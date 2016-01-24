@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Profile</div>
				<div class="panel-body">
					<h3>{{ ucwords($user->profile->first_name .' '. $user->profile->last_name) }}</h3>
					<table>
						<tr>
							<td rowspan="5">
								@if ( ! empty($user->profile->photo) && ! is_null($user->profile->photo))
									<img src="{{ config('profile.photo.path') . $user->profile->photo }}" class="img-thumbnail">
								@endif
							</td>
						</tr>
						<tr>
							<td style="vertical-align: top">
								<table class="table">
									<tr>
										<td><h4>INFORMATION</h4></td>
									</tr>
									<tr>
										<td><strong>Gender</strong></td>
										<td>: 
											@if ($user->profile->gender == 1)
												<i class="fa fa-mars"></i> Male
											@else
												<i class="fa fa-venus"></i> Female
											@endif
										</td>
									</tr>
									<tr>
										<td><strong>Birthday</strong></td>
										<td>: {{ $user->profile->birthday }}</td>
									</tr>
									<tr>
										<td><strong>Address</strong></td>
										<td>: {{ $user->profile->address }}</td>
									</tr>
									<tr>
										<td><strong>Role</strong></td>
										<td>: {{ @$user->group->name }}</td>
									</tr>
									@if ( ! is_null($user->school_member))
									<tr>
										<td><strong>School</strong></td>
										<td>: <a href="{{ action('SchoolController@getIndex') }}/{{ $user->school_member->school->id }}">{{ $user->school_member->school->name }}</a></td>
									</tr>
									@endif
									@if (strtolower($user->group->name) == 'student')
										<tr>
											<td><strong>Section</strong></td>
											<td>: [{{ config('grade_level')[$user->class_student->class_section->level] }}] {{ $user->class_student->class_section->name }}</td>
										</tr>
										<tr>
											<td><strong>Adivser</strong></td>
											<td>: <a href="{{ action('ProfileController@getUser', $user->class_student->class_section->teacher->username) }}">{{ ucwords(strtolower($user->class_student->class_section->teacher->profile->last_name .', '. $user->class_student->class_section->teacher->profile->first_name)) }}</a></td>
										</tr>
									@endif
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>

			@if (strtolower($user->group->name) == 'student')
				<div class="panel panel-default">
					<div class="panel-heading">My Performance</div>
					<div class="panel-body">
						<canvas id="assessment-radar" class="center-block" width="500" height="500"></canvas>
					</div>
				</div>
			@endif
		</div>
	</div>

@endsection