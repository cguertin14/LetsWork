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

/* Other Routes */

Route::get('/', 'OtherController@homepage')->name('homepage.content');
Route::get('/aboutus', 'OtherController@aboutus')->name('information.aboutus');
Route::get('/termsofservice', 'OtherController@termsofservice')->name('information.termsofservice');

/* JobOffer Routes */
Route::resource('/joboffer', 'JobOfferController');

/* JobOffer Letter Route */
Route::post('/joboffer/lettre', 'JobOfferController@lettre')->name('joboffer.lettre');

/* Company Routes */
Route::resource('company', 'CompanyController');

/* Auth Routes */
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	/* Profile Routes */
	Route::get('/profile/{slug}', 'ProfileController@view')->name('profile.view');
	Route::patch('/profile/{slug}/update', 'ProfileController@update')->name('profile.update');
	Route::patch('/profile/uploadphoto', 'ProfileController@uploadphoto')->name('profile.uploadphoto');
	Route::get('/profilephoto', 'ProfileController@photo')->name('profile.photo');
	Route::delete('/profile/{slug}/delete', 'ProfileController@deleteuser')->name('profile.delete');

	/* Company Routes */
	Route::post('/company/{slug}/select', 'CompanyController@select')->name('company.select');
	Route::post('/company/uploadphoto', 'CompanyController@uploadphoto')->name('company.uploadphoto');

	/* Absence Routes */
	Route::resource('absence', 'AbsenceController');

	/* Special Roles Routes */
	Route::resource('specialrole', 'SpecialRoleController');

	/* Dispo Routes */
	Route::resource('dispo', 'DispoController');

	/* Skills Routes */
	Route::resource('skill', 'SkillController');

	/* Cv Routes */
	Route::get('/cv/create', 'CvController@create')->name('cv.create');
	Route::get('/cv', 'CvController@getAuthCv')->name('cv.get');
	Route::post('/cv/store', 'CvController@store')->name('cv.store');

	/* JobOffer Routes (suite...) */
	Route::post('/joboffer/{slug}/apply', 'JobOfferController@apply')->name('joboffer.apply');

	/* JobOfferUser Routes */
	Route::get('/jobofferuser', 'JobOfferUserController@index')->name('jobofferuser.index');
	Route::get('/jobofferuser/{id}', 'JobOfferUserController@show')->name('jobofferuser.show');
	Route::post('/jobofferuser/{id}/accept', 'JobOfferUserController@accept')->name('jobofferuser.accept');
	Route::post('/jobofferuser/{id}/interview', 'JobOfferUserController@interview')->name('jobofferuser.interview');
	Route::delete('/jobofferuser/{id}/refuse', 'JobOfferUserController@refuse')->name('jobofferuser.refuse');

    /* Schedule Routes */
    Route::get('/schedule/thisweek','ScheduleController@thisweek')->name('schedule.thisweek');
    Route::get('/schedule/week/{datebegin}','ScheduleController@week')->name('schedule.week');
    Route::get('/schedule/scheduleelement','ScheduleController@createelement')->name('schedule.createelement');
    Route::post('/schedule/scheduleelement','ScheduleController@storeelement')->name('schedule.storeelement');
    Route::get('/schedule/editing','ScheduleController@editing')->name('schedule.editing');
    Route::get('/schedule/employees/{specialrole}','ScheduleController@getEmployees')->name('schedule.employees');
    Route::resource('/schedule','ScheduleController');

    /* Punch Routes */
    Route::post('/punch', 'PunchController@add');
    Route::get('/punches', 'PunchController@index')->name('punch');
    Route::get('/punches/lastweek', 'PunchController@lastweek');
    Route::get('/punches/lastmouth', 'PunchController@lastmouth');
    Route::get('/punches/lastyear', 'PunchController@lastyear');

    /* Other Routes */
    Route::get('/isauthmanager','OtherController@userIsManager');
});

Route::get('/test', function () {
	\App\Tools\Mailing::send();
});