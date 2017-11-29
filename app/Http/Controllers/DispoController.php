<?php

namespace App\Http\Controllers;

use App\Availability;
use App\Http\Requests\CreateDispoRequest;
use App\User;
use App\Company;
use App\AvailabilityElement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Tools\Helper;
use Illuminate\Support\Facades\Session;

class DispoController extends BaseController
{
    /**
     * DispoController constructor.
     */
    public function __construct()
    {
        $this->middleware('employee');
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
        if (Session::has('sortDispo')) {
            // Sort data...
            $sesh = session('sortDispo');
            $dispos = self::CAvailability()->first()->availabilityelements()->orderBy($sesh['column'],$sesh['order'])->paginate(10);
        } else {
            if (self::CAvailability()->count() <= 0) {
                $dispos = [];
            } else {
                $dispos = self::CAvailability()->first()->availabilityelements()->paginate(10);
            }
            $sesh = [];
        }
        return view("dispo.index", compact('dispos','sesh'));
    }

    public function sort(Request $request)
    {
        session(['sortDispo' => $request->all()]);
        return redirect()->action('DispoController@index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view("dispo.create");
    }

    /**
     * @param CreateDispoRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(CreateDispoRequest $request)
    {
        $data = $request->except('_token');
        $datebegin = Carbon::createFromFormat('Y-m-d H:i:s', $data['begin']);
        $dateend = Carbon::createFromFormat('Y-m-d H:i:s', $data['end']);

        if ($datebegin->gt($dateend) || $datebegin->eq($dateend)) {
            session()->flash('errorDispo', 'La date de début doit être inférieure à la date de fin!');
            return redirect()->back();
        }

        $company = self::CCompany();
        $employee = self::CEmployee();
        $availabilitys = self::CAvailability();
        if ($availabilitys->count() <= 0) {
            $availability = $employee->availabilities()->create([
                'company_id' => $company->id
            ]);
        } else {
            $availability = $availabilitys->get(0);
        }
        $availability->availabilityelements()->create($request->except('_token'));
        return redirect()->action('DispoController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AvailabilityElement::destroy($id);
        return redirect()->action('DispoController@index');
    }
}
