@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">My Room</div>
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

					@if (is_null($section))
						<div class="text-info">
							You have not yet enrolled in any class.
						</div>
						<form method="POST" action="{{ action('RoomController@postEnroll') }}">
							<div class="col-md-6 col-md-offset-3">
								{!! csrf_field() !!}
								<div class="form-group">
									<label for="class_code">Class Code</label>
									<input type="text" name="class_code" id="class_code" class="form-control">
								</div>
								<button type="submit" class="btn btn-primary">Enroll</button>
							</div>
						</form>
					@else
						<ul class="list-inline">
							<li><strong>Adviser:</strong> <a href="#">{{ ucwords($section->teacher->profile->first_name .' '. $section->teacher->profile->last_name) }}</a></li>
						</ul>

						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#students-tab">Students</a></li>
							<li><a data-toggle="tab" href="#subjects-tab">Subjects</a></li>
						</ul>

						<div class="tab-content">
							
							<div id="students-tab" class="tab-pane fade in active">
								<h3><i class="fa fa-users"></i> Students</h3>
								<table data-toggle="table" data-url="{{ action('ClassStudentController@getApi') }}?class_section_id={{ $section->id }}">
									<thead>
										<tr>
											<th data-formatter="studentProfileNameFormatter" data-sortable="true">Name</th>
											<th data-formatter="studentProfileGenderFormatter" data-sortable="true">Gender</th>
										</tr>
									</thead>
								</table>
							</div><!-- end of students tab -->

							<div id="subjects-tab" class="tab-pane fade">
								<h3><i class="fa fa-book"></i> Subjects</h3>
								<table data-toggle="table" data-url="{{ action('ClassSubjectController@getApi') }}?class_section_id={{ $section->id }}">
									<thead>
										<tr>
											<th data-formatter="classSubjectNameFormatter" data-sortable="true">Subject</th>
											<th data-formatter="teacherProfileNameFormatter" data-sortable="true">Teacher</th>
											<th data-field="room" data-sortable="true">Room</th>
										</tr>
									</thead>
								</table>
							</div><!-- end of subjects tab -->

						</div>
					@endif
				</div>
			</div>
		</div>
	</div>

@endsection