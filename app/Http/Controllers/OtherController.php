<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OtherController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function homepage()
    {
        if (Auth::check() && !Session::has('CurrentCompany')) {
            if (Auth::user()->employees()->get()->isEmpty() || Auth::user()->companies()->get()->isEmpty()) {
                session()->forget('CurrentCompany');
            } else {
                $companies = Auth::user()->companies()->get();
                if($companies->count() > 0) {
                    session(['CurrentCompany' => $companies->first()]);
                }
                else {
                    $companies = Auth::user()->employees()->get()->map(function ($employee) { return $employee->companies()->get()->unique(); })->first();
                    if($companies != null && $companies->count() > 0) {
                        session(['CurrentCompany' => $companies->first()]);
                    }
                }
            }
        } else if (Auth::check()) {
            if (Auth::user()->employees()->get()->isEmpty() || Auth::user()->companies()->get()->isEmpty()) {
                session()->forget('CurrentCompany');
            }
        }
        return view('homepage.content');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function aboutus()
    {
        return view('information.aboutus');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function termsofservice()
    {
        return view('information.termsofservice');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userguide()
    {
        return view('information.userguide');
    }

    /**
     * @return int
     */
    public function userIsManager()
    {
        return Auth::user()->isOwner() ? 1 : 0;
    }
}
