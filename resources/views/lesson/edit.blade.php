@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Lesson Edit</div>
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
					
					<form method="POST" action="{{ action('LessonController@postEdit') }}" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
						<input type="hidden" name="subject" value="{{ $lesson->subject_id }}">

						<div class="form-group">
		   					<label for="title">Title</label>
		   					<input type="text" name="title" id="title" class="form-control" value="{{ $lesson->title }}">
		   				</div>
		   				<div class="form-group">
		   					<label for="content">Content</label>
		   					<textarea id="content" name="content" class="form-control">{{ $lesson->content }}</textarea>
		   				</div>
		   				<div class="form-group">
		   					<label for="subject">Subject</label>
							<select id="subject" class="form-control" disabled>
								@foreach ($subjects as $subject)
									@if ($lesson->subject_id == $subject->id)
										<option value="{{ $subject->id }}" selected>{{ '['. $subject->code .'] '. $subject->name .' '. $subject->level .' - '. $subject->description }}</option>
									@else
										<option value="{{ $subject->id }}">{{ '['. $subject->code .'] '. $subject->name .' '. $subject->level .' - '. $subject->description }}</option>
									@endif
								@endforeach
							</select>
		   				</div>

		   				<div class="form-group">
	   						<label>Lesson Files</label>
	   						<div class="text-muted small">
	   							Maximum file size is {{ config('lesson.file.size') }}kb
	   						</div>

	   						<ul>
		   						@foreach ($lesson->file as $file)
		   							<li>{{ $file->name }} <a href="{{ action('LessonController@getDeleteFile', $file->id) }}" data-toggle="tooltip" title="Delete file" onclick="return confirm('Are you sure you want to delete this item?')"><i class="fa fa-remove text-danger"></i></a> <small class="text-muted">{{ $file->created_at }}</small></li>
		   						@endforeach
	   						</ul>

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
	   						<button type="submit" class="btn btn-primary">Save Changes</button>
	   					</div>
					</form>

				</div>
			</div>
		</div>
	</div>

@endsection