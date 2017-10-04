<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OtherController extends Controller
{
    public function homepage()
    {
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
