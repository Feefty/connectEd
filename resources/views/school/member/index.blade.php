@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						<a href="javascript:window.history.back()"><i class="fa fa-arrow-left"></i></a> Members
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
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
								</ul>
							</div>
						</div>

						<div id="toolbar2">
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
									<li><a href="#viewAddCodeModal" data-toggle="modal"><i class="fa fa-plus"></i> Generate Codes</a></li>
								</ul>
							</div>
						</div>

						<div class="modal fade" id="viewAddCodeModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
							    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							    		<h4 class="modal-title" id="modalLabel">Code Generation</h4>
							   		</div>
							   		<div class="modal-body">
							   			<form method="POST" action="{{ action('SchoolMemberController@postGenerate') }}">
							   				{!! csrf_field() !!}
							   				<input type="hidden" name="school_id" value="{{ $school->id }}">

							   				<div class="form-group">
							   					<label for="amount">Amount</label>
							   					<input type="number" id="amount" name="amount" class="form-control" value="1" min="1">
							   				</div>

											<div class="form-group">
												<label for="group">Membership</label>
												<select id="group" name="group" class="form-control">
													<option value="4">Student</option>
													<option value="3">Teacher</option>
													<option value="2">School</option>
												</select>
											</div>

						   					<div class="margin-lg-top">
						   						<button type="submit" class="btn btn-primary">Generate</button>
						   					</div>
							   			</form>
							   		</div>
							   	</div>
							</div>
						</div><!-- end of #viewAddMemberModal -->

						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#lists-tab">List</a></li>
							<li><a data-toggle="tab" href="#codes-tab">Codes</a></li>
						</ul>

						<div class="tab-content">
							
							<div id="lists-tab" class="tab-pane fade in active">
								<table data-toggle="table" data-url="{{ action('SchoolMemberController@getAPI', $school->id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
									<thead>
										<tr>
			                    			<th data-formatter="userProfileNameFormatter" data-sortable="true">Name</th>
			                    			<th data-sortable="true" data-formatter="userGroupNameFormatter">Group</th>
			                    			<th data-formatter="statusFormatter">Status</th>
			                    			<th data-field="created_at" data-sortable="true">Date Added</th>
			                    			@can ('delete-school-member')
												<th data-formatter="actionSchoolMemberFormatter" data-align="center">Actions</th>
											@endcan
										</tr>
									</thead>
								</table>
							</div><!-- end of lists tab -->
							
							<div id="codes-tab" class="tab-pane fade">
								<table data-toggle="table" data-url="{{ action('SchoolCodeController@getApi') }}?school_id={{ $school->id }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar2">
									<thead>
										<tr>
			                    			<th data-field="code" data-sortable="true">Code</th>
			                    			<th data-formatter="groupNameFormatter" data-sortable="true">Membership</th>
			                    			<th data-formatter="statusFormatter" data-sortable="true">Status</th>
			                    			<th data-field="created_at" data-sortable="true">Date Added</th>
			                    			@can ('delete-school-code')
												<th data-formatter="actionSchoolCodeFormatter" data-align="center">Actions</th>
											@endcan
										</tr>
									</thead>
								</table>
							</div><!-- end of codes tab -->

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection