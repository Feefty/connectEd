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
										<td><strong>Membership</strong></td>
										<td>: {{ @$user->group->name }}</td>
									</tr>
									<tr>
										<td><strong>School</strong></td>
										<td>: {{ @$user->school_member->school->name }}</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>

			@if ($user->group->name == 'Student')
				<div class="panel panel-default">
					<div class="panel-heading">Subject Portfolio</div>
					<div class="panel-body">

					</div>
				</div>
			@endif
		</div>
	</div>

@endsection