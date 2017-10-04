<?php
/**
 * Created by PhpStorm.
 * User: ludov
 * Date: 2017-10-02
 * Time: 19:15
 */

namespace App\Tools;


use App\Availability;
use App\Company;
use App\JobOffer;
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
        $daysofweek_fr=[
            "Lundi",
            "Mardi",
            "Mercredi",
            "Jeudi",
            "Vendredi",
            "Samedi",
            "Dimanche",
        ];
        return $daysofweek_fr[\Carbon\Carbon::parse($carbon)->dayOfWeek-1];
    }

    public static function getJobOfferUserById($id)
    {
        $jobofferuser = null;
        $jobOffers = JobOffer::where('company_id',Company::findBySlugOrFail(session('CurrentCompany'))->id)->get();
        foreach ($jobOffers as $joboffer) {
            if ($joboffer->users) {
                foreach ($joboffer->users as $user)
                    if ($user->pivot->id == $id)
                        $jobofferuser = $user->pivot;
            }
        }
        return $jobofferuser;
    }
}