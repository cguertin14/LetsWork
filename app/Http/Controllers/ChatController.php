<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * ChatController constructor.
     */
    public function __construct()
    {
        $this->middleware('employee');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('chat.index');
    }

    /**
     * @param Request $request
     */
    public function save(Request $request)
    {
        \App\Message::create([
            'sender_id' => \App\User::where('email', '=', $request->input('message.sender.email'))->first()->id,
            'receiver_id' => \App\User::where('email', '=', $request->input('message.receiver.email'))->first()->id,
            'content' => $request->input('message.message'),
        ]);
    }

    /**
     * @return mixed
     */
    public function last()
    {
        $allm = \App\Message::where('sender_id', '=', Auth::id())->orWhere('receiver_id', '=', Auth::id())->with(['sender:id,name,email', 'receiver:id,name,email'])->get();
        return  $allm->toJson();
    }
}
