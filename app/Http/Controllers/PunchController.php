<?php

namespace App\Http\Controllers;

use App\Tools\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $punches = \App\Tools\Helper::CEmployee()->punches->where("company_id", \App\Tools\Helper::CCompany()->id);
        return view("punch.index", compact('punches'));
    }

    public function lastweek()
    {
        $moyenne=[];

        $data = [
            "labels" => Helper::getlastweek(Carbon::today()),
            "datasets" =>
                [[
                    "label" => "Le nombre d'heure travaillé en moyenne",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => Helper::getLastWeekAverage(Carbon::today()),
                ]]
        ];
        return json_encode($data);
    }

    public function lastmouth()
    {
        $data = [
            "labels" => ["Première semaine", "Deuxième semaine", "Troisième semaine", "Quatrième semaine"],
            "datasets" =>
                [[
                    "label" => "Le nombre d'heure travaillé en moyenne",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => [0, 10, 5, 2],
                ]]
        ];
        return json_encode($data);
    }

    public function lastyear()
    {
        $data = [
            "labels" => ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
            "datasets" =>
                [[
                    "label" => "Le nombre d'heure travaillé en moyenne",
                    "backgroundColor" => '#552AD6',
                    "borderColor" => '#552AD6',
                    "data" => [0, 10, 5, 2, 20, 25, 45, 23, 45, 67, 34, 67],
                ]]
        ];
        return json_encode($data);
    }
}
