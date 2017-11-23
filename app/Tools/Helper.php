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
use App\Employee;
use App\JobOffer;
use App\Punch;
use App\User;
use Carbon\Carbon;
use function foo\func;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait Helper
{
    /**
     * @return Company
     */
    public static function CCompany()
    {
        //\session(['CurrentCompany' => User::all()->random()->companies()->get()->random()]);
        return session('CurrentCompany');
    }

    /**
     * @return Employee
     */
    public static function CEmployee()
    {
        return self::CCompany()->employees()->where('user_id', Auth::user()->id)->first();
    }

    /**
     * @return array
     */
    public function CAvailability()
    {
        if(self::CCompany() == null)
            return [];
        $company = self::CCompany();
        $employee = self::CEmployee();
        if ($employee == null)
            return [];
        $availabilitys = Availability::where([
            ['employee_id', '=', $employee->id],
            ['company_id', '=', $company->id]
        ]);
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

    public function Month(Carbon $carbon)
    {
        $month_fr = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
        return $month_fr[$carbon->month - 1];
    }

    public function getlastyearmonth(Carbon $today)
    {
        $months=[];
        for ($i=0; $i < 12; $i++) {
            array_push($months,$this->Month($today));
            $today = $today->subDays(30);
        }
        $months=array_reverse($months);
        return $months;
    }

    public function CRoles()
    {
        $rolea = [];
        foreach ($this->CEmployee()->specialroles()->get() as $specialrole)
            foreach ($specialrole->roles()->get() as $role)
                array_push($rolea, $role->content);
        return $rolea;
    }

    public function CIsCEO()
    {
        if (in_array("Owner", $this->CRoles()))
            return true;
        return false;
    }

    public function CIsManager()
    {
        if (in_array("Manager", $this->CRoles()))
            return true;
        return false;
    }

    public function CIsEmployee()
    {
        if (in_array("Employee", $this->CRoles()))
            return true;
        return false;
    }

    public function IsAdmin()
    {
        if (in_array("Administrator", $this->CRoles()))
            return true;
        return false;
    }

    public function getJobOfferUserById($id)
    {
        $jobofferuser = null;
        $jobOffers = $this->CCompany()->joboffers()->get();
        foreach ($jobOffers as $joboffer) {
            if ($joboffer->users) {
                foreach ($joboffer->users as $user)
                    if ($user->pivot->id == $id)
                        $jobofferuser = $user->pivot;
            }
        }
        return $jobofferuser;
    }

    public function getEmployeeFromCompany()
    {
        return session('CurrentCompany')->employees->where('user_id',Auth::user()->id)->get();
    }

    public static function hasLastPunch()
    {
        if (self::CEmployee() != null){
            if (count(self::CEmployee()->punches()->get()) > 0)
            {
                if(self::CEmployee()->punches()->where([['dateend',null],['company_id',self::CCompany()->id]])->get()->count()>0)
                    return true;
            }
        }
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

    public function getlastweekdates($today)
    {
        $lastweek=[];
        $i=5;
        while($i>0)
        {
            if($this->Day($today)!='Dimanche' && $this->Day($today)!='Samedi')
            {
                array_push($lastweek,new Carbon($today));
                --$i;
            }
            $today=$today->subDays(1);
        }
        $lastweek=array_reverse($lastweek);
        return $lastweek;
    }

    public function getDaySum($day)
    {
        //$punches=$this->CEmployee()->punches()->where([['datebegin','>=',new Carbon($day)],['datebegin','<=',new Carbon($day->tomorrow())],['company_id',$this->CCompany()->id]])->get();
        $punches=$this->CEmployee()->punches()->whereBetween('datebegin',[new Carbon($day),new Carbon($day->addDay())])->where('company_id',$this->CCompany()->id)->get();
        $average=0;
        foreach ($punches as $punch)
        {
            $average+= Carbon::parse($punch->dateend)->diffInSeconds(Carbon::parse($punch->datebegin));
        }
        $average=$average;
        return $average/60/60;
    }

    public function getLastWeekSum($today)
    {
        $week=$this->getlastweekdates($today);
        $averages=[];
        foreach ($week as $day)
        {
            array_push($averages,round($this->getDaySum($day),2));
        }
        return $averages;
    }

    public function getLast4WeekDates($today)
    {
        $s4Week=[];
        $i=5*4;
        while($i>0)
        {
            if($this->Day($today)!='Dimanche' && $this->Day($today)!='Samedi')
            {
                array_push($s4Week,new Carbon($today));
                --$i;
            }
            $today=$today->subDays(1);
        }
        $s4Week=array_reverse($s4Week);
        // $s4weeksums=[];
        // foreach ($s4Week as $key) {
        //     array_push($s4weeksums,$this->getDaySum($key));
        // }
        // var_dump($s4weeksums);
        return $s4Week;
    }
    public function getLastYearsDates($today)
    {
        $years=[];
        $i=5*4*12;
        while($i>0)
        {
            if($this->Day($today)!='Dimanche' && $this->Day($today)!='Samedi')
            {
                array_push($years,new Carbon($today));
                --$i;
            }
            $today=$today->subDays(1);
        }
        $years=array_reverse($years);
        return $years;
    }

    public function makeSum($array,$first_n,$n)
    {
        $sum=0;
        $nn=$first_n*$n;
        for ($i=0+$nn; $i < $first_n+$nn ; $i++) {
            $sum+=$this->getDaySum($array[$i]);
        }
        return round($sum,2);
    }

    public function getDays()
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

    public function getWeekDaysJson()
    {
        return collect([
            'weekevents' => [
                'Dimanche' => [],
                'Lundi' => [],
                'Mardi' => [],
                'Mercredi' => [],
                'Jeudi' => [],
                'Vendredi' => [],
                'Samedi' => [],
            ]
        ]);
    }

    /**
     * @return \App\Schedule
     */
    public function getCurrentSchedule()
    {
        return $this->CCompany()->schedules()
                               ->where('begin', '<=', Carbon::now())
                               ->where('end'  , '>=', Carbon::now())
                               ->first();
    }

    /**
     * @return array
     */
    public function getJobOfferUsers()
    {
//        $jobofferusers = [];
//        $jobOffers = self::CCompany()->joboffers()->get();
//        foreach ($jobOffers as $joboffer) {
//            if ($joboffer->users) {
//                foreach ($joboffer->users as $user)
//                    array_push($jobofferusers,$user->pivot);
//            }
//        }
//        return $jobofferusers;
        return self::CCompany()->joboffers()->join('job_offer_user','job_offers.id','=','job_offer_user.job_offer_id')
                                            ->select('job_offers.*')
                                            ->get()
                                            ->map(function($joboffer) {
                                                return $joboffer->users()->get()->map(function ($user) {
                                                    return $user->pivot;
                                                })->first();
                                            });
    }
}