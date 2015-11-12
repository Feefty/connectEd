@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>
				<div class="panel-body">
					@if (count($errors) > 0)
					    <div class="alert alert-danger">
					        <ul>
					            @foreach ($errors->all() as $error)
					                <li>{{ $error }}</li>
					            @endforeach
					        </ul>
					    </div>
					@endif
					<form action="{{ action('Auth\AuthController@postLogin') }}" method="POST">
						{!! csrf_field() !!}
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" name="username" id="username" class="form-control">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" name="password" id="password" class="form-control">
						</div>
						<div class="form-group">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="remember" value="1"> Remember me
								</label>
							</div>
						</div>
						<button class="btn btn-primary">Sign In</button> <a href="{{ action('Auth\AuthController@getRegister') }}" class="btn btn-link">Create an account</a>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection