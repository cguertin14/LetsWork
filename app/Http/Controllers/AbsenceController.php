<?php

namespace App\Http\Controllers;

use App\Absence;
use App\Company;
use App\Employee;
use App\Http\Requests\CreateAbsenceRequest;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidDateException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Session::has('CurrentCompany')) {
            $company = Company::findBySlugOrFail(session('CurrentCompany'));
            return view('absence.create', compact('company'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAbsenceRequest $request)
    {
        $data = $request->except('_token');
        $employees = [];

        foreach(Auth::user()->companies as $company)
            array_push($employees,$company->employees);
        foreach($employees as $employee)
            if ($employee->get(0)->user_id == Auth::user()->id)
                $data['employee_id'] = $employee->get(0)->id;

        $datebegin = Carbon::createFromFormat('Y-m-d H:i:s',$data['begin']);
        $dateend = Carbon::createFromFormat('Y-m-d H:i:s',$data['end']);

        if ($datebegin->gt($dateend) || $datebegin->eq($dateend)) {
            session()->flash('errorAbsence','La date de début doit être inférieure à la date de fin!');
            return redirect()->back();
        }

        $data['begin'] = $datebegin->toDateTimeString();
        $data['end'] = $dateend->toDateTimeString();
        Absence::create($data);

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
