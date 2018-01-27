<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\ClockOutRequest;
use App\Punch;
use App\Tools\Collection;
use App\Tools\Helper;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;

class PunchController extends BaseController
{
    /**
     * PunchController constructor.
     */
    public function __construct()
    {
        $this->middleware('employee',['except' => ['addIpad','clockOut']]);
        $this->middleware('highranked',['only' => [
                'employees','sortEmployees','lastWeekEmployees','lastMonthEmployees',
                'lastTwoWeeksEmployees','lastYearEmployees','sortEmployeesByName',
                'employeesNames','employee','employeesIndex'
            ]
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function add()
    {
        $lastpunch = self::CEmployee()->punches()->where([['dateend', null], ['company_id', self::CCompany()->id]])->get();
        if ($lastpunch->count() > 0) {
            $lastpunch->first()->update(['dateend' => Carbon::now()]);
            return response()->json(['status' => false]);
        } else {
            Punch::query()->create([
                'datebegin' => Carbon::now(),
                'employee_id' => self::CEmployee()->id,
                'company_id' => self::CCompany()->id,
            ]);
            return response()->json(['status' => true]);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function addIpad($id)
    {
        $employee = Employee::query()->findOrFail($id);
        $lastpunch = $employee->punches()->where([['dateend', null], ['company_id', self::CCompany()->id]])->get();
        if ($lastpunch->count() > 0) {
            $lastpunch->first()->update(['dateend' => Carbon::now()]);
            return response()->json(['status' => false]);
        } else {
            Punch::query()->create([
                'datebegin' => Carbon::now(),
                'employee_id' => $employee->id,
                'company_id' => $employee->id,
            ]);
            return response()->json(['status' => true]);
        }
    }

    /**
     * @param ClockOutRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function clockOut(ClockOutRequest $request)
    {
        if ($punches = Punch::query()->latest()->get()) {
            $punches->first()->update(['task' => $request->input('task')]);
            return response()->json(['status' => 'ok']);
        } else {
            return response()->json(['error' => 'No punches.'],400);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPunch($id)
    {
        $punch = Punch::query()->findOrFail($id);
        return view('punch.getpunch',compact('punch'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //session()->forget('sortPunches');
        if (Session::has('sortPunches')) {
            $sesh = session('sortPunches');
            if ($sesh['column'] === 'duration') {
                $punches = self::CEmployee()->punches()->where("company_id", self::CCompany()->id)->orderByRaw('(dateend - datebegin) ' . $sesh['order'])->paginate(5);
            } else {
                $punches = self::CEmployee()->punches()->where("company_id", self::CCompany()->id)->orderBy($sesh['column'], $sesh['order'])->paginate(5);
            }
        } else {
            $punches = self::CEmployee()->punches()->where("company_id", self::CCompany()->id)->latest()->paginate(5);
            $sesh = [];
        }
        return view("punch.index", compact('punches','sesh'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function employees()
    {
        if (Session::has('sortPunchesEmployees')) {
            $sesh = session('sortPunchesEmployees');
            if ($sesh['column'] === 'duration') {
                $punches = self::CCompany()->punches()->where('employee_id','<>',self::CEmployee()->id)->orderByRaw('(dateend - datebegin) ' . $sesh['order'])->paginate(5);
            } else if ($sesh['column'] === 'username') {
                if ($sesh['order'] == 'ASC') {
                    $punches = (new Collection(self::CCompany()->punches()->where('employee_id','<>',self::CEmployee()->id)->get()))->sortBy(function (Punch $punch) {
                        return $punch->employee->user->fullname;
                    })->paginate(5);
                } else {
                    $punches = (new Collection(self::CCompany()->punches()->where('employee_id','<>',self::CEmployee()->id)->get()))->sortByDesc(function (Punch $punch) {
                        return $punch->employee->user->fullname;
                    })->paginate(5);
                }
            } else {
                $punches = self::CCompany()->punches()->where('employee_id','<>',self::CEmployee()->id)->orderBy($sesh['column'], $sesh['order'])->paginate(5);
            }
        } else {
            $punches = self::CCompany()->punches()->where('employee_id','<>',self::CEmployee()->id)->latest()->paginate(5);
            $sesh = [];
        }
        $employees = self::CCompany()->punches()->where('employee_id','<>',self::CEmployee()->id)->get()->map(function (Punch $punch) { return $punch->employee; })->unique();
        return view('punch.employees',compact('punches','sesh','employees'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sort(Request $request)
    {
        session(['sortPunches' => $request->all()]);
        return redirect()->action('PunchController@index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sortEmployees(Request $request)
    {
        session(['sortPunchesEmployees' => $request->all()]);
        return redirect()->action('PunchController@employees');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sortEmployee(Request $request)
    {
        session(["sortPunchesEmployee{$request->input('employee_id')}" => $request->all()]);
        return redirect()->action('PunchController@employee', [
            'id' => $request->input('employee_id')
        ]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function employee($id)
    {
        $employee = self::CCompany()->employees()->findOrFail($id);
        if (Session::has("sortPunchesEmployee{$employee->id}")) {
            $sesh = session("sortPunchesEmployee{$employee->id}");
            if ($sesh['column'] === 'duration') {
                $punches = $employee->punches()->where("company_id", self::CCompany()->id)->orderByRaw('(dateend - datebegin) ' . $sesh['order'])->paginate(5);
            } else {
                $punches = $employee->punches()->where("company_id", self::CCompany()->id)->orderBy($sesh['column'], $sesh['order'])->paginate(5);
            }
        } else {
            $punches = $employee->punches()->paginate(5);
            $sesh = [];
        }
        return view('punch.employee',compact('employee','punches','sesh'));
    }

    /**
     * @param $name
     * @return string
     */
    public function sortEmployeesByName($name)
    {
        $employees = self::CCompany()
            ->punches()
            ->get()
            ->where('employee_id','<>',self::CEmployee()->id)
            ->map(function (Punch $punch) use ($name) {
                return $punch->employee;
            })
            ->unique()
            ->filter(function (Employee $employee) use ($name) {
                return stristr($employee->user->fullname,$name);
            });
        return $this->employeesGrid($employees);
    }

    /**
     * @param $employees
     * @return string
     */
    public function employeesGrid($employees)
    {
        return view('punch.employees_grid',compact('employees'))->render();
    }

    /**
     * @return string
     */
    public function employeesIndex()
    {
        return $this->employeesGrid(self::CCompany()->punches()->where('employee_id','<>',self::CEmployee()->id)->get()->map(function (Punch $punch) { return $punch->employee; })->unique());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function employeesNames()
    {
        // Get employees fullnames and send them to the client.
        return response()->json(['employees' => self::CCompany()->punches()->where('employee_id','<>',self::CEmployee()->id)->get()->map(function (Punch $punch) { return $punch->employee->user->fullname; })->unique()]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function lastweek($id)
    {
        $employee = Employee::query()->findOrFail($id);
        $data = [
            "labels" => $this->getlastweek(Carbon::today()),
            "datasets" => [
                [
                    "label" => "La somme des heures travaillées par {$employee->user->fullname} ce jour-là",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => $this->getLastWeekSum(Carbon::today(),$employee),
                ]
            ]
        ];
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function lastTwoWeeks($id)
    {
        $employee = Employee::query()->findOrFail($id);
        $data = [
            "labels" => $this->getLastTwoWeeks(Carbon::today()),
            "datasets" => [
                [
                    "label" => "La somme des heures travaillées par {$employee->user->fullname} ce jour-là",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => $this->getLastTwoWeeksSum(Carbon::today(),$employee),
                ]
            ]
        ];
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function lastmonth($id)
    {
        $employee = Employee::query()->findOrFail($id);
        $today = $this->getLast4WeekDates(Carbon::today());
        $data = [
            "labels" => ["1ère semaine", "2ième semaine", "3ième semaine", "4ième semaine"],
            "datasets" => [
                [
                    "label" => "La somme des heures travaillées par {$employee->user->fullname} cette semaine-là",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => [
                        $this->makeSum($employee,$today,7,0),
                        $this->makeSum($employee,$today,7,1),
                        $this->makeSum($employee,$today,7,2),
                        $this->makeSum($employee,$today,7,3)
                    ],
                ]
            ]
        ];
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function lastyear($id)
    {
        $employee = Employee::query()->findOrFail($id);
        $today = $this->getLastYearsDates(Carbon::today());
        $data = [
            "labels" => $this->getlastyearmonth(Carbon::today()),
            "datasets" => [
                [
                    "label" => "La somme des heures travaillées par {$employee->user->fullname} ce mois-là",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => [
                        $this->makeSum($employee,$today,28,0),
                        $this->makeSum($employee,$today,28,1),
                        $this->makeSum($employee,$today,28,2),
                        $this->makeSum($employee,$today,28,3),
                        $this->makeSum($employee,$today,28,4),
                        $this->makeSum($employee,$today,28,5),
                        $this->makeSum($employee,$today,28,6),
                        $this->makeSum($employee,$today,28,7),
                        $this->makeSum($employee,$today,28,8),
                        $this->makeSum($employee,$today,28,9),
                        $this->makeSum($employee,$today,28,10),
                        $this->makeSum($employee,$today,28,11)],
                ]
            ]
        ];
        return response()->json($data);
    }
}
