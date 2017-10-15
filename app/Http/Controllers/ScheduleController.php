<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\CreateScheduleRequest;
use App\SpecialRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentEmployee = session('CurrentCompany')->employees->where('user_id',Auth::user()->id)->first();
        $employeeSchedules = $currentEmployee->schedule_elements;
        return view('schedule.index',compact('employeeSchedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Retourne la view à mettre ensuite dans le modal
        // Donc l'appeler en javascript => ajax,
        // et la mettre dedans le modal ensuite
        $specialRoles = SpecialRole::where('company_id',session('CurrentCompany')->id)
                                    ->get()
                                    ->pluck('name','id');
        return view('schedule.create',compact('specialRoles'));
    }

    public function createelement()
    {
        // Retourne la view à mettre ensuite dans le modal
        // Donc l'appeler en javascript => ajax,
        // et la mettre dedans le modal ensuite
        $specialRoles = SpecialRole::where('company_id',session('CurrentCompany')->id)
            ->get()
            ->pluck('name','id');
        return view('schedule.createelement',compact('specialRoles'));
    }

    public function getEmployees($specialrole)
    {
        $employees = session('CurrentCompany')->employees;
        $selectedEmployees = [];
        // Go through all special roles
        // of the employees of the company
        // to check if they have the $specialrole
        foreach ($employees as $employee)
            if (count($employee->specialroles->where('id',$specialrole)) > 0)
                array_push($selectedEmployees,$employee->user);

        return response()->json(['employees' => $selectedEmployees]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CreateScheduleRequest
     * @return \Illuminate\Http\Response
     */
    public function store(CreateScheduleRequest $request)
    {
        // Create schedule in database.
        $data = $request->all();

        // Format dates to be inserted in database
        $data['begin'] = Carbon::createFromFormat('Y-d-m H:i:s',$data['begin']);
        $data['end'] = Carbon::createFromFormat('Y-d-m H:i:s',$data['end']);

        $schedule = session('CurrentCompany')->schedules()->create($data);
        // Change return statement
        return response()->json($schedule);
    }

    /**
     * @param  \App\Http\Requests\CreateEventRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeelement(CreateEventRequest $request)
    {
        if ($request->has('user_id')) {
            // Create schedule element with user_id
        } else {
            // Create schedule element without user_id
        }
        // Change return statement
        return response()->json($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $schedule = session('CurrentCompany')->schedules->where('slug',$slug)->first();
        return view('schedule.edit',compact('schedule'));
    }

    public function editing()
    {
        $schedules = session('CurrentCompany')->schedules;
        return view('schedule.editing',compact('schedules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $schedule = session('CurrentCompany')->schedules->where('slug',$slug)->first();
        $schedule->delete();
        return redirect()->action('ScheduleController@index');
    }
}
