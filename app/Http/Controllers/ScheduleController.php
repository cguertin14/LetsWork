<?php

namespace App\Http\Controllers;

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
        // (Donc l'appeler en javascript => ajax, et la mettre dedans le modal ensuite)

        $schedules = session('CurrentCompany')->schedules;
        return view('schedule.create',compact('schedules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
