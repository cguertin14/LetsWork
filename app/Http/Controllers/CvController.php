<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CvController extends Controller
{
    public function create()
    {
        return view('cv.create');
    }

    public function getAuthCv()
    {
        return response()->json(['cv' => Auth::user()->cv]);
    }

    public function store(Request $request)
    {
        // Encrypter le fichier en base 64 et le stocker dans la bd
        $data = $request->except(['_token']);
        $file = $request->file('file');

        // Encode image to base64
        $filedata = file_get_contents($file);
        $data['cv'] = base64_encode($filedata);

        Auth::user()->update($data);
        return response()->json(['cv' => Auth::user()->cv]);
    }
}
