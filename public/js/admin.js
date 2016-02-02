Chart.defaults.global.responsive = true;

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

function quarterCalendarActionFormatter(value, row) {
	return ["<a href='/admin/quarter_calendar/view/"+ row.school_year +"' class='btn btn-default btn-xs' title='View' data-toggle='tooltip'><i class='fa fa-eye'></i></a>",
			"<a href='/admin/quarter_calendar/edit/"+ row.school_year +"' class='btn btn-default btn-xs' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>",
			"<a href='/admin/quarter_calendar/delete/"+ row.school_year +"' class='btn btn-default btn-xs' title='Delete' data-toggle='tooltip' onclick='return confirm(\"Are you sure you want to delete this quarter calendar?\")'><i class='fa fa-remove'></i></a>"].join(" ");
}

function actionGradeComponentFormatter(value, row) {
	return ["<a href='/admin/grade/component/edit/"+ row.id +"' class='btn btn-default btn-xs' title='Edit' data-toggle='tooltip'><i class='fa fa-pencil'></i></a>",
			"<a href='/admin/grade/component/delete/"+ row.id +"' class='btn btn-default btn-xs' title='Delete' data-toggle='tooltip' onclick='return confirm(\"Are you sure you want to delete this quarter calendar?\")'><i class='fa fa-remove'></i></a>"].join(" ");
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

function schoolMemberSchoolNameFormatter(value, row) {
	if (row.school_member != null) {
		return row.school_member.school.name;
	} else {
		return '<span class="text-muted">No School</span>';
	}
}

function verificationStatusFormatter(value, row) {
	return row.status == 1 ? '<span class="text-success">Active</span>' : '<span value="text-muted">Inactive</span>';
}

function colorFormatter(value, row) {
	return '<div style="background: '+ row.color +'">'+ row.color +'</div>';
}

function schoolYearFormatter(value, row) {
	return row.school_year +' - '+ (row.school_year+1);
}

function achievementIconFormatter(value, row) {
	return '<img src="/img/achievements/'+ row.icon +'" alt="" width="50">';
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

	$('[data-toggle="chart"]').each(function(value, element) {
		var target = $(this).data('target');
		var url = $(this).data('url');
		var type = $(this).data('type');
		chartjs(target, url, type);
	});

	$.get('/admin/grade/component/data/'+ subject_id, function(data) {
		var ctx = $('#gradeComponentChart').get(0).getContext("2d");
		var gradeComponentChart = new Chart(ctx).Pie(data);
	});
});



function chartjs(target, url, type) {
    var $this = $(target);

    $.get(url, function(data) {
        var ctx = $this.get(0).getContext("2d");
        var options = {
            pointHitDetectionRadius: 100
        }

        if (data.datasets[0].hasOwnProperty('data')) {
            if (type == 'line') {
                new Chart(ctx).Line(data, options);
            } else
            if (type == 'bar') {
                new Chart(ctx).Bar(data, options);
            } else
            if (type == 'radar') {
                new Chart(ctx).Radar(data, options);
            } else
            if (type == 'polararea') {
                new Chart(ctx).PolarArea(data, options);
            } else
            if (type == 'pie') {
                new Chart(ctx).Pie(data, options);
            } else
            if (type == 'doughnut') {
                new Chart(ctx).Doughnut(data, options);
            }
        }
    });
}

//# sourceMappingURL=admin.js.map
