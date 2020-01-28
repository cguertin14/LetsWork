<?php

namespace App\Http\Controllers;

use App\Company;
use App\JobOffer;
use App\JobOfferUser;
use App\Tools\Collection;
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
     * JobOfferUserController constructor.
     */
    public function __construct()
    {
        $this->middleware('highranked');
    }

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
                $jobofferusers = (new Collection($this->getJobOfferUsersSortedByName($sesh['order'])))->reject(function ($item) {
                    return is_null($item);
                })->paginate(10);
            } else if ($sesh['column'] === 'poste') {
                $jobofferusers = (new Collection($this->getJobOfferUsersSortedByPoste($sesh['order'])))->reject(function ($item) {
                    return is_null($item);
                })->paginate(10);
            } else {
                $jobofferusers = (new Collection($this->getJobOfferUsers()))->sortBy($sesh['column'],$sesh['order'] === 'ASC' ? SORT_ASC : SORT_DESC,$sesh['order'] === 'ASC' ? false : true)->reject(function ($item) {
                    return is_null($item);
                })->paginate(10);
            }
        } else {
            $jobofferusers = (new Collection($this->getJobOfferUsers()))->reject(function ($item) {
                return is_null($item);
            })->paginate(10);
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
        $data = ['jobofferuser' => $jobofferuser];

        $employee = $jobofferuser->user->employees()->create();
        $jobofferuser->joboffer->specialrole->employees()->attach($employee);
        $jobofferuser->joboffer->company->employees()->attach($employee);
        $employee->companies()->attach($jobofferuser->joboffer->company);

        $jobofferuser->accepted = 1;
        $jobofferuser->save();
        //$jobofferuser->delete();

        // Send email then update entry in database
        try {
            Mail::send('jobofferuser.accept', $data,function ($message) use ($jobofferuser) {
                $message->from('support@letswork.guijethostingtools.com',$jobofferuser->joboffer->company->name);
                $message->to($jobofferuser->user->email,$jobofferuser->user->name)
                        ->subject($jobofferuser->joboffer->specialrole->name);
            });
        } catch (ClientException $e) {}

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
        $data = ['jobofferuser' => $jobofferuser];

        // Send email then delete entry in database
        try {
            Mail::send('jobofferuser.refuse', $data,function ($message) use ($jobofferuser) {
                $message->from('support@letswork.guijethostingtools.com',$jobofferuser->joboffer->company->name);
                $message->to($jobofferuser->user->email,$jobofferuser->user->name)
                        ->subject($jobofferuser->joboffer->specialrole->name);
            });
        } catch (ClientException $e) {}

        $jobofferuser->delete();

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
        $data = ['jobofferuser' => $jobofferuser];

        $jobofferuser->interview = 1;
        $jobofferuser->save();

        // Send email then update entry in database
        try {
            Mail::send('jobofferuser.interview', $data,function ($message) use ($jobofferuser) {
                $message->from('support@letswork.guijethostingtools.com',$jobofferuser->joboffer->company->name);
                $message->to($jobofferuser->user->email,$jobofferuser->user->name)
                        ->subject($jobofferuser->joboffer->specialrole->name);
            });
        } catch (ClientException $e) {}

        return redirect('/jobofferuser');
    }
}
