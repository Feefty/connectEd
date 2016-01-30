@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Settings Profile</div>
				<div class="panel-body">
					<ul class="breadcrumb">
						<li><a href="{{ action('SettingsController@getProfile') }}">Profile</a></li>
						<li><a href="{{ action('SettingsController@getPhoto') }}">Photo</a></li>
						<li><a href="{{ action('SettingsController@getPassword') }}">Password</a></li>
						<li><a href="{{ action('SettingsController@getEmail') }}">E-mail</a></li>
						@if (strtolower(auth()->user()->group->name) == 'student')
							<li><a href="{{ action('SettingsController@getParentCode') }}">Parent Code</a></li>
						@endif
					</ul>
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
					<form action="{{ action('SettingsController@postProfile') }}" method="POST">
						{!! csrf_field() !!}
						<div class="form-group">
							<label for="first_name">First Name</label>
							<input type="text" name="first_name" id="first_name" class="form-control" value="{{ $profile->first_name }}">
						</div>
						<div class="form-group">
							<label for="middle_name">Middle Name</label>
							<input type="text" name="middle_name" id="middle_name" class="form-control" value="{{ $profile->middle_name }}">
						</div>
						<div class="form-group">
							<label for="last_name">Last Name</label>
							<input type="text" name="last_name" id="last_name" class="form-control" value="{{ $profile->last_name }}">
						</div>
						<div class="form-group">
							<label for="birthday">Birthday</label>
							<input type="date" name="birthday" id="birthday" class="form-control"  value="{{ $profile->birthday }}">
						</div>
						<div class="form-group">
							<label for="gender">Gender</label>
							<select id="gender" name="gender" class="form-control">
								@foreach (config('gender') as $row => $col)
									@if ($profile->gender == $row)
										<option value="{{ $row }}" selected>{{ $col }}</option>
									@else
										<option value="{{ $row }}">{{ $col }}</option>
									@endif
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="address">Address</label>
							<textarea id="address" name="address" class="form-control">{{ $profile->address }}</textarea>
						</div>
						<button class="btn btn-primary">Save Changes</button>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection
