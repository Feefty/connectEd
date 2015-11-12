@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><a href="{{ action('Admin\UserController@getIndex') }}" class="small"><i class="fa fa-angle-double-left" title="Go back!"></i></a> User Edit</h1>
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
                    
                    <div class="row">
                    	<div class="col-md-6">
                    		<div class="panel panel-default">
                    			<div class="panel-heading">
                    				Account
                    			</div>
		                    	<div class="panel-body">
		                    		<form action="{{ action('Admin\UserController@postEditAccount') }}" method="POST">
		                    			{!! csrf_field() !!}
		                    			<input type="hidden" name="user_id" value="{{ $user->id }}">

		                    			<div class="form-group">
		                    				<label for="user_id">ID</label>
		                    				<input type="text" id="user_id" class="form-control" value="{{ $user->id }}" readonly>
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="username">Username</label>
		                    				<input type="text" name="username" id="username" class="form-control" value="{{ $user->username }}">
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="npassword">New Password</label>
		                    				<input type="password" name="npassword" id="npassword" class="form-control">
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="npassword_confirmation">Confirm New Password</label>
		                    				<input type="password" name="npassword_confirmation" id="npassword_confirmation" class="form-control">
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="email">E-mail</label>
		                    				<input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="group">Group</label>
						      				<select id="group" name="group" class="form-control">
						      					@foreach ($groups as $row)
						      						@if ($user->group_id == $row->id)
						      							<option value="{{ $row->id }}" selected>{{ $row->name .' ('. $row->level }})</option>
						      						@else
						      							<option value="{{ $row->id }}">{{ $row->name .' ('. $row->level }})</option>
						      						@endif
						      					@endforeach
						      				</select>
		                    			</div>
		                    			<div class="form-group">
		                    				<label>Status</label>
			                    			<div class="radio">
			                    				<label>
			                    					<input type="radio" name="status" value="1"{{ $user->status == 1 ? ' checked' : '' }}> Active
			                    				</label>
			                    				<label>
			                    					<input type="radio" name="status" value="0"{{ $user->status == 0 ? ' checked' : '' }}> Inactive
			                    				</label>
			                    			</div>
		                    			</div>
		                    			<button type="submit" class="btn btn-primary">Save Changes to Account</button>
		                    		</form>
		                    	</div>
		                    </div>
                    	</div>
                    	<div class="col-md-6">
                    		<div class="panel panel-default">
                    			<div class="panel-heading">
                    				Profile
                    			</div>
		                    	<div class="panel-body">
		                    		<form action="{{ action('Admin\UserController@postEditProfile') }}" method="POST">
		                    			{!! csrf_field() !!}
		                    			<input type="hidden" name="user_id" value="{{ $user->id }}">

		                    			<div class="form-group">
		                    				<label for="first_name">First Name</label>
		                    				<input type="text" name="first_name" id="first_name" class="form-control" value="{{ $user->first_name }}">
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="middle_name">Middle Name</label>
		                    				<input type="text" name="middle_name" id="middle_name" class="form-control" value="{{ $user->middle_name }}">
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="last_name">Last Name</label>
		                    				<input type="text" name="last_name" id="last_name" class="form-control" value="{{ $user->last_name }}">
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="gender">Gender</label>
		                    				<select name="gender" id="gender" class="form-control">
		                    					@foreach (config('gender') as $row => $col)
		                    						@if ($user->gender == $row)
		                    							<option value="{{ $row }}" selected>{{ $col }}</option>
		                    						@else
		                    							<option value="{{ $row }}">{{ $col }}</option>
		                    						@endif
		                    					@endforeach
		                    				</select>
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="birthday">Birthday</label>
		                    				<input type="date" name="birthday" id="birthday" class="form-control" value="{{ $user->birthday }}">
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="address">Address</label>
		                    				<textarea name="address" id="address" class="form-control">{{ $user->address }}</textarea>
		                    			</div>
		                    			<button type="submit" class="btn btn-primary">Save Changes to Profile</button>
		                    		</form>
		                    	</div>
		                    </div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection