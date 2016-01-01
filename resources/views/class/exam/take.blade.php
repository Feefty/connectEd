@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						<a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> 
						Class Subject Exam Take
					</div>
					<div class="panel-body">
						<div id="content-msg"></div>

						@if (strtotime($class_subject_exam->start) < time() && strtotime($class_subject_exam->end) > time())
							<h2>{{ $class_subject_exam->exam->title }} <small>{{ $class_subject_exam->exam->exam_type->name }}</small></h2>
							<ul class="list-inline">
								<li>{!! $class_subject_exam->status == 1 ? '<i class="fa fa-lightbulb"></i> <span class="text-success">Active</span>' : '<i class="fa fa-lightbulb-o"></i> <span class="text-muted">Inactive</span>' !!}</li>
								<li><i class="fa fa-book"></i> {{ $class_subject_exam->exam->subject->name }}</li>
								<li><i class="fa fa-calendar"></i> {{ $class_subject_exam->start .' to '. $class_subject_exam->end }}</li>
							</ul>

							<hr>

							@if ($show_questions)
								<button type="button" id="start-exam" data-exam-id="{{ $class_subject_exam->exam->id }}" class="btn btn-primary center-block">Start asnwering / Get grade</button>
								<div id="exam-question-block">
									<div id="question-block"></div>
									<div id="question-answer-block"></div>
								</div>
							@else
								<h3 class='text-center'>Your grade</h3>
								<h2 class='text-center'>{{ $grade['score'] .' / '. $grade['total'] }} <small>{{ round(($grade['score']/$grade['total'])*100) }}%</small></h2>
							@endif
						@else
							<div class="text-helper">
								The exam has already ended {{ $class_subject_exam->end->diffForHumans() }}.
							</div>
						@endif
					</div>	
				</div>
			</div>
		</div>
	</div>

@endsection