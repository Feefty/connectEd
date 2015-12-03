@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						Class Subject View
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
								<td><strong>Section:</strong> <a href="{{ action('ClassSectionController@getView', $class_subject->class_section_id) }}">{{ config('grade_level')[$class_subject->section_level] }} - {{ $class_subject->section }}</a></td>
							</tr>
							<tr>
								<td><strong>Subject:</strong> {{ $class_subject->subject }}</td>
							</tr>
							<tr>
								<td><strong>Room:</strong> {{ $class_subject->room }}</td>
							</tr>
							<tr>
								<td><strong>Teacher:</strong> {{ $class_subject->teacher }}</td>
							</tr>
						</table>

						<div id="toolbar">
                    		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addScheduleModal"><i class="fa fa-plus"></i> Add Schedule</button>

			   				<div class="modal fade" id="addScheduleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								<div class="modal-dialog" role="document">
							 		<div class="modal-content">
								      	<form action="{{ action('SubjectScheduleController@postAdd') }}" method="post">
								    		<div class="modal-header">
								        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								        		<h4 class="modal-title" id="myModalLabel">Subject Schedule</h4>
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
							</div>
						</div>

						<table data-toggle="table" data-url="{{ action('SubjectScheduleController@getAPI', $class_subject->id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
							<thead>
								<tr>
									<th data-formatter="dayFormatter">Day</th>
									<th data-field="time">Time</th>
									<th data-formatter="actionClassSubjectScheduleFormatter" data-align="center">Actions</th>
								</tr>
							</thead>
						</table>
					</div>	
				</div>
			</div>
		</div>
	</div>

@endsection