@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Profile</div>
				<div class="panel-body">
					<table class="table">
						<tr>
							<td><label>Name</label></td>
							<td>{{ $profile->name or '-' }}</td>
						</tr>
                    	<tr>
                    		<td><label>Gender</label></td>
                    		<td>{{ config('gender')[$profile->gender] }}</td>
                    	</tr>
                    	<tr>
                    		<td><label>Birthday</label></td>
                    		<td>{{ $profile->birthday or '-' }}</td>
                    	</tr>
                    	<tr>
                    		<td><label>Address</label></td>
                    		<td>{{ $profile->address or '-' }}</td>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection