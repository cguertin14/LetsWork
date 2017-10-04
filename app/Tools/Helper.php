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
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function CCompany()
    {
        return Company::findBySlugOrFail(session('CurrentCompany'));
    }

    public static function CEmployee()
    {
        return Helper::CCompany()->employees->where('user_id', Auth::user()->id)->get(0);
    }

    public static function CAvailability()
    {
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
}