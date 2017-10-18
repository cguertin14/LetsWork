<?php

namespace App\Http\Controllers;

use App\Tools\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class PunchController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $lastpunch = \App\Tools\Helper::CEmployee()->punches()->where([['dateend', null], ['company_id', \App\Tools\Helper::CCompany()->id]])->get();
        if ($lastpunch->count() > 0) {
            $lastpunch->first()->dateend = \Carbon\Carbon::now();
            $lastpunch->first()->update();
            return 0;
        } else {
            \App\Punch::create([
                "datebegin" => \Carbon\Carbon::now(),
                "employee_id" => \App\Tools\Helper::CEmployee()->id,
                "company_id" => \App\Tools\Helper::CCompany()->id,
            ]);
            return 1;
        }
    }

    public function index()
    {
        $punches = \App\Tools\Helper::CEmployee()->punches()->where("company_id", \App\Tools\Helper::CCompany()->id)->paginate(10);
        return view("punch.index", compact('punches'));
    }

    public function lastweek()
    {
        $moyenne=[];

        $data = [
            "labels" => Helper::getlastweek(Carbon::today()),
            "datasets" =>
                [[
                    "label" => "La somme des heures travaillées",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => Helper::getLastWeekSum(Carbon::today()),
                ]
            ]
        ];
        return response()->json($data);
    }

    public function lastmouth()
    {
        $today=Helper::getLast4WeekDates(Carbon::today());
        $data = [
            "labels" => ["1ère semaine", "2ième semaine", "3ième semaine", "4ième semaine"],
            "datasets" =>
                [[
                    "label" => "La somme des heures travaillées",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => [
                    Helper::makeSum($today,5,0),
                    Helper::makeSum($today,5,1),
                    Helper::makeSum($today,5,2),
                    Helper::makeSum($today,5,3)],
                ]
            ]
        ];
        return response()->json($data);
    }

    public function lastyear()
    {
        $today=Helper::getLastYearsDates(Carbon::today());
        $data = [
            "labels" => ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
            "datasets" =>
                [[
                    "label" => "La somme des heures travaillées",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => [
                        Helper::makeSum($today,20,0),
                        Helper::makeSum($today,20,1),
                        Helper::makeSum($today,20,2),
                        Helper::makeSum($today,20,3),
                        Helper::makeSum($today,20,4),
                        Helper::makeSum($today,20,5),
                        Helper::makeSum($today,20,6),
                        Helper::makeSum($today,20,7),
                        Helper::makeSum($today,20,8),
                        Helper::makeSum($today,20,9),
                        Helper::makeSum($today,20,10),
                        Helper::makeSum($today,20,11)],
                ]
            ]
        ];
        return response()->json($data);
    }
}
