@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><a href="{{ action('Admin\SubjectController@getIndex') }}" class="small"><i class="fa fa-angle-double-left" title="Go back!"></i></a> Subject Edit</h1>
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
                    				Subject
                    			</div>
		                    	<div class="panel-body">
		                    		<form action="{{ action('Admin\SubjectController@postEdit') }}" method="POST">
		                    			{!! csrf_field() !!}
		                    			<input type="hidden" name="subject_id" value="{{ $subject->id }}">

		                    			<div class="form-group">
		                    				<label for="subject_id">ID</label>
		                    				<input type="text" id="subject_id" class="form-control" value="{{ $subject->id }}" readonly>
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="name">Name</label>
		                    				<input type="text" name="name" id="name" class="form-control" value="{{ $subject->name }}">
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="code">Code</label>
		                    				<input type="text" name="code" id="code" class="form-control" value="{{ $subject->code }}">
		                    			</div>
						      			<div class="form-group">
						      				<label for="level">Level</label>
						      				<select name="level" id="level" class="form-control">
						      					@for ($i = 1; $i <= 12; $i++)
						      						@if ($subject->level == $i)
						      							<option value="{{ $i }}" selected>{{ $i }}</option>
						      						@else
						      							<option value="{{ $i }}">{{ $i }}</option>
						      						@endif
						      					@endfor
						      				</select>
						      			</div>
		                    			<div class="form-group">
		                    				<label for="description">Description</label>
		                    				<textarea id="description" name="description" class="form-control">{{ $subject->description }}</textarea>
		                    			</div>
		                    			<button type="submit" class="btn btn-primary">Save Changes</button> <span class="small text-muted">Last updated: {{ $subject->updated_at or 'not yet updated' }}</span>
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