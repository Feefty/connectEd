@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">School</div>
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

					@if (strtolower(auth()->user()->group->name) == 'school admin')
						<a href="{{ action('SchoolController@getEdit', $school->id) }}" class="pull-right"><i class="fa fa-pencil"></i></a>
					@endif
					<div class="text-center">
						@if ($school->logo)
							<img src="{{ asset('/img/schools/'. $school->logo) }}" alt="" class="school-logo">
						@endif
						<h2>{{ $school->name }}</h2>
						<h4>{{ $school->description }}</h4>
						<ul class="list-inline">
							<li><strong>Address:</strong> {{ $school->address }}</li>
							<li><strong>Contact No.:</strong> {{ $school->contact_no }}</li>
							<li><strong>Website:</strong> {{ $school->website }}</li>
						</ul>
						<h2>Motto</h2>
						<em>"{{ $school->motto }}"</em>
						<h2>Mission</h2>
						<em>"{{ $school->mission }}"</em>
						<h2>Vision</h2>
						<em>"{{ $school->vision }}"</em>
						<h2>Goal</h2>
						<em>"{{ $school->goal }}"</em>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Statistic</div>
				<div class="panel-body">
					<table class="table table-bordered">
						<tr>
							<td>
								<label>Teachers:</label> {{ number_format($school->whereHas('member.user.group', function($query) {
									$query->where('name', 'Teacher');
								})->count()) }}
							</td>
							<td>
								<label>Students:</label> {{ number_format($school->whereHas('member.user.group', function($query) {
									$query->where('name', 'Student');
								})->count()) }}
							</td>
							<td>
								<label>Sections:</label> {{ number_format($school->class_section->count()) }}
							</td>
							<td>
								<label>Exams:</label> {{ number_format($school->exam->count()) }}
							</td>
							<td>
								<label>Lessons:</label> {{ number_format($school->lesson->count()) }}
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection
