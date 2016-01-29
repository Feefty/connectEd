String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};

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

var attendanceStatuses = [
	"Absent",
	"Present",
	"Late"
];

var remarks = [
    "Failed",
    "Passed",
    "Dropped"
];

var question_duration;

$(function() {

	$("time.timeago").timeago();
	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
	var isLogged = parseInt($('meta[name="is-logged"]').attr('content')) === 1 ? true : false;

	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="select"]').selectpicker();

	$('#add-more, [data-toggle="add-more"]').on('click', function() {
		var target = $(this).data('target');

		if (target != "undefined") {
			$content = $('[data-id="'+ target +'"]').first().html();
			$('[data-holder="'+ target +'"]').append($content);
		} else {
			$content = $('.add-more-items').first().html();
			$('#add-more-holder').append($content);
		}
	});

	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	    $('.dropdown-menu li.active').removeClass('active');
	    $(this).parent('li').addClass('active');
	});

	$('#attendance [name="date"]').on('change', function() {
		$('#attendance .img-thumbnail')
			.removeClass('bg-danger')
			.removeClass('bg-warning')
			.removeClass('bg-success');
		});

	$('#start-exam').on('click', function(e) {
		var btn = $(this);
		var exam_id = $(this).data('exam-id');
		var class_subject_exam_id = $(this).data('class-subject-exam-id');
		var class_subject_id = $(this).data('class-subject-id');
		var $block = $('#exam-question-block');
		var $answer_block = $('#question-answer-block', $block);
		var $timer = 0;
		var $content_msg = $('#content-msg');
		$('#question-timer').html("");
		// hide the button
		btn.hide();
		// loading icon
		$('#question-block', $block).html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading question...</div>');
		$answer_block.hide();

		var examTimer = setInterval(function() {
			$timer++;
		}, 1000);

		$.get('/class/subject/exam/question/'+ exam_id, function(data) {
			// fetch the question
			var $question = data;
			var $answer_formatted;

			if ($question === undefined || ! $question) {
				getExamGrade(exam_id);
				return;
			}

			// loeading icon
			$answer_block.html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading answers...</div>');
			var time_limit = parseInt($question.time_limit);

			// answers for multiple choice category
			if ($question.category == 'multiplechoice' || $question.category == 'fillintheblank') {
				$.get('/class/subject/exam/answer/'+ $question.id, function(data_answer) {

					if ($question.category == 'multiplechoice') {
						$answer_formatted = "<ul class='list-unstyled'>";

						$.each(data_answer, function(key, value) {
							$answer_formatted += "<li><label><input type='radio' name='answer' value='"+ value.answer +"'> "+ value.answer +"</label></li>";
						});

						$answer_formatted += "</ul>";
					}
					else {
						$answer_formatted = "<ul class='list-unstyled'>";

						for (var i = 0; i < parseInt(data_answer); i++) {
							$answer_formatted += "<li><input type='text' name='answer[]' class='form-control'></li>";
						}

						$answer_formatted += "</ul class='list-unstyled>";
					}

					// display the answers format
					$answer_block.html($answer_formatted).hide().fadeIn();
					$answer_block.append("<button type='button' onclick='submitAnswer("+ $timer +", "+ $question.id +", "+ class_subject_exam_id +", \""+ $question.category +"\", "+ class_subject_id +")' class='btn btn-success'>Submit Answer</button>");

				});
			}
			else {
				// answers for true or false category
				if ($question.category == 'trueorfalse') {
					$answer_formatted = "<ul class='list-unstyled'>";
					$answer_formatted += "<li><label><input type='radio' name='answer' value='true'> True</label></li>";
					$answer_formatted += "<li><label><input type='radio' name='answer' value='false'> False</label></li>";
					$answer_formatted += "</ul>";
				}

				// answers for identification category
				if ($question.category == 'identification') {
					$answer_formatted = "<div class='form-group'><input type='text' name='answer' class='form-control'></div>";
				}

				// answers for essay category
				if ($question.category == 'essay') {
					$answer_formatted = "<div class='form-group'><textarea name='answer' class='form-control'></textarea></div>";
				}

				// display the answers format
				$answer_block.html($answer_formatted).hide().fadeIn();
				$answer_block.append("<button type='button' onclick='submitAnswer("+ $timer +", "+ $question.id +", "+ class_subject_exam_id +", \""+ $question.category +"\", "+ class_subject_id +")' class='btn btn-success'>Submit Answer</button>");
			}

			if (time_limit != 0) {
				// start time_limit
				$('#question-block', $block).before("<div id='question-timer'>You have <span id='time-holder' class='text-danger'></span> seconds left to answer.</div>");
				question_duration = setInterval(function() {
					if (time_limit <= 0) {
						clearInterval(question_duration);
						clearInterval(examTimer);

						submitAnswer($timer, $question.id, class_subject_exam_id, $question.category, class_subject_id);
					}
					$('#time-holder').html(time_limit--);
				}, 1000); // every second
			}

			if ($question.category == 'fillintheblank') {
				$question.question = $question.question.replaceAll(':answer', '_______');
			}

			var question_formatted = "<div class='well'>"+ $question.question +"</div>";
			$('#question-block', $block).html(question_formatted).hide().fadeIn();
		});
	});

	$('[data-toggle="table"]').on('load-success.bs.table', function() {
		$('[data-toggle="tooltip"]').tooltip();
	});

	if (isLogged) {
		var notif_data, notif_num;
		$.get('/notification/api', function(data) {
			notif_data = data;
			notif_num = notif_data.length;

			if (notif_num > 0) {
				$('.notification-icon').html("<span class='badge'>"+ data.length +"</span>");

				var notif_html = "<li class='notification-title'><strong>Notifications</strong><span class='text-underline pull-right text-warning mark-as-read' onClick='readAll()'>Mark all as read</span></li>";

				$.each(notif_data, function(key, val) {
					if (val.url != "") {
						notif_html += "<li><a href="+ val.url +"><strong>"+ val.subject +"</strong><br>"+ val.content +"<br><span class='small'><i class='fa fa-clock'></i><time class='timeago' datetime='"+ val.created_at +"'>"+ val.created_at +"</time></span></a></li>";
					}
					else {
						notif_html += "<li><a href='javsacript:void(0)'><strong>"+ val.subject +"</strong><br>"+ val.content +"<br><span class='small'><i class='fa fa-clock'></i><time class='timeago' datetime='"+ val.created_at +"'>"+ val.created_at +"</time></span></a></li>";
					}
				});

				$('.notification-holder').html(notif_html);
			}
		});

		setInterval(function() {
			$.get('/notification/api', function(data) {
				notif_data = data;

				if (notif_num != notif_data.length) {
					notif_num = notif_data.length;

					if (notif_num > 0) {
						var notif_html = "<li class='notification-title'><strong>Notifications</strong><span class='text-underline pull-right text-warning mark-as-read' onClick='readAll()'>Mark all as read</span></li>";

						$('.notification-icon').html("<span class='badge'>"+ notif_data.length +"</span>");

						$.each(notif_data, function(key, val) {
							if (val.url != "") {
								notif_html += "<li><a href="+ val.url +"><strong>"+ val.subject +"</strong><br>"+ val.content +"<br><span class='small'><i class='fa fa-clock'></i><time class='timeago' datetime='"+ val.created_at +"'>"+ val.created_at +"</time></span></a></li>";
							}
							else {
								notif_html += "<li><a href='javsacript:void(0)'><strong>"+ val.subject +"</strong><br>"+ val.content +"<br><span class='small'><i class='fa fa-clock'></i><time class='timeago' datetime='"+ val.created_at +"'>"+ val.created_at +"</time></span></a></li>";
							}
						});

						$('.notification-holder').html(notif_html);
					}
				}
			});
		}, 5000);

        $.get('/message/unread', function(data) {
            var unread = data.unread;

            if (unread > 0) {
                $('#message-icon').text(unread).addClass('text-danger');
            }
        });

        setInterval(function() {
            $.get('/message/unread', function(data) {
                var unread = data.unread;

                if (unread > 0) {
                    $('#message-icon').text(unread).addClass('text-danger');
                }
                else {
                    $('#message-icon').text('').removeClass('text-danger');
                }
            });
        }, 5000);
	}

});

