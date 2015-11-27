@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Class Sections</div>
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

					<div id="toolbar">
						@can ('create-class-section')
                    		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addClassSectionModal"><i class="fa fa-plus"></i> Create</button>
                    	@endcan
					</div>

					@can ('create-class-section')
						<div class="modal fade" id="addClassSectionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
						 		<div class="modal-content">
							      	<form action="{{ action('ClassSectionController@postAdd') }}" method="post">
							    		<div class="modal-header">
							        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							        		<h4 class="modal-title" id="myModalLabel">Creating a Class Section</h4>
							      		</div>
								      	<div class="modal-body">
								      		{!! csrf_field() !!}
							      			<div class="form-group">
							      				<label for="name">Name</label>
							      				<input type="text" name="name" id="name" class="form-control">
							      			</div>
							      			<div class="form-group">
							      				<label for="adviser">Adviser</label>
							      				<select id="adviser" name="adviser" class="form-control">
							      					@foreach ($teachers as $row)
							      						<option value="{{ $row->id }}">{{ $row->username }}</option>
							      					@endforeach
							      				</select>
							      			</div>
							      			<div class="form-group">
							      				<label for="level">Level</label>
							      				<select id="level" name="level" class="form-control">
							      					@foreach (config('grade_level') as $row => $col)
							      						<option value="{{ $row }}">{{ $col }}</option>
							      					@endforeach
							      				</select>
							      			</div>
							      			<div class="form-group">
							      				<label for="year">Year</label>
							      				<select id="year" name="year" class="form-control">
							      					@for ($y = date('Y'); $y >= 1990; $y--)
							      						<option value="{{ $y }}">{{ $y }}</option>
							      					@endfor
							      				</select>
							      			</div>
							      			<div class="form-group">
							      				<label for="status">Status</label>
							      				<div class="radio">
							      					<label>
							      						<input type="radio" name="status" value="1" checked>
							      						Enable
							      					</label>
							      					<label>
							      						<input type="radio" name="status" value="0">
							      						Disable
							      					</label>
							      				</div>
							      			</div>
								      	</div>
								      	<div class="modal-footer">
								        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								        	<button type="submit" class="btn btn-primary">Add</button>
								      	</div>
							      	</form>
						    	</div>
						  	</div>
						</div>
					@endcan

            		<table data-toggle="table" data-url="{{ action('ClassSectionController@getAPI', $school_id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
						<thead>
							<tr>
								<th data-field="name">Name</th>
								<th data-formatter="fullNameFormatter">Adviser</th>
								<th data-formatter="gradeLevelFormatter">Level</th>
								<th data-field="year">Year</th>
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

@endsection