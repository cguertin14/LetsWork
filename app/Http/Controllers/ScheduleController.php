<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\CreateScheduleRequest;
use App\Schedule;
use App\ScheduleElement;
use App\SpecialRole;
use App\Tools\Helper;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use function MongoDB\BSON\toJSON;

class ScheduleController extends BaseController
{
    /**
     * ScheduleController constructor.
     */
    public function __construct()
    {
        $this->middleware('employee');
        $this->middleware('highranked',['only' => ['editing','create','createelement','storeelement','store','destroy','edit']]);
    }

    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (self::CCompany() == null)
            return redirect('/');
        $currentEmployee = self::CCompany()->employees()->where('user_id',Auth::user()->id)->first();
        $employeeSchedules = $currentEmployee->schedule_elements;
        return view('schedule.index',compact('employeeSchedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function create()
    {
        // Retourne la view à mettre ensuite dans le modal
        // Donc l'appeler en javascript => ajax,
        // et la mettre dedans le modal ensuite
        $specialRoles = self::CCompany()->specialroles()->pluck('name','id');
        return view('schedule.create',compact('specialRoles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function createelement()

    {
        // Retourne la view à mettre ensuite dans le modal
        // Donc l'appeler en javascript => ajax,
        // et la mettre dedans le modal ensuite
        $specialRoles = self::CCompany()->specialroles()->pluck('name','id');
        $schedules    = self::CCompany()->schedules()->pluck('name','id');
        return view('schedule.createelement',compact('specialRoles','schedules'));
    }

    /**
     * @param $specialroles
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployees($specialroles)
    {
        $employees = self::CCompany()->employees()->get();
        $selectedEmployees = [];
        // Go through all special roles
        // of the employees of the company
        // to check if they have the $specialroles
        foreach ($employees as $employee)
        {
            if (strpos($specialroles,',') !== false) {
                foreach (explode(',',$specialroles) as $specialrole)
                    if (count($employee->specialroles()->where('id',$specialrole)) > 0)
                        array_push($selectedEmployees,$employee->user);
            } else {
                if (count($employee->specialroles()->where('id',$specialroles)) > 0)
                    array_push($selectedEmployees,$employee->user);
            }
        }
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

        $schedule = self::CCompany()->schedules()->create($data);
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
        foreach ($request->specialroles as $specialrole)
            $scheduleElement->specialroles()->attach($specialrole);

        if ($request->has('users')) {
            // Attach schedule element with user_id
            foreach ($request->users as $user)
                $scheduleElement->employees()->attach(self::CCompany()->employees()->where('user_id',$user)->first()->id);
        }
        // Return the scheduleElement
        return response()->json($scheduleElement);
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @param  string  $slug
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function edit($slug)
    {
        $scheduleelement    = ScheduleElement::findBySlugOrFail($slug);
        $specialRoles       = self::CCompany()->specialroles()->pluck('name','id');
        $schedules          = self::CCompany()->schedules()->pluck('name','id');
        $companyEmployees   = self::CCompany()->employees()->get();
        $availableEmployees = [];

        $employees = $scheduleelement->employees()->get()->map(function (Employee $employee) {
            return $employee->user;
        });

        foreach ($companyEmployees as $employee)
            foreach ($scheduleelement->specialroles()->get() as $specialrole)
                if (count($employee->specialroles()->get()->find($specialrole->id)) > 0)
                    array_push($availableEmployees,$employee->user);

        $employees = $employees->pluck('id');
        $availableEmployees = collect($availableEmployees)->pluck('name','id');

        return view('schedule.edit',compact('scheduleelement','specialRoles','schedules','employees','availableEmployees'));
    }


    /**
     * Return the editing view to allow the manager to change its schedule.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editing()
    {
        if (self::CCompany() === null) return redirect('/');
        $schedules = self::CCompany()->schedules()->pluck('name','slug');
        return view('schedule.editing',compact('schedules'));
    }

    //<editor-fold desc="Update Schedule Element">
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        // Add code to update the specified schedule element
        $data = $request->except(['_token','_method','skills','roles']);
        $scheduleElement = ScheduleElement::findBySlugOrFail($slug);

        // Detach first
        $this->detachSpecialRoles($request,$scheduleElement);
        if ($request->has('users'))
            $this->detachEmployees($request,$scheduleElement);

        // Attach after
        $this->attachSpecialRoles($request,$scheduleElement);
        if ($request->has('users'))
            $this->attachEmployees($request,$scheduleElement);

        $scheduleElement->update($data);

        return response()->json(['status' => 'Updated!']);
    }

    /**
     * @param Request $request
     * @param ScheduleElement $scheduleelement
     */
    public function attachSpecialRoles(Request $request,ScheduleElement $scheduleelement)
    {
        $specialroles = [];
        $realspecialroles = [];

        foreach ($request->specialroles as $skillID)
            array_push($specialroles,SpecialRole::findOrFail($skillID));
        foreach ($scheduleelement->specialroles as $specialrole)
            array_push($realspecialroles,SpecialRole::findOrFail($specialrole->id));

        $specialrolestoattach = array_diff($specialroles,$realspecialroles);

        foreach ($specialrolestoattach as $specialroletoattach)
            $scheduleelement->specialroles()->attach($specialroletoattach);
    }

    /**
     * @param Request $request
     * @param ScheduleElement $scheduleelement
     */
    public function attachEmployees(Request $request,ScheduleElement $scheduleelement)
    {
        $employees = [];
        $realEmployees = [];

        foreach ($request->users as $userID)
            array_push($employees,Employee::where('user_id',$userID)->first());
        foreach ($scheduleelement->employees as $employee)
            array_push($realEmployees,Employee::findOrFail($employee->id));

        $employeesToAttach = array_diff($employees,$realEmployees);

        foreach ($employeesToAttach as $specialroletoattach)
            $scheduleelement->employees()->attach($specialroletoattach);
    }

    /**
     * @param Request $request
     * @param ScheduleElement $scheduleelement
     */
    public function detachSpecialRoles(Request $request,ScheduleElement $scheduleelement)
    {
        $specialroles = [];
        $realSpecialRoles = [];

        foreach ($request->specialroles as $specialrole)
            array_push($specialroles,SpecialRole::findOrFail($specialrole));
        foreach ($scheduleelement->specialroles as $specialrole)
            array_push($realSpecialRoles,SpecialRole::findOrFail($specialrole->id));

        $specialRolesToDetach = array_diff($realSpecialRoles,$specialroles);

        if (!empty($specialRolesToDetach))
            foreach ($specialRolesToDetach as $skillToDetach)
                $scheduleelement->specialroles()->detach($skillToDetach);
    }

    /**
     * @param Request $request
     * @param ScheduleElement $scheduleelement
     */
    public function detachEmployees(Request $request,ScheduleElement $scheduleelement)
    {
        $employees = [];
        $realEmployees = [];

        foreach ($request->users as $userID)
            array_push($employees,Employee::where('user_id',$userID)->first());
        foreach ($scheduleelement->employees()->get() as $employee)
            array_push($realEmployees,Employee::findOrFail($employee->id));

        $employeesToAttach = array_diff($employees,$realEmployees);

        if (!empty($employeesToAttach))
            foreach ($employeesToAttach as $employeeToAttach)
                $scheduleelement->employees()->detach($employeeToAttach);
    }
    //</editor-fold>

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        //session('CurrentCompany')->schedules->where('slug',$slug)->first()->delete();
        ScheduleElement::findBySlugOrFail($slug)->delete();
        return response()->json(['status' => 'Deleted!']);
    }

    //<editor-fold desc="Get Schedule elements in JSON Structure">
    /**
     * Get week events of whatever week and return them to the client.
     * @param string $datebegin -> as 'Y-m-d'
     * @return Response
     */

    public function week($datebegin)
    {
        //return self::hasLastPunch() ? 'true' : 'false';
        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);

        $dateCarbon = Carbon::createFromFormat('Y-m-d',$datebegin);
        $days       = $this->getDays();
        $data       = $this->getWeekDaysJson();
        $schedule   = $this->getCurrentSchedule();

        if ($schedule == null)
            return response()->json(null);

        // Get schedule elements from this week
        $weekElements = $schedule->scheduleelements()
                                 ->whereBetween('begin',[$dateCarbon->startOfWeek()->toDateTimeString(),$dateCarbon->endOfWeek()->toDateTimeString()])
                                 ->get();

        if (count($weekElements) > 0) {
            // Put data in array.
            $weekEvents = $data->first();
            foreach ($data->first() as $day => $events) {
                // Get le data pour chaque jour et ensuite le mettre dans $weekEvents
                foreach ($weekElements as $element) {
                    if ($days[Carbon::parse($element->begin)->dayOfWeek] == $day) {
                        $test = $element;
                        if (Carbon::createFromFormat('Y-m-d H:i:s',$test['end'])->toTimeString() == '00:00:00'){ // OU BEGIN
                            $test['begin'] = Carbon::createFromFormat('Y-m-d H:i:s',$test['begin'])->addDay(1);
                            if(Carbon::createFromFormat('Y-m-d H:i:s',$test['end'])->day != Carbon::createFromFormat('Y-m-d H:i:s',$test['begin'])->day) {
                                $test['begin'] = substr(Carbon::createFromFormat('H:i:s',Carbon::createFromFormat('Y-m-d H:i:s',$test['begin'])->toTimeString())->toTimeString(),0,5);
                                $test['end'] = substr(Carbon::createFromFormat('Y-m-d H:i:s',Carbon::createFromFormat('Y-m-d H:i:s',$test['end'])->toDateTimeString())->toDateTimeString(),0,16);
                            } else {
                                $test['begin'] = substr(Carbon::createFromFormat('H:i:s',Carbon::createFromFormat('Y-m-d H:i:s',$test['begin'])->toTimeString())->toTimeString(),0,5);
                                $test['end'] = substr(Carbon::createFromFormat('H:i:s',Carbon::createFromFormat('Y-m-d H:i:s',$test['end'])->toTimeString())->toTimeString(),0,5);
                            }
                        } else {
                            if(Carbon::createFromFormat('Y-m-d H:i:s',$test['end'])->day != Carbon::createFromFormat('Y-m-d H:i:s',$test['begin'])->day) {
                                $test['begin'] = substr(Carbon::createFromFormat('H:i:s',Carbon::createFromFormat('Y-m-d H:i:s',$test['begin'])->toTimeString())->toTimeString(),0,5);
                                $test['end'] = substr(Carbon::createFromFormat('Y-m-d H:i:s',Carbon::createFromFormat('Y-m-d H:i:s',$test['end'])->toDateTimeString())->toDateTimeString(),0,16);
                            } else {
                                $test['begin'] = substr(Carbon::createFromFormat('H:i:s',Carbon::createFromFormat('Y-m-d H:i:s',$test['begin'])->toTimeString())->toTimeString(),0,5);
                                $test['end'] = substr(Carbon::createFromFormat('H:i:s',Carbon::createFromFormat('Y-m-d H:i:s',$test['end'])->toTimeString())->toTimeString(),0,5);
                            }
                        }
                        array_push($weekEvents[$day], $test);
                    }
                }
            }
            $data->put('weekevents',$weekEvents);
        }
        // Return data as JSON.
        return response()->json($data);
    }
    //</editor-fold>
}