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
							<input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
						</div>
						<div class="form-group">
							<label for="email">E-mail</label>
							<input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" name="password" id="password" class="form-control" required>
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

						<hr>
						<h3>Profile Information</h3>

						<div class="form-group">
							<label for="first_name">First Name</label>
							<input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
						</div>

						<div class="form-group">
							<label for="middle_name">Middle Name</label>
							<input type="text" name="middle_name" id="middle_name" class="form-control" value="{{ old('middle_name') }}" placeholder="Optional">
						</div>

						<div class="form-group">
							<label for="last_name">Last Name</label>
							<input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" required>
						</div>

						<div class="form-group">
							<label for="address">Address</label>
							<textarea name="address" id="address" class="form-control" required>{{ old('address') }}</textarea>
						</div>

						<div class="form-group">
							<label for="birthday">Birthday</label>
							<input type="date" name="birthday" id="birthday" class="form-control" value="{{ old('birthday') }}" required>
						</div>

						<div class="form-group">
							<label for="gender">Gender</label>
							<div class="radio">
								<label>
									<input type="radio" name="gender" value="1" checked>
									Male
								</label>
								<label>
									<input type="radio" name="gender" value="0">
									Female
								</label>
							</div>
						</div>

						<button class="btn btn-primary">Register</button>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection