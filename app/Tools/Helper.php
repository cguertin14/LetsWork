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
use App\SpecialRole;
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
     * @return array|Collection
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
        ])->get();
        return $availabilitys;
    }

    public static function Day($carbon)
    {
        $daysofweek_fr = [
            "Dimanche",
            "Lundi",
            "Mardi",
            "Mercredi",
            "Jeudi",
            "Vendredi",
            "Samedi"
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

    public static function CRoles()
    {
        return self::CEmployee()->specialroles()->get()->map(function(SpecialRole $specialrole) {
            return $specialrole->roles()->pluck('content')->first();
        })->unique()->toArray();
    }

    /**
     * @return bool
     */
    public static function CIsHighRanked()
    {
        return self::CIsCEO()  || self::CIsManager() || self::IsAdmin();
    }

    public static function CIsCEO()
    {
        if (in_array("Owner", self::CRoles()))
            return true;
        return false;
    }

    /**
     * @return bool
     */
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

    public function getJobOfferUserById($id)
    {
        $jobofferuser = null;
        $jobOffers = self::CCompany()->joboffers()->get();
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

    public static function getlastweek(Carbon $today)
    {
        $lastweek=[];
        $i=7;
        while($i>0)
        {
            array_push($lastweek,self::Day($today));
            --$i;
            $today=$today->subDays(1);
        }
        $lastweek=array_reverse($lastweek);
        return $lastweek;
    }

    public function getlastweekdates(Carbon $today)
    {
        $lastweek=[];
        $i=7;
        while($i>0)
        {
            array_push($lastweek,new Carbon($today));
            --$i;
            $today=$today->subDays(1);
        }
        $lastweek=array_reverse($lastweek);
        return $lastweek;
    }

    public function getDaySum(Carbon $day)
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

    public function getLast4WeekDates(Carbon $today)
    {
        $s4Week=[];
        $i=7*4;
        while($i>0)
        {
            array_push($s4Week,new Carbon($today));
            --$i;
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
    public function getLastYearsDates(Carbon $today)
    {
        $years=[];
        $i=7*4*12;
        while($i>0)
        {
            array_push($years,new Carbon($today));
            --$i;
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
        return self::CCompany()->schedules()
            ->where('begin', '<=', Carbon::now())
            ->where('end'  , '>=', Carbon::now())
            ->first();
    }

    /**
     * @return \Illuminate\Support\Collection|static
     */
    public function getJobOfferUsers()
    {
        return self::CCompany()->joboffers()->get()
            ->map(function(JobOffer $joboffer) {
                return $joboffer->users()->get()->map(function (User $user) {
                    return $user->pivot;
                })->first();
            })->unique();
    }

    /**
     * @param string $order
     * @return \Illuminate\Support\Collection|static
     */
    public function getJobOfferUsersSortedByName($order)
    {
        return self::CCompany()->joboffers()->get()
            ->map(function(JobOffer $joboffer) use ($order) {
                return $joboffer->users()->orderBy('name',$order)->get()->map(function (User $user) {
                    return $user->pivot;
                })->first();
            })->unique();
    }

    /**
     * @param string $order
     * @return \Illuminate\Support\Collection|static
     */
    public function getJobOfferUsersSortedByPoste($order)
    {
        return self::CCompany()->joboffers()->orderBy('name',$order)
            ->get()
            ->map(function(JobOffer $joboffer) {
                return $joboffer->users()->get()->map(function (User $user) {
                    return $user->pivot;
                })->first();
            })->unique();
    }
	
	public static function getWeekDays() {//copy
		return [
			'Lundi',
			'Mardi',
			'Mercredi',
			'Jeudi',
			'Vendredi',
		];
	}
	
	public static function setLogedRedisUsers() {
		$json = [];
		try {
			$redis = new \Predis\Client('localhost:6379');
			foreach (\App\Session::connectedUsers() as $session) {
				array_push($json, ['email' => $session->user->email,
					'name' => $session->user->name,
				]);
			}
			$redis->set('OnlineUsers', \GuzzleHttp\json_encode($json));
		} catch (Exception $e) {
			die($e->getMessage());
		}
	}
}