@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
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
							   					<label for="score">Score</label>
							   					<input type="text" name="score" id="score" class="form-control">
							   				</div>
							   				
							   				<div class="form-group">
							   					<label for="total">Total</label>
							   					<input type="text" name="total" id="total" class="form-control">
							   				</div>
							   				
							   				<div class="form-group">
							   					<label for="source">Source</label>
							   					<input type="text" name="source" id="source" class="form-control">
							   				</div>
							   				
							   				<div class="form-group">
							   					<label for="term">Term</label>
							   					<select id="term" name="term" class="form-control">
							   						@for ($i = 1; $i <= 4; $i++)
							   							<option value="{{ $i }}">{{ $i }}</option>
							   						@endfor
							   					</select>
							   				</div>
							   				
							   				<div class="form-group">
							   					<label for="status">Status</label>
							   					<div class="radio">
							   						<label>
							   							<input type="radio" name="status" value="1"> Active
							   						</label>
							   						<label>
							   							<input type="radio" name="status" value="0"> Inactive
							   						</label>
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
							   					<label for="student">Student</label>
							   					<select id="student" name="student" class="form-control">
							   						@foreach ($students as $row)
							   							<option value="{{ $row->id }}">{{ ucwords($row->last_name .', '. $row->first_name) }}</option>
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
									<th data-sortable="true" data-formatter="subjectNameFormatter">Subject</th>
									@if (strtolower(auth()->user()->group->name) != 'student')
										<th data-sortable="true" data-formatter="schoolNameFormatter">School</th>
										<th data-formatter="studentProfileNameFormatter">Student</th>
									@endif
									<th data-sortable="true" data-formatter="assessedProfileNameFormatter">Assessed By</th>
									<th data-sortable="true" data-formatter="statusFormatter">Status</th>
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