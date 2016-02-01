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
		   					<label for="assessment_category_id">Category</label>
		   					<select id="assessment_category_id" name="assessment_category_id" class="form-control">
		   						@foreach ($assessment_categories as $row)
		   							@if ($exam->assessment_category_id == $row->id)
		   								<option value="{{ $row->id }}" selected>{{ $row->name }}</option>
		   							@else
		   								<option value="{{ $row->id }}">{{ $row->name }}</option>
		   							@endif
		   						@endforeach
		   					</select>
		   				</div>

		   				<div class="form-group">
		   					<label for="exam_type_id">Type</label>
		   					<select id="exam_type_id" name="exam_type_id" class="form-control">
		   						@foreach ($exam_types as $row)
		   							@if ($exam->exam_type_id == $row->id)
		   								<option value="{{ $row->id }}" selected>{{ $row->name }}</option>
		   							@else
		   								<option value="{{ $row->id }}">{{ $row->name }}</option>
		   							@endif
		   						@endforeach
		   					</select>
							<div class="help-block">
								The Quarterly Assessment needs to be verified first by the school to be answered by Students.
							</div>
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

						@if (strtolower(auth()->user()->group->name) == 'school admin')
							<div class="form-group">
								<label for="status">Status</label>
								<select class="form-control" name="status" id="status">
									@foreach (config('exam_status') as $row => $col)
										<option value="{{ $row }}">{{ $col }}</option>
									@endforeach
								</select>
							</div>
						@endif

						<button type="submit" class="btn btn-primary">Save Changes</button>
					</form>

				</div>
			</div>
		</div>
	</div>

@endsection