function readAll() {
	$.get('/notification/readall', function() {
		var notif_html = "<li class='notification-title'><strong>Notifications</strong><span class='text-underline pull-right text-warning mark-as-read' onClick='readAll()'>Mark all as read</span></li>";

		$('.notification-holder').html(notif_html);
		$('.notification-icon').html("");
	});
}

function submitAttendance(status, user_id) {
	var date = $('#attendance [name="date"]').val();
	var class_subject_id = $('#attendance [name="class_subject_id"]').val();

	if (date == '') {
		alert('Date is required.');
		return;
	}

	$.post('/attendance/add', { status: status, user_id: user_id, date: date, class_subject_id: class_subject_id }, function(data) {
		$('.attendance-'+ user_id + ' .img-thumbnail')
			.removeClass('bg-danger')
			.removeClass('bg-warning')
			.removeClass('bg-success');

		switch (status) {
			case 0:
				$('.attendance-'+ user_id + ' .img-thumbnail').addClass('bg-danger');
				break;
			case 1:
				$('.attendance-'+ user_id + ' .img-thumbnail').addClass('bg-success');
				break;
			case 2:
				$('.attendance-'+ user_id + ' .img-thumbnail').addClass('bg-warning');
				break;
		}

		$('#attendance-tab table').bootstrapTable('refresh');
	});
}

