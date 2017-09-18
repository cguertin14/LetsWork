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

    Route::get('/profile/{slug}','ProfileController@view', ['as' => 'user']);
    Route::patch('/profile/{slug}/update','ProfileController@update', ['as' => 'user']);
    Route::patch('/profile/uploadphoto','ProfileController@uploadphoto', ['as' => 'user']);
    Route::get('/profile/getphoto','ProfileController@getphoto', ['as' => 'user']);
    Route::resource('company', 'CompanyController');

});
