@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Settings E-mail</div>
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
					<form action="{{ action('SettingsController@postEmail') }}" method="POST">
						{!! csrf_field() !!}
						<div class="form-group">
							<label for="email">E-mail</label>
							<input type="email" name="email" id="email" class="form-control" value="{{ $email }}">
						</div>
						<hr>
						<div class="form-group">
							<label for="cpassword">Current Password</label>
							<input type="password" name="cpassword" id="cpassword" class="form-control">
						</div>
						<button class="btn btn-primary">Save Changes</button>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection
