<?php

namespace App\Http\Controllers;

use App\Punch;
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
                $punches = self::CEmployee()->punches()->where("company_id", self::CCompany()->id)->orderBy($sesh['column'],$sesh['order'])->paginate(10);
            }
        } else {
            $punches = self::CEmployee()->punches()->where("company_id", self::CCompany()->id)->paginate(5);
            $sesh = [];
        }
        return view("punch.index", compact('punches','sesh'));
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

    public function lastweek()
    {
        $data = [
            "labels" => $this->getlastweek(Carbon::today()),
            "datasets" =>
                [[
                    "label" => "La somme des heures travaillées",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => $this->getLastWeekSum(Carbon::today()),
                ]
            ]
        ];
        return response()->json($data);
    }

    public function lastmouth()
    {
        $today=$this->getLast4WeekDates(Carbon::today());
        $data = [
            "labels" => ["1ère semaine", "2ième semaine", "3ième semaine", "4ième semaine"],
            "datasets" =>
                [[
                    "label" => "La somme des heures travaillées",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => [
                    $this->makeSum($today,7,0),
                    $this->makeSum($today,7,1),
                    $this->makeSum($today,7,2),
                    $this->makeSum($today,7,3)],
                ]
            ]
        ];
        return response()->json($data);
    }

    public function lastyear()
    {
        $today=$this->getLastYearsDates(Carbon::today());
        $data = [
            "labels" => $this->getlastyearmonth(Carbon::today()),
            "datasets" =>
                [[
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
}
