@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Lessons</div>
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
						@can ('manage-lesson')
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
									@can ('create-lesson')
										<li><a href="#viewCreateLessonModal" data-toggle="modal"><i class="fa fa-plus"></i> Create</a></li>
									@endcan
								</ul>
							</div>
						@endcan
					</div>

					<input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
					<input type="hidden" name="group_name" value="{{ strtolower(auth()->user()->group->name) }}">

					@can ('create-lesson')
					<div class="modal fade" id="viewCreateLessonModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
						    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						    		<h4 class="modal-title" id="modalLabel">Lessons</h4>
						   		</div>
						   		<div class="modal-body">
						   			<form method="POST" action="{{ action('LessonController@postAdd') }}" enctype="multipart/form-data">
						   				{!! csrf_field() !!}
						   				<input type="hidden" name="school_id" value="{{ $school_id }}">

						   				<div class="form-group">
						   					<label for="title">Title</label>
						   					<input type="text" name="title" id="title" class="form-control">
						   				</div>
						   				<div class="form-group">
						   					<label for="content">Content</label>
						   					<textarea id="content" name="content" class="form-control"></textarea>
						   				</div>
						   				<div class="form-group">
						   					<label for="subject">Subject</label>
											<select id="subject" name="subject" class="form-control">
												@foreach ($subjects as $subject)
													<option value="{{ $subject->id }}">{{ '['. $subject->code .'] '. $subject->name .' '. $subject->level .' - '. $subject->description }}</option>
												@endforeach
											</select>
						   				</div>

						   				<div class="form-group">
					   						<label>Lesson Files</label>
					   						<div class="text-muted small">
					   							Maximum file size is {{ config('lesson.file.size') }}kb
					   						</div>

					   						<div class="add-more-items">
					   							<div class="row">
						   							<div class="col-xs-12">
							   							<input type="file" name="file[]">
						   							</div>
					   							</div>
					   						</div>

					   						<div id="add-more-holder"></div>
					   					</div>

					   					<div class="margin-lg-top">
					   						<button type="button" id="add-more" class="btn btn-info">Add More File</button>
					   						<button type="submit" class="btn btn-primary">Create</button>
					   					</div>
						   			</form>
						   		</div>
						   	</div>
						</div>
					</div><!-- end of #viewCreateLessonModal -->
					@endcan

					<table data-toggle="table" data-url="{{ action('LessonController@getApi', $school_id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
						<thead>
							<tr>
								<th data-field="title">Title</th>
								<th data-formatter="subjectNameFormatter">Subject</th>
								<th data-formatter="userProfileNameFormatter">Posted By</th>
								<th data-field="created_at">Date Created</th>
								@can ('manage-lesson')
									<th data-formatter="actionLessonFormatter" data-align="center">Actions</th>
								@endcan
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection