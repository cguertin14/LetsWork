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

    public function store(Request $request)
    {
        $data = Auth::user();
        $data['cv'] = $request->all();
        // Encrypter le fichier en base 64 et le stocker dans la bd
    }

    public function update(Request $request)
    {

    }
}
