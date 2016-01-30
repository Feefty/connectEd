@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Achievement</h1>
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
                    	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#addAchievementModal"><i class="fa fa-plus"></i> Add Achievement</button>
					</div>

					<div class="modal fade" id="addAchievementModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
					 		<div class="modal-content">
						      	<form action="{{ action('Admin\AchievementController@postAdd') }}" method="post" enctype="multipart/form-data">
						    		<div class="modal-header">
						        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        		<h4 class="modal-title" id="myModalLabel">Add Achievement</h4>
						      		</div>
							      	<div class="modal-body">
							      		{!! csrf_field() !!}
						      			<div class="form-group">
						      				<label for="title">Title</label>
						      				<input type="text" name="title" id="title" class="form-control">
						      			</div>
						      			<div class="form-group">
						      				<label for="description">Description</label>
						      				<textarea id="description" name="description" class="form-control"></textarea>
						      			</div>
                                        <div class="form-group">
                                            <label for="icon">Icon</label>
                                            <input type="file" name="icon" id="icon">
                                            <div class="help-block">
                                                200x200 pixels are the recommended size.
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

                    <div class="panel panel-default">
                    	<div class="panel-body">
                    		<table data-toggle="table" data-show-columns="true" data-show-export="true" data-url="{{ action('Admin\AchievementController@getAPI') }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
                    			<thead>
                    				<tr>
                                        <th data-formatter="achievementIconFormatter">Icon</th>
                    					<th data-field="title" data-sortable="true">Title</th>
                    					<th data-field="description">Description</th>
                    					<th data-field="updated_at" data-sortable="true">Last Updated</th>
                    					<th data-field="created_at" data-sortable="true">Date Added</th>
                    					<th data-formatter="actionAchievementFormatter" data-align="center"></th>
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
