@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Lesson View
					@can ('update-lesson')
						@if (strtolower(auth()->user()->group->name) == 'teacher' && auth()->user()->id == $lesson->posted_by)
							<a href="{{ action('LessonController@getEdit', $lesson->id) }}" class="pull-right"><i class="fa fa-pencil"></i> Edit</a>
						@endif
					@endcan
				</div>
				<div class="panel-body">
					<h2>{{ $lesson->title }}</h2>

					<ul class="list-inline">
						<li><i class="fa fa-building"></i> <a href="{{ action('SchoolController@getView').'/'. $lesson->school_id }}">{{ $lesson->school->name }}</a></li>
						<li><i class="fa fa-user"></i> <a href="{{ action('ProfileController@getUser', $lesson->user->username) }}">{{ ucwords($lesson->user->profile->first_name .' '. $lesson->user->profile->last_name) }}</a></li>
						<li><i class="fa fa-book"></i> {{ '['. $lesson->subject->code .'] '.$lesson->subject->subject }}</li>
						<li><i class="fa fa-clock-o"></i> {{ $lesson->created_at }}</li>
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
