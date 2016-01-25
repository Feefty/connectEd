@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><a href="{{ action('Admin\SchoolController@getIndex') }}" class="small"><i class="fa fa-angle-double-left" title="Go back!"></i></a> School Edit</h1>
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
                    			</div>
		                    	<div class="panel-body">
		                    		<form action="{{ action('Admin\SchoolController@postEdit') }}" method="POST">
		                    			{!! csrf_field() !!}
		                    			<input type="hidden" name="school_id" value="{{ $school->id }}">

		                    			<div class="form-group">
		                    				<label for="school_id">ID</label>
		                    				<input type="text" id="school_id" class="form-control" value="{{ $school->id }}" readonly>
		                    			</div>

                						<div class="form-group">
                							<label for="name">Name</label>
                							<input type="text" name="name" id="name" class="form-control" value="{{ $school->name }}">
                						</div>

                						<div class="form-group">
                							<label for="description">Description</label>
                							<textarea name="description" id="description" class="form-control">{{ $school->description }}</textarea>
                						</div>

                						<div class="form-group">
                							<label for="address">Address</label>
                							<textarea name="address" id="address" class="form-control">{{ $school->address }}</textarea>
                						</div>

                						<div class="form-group">
                							<label for="contact_no">Contact No.</label>
                							<input type="text" name="contact_no" id="contact_no" class="form-control" value="{{  $school->contact_no }}">
                						</div>

                						<div class="form-group">
                							<label for="website">Website</label>
                							<input type="text" name="website" id="website" class="form-control" value="{{ $school->website }}">
                						</div>

                						<div class="form-group">
                							<label for="motto">Motto</label>
                							<textarea name="motto" id="motto" class="form-control">{{ $school->motto }}</textarea>
                						</div>

                						<div class="form-group">
                							<label for="mission">Mission</label>
                							<textarea name="mission" id="mission" class="form-control">{{ $school->mission }}</textarea>
                						</div>

                						<div class="form-group">
                							<label for="vision">Vision</label>
                							<textarea name="vision" id="vision" class="form-control">{{ $school->vision }}</textarea>
                						</div>

                						<div class="form-group">
                							<label for="goal">Goal</label>
                							<textarea name="goal" id="goal" class="form-control">{{ $school->goal }}</textarea>
                						</div>
		                    			<button type="submit" class="btn btn-primary">Save Changes</button> <span class="small text-muted">Last updated: {{ $school->updated_at or 'not yet updated' }}</span>
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
