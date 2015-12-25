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

function usernameFormatter(value, row) {
	return "<a href='/admin/user/"+ row.id +"/view'>"+ row.username +"</a>";
}
//# sourceMappingURL=admin.js.map