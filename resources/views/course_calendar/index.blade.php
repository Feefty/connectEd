@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Course Calendar</div>
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
					@can ('create-course-calendar', 'strict')
						<button type="button" data-toggle="modal" data-target="#addCourseCalendarModal" name="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button>
					@endcan
					<div data-toggle="calendar" class="fullcalendar" data-source="{{ action('CourseCalendarController@getData') }}?school_id={{ @auth()->user()->school_member->school_id }}"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="addCourseCalendarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="exampleModalLabel">Course Calendar</h4>
				</div>
				<form action="{{ action('CourseCalendarController@postAdd') }}" method="post">
					{!! csrf_field() !!}
					<input type="hidden" name="school_id" value="{{ auth()->user()->school_member->school_id }}">
					<div class="modal-body">
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" name="title" id="title" class="form-control">
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" id="description" class="form-control"></textarea>
						</div>
						<div class="form-group">
							<label for="date_from">Date</label>
							<div class="input-group">
								<span class="input-group-addon">From</span>
								<input type="date" name="date_from" class="form-control">
								<span class="input-group-addon">To</span>
								<input type="date" name="date_to" class="form-control">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Create</button>
					</div>
				</form>
			</div>
		</div>
	</div>

@endsection
