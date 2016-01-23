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

						@can ('create-assessment')
						<div class="modal fade" id="viewCreateAssessment" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
							    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							    		<h4 class="modal-title" id="modalLabel">Assessment</h4>
							   		</div>
							   		<div class="modal-body">
							   			<form method="POST" action="{{ action('AssessmentController@postAdd') }}">
							   				{!! csrf_field() !!}
							   				
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
							   					<label for="source">Source</label>
							   					<input type="text" name="source" id="source" class="form-control">
							   				</div>
							   				
							   				<div class="form-group">
							   					<div class="row">
								   					<div class="col-sm-6">
								   						<label for="term">Term</label>
									   					<select id="term" name="term" class="form-control">
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
							   					<label for="subject">Subject</label>
							   					<select id="subject" name="subject" class="form-control">
							   						@foreach ($subjects as $row)
							   							<option value="{{ $row->id }}">[{{ $row->code }}] {{ $row->name }} - {{ $row->description }}</option>
							   						@endforeach
							   					</select>
							   				</div>
							   				
							   				<div class="form-group">
							   					<label for="students">Student</label>
							   					<select id="students" name="students[]" class="form-control" data-toggle="select" data-live-search="true" multiple>
							   						@foreach ($students as $row)
							   							<option value="{{ $row->id }}">{{ ucwords($row->last_name .', '. $row->first_name) }} - [{{ config('grade_level')[$row->user->class_student->class_section->level] }}] {{ $row->user->class_student->class_section->name }}</option>
							   						@endforeach
							   					</select>
							   				</div>

							   				<button type="submit" class="btn btn-primary">Add</button>
							   			</form>
							   		</div>
							   	</div>
							</div>
						</div><!-- end of #viewCreateAssessment -->
						@endcan

						<div id="toolbar">
							@can ('manage-assessment')
								<div class="dropdown">
									<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
									<ul class="dropdown-menu">
										@can ('create-assessment')
											<li><a href="#viewCreateAssessment" data-toggle="modal"><i class="fa fa-plus"></i> Create</a></li>
										@endcan
									</ul>
								</div>
							@endcan
						</div>

						<table data-url="{{ action('AssessmentController@getApi') }}" data-toggle="table" data-search="true">
							<thead>
								<tr>
									<th data-sortable="true" data-formatter="assessmentGradeFormatter">Grade</th>
									<th data-sortable="true" data-field="source">Source</th>
									<th data-sortable="true" data-field="term">Term</th>
									<th data-sortable="true" data-formatter="assessmentClassSubjectNameFormatter">Subject</th>
									@if (strtolower(auth()->user()->group->name) != 'student')
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