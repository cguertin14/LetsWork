<?php

namespace App\Http\Controllers;

use App\Punch;
use App\Tools\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class PunchController extends BaseController
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $lastpunch = self::CEmployee()->punches()->where([['dateend', null], ['company_id', $this->CCompany()->id]])->get();
        if ($lastpunch->count() > 0) {
            $lastpunch->first()->dateend = Carbon::now();
            $lastpunch->first()->update();
            return 0;
        } else {
            Punch::create([
                "datebegin" => Carbon::now(),
                "employee_id" => $this->CEmployee()->id,
                "company_id" => $this->CCompany()->id,
            ]);
            return 1;
        }
    }

    public function index()
    {
        $punches = $this->CEmployee()->punches()->where("company_id", $this->CCompany()->id)->paginate(5);
        return view("punch.index", compact('punches'));
    }

    public function lastweek()
    {
        $moyenne=[];

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
                    $this->makeSum($today,5,0),
                    $this->makeSum($today,5,1),
                    $this->makeSum($today,5,2),
                    $this->makeSum($today,5,3)],
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
                        $this->makeSum($today,20,0),
                        $this->makeSum($today,20,1),
                        $this->makeSum($today,20,2),
                        $this->makeSum($today,20,3),
                        $this->makeSum($today,20,4),
                        $this->makeSum($today,20,5),
                        $this->makeSum($today,20,6),
                        $this->makeSum($today,20,7),
                        $this->makeSum($today,20,8),
                        $this->makeSum($today,20,9),
                        $this->makeSum($today,20,10),
                        $this->makeSum($today,20,11)],
                ]
            ]
        ];
        return response()->json($data);
    }
}
