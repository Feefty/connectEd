<?php 

// 0 = guest
// 1 = student
// 2 = teacher
// 25 = school
// 99 = admin/deped

return [

	'user' => [
		'create'	=> 99,
		'update'	=> 99,
		'delete'	=> 99,
		'read'		=> 99,
		'api'		=> 99,
	],

	'settings' => [
		'profile'	=> 0,
		'password'	=> 0,
		'email'		=> 0,
		'privacy'	=> 0
	],

	'dashboard' => [
		'read'		=> 25,
	],

	'group' => [
		'create'	=> 99,
		'update'	=> 99,
		'delete'	=> 99,
		'read'		=> 99,
		'api'		=> 99,
	],

	'school' => [
		'create'	=> 99,
		'update'	=> 99,
		'delete'	=> 99,
		'read'		=> 99,
		'api'		=> 99,
		'read-member'	=> 5,
		'add-member'	=> 5,
		'delete-member'	=> 25,
	],

	'subject' => [
		'create'	=> 99,
		'update'	=> 99,
		'delete'	=> 99,
		'read'		=> 99,
		'api'		=> 99,
	],

	'achievement' => [
		'create'	=> 99,
		'update'	=> 99,
		'delete'	=> 99,
		'read'		=> 99,
		'api'		=> 99,
	],

	'student-achievement' => [
		'create'	=> 5
	],

	'class-section' => [
		'create'	=> 25,
		'delete'	=> 25,
		'update'	=> 5,
		'read'		=> 5,
	],

	'class-subject' => [
		'create'	=> 25,
		'delete'	=> 25,
		'update'	=> 5,
		'read'		=> 5,
		'manage'	=> 5
	],

	'class-student' => [
		'create'	=> 25,
		'delete'	=> 25,
		'update'	=> 5,
		'read'		=> 5,
	],

	'student-class' => [
		'read'		=> 2,
		'add'		=> 5,
	],

	'school-member' => [
		'create'	=> 25,
		'delete'	=> 25,
		'update'	=> 5,
		'read'		=> 5,
	],

	'subject-schedule' => [
		'create'	=> 25,
		'delete'	=> 25,
		'update'	=> 25,
		'read'		=> 5,
	]

];