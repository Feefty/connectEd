@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-heading">
						<a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a>
						Class Subject Exam Edit
						<a href="{{ action('ClassSubjectExamController@getEdit', $class_subject_exam->id) }}" title="Edit" data-toggle="tooltip" class="pull-right"><i class="fa fa-pencil"></i></a>
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

                        <form action="{{ action('ClassSubjectExamController@postEdit') }}" method="POST">
                            {!! csrf_field() !!}
                            <input type="hidden" name="class_subject_exam_id" value="{{ (int) $class_subject_exam->id }}">

                            <div class="form-group">
                                <label for="start">Start</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" name="start_date" id="start" class="form-control" placeholder="YYYY-MM-DD" value="{{ date('Y-m-d', strtotime($class_subject_exam->start)) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="time" name="start_time" class="form-control" placeholder="HH:MM" value="{{ date('H:i', strtotime($class_subject_exam->start)) }}">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="end">End</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="date" name="end_date" id="end" class="form-control" placeholder="YYYY-MM-DD" value="{{ date('Y-m-d', strtotime($class_subject_exam->end)) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="time" name="end_time" class="form-control" placeholder="HH:MM" value="{{ date('H:i', strtotime($class_subject_exam->end)) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="quarter">Quarter</label>
                                <select class="form-control" name="quarter" id="quarter">
                                    @for ($i = 1; $i <= 4; $i++)
                                        @if ($i == $class_subject_exam->quarter)
                                            <option value="{{ $i }}" selected>{{ $i }}</option>
                                        @else
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endif
                                    @endfor
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
							<a href="{{ action('ClassSubjectExamController@getView', $class_subject_exam->id) }}" class="btn btn-link">Cancel</a>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
