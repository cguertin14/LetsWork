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
	$data = \App\Company::where('description', 'like', "%" . $name . "%")
		->orWhere('name', 'like', "%" . $name . "%")
		->forPage($page, 15)
		->get()
		->toJson();
	return $data;
});