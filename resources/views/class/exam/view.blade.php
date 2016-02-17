@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						<a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a>
						Class Subject Exam View
						<a href="{{ action('ClassSubjectExamController@getEdit', $class_subject_exam->id) }}" title="Edit" data-toggle="tooltip" class="pull-right"><i class="fa fa-pencil"></i></a>
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

						<h2>{{ $class_subject_exam->exam->title }} <small>{{ $class_subject_exam->exam->assessment_category->name }}</small></h2>
						<ul class="list-inline">
							<li>{{ config('quarter_calendar')[$class_subject_exam->quarter] }}</li>
							<li><i class="fa fa-book"></i> {{ $class_subject_exam->exam->subject->name }}</li>
							<li><i class="fa fa-flag"></i> {{ $class_subject_exam->exam->assessment_category->name }}</li>
							<li><i class="fa fa-calendar"></i> {{ $class_subject_exam->start .' to '. $class_subject_exam->end }}</li>
						</ul>
						<div class="text-helper">
							The list of students who are able to take the exam.
						</div>

						<div id="toolbar">
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
									<li><a href="#addUserModal" data-toggle="modal"><i class="fa fa-plus"></i> Add User</a></li>
								</ul>
							</div>
						</div>

						<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
						 		<div class="modal-content">
							      	<form action="{{ action('ClassSubjectExamUserController@postAdd') }}" method="post">
							    		<div class="modal-header">
							        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        		<h4 class="modal-title" id="myModalLabel">Exam Users</h4>
							      		</div>
								      	<div class="modal-body">
								      		{!! csrf_field() !!}

								      		<input type="hidden" name="class_subject_exam_id" value="{{ $class_subject_exam->id }}">

							   				<div class="form-group">
							   					<label for="user">Users</label>
							   					<select id="user" name="users[]" class="form-control" data-toggle="select" data-live-search="true" multiple>
							   						@foreach ($users as $row)
							   							<option value="{{ $row->user_id }}">{{ ucwords($row->last_name .', '. $row->first_name) }}</option>
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

						<table data-toggle="table" data-url="{{ action('ClassSubjectExamUserController@getApi') }}?class_subject_exam_id={{ $class_subject_exam->id }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
							<thead>
								<tr>
									<th colspan="4" data-align="center">Users</th>
								</tr>
								<tr>
									<th data-formatter="userProfileNameFormatter">Name</th>
									<th data-formatter="subjectExamGradeFormatter" data-sortable="true">Grade</th>
									<th data-field="created_at">Date Added</th>
									@can ('manage-class-subject-exam-user')
										<th data-formatter="actionClassSubjectExamUserFormatter" data-align="center">Actions</th>
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
