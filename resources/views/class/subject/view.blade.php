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
								<td><strong>Teacher:</strong> {{ ucwords($class_subject->teacher->profile->first_name .' '. $class_subject->teacher->profile->last_name) }}</td>
							</tr>
						</table>

						<div id="toolbar">
							@can ('manage-class-subject')
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
									<li><a href="#addScheduleModal" data-toggle="modal"><i class="fa fa-plus"></i> Add Schedule</a></li>
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
								      				@foreach ($lessons as $lesson)
								      					<option value="{{ $lesson->id }}">{{ $lesson->title .' by '. ucwords($lesson->user->profile->first_name .' '. $lesson->user->profile->last_name) .' - '. $lesson->created_at }}</option>
								      				@endforeach
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
							   							<option value="{{ $row->id }}">[{{ $row->username }}] {{ ucwords($row->profile->first_name .' '. $row->profile->last_name) }}</option>
							   						@endforeach
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

						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#schedules-tab">Schedules</a></li>
							<li><a data-toggle="tab" href="#lessons-tab">Lessons</a></li>
							<li><a data-toggle="tab" href="#exams-tab">Exams</a></li>
						</ul>

						<div class="tab-content">
							
							<div id="schedules-tab" class="tab-pane fade in active">
								<table data-toggle="table" data-url="{{ action('SubjectScheduleController@getAPI', $class_subject->id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
									<thead>
										<tr>
											<th colspan="4" data-align="center">Schedules</th>
										</tr>
										<tr>
											<th data-formatter="dayFormatter" data-sortable="true">Day</th>
											<th data-field="time" data-sortable="true">Time</th>
											@can ('manage-subject-schedule')
												<th data-formatter="actionClassSubjectScheduleFormatter" data-align="center">Actions</th>
											@endcan
										</tr>
									</thead>
								</table><!-- end of subject schedule -->
							</div><!-- end of schedules tab -->

							<div id="lessons-tab" class="tab-pane fade">
								<table data-toggle="table" data-url="{{ action('ClassSubjectLessonController@getApi', $class_subject->id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar2">
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
								<table data-toggle="table" data-url="{{ action('ClassSubjectExamController@getApi', $class_subject->id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar3">
									<thead>
										<tr>
											<th colspan="4" data-align="center">Exams</th>
										</tr>
										<tr>
											<th data-formatter="takeExamTitleFormatter" data-sortable="true">Title</th>
											<th data-field="start" data-sortable="true">Start</th>
											<th data-field="end" data-sortable="true">End</th>
											<th data-field="created_at">Date Added</th>
											@can ('manage-exam')
												<th data-formatter="actionClassSubjectExamFormatter" data-align="center"></th>
											@endcan
											@can ('take-exam', ['strict'])
												<th data-formatter="actionTakeClassSubjectExamFormatter" data-align="center"></th>
											@endcan
										</tr>
									</thead>
								</table>
							</div><!-- end of lessons tab -->

						</div>
					</div>	
				</div>
			</div>
		</div>
	</div>

@endsection