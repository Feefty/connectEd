@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Settings Photo</div>
				<div class="panel-body">
					<ul class="breadcrumb">
						<li><a href="{{ action('SettingsController@getProfile') }}">Profile</a></li>
						<li><a href="{{ action('SettingsController@getPhoto') }}">Photo</a></li>
						<li><a href="{{ action('SettingsController@getPassword') }}">Password</a></li>
						<li><a href="{{ action('SettingsController@getEmail') }}">E-mail</a></li>
						<li><a href="{{ action('SettingsController@getParentCode') }}">Parent Code</a></li>
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
					<form action="{{ action('SettingsController@postPhoto') }}" method="POST" enctype="multipart/form-data">
						{!! csrf_field() !!}
						<div class="form-group">
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 250px;">
									@if ( ! empty($profile->photo) && ! is_null($profile->photo))
										<img src="{{ config('profile.photo.path') . $profile->photo }}">
									@endif
								</div>
								<div>
									<span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="photo"></span>
									<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
								</div>
							</div>
						</div>
						<button class="btn btn-primary">Save Changes</button>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection
