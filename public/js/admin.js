function actionUserFormatter(value, row) {
	return ["<a href='/admin/user/"+ row.id +"/view' class='btn btn-default btn-xs' title='View' data-toggle='tooltip'><i class='fa fa-eye'></i></a>",
			"<a href='/admin/user/"+ row.id +"/edit' class='btn btn-default btn-xs' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>",
			"<a href='/admin/user/"+ row.id +"/delete' class='btn btn-default btn-xs' title='Delete' data-toggle='tooltip' onclick='return confirm(\"Are you sure you want to delete this user?\")'><i class='fa fa-remove'></i></a>"].join(" ");
}

function actionGroupFormatter(value, row) {
	return ["<a href='/admin/group/"+ row.id +"/view' class='btn btn-default btn-xs' title='View' data-toggle='tooltip'><i class='fa fa-eye'></i></a>",
			"<a href='/admin/group/"+ row.id +"/edit' class='btn btn-default btn-xs' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>",
			"<a href='/admin/group/"+ row.id +"/delete' class='btn btn-default btn-xs' title='Delete' data-toggle='tooltip' onclick='return confirm(\"Are you sure you want to delete this group?\")'><i class='fa fa-remove'></i></a>"].join(" ");
}

function actionSchoolFormatter(value, row) {
	return ["<a href='/admin/school/"+ row.id +"/view' class='btn btn-default btn-xs' title='View' data-toggle='tooltip'><i class='fa fa-eye'></i></a>",
			"<a href='/admin/school/"+ row.id +"/edit' class='btn btn-default btn-xs' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>",
			"<a href='/admin/school/"+ row.id +"/delete' class='btn btn-default btn-xs' title='Delete' data-toggle='tooltip' onclick='return confirm(\"Are you sure you want to delete this school?\")'><i class='fa fa-remove'></i></a>"].join(" ");
}

function actionSubjectFormatter(value, row) {
	return ["<a href='/admin/subject/"+ row.id +"/view' class='btn btn-default btn-xs' title='View' data-toggle='tooltip'><i class='fa fa-eye'></i></a>",
			"<a href='/admin/subject/"+ row.id +"/grade_components' class='btn btn-default btn-xs' title='Grade Components' data-toggle='tooltip'><i class='fa fa-pie-chart'></i></a>",
			"<a href='/admin/subject/"+ row.id +"/edit' class='btn btn-default btn-xs' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>",
			"<a href='/admin/subject/"+ row.id +"/delete' class='btn btn-default btn-xs' title='Delete' data-toggle='tooltip' onclick='return confirm(\"Are you sure you want to delete this subject?\")'><i class='fa fa-remove'></i></a>"].join(" ");
}

function actionAchievementFormatter(value, row) {
	return ["<a href='/admin/achievement/"+ row.id +"/view' class='btn btn-default btn-xs' title='View' data-toggle='tooltip'><i class='fa fa-eye'></i></a>",
			"<a href='/admin/achievement/"+ row.id +"/edit' class='btn btn-default btn-xs' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>",
			"<a href='/admin/achievement/"+ row.id +"/delete' class='btn btn-default btn-xs' title='Delete' data-toggle='tooltip' onclick='return confirm(\"Are you sure you want to delete this achievement?\")'><i class='fa fa-remove'></i></a>"].join(" ");
}

function actionMemberSchoolFormatter(value, row) {
	return ["<a href='/admin/school/member/"+ row.id +"/delete' class='btn btn-default btn-xs' title='Delete' data-toggle='tooltip' onclick='return confirm(\"Are you sure you want to delete this school member?\")'><i class='fa fa-remove'></i></a>"].join(" ");
}

function actionExamTypeFormatter(value, row) {
	return ["<a href='/admin/exam/type/delete/"+ row.id +"' class='btn btn-default btn-xs' title='Delete' data-toggle='tooltip' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fa fa-remove'></i></a>"].join(" ");
}

function actionAssessmentFormatter(value, row) {
	return ["<a href='/admin/assessment/view/"+ row.id +"' class='btn btn-default btn-xs' title='View' data-toggle='tooltip'><i class='fa fa-eye'></i></a>"].join(" ");
}

function assessmentCategoryFormatter(value, row) {
	return ["<a href='/admin/assessment/category/edit/"+ row.id +"' class='btn btn-default btn-xs' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>",
			"<a href='/admin/assessment/category/delete/"+ row.id +"' class='btn btn-default btn-xs' title='Delete' data-toggle='tooltip' onclick='return confirm(\"Are you sure you want to delete this achievement?\")'><i class='fa fa-remove'></i></a>"].join(" ");
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

function verificationStatusFormatter(value, row) {
	return row.status == 1 ? '<span class="text-success">Active</span>' : '<span value="text-muted">Inactive</span>';
}

function colorFormatter(value, row) {
	return '<div style="background: '+ row.color +'">'+ row.color +'</div>';
}

$(function() {
	$('[data-toggle="table"]').on('load-success.bs.table', function() {
		$('[data-toggle="tooltip"]').tooltip();
	});

	$('[data-toggle="color-picker"]').minicolors({
		animationSpeed: 50,
        animationEasing: 'swing',
        change: null,
        changeDelay: 0,
        control: 'hue',
        dataUris: true,
        defaultValue: '',
        format: 'hex',
        hide: null,
        hideSpeed: 100,
        inline: false,
        keywords: '',
        letterCase: 'lowercase',
        opacity: false,
        position: 'bottom left',
        show: null,
        showSpeed: 100,
        theme: 'bootstrap'
	});

	var subject_id = $('#gradeComponentChart').data('subject-id');

	$.get('/admin/grade/component/data/'+ subject_id, function(data) {
		var ctx = $('#gradeComponentChart').get(0).getContext("2d");
		var gradeComponentChart = new Chart(ctx).Pie(data);
	});
});

//# sourceMappingURL=admin.js.map
