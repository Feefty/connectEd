function actionUserFormatter(value, row) {
	return ["<a href='/admin/user/"+ row.id +"/view' class='btn btn-default btn-xs'><i class='fa fa-eye'></i> View</a>",
			"<a href='/admin/user/"+ row.id +"/edit' class='btn btn-default btn-xs'><i class='fa fa-pencil'></i> Edit</a>",
			"<a href='/admin/user/"+ row.id +"/delete' class='btn btn-default btn-xs' onclick='return confirm(\"Are you sure you want to delete this user?\")'><i class='fa fa-remove'></i> Delete</a>"].join(" ");
}

function actionGroupFormatter(value, row) {
	return ["<a href='/admin/group/"+ row.id +"/view' class='btn btn-default btn-xs'><i class='fa fa-eye'></i> View</a>",
			"<a href='/admin/group/"+ row.id +"/edit' class='btn btn-default btn-xs'><i class='fa fa-pencil'></i> Edit</a>",
			"<a href='/admin/group/"+ row.id +"/delete' class='btn btn-default btn-xs' onclick='return confirm(\"Are you sure you want to delete this group?\")'><i class='fa fa-remove'></i> Delete</a>"].join(" ");
}

function actionSchoolFormatter(value, row) {
	return ["<a href='/admin/school/"+ row.id +"/view' class='btn btn-default btn-xs'><i class='fa fa-eye'></i> View</a>",
			"<a href='/admin/school/"+ row.id +"/edit' class='btn btn-default btn-xs'><i class='fa fa-pencil'></i> Edit</a>",
			"<a href='/admin/school/"+ row.id +"/delete' class='btn btn-default btn-xs' onclick='return confirm(\"Are you sure you want to delete this school?\")'><i class='fa fa-remove'></i> Delete</a>"].join(" ");
}

function actionSubjectFormatter(value, row) {
	return ["<a href='/admin/subject/"+ row.id +"/view' class='btn btn-default btn-xs'><i class='fa fa-eye'></i> View</a>",
			"<a href='/admin/subject/"+ row.id +"/edit' class='btn btn-default btn-xs'><i class='fa fa-pencil'></i> Edit</a>",
			"<a href='/admin/subject/"+ row.id +"/delete' class='btn btn-default btn-xs' onclick='return confirm(\"Are you sure you want to delete this subject?\")'><i class='fa fa-remove'></i> Delete</a>"].join(" ");
}

function actionAchievementFormatter(value, row) {
	return ["<a href='/admin/achievement/"+ row.id +"/view' class='btn btn-default btn-xs'><i class='fa fa-eye'></i> View</a>",
			"<a href='/admin/achievement/"+ row.id +"/edit' class='btn btn-default btn-xs'><i class='fa fa-pencil'></i> Edit</a>",
			"<a href='/admin/achievement/"+ row.id +"/delete' class='btn btn-default btn-xs' onclick='return confirm(\"Are you sure you want to delete this achievement?\")'><i class='fa fa-remove'></i> Delete</a>"].join(" ");
}

function actionMemberSchoolFormatter(value, row) {
	return ["<a href='/admin/school/member/"+ row.id +"/delete' class='btn btn-default btn-xs' onclick='return confirm(\"Are you sure you want to delete this school member?\")'><i class='fa fa-remove'></i> Delete</a>"].join(" ");
}

function actionExamTypeFormatter(value, row) {
	return ["<a href='/admin/exam/type/delete/"+ row.id +"' class='btn btn-default btn-xs' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fa fa-remove'></i> Delete</a>"].join(" ");
}

function actionAssessmentFormatter(value, row) {
	return ["<a href='/admin/assessment/view/"+ row.id +"' class='btn btn-default btn-xs'><i class='fa fa-eye'></i> View</a>"].join(" ");
}

function usernameFormatter(value, row) {
	return "<a href='/admin/user/"+ row.id +"/view'>"+ row.username +"</a>";
}

function statusFormatter(value, row) {
	return row.status == 1 ? 'Enable' : 'Disable';
}

function assessmentGradeFormatter(value, row) {
	return  row.score +"/"+ row.total +" ("+ Math.round((row.score / row.total) * 100) +" %)";
}

function studentProfileNameFormatter(value, row) {
	var name = ucwords(row.student.profile.first_name) +' '+ ucwords(row.student.profile.last_name);
	return '<a href="/user/'+ row.student.username +'">'+ name +'</a>';
}

function assessedProfileNameFormatter(value, row) {
	var name = ucwords(row.assessed.profile.first_name) +' '+ ucwords(row.assessed.profile.last_name);
	return '<a href="/user/'+ row.assessed.username +'">'+ name +'</a>';
}

function schoolNameFormatter(value, row) {
	return row.school.name;
}

$('[data-toggle="table"]').on('load-success.bs.table', function() {
	$('[data-toggle="tooltip"]').tooltip();
});
//# sourceMappingURL=admin.js.map