function submitAnswer(timer, exam_question_id, class_subject_exam_id, category, class_subject_id) {
	clearInterval(question_duration);

	var $answer = '';

	if (category == 'multiplechoice' || category == 'trueorfalse') {
		$answer = $('[name="answer"]:checked').val();
	}

	if (category == 'identification' || category == 'essay' || category == 'fillintheblank') {
		$answer = $('[name="answer"]').val();
	}

	$.post('/class/subject/exam/answer', { answer: $answer, timer: timer, exam_question_id: exam_question_id, class_subject_exam_id: class_subject_exam_id, class_subject_id: class_subject_id }, function(res) {
		$('#start-exam').click();
	});
}

function getExamGrade(exam_id) {
	var $block = $('#exam-question-block');

	$.get('/class/subject/exam/grade/'+ exam_id, function(data) {
		$block.html("<h3 class='text-center'>Your grade</h3><h2 class='text-center'>"+ data.score +" / "+ data.total +" <small>"+ Math.round((data.score/data.total)*100) +"%</small></h2>");
	});
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function usernameFormatter(value, row) {
	return "<a href='/user/"+ row.id +"'>"+ row.username +"</a>";
}

function fullNameFormatter(value, row) {
	return "<a href='/user/"+ row.user_id +"'>"+ row.full_name +"</a>";
}

function actionSchoolMemberFormatter(value, row) {
	return ["<a href='/school/member/delete/"+ row.id +"' class='btn btn-default btn-xs' onclick='return confirm(\"Are you sure you want to delete this school member?\")'><i class='fa fa-remove'></i></a>"].join(" ");
}

function subjectFormatter(value, row) {
	return ["[", row.code, "] ", row.name, " - ", row.description].join(" ");
}

function actionUpdateClassSectionFormatter(value, row) {
	return ["<a href='/class/section/edit/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Edit'><i class='fa fa-pencil'></i></a>",
			"<a href='/class/section/view/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>"].join(" ");
}

function actionClassSectionFormatter(value, row) {
	return ["<a href='/class/student/delete/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fa fa-remove'></i></a>",].join(" ");
}

function userProfile(value, row) {
	return "<a href='/user/"+ row.username +"'>"+ row.name +"</a>";
}

function actionClassSubjectFormatter(value, row) {
	return ["<a href='/class/subject/edit/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Edit'><i class='fa fa-pencil'></i></a>",
			"<a href='/class/subject/delete/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fa fa-remove'></i></a>",
			"<a href='/class/subject/view/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>"].join(" ");
}

function actionClassSubjectScheduleFormatter(value, row) {
	return ["<a href='/class/subject/schedule/edit/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Edit'><i class='fa fa-pencil'></i></a>",
			"<a href='/class/subject/schedule/delete/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fa fa-remove'></i></a>"].join(" ");
}

function actionLessonFormatter(value, row) {
	var user_id = $('[name="user_id"]').val();
	var group_name = $('[name="group_name"]').val();

	if (row.posted_by != user_id && group_name == 'teacher')
	{
		return "<a href='/lesson/view/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>";
	}

	return ["<a href='/lesson/edit/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Edit'><i class='fa fa-pencil'></i></a>",
			"<a href='/lesson/delete/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item? All of its file will be deleted.\")'><i class='fa fa-remove'></i></a>",
			"<a href='/lesson/view/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>"].join(" ");
}

function classSubjectNameFormatter(value, row) {
	return "<a href='/class/subject/view/"+ row.id +"'>"+ row.subject.name +"</a>";
}

function actionClassSubjectLessonFormatter(value, row) {
	return ["<a href='/class/subject/lesson/delete/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fa fa-remove'></i></a>",
			"<a href='/lesson/view/"+ row.lesson_id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>"].join(" ");
}

function actionSchoolCodeFormatter(value, row) {
	return [
		"<a href='/school/code/delete/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fa fa-remove'></i></a>"
	].join(" ");
}

function actionClassCodeFormatter(value, row) {
	return [
		"<a href='/class/section/code/delete/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fa fa-remove'></i></a>"
	].join(" ");
}

function lessonFormatter(value, row) {
	return "<a href='/lesson/view/"+ row.lesson_id +"'>"+ row.title +"</a>";
}

function actionExamQuestionFormatter(value, row) {
	return ["<a href='/exam/question/edit/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Edit'><i class='fa fa-pencil'></i></a>",
			"<a href='/exam/question/delete/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fa fa-remove'></i></a>",
			"<a href='/exam/question/view/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>"].join(" ");
}


function actionExamQuestionViewFormatter(value, row) {
	return ["<a href='/exam/question/view/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>"].join(" ");
}

function actionExamQuestionAnswerFormatter(value, row) {
	return ["<a href='/exam/question/answer/edit/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Edit'><i class='fa fa-pencil'></i></a>",
			"<a href='/exam/question/answer/delete/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fa fa-remove'></i></a>"].join(" ");
}

function actionExamFormatter(value, row) {
	return ["<a href='/exam/edit/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Edit'><i class='fa fa-pencil'></i></a>",
			"<a href='/exam/delete/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fa fa-remove'></i></a>",
			"<a href='/exam/view/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>"].join(" ");
}

function actionClassSubjectExamFormatter(value, row) {
	return ["<a href='/class/subject/exam/edit/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Edit'><i class='fa fa-pencil'></i></a>",
            "<a href='/class/subject/exam/delete/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fa fa-remove'></i></a>",
			"<a href='/class/subject/exam/view/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>"].join(" ");
}

function actionClassSubjectExamUserFormatter(value, row) {
	return ["<a href='/class/subject/exam/user/delete/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fa fa-remove'></i></a>"].join(" ");
}

function actionMyClassFormatter(value, row) {
	return "<a href='/class/subject/view/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='View'><i class='fa fa-eye'></i></a>";
}

function actionClassSubjectStudentsFormatter(value, row) {
    return "";
}

function statusFormatter(value, row) {
	if (row.status == 1) {
		return "<span class='text-success'>Active</span>";
	} else {
		return "<span class='text-muted'>Inactive</span>";
	}
}

function examTakeExamTitleFormatter(value, row) {
	return "<a href='/class/subject/exam/take/"+ row.class_subject_exam.id +"'>"+ row.title +"</a>";
}

function takeExamTitleFormatter(value, row) {
	return "<a href='/class/subject/exam/take/"+ row.id +"'>"+ row.exam.title +"</a>";
}

function lessonTitleFormatter(value, row) {
	return "<a href='/lesson/view/"+ row.lesson.id +"'>"+ row.lesson.title +"</a>";
}

function subjectNameFormatter(value, row) {
	return '['+ row.subject.code +'] '+ row.subject.name +' - '+ row.subject.description;
}

function profileNameFormatter(value, row) {
	var name = ucwords(row.profile.last_name +', '+ row.profile.first_name);
	return '<a href="/user/'+ row.username +'">'+ name +'</a>';
}

function fromProfileNameFormatter(value, row) {
	var name = ucwords(row.from.profile.last_name +', '+ row.from.profile.first_name);
	return '<a href="/user/'+ row.from.username +'">'+ name +'</a>';
}

function userProfileNameFormatter(value, row) {
	var name = ucwords(row.user.profile.last_name +', '+ row.user.profile.first_name);
	return '<a href="/user/'+ row.user.username +'">'+ name +'</a>';
}

function teacherProfileNameFormatter(value, row) {
	var name = ucwords(row.teacher.profile.last_name) +', '+ ucwords(row.teacher.profile.first_name);
	return '<a href="/user/'+ row.teacher.username +'">'+ name +'</a>';
}

function studentProfileNameFormatter(value, row) {
	var name = ucwords(row.student.profile.last_name) +', '+ ucwords(row.student.profile.first_name);
	return '<a href="/user/'+ row.student.username +'">'+ name +'</a>';
}

function classStudentProfileNameFormatter(value, row) {
	var name = ucwords(row.class_student.student.profile.last_name) +', '+ ucwords(row.class_student.student.profile.first_name);
	return '<a href="/user/'+ row.class_student.student.username +'">'+ name +'</a>';
}

function studentProfileGenderFormatter(value, row) {
	if (row.student.profile.gender == 1) {
		return 'Male';
	}
	else {
		return 'Female';
	}
}

function profileGenderFormatter(value, row) {
	if (row.profile.gender == 1) {
		return 'Male';
	}
	else {
		return 'Female';
	}
}

function remarksFormatter(value, row) {
    return remarks[row.remarks];
}

function yearLevelFormatter(value, row) {
	return row.level +' - '+ row.level+1;
}

function dayFormatter(value, row) {
	return days[row.day];
}

function gradeLevelFormatter(value, row) {
	return gradeLevels[row.level];
}

function ucwords(str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}

function assessmentGradeFormatter(value, row) {
	return  row.score +"/"+ row.total +" ("+ Math.round((row.score / row.total) * 100) +"%)";
}

function assessedProfileNameFormatter(value, row) {
	var name = ucwords(row.assessed.profile.first_name) +' '+ ucwords(row.assessed.profile.last_name);
	return '<a href="/user/'+ row.assessed.username +'">'+ name +'</a>';
}

function classSectionNameFormatter(value, row) {
	return "["+ gradeLevels[row.class_section.level] + "] "+ row.class_section.name;
}

function attendanceStatusFormatter(value, row) {
	var status;

	switch (row.status) {
		case 0:
			status = "<i class='fa fa-times text-danger' data-toggle='tooltip' title='Absent'></i> Absent";
			break;
		case 1:
			status = "<i class='fa fa-check text-success' data-toggle='tooltip' title='Present'></i> Present";
			break;
		case 2:
			status = "<i class='fa fa-exclamation text-warning' data-toggle='tooltip' title='Late'></i> Late";
			break;
	}

	return status;
}

function recordedFormatter(value, row) {
	return row.recorded ? 'Yes' : 'No';
}

function assessmentClassSubjectNameFormatter(value, row) {
    if (row.class_subject == null) {
        return '['+ row.class_subject_exam.class_subject.subject.code +'] '+ row.class_subject_exam.class_subject.subject.name +' - '+ row.class_subject_exam.class_subject.subject.description;
    } else {
        return '['+ row.class_subject.subject.code +'] '+ row.class_subject.subject.name +' - '+ row.class_subject.subject.description;
    }
}

function classStudentSchoolNameFormatter(value, row) {
	return row.class_student.student.school_member.school.name;
}

function assessmentCategoryName(value, row) {
	return row.assessment_category.name;
}

function subjectExamGradeFormatter(value, row) {
	if (row.score == null) {
		return "<span class='text-muted'>None</span>";
	} else {
		return row.score +"/"+ row.total +" ("+ Math.round((row.score / row.total) * 100) +"%)";
	}
}

function classStudentClassSectionTeacherProfileNameFormatter(value, row) {
	var name = ucwords(row.class_student.class_section.teacher.profile.last_name +', '+ row.class_student.class_section.teacher.profile.first_name);
	return '<a href="/user/'+ row.class_student.class_section.teacher.username +'">'+ name +'</a>';
}

$(function() {
    var student_id = $('#assessment-radar').data('student-id');
	$.get('/assessment/data?student_id='+ student_id, function(data) {
		var ctx = $('#assessment-radar').get(0).getContext("2d");
		var assessmentRadar = new Chart(ctx).Radar(data);
	});
});
