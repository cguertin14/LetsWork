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
        return Helper::CCompany()->employees->where('user_id', Auth::user()->id)->get(0);
    }

    public static function CAvailability()
    {
        if(!Session::has('CurrentCompany'))
            return [];
        $company = Helper::CCompany();
        $employee = Helper::CEmployee();
        $availabilitys = Availability::where([
            ['employee_id', '=', $employee->id],
            ['company_id', '=', $company->id]
        ])->get();
        return $availabilitys;
    }

    public static function Day($carbon)
    {
        $daysofweek_fr = [
            "Lundi",
            "Mardi",
            "Mercredi",
            "Jeudi",
            "Vendredi",
            "Samedi",
            "Dimanche",
        ];
        return $daysofweek_fr[\Carbon\Carbon::parse($carbon)->dayOfWeek - 1];
    }

    public static function CRoles()
    {
        $rolea = [];
        foreach (Helper::CEmployee()->specialroles as $specialrole)
            foreach ($specialrole->roles as $role)
                array_push($rolea, $role->content);
        return $rolea;
    }

    public static function CIsCEO()
    {
        if (in_array("Owner", Helper::CRoles()))
            return true;
        return false;
    }

    public static function CIsManager()
    {
        if (in_array("Manager", Helper::CRoles()))
            return true;
        return false;
    }

    public static function CIsEmployee()
    {
        if (in_array("Employee", Helper::CRoles()))
            return true;
        return false;
    }

    public static function IsAdmin()
    {
        if (in_array("Administrator", Helper::CRoles()))
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
        if(\App\Tools\Helper::CEmployee()->punches()->where('dateend',null)->get()->count()>0)
            return true;
        return false;
    }

    public static function punchMessage($bool)
    {
        return !$bool ? "Commencer à travailler" : "Terminer de travailler";
    }
}