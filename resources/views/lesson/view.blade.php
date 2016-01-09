@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Lesson View</div>
				<div class="panel-body">
					<h2>{{ $lesson->title }}</h2>

					<ul class="list-inline">
						<li><i class="fa fa-building"></i> {{ $lesson->school->name }}</li>
						<li><i class="fa fa-user"></i> {{ ucwords($lesson->user->profile->first_name .' '. $lesson->user->profile->last_name) }}</li>
						<li><i class="fa fa-book"></i> {{ '['. $lesson->subject->code .'] '.$lesson->subject->subject .' '. $lesson->subject->level .' - '. $lesson->subject->description }}</li>
						<li><i class="fa fa-clock-o"></i> {{ $lesson->created_at }}</li>
						@can ('update-lesson')
							@if (strtolower(auth()->user()->group->name) == 'teacher' && auth()->user()->id == $lesson->posted_by)
								<li><a href="{{ action('LessonController@getEdit', $lesson->id) }}"><i class="fa fa-pencil"></i> Edit</a></li>
							@endif
						@endcan
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