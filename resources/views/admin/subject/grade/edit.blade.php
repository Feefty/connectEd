@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><a href="{{ action('Admin\SubjectController@getGradeComponents', $grade_component->subject_id) }}" class="small"><i class="fa fa-angle-double-left" title="Go back!"></i></a> Grade Component Edit - {{ $grade_component->assessment_category->name }}</h1>
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
		                    		<form action="{{ action('Admin\GradeComponentController@postEdit') }}" method="POST">
		                    			{!! csrf_field() !!}
		                    			<input type="hidden" name="grade_component_id" value="{{ $grade_component->id }}">
		                    			<input type="hidden" name="subject_id" value="{{ $grade_component->subject_id }}">

		                    			<div class="form-group">
		                    				<label for="percentage">Percentage</label>
		                    				<input type="text" name="percentage" id="percentage" class="form-control" value="{{ $grade_component->percentage }}">
		                    			</div>
		                    			<div class="form-group">
		                    				<label for="color">Color</label>
		                    				<input type="text" name="color" id="color" data-toggle="color-picker" class="form-control" value="{{ $grade_component->color }}">
		                    			</div>
		                    			<button type="submit" class="btn btn-primary">Save Changes</button> <span class="small text-muted">Last updated: {{ $grade_component->updated_at or 'not yet updated' }}</span>
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
