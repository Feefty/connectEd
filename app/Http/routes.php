<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@getIndex');
Route::get('/home', 'HomeController@getIndex');
Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/register', 'Auth\AuthController@getRegister');
Route::post('/register', 'Auth\AuthController@postRegister');
Route::get('/logout', 'Auth\AuthController@getLogout');

Route::group(['middleware' => 'auth'], function()
{
	Route::get('/settings/profile', 'SettingsController@getProfile');
	Route::post('/settings/profile', 'SettingsController@postProfile');
	Route::get('/settings/password', 'SettingsController@getPassword');
	Route::post('/settings/password', 'SettingsController@postPassword');
	Route::get('/settings/email', 'SettingsController@getEmail');
	Route::post('/settings/email', 'SettingsController@postEmail');
	Route::get('/settings/privacy', 'SettingsController@getPrivacy');
	Route::post('/settings/privacy', 'SettingsController@postPrivacy');
	Route::get('/profile', 'ProfileController@getIndex');
	Route::get('/achievement', 'AchievementController@getIndex');
	Route::get('/achievement/api/{studentid?}', 'AchievementController@getAPI')->where(['studentid' => '[0-9]+']);
	Route::get('/class/section', 'ClassSectionController@getIndex');
	Route::post('/class/section/add', 'ClassSectionController@postAdd');
	Route::get('/class/section/api/{school_id}', 'ClassSectionController@getAPI')->where(['school_id' => '[0-9]+']);
	Route::get('/class/section/view/{school_id}', 'ClassSectionController@getView')->where(['school_id' => '[0-9]+']);
	Route::get('/class/section/edit/{school_id}', 'ClassSectionController@getEdit')->where(['school_id' => '[0-9]+']);
	Route::get('/school/member', 'SchoolMemberController@getIndex');
	Route::get('/school/member/api/{school_id}', 'SchoolMemberController@getAPI')->where(['school_id' => '[0-9]+']);
	Route::post('/school/member/add', 'SchoolMemberController@postAdd');
	Route::get('/school/member/{school_id}/delete', 'SchoolMemberController@getDelete')->where(['school_id' => '[0-9]+']);

	Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function()
	{
		Route::get('/dashboard', 'DashboardController@getIndex');
		Route::get('/user', 'UserController@getIndex');
		Route::post('/user/add', 'UserController@postAdd');
		Route::get('/user/api', 'UserController@getAPI');
		Route::get('/user/{id}/view', 'UserController@getView')->where(['id' => '[0-9]+']);
		Route::get('/user/{id}/edit', 'UserController@getEdit')->where(['id' => '[0-9]+']);
		Route::get('/user/{id}/delete', 'UserController@getDelete')->where(['id' => '[0-9]+']);
		Route::post('/user/edit/account', 'UserController@postEditAccount');
		Route::post('/user/edit/profile', 'UserController@postEditProfile');
		Route::get('/group', 'GroupController@getIndex');
		Route::get('/group/api', 'GroupController@getAPI');
		Route::post('/group/add', 'GroupController@postAdd');
		Route::get('/group/{id}/view', 'GroupController@getView')->where(['id' => '[0-9]+']);
		Route::get('/group/{id}/edit', 'GroupController@getEdit')->where(['id' => '[0-9]+']);
		Route::get('/group/{id}/delete', 'GroupController@getDelete')->where(['id' => '[0-9]+']);
		Route::post('/group/edit', 'GroupController@postEdit');
		Route::get('/school', 'SchoolController@getIndex');	
		Route::get('/school/api', 'SchoolController@getAPI');
		Route::post('/school/add', 'SchoolController@postAdd');
		Route::get('/school/{id}/view', 'SchoolController@getView')->where(['id' => '[0-9]+']);
		Route::get('/school/{id}/edit', 'SchoolController@getEdit')->where(['id' => '[0-9]+']);
		Route::get('/school/{id}/delete', 'SchoolController@getDelete')->where(['id' => '[0-9]+']);
		Route::post('/school/edit', 'SchoolController@postEdit');
		Route::post('/school/member/add', 'SchoolController@postAddMember');
		Route::get('/school/member/api/{school_id}', 'SchoolController@getMemberAPI')->where(['id' => '[0-9]+']);
		Route::get('/school/member/{id}/delete', 'SchoolController@getDeleteMember')->where(['id' => '[0-9]+']);
		Route::get('/subject', 'SubjectController@getIndex');	
		Route::get('/subject/api', 'SubjectController@getAPI');
		Route::post('/subject/add', 'SubjectController@postAdd');
		Route::get('/subject/{id}/view', 'SubjectController@getView')->where(['id' => '[0-9]+']);
		Route::get('/subject/{id}/edit', 'SubjectController@getEdit')->where(['id' => '[0-9]+']);
		Route::get('/subject/{id}/delete', 'SubjectController@getDelete')->where(['id' => '[0-9]+']);
		Route::post('/subject/edit', 'SubjectController@postEdit');
		Route::get('/achievement', 'AchievementController@getIndex');	
		Route::get('/achievement/api', 'AchievementController@getAPI');
		Route::post('/achievement/add', 'AchievementController@postAdd');
		Route::get('/achievement/{id}/view', 'AchievementController@getView')->where(['id' => '[0-9]+']);
		Route::get('/achievement/{id}/edit', 'AchievementController@getEdit')->where(['id' => '[0-9]+']);
		Route::get('/achievement/{id}/delete', 'AchievementController@getDelete')->where(['id' => '[0-9]+']);
		Route::post('/achievement/edit', 'AchievementController@postEdit');
		Route::get('/grade', 'GradeController@getIndex');

		Route::get('/page', 'PageController@getIndex');
	});
});