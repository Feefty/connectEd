@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Subject</h1>
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
                    	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#addSubjectModal"><i class="fa fa-plus"></i> Add Subject</button>
					</div>

					<div class="modal fade" id="addSubjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
					 		<div class="modal-content">
						      	<form action="{{ action('Admin\SubjectController@postAdd') }}" method="post">
						    		<div class="modal-header">
						        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        		<h4 class="modal-title" id="myModalLabel">Add Subject</h4>
						      		</div>
							      	<div class="modal-body">
							      		{!! csrf_field() !!}
						      			<div class="form-group">
						      				<label for="name">Name</label>
						      				<input type="text" name="name" id="name" class="form-control">
						      			</div>
						      			<div class="form-group">
						      				<label for="code">Code</label>
						      				<input type="text" name="code" id="code" class="form-control">
						      			</div>
						      			<div class="form-group">
						      				<label for="description">Description</label>
						      				<textarea id="description" name="description" class="form-control"></textarea>
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
                    		<table data-toggle="table" data-url="{{ action('Admin\SubjectController@getAPI') }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
                    			<thead>
                    				<tr>
                    					<th data-field="name" data-sortable="true">Name</th>
                    					<th data-field="code" data-sortable="true">Code</th>
                    					<th data-field="description">Description</th>
                    					<th data-field="updated_at" data-sortable="true">Last Updated</th>
                    					<th data-field="created_at" data-sortable="true">Date Added</th>
                    					<th data-formatter="actionSubjectFormatter" data-align="center"></th>
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
