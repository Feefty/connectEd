var days = [
	'',
	'Monday',
	'Tuesday',
	'Wednesday',
	'Thursday',
	'Friday',
	'Saturday'
];

var gradeLevels = [
	"",
	"Grade 1",
	"Grade 2",
	"Grade 3",
	"Grade 4",
	"Grade 5",
	"Grade 6",
	"1st Year High School",
	"2nd Year High School",
	"3rd Year High School",
	"4th Year High School"
];

$(function() {
	$('#add-more-schedule').on('click', function() {
		$content = $('.schedule-items').first().html();
		$('#schedule-holder').append($content);
	});
});

function usernameFormatter(value, row) {
	return "<a href='/user/"+ row.id +"'>"+ row.username +"</a>";
}

function fullNameFormatter(value, row) {
	return "<a href='/user/"+ row.user_id +"'>"+ row.full_name +"</a>";
}

function actionSchoolMemberFormatter(value, row) {
	return ["<a href='/school/member/"+ row.id +"/delete' class='btn btn-default btn-xs' onclick='return confirm(\"Are you sure you want to delete this school member?\")'><i class='fa fa-remove'></i> Delete</a>"].join(" ");
}

function subjectFormatter(value, row) {
	return ["[", row.code, "] ", row.name, " - ", row.description].join(" ");
}

function actionUpdateClassSectionFormatter(value, row) {
	return ["<a href='/class/section/edit/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Edit'><i class='fa fa-pencil'></i></a>",
			"<a href='/class/section/view/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>"].join(" ");
}

function actionClassSectionFormatter(value, row) {
	return ["<a href='/class/section/edit/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Edit'><i class='fa fa-pencil'></i></a>"].join(" ");
}

function userProfile(value, row) {
	return "<a href='/user/"+ row.username +"'>"+ row.name +"</a>";
}

function actionClassSubjectFormatter(value, row) {
	return ["<a href='/class/subject/edit/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Edit'><i class='fa fa-pencil'></i></a>",
			"<a href='/class/subject/delete/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Delete'><i class='fa fa-remove'></i></a>",
			"<a href='/class/subject/view/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>"].join(" ");
}

function actionClassSubjectScheduleFormatter(value, row) {
	return ["<a href='/class/subject/schedule/edit/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Edit'><i class='fa fa-pencil'></i></a>",
			"<a href='/class/subject/schedule/delete/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Delete'><i class='fa fa-remove'></i></a>"].join(" ");
}

function dayFormatter(value, row) {
	return days[row.day];
}

function gradeLevelFormatter(value, row) {
	return gradeLevels[row.level];
}