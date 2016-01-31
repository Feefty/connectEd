@extends('main')

@section('content')
	<div class="row">
		<div class="col-md-2 profile-sidebar" id="profile-spy">
			<ul class="nav nav-pills nav-stacked col-md-2" data-spy="affix">
				<li><a href="#basic-info"><i class="fa fa-info fa-fw"></i> Basic Information</a></li>
				@if (strtolower($user->group->name) == 'student')
					<li><a href="#performance"><i class="fa fa-line-chart fa-fw"></i> Performances</a></li>
					<li><a href="#grades"><i class="fa fa-file-text-o fa-fw"></i> Grades</a></li>
				@endif
			</ul>
		</div>
		<div class="col-md-8">
			<div class="panel panel-default" id="basic-info">
				<div class="panel-heading">Profile</div>
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

					<h3>{{ ucwords($user->profile->first_name .' '. $user->profile->last_name) }}</h3>
					@if (auth()->user()->id != $user->id)
						<ul class="list-inline">
							<li><a href="#composeMessageModal" data-toggle="modal"><i class="fa fa-envelope"></i> Send Message</a></li>
							<li><a href="#"><i class="fa fa-heart"></i> Follow</a></li>
							<li><a href="#"><i class="fa fa-ban"></i> Block</a></li>
						</ul>

						<div class="modal fade" id="composeMessageModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
							    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							    		<h4 class="modal-title" id="modalLabel">Message</h4>
							   		</div>
							   		<div class="modal-body">
							   			<form method="POST" action="{{ action('MessageController@postAdd') }}">
							   				{!! csrf_field() !!}
							   				<input type="hidden" name="to_id" value="{{ $user->id }}">

							   				<div class="form-group">
							   					<label for="content">Content</label>
							   					<textarea id="content" name="content" class="form-control"></textarea>
							   				</div>

						   					<div class="margin-lg-top">
						   						<button type="submit" class="btn btn-primary">Send</button>
												<a href="{{ action('MessageController@getIndex') }}" class="btn btn-link">View all messages</a>
						   					</div>
							   			</form>
							   		</div>
							   	</div>
							</div>
						</div><!-- end of #viewCreateLessonModal -->
					@endif
					<table>
						<tr>
							<td rowspan="5">
								@if ( ! empty($user->profile->photo) && ! is_null($user->profile->photo))
									<img src="{{ config('profile.photo.path') . $user->profile->photo }}" class="img-thumbnail">
								@endif
							</td>
						</tr>
						<tr>
							<td style="vertical-align: top">
								<table class="table">
									<tr>
										<td><h4>INFORMATION</h4></td>
									</tr>
									<tr>
										<td><strong>Gender</strong></td>
										<td>:
											@if ($user->profile->gender == 1)
												<i class="fa fa-mars"></i> Male
											@else
												<i class="fa fa-venus"></i> Female
											@endif
										</td>
									</tr>
									<tr>
										<td><strong>Birthday</strong></td>
										<td>: {{ $user->profile->birthday }}</td>
									</tr>
									<tr>
										<td><strong>Address</strong></td>
										<td>: {{ $user->profile->address }}</td>
									</tr>
									<tr>
										<td><strong>Role</strong></td>
										<td>: {{ @$user->group->name }}</td>
									</tr>
									@if ( ! is_null($user->school_member))
									<tr>
										<td><strong>School</strong></td>
										<td>: <a href="{{ action('SchoolController@getIndex') }}/{{ $user->school_member->school->id }}">{{ $user->school_member->school->name }}</a></td>
									</tr>
									@endif
									@if (strtolower($user->group->name) == 'student')
										<tr>
											<td><strong>Section</strong></td>
											<td>: [{{ config('grade_level')[$user->class_student->class_section->level] }}] {{ $user->class_student->class_section->name }}</td>
										</tr>
										<tr>
											<td><strong>Adviser</strong></td>
											<td>: <a href="{{ action('ProfileController@getUser', $user->class_student->class_section->teacher->username) }}">{{ ucwords(strtolower($user->class_student->class_section->teacher->profile->last_name .', '. $user->class_student->class_section->teacher->profile->first_name)) }}</a></td>
										</tr>
									@endif
								</table>
							</td>
						</tr>
					</table>
				</div>
			</div>

			@if (strtolower($user->group->name) == 'student')
				<div class="panel panel-default" id="performance">
					<div class="panel-heading">Performances</div>
					<div class="panel-body">
						<canvas id="assessment-radar" data-student-id="{{ $user->id }}" class="center-block" width="500" height="500"></canvas>
					</div>
				</div>
					<div class="panel panel-default" id="grades">
						<div class="panel-heading">Grades</div>
						<div class="panel-body">
							<ul class="nav nav-tabs">
								@foreach ($school_years as $row)
									@if ($school_years[0]->school_year == $row->school_year)
										<li class="active"><a href="#grade{{ $row->school_year }}" data-toggle="tab">{{ $row->school_year }} - {{ $row->school_year+1 }}</a></li>
									@else
										<li><a href="#grade{{ $row->school_year }}" data-toggle="tab">{{ $row->school_year }} - {{ $row->school_year+1 }}</a></li>
									@endif
								@endforeach
							</ul>

							<div class="tab-content">
								@foreach ($school_years as $row)
									@if ($school_years[0]->school_year == $row->school_year)
										<div class="tab-pane active fade in" id="grade{{ $row->school_year }}">
									@else
										<div class="tab-pane fade" id="grade{{ $row->school_year }}">
									@endif

									<table class="table table-bordered">
										<thead>
											<tr>
												<th>
													Subject
												</th>
												<th>
													1st Quarter
												</th>
												<th>
													2nd Quarter
												</th>
												<th>
													3rd Quarter
												</th>
												<th>
													4th Quarter
												</th>
												<th>
													Final
												</th>
												<th>
													Remarks
												</th>
											</tr>
										</thead>
										@foreach ($subjects as $subject)
											<tr>
												<td>
													{{ $subject->name }}
												</td>
												@for ($quarter = 1; $quarter <= 4; $quarter++)
													<td>
														{{ round(\App\GradeSummary::whereHas('class_subject', function($query) use($subject) {
															$query->where('subject_id', $subject->id);
														})->where('quarter', $quarter)->pluck('grade')) }}
													</td>
												@endfor
												<td>
													<?php $average = round(\App\GradeSummary::whereHas('class_subject', function($query) use($subject) {
														$query->where('subject_id', $subject->id);
													})->avg('grade')) ?>
													{{ $average }}
												</td>
												<td>
													{!! $average < 75 ? '<strong class="text-danger">Failed</strong>' : '<strong class="text-success">Passed</strong>' !!}
												</td>
											</tr>
										@endforeach
									</table>
								</div>
								@endforeach
							</div>
						</div>
					</div>
			@endif
		</div>
	</div>

@endsection
