<?php

namespace App\Http\Controllers;

use App\Company;
use App\JobOffer;
use App\JobOfferUser;
use App\Tools\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Mail;

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
        $jobOffers = JobOffer::where('company_id',Company::findBySlugOrFail(session('CurrentCompany'))->id)->get();
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
        $jobofferuser = Helper::getJobOfferUserById($id);
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
        $jobofferuser = Helper::getJobOfferUserById($id);
        session(['jobofferuser' => $jobofferuser]);
        $data = [
            'jobofferuser' => $jobofferuser
        ];
        // Send email then update entry in database

        Mail::send('jobofferuser.accept', $data,function ($message){
            $message->from(session('jobofferuser')->joboffer->company->email,session('jobofferuser')->joboffer->company->name);
            $message->to(session('jobofferuser')->user->email,session('jobofferuser')->user->name)
                    ->subject(session('jobofferuser')->joboffer->specialrole->name);
        });

        session()->forget('jobofferuser');
        session()->flush();

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
        $jobofferuser = Helper::getJobOfferUserById($id);
        session(['jobofferuser' => $jobofferuser]);
        $data = [
            'jobofferuser' => $jobofferuser
        ];
        // Send email then update entry in database

        Mail::send('jobofferuser.refuse', $data,function ($message){
            $message->from(session('jobofferuser')->joboffer->company->email,session('jobofferuser')->joboffer->company->name);
            $message->to(session('jobofferuser')->user->email,session('jobofferuser')->user->name)
                    ->subject(session('jobofferuser')->joboffer->specialrole->name);
        });

        session()->forget('jobofferuser');
        session()->flush();

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
        $jobofferuser = Helper::getJobOfferUserById($id);
        session(['jobofferuser' => $jobofferuser]);
        $data = [
            'jobofferuser' => $jobofferuser
        ];
        // Send email then update entry in database
        Mail::send('jobofferuser.interview', $data,function ($message){
            $message->from(session('jobofferuser')->joboffer->company->email,session('jobofferuser')->joboffer->company->name);
            $message->to(session('jobofferuser')->user->email,session('jobofferuser')->user->name)
                    ->subject(session('jobofferuser')->joboffer->specialrole->name);
        });

        $jobofferuser->update(['interview' => 1]);

        session()->forget('jobofferuser');
        session()->flush();

        return redirect('/jobofferuser');
    }
}
