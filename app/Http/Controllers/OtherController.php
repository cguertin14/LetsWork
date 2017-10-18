<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OtherController extends Controller
{
    public function homepage()
    {
        if(Auth::check() && Session::has('CurrentCompany'))
        {            
            $companies=\Illuminate\Support\Facades\Auth::user()->companies;
            if($companies->count() == 1)
                session(['CurrentCompany' => $companies->first()]);
        }
        return view('homepage.content');
    }

    public function aboutus()
    {
        return view('information.aboutus');
    }

    public function termsofservice()
    {
        return view('information.termsofservice');
    }
}
