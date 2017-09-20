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

Route::get('/', ['as' => 'homepage.content', function () {
    return view('homepage.content');
}]);

Auth::routes();

Route::group(['middleware' => 'ConnectedUserOnly'], function() {

    /* Profile Routes */
    Route::get('/profile/{slug}','ProfileController@view')->name('profile.view');
    Route::patch('/profile/{slug}/update','ProfileController@update')->name('profile.update');
    Route::patch('/profile/uploadphoto','ProfileController@uploadphoto')->name('profile.uploadphoto');
    Route::get('/profilephoto','ProfileController@photo')->name('profile.photo');
    Route::resource('company', 'CompanyController');
    Route::get('/company/{slug}/absence','CompanyController@absence')->name('company.absence');

});
