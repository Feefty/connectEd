@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						<a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Class Section Edit
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

						<form action="{{ action('ClassSectionController@postEdit') }}" method="POST">
							
							{!! csrf_field() !!}

							<input type="hidden" name="id" value="{{ (int) $class_section->id }}">

			      			<div class="form-group">
			      				<label for="name">Name</label>
			      				<input type="text" name="name" id="name" class="form-control" value="{{ $class_section->name }}">
			      			</div>
			      			<div class="form-group">
			      				<label for="adviser">Adviser</label>
			      				<select id="adviser" name="adviser" class="form-control">
			      					@foreach ($teachers as $row)
			      						@if ($class_section->adviser_id == $row->id)
			      							<option value="{{ $row->id }}" selected>{{ $row->username }}</option>
			      						@else
			      							<option value="{{ $row->id }}">{{ $row->username }}</option>
			      						@endif
			      					@endforeach
			      				</select>
			      			</div>
			      			<div class="form-group">
			      				<label for="level">Level</label>
			      				<select id="level" name="level" class="form-control">
			      					@foreach (config('grade_level') as $row => $col)
			      						@if ($class_section->level == $row)
			      							<option value="{{ $row }}" selected>{{ $col }}</option>
			      						@else
			      							<option value="{{ $row }}">{{ $col }}</option>
			      						@endif
			      					@endforeach
			      				</select>
			      			</div>
			      			<div class="form-group">
			      				<label for="year">Year</label>
			      				<select id="year" name="year" class="form-control">
			      					@for ($y = date('Y'); $y >= 1990; $y--)
			      						@if ($class_section->year == $y)
			      							<option value="{{ $y }}" selected>{{ $y }}</option>
			      						@else
			      							<option value="{{ $y }}">{{ $y }}</option>
			      						@endif
			      					@endfor
			      				</select>
			      			</div>
			      			<div class="form-group">
			      				<label for="status">Status</label>
			      				<div class="radio">
			      					@if ($class_section->status == 1)
				      					<label>
				      						<input type="radio" name="status" value="1" checked>
				      						Enable
				      					</label>
				      					<label>
				      						<input type="radio" name="status" value="0">
				      						Disable
				      					</label>
			      					@else
				      					<label>
				      						<input type="radio" name="status" value="1">
				      						Enable
				      					</label>
				      					<label>
				      						<input type="radio" name="status" value="0" checked>
				      						Disable
				      					</label>
			      					@endif
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