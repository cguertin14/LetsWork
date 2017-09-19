<?php

namespace App\Http\Controllers;

use App\FileType;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function view($slug)
    {
        if($slug=="photo")
            return  $this->photo();
        
        $user = User::findBySlugOrFail($slug);
        return view('profile.edit',compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->update($request->all());
        return redirect('/');
    }

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

    public function photo() {
        return Auth::user()->photo;
    }
}