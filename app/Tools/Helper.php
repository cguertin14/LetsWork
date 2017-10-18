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
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait Helper
{
    public static function CCompany()
    {
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
        $punches=self::CEmployee()->punches()->whereBetween('datebegin',[new Carbon($day),new Carbon($day->tomorrow())])->where('company_id',self::CCompany()->id)->get();
        $average=0;
        foreach ($punches as $punch)
        {
            $average+= Carbon::parse($punch->dateend)->diffInSeconds(Carbon::parse($punch->datebegin));
        }
        $average=$average;
        return $average/60/60;
    }

    public static function getLastWeekAverage($today)
    {
        $week=self::getlastweekdates($today);
        $averages=[];
        foreach ($week as $day)
        {
            array_push($averages,self::getDaySum($day));
        }
        return $averages;
    }
}