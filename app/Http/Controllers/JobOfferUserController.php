<?php

namespace App\Http\Controllers;

use App\Company;
use App\JobOffer;
use App\JobOfferUser;
use App\Tools\Helper;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;

class JobOfferUserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (self::CCompany() == null)
            return redirect('/');
        Carbon::setLocale('fr');
        if (Session::has('sortJobOfferUsers')) {
            $sesh = session('sortJobOfferUsers');
            if ($sesh['column'] === 'fullname') {
                // Sort data...
                $jobofferusers = DB::table('job_offer_user')->paginate(10); ////// To continue...
            } else if ($sesh['column'] === 'poste') {
                // Sort data...
                $jobofferusers = $this->getJobOfferUsers()->orderBy($sesh['column'],$sesh['order'])->paginate(10);
            } else {
                $jobofferusers = $this->getJobOfferUsers()->orderBy($sesh['column'],$sesh['order'])->paginate(10);
            }
        } else {
            $jobofferusers = $this->getJobOfferUsers()->paginate(10);
            $sesh = [];
        }
        return view('jobofferuser.index',compact('jobofferusers','sesh'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sort(Request $request)
    {
        session(['sortJobOfferUsers' => $request->all()]);
        return redirect()->action('JobOfferUserController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jobofferuser = $this->getJobOfferUserById($id);
        return view('jobofferuser.show',compact('jobofferuser'));
    }

    /**
     * * Accept the user (send email to say he/she is refused)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function accept($id)
    {
        $jobofferuser = $this->getJobOfferUserById($id);
        session(['jobofferuser' => $jobofferuser]);
        $data = ['jobofferuser' => $jobofferuser];

        $employee = $jobofferuser->user->employees()->create(['user_id' => $jobofferuser->user->id]);
        $employee->companies()->attach($jobofferuser->joboffer->company);

        // Send email then update entry in database
        try {
            Mail::send('jobofferuser.accept', $data,function ($message){
                $message->from('support@letswork.dev',session('jobofferuser')->joboffer->company->name);
                $message->to(session('jobofferuser')->user->email,session('jobofferuser')->user->name)
                        ->subject(session('jobofferuser')->joboffer->specialrole->name);
            });
        } catch (ClientException $e) {}

        session()->forget('jobofferuser');
        return redirect('/jobofferuser');
    }

    /**
     * Refuse the user (send email to say he/she is refused)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function refuse($id)
    {
        $jobofferuser = $this->getJobOfferUserById($id);
        session(['jobofferuser' => $jobofferuser]);
        $data = ['jobofferuser' => $jobofferuser];

        // Send email then delete entry in database
        try {
            Mail::send('jobofferuser.refuse', $data,function ($message){
                $message->from('support@letswork.dev',session('jobofferuser')->joboffer->company->name);
                $message->to(session('jobofferuser')->user->email,session('jobofferuser')->user->name)
                        ->subject(session('jobofferuser')->joboffer->specialrole->name);
            });
        } catch (ClientException $e) {}

        $jobofferuser->delete();

        session()->forget('jobofferuser');
        return redirect('/jobofferuser');
    }

    /**
     * Give interview to user (send email to say he/she is refused)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function interview($id)
    {
        $jobofferuser = $this->getJobOfferUserById($id);
        session(['jobofferuser' => $jobofferuser]);
        $data = ['jobofferuser' => $jobofferuser];

        $jobofferuser->interview = 1;
        $jobofferuser->save();

        // Send email then update entry in database
        try {
            Mail::send('jobofferuser.interview', $data,function ($message){
                $message->from('support@letswork.dev',session('jobofferuser')->joboffer->company->name);
                $message->to(session('jobofferuser')->user->email,session('jobofferuser')->user->name)
                        ->subject(session('jobofferuser')->joboffer->specialrole->name);
            });
        } catch (ClientException $e) {}

        session()->forget('jobofferuser');
        return redirect('/jobofferuser');
    }
}
