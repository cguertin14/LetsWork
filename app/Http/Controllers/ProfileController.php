<?php

namespace App\Http\Controllers;

use App\FileType;
use App\Http\Requests\ModifyUserRequest;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('profile',['only' => 'edit']);
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($slug)
    {
        $user = User::findBySlugOrFail($slug);
        return view('profile.edit',compact('user'));
    }

    public function view($slug)
    {
        $user = User::findBySlugOrFail($slug);
        return view('profile.show',compact('user'));
    }

    /**
     * @param ModifyUserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ModifyUserRequest $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $errors = false;
        if ($user->email != $data['email']) {
            if (User::query()->where('email',$data['email'])->exists()){
                session()->flash('email_unique','L\'adresse courriel est déjà prise');
                $errors = true;
            } else {
                $user->email = $data['email'];
            }
        } elseif ($user->phone_number != $data['phone_number']) {
            if (User::query()->where('phone_number',$data['phone_number'])->exists()) {
                session()->flash('phone_number_unique','Le numéro de téléphone est déjà pris');
                $errors = true;
            } else {
                $user->phone_number = $data['phone_number'];
            }
        }

        if ($errors) {
            return redirect()->back();
        }

        // Update normal attributes
        $user->last_name = $data['last_name'];
        $user->first_name = $data['first_name'];
        $user->save();

        return redirect('/');
    }

    /**
     * @param Request $request
     */
    public function uploadphoto(Request $request)
    {
        $data = $request->except(['file','_method','_token']);
        $file = $request->file('file');

        // Encode image to base64
        $filedata = file_get_contents($file);
        $data['user_id'] = Auth::user()->id;
        $data['source'] = base64_encode($filedata);

        // Create profile picture in database
        $user = Auth::user();
        if ($user->photo)
            $user->photo()->update($data);
        else {
            $photo = $user->photo()->create($data);
            $user->photo_id = $photo->id;
            $user->save();
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function photo($slug) {
        // return image as base64
        return response()->json(['photo' => User::findBySlugOrFail($slug)->photo]);
    }

    /**
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteuser($slug)
    {
        Auth::logout();
        $user = User::findBySlugOrFail($slug);
        $user->delete();
        session()->flush();
        return redirect('/');
    }
}