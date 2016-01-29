@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						Assessment
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

						<table data-url="{{ action('AssessmentController@getApi') }}" data-toggle="table" data-search="true" data-pagination="true" data-refresh="true">
							<thead>
								<tr>
									<th data-sortable="true" data-formatter="assessmentGradeFormatter">Grade</th>
									<th data-sortable="true" data-field="source">Source</th>
									<th data-sortable="true" data-field="quarter">Quarter</th>
									<th data-sortable="true" data-formatter="assessmentClassSubjectNameFormatter">Subject</th>
									@if (strtolower(auth()->user()->group->name) != 'student' || strtolower(auth()->user()->group->name) != 'parent')
										<th data-sortable="true" data-formatter="classStudentSchoolNameFormatter">School</th>
										<th data-sortable="true" data-formatter="classStudentProfileNameFormatter">Student</th>
									@endif
									<th data-sortable="true" data-formatter="recordedFormatter">Recorded</th>
									<th data-sortable="true" data-field="created_at">Date</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
