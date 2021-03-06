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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

$resources = ['only' => ['create', 'edit', 'destroy', 'store', 'update', 'index']];

/* Basic Routes */
Route::get('/', 'OtherController@homepage')->name('homepage.content');
Route::get('/aboutus', 'OtherController@aboutus')->name('information.aboutus');
//Route::get('/userguide', 'OtherController@userguide')->name('information.userguide');
//Route::get('/termsofservice', 'OtherController@termsofservice')->name('information.termsofservice');

/* JobOffer Routes */
Route::resource('/joboffer', 'JobOfferController');

/* Company Routes */
Route::get('/company/names','CompanyController@names')->name('company.names');
Route::resource('company', 'CompanyController');
Route::get('/cpage', 'CompanyController@cpage')->name('company.cpage');
Route::post('/company/{slug}/sort', 'CompanyController@sort')->name('company.sort');
Route::post('/company/sort', 'CompanyController@sortCompanies')->name('company.sortCompanies');

/* Auth Routes */
Auth::routes();
Route::post('/login/facebook','FacebookAuthController@login')->name('facebook_login')->middleware('guest');

/* UNAUTHENTICATED PUNCHES ROUTES. */
Route::post('/punch/clockout', 'PunchController@clockOut')->name('clockOut');

Route::group(['middleware' => 'auth'], function () use ($resources) {
	/* Profile Routes */
	Route::get('/profile/{slug}', 'ProfileController@view')->name('profile.view');
	Route::get('/profile/{slug}/edit', 'ProfileController@edit')->name('profile.edit');
	Route::patch('/profile/{slug}/update', 'ProfileController@update')->name('profile.update');
	Route::patch('/profile/uploadphoto', 'ProfileController@uploadphoto')->name('profile.uploadphoto');
	Route::get('/profile/{slug}/photo', 'ProfileController@photo')->name('profile.photo');
	Route::delete('/profile/{slug}/delete', 'ProfileController@deleteuser')->name('profile.delete');

	/* Company Routes */
	Route::post('/company/{slug}/select', 'CompanyController@select')->name('company.select');
	Route::post('/company/uploadphoto', 'CompanyController@uploadphoto')->name('company.uploadphoto');

    /* Absence Routes */
    Route::resource('absence', 'AbsenceController',['only' => ['update','create','store','destroy','index']])->middleware('employee');
    Route::post('/absence/sort','AbsenceController@sort')->name('absence.sort');

	/* Special Roles Routes */
	Route::resource('specialrole', 'SpecialRoleController', $resources)->middleware('employee');
	Route::post('/specialroles/sort', 'SpecialRoleController@sort')->name('specialroles.sort')->middleware('employee');

	/* Dispo Routes */
	Route::get('/dispo', 'DispoController@index')->name('dispo.index');
	Route::get('/dispo/create', 'DispoController@create')->name('dispo.create');
	Route::post('/dispo', 'DispoController@store')->name('dispo.store');
	Route::delete('/dispo/{id}', 'DispoController@destroy')->name('dispo.destroy');
	Route::post('/dispo/sort', 'DispoController@sort')->name('dispo.sort');

	/* Skills Routes */
	Route::resource('skill', 'SkillController', $resources)->middleware('employee');
	Route::post('/skills/sort', 'SkillController@sort')->name('skills.sort')->middleware('employee');

	/* Cv Routes */
	Route::get('/cv/create', 'CvController@create')->name('cv.create');
	Route::get('/cv', 'CvController@getAuthCv')->name('cv.get');
	Route::post('/cv/store', 'CvController@store')->name('cv.store');

	/* JobOffer Routes (suite...) */
	Route::post('/joboffer/lettre', 'JobOfferController@lettre')->name('joboffer.lettre');
	Route::post('/joboffer/{slug}/apply', 'JobOfferController@apply')->name('joboffer.apply');
	Route::post('/joboffers/sort', 'JobOfferController@sort')->name('joboffer.sort');
	Route::post('/joboffers/unsort', 'JobOfferController@unsort')->name('joboffer.unsort');

	/* JobOfferUser Routes -> USING HIGH RANKED MIDDLEWARE  */
	Route::get('/jobofferuser', 'JobOfferUserController@index')->name('jobofferuser.index');
	Route::get('/jobofferuser/{id}', 'JobOfferUserController@show')->name('jobofferuser.show');
	Route::post('/jobofferuser/{id}/accept', 'JobOfferUserController@accept')->name('jobofferuser.accept');
	Route::post('/jobofferuser/{id}/interview', 'JobOfferUserController@interview')->name('jobofferuser.interview');
	Route::delete('/jobofferuser/{id}/refuse', 'JobOfferUserController@refuse')->name('jobofferuser.refuse');
	Route::post('/jobofferuser/sort', 'JobOfferUserController@sort')->name('jobofferuser.sort');

	/* Schedule Routes -> USING EMPLOYEE MIDDLEWARE */
	Route::get('/schedule/week/{datebegin}', 'ScheduleController@week')->name('schedule.week');
	Route::get('/schedule/scheduleelement', 'ScheduleController@createelement')->name('schedule.createelement');
	Route::post('/schedule/scheduleelement', 'ScheduleController@storeelement')->name('schedule.storeelement');
	Route::get('/schedule/editing', 'ScheduleController@editing')->name('schedule.editing');
	Route::get('/schedule/employees/{specialrole}', 'ScheduleController@getEmployees')->name('schedule.employees');
	Route::resource('/schedule', 'ScheduleController', $resources);

	/* Punch Routes */
    Route::post('/punch', 'PunchController@add');
    Route::get('/punch/{id}', 'PunchController@getPunch')->name('getPunch');
	Route::get('/punches', 'PunchController@index')->name('punch');
    Route::get('/punches/employees', 'PunchController@employees')->name('punch.employees');
	Route::get('/punches/lastweek/{id}', 'PunchController@lastweek');
    Route::get('/punches/lasttwoweeks/{id}', 'PunchController@lastTwoWeeks');
	Route::get('/punches/lastmonth/{id}', 'PunchController@lastmonth');
	Route::get('/punches/lastyear/{id}', 'PunchController@lastyear');
	Route::post('/punches/sort', 'PunchController@sort')->name('punches.sort');
	Route::get('/punches/employees/names','PunchController@employeesNames')->name('punches.employees');
    Route::get('/punches/sort/employees/{name}', 'PunchController@sortEmployeesByName')->name('punches.sortEmployeesByName');
    Route::get('/punches/employees/index','PunchController@employeesIndex')->name('punches.employeesIndex');
    Route::get('/punches/employee/{id}','PunchController@employee')->name('punches.employee');
    Route::post('/punches/sort/employees', 'PunchController@sortEmployees')->name('punches.sortEmployees');
    Route::post('/punches/sort/employee', 'PunchController@sortEmployee')->name('punches.sortEmployee');

	/* Other Routes */
	Route::get('/isauthmanager', 'OtherController@userIsManager')->middleware('employee');

	/* Chat Routes*/
	//Route::get('/chat', 'ChatController@index')->name('chat');
	//Route::post('/savemessages', 'ChatController@save');
	//Route::get('/lastmessages', 'ChatController@last');

	/* Employee Routes */
	Route::get('/employees/names','EmployeeController@employeesNames')->name('employees.names');
    Route::get('/employees/all','EmployeeController@employeesAll')->name('employees.employeesAll');
    Route::get('/employees/sort/{keyword}','EmployeeController@sortEmployees')->name('employees.sort');
	Route::resource('/employees','EmployeeController',$resources);
});