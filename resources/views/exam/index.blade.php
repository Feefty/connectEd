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
						   					<label for="exam_type">Type</label>
						   					<select id="exam_type" name="exam_type" class="form-control">
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

					<table data-toggle="table" data-url="{{ action('ExamController@getApi') }}?school_id={{ $school_id }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
						<thead>
							<tr>
								@can ('take-exam', 'strict')

									<th data-formatter="examTakeExamTitleFormatter" data-sortable="true">Title</th>
								@else
									<th data-field="title" data-sortable="true">Title</th>
								@endcan
								<th data-formatter="examTypeFormatter" data-sortable="true">Type</th>
								<th data-formatter="subjectNameFormatter" data-sortable="true">Subject</th>
								<th data-field="created_at" data-sortable="true">Date Added</th>
								@can ('manage-exam')
									<th data-formatter="actionExamFormatter" data-align="center"></th>
								@endcan
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection