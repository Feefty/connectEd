@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Lesson View</div>
				<div class="panel-body">
					<h2>{{ $lesson->title }}</h2>

					<ul class="list-inline small">
						<li>{{ $lesson->school_name }}</li>
						<li>{{ $lesson->posted_by }}</li>
						<li>{{ '['. $lesson->code .'] '.$lesson->subject .' '. $lesson->level .' - '. $lesson->description }}</li>
						<li>{{ $lesson->created_at->diffForHumans() }}</li>
					</ul>

					{!! nl2br($lesson->content) !!}

					<ul>
						@foreach ($lesson->file as $file)
							<li><a href="{{ action('LessonController@getFile', $file->id) }}">{{ $file->name }}</a> <small class="text-muted">{{ $file->created_at }}</small></li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>

@endsection