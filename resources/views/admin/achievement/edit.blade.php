@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><a href="{{ action('Admin\AchievementController@getIndex') }}" class="small"><i class="fa fa-angle-double-left" title="Go back!"></i></a> Achievement Edit</h1>
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
                    				Achievement
                    			</div>
		                    	<div class="panel-body">
		                    		<form action="{{ action('Admin\AchievementController@postEdit') }}" method="POST" enctype="multipart/form-data">
		                    			{!! csrf_field() !!}
		                    			<input type="hidden" name="achievement_id" value="{{ $achievement->id }}">

		                    			<div class="form-group">
		                    				<label for="achievement_id">ID</label>
		                    				<input type="text" id="achievement_id" class="form-control" value="{{ $achievement->id }}" readonly>
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="title">Title</label>
		                    				<input type="text" name="title" id="title" class="form-control" value="{{ $achievement->title }}">
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="description">Description</label>
		                    				<textarea id="description" name="description" class="form-control">{{ $achievement->description }}</textarea>
		                    			</div>
                                        <div class="form-group">
                                            <label for="icon">Icon</label>
                                            <input type="file" name="icon" id="icon">
                                            <img src="{{ config('achievement.icon.path') }}/{{ $achievement->icon }}" alt="" />
                                            <div class="help-block">
                                                200x200 pixels are the recommended size.
                                            </div>
                                        </div>
		                    			<button type="submit" class="btn btn-primary">Save Changes</button> <span class="small text-muted">Last updated: {{ $achievement->updated_at or 'not yet updated' }}</span>
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
