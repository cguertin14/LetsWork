<?php

namespace App\Http\Controllers;

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
        $lastpunch=\App\Tools\Helper::CEmployee()->punches()->where('dateend',null)->get();
        if($lastpunch->count()>0)
        {
            $lastpunch->first()->dateend=\Carbon\Carbon::now();
            $lastpunch->first()->update();
            return 0;
        }
        else
        {
            $punch =  \App\Punch::create([
                "datebegin"=> \Carbon\Carbon::now(),
                "employee_id"=>\App\Tools\Helper::CEmployee()->id,
                "company_id"=> \App\Tools\Helper::CCompany()->id,
            ]);
            return 1;
        }
    }

    public function index()
    {
        $punches=\App\Tools\Helper::CEmployee()->punches;
        return view("punch.index", compact('punches'));
    }
}
