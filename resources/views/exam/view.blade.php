@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Exams
					@can ('update-exam')
						<a href="{{ action('ExamController@getEdit', $exam->id) }}" data-toggle="tooltip" title="Edit" class="pull-right"><i class="fa fa-pencil"></i></a>
					@endcan
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

					<h2>{{ $exam->title }} <small>{{ $exam->exam_type->name }}</small></h2>
					<ul class="list-inline">
						<li><i class="fa fa-book"></i> {{ '['. $exam->subject->code .'] '. $exam->subject->name .' - '. $exam->subject->description }}</li>
						<li><i class="fa fa-flag"></i> {{ $exam->assessment_category->name }}</li>
						<li><i class="fa fa-clock-o"></i> {{ $exam->created_at }}</li>
						<li><i class="fa fa-bolt"></i> {{ config('exam_status')[$exam->status] }}</li>
					</ul>

					<input type="hidden" id="user_id" value="{{ auth()->user()->id }}">
					<input type="hidden" id="group_name" value="{{ auth()->user()->group->name }}">

					<div id="toolbar">
						@can ('manage-exam-question')
							@if (strtolower(auth()->user()->group->name) == 'teacher' && $exam->created_by == auth()->user()->id)
							<div class="dropdown">
								<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
								<ul class="dropdown-menu">
									@can ('create-exam-question')
										<li><a href="#viewAddQuestionItemModal" data-toggle="modal"><i class="fa fa-plus"></i> Add Item</a></li>
									@endcan
								</ul>
							</div>
							@endif
						@endcan
					</div>
					<div class="modal fade" id="viewAddQuestionItemModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
						    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						    		<h4 class="modal-title" id="modalLabel">Exam Questions</h4>
						   		</div>
						   		<div class="modal-body">

									<div class="dropdown margin-lg-bottom">
										<button type="button" data-toggle="dropdown" class="btn btn-default">
											Question Type
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											<li class="active"><a href="#multiplechoice" data-toggle="tab">Multiple Choice</a></li>
											<li><a href="#trueorfalse" data-toggle="tab">True or False</a></li>
											<li><a href="#identification" data-toggle="tab">Identification</a></li>
											<li><a href="#essay" data-toggle="tab">Essay</a></li>
											<li><a href="#fillintheblank" data-toggle="tab">Fill in the blank</a></li>
										</ul>
									</div>

									<div class="tab-content">
										<div class="tab-pane active fade in" id="multiplechoice">
											<form method="POST" action="{{ action('ExamQuestionController@postAdd') }}">
												{!! csrf_field() !!}
												<input type="hidden" name="category" value="multiplechoice">
												<input type="hidden" name="exam_id" value="{{ $exam->id }}">

												<div class="form-group">
													<label>Question</label>
													<textarea name="question" class="form-control"></textarea>
												</div>

												<div class="form-group">
													<label for="time_limit">Time Limit</label>
													<div class="text-helper text-muted">
														Leave 0 for no time limit
													</div>
													<div class="input-group">
														<input type="number" name="time_limit" id="time_limit" class="form-control" value="0" min="0">
														<span class="input-group-addon">
															Seconds
														</span>
													</div>
												</div>

												<div class="add-more-items" data-id="multiplechoice">

													<div class="form-group">
														<div class="row">
															<div class="col-md-6">
																<label>Answer</label>
																<input type="text" name="answer[]" class="form-control">
															</div>
															<div class="col-md-6">
																<label>Points</label>
																<input type="number" name="points[]" class="form-control" min="0" max="100" value="0">
															</div>
														</div>
													</div>

												</div>

												<div id="add-more-holder" data-holder="multiplechoice"></div>

												<button type="button" class="btn btn-info" id="add-more" data-toggle="add-more" data-target="multiplechoice">Add more answer</button>
												<button type="submit" class="btn btn-primary">Add</button>
											</form>
										</div>

										<div class="tab-pane fade" id="trueorfalse">
											<form method="POST" action="{{ action('ExamQuestionController@postAdd') }}">
												{!! csrf_field() !!}
												<input type="hidden" name="category" value="trueorfalse">
												<input type="hidden" name="exam_id" value="{{ $exam->id }}">

												<div class="form-group">
													<label>Question</label>
													<textarea name="question" class="form-control"></textarea>
												</div>

												<div class="form-group">
													<label for="time_limit">Time Limit</label>
													<div class="text-helper text-muted">
														Leave 0 for no time limit
													</div>
													<div class="input-group">
														<input type="number" name="time_limit" id="time_limit" class="form-control" value="0" min="0">
														<span class="input-group-addon">
															Seconds
														</span>
													</div>
												</div>

												<div class="form-group">
													<label for="answer">Answer</label>
													<div class="radio">
														<label>
															<input type="radio" name="answer[]" value="true">
															True
														</label>
													</div>
													<div class="radio">
														<label>
															<input type="radio" name="answer[]" value="false">
															False
														</label>
													</div>
												</div>
												<div class="form-group">
													<label>Points</label>
													<input type="number" name="points[]" value="0" min="0" max="100" class="form-control">
												</div>
												<button type="submit" class="btn btn-primary">Add</button>
											</form>
										</div>

										<div class="tab-pane fade" id="identification">
											<form method="POST" action="{{ action('ExamQuestionController@postAdd') }}">
												{!! csrf_field() !!}
												<input type="hidden" name="category" value="identification">
												<input type="hidden" name="exam_id" value="{{ $exam->id }}">

												<div class="form-group">
													<label>Question</label>
													<textarea name="question" class="form-control"></textarea>
												</div>

												<div class="form-group">
													<label for="time_limit">Time Limit</label>
													<div class="text-helper text-muted">
														Leave 0 for no time limit
													</div>
													<div class="input-group">
														<input type="number" name="time_limit" id="time_limit" class="form-control" value="0" min="0">
														<span class="input-group-addon">
															Seconds
														</span>
													</div>
												</div>

												<div class="add-more-items" data-id="identification">

													<div class="form-group">
														<div class="row">
															<div class="col-md-6">
																<label>Answer</label>
																<input type="text" name="answer[]" class="form-control">
															</div>
															<div class="col-md-6">
																<label>Points</label>
																<input type="number" name="points[]" class="form-control" min="0" max="100" value="0">
															</div>
														</div>
													</div>

												</div>

												<div id="add-more-holder" data-holder="identification"></div>

												<button type="button" class="btn btn-info" id="add-more" data-toggle="add-more" data-target="identification">Add more answer</button>
												<button type="submit" class="btn btn-primary">Add</button>
											</form>
										</div>

										<div class="tab-pane fade" id="essay">
											<form method="POST" action="{{ action('ExamQuestionController@postAdd') }}">
												{!! csrf_field() !!}
												<input type="hidden" name="category" value="essay">
												<input type="hidden" name="exam_id" value="{{ $exam->id }}">

												<div class="form-group">
													<label>Question</label>
													<textarea name="question" class="form-control"></textarea>
												</div>

												<div class="form-group">
													<label for="time_limit">Time Limit</label>
													<div class="text-helper text-muted">
														Leave 0 for no time limit
													</div>
													<div class="input-group">
														<input type="number" name="time_limit" id="time_limit" class="form-control" value="0" min="0">
														<span class="input-group-addon">
															Seconds
														</span>
													</div>
												</div>

												<div class="text-helper text-muted">
													The answers will be use as key answer for every question they got correct.
												</div>

												<div class="add-more-items" data-id="essay">

													<div class="form-group">
														<div class="row">
															<div class="col-md-6">
																<label>Answer</label>
																<input type="text" name="answer[]" class="form-control">
															</div>
															<div class="col-md-6">
																<label>Points</label>
																<input type="number" name="points[]" class="form-control" min="0" max="100" value="0">
															</div>
														</div>
													</div>

												</div>

												<div id="add-more-holder" data-holder="essay"></div>

												<button type="button" class="btn btn-info" id="add-more" data-toggle="add-more" data-target="essay">Add more answer</button>												<button type="submit" class="btn btn-primary">Add</button>
											</form>
										</div>

										<div class="tab-pane fade" id="fillintheblank">
											<form method="POST" action="{{ action('ExamQuestionController@postAdd') }}">
												{!! csrf_field() !!}
												<input type="hidden" name="category" value="fillintheblank">
												<input type="hidden" name="exam_id" value="{{ $exam->id }}">

												<div class="form-group">
													<label>Question</label>
													<div class="text-helper text-muted">
														Use the keyword :answer in the question to replace as answer from below. All must be in order.
													</div>
													<textarea name="question" class="form-control"></textarea>
												</div>

												<div class="form-group">
													<label for="time_limit">Time Limit</label>
													<div class="text-helper text-muted">
														Leave 0 for no time limit
													</div>
													<div class="input-group">
														<input type="number" name="time_limit" id="time_limit" class="form-control" value="0" min="0">
														<span class="input-group-addon">
															Seconds
														</span>
													</div>
												</div>

												<div class="add-more-items" data-id="fillintheblank">

													<div class="form-group">
														<div class="row">
															<div class="col-md-6">
																<label>Answer</label>
																<input type="text" name="answer[]" class="form-control">
															</div>
															<div class="col-md-6">
																<label>Points</label>
																<input type="number" name="points[]" class="form-control" min="0" max="100" value="0">
															</div>
														</div>
													</div>

												</div>

												<div id="add-more-holder" data-holder="fillintheblank"></div>

												<button type="button" class="btn btn-info" id="add-more" data-toggle="add-more" data-target="fillintheblank">Add more answer</button>
												<button type="submit" class="btn btn-primary">Add</button>
											</form>
										</div>
									</div>
						   		</div>
						   	</div>
						</div>
					</div><!-- end of #viewAddQuestionItemModal -->

					<table data-toggle="table" data-url="{{ action('ExamQuestionController@getApi') }}?exam_id={{ $exam->id }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
						<thead>
							<tr>
								<th data-field="question" data-sortable="true">Question</th>
								<th data-field="category" data-sortable="true">Category</th>
								<th data-field="time_limit" data-sortable="true">Time Limit</th>
								@can ('manage-exam')
									@if (strtolower(auth()->user()->group->name) == 'teacher' && $exam->created_by == auth()->user()->id)
									<th data-formatter="actionExamQuestionFormatter" data-align="center"></th>
									@else
									<th data-formatter="actionExamQuestionViewFormatter" data-align="center"></th>
									@endif
								@endcan
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection
