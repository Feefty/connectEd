@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User</h1>
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

					<div class="toolbar1">
						@can('create-user')
                    	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#addUserModal"><i class="fa fa-plus"></i> Add User</button>
                    	@endcan
					</div>

					<div class="toolbar2">
						@can('create-user')
                    	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#addUserModal"><i class="fa fa-plus"></i> Add User</button>
                    	@endcan
					</div>

					<div class="toolbar3">
						@can('create-user')
                    	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#addUserModal"><i class="fa fa-plus"></i> Add User</button>
                    	@endcan
					</div>

					<div class="toolbar4">
						@can('create-user')
                    	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#addUserModal"><i class="fa fa-plus"></i> Add User</button>
                    	@endcan
					</div>

					<div class="toolbar5">
						@can('create-user')
                    	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#addUserModal"><i class="fa fa-plus"></i> Add User</button>
                    	@endcan
					</div>

					@can('create-user')
					<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
					 		<div class="modal-content">
						      	<form action="{{ action('Admin\UserController@postAdd') }}" method="post">
						    		<div class="modal-header">
						        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        		<h4 class="modal-title" id="myModalLabel">Add User</h4>
						      		</div>
							      	<div class="modal-body">
							      		{!! csrf_field() !!}
						      			<div class="form-group">
						      				<label for="username">Username</label>
						      				<input type="text" name="username" id="username" class="form-control">
						      			</div>
						      			<div class="form-group">
						      				<label for="password">Password</label>
						      				<input type="password" name="password" id="password" class="form-control">
						      			</div>
						      			<div class="form-group">
						      				<label for="password_confirmation">Confirm Password</label>
						      				<input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
						      			</div>
						      			<div class="form-group">
						      				<label for="email">E-mail</label>
						      				<input type="email" name="email" id="email" class="form-control">
						      			</div>
						      			<div class="form-group">
						      				<label for="group">Group</label>
						      				<select id="group" name="group" class="form-control">
						      					@foreach ($groups as $row)
						      					<option value="{{ $row->id }}">{{ $row->name .' ('. $row->level }})</option>
						      					@endforeach
						      				</select>
						      			</div>
						      			<hr>
						      			<div class="form-group">
						      				<label for="first_name">First Name</label>
						      				<input type="text" name="first_name" id="first_name" class="form-control">
						      			</div>
						      			<div class="form-group">
						      				<label for="middle_name">Middle Name</label>
						      				<input type="text" name="middle_name" id="middle_name" class="form-control">
						      			</div>
						      			<div class="form-group">
						      				<label for="last_name">Last Name</label>
						      				<input type="text" name="last_name" id="last_name" class="form-control">
						      			</div>
						      			<div class="form-group">
						      				<label for="gender">Gender</label>
						      				<select id="gender" name="gender" class="form-control">
						      					@foreach (config('gender') as $row => $col)
						      					<option value="{{ $row }}">{{ $col }}</option>
						      					@endforeach
						      				</select>
						      			</div>
						      			<div class="form-group">
						      				<label for="birthday">Birthday</label>
						      				<input type="date" name="birthday" id="birthday" class="form-control">
						      			</div>
						      			<div class="form-group">
						      				<label for="address">Address</label>
						      				<textarea id="address" name="address" class="form-control"></textarea>
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

                    <div class="panel panel-default">
                    	<div class="panel-body">

                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#system-admins-tab"><img src="{{ asset('/img/user/system_admin.png') }}" class="user-icon-16" alt="" /> System Admins</a></li>
                                <li><a data-toggle="tab" href="#school-admins-tab"><img src="{{ asset('/img/user/system_admin.png') }}" class="user-icon-16" alt="" /> School Admins</a></li>
                                <li><a data-toggle="tab" href="#teachers-tab"><img src="{{ asset('/img/user/teacher.png') }}" class="user-icon-16" alt="" /> Teachers</a></li>
                                <li><a data-toggle="tab" href="#students-tab"><img src="{{ asset('/img/user/student.png') }}" class="user-icon-16" alt="" /> Students</a></li>
                                <li><a data-toggle="tab" href="#parents-tab"><img src="{{ asset('/img/user/parent.png') }}" class="user-icon-16" alt="" /> Parents</a></li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane active" id="system-admins-tab">
                            		<table data-toggle="table" data-show-columns="true" data-show-export="true" data-url="{{ action('Admin\UserController@getAPI') }}?show=system%20admin" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar=".toolbar4">
                            			<thead>
                            				<tr>
                            					<th data-field="username" data-sortable="true">Username</th>
                            					<th data-field="email" data-sortable="true">E-mail</th>
                            					<th data-field="group" data-sortable="true">Group</th>
                            					<th data-formatter="schoolMemberSchoolNameFormatter" data-sortable="true">School</th>
                            					<th data-field="status" data-sortable="true">Status</th>
                            					<th data-field="created_at" data-sortable="true">Date Joined</th>
                            					<th data-formatter="actionUserFormatter" data-align="center"></th>
                            				</tr>
                            			</thead>
                            		</table>
                                </div>
                                <div class="tab-pane" id="school-admins-tab">
                            		<table data-toggle="table" data-show-columns="true" data-show-export="true" data-url="{{ action('Admin\UserController@getAPI') }}?show=school%20admin" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar=".toolbar3">
                            			<thead>
                            				<tr>
                            					<th data-field="username" data-sortable="true">Username</th>
                            					<th data-field="email" data-sortable="true">E-mail</th>
                            					<th data-field="group" data-sortable="true">Group</th>
                            					<th data-formatter="schoolMemberSchoolNameFormatter" data-sortable="true">School</th>
                            					<th data-field="status" data-sortable="true">Status</th>
                            					<th data-field="created_at" data-sortable="true">Date Joined</th>
                            					<th data-formatter="actionUserFormatter" data-align="center"></th>
                            				</tr>
                            			</thead>
                            		</table>
                                </div>
                                <div class="tab-pane" id="teachers-tab">
                                    <table data-toggle="table" data-show-columns="true" data-show-export="true" data-url="{{ action('Admin\UserController@getAPI') }}?show=teacher" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar=".toolbar2">
                            			<thead>
                            				<tr>
                            					<th data-field="username" data-sortable="true">Username</th>
                            					<th data-field="email" data-sortable="true">E-mail</th>
                            					<th data-field="group" data-sortable="true">Group</th>
                            					<th data-formatter="schoolMemberSchoolNameFormatter" data-sortable="true">School</th>
                            					<th data-field="status" data-sortable="true">Status</th>
                            					<th data-field="created_at" data-sortable="true">Date Joined</th>
                            					<th data-formatter="actionUserFormatter" data-align="center"></th>
                            				</tr>
                            			</thead>
                            		</table>
                                </div>
                                <div class="tab-pane" id="students-tab">
                                    <table data-toggle="table" data-show-columns="true" data-show-export="true" data-url="{{ action('Admin\UserController@getAPI') }}?show=student" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar=".toolbar1">
                            			<thead>
                            				<tr>
                            					<th data-field="username" data-sortable="true">Username</th>
                            					<th data-field="email" data-sortable="true">E-mail</th>
                            					<th data-field="group" data-sortable="true">Group</th>
                            					<th data-formatter="schoolMemberSchoolNameFormatter" data-sortable="true">School</th>
                            					<th data-field="status" data-sortable="true">Status</th>
                            					<th data-field="created_at" data-sortable="true">Date Joined</th>
                            					<th data-formatter="actionUserFormatter" data-align="center"></th>
                            				</tr>
                            			</thead>
                            		</table>
                                </div>
                                <div class="tab-pane" id="parents-tab">
                                    <table data-toggle="table" data-show-columns="true" data-show-export="true" data-url="{{ action('Admin\UserController@getAPI') }}?show=parent" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar=".toolbar5">
                            			<thead>
                            				<tr>
                            					<th data-field="username" data-sortable="true">Username</th>
                            					<th data-field="email" data-sortable="true">E-mail</th>
                            					<th data-field="group" data-sortable="true">Group</th>
                            					<th data-formatter="schoolMemberSchoolNameFormatter" data-sortable="true">School</th>
                            					<th data-field="status" data-sortable="true">Status</th>
                            					<th data-field="created_at" data-sortable="true">Date Joined</th>
                            					<th data-formatter="actionUserFormatter" data-align="center"></th>
                            				</tr>
                            			</thead>
                            		</table>
                                </div>
                            </div>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
