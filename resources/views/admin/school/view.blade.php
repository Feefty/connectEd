@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><a href="{{ action('Admin\SchoolController@getIndex') }}" class="small"><i class="fa fa-angle-double-left" title="Go back!"></i></a> School View</h1>
                    
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
	                    <div class="col-xs-12">
	                    	<div class="panel panel-default">
	                    		<div class="panel-heading">
	                    			School
	                    			<a href="{{ action('Admin\SchoolController@getEdit', $school->id) }}" class="pull-right"><i class="fa fa-pencil"></i></a>
	                    		</div>
		                    	<div class="panel-body">
				                    <table class="table">
				                    	<tr>
				                    		<td><label>Name</label></td>
				                    		<td>{{ $school->name }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Address</label></td>
				                    		<td>{{ $school->address }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Description</label></td>
				                    		<td>{{ $school->description }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Date Added</label></td>
				                    		<td>{{ $school->created_at }}</td>
				                    	</tr>
				                    </table>
		                    	</div>
		                    </div>
	                    </div>
                    </div>
                    <div class="small text-muted margin-lg-bottom">Last updated: {{ $school->updated_at or 'not yet updated' }}</div>

                    <div class="row">
	                    <div class="col-xs-12">
	                    	<div class="panel panel-default">
	                    		<div class="panel-heading">
	                    			Admins
	                    		</div>
		                    	<div class="panel-body">
		                    		<div id="toolbar">
					                    <form action="{{ action('Admin\SchoolController@postAddMember') }}" method="POST" class="form-inline">
					                    	{!! csrf_field() !!}
					                    	<input type="hidden" name="school_id" value="{{ $school->id }}">
					                    	<div class="form-group">
					             				<div class="input-group">
					                    			<input type="text" class="form-control" name="username" placeholder="Enter Username">
					                    			<span class="input-group-btn">
					             						<button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i></button>
					             					</span>
					             				</div>
					                    	</div>
					                    </form>
		                    		</div>
                    				<table data-toggle="table" data-url="{{ action('Admin\SchoolController@getMemberAPI', $school->id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
				                    	<thead>
				                    		<tr>
				                    			<th data-formatter="usernameFormatter" data-sortable="true">Username</th>
				                    			<th data-field="created_at" data-sortable="true">Date Added</th>
				                    			<th data-formatter="actionMemberSchoolFormatter">Actions</th>
				                    		</tr>
				                    	</thead>
				                    </table>
		                    	</div>
		                    </div>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection