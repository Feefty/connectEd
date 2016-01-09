@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						<a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Subject Schedule Edit
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

						<form action="{{ action('SubjectScheduleController@postEdit') }}" method="POST">
							
							{!! csrf_field() !!}
							<input type="hidden" name="id" value="{{ (int) $subject_schedule->id }}">
							<input type="hidden" name="class_subject_id" value="{{ $subject_schedule->class_subject_id }}">

			      			<div class="form-group">
			      				<div class="row">
					      			<div class="col-md-4">
		   								<label>Day</label>
		   								<select name="day" class="form-control">
		   									@foreach (config('days') as $row => $col)
		   										@if ($subject_schedule->day == $row)
		   											<option value="{{ $row }}" selected="">{{ $col }}</option>
		   										@else
		   											<option value="{{ $row }}">{{ $col }}</option>
		   										@endif
		   									@endforeach
		   								</select>
		   							</div>
		   							<div class="col-md-4">
		   								<label>Time Start</label>
		   								<input type="time" name="time_start" class="form-control" value="{{ $subject_schedule->time_start }}">
		   							</div>
		   							<div class="col-md-4">
		   								<label>Time End</label>
		   								<input type="time" name="time_end" class="form-control" value="{{ $subject_schedule->time_end }}">
		   							</div>
			      				</div>
			      			</div>

			      			<button type="submit" class="btn btn-primary">Save</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection