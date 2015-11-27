@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						<strong>Section {{ $section->name }}</strong> <span class="text-warning small">{{ config('grade_level')[$section->level] }}</span>
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

						<button type="button" class="btn btn-default btn-xs margin-lg-bottom" data-toggle="modal" data-target="#viewClassSchedulesModal">Manage Subjects</button>

						<div class="modal fade" id="viewClassSchedulesModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
							    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							    		<h4 class="modal-title" id="modalLabel">Class Subject</h4>
							   		</div>
							   		<div class="modal-body">
							   			<div id="toolbar2">
							   				<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#addScheduleForm">Add Subject</button>
							   			</div>
							   			<div id="addScheduleForm" class="collapse margin-lg-top">
							   				<form action="{{ action('ClassSectionController@postAddSubject') }}" method="POST">
							   					{!! csrf_field() !!}
							   					<input type="hidden" name="class_section_id" value="{{ $section->id }}">

							   					<div class="form-group">
							   						<label for="subject">Subject</label>
							   						<select id="subject" name="subject" class="form-control">
							   							@foreach ($subjects as $row)
							   								<option value="{{ $row->id }}">[{{ $row->code }}] {{ $row->name .' - '. $row->description }}</option>
							   							@endforeach
							   						</select>
							   					</div>
							   					<div class="form-group">
							   						<label for="teacher">Teacher</label>
							   						<select id="teacher" name="teacher" class="form-control">
							   							@foreach ($teachers as $row)
							   								<option value="{{ $row->id }}">{{ $row->first_name }} {{ $row->last_name }}</option>
							   							@endforeach
							   						</select>
							   					</div>
							   					<div class="form-group">
							   						<label for="room">Room</label>
							   						<input type="text" name="room" id="room" class="form-control" rquired>
							   					</div>
							   					<div class="form-group">
							   						<label>Schedules</label>

							   						<div class="schedule-items">
							   							<div class="row well">
								   							<div class="col-md-4">
								   								<label>Day</label>
								   								<select name="day[]" class="form-control">
								   									@foreach (config('days') as $row => $col)
								   										<option value="{{ $row }}">{{ $col }}</option>
								   									@endforeach
								   								</select>
								   							</div>
								   							<div class="col-md-4">
								   								<label>Time Start</label>
								   								<input type="time" name="time_start[]" class="form-control">
								   							</div>
								   							<div class="col-md-4">
								   								<label>Time End</label>
								   								<input type="time" name="time_end[]" class="form-control">
								   							</div>
								   						</div>
							   						</div>

							   							<div id="schedule-holder"></div>

							   						<button type="button" id="add-more-schedule" class="btn btn-info">Add More Schedule</button>
							   						<button type="submit" class="btn btn-primary">Create</button>
							   					</div>

							   				</form>
							   			</div>

								   		<table data-toggle="table" data-url="{{ action('ClassSubjectController@getAPI', $section->id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar2">
											<thead>
												<tr>
													<th data-field="subject">Subject</th>
													<th data-field="teacher">Teacher</th>
													<th data-field="room">Room</th>
													<th data-formatter="actionClassSubjectFormatter">Actions</th>
												</tr>
											</thead>
										</table>
							   		</div>
							   	</div>
							</div>
						</div>

						<table class="table">
							<tr>
								<td><strong>Adviser:</strong> {{ ucfirst(strtolower($section->first_name)) }} {{ ucfirst(strtolower($section->last_name)) }}</td>
							</tr>
							<tr>
								<td><strong>Year:</strong> {{ $section->year }} - {{ $section->year+1 }}</td>
							</tr>
							<tr>
								<td><strong>School:</strong> {{ $section->school }}</td>
							</tr>
						</table>

						<div id="toolbar">
		                    <form action="{{ action('ClassStudentController@postAdd') }}" method="POST" class="form-inline">
		                    	{!! csrf_field() !!}
		                    	<input type="hidden" name="class_section_id" value="{{ $section->id }}">
		                    	<div class="form-group">
		             				<div class="input-group">
		                    			<input type="text" class="form-control" name="username" placeholder="Enter Username">
		                    			<span class="input-group-btn">
		             						<button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i></button>
		             					</span>
		             				</div>
		                    	</div>
		                    </form>
						</div>

						<table data-toggle="table" data-url="{{ action('ClassStudentController@getAPIBySection', $section->id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
							<thead>
								<tr>
									<th data-formatter="userProfile">Name</th>
									<th data-field="gender">Gender</th>
									@can ('update-class-section')
									<th data-formatter="actionUpdateClassSectionFormatter">Actions</th>
									@else
									<th data-formatter="actionClassSectionFormatter">Actions</th>
									@endcan
								</tr>
							</thead>
						</table>
					</div>	
				</div>
			</div>
		</div>
	</div>

@endsection