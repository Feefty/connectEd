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

Route::get('', 'HomeController@getIndex');
Route::get('home', 'HomeController@getIndex');
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');
Route::get('logout', 'Auth\AuthController@getLogout');
Route::get('user/{username}', 'ProfileController@getUser')->where(['username' => '[a-zA-Z0-9]+']);

Route::group(['middleware' => 'auth'], function()
{
	// Settings
	Route::controller('settings', 'SettingsController');

	Route::get('profile', 'ProfileController@getIndex');
	Route::get('achievement', 'AchievementController@getIndex');
	Route::get('achievement/api/{studentid?}', 'AchievementController@getAPI')->where(['studentid' => '[0-9]+']);

	// My Class
	Route::controller('myclass', 'MyClassController');

	// Class Section Code
	Route::controller('class/section/code', 'ClassSectionCodeController');

	// Class Section
	Route::controller('class/section', 'ClassSectionController');

	// Class Subject Exam User
	Route::controller('class/subject/exam/user', 'ClassSubjectExamUserController');

	// Class Subject Exam
	Route::controller('class/subject/exam', 'ClassSubjectExamController');

	// School Member
	Route::controller('school/member', 'SchoolMemberController');

	// School Code
	Route::controller('verification/code', 'VerificationCodeController');

	// Class Student
	Route::controller('class/student', 'ClassStudentController');

	// Class Subject Lesson
	Route::controller('class/subject/lesson', 'ClassSubjectLessonController');

	// Subject Schedule
	Route::controller('class/subject/schedule', 'SubjectScheduleController');

	// Class Subject
	Route::controller('class/subject', 'ClassSubjectController');

	// Attendance
	Route::controller('attendance', 'AttendanceController');

	// Assessment
	Route::controller('assessment', 'AssessmentController');

	// Room
	Route::controller('myroom', 'RoomController');

	// Notification
	Route::controller('notification', 'NotificationController');

	// Lesson
	Route::controller('lesson', 'LessonController');

	// Exam Question Answer
	Route::controller('exam/question/answer', 'ExamQuestionAnswerController');

	// Exam Question
	Route::controller('exam/question', 'ExamQuestionController');

	// Exam
	Route::controller('exam', 'ExamController');

	Route::get('school/{school_id}', 'SchoolController@getIndex')->where(['id' => '[0-9]+']);
	Route::controller('school', 'SchoolController');

	Route::controller('page', 'PageController');

	Route::controller('parent', 'ParentController');

	Route::controller('grade_summary', 'GradeSummaryController');

	Route::controller('message', 'MessageController');
	Route::get('m/{username}', 'MessageController@getView');

	Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function()
	{
		Route::get('dashboard', 'DashboardController@getIndex');
		Route::get('user', 'UserController@getIndex');
		Route::post('user/add', 'UserController@postAdd');
		Route::get('user/api', 'UserController@getAPI');
		Route::get('user/{id}/view', 'UserController@getView')->where(['id' => '[0-9]+']);
		Route::get('user/{id}/edit', 'UserController@getEdit')->where(['id' => '[0-9]+']);
		Route::get('user/{id}/delete', 'UserController@getDelete')->where(['id' => '[0-9]+']);
		Route::post('user/edit/account', 'UserController@postEditAccount');
		Route::post('user/edit/profile', 'UserController@postEditProfile');
		Route::get('group', 'GroupController@getIndex');
		Route::get('group/api', 'GroupController@getAPI');
		Route::post('group/add', 'GroupController@postAdd');
		Route::get('group/{id}/view', 'GroupController@getView')->where(['id' => '[0-9]+']);
		Route::get('group/{id}/edit', 'GroupController@getEdit')->where(['id' => '[0-9]+']);
		Route::get('group/{id}/delete', 'GroupController@getDelete')->where(['id' => '[0-9]+']);
		Route::post('group/edit', 'GroupController@postEdit');
		Route::get('school', 'SchoolController@getIndex');
		Route::get('school/api', 'SchoolController@getAPI');
		Route::post('school/add', 'SchoolController@postAdd');
		Route::get('school/{id}/view', 'SchoolController@getView')->where(['id' => '[0-9]+']);
		Route::get('school/{id}/edit', 'SchoolController@getEdit')->where(['id' => '[0-9]+']);
		Route::get('school/{id}/delete', 'SchoolController@getDelete')->where(['id' => '[0-9]+']);
		Route::post('school/edit', 'SchoolController@postEdit');
		Route::post('school/member/add', 'SchoolController@postAddMember');
		Route::get('school/member/api/{school_id}', 'SchoolController@getMemberAPI')->where(['id' => '[0-9]+']);
		Route::get('school/member/{id}/delete', 'SchoolController@getDeleteMember')->where(['id' => '[0-9]+']);
		Route::get('subject', 'SubjectController@getIndex');
		Route::get('subject/api', 'SubjectController@getAPI');
		Route::post('subject/add', 'SubjectController@postAdd');
		Route::get('subject/{id}/view', 'SubjectController@getView')->where(['id' => '[0-9]+']);
		Route::get('subject/{id}/edit', 'SubjectController@getEdit')->where(['id' => '[0-9]+']);
		Route::get('subject/{id}/delete', 'SubjectController@getDelete')->where(['id' => '[0-9]+']);
		Route::get('subject/{id}/grade_components', 'SubjectController@getGradeComponents')->where(['id' => '[0-9]+']);
		Route::post('subject/edit', 'SubjectController@postEdit');
		Route::get('achievement', 'AchievementController@getIndex');
		Route::get('achievement/api', 'AchievementController@getAPI');
		Route::post('achievement/add', 'AchievementController@postAdd');
		Route::get('achievement/{id}/view', 'AchievementController@getView')->where(['id' => '[0-9]+']);
		Route::get('achievement/{id}/edit', 'AchievementController@getEdit')->where(['id' => '[0-9]+']);
		Route::get('achievement/{id}/delete', 'AchievementController@getDelete')->where(['id' => '[0-9]+']);
		Route::post('achievement/edit', 'AchievementController@postEdit');


		Route::controller('assessment/category', 'AssessmentCategoryController');

		// Page
		Route::get('page', 'PageController@getIndex');

		// Exam Type
		Route::controller('exam/type', 'ExamTypeController');

		// Exam
		Route::controller('exam', 'ExamController');

		Route::controller('grade/component', 'GradeComponentController');

		Route::controller('configuration', 'ConfigurationController');

		Route::controller('quarter_calendar', 'QuarterCalendarController');
	});
});
