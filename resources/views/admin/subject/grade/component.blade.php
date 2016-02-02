@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Grade Components <small>[{{ $subject->code }}] {{ $subject->name }}</small></h1>
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
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#addComponentModal"><i class="fa fa-plus"></i> Add Grade Component</button>
                    </div>

                    <div class="modal fade" id="addComponentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
					 		<div class="modal-content">
						      	<form action="{{ action('Admin\GradeComponentController@postAdd') }}" method="post">
						    		<div class="modal-header">
						        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        		<h4 class="modal-title" id="myModalLabel">Add Grade Component</h4>
						      		</div>
							      	<div class="modal-body">
							      		{!! csrf_field() !!}

                                        <input type="hidden" name="subject_id" value="{{ $subject->id }}">

						      			<div class="form-group">
						      				<label for="assessment_category_id">Category</label>
                                            <select class="form-control" id="assessment_category_id" name="assessment_category_id">
                                                @foreach ($assessment_categories as $row)
                                                    <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                @endforeach
                                            </select>
						      			</div>
                                        <div class="form-group">
                                            <label for="percentage">Percentage</label>
                                            <input type="number" name="percentage" id="percentage" class="form-control" min="0" max="100">
                                        </div>
                                        <div class="form-group">
                                            <label for="color">Color</label>
                                            <input type="text" name="color" data-toggle="color-picker" data-control="hue" class="form-control">
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

                    <div class="row">
                        <div class="col-xs-12">
                            <table data-toggle="table" data-show-columns="true" data-show-export="true" data-url="{{ action('Admin\GradeComponentController@getApi', $subject->id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
                    			<thead>
                    				<tr>
                                        <th data-field="color" data-formatter="colorFormatter">Color</th>
                    					<th data-field="percentage" data-sortable="true">Percentage</th>
                    					<th data-field="assessment_category.name" data-sortable="true">Category</th>
                    					<th data-field="description" data-sortable="true">Description</th>
                    					<th data-field="updated_at" data-sortable="true">Last Updated</th>
                    					<th data-field="created_at" data-sortable="true">Date Added</th>
                                        <th data-align="true" data-formatter="actionGradeComponentFormatter"></th>
                    				</tr>
                    			</thead>
                    		</table>
                        </div>
                        <div class="col-xs-12">
                            <div class="text-center">
                                <h3>{{ $grade_components_percent }}%</h3>
                            </div>
                            <canvas id="gradeComponentChart" class="center-block" data-subject-id="{{ $subject->id }}"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
