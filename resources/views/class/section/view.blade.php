@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						<strong>Section {{ $section->name }}</strong> <span class="text-warning small">{{ config('grade_level')[$section->level] }}</span>
					</div>
					<div class="panel-body">
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

						<button type="button" class="btn btn-default btn-xs margin-lg-bottom" data-toggle="modal" data-target="#viewClassSchedulesModal">View Class Schedules</button>

						<div class="modal fade" id="viewClassSchedulesModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
							    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							    		<h4 class="modal-title" id="modalLabel">Create a New Class</h4>
							   		</div>
							   		<div class="modal-body">
							   			<button type="button" class="btn btn-primary">Add Schedule</button>
							   		</div>
							   	</div>
							</div>
						</div>

						<table class="table">
							<tr>
								<td><strong>Adviser:</strong> {{ ucfirst(strtolower($section->first_name)) }} {{ ucfirst(strtolower($section->last_name)) }}</td>
							</tr>
							<tr>
								<td><strong>Year:</strong> {{ $section->year }} - {{ $section->year+1 }}</td>
							</tr>
							<tr>
								<td><strong>School:</strong> {{ $section->school }}</td>
							</tr>
						</table>

						<div id="toolbar">
		                    <form action="{{ action('ClassStudentController@postAdd') }}" method="POST" class="form-inline">
		                    	{!! csrf_field() !!}
		                    	<input type="hidden" name="class_section_id" value="{{ $section->id }}">
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

						<table data-toggle="table" data-url="{{ action('ClassStudentController@getAPIBySection', $section->id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
						<thead>
							<tr>
								<th data-formatter="userProfile">Name</th>
								<th data-field="gender">Gender</th>
								@can ('update-class-section')
								<th data-formatter="actionUpdateClassSectionFormatter">Actions</th>
								@else
								<th data-formatter="actionClassSectionFormatter">Actions</th>
								@endcan
							</tr>
						</thead>
					</table>
					</div>	
				</div>
			</div>
		</div>
	</div>

@endsection