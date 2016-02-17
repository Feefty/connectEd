@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						<a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a>
						Student's Exam Answers
					</div>
					<div class="panel-body">
						<div id="content-msg"></div>
						<h2><a href="{{ action('ClassSubjectExamController@getView', $class_subject_exam->id) }}">{{ $class_subject_exam->exam->title }}</a></h2>
						<h3 class="text-right">Score {{ $grade['score'] }}/{{ $grade['total'] }} ({{ round(($grade['score']/$grade['total']) * 100) }}%)</h3>
						<?php $count = 1 ?>
                        @foreach ($class_subject_exam->exam->question as $question)
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4>{{ $count++ }}. {{ config('question_category')[$question->category] }}</h4>
                                    <div class="well">
                                        @if ($question->category == 'fillintheblank')
                                            {!! str_replace(':answer', '_______', $question->question) !!}
                                        @else
                                            {!! $question->question !!}
                                        @endif
                                    </div>
                                    <div class="">
                                        <h5>Answers:</h5>
                                        @if ($question->category == 'multiplechoice')
                                            <ol type="a">
                                                <?php $student_answers = [];
                                                foreach ($question->student_exam_question_answer as $student_answer)
                                                {
                                                    $student_answers[] = $student_answer->answer;
                                                }
                                                ?>
                                                @for ($i = 0; $i < count($question->answer); $i++)
                                                    @if ($question->answer[$i]->points > 0)
                                                        @if (count($question->student_exam_question_answer) > 0 && in_array($question->answer[$i]->answer, $student_answers))
                                                            <li>{{ $question->answer[$i]->answer }} ({{ $question->answer[$i]->points }} pts.) <i class="fa fa-check text-success"></i></li>
                                                        @else
                                                            <li><span class="text-success">[{{ $question->answer[$i]->answer }}] ({{ $question->answer[$i]->points }} pts.)</span></li>
                                                        @endif
                                                    @else
                                                        @if (count($question->student_exam_question_answer) > 0 && in_array($question->answer[$i]->answer, $student_answers))
                                                            <li>{{ $question->answer[$i]->answer }} <i class="fa fa-remove text-danger"></i></li>
                                                        @else
                                                            <li>{{ $question->answer[$i]->answer }}</li>
                                                        @endif
                                                    @endif
                                                @endfor
                                            </ol>
                                        @elseif ($question->category == 'fillintheblank')
                                            <ol>
                                                @for ($i = 0; $i < count($question->answer); $i++)
                                                    @if (isset($question->student_exam_question_answer[$i]))
                                                        @if ($question->answer[$i]->answer == $question->student_exam_question_answer[$i]->answer)
                                                            <li>{{ $question->answer[$i]->answer }} ({{ $question->answer[$i]->points }}) <i class="fa fa-check text-success"></i></li>
                                                        @else
                                                            <li>{{  $question->student_exam_question_answer[$i]->answer }} <i class="fa fa-remove text-danger"></i> <span class="text-success">[{{ $question->answer[$i]->answer }}] ({{ $question->answer[$i]->points }} pts.)</span></li>
                                                        @endif
                                                    @else
                                                        <li>Blank <i class="fa fa-remove text-danger"></i> <span class="text-success">[{{ $question->answer[$i]->answer }}]</span></li>
                                                    @endif
                                                @endfor
                                            </ol>
                                        @elseif ($question->category == 'trueorfalse')
                                            <ul>
                                                @if ($question->answer[0]->answer == 'true')
													@if (isset($question->student_exam_question_answer[0]) && $question->student_exam_question_answer[0]->answer == 'true')
														<li>True ({{ $question->answer[0]->points }} pts.)<i class="fa fa-check text-success"></i></li>
														<li>False</li>
													@else
														<li><span class="text-success">[True] ({{ $question->answer[0]->points }} pts.)</span></li>
														<li>False <i class="fa fa-remove text-danger"></i></li>
													@endif
												@else
													@if (isset($question->student_exam_question_answer[0]) && $question->student_exam_question_answer[0]->answer == 'false')
														<li>True</li>
														<li>False ({{ $question->answer[0]->points }} pts.)<i class="fa fa-check text-success"></i></li>
													@else
														<li>True <i class="fa fa-remove text-danger"></i></li>
														<li><span class="text-success">[False] ({{ $question->answer[0]->points }} pts.)</span></li>
													@endif
												@endif
                                            </ul>
                                        @else
                                            <ul>
												@for ($i = 0; $i < count($question->answer); $i++)
                                                    @if (isset($question->student_exam_question_answer[$i]))
                                                        @if ($question->answer[$i]->answer == $question->student_exam_question_answer[$i]->answer)
                                                            <li>{{ $question->answer[$i]->answer }} ({{ $question->answer[$i]->points }}) <i class="fa fa-check text-success"></i></li>
                                                        @else
                                                            <li>{{  $question->student_exam_question_answer[$i]->answer }} <i class="fa fa-remove text-danger"></i> <span class="text-success">[{{ $question->answer[$i]->answer }}] ({{ $question->answer[$i]->points }} pts.)</span></li>
                                                        @endif
                                                    @else
                                                        <li>Blank <i class="fa fa-remove text-danger"></i> <span class="text-success">[{{ $question->answer[$i]->answer }}]</span></li>
                                                    @endif
                                                @endfor
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
