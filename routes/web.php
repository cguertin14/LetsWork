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

    Route::get('/profile/{slug}','ProfileController@view')->name('profile.view');
    Route::patch('/profile/{slug}/update','ProfileController@update')->name('profile.update');
    Route::patch('/profile/uploadphoto','ProfileController@uploadphoto')->name('profile.uploadphoto');
    Route::get('/profilephoto','ProfileController@photo')->name('profile.photo');

    Route::post('/confirmation/ask','ConfirmationController@ask');
    Route::get('/confirmation/dovalidate','ConfirmationController@dovalidate');
    Route::get('/confirmation/docancel','ConfirmationController@docancel');

});
//Route::get('/company/delete/{id}/{user_id}','CompanyController@delete');
Route::resource('company', 'CompanyController');

Route::get('/aboutus', ['as' => 'about.us', function () {
    return view('about.us');
}]);