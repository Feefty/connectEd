@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						Members
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
							@can ('add-member-school')
								<form action="{{ action('SchoolMemberController@postAdd') }}" method="POST" class="form-inline">
			                    	{!! csrf_field() !!}
			                    	<input type="hidden" name="school_id" value="{{ $school->school_id }}">
			                    	<div class="form-group">
			             				<div class="input-group">
			                    			<input type="text" class="form-control" name="username" placeholder="Enter Username">
			                    			<span class="input-group-btn">
			             						<button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i></button>
			             					</span>
			             				</div>
			                    	</div>
			                    </form>
		                    @endcan
						</div>
						<table data-toggle="table" data-url="{{ action('SchoolMemberController@getAPI', $school->school_id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
							<thead>
								<tr>
	                    			<th data-formatter="usernameFormatter" data-sortable="true">Username</th>
	                    			<th data-sortable="true" data-field="group">Group</th>
	                    			<th data-field="created_at" data-sortable="true">Date Added</th>
	                    			@can ('delete-member-school')
										<th data-formatter="actionSchoolMemberFormatter">Actions</th>
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