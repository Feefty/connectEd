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
								<td><strong>Section:</strong> {{ '['. config('grade_level')[$class_subject->class_section->level] .'] '. $class_subject->class_section->name }}</td>
							</tr>
							<tr>
								<td><strong>Subject:</strong> {{ '['. $class_subject->subject->code .'] '. $class_subject->subject->name .' '. $class_subject->subject->level .' - '. $class_subject->subject->description }}</td>
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
								      					<option value="{{ $row->id }}">{{ $row->title .' - '. $row->exam_type->name }}</option>
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
							   					<select id="user" name="users[]" class="form-control" data-toggle="select" multiple>
							   						@foreach ($users as $row)
							   							<option value="{{ $row->user_id }}">{{ ucwords($row->last_name .', '. $row->first_name) }}</option>
							   						@endforeach
							   					</select>
							   				</div>

							   				<div class="form-group">
							   					<label for="status">Status</label>
							   					<div class="radio">
							   						<label>
							   							<input type="radio" name="status" id="status" value="1" checked> Active
							   						</label>
							   						<label>
							   							<input type="radio" name="status" id="status" value="0"> Inactive
							   						</label>
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

						<div class="modal fade" id="addAttendanceModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog modal-lg" role="document">
						 		<div class="modal-content">
							      	<form action="{{ action('ClassSubjectExamController@postAdd') }}" method="post">
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

						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#schedules-tab"><i class="fa fa-calendar"></i> Schedules</a></li>
							<li><a data-toggle="tab" href="#lessons-tab"><i class="fa fa-book"></i> Lessons</a></li>
							<li><a data-toggle="tab" href="#exams-tab"><i class="fa fa-file-text"></i> Exams</a></li>
							<li><a data-toggle="tab" href="#attendance-tab"><i class="fa fa-star"></i> Attendance</a></li>
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
											<th colspan="6" data-align="center">Exams</th>
										</tr>
										<tr>
											<th data-field="exam.title" data-formatter="takeExamTitleFormatter" data-sortable="true">Title</th>
											<th data-field="exam.exam_type.name" data-sortable="true">Type</th>
											<th data-field="start" data-sortable="true">Start</th>
											<th data-field="end" data-sortable="true">End</th>
											<th data-field="created_at" data-sortable="true">Date Added</th>
											@can ('manage-exam')
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
											<th data-searchable="true" data-formatter="attendanceStatusFormatter" data-align="center" data-sortable="true">Status</th>
											<th data-searchable="true" data-field="date" data-sortable="true">Date</th>
											@can ('manage-exam')
												<th data-formatter="actionClassSubjectExamFormatter" data-align="center"></th>
											@endcan
										</tr>
									</thead>
								</table>
							</div><!-- end of attendance tab -->

						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>

@endsection