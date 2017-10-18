<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\CreateScheduleRequest;
use App\Schedule;
use App\SpecialRole;
use App\Tools\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function MongoDB\BSON\toJSON;

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
        $schedules = session('CurrentCompany')->schedules->pluck('name','id');
        return view('schedule.createelement',compact('specialRoles','schedules'));
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
        // Format dates to be inserted in database
        $data = $request->all();
        $data['begin'] = Carbon::createFromFormat('Y-d-m H:i:s',$data['begin']);
        $data['end'] = Carbon::createFromFormat('Y-d-m H:i:s',$data['end']);

        // Create schedule element in database, link with selected schedule
        $scheduleElement = Schedule::findOrFail($data['schedule_id'])->scheduleelements()->create($data);
        // Attach schedule element with special role
        $scheduleElement->specialroles()->attach($data['special_role_id']);

        if ($request->has('user_id')) {
            // Attach schedule element with user_id
            $scheduleElement->employees()->attach(session('CurrentCompany')->employees->where('user_id',$data['user_id'])->first()->id);
        }
        // Return the scheduleElement
        return response()->json($scheduleElement);
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
        // Modify this request ...
        $schedule = session('CurrentCompany')->schedules->where('slug',$slug)->first();
        return view('schedule.edit',compact('schedule'));
    }

    public function editing()
    {
        $schedules = session('CurrentCompany')->schedules->pluck('name','slug');
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
        session('CurrentCompany')->schedules->where('slug',$slug)->first()->delete();
        return redirect()->action('ScheduleController@index');
    }

    /**
     *  Get schedule elements from this week's schedule
     *  and return them as JSON to the client.
     *  @return \Illuminate\Http\Response
     */
    public function thisweek()
    {
        $days     = Helper::getWeekDays();
        $data     = Helper::getWeekDaysJson();
        $schedule = Helper::getCurrentSchedule();

        // Get schedule elements
        $scheduleElements = $schedule->scheduleelements()->get();
        // Get elements before today.
        $thisWeekElements = $scheduleElements->where('begin','<=',Carbon::today())
                                             ->where('end','>=',Carbon::today())
                                             ->groupBy('begin');
        if (count($thisWeekElements) > 0) {
            //$thisWeekElements->orderBy('begin');
            // Put data in array.
            $weekEvents = $data->first();
            foreach ($data->first() as $day => $events) {
                // Get le data pour chaque jour et ensuite le mettre dans $weekEvents
                foreach ($thisWeekElements as $element) {
                    if ($days[$element->begin->dayOfWeek] == $day)
                        array_push($weekEvents[$day], $element /*[
                    'begin' => '12:00',
                    'end' => '13:00',
                    'name' => 'nom d\'événement',
                    'description' => 'description d\'événement',
                ]*/);
                }
            }
            $data->put('weekdays',$weekEvents);
        }
        // Return data as JSON.
        return response()->json($data);
    }
}