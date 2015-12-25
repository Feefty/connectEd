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
								<td><strong>Section:</strong> {{ config('grade_level')[$class_subject->section_level] }} - {{ $class_subject->section }}</td>
							</tr>
							<tr>
								<td><strong>Subject:</strong> {{ '['. $subject->code .'] '. $subject->name .' '. $subject->level .' - '. $subject->description }}</td>
							</tr>
							<tr>
								<td><strong>Room:</strong> {{ $class_subject->room }}</td>
							</tr>
							<tr>
								<td><strong>Teacher:</strong> {{ $class_subject->teacher }}</td>
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
								      					<option value="{{ $lesson->id }}">{{ $lesson->title .' by '. $lesson->posted_by .' - '. $lesson->created_at }}</option>
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
						</ul>

						<div class="tab-content">
							
							<div id="schedules-tab" class="tab-pane fade in active">
								<table data-toggle="table" data-url="{{ action('SubjectScheduleController@getAPI', $class_subject->id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
									<thead>
										<tr>
											<th colspan="4" data-align="center">Schedules</th>
										</tr>
										<tr>
											<th data-formatter="dayFormatter">Day</th>
											<th data-field="time">Time</th>
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
											<th data-formatter="lessonFormatter">Title</th>
											<th data-field="created_at">Date Added</th>
											@can ('manage-subject-schedule')
												<th data-formatter="actionClassSubjectLessonFormatter" data-align="center">Actions</th>
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