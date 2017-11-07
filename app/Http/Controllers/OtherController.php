<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OtherController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function homepage()
    {
        if(Auth::check() && !Session::has('CurrentCompany'))
        {            
            $companies = Auth::user()->companies;
            if($companies->count() == 1)
                session(['CurrentCompany' => $companies->first()]);
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
     * @return int
     */
    public function userIsManager()
    {
        return Auth::user()->isOwner() ? 1 : 0;
    }
}
