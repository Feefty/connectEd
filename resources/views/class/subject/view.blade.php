@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						<a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Class Subject View
					</div>
					<div class="panel-body">
						@if (count($errors) > 0)
						    <div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
						        <ul>
						            @foreach ($errors->all() as $error)
						                <li>{{ $error }}</li>
						            @endforeach
						        </ul>
						    </div>
						@endif
						@if (session()->has('msg'))
							<div class="alert alert-info">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<p>{{ session()->get('msg') }}</p>
							</div>
						@endif

						@can ('update-class-subject')
							<div class="text-right">
								<a class="btn btn-link " href="{{ action('ClassSubjectController@getEdit', $class_subject->id) }}"><i class="fa fa-pencil"></i> Edit</a>
							</div>
						@endcan
						<table class="table table-bordered">
							<tr>
								<td><strong>Section:</strong> <a href="{{ action('ClassSectionController@getView', $class_subject->class_section_id) }}">{{ '['. config('grade_level')[$class_subject->class_section->level] .'] '. $class_subject->class_section->name }}</a></td>
							</tr>
							<tr>
								<td><strong>Subject:</strong> {{ '['. $class_subject->subject->code .'] '. $class_subject->subject->name }}</td>
							</tr>
							<tr>
								<td><strong>Room:</strong> {{ $class_subject->room }}</td>
							</tr>
							<tr>
								<td><strong>Teacher:</strong> <a href="{{ action('ProfileController@getUser', $class_subject->teacher->username) }}">{{ ucwords($class_subject->teacher->profile->first_name .' '. $class_subject->teacher->profile->last_name) }}</a></td>
							</tr>
						</table>

						<div id="toolbar">
							@can ('manage-subject-schedule')
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
									@can ('create-subject-schedule')
									<li><a href="#addScheduleModal" data-toggle="modal"><i class="fa fa-plus"></i> Add Schedule</a></li>
									@endcan
								</ul>
							</div>
							@endcan
						</div>

						<div id="toolbar2">
							@can ('manage-class-subject')
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
									<li><a href="#addLessonModal" data-toggle="modal"><i class="fa fa-plus"></i> Add Lesson</a></li>
								</ul>
							</div>
							@endcan
						</div>

						<div id="toolbar3">
							@can ('manage-class-subject')
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
									<li><a href="#addExamModal" data-toggle="modal"><i class="fa fa-plus"></i> Add Exam</a></li>
								</ul>
							</div>
							@endcan
						</div>

						<div id="toolbar4">
							@can ('manage-attendance')
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
									<li><a href="#addAttendanceModal" data-toggle="modal"><i class="fa fa-plus"></i> Add Attendance</a></li>
								</ul>
							</div>
							@endcan
							<ul class="list-inline">
								<li><strong>Legends</strong></li>
								@foreach (config('attendance.status') as $row => $col)
									<li>{{ $row }} {{ $col }}</li>
								@endforeach
							</ul>
						</div>

						<div id="toolbarq1">
							@can ('manage-grade-summary')
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
									<li><a href="#addGradeSummaryModal" data-toggle="modal"><i class="fa fa-plus"></i> Submit Grade Summary</a></li>
								</ul>
							</div>
							@endcan
						</div>

						<div id="toolbarq2">
							@can ('manage-grade-summary')
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
									<li><a href="#addGradeSummaryModal" data-toggle="modal"><i class="fa fa-plus"></i> Submit Grade Summary</a></li>
								</ul>
							</div>
							@endcan
						</div>

						<div id="toolbarq3">
							@can ('manage-grade-summary')
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
									<li><a href="#addGradeSummaryModal" data-toggle="modal"><i class="fa fa-plus"></i> Submit Grade Summary</a></li>
								</ul>
							</div>
							@endcan
						</div>

						<div id="toolbarq4">
							@can ('manage-grade-summary')
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
									<li><a href="#addGradeSummaryModal" data-toggle="modal"><i class="fa fa-plus"></i> Submit Grade Summary</a></li>
								</ul>
							</div>
							@endcan
						</div>

						<div class="modal fade" id="addScheduleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
						 		<div class="modal-content">
							      	<form action="{{ action('SubjectScheduleController@postAdd') }}" method="post">
							    		<div class="modal-header">
							        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        		<h4 class="modal-title" id="myModalLabel">Schedule</h4>
							      		</div>
								      	<div class="modal-body">
								      		{!! csrf_field() !!}

								      		<input type="hidden" name="class_subject_id" value="{{ $class_subject->id }}">
								      		<input type="hidden" name="room" value="{{ $class_subject->room }}">

							      			<div class="form-group">
							      				<div class="row">
									      			<div class="col-md-4">
						   								<label>Day</label>
						   								<select name="day" class="form-control">
						   									@foreach (config('days') as $row => $col)
						   										<option value="{{ $row }}">{{ $col }}</option>
						   									@endforeach
						   								</select>
						   							</div>
						   							<div class="col-md-4">
						   								<label>Time Start</label>
						   								<input type="time" name="time_start" class="form-control">
						   							</div>
						   							<div class="col-md-4">
						   								<label>Time End</label>
						   								<input type="time" name="time_end" class="form-control">
						   							</div>
							      				</div>
							      			</div>
								      	</div>
								      	<div class="modal-footer">
								        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								        	<button type="submit" class="btn btn-primary">Add</button>
								      	</div>
							      	</form>
						    	</div>
						  	</div>
						</div><!-- end of modal -->

						<div class="modal fade" id="addLessonModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
						 		<div class="modal-content">
							      	<form action="{{ action('ClassSubjectLessonController@postAdd') }}" method="post">
							    		<div class="modal-header">
							        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        		<h4 class="modal-title" id="myModalLabel">Lesson</h4>
							      		</div>
								      	<div class="modal-body">
								      		{!! csrf_field() !!}

								      		<input type="hidden" name="class_subject_id" value="{{ $class_subject->id }}">

								      		<div class="form-group">
								      			<label for="lesson">Lesson</label>
								      			<select id="lesson" name="lesson" class="form-control">
								      				@forelse ($lessons as $lesson)
								      					<option value="{{ $lesson->id }}">{{ $lesson->title .' by '. ucwords($lesson->user->profile->first_name .' '. $lesson->user->profile->last_name) .' - '. $lesson->created_at }}</option>
								      				@empty
								      					<option>No availble lesson</option>
								      				@endforelse
								      			</select>
								      		</div>
								      	</div>
								      	<div class="modal-footer">
								        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								        	<button type="submit" class="btn btn-primary">Add</button>
								      	</div>
							      	</form>
						    	</div>
						  	</div>
						</div><!-- end of modal -->

						<div class="modal fade" id="addExamModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
						 		<div class="modal-content">
							      	<form action="{{ action('ClassSubjectExamController@postAdd') }}" method="post">
							    		<div class="modal-header">
							        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        		<h4 class="modal-title" id="myModalLabel">Exam</h4>
							      		</div>
								      	<div class="modal-body">
								      		{!! csrf_field() !!}

								      		<input type="hidden" name="class_subject_id" value="{{ $class_subject->id }}">

								      		<div class="form-group">
								      			<label for="exam">Exam</label>
								      			<select id="exam" name="exam" class="form-control">
								      				@forelse ($class_subject->subject->exam as $row)
								      					<option value="{{ $row->id }}">{{ $row->title .' - '. $row->assessment_category->name }}</option>
								      				@empty
								      					<option>No available exam</option>
								      				@endforelse
								      			</select>
								      		</div>

							   				<div class="form-group">
									   			<label for="start">Start</label>
							   					<div class="row">
							   						<div class="col-md-6">
									   					<input type="date" name="start_date" id="start" class="form-control" placeholder="YYYY-MM-DD">
								   					</div>
							   						<div class="col-md-6">
									   					<input type="time" name="start_time" class="form-control" placeholder="HH:MM">
								   					</div>
							   					</div>
							   				</div>


							   				<div class="form-group">
									   			<label for="end">End</label>
							   					<div class="row">
							   						<div class="col-md-6">
									   					<input type="date" name="end_date" id="end" class="form-control" placeholder="YYYY-MM-DD">
								   					</div>
							   						<div class="col-md-6">
									   					<input type="time" name="end_time" class="form-control" placeholder="HH:MM">
								   					</div>
							   					</div>
							   				</div>

							   				<div class="form-group">
							   					<label for="user">Users</label>
							   					<select id="user" name="users[]" class="form-control" data-toggle="select" data-live-search="true" multiple>
							   						@foreach ($users as $row)
							   							<option value="{{ $row->user_id }}">{{ ucwords($row->last_name .', '. $row->first_name) }}</option>
							   						@endforeach
							   					</select>
							   				</div>

											<div class="form-group">
												<label for="quarter">Quarter</label>
												<select class="form-control" name="quarter" id="quarter">
													@for ($i = 1; $i <= 4; $i++)
														<option value="{{ $i }}">{{ $i }}</option>
													@endfor
												</select>
											</div>
								      	</div>
								      	<div class="modal-footer">
								        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								        	<button type="submit" class="btn btn-primary">Add</button>
								      	</div>
							      	</form>
						    	</div>
						  	</div>
						</div><!-- end of modal -->

						<div class="modal fade" id="addAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog modal-lg" role="document">
						 		<div class="modal-content">
							      	<form action="" method="post">
							    		<div class="modal-header">
							        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        		<h4 class="modal-title" id="myModalLabel">Attendance</h4>
							      		</div>
								      	<div class="modal-body" id="attendance">
								      		{!! csrf_field() !!}

								      		<input type="hidden" name="class_subject_id" value="{{ $class_subject->id }}">

								      		<div class="form-group">
								      			<label for="date">Date</label>
								      			<input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}">
								      		</div>

							      			<div class="row">
							      				@foreach ($users as $row)
										      		<div class="col-md-3 col-sm-4 attendance-{{ $row->user_id }}">
									      				<div class="img-thumbnail">
									      					<strong>{{ ucwords($row->last_name .', '. $row->first_name) }}</strong>
											      			<button type="button" class="btn btn-xs btn-link pull-right" data-toggle="tooltip" title="Present"  onclick="submitAttendance(1, {{ $row->user_id }})"><i class="fa fa-check text-success"></i></button>
											      			@if ($row->photo)
											      				<img src="{{ config('profile.photo.path') . $row->photo }}" class="img-responsive">
											      			@else
											      				<img src="http://placehold.it/200x250" class="img-responsive">
											      			@endif
											      			<div class="attendance-tool">
											      				<button type="button" class="btn btn-xs btn-link" onclick="submitAttendance(0, {{ $row->user_id }})"><i class="fa fa-times"></i> Absent</button>
											      				<button type="button" class="btn btn-xs btn-link" onclick="submitAttendance(2, {{ $row->user_id }})"><i class="fa fa-exclamation"></i> Late</button>
											      			</div>
									      				</div>
										      		</div>
								      			@endforeach
							      			</div>
								      	</div>
								      	<div class="modal-footer">
								        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								      	</div>
							      	</form>
						    	</div>
						  	</div>
						</div><!-- end of modal -->

						<div class="modal fade" id="addAssessmentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
						 		<div class="modal-content">
							      	<form action="{{ action('AssessmentController@postAdd') }}" method="post" id="addAssessmentForm">
							    		<div class="modal-header">
							        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        		<h4 class="modal-title" id="myModalLabel">Assessments</h4>
							      		</div>
								      	<div class="modal-body" id="attendance">
								      		{!! csrf_field() !!}
											<div class="assessment-message-container"></div>

								      		<input type="hidden" name="class_subject_id" value="{{ $class_subject->id }}">

							   				<div class="form-group">
							   					<label for="score">Grade</label>
							   					<div class="input-group">
							   						<input type="text" name="score" id="score" class="form-control" placeholder="Score">
							   						<span class="input-group-addon">
							   							/
							   						</span>
							   						<input type="text" name="total" id="total" class="form-control" placeholder="Total">
							   					</div>

							   				</div>

							   				<div class="form-group">
							   					<label for="date">Date</label>
							   					<input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}">
							   				</div>

							   				<div class="form-group">
							   					<label for="assessment_category_id">Category</label>
							   					<select id="assessment_category_id" name="assessment_category_id" class="form-control">
							   						@foreach ($assessment_categories as $row)
							   							<option value="{{ $row->id }}">{{ $row->name }}</option>
							   						@endforeach
							   					</select>
							   				</div>

							   				<div class="form-group">
												<label for="source">Source</label>
												<div class="row">
													<div class="col-sm-6">
														<select class="form-control" name="source" id="source">
															<option value="">- Select -</option>
															@foreach (config('assessment.sources') as $row)
																<option value="{{ $row }}">{{ $row }}</option>
															@endforeach
														</select>
													</div>
													<div class="col-sm-6">
									   					<input type="text" name="other" id="other" class="form-control" placeholder="Other">
													</div>
												</div>
							   				</div>

							   				<div class="form-group">
							   					<div class="row">
								   					<div class="col-sm-6">
								   						<label for="term">Quarter</label>
									   					<select id="quarter" name="quarter" class="form-control">
									   						@for ($i = 1; $i <= 4; $i++)
									   							<option value="{{ $i }}">{{ $i }}</option>
									   						@endfor
									   					</select>
								   					</div>

								   					<div class="col-sm-6">
									   					<label for="recorded">Recorded</label>
									   					<div class="radio">
									   						<label>
									   							<input type="radio" name="recorded" value="1" checked> Yes
									   						</label>
									   						<label>
									   							<input type="radio" name="recorded" value="0"> No
									   						</label>
									   					</div>
								   					</div>
							   					</div>
							   				</div>

							   				<div class="form-group">
							   					<label for="students">Student</label>
							   					<select name="students[]" id="students" class="form-control" data-toggle="select" data-live-search="true" multiple>
							   						@foreach ($users as $row)
							   							<option value="{{ $row->user_id }}">{{ ucwords(strtolower($row->last_name .', '. $row->first_name)) }}</option>
							   						@endforeach
							   					</select>
							   				</div>
								      	</div>
								      	<div class="modal-footer">
								        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								      		<button type="button" id="add" class="btn btn-primary">Add</button>
								      	</div>
							      	</form>
						    	</div>
						  	</div>
						</div><!-- end of modal -->

						<div class="modal fade" id="addGradeSummaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
						 		<div class="modal-content">
							      	<form action="{{ action('GradeSummaryController@postAdd') }}" method="post">
							    		<div class="modal-header">
							        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        		<h4 class="modal-title" id="myModalLabel">Grade Summary</h4>
							      		</div>
								      	<div class="modal-body">
								      		{!! csrf_field() !!}

								      		<input type="hidden" name="class_subject_id" value="{{ $class_subject->id }}">

											<div class="form-group">
												<label for="student_id">Student</label>
												<select class="form-control" data-toggle="select" name="student_id" id="student_id" data-live-search="true">
													@foreach ($users as $row)
														<option value="{{ $row->user_id }}">{{ ucwords(strtolower($row->last_name .', '. $row->first_name)) }}</option>
													@endforeach
												</select>
											</div>

											<div class="form-group">
												<div class="row">
													<div class="col-sm-6">
														<label for="quarterselect">Quarter</label>
														<select class="form-control" name="quarter" id="quarterselect">
															@for ($i = 1; $i <= 4; $i++)
																<option value="{{ $i }}">{{ $i }}</option>
															@endfor
														</select>
													</div>
													<div class="col-sm-6">
														<label for="school_year">School Year</label>
														<select class="form-control" name="school_year" id="school_year">
															@for ($year = date('Y'); $year >= 1950; $year--)
																<option value="{{ $year }}">{{ $year }} - {{ $year+1 }}</option>
															@endfor
														</select>
													</div>
												</div>
											</div>

								      	</div>
								      	<div class="modal-footer">
								        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								        	<button type="submit" class="btn btn-primary">Submit</button>
								      	</div>
							      	</form>
						    	</div>
						  	</div>
						</div><!-- end of modal -->

						<div class="modal fade" id="addAchievementStudent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog modal-lg" role="document">
						 		<div class="modal-content">
							      	<form action="{{ action('AchievementController@postAdd') }}" method="post">
							    		<div class="modal-header">
							        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        		<h4 class="modal-title" id="myModalLabel">Achievement</h4>
							      		</div>
								      	<div class="modal-body">
								      		{!! csrf_field() !!}
											<input type="hidden" name="student_id" value="">

											<div class="row">
												@foreach ($achievements as $row)
													<div class="col-sm-2">
														<div class="checkbox">
															<label>
																<input type="checkbox" name="achievement_ids[]" value="{{ $row->id }}">
																<strong>{{ $row->title }}</strong>
																<img src="{{ asset(config('achievement.icon.path')).'/'. $row->icon }}" class="img-responsive" alt="" />
															</label>
														</div>
													</div>
												@endforeach
											</div>
								      	</div>
								      	<div class="modal-footer">
								        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								        	<button type="submit" class="btn btn-primary">Add</button>
								      	</div>
							      	</form>
						    	</div>
						  	</div>
						</div><!-- end of modal -->

						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#schedules-tab"><i class="fa fa-calendar"></i> Schedules</a></li>
							<li><a data-toggle="tab" href="#students-tab"><i class="fa fa-users"></i> Students</a></li>
							<li><a data-toggle="tab" href="#lessons-tab"><i class="fa fa-book"></i> Lessons</a></li>
							<li><a data-toggle="tab" href="#exams-tab"><i class="fa fa-file-text"></i> Exams</a></li>
							<li><a data-toggle="tab" href="#attendance-tab"><i class="fa fa-star"></i> Attendance</a></li>
							<li><a data-toggle="tab" href="#assessments-tab"><i class="fa fa-line-chart"></i> Assessments</a></li>
							<li><a data-toggle="tab" href="#grade-summary-tab"><i class="fa fa-pie-chart"></i> Grade Summary</a></li>
						</ul>

						<div class="tab-content">

							<div id="schedules-tab" class="tab-pane fade in active">
								<table data-toggle="table" data-url="{{ action('SubjectScheduleController@getApi') }}?class_subject_id={{$class_subject->id }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
									<thead>
										<tr>
											<th colspan="4" data-align="center">Schedules</th>
										</tr>
										<tr>
											<th data-formatter="dayFormatter" data-sortable="true">Day</th>
											<th data-field="time" data-sortable="true">Time</th>
											@can ('manage-subject-schedule')
												<th data-formatter="actionClassSubjectScheduleFormatter" data-align="center"></th>
											@endcan
										</tr>
									</thead>
								</table><!-- end of subject schedule -->
							</div><!-- end of schedules tab -->

							<div id="lessons-tab" class="tab-pane fade">
								<table data-toggle="table" data-url="{{ action('ClassSubjectLessonController@getApi') }}?class_subject_id={{ $class_subject->id }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar2">
									<thead>
										<tr>
											<th colspan="4" data-align="center">Lessons</th>
										</tr>
										<tr>
											<th data-formatter="lessonTitleFormatter" data-sortable="true">Title</th>
											<th data-field="created_at" data-sortable="true">Date Added</th>
											@can ('manage-subject-schedule')
												<th data-formatter="actionClassSubjectLessonFormatter" data-align="center">Actions</th>
											@endcan
										</tr>
									</thead>
								</table>
							</div><!-- end of lessons tab -->

							<div id="exams-tab" class="tab-pane fade">
								<table data-toggle="table" data-url="{{ action('ClassSubjectExamController@getApi') }}?class_subject_id={{ $class_subject->id }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar3">
									<thead>
										<tr>
											<th colspan="7" data-align="center">Exams</th>
										</tr>
										<tr>
											<th data-field="exam.title" data-formatter="takeExamTitleFormatter" data-sortable="true">Title</th>
											<th data-field="exam.assessment_category.name" data-sortable="true">Category</th>
											<th data-field="start" data-sortable="true">Start</th>
											<th data-field="end" data-sortable="true">End</th>
											<th data-field="quarter" data-sortable="true">Quarter</th>
											<th data-field="created_at" data-sortable="true">Date Added</th>
											@can ('manage-class-subject-exam')
												<th data-formatter="actionClassSubjectExamFormatter" data-align="center"></th>
											@endcan
										</tr>
									</thead>
								</table>
							</div><!-- end of exams tab -->


							<div id="attendance-tab" class="tab-pane fade">
								<table data-toggle="table" data-url="{{ action('AttendanceController@getApi') }}?class_subject_id={{ $class_subject->id }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar4">
									<thead>
										<tr>
											<th colspan="6" data-align="center">Attendance</th>
										</tr>
										<tr>
											<th data-searchable="true" data-formatter="studentProfileNameFormatter" data-sortable="true">Student</th>
											<th data-searchable="true" data-align="center" data-field="status" data-sortable="true">Status</th>
											<th data-searchable="true" data-field="date" data-sortable="true">Date</th>
											<th data-formatter="attendanceStudentProfileFormatter" data-align="center"></th>
										</tr>
									</thead>
								</table>
							</div><!-- end of attendance tab -->


							<div id="assessments-tab" class="tab-pane fade">
								<div class="row">
									<div class="col-sm-3">
										<ul class="nav nav-pills nav-stacked">
											@foreach ($sources as $row)
												@if ($sources[0]->id == $row->id)
													<li class="active"><a data-toggle="tab" href="#{{ str_replace(' ', '_', strtolower($row->source)) }}"><i class="fa fa-arrow-right fa-fw"></i> {{ $row->source }}</a></li>
												@else
													<li><a data-toggle="tab" href="#{{ str_replace(' ', '_', strtolower($row->source)) }}"><i class="fa fa-arrow-right fa-fw"></i> {{ $row->source }}</a></li>
												@endif
											@endforeach
										</ul>
									</div>
									<div class="col-sm-9">
										<div id="toolbarassessment" class="margin-lg-top">
											@can ('manage-assessment')
											<div class="dropdown">
												<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
												<ul class="dropdown-menu">
													<li><a href="#addAssessmentModal" data-toggle="modal"><i class="fa fa-plus"></i> Add Assessment</a></li>
												</ul>
											</div>
											@endcan
										</div>
										<div class="tab-content">
											@foreach ($sources as $row)
												@if ($sources[0]->id == $row->id)
													<div id="{{ str_replace(' ', '_', strtolower($row->source)) }}" class="tab-pane fade in active">
												@else
													<div id="{{ str_replace(' ', '_', strtolower($row->source)) }}" class="tab-pane fade">
												@endif
													<table data-toggle="table" data-url="{{ action('AssessmentController@getApi') }}?class_subject_id={{ $class_subject->id }}&source={{ rawurlencode($row->source) }}" data-pagination="true" data-search="true" data-show-refresh="true">
														<thead>
															<tr>
																<th colspan="9" data-align="center">Assessments</th>
															</tr>
															<tr>
																<th data-sortable="true" data-formatter="assessmentGradeFormatter">Grade</th>
																<th data-sortable="true" data-field="quarter">Quarter</th>
																@if (strtolower(auth()->user()->group->name) != 'student')
																	<th data-formatter="classStudentProfileNameFormatter">Student</th>
																@endif
																<th data-sortable="true" data-formatter="recordedFormatter">Recorded</th>
																<th data-sortable="true" data-field="date">Date</th>
																@can ('delete-assessment')
																	<th data-align="center" data-formatter="actionClassSubjectAssessmentFormatter"></th>
																@endcan
															</tr>
														</thead>
													</table>
												</div>
											@endforeach
										</div>
									</div>
								</div>
							</div><!-- end of assessments tab -->


							<div id="grade-summary-tab" class="tab-pane fade">
								<div class="row">
									<div class="col-sm-3">
										<ul class="nav nav-pills nav-stacked">
											<li class="active"><a href="#quarter1" data-toggle="tab"><i class="fa fa-arrow-right fa-fw"></i> 1st Quarter</a></li>
											<li><a href="#quarter2" data-toggle="tab"><i class="fa fa-arrow-right fa-fw"></i> 2nd Quarter</a></li>
											<li><a href="#quarter3" data-toggle="tab"><i class="fa fa-arrow-right fa-fw"></i> 3rd Quarter</a></li>
											<li><a href="#quarter4" data-toggle="tab"><i class="fa fa-arrow-right fa-fw"></i> 4th Quarter</a></li>
											<li><a href="#fullgrade" data-toggle="tab"><i class="fa fa-arrow-right fa-fw"></i> Final</a></li>
										</ul>
									</div>
									<div class="col-sm-9">
										<div class="tab-content">
											<div id="quarter1" class="tab-pane fade in active">
												<table data-toggle="table" data-url="{{ action('GradeSummaryController@getApi') }}?class_subject_id={{ $class_subject->id }}&quarter=1" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbarq1">
													<thead>
														<tr>
															<th colspan="9" data-align="center">Grade Summary</th>
														</tr>
														<tr>
															<th data-sortable="true" data-formatter="studentProfileNameFormatter">Student</th>
															<th data-sortable="true" data-field="grade">Grade</th>
															<th data-sortable="true" data-field="created_at">Date Added</th>
															<th data-sortable="true" data-formatter="remarksFormatter">Remarks</th>
														</tr>
													</thead>
												</table>
											</div>
											<div id="quarter2" class="tab-pane fade">
												<table data-toggle="table" data-url="{{ action('GradeSummaryController@getApi') }}?class_subject_id={{ $class_subject->id }}&quarter=2" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbarq2">
													<thead>
														<tr>
															<th colspan="9" data-align="center">Grade Summary</th>
														</tr>
														<tr>
															<th data-sortable="true" data-formatter="studentProfileNameFormatter">Student</th>
															<th data-sortable="true" data-field="grade">Grade</th>
															<th data-sortable="true" data-field="created_at">Date Added</th>
															<th data-sortable="true" data-formatter="remarksFormatter">Remarks</th>
														</tr>
													</thead>
												</table>
											</div>
											<div id="quarter3" class="tab-pane fade">
												<table data-toggle="table" data-url="{{ action('GradeSummaryController@getApi') }}?class_subject_id={{ $class_subject->id }}&quarter=3" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbarq3">
													<thead>
														<tr>
															<th colspan="9" data-align="center">Grade Summary</th>
														</tr>
														<tr>
															<th data-sortable="true" data-formatter="studentProfileNameFormatter">Student</th>
															<th data-sortable="true" data-field="grade">Grade</th>
															<th data-sortable="true" data-field="created_at">Date Added</th>
															<th data-sortable="true" data-formatter="remarksFormatter">Remarks</th>
														</tr>
													</thead>
												</table>
											</div>
											<div id="quarter4" class="tab-pane fade">
												<table data-toggle="table" data-url="{{ action('GradeSummaryController@getApi') }}?class_subject_id={{ $class_subject->id }}&quarter=4" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbarq4">
													<thead>
														<tr>
															<th colspan="9" data-align="center">Grade Summary</th>
														</tr>
														<tr>
															<th data-sortable="true" data-formatter="studentProfileNameFormatter">Student</th>
															<th data-sortable="true" data-field="grade">Grade</th>
															<th data-sortable="true" data-field="created_at">Date Added</th>
															<th data-sortable="true" data-formatter="remarksFormatter">Remarks</th>
														</tr>
													</thead>
												</table>
											</div>
											<div id="fullgrade" class="tab-pane fade">
												<button type="button" data-target="#finalGrade" class="btn btn-xs btn-default" data-toggle="print">Print</button>
												<table class="table table-bordered table-hover margin-lg-top" id="finalGrade">
													<thead>
														<tr>
															<th>
																Student
															</th>
															<th>
																1st Quarter
															</th>
															<th>
																2nd Quarter
															</th>
															<th>
																3rd Quarter
															</th>
															<th>
																4th	Quarter
															</th>
															<th>
																Final
															</th>
															<th>
																Remarks
															</th>
														</tr>
													</thead>
													<tbody>
														@foreach ($users as $row)
															<tr>
																<td>
																	{{ ucwords(strtolower($row->last_name .', '. $row->first_name)) }}
																</td>
																<td>
																	{{ \App\GradeSummary::where(['quarter' => 1, 'class_subject_id' => $class_subject->id, 'school_year' => $class_subject->class_section->year, 'student_id' => $row->user_id])->pluck('grade') }}
																</td>
																<td>
																	{{ \App\GradeSummary::where(['quarter' => 2, 'class_subject_id' => $class_subject->id, 'school_year' => $class_subject->class_section->year, 'student_id' => $row->user_id])->pluck('grade') }}
																</td>
																<td>
																	{{ \App\GradeSummary::where(['quarter' => 3, 'class_subject_id' => $class_subject->id, 'school_year' => $class_subject->class_section->year, 'student_id' => $row->user_id])->pluck('grade') }}
																</td>
																<td>
																	{{ \App\GradeSummary::where(['quarter' => 4, 'class_subject_id' => $class_subject->id, 'school_year' => $class_subject->class_section->year, 'student_id' => $row->user_id])->pluck('grade') }}
																</td>
																<td>
																	<?php $avg = \App\GradeSummary::where(['class_subject_id' => $class_subject->id, 'school_year' => $class_subject->class_section->year, 'student_id' => $row->user_id])->avg('grade') ?>
																	{{ $avg }}
																</td>
																<td>
																	{!! $avg < 75 ? ('<span class="text-danger">Failed</span>' == 0 ? '-' : '<span class="text-danger">Failed</span>') : '<span class="text-success">Passed</span>' !!}
																</td>
															</tr>
														@endforeach
													</tbody>
											 	</table>
											</div>
										</div>
									</div>
								</div>
							</div><!-- end of grade summaries tab -->


							<div id="students-tab" class="tab-pane fade">
								<table data-toggle="table" data-url="{{ action('ClassStudentController@getApi') }}?class_subject_id={{ $class_subject->id }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar7">
									<thead>
										<tr>
											<th colspan="9" data-align="center">Students</th>
										</tr>
										<tr>
											<th data-sortable="true" data-formatter="studentProfileNameFormatter">Name</th>
											<th data-sortable="true" data-formatter="studentProfileGenderFormatter">Gender</th>
											@can ('create-student-achievement')
												<th data-formatter="actionClassSubjectStudentFormatter" data-align="center"></th>
											@endif
										</tr>
									</thead>
								</table>
							</div><!-- end of assessments tab -->

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="attendanceProfileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="exampleModalLabel">Student's Attendance Profile</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-3">
							<strong id="profile-name"></strong>
							<img src="http://placehold.it/200x250" id="profile-photo" alt="" class="img-responsive" />
							<ul class="list-unstyled" id="attendance-profile">
							</ul>
						</div>
						<div class="col-sm-9">
							<table data-toggle="data" data-url="" data-search="true" data-pagination="true">
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

@endsection
