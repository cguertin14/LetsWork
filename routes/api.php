<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/* UNAUTHENTICATED PUNCHES ROUTES. */
Route::post('/punch/clockout', 'PunchController@clockOut')->name('clockOut');
Route::post('/punch/ipad/{id}', 'PunchController@addIpad');