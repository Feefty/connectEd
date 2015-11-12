@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><a href="{{ action('Admin\UserController@getIndex') }}" class="small"><i class="fa fa-angle-double-left" title="Go back!"></i></a> User View</h1>
                    
                    <div class="row">
	                    <div class="col-md-6">
	                    	<div class="panel panel-default">
	                    		<div class="panel-heading">
	                    			Account
	                    			@can('update-user')
	                    			<a href="{{ action('Admin\UserController@getEdit', $user->id) }}" class="pull-right"><i class="fa fa-pencil"></i></a>
	                    			@endcan
	                    		</div>
		                    	<div class="panel-body">
				                    <table class="table">
				                    	<tr>
				                    		<td><label>ID</label></td>
				                    		<td>{{ $user->id }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Username</label></td>
				                    		<td>{{ $user->username }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>E-mail</label></td>
				                    		<td>{{ $user->email }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Group</label></td>
				                    		<td>{{ $user->group }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Status</label></td>
				                    		<td>{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Date Joined</label></td>
				                    		<td>{{ $user->created_at }}</td>
				                    	</tr>
				                    </table>
		                    	</div>
		                    </div>
	                    </div>
	                    <div class="col-md-6">
	                    	<div class="panel panel-default">
	                    		<div class="panel-heading">
	                    			Profile
	                    			@can('update-user')
	                    			<a href="{{ action('Admin\UserController@getEdit', $user->id) }}" class="pull-right"><i class="fa fa-pencil"></i></a>
	                    			@endcan
	                    		</div>
		                    	<div class="panel-body">
				                    <table class="table">
				                    	<tr>
				                    		<td><label>Name</label></td>
				                    		<td>{{ $user->name or '-' }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Gender</label></td>
				                    		<td>{{ config('gender')[$user->gender or 1] }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Birthday</label></td>
				                    		<td>{{ $user->birthday or '-' }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Address</label></td>
				                    		<td>{{ $user->address or '-' }}</td>
				                    	</tr>
				                    </table>
		                    	</div>
		                    </div>
	                    </div>
                    </div>
                    <span class="small text-muted">Last updated: {{ $user->updated_at or 'not yet updated' }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection