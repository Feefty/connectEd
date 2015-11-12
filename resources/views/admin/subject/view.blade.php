@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><a href="{{ action('Admin\SubjectController@getIndex') }}" class="small"><i class="fa fa-angle-double-left" title="Go back!"></i></a> Subject View</h1>
                    
                    <div class="row">
	                    <div class="col-xs-12">
	                    	<div class="panel panel-default">
	                    		<div class="panel-heading">
	                    			Subject
	                    			<a href="{{ action('Admin\SubjectController@getEdit', $subject->id) }}" class="pull-right"><i class="fa fa-pencil"></i></a>
	                    		</div>
		                    	<div class="panel-body">
				                    <table class="table">
				                    	<tr>
				                    		<td><label>Name</label></td>
				                    		<td>{{ $subject->name }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Code</label></td>
				                    		<td>{{ $subject->code }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Description</label></td>
				                    		<td>{{ $subject->description }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Date Added</label></td>
				                    		<td>{{ $subject->created_at }}</td>
				                    	</tr>
				                    </table>
		                    	</div>
		                    </div>
	                    </div>
                    </div>
                    <span class="small text-muted">Last updated: {{ $subject->updated_at or 'not yet updated' }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection