@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><a href="{{ action('Admin\SchoolController@getIndex') }}" class="small"><i class="fa fa-angle-double-left" title="Go back!"></i></a> School View</h1>

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

                    <div class="row">
	                    <div class="col-xs-12">
	                    	<div class="panel panel-default">
	                    		<div class="panel-heading">
	                    			School
	                    			<a href="{{ action('Admin\SchoolController@getEdit', $school->id) }}" class="pull-right"><i class="fa fa-pencil"></i></a>
	                    		</div>
		                    	<div class="panel-body">
				                    <table class="table">
				                    	<tr>
				                    		<td><label>Name</label></td>
				                    		<td>{{ $school->name }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Address</label></td>
				                    		<td>{{ $school->address }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Description</label></td>
				                    		<td>{{ $school->description }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Vision</label></td>
				                    		<td>{{ $school->vision }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Mission</label></td>
				                    		<td>{{ $school->mission }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Goal</label></td>
				                    		<td>{{ $school->goal }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Motto</label></td>
				                    		<td>{{ $school->motto }}</td>
				                    	</tr>
				                    	<tr>
				                    		<td><label>Date Added</label></td>
				                    		<td>{{ $school->created_at }}</td>
				                    	</tr>
				                    </table>
		                    	</div>
		                    </div>
	                    </div>
                    </div>
                    <div class="small text-muted margin-lg-bottom">Last updated: {{ $school->updated_at or 'not yet updated' }}</div>

                    <div class="row">
	                    <div class="col-xs-12">
	                    	<div class="panel panel-default">
	                    		<div class="panel-heading">
	                    			Members
	                    		</div>
		                    	<div class="panel-body">
		                    		<div id="toolbar">
                                        <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#generateCodeCollapse">Generate Code</button>
		                    		</div>
                                    <div id="generateCodeCollapse" class="collapse">
                                        <form action="{{ action('SchoolMemberController@postGenerate') }}" method="POST">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="group" value="{{ array_keys(config('group'), "School Admin")[0] }}">
                                            <input type="hidden" name="school_id" value="{{ $school->id }}">

                                            <div class="form-group">
                                                <label for="amount">Amount</label>
                                                <input type="number" name="amount" id="amount" min="1" max="99" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Generate</button>
                                        </form>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#members-tab" data-toggle="tab">Members</a></li>
                                        <li><a href="#codes-tab" data-toggle="tab">Codes</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="members-tab" class="tab-pane fade in active">
                                            <table data-toggle="table" data-url="{{ action('Admin\SchoolController@getMemberAPI', $school->id) }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
        				                    	<thead>
        				                    		<tr>
        				                    			<th data-formatter="usernameFormatter" data-sortable="true">Username</th>
        				                    			<th data-field="created_at" data-sortable="true">Date Added</th>
        				                    			<th data-formatter="actionMemberSchoolFormatter" data-align="center"></th>
        				                    		</tr>
        				                    	</thead>
        				                    </table>
                                        </div>
                                        <div id="codes-tab" class="tab-pane fade">
                                            <table data-toggle="table" data-url="{{ action('VerificationCodeController@getApi') }}?school_id={{ $school->id }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
            									<thead>
            										<tr>
            			                    			<th data-field="code" data-sortable="true">Code</th>
            			                    			<th data-field="group.name" data-sortable="true">Membership</th>
            			                    			<th data-formatter="verificationStatusFormatter" data-sortable="true">Status</th>
            			                    			<th data-field="created_at" data-sortable="true">Date Added</th>
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
        </div>
    </div>
@endsection
