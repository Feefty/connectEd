@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Exam Edit</div>
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

					<form method="POST" action="{{ action('ExamController@postEdit') }}">
						{!! csrf_field() !!}
						<input type="hidden" name="exam_id" value="{{ $exam->id }}">

						<div class="form-group">
		   					<label for="title">Title</label>
		   					<input type="text" name="title" id="title" class="form-control" value="{{ $exam->title }}">
		   				</div>

		   				<div class="form-group">
		   					<label for="exam_type">Type</label>
		   					<select id="exam_type" name="exam_type" class="form-control">
		   						@foreach ($exam_types as $row)
		   							@if ($exam->exam_type_id == $row->id)
		   								<option value="{{ $row->id }}" selected>{{ $row->name }}</option>
		   							@else
		   								<option value="{{ $row->id }}">{{ $row->name }}</option>
		   							@endif
		   						@endforeach
		   					</select>
		   				</div>

		   				<div class="form-group">
		   					<label for="subject">Subject</label>
		   					<select id="subject" name="subject" class="form-control">
		   						@foreach ($subjects as $row)
		   							@if ($exam->subject_id == $row->id)
		   								<option value="{{ $row->id }}" selected>{{ '['. $row->code .'] '. $row->name .' - '. $row->description }}</option>
		   							@else
		   								<option value="{{ $row->id }}">{{ '['. $row->code .'] '. $row->name .' - '. $row->description }}</option>
		   							@endif
		   						@endforeach
		   					</select>
		   				</div>

						<button type="submit" class="btn btn-primary">Save Changes</button>
					</form>

				</div>
			</div>
		</div>
	</div>

@endsection