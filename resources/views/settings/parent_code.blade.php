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
					<form action="{{ action('SettingsController@postParentCode') }}" method="POST">
						{!! csrf_field() !!}
						<div class="form-group">
							<label for="parent_code">Parent Codde</label>
							<input type="text" name="parent_code" id="parent_code" class="form-control" value="{{ $parent_code }}" readonly>
                            <div class="text-helper">
                                Give this code to your parent.
                            </div>
						</div>
						<button class="btn btn-primary">Regenerate</button>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection
