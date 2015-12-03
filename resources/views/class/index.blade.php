@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						Class
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

						<div id="toolbar">
							@can ('create-class')
								<button type="button" class="btn btn-success" data-toggle="modal" data-target="#createClassModal"><i class="fa fa-plus"></i> Create</button>

								<div class="modal fade" id="createClassModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
									    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									    		<h4 class="modal-title" id="modalLabel">Create a New Class</h4>
									   		</div>
								    		<form action="{{ action('ClassSectionController@postAdd') }}" method="POST">
									    		<div class="modal-body">
								    				{!! csrf_field() !!}
								    				<div class="form-group">
								    					<label for="subject">Subject</label>
								    					<select id="subject" name="subject" class="form-control">
								    						@foreach ($subjects as $row)
								    							<option value="{{ $row->id }}">[{{ $row->level .'] ' . $row->name }}</option>
								    						@endforeach
								    					</select>
								    				</div>
									    			<div class="form-group">
									    				<label for="teacher">Teacher</label>
									    				<select id="teaher" name="teacher" class="form-control">
									    					@foreach ($teachers as $row)
									    						<option value="{{ $row->id }}">{{ $row->username }}</option>
									    					@endforeach
									    				</select>
									    			</div>

									    			<div class="form-group">
									    				<label for="level">Level</label>
									    				<select name="level" id="level" class="form-control">
									    					@foreach (config('grade_level') as $row => $col)
									    						<option value="{{ $row }}">{{ $col }}</option>
									    					@endforeach
									    				</select>
									    			</div>

									    			<div class="form-group">
									    				<label for="year">Year</label>
									    				<select id="year" name="year" class="form-control">
										    				@for ($year = date('Y'); $year >= 1900; $year--)
										    					<option value="{{ $year }}">{{ $year }}</option>
										    				@endfor
									    				</select>
									    			</div>

									    			<div class="form-group">
									    				<label for="status">Status</label>
									    				<div class="radio">
									    					<label>
									    						<input type="radio" name="status" checked 	value="1">
									    						Enable
									    					</label>
									    					<label>
									    						<input type="radio" name="status" value="0">
									    						Disable
									    					</label>
									    				</div>
									    			</div>

									    			<hr>

									    			<h4>Schedules</h4>

									    			<div class="form-group">
									    				<div class="schedule-items">
										    				<div class="row">
										    					<div class="col-md-6">
										    						<label for="day">Day</label>
										    						<select id="day" name="day[]" class="form-control">
										    							@foreach (config('days') as $row => $col)
										    								<option value="{{ $row }}">{{ $col }}</option>
										    							@endforeach
										    						</select>
										    					</div>
										    					<div class="col-md-3">
										    						<label for="time_start">Start</label>
										    						<input type="time" id="time_start" name="time_start[]" class="form-control">
										    					</div>
										    					<div class="col-md-3">
										    						<label for="time_end">End</label>
										    						<input type="time" id="time_end" name="time_end[]" class="form-control">
										    					</div>
										    				</div>
									    				</div>
									    				<span id="schedule-holder"></span>
									    				<button type="button" class="btn btn-xs btn-warning margin-lg-top" id="add-more-schedule">Add More Schedule</button>
									    			</div>
										    	</div>
										    	<div class="modal-footer">
										    		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										    		<button type="submit" class="btn btn-primary">Create</button>
										     	</div>
								    		</form>
										</div>
									</div>
								</div><!-- end of creating class -->
							@endcan
						</div>

						@can ('read-class')
							<table data-toggle="table" data-url="{{ action('ClassController@getAPI', $school_id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
								<thead>
									<tr>
										<th data-formatter="subjectFormatter">Subject</th>
										<th data-formatter="subjectClassFormatter" data-align="center">Actions</th>
									</tr>
								</thead>
							</table>
						@endcan
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection