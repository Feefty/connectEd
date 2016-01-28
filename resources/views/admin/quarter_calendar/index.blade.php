@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Quarter Calendar</h1>
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
                    	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#addQuarterCalendar"><i class="fa fa-plus"></i> Add Quarter Calendar</button>
					</div>

					<div class="modal fade" id="addQuarterCalendar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
					 		<div class="modal-content">
						      	<form action="{{ action('Admin\QuarterCalendarController@postAdd') }}" method="post">
						    		<div class="modal-header">
						        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        		<h4 class="modal-title" id="myModalLabel">Add Quarter Calendar</h4>
						      		</div>
							      	<div class="modal-body">
							      		{!! csrf_field() !!}
						      			<div class="form-group">
                                            <label for="quarter_1_from">1st Quarter</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">From</span>
                                                <input type="date" name="quarter_1_from" id="quarter_1_from" class="form-control">
                                                <span class="input-group-addon">To</span>
                                                <input type="date" name="quarter_1_to" id="quarter_1_to" class="form-control">
                                            </div>
						      			</div>
						      			<div class="form-group">
                                            <label for="quarter_2_from">2nd Quarter</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">From</span>
                                                <input type="date" name="quarter_2_from" id="quarter_2_from" class="form-control">
                                                <span class="input-group-addon">To</span>
                                                <input type="date" name="quarter_2_to" id="quarter_2_to" class="form-control">
                                            </div>
						      			</div>
						      			<div class="form-group">
                                            <label for="quarter_3_from">3rd Quarter</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">From</span>
                                                <input type="date" name="quarter_3_from" id="quarter_3_from" class="form-control">
                                                <span class="input-group-addon">To</span>
                                                <input type="date" name="quarter_3_to" id="quarter_3_to" class="form-control">
                                            </div>
						      			</div>
						      			<div class="form-group">
                                            <label for="quarter_4_from">4th Quarter</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">From</span>
                                                <input type="date" name="quarter_4_from" id="quarter_4_from" class="form-control">
                                                <span class="input-group-addon">To</span>
                                                <input type="date" name="quarter_4_to" id="quarter_4_to" class="form-control">
                                            </div>
						      			</div>
						      			<div class="form-group">
						      				<label for="school_year">School Year</label>
                                            <select class="form-control" name="school_year" id="school_yead">
                                                @for ($year = date('Y'); $year >= 1950; $year--)
                                                    <option value="{{ $year }}">{{ $year }} - {{ $year+1 }}</option>
                                                @endfor
                                            </select>
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

                    <div class="panel panel-default">
                    	<div class="panel-body">
                    		<table data-toggle="table" data-url="{{ action('Admin\QuarterCalendarController@getApi') }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
                    			<thead>
                    				<tr>
                                        <th data-field="school_year" data-formatter="schoolYearFormatter" data-sortable="true">School Year</th>
                                        <th data-formatter="quarterCalendarActionFormatter" data-align="center"></th>
                    				</tr>
                    			</thead>
                    		</table>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
