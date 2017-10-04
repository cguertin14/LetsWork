<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\User;

Route::get('/', ['as' => 'homepage.content', function () {
    return view('homepage.content');
}]);

Route::get('/aboutus', ['as' => 'about.us', function () {
    return view('about.us');
}]);

Auth::routes();

Route::group(['middleware' => 'ConnectedUserOnly'], function() {

    /* Profile Routes */
    Route::get('/profile/{slug}','ProfileController@view')->name('profile.view');
    Route::patch('/profile/{slug}/update','ProfileController@update')->name('profile.update');
    Route::patch('/profile/uploadphoto','ProfileController@uploadphoto')->name('profile.uploadphoto');
    Route::get('/profilephoto','ProfileController@photo')->name('profile.photo');
    Route::delete('/profile/{slug}/delete','ProfileController@deleteuser')->name('profile.delete');

    /* Company Routes */
    Route::post('/company/{slug}/select','CompanyController@select')->name('company.select');

    /*Route::post('/confirmation/ask','ConfirmationController@ask');
    Route::get('/confirmation/dovalidate','ConfirmationController@dovalidate');
    Route::get('/confirmation/docancel','ConfirmationController@docancel');*/

    /* Absence Routes */
    Route::resource('absence','AbsenceController');

    /* Special Roles Routes */
    Route::resource('specialrole','SpecialRoleController');

    Route::resource("dispo","DispoController");

    /* Skills Routes */
    Route::resource('skill','SkillController');
});
Route::resource('company', 'CompanyController');
Route::get('/aboutus', ['as' => 'about.us', function () {
    return view('about.us');
}]);
use App\Company;
Route::get('test',function (){

    $dispos=\App\Tools\Helper::CAvailability()->get(0);
    return $dispos;
});