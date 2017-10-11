<?php

namespace App\Http\Controllers;

use App\Company;
use App\JobOffer;
use App\JobOfferUser;
use App\Tools\Helper;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class JobOfferUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Carbon::setLocale('fr');
        $jobofferusers = [];
        $jobOffers = JobOffer::where('company_id',session('CurrentCompany')->id)->get();
        foreach ($jobOffers as $joboffer) {
            if ($joboffer->users) {
                foreach ($joboffer->users as $user)
                    array_push($jobofferusers,$user->pivot);
            }
        }
        $jobofferusers = new Paginator($jobofferusers,10,1);
        return view('jobofferuser.index',compact('jobofferusers'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jobofferuser = JobOfferUser::findOrFail($id);//Helper::getJobOfferUserById($id);
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
        $jobofferuser = JobOfferUser::findOrFail($id);
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
        $jobofferuser = JobOfferUser::findOrFail($id);
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
        $jobofferuser = JobOfferUser::findOrFail($id);
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
