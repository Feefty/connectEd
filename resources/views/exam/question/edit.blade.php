@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Exam Edit</div>
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

					<form method="POST" action="{{ action('ExamQuestionController@postEdit') }}">
						{!! csrf_field() !!}
						<input type="hidden" name="exam_question_id" value="{{ $exam_question->id }}">

						<div class="form-group">
							<label>Question</label>
							<textarea name="question" data-toggle="wysiwyg" class="form-control">{{ $exam_question->question }}</textarea>
						</div>

						<div class="form-group">
							<label for="time_limit">Time Limit</label>
							<div class="text-helper text-muted">
								Leave 0 for no time limit
							</div>
							<div class="input-group">
								<input type="number" name="time_limit" id="time_limit" class="form-control" value="{{ $exam_question->time_limit }}" min="0">
								<span class="input-group-addon">
									Seconds
								</span>
							</div>
						</div>

						<button type="submit" class="btn btn-primary">Save Changes</button>
						<a href="{{ action('ExamQuestionController@getView', $exam_question->id) }}" class="btn btn-link">View Answers</a>
					</form>

				</div>
			</div>
		</div>
	</div>

@endsection
