<?php
/**
 * Created by PhpStorm.
 * User: ludov
 * Date: 2017-10-02
 * Time: 19:15
 */

namespace App\Tools;


use App\Admin;
use App\Availability;
use App\Company;
use App\JobOffer;
use App\Punch;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

abstract class Helper
{
    public static function CCompany()
    {
        //\session(['CurrentCompany' => User::all()->random()->companies()->get()->random()]);
        return session('CurrentCompany');
    }

    public static function CEmployee()
    {
        return self::CCompany()->employees->where('user_id', Auth::user()->id)->get(0);
    }

    public static function CAvailability()
    {
        if(!Session::has('CurrentCompany'))
            return [];
        $company = self::CCompany();
        $employee = self::CEmployee();
        $availabilitys = Availability::where([
            ['employee_id', '=', $employee->id],
            ['company_id', '=', $company->id]
        ])->get();
        return $availabilitys;
    }

    public static function Day($carbon)
    {
        $daysofweek_fr = [
            "Samedi",
            "Dimanche",
            "Lundi",
            "Mardi",
            "Mercredi",
            "Jeudi",
            "Vendredi"
        ];
        return $daysofweek_fr[$carbon->dayOfWeek];
    }

    public static function Month($carbon)
    {
        $month_fr=["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
        return $month_fr[$carbon->month-1];
    }

    public static function getlastyearmonth($today)
    {
        $months=[];
        for ($i=0; $i < 12; $i++) {
            array_push($months,self::Month($today));
            $today=$today->subDays(30);
        }
        $months=array_reverse($months);
        return $months;
    }

    public static function CRoles()
    {
        $rolea = [];
        foreach (self::CEmployee()->specialroles as $specialrole)
            foreach ($specialrole->roles as $role)
                array_push($rolea, $role->content);
        return $rolea;
    }

    public static function CIsCEO()
    {
        if (in_array("Owner", self::CRoles()))
            return true;
        return false;
    }

    public static function CIsManager()
    {
        if (in_array("Manager", self::CRoles()))
            return true;
        return false;
    }

    public static function CIsEmployee()
    {
        if (in_array("Employee", self::CRoles()))
            return true;
        return false;
    }

    public static function IsAdmin()
    {
        if (in_array("Administrator", self::CRoles()))
            return true;
        return false;
    }

    public static function getJobOfferUserById($id)
    {
        $jobofferuser = null;
        $jobOffers = JobOffer::where('company_id',session('CurrentCompany')->id)->get();
        foreach ($jobOffers as $joboffer) {
            if ($joboffer->users) {
                foreach ($joboffer->users as $user)
                    if ($user->pivot->id == $id)
                        $jobofferuser = $user->pivot;
            }
        }
        return $jobofferuser;
    }

    public static function getEmployeeFromCompany()
    {
        return session('CurrentCompany')->employees->where('user_id',Auth::user()->id)->get();
    }

    public static function hasLastPunch()
    {
        if(self::CEmployee()->punches()->where([['dateend',null],['company_id',self::CCompany()->id]])->get()->count()>0)
            return true;
        return false;
    }

    public static function punchMessage($bool)
    {
        return !$bool ? "Commencer à travailler" : "Terminer de travailler";
    }

    public static function getlastweek($today)
    {
        $lastweek=[];
        $i=5;
        while($i>0)
        {
            if(self::Day($today)!='Dimanche' && self::Day($today)!='Samedi')
            {
                array_push($lastweek,self::Day($today));
                --$i;
            }
            $today=$today->subDays(1);
        }
        $lastweek=array_reverse($lastweek);
        return $lastweek;
    }

    public static function getlastweekdates($today)
    {
        $lastweek=[];
        $i=5;
        while($i>0)
        {
            if(self::Day($today)!='Dimanche' && self::Day($today)!='Samedi')
            {
                array_push($lastweek,new Carbon($today));
                --$i;
            }
            $today=$today->subDays(1);
        }
        $lastweek=array_reverse($lastweek);
        return $lastweek;
    }

    public static function getDaySum($day)
    {
        //$punches=self::CEmployee()->punches()->where([['datebegin','>=',new Carbon($day)],['datebegin','<=',new Carbon($day->tomorrow())],['company_id',self::CCompany()->id]])->get();
        $punches=self::CEmployee()->punches()->whereBetween('datebegin',[new Carbon($day),new Carbon($day->addDay())])->where('company_id',self::CCompany()->id)->get();
        $average=0;
        foreach ($punches as $punch)
        {
            $average+= Carbon::parse($punch->dateend)->diffInSeconds(Carbon::parse($punch->datebegin));
        }
        $average=$average;
        return $average/60/60;
    }

    public static function getLastWeekSum($today)
    {
        $week=self::getlastweekdates($today);
        $averages=[];
        foreach ($week as $day)
        {
            array_push($averages,round(self::getDaySum($day),2));
        }
        return $averages;
    }

    public static function getLast4WeekDates($today)
    {
        $s4Week=[];
        $i=5*4;
        while($i>0)
        {
            if(self::Day($today)!='Dimanche' && self::Day($today)!='Samedi')
            {
                array_push($s4Week,new Carbon($today));
                --$i;
            }
            $today=$today->subDays(1);
        }
        $s4Week=array_reverse($s4Week);
        // $s4weeksums=[];
        // foreach ($s4Week as $key) {
        //     array_push($s4weeksums,self::getDaySum($key));
        // }
        // var_dump($s4weeksums);
        return $s4Week;
    }
    public static function getLastYearsDates($today)
    {
        $years=[];
        $i=5*4*12;
        while($i>0)
        {
            if(self::Day($today)!='Dimanche' && self::Day($today)!='Samedi')
            {
                array_push($years,new Carbon($today));
                --$i;
            }
            $today=$today->subDays(1);
        }
        $years=array_reverse($years);
        return $years;
    }

    public static function makeSum($array,$first_n,$n)
    {
        $sum=0;
        $nn=$first_n*$n;
        for ($i=0+$nn; $i < $first_n+$nn ; $i++) {
            $sum+=self::getDaySum($array[$i]);
        }
        return round($sum,2);
    }

    public static function getDays()
    {
        return [
            'Dimanche',
            'Lundi',
            'Mardi',
            'Mercredi',
            'Jeudi',
            'Vendredi',
            'Samedi'
        ];
    }

    public static function getWeekDays()
    {
        return [
            'Lundi',
            'Mardi',
            'Mercredi',
            'Jeudi',
            'Vendredi'
        ];
    }

    public static function getWeekDaysJson()
    {
        return collect([
            'weekevents' => [
                'Lundi' => [],
                'Mardi' => [],
                'Mercredi' => [],
                'Jeudi' => [],
                'Vendredi' => [],
            ]
        ]);
    }

    /**
     * @return \App\Schedule
     */
    public static function getCurrentSchedule()
    {
        return session('CurrentCompany')->schedules
                                            ->where('begin', '<=', Carbon::now())
                                            ->where('end'  , '>=', Carbon::now())
                                            ->first();
    }
}