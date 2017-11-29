<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CreateJobOfferRequest;
use App\Http\Requests\ModifyJobOfferRequest;
use App\JobOffer;
use App\SpecialRole;
use App\Tools\Collection;
use App\Tools\Helper;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use \Yajra\DataTables\Facades\DataTables;

class JobOfferController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('highranked',['only' => ['create','edit','update','store','destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Carbon::setLocale('fr');
        if (self::CCompany() != null) {
            if (Session::has('sortJobOffers')) {
                $sesh = session('sortJobOffers');
                //return $sesh;
                if ($sesh['column'] === 'companyName') {
                    $jobOffers = self::CCompany()->joboffers()->join('companies','job_offers.company_id','=','companies.id')
                                                              ->orderBy('companies.ville',$sesh['order'])
                                                              ->select('job_offers.*')
                                                              ->paginate(10);
                } else if ($sesh['column'] === 'companyCity') {
                    $jobOffers = self::CCompany()->joboffers()->join('companies','job_offers.company_id','=','companies.id')
                                                              ->orderBy('companies.ville',$sesh['order'])
                                                              ->select('job_offers.*')
                                                              ->paginate(10);
                } else if (strpos($sesh['column'],'cities') !== false) {
                    if (strpos($sesh['column'],'companyName') !== false) {
                        $jobOffers = self::CCompany()->joboffers()->join('companies','job_offers.company_id','=','companies.id')
                                                                  ->whereIn('ville',$sesh['cities'])
                                                                  ->orderBy('companies.name',$sesh['order'])
                                                                  ->select('job_offers.*')
                                                                  ->paginate(10);
                    } else if (strpos($sesh['column'],'companyCity') !== false) {
                        $jobOffers = self::CCompany()->joboffers()->join('companies','job_offers.company_id','=','companies.id')
                                                                  ->whereIn('ville',$sesh['cities'])
                                                                  ->orderBy('companies.ville',$sesh['order'])
                                                                  ->select('job_offers.*')
                                                                  ->paginate(10);
                    } else if (strpos($sesh['column'],'name') !== false) {
                        $jobOffers = self::CCompany()->joboffers()->orderBy('name',$sesh['order'])
                                                                  ->join('companies','job_offers.company_id','=','companies.id')
                                                                  ->whereIn('ville',$sesh['cities'])
                                                                  ->select('job_offers.*')
                                                                  ->paginate(10);
                    } else if (strpos($sesh['column'],'created_at') !== false) {
                        $jobOffers = self::CCompany()->joboffers()->join('companies','job_offers.company_id','=','companies.id')
                                                                  ->whereIn('ville',$sesh['cities'])
                                                                  ->orderBy('job_offers.created_at',$sesh['order'])
                                                                  ->select('job_offers.*')
                                                                  ->paginate(10);
                    } else {
                        $jobOffers = self::CCompany()->joboffers()->join('companies','job_offers.company_id','=','companies.id')
                                                                  ->whereIn('ville',$sesh['cities'])
                                                                  ->select('job_offers.*')
                                                                  ->paginate(10);
                    }
                } else if (strpos($sesh['column'],'names') !== false) {
                    if (strpos($sesh['column'],'companyName') !== false) {
                        $jobOffers = self::CCompany()->joboffers()->join('companies','job_offers.company_id','=','companies.id')
                                                                  ->whereIn('companies.name',$sesh['names'])
                                                                  ->orderBy('companies.name',$sesh['order'])
                                                                  ->select('job_offers.*')
                                                                  ->paginate(10);
                    } else if (strpos($sesh['column'],'companyCity') !== false) {
                        $jobOffers = self::CCompany()->joboffers()->join('companies','job_offers.company_id','=','companies.id')
                                                                  ->whereIn('companies.name',$sesh['names'])
                                                                  ->orderBy('companies.ville',$sesh['order'])
                                                                  ->select('job_offers.*')
                                                                  ->paginate(10);
                    } else if ($sesh['column'] === 'names,name') {
                        $jobOffers = self::CCompany()->joboffers()->orderBy('name',$sesh['order'])
                                                                  ->join('companies','job_offers.company_id','=','companies.id')
                                                                  ->whereIn('companies.name',$sesh['names'])
                                                                  ->select('job_offers.*')
                                                                  ->paginate(10);
                    } else if (strpos($sesh['column'],'created_at') !== false) {
                        $jobOffers = self::CCompany()->joboffers()->join('companies','job_offers.company_id','=','companies.id')
                                                                  ->whereIn('companies.name',$sesh['names'])
                                                                  ->orderBy('job_offers.created_at',$sesh['order'])
                                                                  ->select('job_offers.*')
                                                                  ->paginate(10);
                    } else {
                        $jobOffers = self::CCompany()->joboffers()->join('companies','job_offers.company_id','=','companies.id')
                                                                  ->whereIn('companies.name',$sesh['names'])
                                                                  ->select('job_offers.*')
                                                                  ->paginate(10);
                    }
                    //return $sesh;
                } else {
                    $jobOffers = self::CCompany()->joboffers()->orderBy($sesh['column'],$sesh['order'])->paginate(10);
                }
            } else {
                $jobOffers = self::CCompany()->joboffers()->paginate(10);
                $sesh = [];
            }
            $cities = self::CCompany()->joboffers()->join('companies','job_offers.company_id','=','companies.id')->pluck('companies.ville','companies.ville');
            $names  = self::CCompany()->joboffers()->join('companies','job_offers.company_id','=','companies.id')->pluck('companies.name','companies.name');
        } else {
            if (Session::has('sortJobOffers')) {
                $sesh = session('sortJobOffers');
                if ($sesh['column'] === 'companyName') {
                    $jobOffers = JobOffer::join('companies','job_offers.company_id','=','companies.id')
                                           ->orderBy('companies.name',$sesh['order'])
                                           ->select('job_offers.*')
                                           ->paginate(10);
                } else if ($sesh['column'] === 'companyCity') {
                    $jobOffers = JobOffer::join('companies','job_offers.company_id','=','companies.id')
                                           ->orderBy('companies.ville',$sesh['order'])
                                           ->select('job_offers.*')
                                           ->paginate(10);
                } else if (strpos($sesh['column'],'cities') !== false) {
                    if (strpos($sesh['column'],'companyName') !== false) {
                        $jobOffers = JobOffer::join('companies','job_offers.company_id','=','companies.id')
                                                ->whereIn('ville',$sesh['cities'])
                                                ->orderBy('companies.name',$sesh['order'])
                                                ->select('job_offers.*')
                                                ->paginate(10);
                    } else if (strpos($sesh['column'],'companyCity') !== false) {
                        $jobOffers = JobOffer::join('companies','job_offers.company_id','=','companies.id')
                                                ->whereIn('ville',$sesh['cities'])
                                                ->orderBy('companies.ville',$sesh['order'])
                                                ->select('job_offers.*')
                                                ->paginate(10);
                    } else if (strpos($sesh['column'],'name') !== false) {
                        $jobOffers = JobOffer::join('companies','job_offers.company_id','=','companies.id')
                                                ->whereIn('ville',$sesh['cities'])
                                                ->orderBy('companies.name',$sesh['order'])
                                                ->select('job_offers.*')
                                                ->paginate(10);
                    } else if (strpos($sesh['column'],'created_at') !== false) {
                        $jobOffers = JobOffer::join('companies','job_offers.company_id','=','companies.id')
                                                ->whereIn('ville',$sesh['cities'])
                                                ->orderBy('job_offers.created_at',$sesh['order'])
                                                ->select('job_offers.*')
                                                ->paginate(10);
                    } else {
                        $jobOffers = JobOffer::join('companies','job_offers.company_id','=','companies.id')
                                                ->whereIn('ville',$sesh['cities'])
                                                ->select('job_offers.*')
                                                ->paginate(10);
                    }
                } else if (strpos($sesh['column'],'names') !== false) {
                    if (strpos($sesh['column'],'companyName') !== false) {
                        $jobOffers = JobOffer::join('companies','job_offers.company_id','=','companies.id')
                                                ->whereIn('companies.name',$sesh['names'])
                                                ->orderBy('companies.name',$sesh['order'])
                                                ->select('job_offers.*')
                                                ->paginate(10);
                    } else if (strpos($sesh['column'],'companyCity') !== false) {
                        $jobOffers = JobOffer::join('companies','job_offers.company_id','=','companies.id')
                                                ->whereIn('companies.name',$sesh['names'])
                                                ->orderBy('companies.ville',$sesh['order'])
                                                ->select('job_offers.*')
                                                ->paginate(10);
                    } else if ($sesh['column'] === 'names,name') {
                        $jobOffers = JobOffer::orderBy('name',$sesh['order'])
                                                ->join('companies','job_offers.company_id','=','companies.id')
                                                ->whereIn('companies.name',$sesh['names'])
                                                ->select('job_offers.*')
                                                ->paginate(10);
                    } else if (strpos($sesh['column'],'created_at') !== false) {
                        $jobOffers = JobOffer::join('companies','job_offers.company_id','=','companies.id')
                                                ->whereIn('companies.name',$sesh['names'])
                                                ->orderBy('job_offers.created_at',$sesh['order'])
                                                ->select('job_offers.*')
                                                ->paginate(10);
                    } else {
                        $jobOffers = JobOffer::join('companies','job_offers.company_id','=','companies.id')
                                                ->whereIn('companies.name',$sesh['names'])
                                                ->select('job_offers.*')
                                                ->paginate(10);
                    }
                } else {
                    $jobOffers = JobOffer::orderBy($sesh['column'], $sesh['order'])->paginate(10);
                }
            } else {
                $jobOffers = JobOffer::paginate(10);
                $sesh = [];
            }
            $cities = JobOffer::join('companies','job_offers.company_id','=','companies.id')->pluck('companies.ville','companies.ville');
            $names  = JobOffer::join('companies','job_offers.company_id','=','companies.id')->pluck('companies.name','companies.name');
        }
        return view('joboffer.index',compact('jobOffers','sesh','cities','names'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sort(Request $request)
    {
        $sesh = session('sortJobOffers');
        if ($sesh != null) {
            $sesh = new Collection($sesh);
            if ($sesh->has('citiesSorted') || $sesh->has('namesSorted')) {
                if ($request->has('cities') || $request->has('names')) {
                    $this->sortNormal($request);
                } else {
                    if (strpos($sesh->get('column'),'cities') !== false) {
                        if (strpos($sesh->get('column'),$request->get('column')) === false)
                            $sesh->put('column','cities' . ',' . $request->get('column'));
                    } else if (strpos($sesh->get('column'),'names') !== false) {
                        if ($request->get('column') === 'name') {
                            if ($sesh->get('column') !== 'names,name') {
                                $sesh->put('column','names' . ',' . $request->get('column'));
                            }
                        } else {
                            if (strpos($sesh->get('column'),$request->get('column')) === false)
                                $sesh->put('column','names' . ',' . $request->get('column'));
                        }
                    }
                    $sesh->put('order',$request->get('order'));
                    session(['sortJobOffers' => $sesh->toArray()]);
                }
            } else {
                $this->sortNormal($request);
            }
        } else {
            $this->sortNormal($request);
        }
        return redirect()->action('JobOfferController@index');
    }

    /**
     * @param Request $request
     */
    public function sortNormal(Request $request)
    {
        $data = $request->all();
        if ( ! $request->has('column') || ! $request->has('order') ) {
            if ($request->has('cities')) {
                $data['column'] = 'cities';
                $data['citiesSorted'] = new Collection();
                foreach ($data['cities'] as $city) $data['citiesSorted'][$city] = $city;
            } else if ($request->has('names')) {
                $data['column'] = 'names';
                $data['namesSorted'] = new Collection();
                foreach ($data['names'] as $name) $data['namesSorted'][$name] = $name;
            }
        }
        session(['sortJobOffers' => $data]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsort()
    {
        if (Session::has('sortJobOffers')) {
            session()->forget('sortJobOffers');
        }
        return redirect()->action('JobOfferController@index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specialRoles = self::CCompany()->specialroles()->pluck('name','id');
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
        $data['company_id'] = $this->CCompany()->id;
        JobOffer::create($data);
        return redirect()->action('JobOfferController@index');
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
        $specialRoles = self::CCompany()->specialroles()->pluck('name','id');
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
        return redirect()->action('JobOfferController@index');
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
        return redirect()->action('JobOfferController@index');
    }

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function apply(Request $request, $slug)
    {
        $joboffer = JobOffer::findBySlugOrFail($slug);
        $data = $request->except(['_token','_method']);
        $data['user_id'] = Auth::user()->id;

        if (Session::has('letter'))
            $joboffer->users()->attach($data,['letter' => session('letter')]);
        else
            $joboffer->users()->attach($data);
        return redirect()->action('JobOfferController@index');
    }

    /**
     * @param Request $request
     * @return string
     */
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
