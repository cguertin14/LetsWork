<?php

namespace App\Http\Controllers;

use App\Punch;
use App\Tools\Collection;
use App\Tools\Helper;
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
        $this->middleware('employee');
        $this->middleware('highranked',['only' => ['employees','sortEmployees','lastWeekEmployees','lastMonthEmployees','lastTwoWeeksEmployees','lastYearEmployees']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $lastpunch = self::CEmployee()->punches()->where([['dateend', null], ['company_id', self::CCompany()->id]])->get();
        if ($lastpunch->count() > 0) {
            $lastpunch->first()->dateend = Carbon::now();
            $lastpunch->first()->update();
            return 0;
        } else {
            Punch::create([
                "datebegin" => Carbon::now(),
                "employee_id" => self::CEmployee()->id,
                "company_id" => self::CCompany()->id,
            ]);
            return 1;
        }
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
                $punches = self::CEmployee()->punches()->where("company_id", self::CCompany()->id)->orderByRaw('(dateend - datebegin) ' . $sesh['order'])->paginate(10);
            } else {
                $punches = self::CEmployee()->punches()->where("company_id", self::CCompany()->id)->orderBy($sesh['column'], $sesh['order'])->paginate(10);
            }
        } else {
            $punches = self::CEmployee()->punches()->where("company_id", self::CCompany()->id)->paginate(5);
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
                $punches = self::CCompany()->punches()->orderByRaw('(dateend - datebegin) ' . $sesh['order'])->paginate(10);
            } else if ($sesh['column'] === 'username') {
                if ($sesh['order'] == 'ASC') {
                    $punches = (new Collection(self::CCompany()->punches()->get()))->sortBy(function (Punch $punch) {
                        return $punch->employee->user->fullname;
                    })->paginate(5);
                } else {
                    $punches = (new Collection(self::CCompany()->punches()->get()))->sortByDesc(function (Punch $punch) {
                        return $punch->employee->user->fullname;
                    })->paginate(5);
                }
            } else {
                $punches = self::CCompany()->punches()->orderBy($sesh['column'], $sesh['order'])->paginate(10);
            }
        } else {
            $punches = self::CCompany()->punches()->paginate(5);
            $sesh = [];
        }
        return view('punch.employees',compact('punches','sesh'));
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function lastweek()
    {
        $data = [
            "labels" => $this->getlastweek(Carbon::today()),
            "datasets" => [
                [
                    "label" => self::CIsHighRanked() ? "Les heures travaillées par employé" : "La somme des heures travaillées",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => $this->getLastWeekSum(Carbon::today()),
                ]
            ]
        ];
        return response()->json($data);
    }

    public function lastWeekEmployees()
    {

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function lastTwoWeeks()
    {
        $data = [
            "labels" => $this->getLastTwoWeeks(Carbon::today()),
            "datasets" => [
                [
                    "label" => "La somme des heures travaillées",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => $this->getLastTwoWeeksSum(Carbon::today()),
                ]
            ]
        ];
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function lastTwoWeeksEmployees()
    {
        $data = [
            "labels" => $this->getLastTwoWeeks(Carbon::today()),
            "datasets" => $this->getCompanyEmployeesTwoWeekTimes()
        ];
        return response()->json($data);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function lastmonth()
    {
        $today=$this->getLast4WeekDates(Carbon::today());
        $data = [
            "labels" => ["1ère semaine", "2ième semaine", "3ième semaine", "4ième semaine"],
            "datasets" => [
                [
                    "label" => "La somme des heures travaillées",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => [
                        $this->makeSum($today,7,0),
                        $this->makeSum($today,7,1),
                        $this->makeSum($today,7,2),
                        $this->makeSum($today,7,3)
                    ],
                ]
            ]
        ];
        return response()->json($data);
    }

    /**
     *
     */
    public function lastMonthEmployees()
    {

    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function lastyear()
    {
        $today=$this->getLastYearsDates(Carbon::today());
        $data = [
            "labels" => $this->getlastyearmonth(Carbon::today()),
            "datasets" => [
                [
                    "label" => "La somme des heures travaillées",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => [
                        $this->makeSum($today,28,0),
                        $this->makeSum($today,28,1),
                        $this->makeSum($today,28,2),
                        $this->makeSum($today,28,3),
                        $this->makeSum($today,28,4),
                        $this->makeSum($today,28,5),
                        $this->makeSum($today,28,6),
                        $this->makeSum($today,28,7),
                        $this->makeSum($today,28,8),
                        $this->makeSum($today,28,9),
                        $this->makeSum($today,28,10),
                        $this->makeSum($today,28,11)],
                ]
            ]
        ];
        return response()->json($data);
    }

    /**
     *
     */
    public function lastYearEmployees()
    {

    }
}
