@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><a href="{{ action('Admin\QuarterCalendarController@getIndex') }}" class="small"><i class="fa fa-angle-double-left" title="Go back!"></i></a> Quarter Calendar Edit</h1>
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

            		<form action="{{ action('Admin\QuarterCalendarController@postEdit') }}" method="POST">
            			{!! csrf_field() !!}
            			<input type="hidden" name="school_year" value="{{ (int) $school_year }}">

		      			<div class="form-group">
                            <label for="quarter_1_from">1st Quarter</label>
                            <div class="input-group">
                                <span class="input-group-addon">From</span>
                                <input type="date" name="quarter_1_from" id="quarter_1_from" class="form-control" value="{{ $quarter_calendar['quarter_1']['date_from'] }}">
                                <span class="input-group-addon">To</span>
                                <input type="date" name="quarter_1_to" id="quarter_1_to" class="form-control" value="{{ $quarter_calendar['quarter_1']['date_to'] }}">
                            </div>
		      			</div>
		      			<div class="form-group">
                            <label for="quarter_2_from">2nd Quarter</label>
                            <div class="input-group">
                                <span class="input-group-addon">From</span>
                                <input type="date" name="quarter_2_from" id="quarter_2_from" class="form-control" value="{{ $quarter_calendar['quarter_2']['date_from'] }}">
                                <span class="input-group-addon">To</span>
                                <input type="date" name="quarter_2_to" id="quarter_2_to" class="form-control" value="{{ $quarter_calendar['quarter_2']['date_to'] }}">
                            </div>
		      			</div>
		      			<div class="form-group">
                            <label for="quarter_3_from">3rd Quarter</label>
                            <div class="input-group">
                                <span class="input-group-addon">From</span>
                                <input type="date" name="quarter_3_from" id="quarter_3_from" class="form-control" value="{{ $quarter_calendar['quarter_3']['date_from'] }}">
                                <span class="input-group-addon">To</span>
                                <input type="date" name="quarter_3_to" id="quarter_3_to" class="form-control" value="{{ $quarter_calendar['quarter_3']['date_to'] }}">
                            </div>
		      			</div>
		      			<div class="form-group">
                            <label for="quarter_4_from">4th Quarter</label>
                            <div class="input-group">
                                <span class="input-group-addon">From</span>
                                <input type="date" name="quarter_4_from" id="quarter_4_from" class="form-control" value="{{ $quarter_calendar['quarter_4']['date_from'] }}">
                                <span class="input-group-addon">To</span>
                                <input type="date" name="quarter_4_to" id="quarter_4_to" class="form-control" value="{{ $quarter_calendar['quarter_4']['date_to'] }}">
                            </div>
		      			</div>
            			<button type="submit" class="btn btn-primary">Save Changes</button>
            		</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
