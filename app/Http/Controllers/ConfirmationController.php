<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ConfirmationController extends Controller
{
    public function askvalidate($request)
    {
        Session::put('ConfirmationRequest',$request);
        return view('confirmation.show');
    }

    public function dovalidate()
    {
        $wait=Session::get('ConfirmationRequest');
        Session::forget('ConfirmationRequest');
        return $wait;
    }

    public function docancel()
    {
        Session::forget('ConfirmationRequest');
        return "canceled";
    }
}
