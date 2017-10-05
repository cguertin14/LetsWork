<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CreateJobOfferRequest;
use App\Http\Requests\ModifyJobOfferRequest;
use App\JobOffer;
use App\SpecialRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class JobOfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show','lettre']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Carbon::setLocale('fr');
        if (Session::has('CurrentCompany')) {
            //return session('CurrentCompany')->id;
            $jobOffers = JobOffer::where('company_id',session('CurrentCompany')->id)->get();
            $jobOffers = new Paginator($jobOffers,10,1);
        } else {
            $jobOffers = JobOffer::paginate(10);
        }
        //return $jobOffers;
        return view('joboffer.index',compact('jobOffers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specialRoles = SpecialRole::all()
            ->where('company_id',session('CurrentCompany')->id)
            ->pluck('name','id');

        return view('joboffer.create',compact('specialRoles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateJobOfferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateJobOfferRequest $request)
    {
        $data = $request->except(['_token','_method']);
        $data['company_id'] = session('CurrentCompany')->id;
        JobOffer::create($data);
        return redirect('/joboffer');
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $joboffer = JobOffer::findBySlugOrFail($slug);
        return view('joboffer.show',compact('joboffer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $jobOffer = JobOffer::findBySlugOrFail($slug);
        $specialRoles = SpecialRole::all()
            ->where('company_id',session('CurrentCompany')->id)
            ->pluck('name','id');
        return view('joboffer.edit',compact(['jobOffer','specialRoles']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ModifyJobOfferRequest  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(ModifyJobOfferRequest $request, $slug)
    {
        JobOffer::findBySlugOrFail($slug)->update($request->all());
        return redirect('/joboffer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        JobOffer::findBySlugOrFail($slug)->delete();
        return redirect('/joboffer');
    }

    public function apply(Request $request, $slug)
    {
        $joboffer = JobOffer::findBySlugOrFail($slug);
        $data = $request->except(['_token','_method']);
        $data['user_id'] = Auth::user()->id;

        if (Session::has('letter'))
            $joboffer->users()->attach($data,['letter' => session('letter')]);
        else
            $joboffer->users()->attach($data);
        return redirect('/joboffer');
    }

    public function lettre(Request $request)
    {
        //$data = $request->except(['_token']);
        $file = $request->file('file');

        // Encode image to base64
        $filedata = file_get_contents($file);
        $data = base64_encode($filedata);

        // Put data in session for further insertion into database
        session(['letter' => $data]);

        return $data;
    }
}
