<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ConfirmationController extends Controller
{
    public function ask(Request $request)
    {
        $data=$request->all();
        Session::put('todoaction',$data['todoaction']);
        Session::put('parameters_id',$data['id']);
        Session::put('lastaction',$data['lastaction']);
        $text=$data['text'];
        return view('confirmation.show',compact('text'));
    }

    public function dovalidate()
    {
        return redirect()->route(Session::get('todoaction'),
            [Session::get('parameters_id'),'method'=>'DELETE']);
    }

    public function docancel()
    {
        return redirect()->action(Session::get('lastaction'));
    }
}
