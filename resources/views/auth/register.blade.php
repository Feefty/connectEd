@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">Register</div>
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
					<form action="{{ action('Auth\AuthController@postRegister') }}" method="POST">
						{!! csrf_field() !!}
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}">
						</div>
						<div class="form-group">
							<label for="email">E-mail</label>
							<input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" name="password" id="password" class="form-control">
						</div>
						<div class="form-group">
							<label for="password_confirmation">Confirm Password</label>
							<input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
						</div>
						<div class="form-group">
							<label for="group">Membership</label>
							<select id="group" name="group" class="form-control">
								<option value="4">Student</option>
								<option value="3">Teacher</option>
								<option value="2">School</option>
							</select>
						</div>
						<button class="btn btn-primary">Register</button>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection