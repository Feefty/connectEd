@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Exams</div>
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

					<div id="toolbar">
						@can ('manage-exam')
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
									@can ('create-exam')
										<li><a href="#viewCreateExamModal" data-toggle="modal"><i class="fa fa-plus"></i> Create</a></li>
									@endcan
								</ul>
							</div>
						@endcan
					</div>

					@can ('create-exam')
					<div class="modal fade" id="viewCreateExamModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
						    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						    		<h4 class="modal-title" id="modalLabel">Exams</h4>
						   		</div>
						   		<div class="modal-body">
						   			<form method="POST" action="{{ action('ExamController@postAdd') }}">
						   				{!! csrf_field() !!}
						   				<input type="hidden" name="school_id" value="{{ $school_id }}">

						   				<div class="form-group">
						   					<label for="title">Title</label>
						   					<input type="text" name="title" id="title" class="form-control">
						   				</div>

						   				<div class="form-group">
						   					<label for="assessment_category_id">Category</label>
						   					<select id="assessment_category_id" name="assessment_category_id" class="form-control">
						   						@foreach ($assessment_categories as $row)
						   							<option value="{{ $row->id }}">{{ $row->name }}</option>
						   						@endforeach
						   					</select>
											<div class="help-block">
												The Quarterly Assessment needs to be verified first by the school to be answered by Students.
											</div>
						   				</div>

										<div class="form-group">
											<label for="exam_type_id">Type</label>
											<select class="form-control" name="exam_type_id" id="exam_type_id">
												@foreach ($exam_types as $row)
													<option value="{{ $row->id }}">{{ $row->name }}</option>
												@endforeach
											</select>
										</div>

						   				<div class="form-group">
						   					<label for="subject">Subject</label>
						   					<select id="subject" name="subject" class="form-control">
						   						@foreach ($subjects as $row)
						   							<option value="{{ $row->id }}">{{ '['. $row->code .'] '. $row->name .' - '. $row->description }}</option>
						   						@endforeach
						   					</select>
						   				</div>

					   					<button type="submit" class="btn btn-primary">Create</button>
						   			</form>
						   		</div>
						   	</div>
						</div>
					</div><!-- end of #viewCreateExamModal -->
					@endcan

					@if (strtolower(auth()->user()->group->name) == 'student')
						<table data-toggle="table" data-url="{{ action('ClassSubjectExamController@getApi') }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar3">
							<thead>
								<tr>
									<th colspan="6" data-align="center">Exams</th>
								</tr>
								<tr>
									<th data-field="exam.title" data-formatter="takeExamTitleFormatter" data-sortable="true">Title</th>
									<th data-field="exam.assessment_category.name" data-sortable="true">Category</th>
									<th data-field="start" data-sortable="true">Start</th>
									<th data-field="end" data-sortable="true">End</th>
									<th data-field="created_at" data-sortable="true">Date Added</th>
								</tr>
							</thead>
						</table>
					@else
						<table data-toggle="table" data-url="{{ action('ExamController@getApi') }}?school_id={{ $school_id }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
							<thead>
								<tr>
									<th data-field="title" data-sortable="true">Title</th>
									<th data-field="assessment_category.name" data-sortable="true">Category</th>
									<th data-field="exam_type.name" data-sortable="true">Type</th>
									<th data-field="subject.name" data-sortable="true">Subject</th>
									<th data-formatter="examStatusFormatter">Status</th>
									<th data-field="created_at" data-sortable="true">Date Added</th>
									@can ('manage-exam')
										<th data-formatter="actionExamFormatter" data-align="center"></th>
									@endcan
								</tr>
							</thead>
						</table>
					@endif
				</div>
			</div>
		</div>
	</div>

@endsection
