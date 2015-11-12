@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><a href="{{ action('Admin\GroupController@getIndex') }}" class="small"><i class="fa fa-angle-double-left" title="Go back!"></i></a> Group Edit</h1>
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
                    				Group
                    			</div>
		                    	<div class="panel-body">
		                    		<form action="{{ action('Admin\GroupController@postEdit') }}" method="POST">
		                    			{!! csrf_field() !!}
		                    			<input type="hidden" name="group_id" value="{{ $group->id }}">

		                    			<div class="form-group">
		                    				<label for="group_id">ID</label>
		                    				<input type="text" id="group_id" class="form-control" value="{{ $group->id }}" readonly>
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="name">Name</label>
		                    				<input type="text" name="name" id="name" class="form-control" value="{{ $group->name }}">
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="level">Level</label>
		                    				<input type="number" name="level" id="level" class="form-control" value="{{ $group->level }}">
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="description">Description</label>
		                    				<textarea id="description" name="description" class="form-control">{{ $group->description }}</textarea>
		                    			</div>
		                    			<button type="submit" class="btn btn-primary">Save Changes</button> <span class="small text-muted">Last updated: {{ $group->updated_at or 'not yet updated' }}</span>
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