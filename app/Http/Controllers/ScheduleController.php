<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\CreateScheduleRequest;
use App\Schedule;
use App\ScheduleElement;
use App\SpecialRole;
use App\Tools\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        $scheduleelement = ScheduleElement::findBySlugOrFail($slug);//Helper::getCurrentSchedule()->scheduleelements()->get()->where('slug',$slug)->first();
        $specialRoles = SpecialRole::where('company_id',session('CurrentCompany')->id)
                                    ->get()
                                    ->pluck('name','id');
        $schedules = session('CurrentCompany')->schedules->pluck('name','id');
        return view('schedule.edit',compact('scheduleelement','specialRoles','schedules'));
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
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);

        $days     = Helper::getWeekDays();
        $data     = Helper::getWeekDaysJson();
        $schedule = Helper::getCurrentSchedule();

        // Get schedule elements
        $scheduleElements = $schedule->scheduleelements()->get();
        // Get elements before today.
        $thisWeekElements = $scheduleElements->where('begin','>=',Carbon::now()->startOfWeek())
                                             ->where('end','<=',Carbon::now()->endOfWeek());
        if (count($thisWeekElements) > 0) {
            // Put data in array.
            $weekEvents = $data->first();
            foreach ($data->first() as $day => $events) {
                // Get le data pour chaque jour et ensuite le mettre dans $weekEvents
                foreach ($thisWeekElements as $element) {
                    if ($element->begin >= Carbon::now()->startOfWeek() && $element->end <= Carbon::now()->endOfWeek()) {
                        if ($days[Carbon::createFromFormat('Y-m-d H:i:s',$element->begin)->dayOfWeek] == $day)
                        {
                            $test = $element->first();
                            $test['begin'] = substr(Carbon::createFromFormat('H:i:s',Carbon::createFromFormat('Y-m-d H:i:s',$test['begin'])->toTimeString())->toTimeString(),0,5);
                            $test['end'] = substr(Carbon::createFromFormat('H:i:s',Carbon::createFromFormat('Y-m-d H:i:s',$test['end'])->toTimeString())->toTimeString(),0,5);
                            array_push($weekEvents[$day], $test);
                        }
                    }
                }
            }
            $data->put('weekevents',$weekEvents);
        }
        // Return data as JSON.
        return response()->json($data);
    }

    /**
     * Get week events of whatever week and return them to the client.
     * @param string $datebegin -> as 'Y-m-d'
     * @return Response
     */
    public function week($datebegin)
    {
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);

        $dateCarbon = Carbon::createFromFormat('Y-m-d',$datebegin);
        $days       = Helper::getWeekDays();
        $data       = Helper::getWeekDaysJson();
        $schedule   = Helper::getCurrentSchedule();

        // Get schedule elements
        $scheduleElements = $schedule->scheduleelements()->get();
        // Get elements before today.
        $weekElements = $scheduleElements->where('begin','>=',$dateCarbon->startOfWeek())
                                         ->where('end'  ,'<=',$dateCarbon->endOfWeek());
        if (count($weekElements) > 0) {
            // Put data in array.
            $weekEvents = $data->first();
            foreach ($data->first() as $day => $events) {
                // Get le data pour chaque jour et ensuite le mettre dans $weekEvents
                foreach ($weekElements as $element) {
                    if ($element->begin >= $dateCarbon->startOfWeek() && $element->end <= $dateCarbon->endOfWeek()) {
                        if ($days[Carbon::createFromFormat('Y-m-d H:i:s',$element->begin)->dayOfWeek] == $day)
                            array_push($weekEvents[$day], $element);
                    }
                }
            }
            $data->put('weekevents',$weekEvents);
        }
        // Return data as JSON.
        return response()->json($data);
    }
}