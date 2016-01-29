@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						<a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a>
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

						@can ('manage-class-subject')

							<div class="modal fade" id="viewSubjectModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
								    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								    		<h4 class="modal-title" id="modalLabel">Class Subject</h4>
								   		</div>
								   		<div class="modal-body">
								   			<div id="toolbar2">
								   				@can ('create-class-subject')
								   					<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#addSubjectForm">Add Subject</button>
								   				@endcan
								   			</div>

								   			@can ('create-class-subject')
									   			<div id="addSubjectForm" class="collapse margin-lg-top">
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
									   								<option value="{{ $row->id }}">{{ ucwords($row->profile->first_name .' '. $row->profile->last_name) }}</option>
									   							@endforeach
									   						</select>
									   					</div>
									   					<div class="form-group">
									   						<label for="room">Room</label>
									   						<input type="text" name="room" id="room" class="form-control" rquired>
									   					</div>
									   					<div class="form-group">
									   						<label>Schedules</label>

									   						<div class="add-more-items">
									   							<div class="row">
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

									   						<div id="add-more-holder"></div>

									   						<div class="margin-lg-top">
									   							<button type="button" id="add-more" class="btn btn-info">Add More Schedule</button>
									   							<button type="submit" class="btn btn-primary">Create</button>
									   						</div>
									   					</div>

									   				</form>
									   			</div>
								   			@endcan

									   		<table data-toggle="table" data-url="{{ action('ClassSubjectController@getApi') }}?class_section_id={{ $section->id }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar2">
												<thead>
													<tr>
														<th data-formatter="subjectNameFormatter">Subject</th>
														<th data-formatter="teacherProfileNameFormatter">Teacher</th>
														<th data-field="room">Room</th>
														<th data-formatter="actionClassSubjectFormatter" data-align="center">Actions</th>
													</tr>
												</thead>
											</table>
								   		</div>
								   	</div>
								</div>
							</div><!-- end of class subject modal -->

						@endcan

						@can ('manage-class-section-code')

							<div class="modal fade" id="viewClassCodeModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
								    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								    		<h4 class="modal-title" id="modalLabel">Class Code</h4>
								   		</div>
								   		<div class="modal-body">
								   			<div id="toolbar3">
								   				@can ('create-class-section-code')
								   					<button type="button" class="btn btn-default" data-toggle="collapse" data-target="#generateClassCodeForm">Generate Class Code</button>
								   				@endcan
								   			</div>

								   			@can ('create-class-section-code')
									   			<div id="generateClassCodeForm" class="collapse margin-lg-top">
									   				<form action="{{ action('ClassSectionCodeController@postGenerate') }}" method="POST">
									   					{!! csrf_field() !!}
									   					<input type="hidden" name="class_section_id" value="{{ $section->id }}">

									   					<div class="form-group">
									   						<label for="amount">Amount</label>
									   						<input type="number" name="amount" id="amount" class="form-control">
									   					</div>

								   						<button type="submit" class="btn btn-primary">Generate</button>

									   				</form>
									   			</div>
								   			@endcan

									   		<table data-toggle="table" data-url="{{ action('ClassSectionCodeController@getApi') }}?section_id={{ $section->id }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar3">
												<thead>
													<tr>
														<th data-field="code" data-sortable="true">Code</th>
														<th data-formatter="statusFormatter" data-sortable="true">Status</th>
														<th data-field="created_at" data-sortable="true">Date Added</th>
														<th data-formatter="actionClassCodeFormatter" data-align="center">Actions</th>
													</tr>
												</thead>
											</table>
								   		</div>
								   	</div>
								</div>
							</div><!-- end of class section code modal -->

						@endcan

						<table class="table">
							<tr>
								<td><strong>Adviser:</strong> <a href="{{ action('ProfileController@getUser', $section->teacher->username) }}">{{ ucwords($section->teacher->profile->first_name .' '. $section->teacher->profile->last_name) }}</a></td>
							</tr>
							<tr>
								<td><strong>School Year:</strong> {{ $section->year }} - {{ $section->year+1 }}</td>
							</tr>
							<tr>
								<td><strong>School:</strong> <a href="{{ action('SchoolController@getIndex', $section->school->id) }}">{{ $section->school->name }}</a></td>
							</tr>
						</table>

						<div id="toolbar">
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
									<li><a href="#viewSubjectModal" data-toggle="modal">Subjects</a></li>
									<li><a href="#viewClassCodeModal" data-toggle="modal">Class Code</a></li>
								</ul>
							</div>
						</div>

						<table data-toggle="table" data-url="{{ action('ClassStudentController@getApi') }}?class_section_id={{ $section->id }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
							<thead>
								<tr>
									<th data-formatter="studentProfileNameFormatter">Name</th>
									<th data-formatter="studentProfileGenderFormatter">Gender</th>
									<th data-formatter="actionClassSectionFormatter" data-align="center">Actions</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
