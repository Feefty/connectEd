@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Exam Question</div>
				<div class="panel-body">
					<h2>{{ $exam_question->exam->title }}</h2>
					<div class="well">
						<p>{{ $exam_question->question }}</p>
					</div>

					<div id="toolbar">
						@can ('manage-exam-question')
							@if (strtolower(auth()->user()->group->name) == 'teacher' && $exam_question->exam->created_by == auth()->user()->id)
								<div class="dropdown">
									<button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
									<ul class="dropdown-menu">
										@can ('create-exam-question-answer')
												@if ($exam_question->category == 'multiplechoice' ||
													 $exam_question->category == 'identification')
												<li><a href="#viewAddAnswerModal" data-toggle="modal"><i class="fa fa-plus"></i> Add Answer</a></li>
												@endif
										@endcan
									</ul>
								</div>
							@endif
						@endcan
					</div>

					@can ('create-exam-question-answer')
					<div class="modal fade" id="viewAddAnswerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
					 		<div class="modal-content">
						      	<form action="{{ action('ExamQuestionAnswerController@postAdd') }}" method="post">
						    		<div class="modal-header">
						        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        		<h4 class="modal-title" id="myModalLabel">Exam Question Answer</h4>
						      		</div>
							      	<div class="modal-body">
							      		{!! csrf_field() !!}

							      		@if ($exam_question->category == 'multiplechoice')
						      				<input type="hidden" name="exam_question_id" value="{{ $exam_question->id }}">

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
							      		@endif

							      		@if ($exam_question->category == 'identification')
						      				<input type="hidden" name="exam_question_id" value="{{ $exam_question->id }}">

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
							      		@endif
							      	</div>
							      	<div class="modal-footer">
							        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							        	<button type="submit" class="btn btn-primary">Add</button>
							      	</div>
						      	</form>
					    	</div>
					  	</div>
					</div><!-- end of modal -->
					@endcan

					<table data-toggle="table" data-url="{{ action('ExamQuestionAnswerController@getApi') }}?exam_question_id={{ $exam_question->id }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
						<thead>
							<tr>
								<th data-field="answer" data-sortable="true">Answer</th>
								<th data-field="points" data-sortable="true">Points</th>
								<th data-field="created_at" data-sortable="true">Date Added</th>
								@can ('manage-exam-question-answer')
									@if (strtolower(auth()->user()->group->name) == 'teacher' && $exam_question->exam->created_by == auth()->user()->id)
									<th data-formatter="actionExamQuestionAnswerFormatter" data-align="center"></th>
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