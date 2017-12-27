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
use PhpParser\Node\Stmt\Catch_;

trait Helper
{
    /**
     * @return Company
     */
    public static function CCompany()
    {
        //session(['CurrentCompany' => User::all()->random()->companies()->get()->random()]);
        return session('CurrentCompany');
    }

    /**
     * @return Employee
     */
    public static function CEmployee()
    {
        return self::CCompany()->employees()->where('user_id', Auth::user()->id)->first();
    }

    public static function verifyEmployeeStatus()
    {
        if (Auth::check() && !Session::has('CurrentCompany')) {
            if (Auth::user()->employees()->get()->isEmpty()) {
                session()->forget('CurrentCompany');
            } else {
                $companies = Auth::user()->companies()->get();
                if($companies->count() > 0) {
                    session(['CurrentCompany' => $companies->first()]);
                }
                else {
                    $companies = Auth::user()->employees()->get()->map(function (Employee $employee) { return $employee->companies()->get()->unique(); })->first();
                    if($companies != null && $companies->count() > 0) {
                        session(['CurrentCompany' => $companies->first()]);
                    }
                }
            }
        } else if (Auth::check()) {
            if (Auth::user()->employees()->get()->isEmpty()) {
                session()->forget('CurrentCompany');
            }
        }
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
        if (self::CEmployee() == null) {
            return [];
        } else {
            return self::CEmployee()->specialroles()->get()->map(function(SpecialRole $specialrole) {
                return $specialrole->roles()->pluck('content');
            })->unique()->first()->toArray();
        }
    }

    /**
     * @return bool
     */
    public static function CIsHighRanked()
    {
        return self::CIsCEO() || self::CIsManager() || self::IsAdmin();
    }

    public static function CIsCEO()
    {
        return in_array("Owner", self::CRoles());
    }

    /**
     * @return bool
     */
    public static function CIsManager()
    {
        return in_array("Manager", self::CRoles());
    }

    public static function CIsEmployee()
    {
        return in_array("Employee", self::CRoles());
    }

    public static function IsAdmin()
    {
        return in_array("Administrator", self::CRoles());
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
        $lastweek = [];
        $i = 7;
        while($i > 0) {
            array_push($lastweek,self::Day($today));
            --$i;
            $today = $today->subDays(1);
        }
        $lastweek = array_reverse($lastweek);
        return $lastweek;
    }

    public function getLastTwoWeeks(Carbon $today)
    {
        $lastTwoWeeks = [];
        for ($i = 14; $i > 0; --$i) {
            array_push($lastTwoWeeks,self::Day($today));
            $today->subDay(1);
        }
        return array_reverse($lastTwoWeeks);
    }

    public function getlastweekdates(Carbon $today)
    {
        $lastweek = [];
        $i = 7;
        while($i > 0)
        {
            array_push($lastweek,new Carbon($today));
            --$i;
            $today = $today->subDays(1);
        }
        $lastweek = array_reverse($lastweek);
        return $lastweek;
    }

    public function getDaySum(Carbon $day,Employee $employee)
    {
        $punches = $employee->punches()->whereBetween('datebegin',[new Carbon($day),new Carbon($day->addDay())])->where('company_id',self::CCompany()->id)->get();
        $average = 0;
        foreach ($punches as $punch) {
            $average += Carbon::parse($punch->dateend)->diffInSeconds(Carbon::parse($punch->datebegin));
        }
        return $average / 60 / 60;
    }

    public function getEmployeesDaySum(Carbon $day)
    {
        $punches = self::CCompany()->punches()->whereBetween('datebegin',[new Carbon($day),new Carbon($day->addDay())])->get();
        $average = 0;
        foreach ($punches as $punch) {
            $average += Carbon::parse($punch->dateend)->diffInSeconds(Carbon::parse($punch->datebegin));
        }
        return $average / 60 / 60;
    }

    public function getLastWeekSum(Carbon $today,Employee $employee)
    {
        $week = $this->getlastweekdates($today);
        $averages = [];
        foreach ($week as $day) {
            array_push($averages,round($this->getDaySum($day,$employee),2));
        }
        return $averages;
    }

    public function getDaySumByEmployee(Employee $employee, Carbon $day) {
        $punches = $employee->punches()->whereBetween('datebegin',[new Carbon($day),new Carbon($day->addDay())])->where('company_id',self::CCompany()->id)->get();
        $average = 0;
        foreach ($punches as $punch) {
            $average += Carbon::parse($punch->dateend)->diffInSeconds(Carbon::parse($punch->datebegin));
        }
        return $average / 60 / 60;
    }

    public function getLastTwoWeeksDates(Carbon $today)
    {
        $lastTwoWeeksDates = [];
        for ($i = 14; $i > 0; --$i) {
            array_push($lastTwoWeeksDates,new Carbon($today));
            $today = $today->subDays(1);
        }
        return array_reverse($lastTwoWeeksDates);
    }

    public static function rand_color() {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    public function getLastTwoWeeksSum(Carbon $today,Employee $employee)
    {
        $week = $this->getLastTwoWeeksDates($today);
        $averages = [];
        foreach ($week as $day) {
            array_push($averages,round($this->getDaySum($day,$employee),2));
        }
        return $averages;
    }

    public function getLast4WeekDates(Carbon $today)
    {
        $s4Week = [];
        $i = 7 * 4;
        while($i > 0)
        {
            array_push($s4Week,new Carbon($today));
            --$i;
            $today = $today->subDays(1);
        }
        $s4Week = array_reverse($s4Week);
        return $s4Week;
    }
    public function getLastYearsDates(Carbon $today)
    {
        $years = [];
        $i = 7 * 4 * 12;
        while($i > 0)
        {
            array_push($years,new Carbon($today));
            --$i;
            $today = $today->subDays(1);
        }
        $years = array_reverse($years);
        return $years;
    }

    public function makeSum(Employee $employee,$array,$first_n,$n)
    {
        $sum = 0;
        $nn = $first_n*$n;
        for ($i = 0 + $nn; $i < $first_n + $nn ; $i++) {
            $sum+=$this->getDaySum($array[$i],$employee);
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
                    if ($user->pivot->accepted != 1) return $user->pivot;
                })->first();
            })->unique();
    }

    /**
     * @param string $order
     * @return \Illuminate\Support\Collection|static
     */
    public function getJobOfferUsersSortedByName($order)
    {
        if ($order == 'ASC') {
            return self::CCompany()->joboffers()->get()
                ->map(function(JobOffer $joboffer) use ($order) {
                    return $joboffer->users()->get()->sortBy(function ($user) { return $user->fullname; })->map(function (User $user) {
                        if ($user->pivot->accepted != 1) return $user->pivot;
                    })->first();
                })->unique();
        } else {
            return self::CCompany()->joboffers()->get()
                ->map(function(JobOffer $joboffer) use ($order) {
                    return $joboffer->users()->get()->sortByDesc(function ($user) { return $user->fullname; })->map(function (User $user) {
                        if ($user->pivot->accepted != 1) return $user->pivot;
                    })->first();
                })->unique();
        }
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
                    if ($user->pivot->accepted != 1) return $user->pivot;
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

    /**
     * @return mixed
     */
	public function getCompaniesOfEmployee()
    {
        return Auth::user()->employees()->get()->map(function ($employee) { return $employee->companies()->get()->unique(); })->first();
    }
}