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
		'create'	=> [
			SCHOOL_LEVEL
		],
		'delete'	=> SCHOOL_LEVEL,
		'update'	=> TEACHER_LEVEL,
		'read' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
	],

	'class-subject' => [
		'create'	=> SCHOOL_LEVEL,
		'delete'	=> SCHOOL_LEVEL,
		'update'	=> SCHOOL_LEVEL,
		'read'		=> STUDENT_LEVEL,
		'manage'	=> TEACHER_LEVEL
	],

	'class-subject-exam' => [
		'create'	=> TEACHER_LEVEL,
		'delete'	=> TEACHER_LEVEL,
		'read'		=> STUDENT_LEVEL,
		'manage'	=> TEACHER_LEVEL
	],

	'class-subject-exam-user' => [
		'create'	=> TEACHER_LEVEL,
		'delete'	=> TEACHER_LEVEL,
		'read'		=> TEACHER_LEVEL,
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
		'update'	=> SCHOOL_LEVEL,
		'read'		=> SCHOOL_LEVEL,
	],

	'school-code' => [
		'create'	=> [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
		'delete'	=> SCHOOL_LEVEL,
		'read'		=> TEACHER_LEVEL,
		'manage'	=> [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		]
	],

	'subject-schedule' => [
		'create'	=> SCHOOL_LEVEL,
		'delete'	=> SCHOOL_LEVEL,
		'update'	=> SCHOOL_LEVEL,
		'read'		=> STUDENT_LEVEL,
		'manage'	=> SCHOOL_LEVEL,
	],

	'class-section-code' => [
		'create'	=> [
			TEACHER_LEVEL, 
			SCHOOL_LEVEL,
		],
		'delete'	=> SCHOOL_LEVEL,
		'update'	=> SCHOOL_LEVEL,
		'read'		=> TEACHER_LEVEL,
		'manage'	=> [
			TEACHER_LEVEL,
			SCHOOL_LEVEL,
		],
	],

	'exam' => [
		'create' => [
			TEACHER_LEVEL
		],
		'delete' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
		'update' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
		'read' => [
			STUDENT_LEVEL,
			SCHOOL_LEVEL,
			TEACHER_LEVEL
		],
		'manage' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
		'take' => STUDENT_LEVEL
	],

	'exam-question' => [
		'create' => [
			TEACHER_LEVEL
		],
		'delete' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
		'update' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
		'read' => [
			SCHOOL_LEVEL,
			TEACHER_LEVEL
		],
		'manage' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
	],

	'exam-question-answer' => [
		'create' => [
			TEACHER_LEVEL
		],
		'delete' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
		'update' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
		'read' => [
			SCHOOL_LEVEL,
			TEACHER_LEVEL
		],
		'manage' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
	],

	'assessment' => [
		'create' => [
			TEACHER_LEVEL
		],
		'delete' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
		'update' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
		'read' => [
			STUDENT_LEVEL,
			SCHOOL_LEVEL,
			TEACHER_LEVEL
		],
		'manage' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
	],

	'attendance' => [
		'create' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
		'delete' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
		'update' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
		'read' => [
			STUDENT_LEVEL,
			SCHOOL_LEVEL,
			TEACHER_LEVEL
		],
		'manage' => [
			TEACHER_LEVEL,
			SCHOOL_LEVEL
		],
	],

	'my-class' => [
		'read' => TEACHER_LEVEL
	],


];