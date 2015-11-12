@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><a href="{{ action('Admin\AchievementController@getIndex') }}" class="small"><i class="fa fa-angle-double-left" title="Go back!"></i></a> Achievement View</h1>
                    
                    <div class="row">
	                    <div class="col-xs-12">
	                    	<div class="panel panel-default">
	                    		<div class="panel-heading">
	                    			Achievement
	                    			<a href="{{ action('Admin\AchievementController@getEdit', $achievement->id) }}" class="pull-right"><i class="fa fa-pencil"></i></a>
	                    		</div>
		                    	<div class="panel-body">
				                    <table class="table">
				                    	<tr>
				                    		<td><label>Title</label></td>
				                    		<td>{{ $achievement->title }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Description</label></td>
				                    		<td>{{ $achievement->description }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Date Added</label></td>
				                    		<td>{{ $achievement->created_at }}</td>
				                    	</tr>
				                    </table>
		                    	</div>
		                    </div>
	                    </div>
                    </div>
                    <span class="small text-muted">Last updated: {{ $achievement->updated_at or 'not yet updated' }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection