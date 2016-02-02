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
					<button type="button" data-toggle="modal" data-target="#addCourseCalendarModal" name="button" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button>
                    <div data-toggle="calendar"></div>
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
					<div class="modal-body">
						<div class="form-group">
							<label for="title">Title</label>
							<input type="text" name="title" id="title" class="form-control">
						</div>
						<div class="form-group">
							<label for="description">Description</label>
							<textarea name="description" id="description" class="form-control"></textarea>
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
