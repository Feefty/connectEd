String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};

Chart.defaults.global.responsive = true;

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
	"Grade 7",
	"Grade 8",
	"Grade 9",
	"Grade 10"
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

var examStatuses = [
    "Unverified",
    "Verified",
    "Undecided"
];

var question_duration;

$(function() {

    $('[data-toggle="calendar"]').fullCalendar();

	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
	});
	var isLogged = parseInt($('meta[name="is-logged"]').attr('content')) === 1 ? true : false;

	$('[data-toggle="tooltip"]').tooltip();
	$('.tooltips').tooltip();
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

		// setInterval(function() {
		// 	$.get('/notification/api', function(data) {
		// 		notif_data = data;
        //
		// 		if (notif_num != notif_data.length) {
		// 			notif_num = notif_data.length;
        //
		// 			if (notif_num > 0) {
		// 				var notif_html = "<li class='notification-title'><strong>Notifications</strong><span class='text-underline pull-right text-warning mark-as-read' onClick='readAll()'>Mark all as read</span></li>";
        //
		// 				$('.notification-icon').html("<span class='badge'>"+ notif_data.length +"</span>");
        //
		// 				$.each(notif_data, function(key, val) {
		// 					if (val.url != "") {
		// 						notif_html += "<li><a href="+ val.url +"><strong>"+ val.subject +"</strong><br>"+ val.content +"<br><span class='small'><i class='fa fa-clock'></i><time class='timeago' datetime='"+ val.created_at +"'>"+ val.created_at +"</time></span></a></li>";
		// 					}
		// 					else {
		// 						notif_html += "<li><a href='javsacript:void(0)'><strong>"+ val.subject +"</strong><br>"+ val.content +"<br><span class='small'><i class='fa fa-clock'></i><time class='timeago' datetime='"+ val.created_at +"'>"+ val.created_at +"</time></span></a></li>";
		// 					}
		// 				});
        //
		// 				$('.notification-holder').html(notif_html);
		// 			}
		// 		}
		// 	});
		// }, 5000);

        $.get('/message/unread', function(data) {
            var unread = data.unread;

            if (unread > 0) {
                $('#message-icon').text(unread).addClass('text-danger');
            }
        });

        // setInterval(function() {
        //     $.get('/message/unread', function(data) {
        //         var unread = data.unread;
        //
        //         if (unread > 0) {
        //             $('#message-icon').text(unread).addClass('text-danger');
        //         }
        //         else {
        //             $('#message-icon').text('').removeClass('text-danger');
        //         }
        //     });
        // }, 5000);
	}
    $('.messages').animate({ scrollTop: $('.messages').prop('scrollHeight') }, "slow");

    $('#sendMessageForm button').on('click', function(e) {
        var sendMessageForm = $('#sendMessageForm');
        var content = $('[name="content"]', sendMessageForm).val();
        var to_id = $('[name="to_id"]', sendMessageForm).val();

        $.post('/message/send', { content: content, to_id: to_id } , function(data) {
            if (data.status == 'success') {
                var message = '<div class="message-bit" id="message-'+ data.id +'">';
                message += '    <div class="row">';
                message += '        <div class="col-sm-12">';
                message += '            <p class="pull-left">';
                message += '                <a href="/user/'+ data.username +'">'+ data.name +'</a>';
                message += '            </p>';
                message += '            <p class="pull-right text-muted small margin-md-right">';
                message += '                <i class="fa fa-clock-o" data-toggle="tooltip" title="'+ data.created_at +'"></i> '+  data.timeago;
                message += '            </p>';
                message += '        </div>';
                message += '    </div>';
                message += '    <div class="row">';
                message += '        <div class="col-sm-12">';
                message += data.content;
                message += '        </div>';
                message += '    </div>';
                message += '</div>';
                $('.messages').append(message);
                $('.messages').animate({ scrollTop: $('.messages').prop('scrollHeight') }, "slow");
            }

            $('[name="content"]', sendMessageForm).val('');
        });
    });

    $('#attendanceProfileModal').on('show.bs.modal', function(e) {
        var user_id = $(e.relatedTarget).data('user-id');
        var name =  $(e.relatedTarget).data('name');
        var photo =  $(e.relatedTarget).data('photo');

        $('#profile-name').html(ucwords(name));

        var photo_src = photo;
        if (photo == '') {
            photo_src = 'http://placehold.it/200x250';
        }

        $.get('/attendance/profile/'+ user_id, function(data) {
            var profile_html = '<li><strong>Absents:</strong> '+ data.absents +'</li>';
            profile_html += '<li><strong>Presents:</strong> '+ data.presents +'</li>';
            profile_html += '<li><strong>Lates:</strong> '+ data.lates +'</li>';
            $('#attendance-profile').html(profile_html);
        });

        $('#profile-photo').prop('src', photo_src);

        $('[data-toggle="data"]', this).bootstrapTable({
            url: '/attendance/api?student_id='+ user_id,
            columns: [{
                title: 'Status',
                formatter: 'attendanceStatusFormatter',
                align: 'center',
                sortable: true
            }, {
                title: 'Date',
                field: 'created_at',
                sortable: true
            }]
        });
    });

    $('#addAssessmentForm #add').on('click', function(e) {
        e.preventDefault();
        $('.assessment-message-container').html('');
        var form = $('#addAssessmentForm');
        var form_data = {
            class_subject_id: $('[name="class_subject_id"]', form).val(),
            score: $('[name="score"]', form).val(),
            total: $('[name="total"]', form).val(),
            date: $('[name="date"]', form).val(),
            assessment_category_id: $('[name="assessment_category_id"]', form).val(),
            source: $('[name="source"]', form).val(),
            other: $('[name="other"]', form).val(),
            quarter: $('[name="quarter"]', form).val(),
            recorded: $('[name="recorded"]:checked', form).val(),
            students: $('[name="students[]"]', form).map(function(){return $(this).val();}).get()
        };

        $.post('/assessment/add', form_data, function(data) {
            if (data.status == 'success') {
                var msg = '<div class="alert alert-success">';
                msg += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                msg += '<p>'+ data.msg +'</p>';
                msg += '</div>';

                $('.assessment-message-container').html(msg);
                $('#assessments-tab table').bootstrapTable('refresh');
                $('[name="score"]', form).val('');
                $('[name="total"]', form).val('');
            }
        }).fail(function(data) {
            var msg = '<div class="alert alert-danger">';
            msg += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            $.each(data.responseJSON, function(key, value) {
                msg += '<p>'+ value +'</p>';
            });

            msg += '</div>';

            $('.assessment-message-container').html(msg);
        });

        return false;
    });

    $('[data-toggle="wysiwyg"]').summernote();
    $('#viewCreateLessonModal').on('show.bs.modal', function(e) {
        $('[data-toggle="wysiwyg"]').summernote();
    });
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

	if (category == 'identification' || category == 'essay') {
		$answer = $('[name="answer"]').val();
	}

    if (category == 'fillintheblank') {
        $answer = $('[name="answer[]"]').map(function(){return $(this).val();}).get();
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

function actionClassSubjectStudentFormatter(value, row) {
    return ["<a href='#addAchievementStudent' data-toggle='modal' class='btn btn-default btn-xs tooltips' title='Add Achievement'><i class='fa fa-trophy'></i></a>"].join(" ");
}

function actionClassSubjectAssessmentFormatter(value, row) {
	return ["<a href='/assessment/delete/"+ row.id +"' class='btn btn-default btn-xs' data-toggle='tooltip' title='Delete' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fa fa-remove'></i></a>"].join(" ");
}

function actionClassSubjectStudentsFormatter(value, row) {
    return "";
}

function attendanceStudentProfileFormatter(value, row) {
    var photo = '';
    if (row.student.profile.photo) {
        photo = row.student.profile.photo;
    }

    return '<a href="#attendanceProfileModal" data-photo="'+ photo +'" data-user-id="'+ row.student_id +'" data-name="'+ row.student.profile.first_name +' '+ row.student.profile.last_name +'" class="btn btn-default btn-xs" title="View Attendance Profile" data-toggle="modal"><i class="fa fa-eye"></i></a>';
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
	return '['+ row.subject.code +'] '+ row.subject.name;
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

function schoolYearFormatter(value, row) {
	return row.year +' - '+ (parseInt(row.year)+1);
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

function assessmentClass(value, row) {
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

function messageNameFormatter(value, row) {
    	var name = ucwords(row.from.profile.last_name +', '+ row.from.profile.first_name);
    	return '<a href="/m/'+ row.from.username +'">'+ name +'</a>';
}

function examStatusFormatter(value, row) {
    return examStatuses[row.status];
}

function gradeFormatter(value, row) {
    return Math.round(row.grade);
}

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

$(function() {

    var $this = $('canvas.chartjs:first');
    var url = $this.data('url');
    var type = $this.data('type');
    chartjs($this, url, type);

    $('#school-stats').ready(function() {
        $this = $('#school-stats');
        var url = $this.data('url');
        var type = $this.data('type');
        chartjs('#school-stats', url, type);
    });

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        var $this = $($(e.target).data('target') +' canvas');
        var url = $this.data('url');
        var type = $this.data('type');

        chartjs($(e.target).data('target') +' canvas', url, type);
    });
});

/*!
 * Jasny Bootstrap v3.1.3 (http://jasny.github.io/bootstrap)
 * Copyright 2012-2014 Arnold Daniels
 * Licensed under Apache-2.0 (https://github.com/jasny/bootstrap/blob/master/LICENSE)
 */
if("undefined"==typeof jQuery)throw new Error("Jasny Bootstrap's JavaScript requires jQuery");+function(a){"use strict";function b(){var a=document.createElement("bootstrap"),b={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var c in b)if(void 0!==a.style[c])return{end:b[c]};return!1}void 0===a.support.transition&&(a.fn.emulateTransitionEnd=function(b){var c=!1,d=this;a(this).one(a.support.transition.end,function(){c=!0});var e=function(){c||a(d).trigger(a.support.transition.end)};return setTimeout(e,b),this},a(function(){a.support.transition=b()}))}(window.jQuery),+function(a){"use strict";var b=function(c,d){this.$element=a(c),this.options=a.extend({},b.DEFAULTS,d),this.state=null,this.placement=null,this.options.recalc&&(this.calcClone(),a(window).on("resize",a.proxy(this.recalc,this))),this.options.autohide&&a(document).on("click",a.proxy(this.autohide,this)),this.options.toggle&&this.toggle(),this.options.disablescrolling&&(this.options.disableScrolling=this.options.disablescrolling,delete this.options.disablescrolling)};b.DEFAULTS={toggle:!0,placement:"auto",autohide:!0,recalc:!0,disableScrolling:!0},b.prototype.offset=function(){switch(this.placement){case"left":case"right":return this.$element.outerWidth();case"top":case"bottom":return this.$element.outerHeight()}},b.prototype.calcPlacement=function(){function b(a,b){if("auto"===e.css(b))return a;if("auto"===e.css(a))return b;var c=parseInt(e.css(a),10),d=parseInt(e.css(b),10);return c>d?b:a}if("auto"!==this.options.placement)return void(this.placement=this.options.placement);this.$element.hasClass("in")||this.$element.css("visiblity","hidden !important").addClass("in");var c=a(window).width()/this.$element.width(),d=a(window).height()/this.$element.height(),e=this.$element;this.placement=c>=d?b("left","right"):b("top","bottom"),"hidden !important"===this.$element.css("visibility")&&this.$element.removeClass("in").css("visiblity","")},b.prototype.opposite=function(a){switch(a){case"top":return"bottom";case"left":return"right";case"bottom":return"top";case"right":return"left"}},b.prototype.getCanvasElements=function(){var b=this.options.canvas?a(this.options.canvas):this.$element,c=b.find("*").filter(function(){return"fixed"===a(this).css("position")}).not(this.options.exclude);return b.add(c)},b.prototype.slide=function(b,c,d){if(!a.support.transition){var e={};return e[this.placement]="+="+c,b.animate(e,350,d)}var f=this.placement,g=this.opposite(f);b.each(function(){"auto"!==a(this).css(f)&&a(this).css(f,(parseInt(a(this).css(f),10)||0)+c),"auto"!==a(this).css(g)&&a(this).css(g,(parseInt(a(this).css(g),10)||0)-c)}),this.$element.one(a.support.transition.end,d).emulateTransitionEnd(350)},b.prototype.disableScrolling=function(){var b=a("body").width(),c="padding-"+this.opposite(this.placement);if(void 0===a("body").data("offcanvas-style")&&a("body").data("offcanvas-style",a("body").attr("style")||""),a("body").css("overflow","hidden"),a("body").width()>b){var d=parseInt(a("body").css(c),10)+a("body").width()-b;setTimeout(function(){a("body").css(c,d)},1)}},b.prototype.show=function(){if(!this.state){var b=a.Event("show.bs.offcanvas");if(this.$element.trigger(b),!b.isDefaultPrevented()){this.state="slide-in",this.calcPlacement();var c=this.getCanvasElements(),d=this.placement,e=this.opposite(d),f=this.offset();-1!==c.index(this.$element)&&(a(this.$element).data("offcanvas-style",a(this.$element).attr("style")||""),this.$element.css(d,-1*f),this.$element.css(d)),c.addClass("canvas-sliding").each(function(){void 0===a(this).data("offcanvas-style")&&a(this).data("offcanvas-style",a(this).attr("style")||""),"static"===a(this).css("position")&&a(this).css("position","relative"),"auto"!==a(this).css(d)&&"0px"!==a(this).css(d)||"auto"!==a(this).css(e)&&"0px"!==a(this).css(e)||a(this).css(d,0)}),this.options.disableScrolling&&this.disableScrolling();var g=function(){"slide-in"==this.state&&(this.state="slid",c.removeClass("canvas-sliding").addClass("canvas-slid"),this.$element.trigger("shown.bs.offcanvas"))};setTimeout(a.proxy(function(){this.$element.addClass("in"),this.slide(c,f,a.proxy(g,this))},this),1)}}},b.prototype.hide=function(){if("slid"===this.state){var b=a.Event("hide.bs.offcanvas");if(this.$element.trigger(b),!b.isDefaultPrevented()){this.state="slide-out";var c=a(".canvas-slid"),d=(this.placement,-1*this.offset()),e=function(){"slide-out"==this.state&&(this.state=null,this.placement=null,this.$element.removeClass("in"),c.removeClass("canvas-sliding"),c.add(this.$element).add("body").each(function(){a(this).attr("style",a(this).data("offcanvas-style")).removeData("offcanvas-style")}),this.$element.trigger("hidden.bs.offcanvas"))};c.removeClass("canvas-slid").addClass("canvas-sliding"),setTimeout(a.proxy(function(){this.slide(c,d,a.proxy(e,this))},this),1)}}},b.prototype.toggle=function(){"slide-in"!==this.state&&"slide-out"!==this.state&&this["slid"===this.state?"hide":"show"]()},b.prototype.calcClone=function(){this.$calcClone=this.$element.clone().html("").addClass("offcanvas-clone").removeClass("in").appendTo(a("body"))},b.prototype.recalc=function(){if("none"!==this.$calcClone.css("display")&&("slid"===this.state||"slide-in"===this.state)){this.state=null,this.placement=null;var b=this.getCanvasElements();this.$element.removeClass("in"),b.removeClass("canvas-slid"),b.add(this.$element).add("body").each(function(){a(this).attr("style",a(this).data("offcanvas-style")).removeData("offcanvas-style")})}},b.prototype.autohide=function(b){0===a(b.target).closest(this.$element).length&&this.hide()};var c=a.fn.offcanvas;a.fn.offcanvas=function(c){return this.each(function(){var d=a(this),e=d.data("bs.offcanvas"),f=a.extend({},b.DEFAULTS,d.data(),"object"==typeof c&&c);e||d.data("bs.offcanvas",e=new b(this,f)),"string"==typeof c&&e[c]()})},a.fn.offcanvas.Constructor=b,a.fn.offcanvas.noConflict=function(){return a.fn.offcanvas=c,this},a(document).on("click.bs.offcanvas.data-api","[data-toggle=offcanvas]",function(b){var c,d=a(this),e=d.attr("data-target")||b.preventDefault()||(c=d.attr("href"))&&c.replace(/.*(?=#[^\s]+$)/,""),f=a(e),g=f.data("bs.offcanvas"),h=g?"toggle":d.data();b.stopPropagation(),g?g.toggle():f.offcanvas(h)})}(window.jQuery),+function(a){"use strict";var b=function(c,d){this.$element=a(c),this.options=a.extend({},b.DEFAULTS,d),this.$element.on("click.bs.rowlink","td:not(.rowlink-skip)",a.proxy(this.click,this))};b.DEFAULTS={target:"a"},b.prototype.click=function(b){var c=a(b.currentTarget).closest("tr").find(this.options.target)[0];if(a(b.target)[0]!==c)if(b.preventDefault(),c.click)c.click();else if(document.createEvent){var d=document.createEvent("MouseEvents");d.initMouseEvent("click",!0,!0,window,0,0,0,0,0,!1,!1,!1,!1,0,null),c.dispatchEvent(d)}};var c=a.fn.rowlink;a.fn.rowlink=function(c){return this.each(function(){var d=a(this),e=d.data("bs.rowlink");e||d.data("bs.rowlink",e=new b(this,c))})},a.fn.rowlink.Constructor=b,a.fn.rowlink.noConflict=function(){return a.fn.rowlink=c,this},a(document).on("click.bs.rowlink.data-api",'[data-link="row"]',function(b){if(0===a(b.target).closest(".rowlink-skip").length){var c=a(this);c.data("bs.rowlink")||(c.rowlink(c.data()),a(b.target).trigger("click.bs.rowlink"))}})}(window.jQuery),+function(a){"use strict";var b=void 0!==window.orientation,c=navigator.userAgent.toLowerCase().indexOf("android")>-1,d="Microsoft Internet Explorer"==window.navigator.appName,e=function(b,d){c||(this.$element=a(b),this.options=a.extend({},e.DEFAULTS,d),this.mask=String(this.options.mask),this.init(),this.listen(),this.checkVal())};e.DEFAULTS={mask:"",placeholder:"_",definitions:{9:"[0-9]",a:"[A-Za-z]",w:"[A-Za-z0-9]","*":"."}},e.prototype.init=function(){var b=this.options.definitions,c=this.mask.length;this.tests=[],this.partialPosition=this.mask.length,this.firstNonMaskPos=null,a.each(this.mask.split(""),a.proxy(function(a,d){"?"==d?(c--,this.partialPosition=a):b[d]?(this.tests.push(new RegExp(b[d])),null===this.firstNonMaskPos&&(this.firstNonMaskPos=this.tests.length-1)):this.tests.push(null)},this)),this.buffer=a.map(this.mask.split(""),a.proxy(function(a){return"?"!=a?b[a]?this.options.placeholder:a:void 0},this)),this.focusText=this.$element.val(),this.$element.data("rawMaskFn",a.proxy(function(){return a.map(this.buffer,function(a,b){return this.tests[b]&&a!=this.options.placeholder?a:null}).join("")},this))},e.prototype.listen=function(){if(!this.$element.attr("readonly")){var b=(d?"paste":"input")+".mask";this.$element.on("unmask.bs.inputmask",a.proxy(this.unmask,this)).on("focus.bs.inputmask",a.proxy(this.focusEvent,this)).on("blur.bs.inputmask",a.proxy(this.blurEvent,this)).on("keydown.bs.inputmask",a.proxy(this.keydownEvent,this)).on("keypress.bs.inputmask",a.proxy(this.keypressEvent,this)).on(b,a.proxy(this.pasteEvent,this))}},e.prototype.caret=function(a,b){if(0!==this.$element.length){if("number"==typeof a)return b="number"==typeof b?b:a,this.$element.each(function(){if(this.setSelectionRange)this.setSelectionRange(a,b);else if(this.createTextRange){var c=this.createTextRange();c.collapse(!0),c.moveEnd("character",b),c.moveStart("character",a),c.select()}});if(this.$element[0].setSelectionRange)a=this.$element[0].selectionStart,b=this.$element[0].selectionEnd;else if(document.selection&&document.selection.createRange){var c=document.selection.createRange();a=0-c.duplicate().moveStart("character",-1e5),b=a+c.text.length}return{begin:a,end:b}}},e.prototype.seekNext=function(a){for(var b=this.mask.length;++a<=b&&!this.tests[a];);return a},e.prototype.seekPrev=function(a){for(;--a>=0&&!this.tests[a];);return a},e.prototype.shiftL=function(a,b){var c=this.mask.length;if(!(0>a)){for(var d=a,e=this.seekNext(b);c>d;d++)if(this.tests[d]){if(!(c>e&&this.tests[d].test(this.buffer[e])))break;this.buffer[d]=this.buffer[e],this.buffer[e]=this.options.placeholder,e=this.seekNext(e)}this.writeBuffer(),this.caret(Math.max(this.firstNonMaskPos,a))}},e.prototype.shiftR=function(a){for(var b=this.mask.length,c=a,d=this.options.placeholder;b>c;c++)if(this.tests[c]){var e=this.seekNext(c),f=this.buffer[c];if(this.buffer[c]=d,!(b>e&&this.tests[e].test(f)))break;d=f}},e.prototype.unmask=function(){this.$element.unbind(".mask").removeData("inputmask")},e.prototype.focusEvent=function(){this.focusText=this.$element.val();var a=this.mask.length,b=this.checkVal();this.writeBuffer();var c=this,d=function(){b==a?c.caret(0,b):c.caret(b)};d(),setTimeout(d,50)},e.prototype.blurEvent=function(){this.checkVal(),this.$element.val()!==this.focusText&&this.$element.trigger("change")},e.prototype.keydownEvent=function(a){var c=a.which;if(8==c||46==c||b&&127==c){var d=this.caret(),e=d.begin,f=d.end;return f-e===0&&(e=46!=c?this.seekPrev(e):f=this.seekNext(e-1),f=46==c?this.seekNext(f):f),this.clearBuffer(e,f),this.shiftL(e,f-1),!1}return 27==c?(this.$element.val(this.focusText),this.caret(0,this.checkVal()),!1):void 0},e.prototype.keypressEvent=function(a){var b=this.mask.length,c=a.which,d=this.caret();if(a.ctrlKey||a.altKey||a.metaKey||32>c)return!0;if(c){d.end-d.begin!==0&&(this.clearBuffer(d.begin,d.end),this.shiftL(d.begin,d.end-1));var e=this.seekNext(d.begin-1);if(b>e){var f=String.fromCharCode(c);if(this.tests[e].test(f)){this.shiftR(e),this.buffer[e]=f,this.writeBuffer();var g=this.seekNext(e);this.caret(g)}}return!1}},e.prototype.pasteEvent=function(){var a=this;setTimeout(function(){a.caret(a.checkVal(!0))},0)},e.prototype.clearBuffer=function(a,b){for(var c=this.mask.length,d=a;b>d&&c>d;d++)this.tests[d]&&(this.buffer[d]=this.options.placeholder)},e.prototype.writeBuffer=function(){return this.$element.val(this.buffer.join("")).val()},e.prototype.checkVal=function(a){for(var b=this.mask.length,c=this.$element.val(),d=-1,e=0,f=0;b>e;e++)if(this.tests[e]){for(this.buffer[e]=this.options.placeholder;f++<c.length;){var g=c.charAt(f-1);if(this.tests[e].test(g)){this.buffer[e]=g,d=e;break}}if(f>c.length)break}else this.buffer[e]==c.charAt(f)&&e!=this.partialPosition&&(f++,d=e);return!a&&d+1<this.partialPosition?(this.$element.val(""),this.clearBuffer(0,b)):(a||d+1>=this.partialPosition)&&(this.writeBuffer(),a||this.$element.val(this.$element.val().substring(0,d+1))),this.partialPosition?e:this.firstNonMaskPos};var f=a.fn.inputmask;a.fn.inputmask=function(b){return this.each(function(){var c=a(this),d=c.data("bs.inputmask");d||c.data("bs.inputmask",d=new e(this,b))})},a.fn.inputmask.Constructor=e,a.fn.inputmask.noConflict=function(){return a.fn.inputmask=f,this},a(document).on("focus.bs.inputmask.data-api","[data-mask]",function(){var b=a(this);b.data("bs.inputmask")||b.inputmask(b.data())})}(window.jQuery),+function(a){"use strict";var b="Microsoft Internet Explorer"==window.navigator.appName,c=function(b,c){if(this.$element=a(b),this.$input=this.$element.find(":file"),0!==this.$input.length){this.name=this.$input.attr("name")||c.name,this.$hidden=this.$element.find('input[type=hidden][name="'+this.name+'"]'),0===this.$hidden.length&&(this.$hidden=a('<input type="hidden">').insertBefore(this.$input)),this.$preview=this.$element.find(".fileinput-preview");var d=this.$preview.css("height");"inline"!==this.$preview.css("display")&&"0px"!==d&&"none"!==d&&this.$preview.css("line-height",d),this.original={exists:this.$element.hasClass("fileinput-exists"),preview:this.$preview.html(),hiddenVal:this.$hidden.val()},this.listen()}};c.prototype.listen=function(){this.$input.on("change.bs.fileinput",a.proxy(this.change,this)),a(this.$input[0].form).on("reset.bs.fileinput",a.proxy(this.reset,this)),this.$element.find('[data-trigger="fileinput"]').on("click.bs.fileinput",a.proxy(this.trigger,this)),this.$element.find('[data-dismiss="fileinput"]').on("click.bs.fileinput",a.proxy(this.clear,this))},c.prototype.change=function(b){var c=void 0===b.target.files?b.target&&b.target.value?[{name:b.target.value.replace(/^.+\\/,"")}]:[]:b.target.files;if(b.stopPropagation(),0===c.length)return void this.clear();this.$hidden.val(""),this.$hidden.attr("name",""),this.$input.attr("name",this.name);var d=c[0];if(this.$preview.length>0&&("undefined"!=typeof d.type?d.type.match(/^image\/(gif|png|jpeg)$/):d.name.match(/\.(gif|png|jpe?g)$/i))&&"undefined"!=typeof FileReader){var e=new FileReader,f=this.$preview,g=this.$element;e.onload=function(b){var e=a("<img>");e[0].src=b.target.result,c[0].result=b.target.result,g.find(".fileinput-filename").text(d.name),"none"!=f.css("max-height")&&e.css("max-height",parseInt(f.css("max-height"),10)-parseInt(f.css("padding-top"),10)-parseInt(f.css("padding-bottom"),10)-parseInt(f.css("border-top"),10)-parseInt(f.css("border-bottom"),10)),f.html(e),g.addClass("fileinput-exists").removeClass("fileinput-new"),g.trigger("change.bs.fileinput",c)},e.readAsDataURL(d)}else this.$element.find(".fileinput-filename").text(d.name),this.$preview.text(d.name),this.$element.addClass("fileinput-exists").removeClass("fileinput-new"),this.$element.trigger("change.bs.fileinput")},c.prototype.clear=function(a){if(a&&a.preventDefault(),this.$hidden.val(""),this.$hidden.attr("name",this.name),this.$input.attr("name",""),b){var c=this.$input.clone(!0);this.$input.after(c),this.$input.remove(),this.$input=c}else this.$input.val("");this.$preview.html(""),this.$element.find(".fileinput-filename").text(""),this.$element.addClass("fileinput-new").removeClass("fileinput-exists"),void 0!==a&&(this.$input.trigger("change"),this.$element.trigger("clear.bs.fileinput"))},c.prototype.reset=function(){this.clear(),this.$hidden.val(this.original.hiddenVal),this.$preview.html(this.original.preview),this.$element.find(".fileinput-filename").text(""),this.original.exists?this.$element.addClass("fileinput-exists").removeClass("fileinput-new"):this.$element.addClass("fileinput-new").removeClass("fileinput-exists"),this.$element.trigger("reset.bs.fileinput")},c.prototype.trigger=function(a){this.$input.trigger("click"),a.preventDefault()};var d=a.fn.fileinput;a.fn.fileinput=function(b){return this.each(function(){var d=a(this),e=d.data("bs.fileinput");e||d.data("bs.fileinput",e=new c(this,b)),"string"==typeof b&&e[b]()})},a.fn.fileinput.Constructor=c,a.fn.fileinput.noConflict=function(){return a.fn.fileinput=d,this},a(document).on("click.fileinput.data-api",'[data-provides="fileinput"]',function(b){var c=a(this);if(!c.data("bs.fileinput")){c.fileinput(c.data());var d=a(b.target).closest('[data-dismiss="fileinput"],[data-trigger="fileinput"]');d.length>0&&(b.preventDefault(),d.trigger("click.bs.fileinput"))}})}(window.jQuery);
//# sourceMappingURL=app.js.map
