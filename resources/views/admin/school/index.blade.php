@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">School</h1>
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
                    	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#addSchoolModal"><i class="fa fa-plus"></i> Add School</button>
					</div>

					<div class="modal fade" id="addSchoolModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
					 		<div class="modal-content">
						      	<form action="{{ action('Admin\SchoolController@postAdd') }}" method="post">
						    		<div class="modal-header">
						        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        		<h4 class="modal-title" id="myModalLabel">Add School</h4>
						      		</div>
							      	<div class="modal-body">
							      		{!! csrf_field() !!}

                						<div class="form-group">
                							<label for="name">Name</label>
                							<input type="text" name="name" id="name" class="form-control">
                						</div>

                						<div class="form-group">
                							<label for="description">Description</label>
                							<textarea name="description" id="description" class="form-control"></textarea>
                						</div>

                						<div class="form-group">
                							<label for="address">Address</label>
                							<textarea name="address" id="address" class="form-control"></textarea>
                						</div>

                						<div class="form-group">
                							<label for="contact_no">Contact No.</label>
                							<input type="text" name="contact_no" id="contact_no" class="form-control">
                						</div>

                						<div class="form-group">
                							<label for="website">Website</label>
                							<input type="text" name="website" id="website" class="form-control">
                						</div>

                						<div class="form-group">
                							<label for="motto">Motto</label>
                							<textarea name="motto" id="motto" class="form-control"></textarea>
                						</div>

                						<div class="form-group">
                							<label for="mission">Mission</label>
                							<textarea name="mission" id="mission" class="form-control"></textarea>
                						</div>

                						<div class="form-group">
                							<label for="vision">Vision</label>
                							<textarea name="vision" id="vision" class="form-control"></textarea>
                						</div>

                						<div class="form-group">
                							<label for="goal">Goal</label>
                							<textarea name="goal" id="goal" class="form-control"></textarea>
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
                    		<table data-toggle="table" data-show-columns="true" data-show-export="true" data-url="{{ action('Admin\SchoolController@getAPI') }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
                    			<thead>
                    				<tr>
                    					<th data-field="name" data-sortable="true">Name</th>
                    					<th data-field="description" data-sortable="true">Description</th>
                                        <th data-field="members" data-sortable="true">Members</th>
                    					<th data-field="updated_at" data-sortable="true">Last Updated</th>
                    					<th data-field="created_at" data-sortable="true">Date Added</th>
                    					<th data-formatter="actionSchoolFormatter" data-align="center"></th>
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
