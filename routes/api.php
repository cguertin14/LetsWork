<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cpage', function (Request $request) {
    $page = $request->input('page');
    $name = $request->input('name');
    return \App\Company::all(["name", "description"])
//      ->where('description','like', '%'.$name.'%')
        ->forPage($page, 15)
        ->toJson();
});