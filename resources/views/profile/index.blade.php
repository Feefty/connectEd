@extends('main')

@section('content')
	<div class="row">
		<div class="col-md-2 profile-sidebar" id="profile-spy">
			<ul class="nav nav-pills nav-stacked col-md-2" data-spy="affix">
				<li><a href="#basic-info"><i class="fa fa-info fa-fw"></i> Basic Information</a></li>
				@if (strtolower($user->group->name) == 'student')
					<li><a href="#performance"><i class="fa fa-line-chart fa-fw"></i> Performances</a></li>
					<li><a href="#grades"><i class="fa fa-file-text-o fa-fw"></i> Grades</a></li>
				@endif
			</ul>
		</div>
		<div class="col-md-8">
			<div class="panel panel-default" id="basic-info">
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
				<div class="panel panel-default" id="performance">
					<div class="panel-heading">Performances</div>
					<div class="panel-body">
						<canvas id="assessment-radar" data-student-id="{{ $user->id }}" class="center-block" width="500" height="500"></canvas>
					</div>
				</div>
					<div class="panel panel-default" id="grades">
						<div class="panel-heading">Grades</div>
						<div class="panel-body">
						</div>
					</div>
			@endif
		</div>
	</div>

@endsection
