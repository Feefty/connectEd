@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						<a href="{{ action('ClassSubjectController@getView', $class_subject->id) }}"><i class="fa fa-arrow-left"></i></a> Class Subject Edit
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

						<form action="{{ action('ClassSubjectController@postEdit') }}" method="POST">
							
							{!! csrf_field() !!}

							<input type="hidden" name="id" value="{{ (int) $class_subject->id }}">

			      			<div class="form-group">
		   						<label for="subject">Subject</label>
		   						<select id="subject" name="subject" class="form-control">
		   							@foreach ($subjects as $row)
		   								@if ($class_subject->subject_id == $row->id)
		   									<option value="{{ $row->id }}" selected>[{{ $row->code }}] {{ $row->name .' - '. $row->description }}</option>
		   								@else
		   									<option value="{{ $row->id }}">[{{ $row->code }}] {{ $row->name .' - '. $row->description }}</option>
		   								@endif
		   							@endforeach
		   						</select>
		   					</div>
		   					<div class="form-group">
		   						<label for="teacher">Teacher</label>
		   						<select id="teacher" name="teacher" class="form-control">
		   							@foreach ($teachers as $row)
		   								@if ($class_subject->teacher_id == $row->id)
		   									<option value="{{ $row->id }}" selected>{{ $row->first_name }} {{ $row->last_name }}</option>
		   								@else
		   									<option value="{{ $row->id }}">{{ $row->first_name }} {{ $row->last_name }}</option>
		   								@endif
		   							@endforeach
		   						</select>
		   					</div>
		   					<div class="form-group">
		   						<label for="room">Room</label>
		   						<input type="text" name="room" id="room" class="form-control" value='{{ $class_subject->room }}' required>
		   					</div>

			      			<button type="submit" class="btn btn-primary">Save</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection