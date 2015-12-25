@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Exam Question Answer Edit</div>
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

					<form method="POST" action="{{ action('ExamQuestionAnswerController@postEdit') }}">
						{!! csrf_field() !!}
						<input type="hidden" name="exam_question_answer_id" value="{{ $exam_question_answer->id }}">

						<div class="form-group">
							<label for="answer">Answer</label>
							<input type="text" name="answer" id="answer" class="form-control" value="{{ $exam_question_answer->answer }}">
						</div>

						<div class="form-group">
							<label for="points">Points</label>
							<input type="number" name="points" id="points" class="form-control" value="{{ $exam_question_answer->points }}">
						</div>

						<button type="submit" class="btn btn-primary">Save Changes</button>
						<a href="{{ action('ExamQuestionController@getView', $exam_question_answer->exam_question_id) }}" class="btn btn-link">View Question</a>
					</form>

				</div>
			</div>
		</div>
	</div>

@endsection