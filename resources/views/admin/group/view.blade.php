@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><a href="{{ action('Admin\GroupController@getIndex') }}" class="small"><i class="fa fa-angle-double-left" title="Go back!"></i></a> Group View</h1>
                    
                    <div class="row">
	                    <div class="col-xs-12">
	                    	<div class="panel panel-default">
	                    		<div class="panel-heading">
	                    			Group
	                    			<a href="{{ action('Admin\GroupController@getEdit', $group->id) }}" class="pull-right"><i class="fa fa-pencil"></i></a>
	                    		</div>
		                    	<div class="panel-body">
				                    <table class="table">
				                    	<tr>
				                    		<td><label>Name</label></td>
				                    		<td>{{ $group->name }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Level</label></td>
				                    		<td>{{ $group->level }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Description</label></td>
				                    		<td>{{ $group->description }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Date Added</label></td>
				                    		<td>{{ $group->created_at }}</td>
				                    	</tr>
				                    </table>
		                    	</div>
		                    </div>
	                    </div>
                    </div>
                    <span class="small text-muted">Last updated: {{ $group->updated_at or 'not yet updated' }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection