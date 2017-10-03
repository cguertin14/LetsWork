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

class DispoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dispos=Helper::CAvailability()->get(0)->availabilityelements;
        return view("dispo.index",compact('dispos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CreateDispoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dispo.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
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

        $company = Helper::CCompany();
        $employee = Helper::CEmployee();
        $availabilitys = Helper::CAvailability();
        if ($availabilitys->count() <= 0) {
            $availability = $employee->availabilitie()->create([
                'company_id' => $company->id
            ]);
        } else {
            $availability = $availabilitys->get(0);
        }
        $availability->availabilityelements()->create($request->except('_token'));
        return $this->index();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
