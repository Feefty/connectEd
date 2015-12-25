<?php 

// BANNED_LEVEL = banned
// 1 = guest
// 2 = member
// 3 = student
// 5 = teacher
// SCHOOL_LEVEL = school
// ADMIN_LEVEL = admin/deped
// 
define('BANNED_LEVEL', 0);
define('GUEST_LEVEL', 1);
define('MEMBER_LEVEL', 2);
define('STUDENT_LEVEL', 3);
define('TEACHER_LEVEL', 5);
define('SCHOOL_LEVEL', 25);
define('ADMIN_LEVEL', 99);

return [

	'user' => [
		'create'	=> ADMIN_LEVEL,
		'update'	=> ADMIN_LEVEL,
		'delete'	=> ADMIN_LEVEL,
		'read'		=> ADMIN_LEVEL,
		'api'		=> ADMIN_LEVEL,
	],

	'settings' => [
		'profile'	=> BANNED_LEVEL,
		'password'	=> BANNED_LEVEL,
		'email'		=> BANNED_LEVEL,
		'privacy'	=> BANNED_LEVEL
	],

	'dashboard' => [
		'read'		=> SCHOOL_LEVEL,
	],

	'group' => [
		'create'	=> ADMIN_LEVEL,
		'update'	=> ADMIN_LEVEL,
		'delete'	=> ADMIN_LEVEL,
		'read'		=> ADMIN_LEVEL,
		'api'		=> ADMIN_LEVEL,
	],

	'school' => [
		'create'	=> ADMIN_LEVEL,
		'update'	=> ADMIN_LEVEL,
		'delete'	=> ADMIN_LEVEL,
		'read'		=> ADMIN_LEVEL,
		'api'		=> ADMIN_LEVEL,
		'read-member'	=> TEACHER_LEVEL,
		'add-member'	=> TEACHER_LEVEL,
		'delete-member'	=> SCHOOL_LEVEL,
	],

	'subject' => [
		'create'	=> ADMIN_LEVEL,
		'update'	=> ADMIN_LEVEL,
		'delete'	=> ADMIN_LEVEL,
		'read'		=> ADMIN_LEVEL,
		'api'		=> ADMIN_LEVEL,
	],

	'achievement' => [
		'create'	=> ADMIN_LEVEL,
		'update'	=> ADMIN_LEVEL,
		'delete'	=> ADMIN_LEVEL,
		'read'		=> ADMIN_LEVEL,
		'api'		=> ADMIN_LEVEL,
	],

	'lesson' => [
		'create'	=> TEACHER_LEVEL,
		'delete'	=> TEACHER_LEVEL,
		'update'	=> TEACHER_LEVEL,
		'read'		=> STUDENT_LEVEL,
		'manage'	=> TEACHER_LEVEL,
	],

	'student-achievement' => [
		'create'	=> TEACHER_LEVEL
	],

	'my-room' => [
		'read'		=> STUDENT_LEVEL
	],

	'class-section' => [
		'create'	=> SCHOOL_LEVEL,
		'delete'	=> SCHOOL_LEVEL,
		'update'	=> TEACHER_LEVEL,
		'read'		=> TEACHER_LEVEL,
	],

	'class-subject' => [
		'create'	=> SCHOOL_LEVEL,
		'delete'	=> SCHOOL_LEVEL,
		'update'	=> TEACHER_LEVEL,
		'read'		=> STUDENT_LEVEL,
		'manage'	=> TEACHER_LEVEL
	],

	'class-student' => [
		'create'	=> SCHOOL_LEVEL,
		'delete'	=> SCHOOL_LEVEL,
		'update'	=> TEACHER_LEVEL,
		'read'		=> STUDENT_LEVEL,
	],

	'student-class' => [
		'read'		=> STUDENT_LEVEL,
		'add'		=> TEACHER_LEVEL,
	],

	'school-member' => [
		'create'	=> SCHOOL_LEVEL,
		'delete'	=> SCHOOL_LEVEL,
		'update'	=> TEACHER_LEVEL,
		'read'		=> TEACHER_LEVEL,
	],

	'school-code' => [
		'create'	=> SCHOOL_LEVEL,
		'delete'	=> SCHOOL_LEVEL,
		'read'		=> TEACHER_LEVEL,
		'manage'	=> SCHOOL_LEVEL,
	],

	'subject-schedule' => [
		'create'	=> SCHOOL_LEVEL,
		'delete'	=> SCHOOL_LEVEL,
		'update'	=> SCHOOL_LEVEL,
		'read'		=> STUDENT_LEVEL,
		'manage'	=> TEACHER_LEVEL,
	],

	'class-section-code' => [
		'create'	=> SCHOOL_LEVEL,
		'delete'	=> SCHOOL_LEVEL,
		'update'	=> SCHOOL_LEVEL,
		'read'		=> TEACHER_LEVEL,
		'manage'	=> SCHOOL_LEVEL,
	],

	'exam' => [
		'create'	=> SCHOOL_LEVEL,
		'delete'	=> SCHOOL_LEVEL,
		'update'	=> SCHOOL_LEVEL,
		'read'		=> TEACHER_LEVEL,
		'manage'	=> SCHOOL_LEVEL,
	],

	'exam-question' => [
		'create'	=> SCHOOL_LEVEL,
		'delete'	=> SCHOOL_LEVEL,
		'update'	=> SCHOOL_LEVEL,
		'read'		=> TEACHER_LEVEL,
		'manage'	=> SCHOOL_LEVEL,
	],

	'exam-question-answer' => [
		'create'	=> SCHOOL_LEVEL,
		'delete'	=> SCHOOL_LEVEL,
		'update'	=> SCHOOL_LEVEL,
		'read'		=> TEACHER_LEVEL,
		'manage'	=> SCHOOL_LEVEL,
	],


];