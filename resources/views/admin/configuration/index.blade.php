@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Configuration</h1>
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

                    <div class="panel panel-default">
                    	<div class="panel-body">
                            <form action="{{ action('Admin\ConfigurationController@postUpdate') }}" method="POST">
                                {!! csrf_field() !!}

                                <fieldset>
                                    <legend>Quarter Calendar</legend>
                                    <div class="form-group">
                                        <label for="1_quarter_date_from">1st Quarter</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">From</span>
                                            <input type="date" name="1_quarter_date_from" id="1_quarter_date_from" class="form-control" value="{{ $configs['1_quarter_date_from'] }}">
                                            <span class="input-group-addon">To</span>
                                            <input type="date" name="1_quarter_date_to" id="1_quarter_date_from" class="form-control" value="{{ $configs['1_quarter_date_to'] }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="1_quarter_date_from">2nd Quarter</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">From</span>
                                            <input type="date" name="2_quarter_date_from" id="2_quarter_date_from" class="form-control" value="{{ $configs['2_quarter_date_from'] }}">
                                            <span class="input-group-addon">To</span>
                                            <input type="date" name="2_quarter_date_to" id="2_quarter_date_from" class="form-control" value="{{ $configs['2_quarter_date_to'] }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="1_quarter_date_from">3rd Quarter</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">From</span>
                                            <input type="date" name="3_quarter_date_from" id="3_quarter_date_from" class="form-control" value="{{ $configs['3_quarter_date_from'] }}">
                                            <span class="input-group-addon">To</span>
                                            <input type="date" name="3_quarter_date_to" id="3_quarter_date_from" class="form-control" value="{{ $configs['3_quarter_date_to'] }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="1_quarter_date_from">4th Quarter</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">From</span>
                                            <input type="date" name="4_quarter_date_from" id="4_quarter_date_from" class="form-control" value="{{ $configs['4_quarter_date_from'] }}">
                                            <span class="input-group-addon">To</span>
                                            <input type="date" name="4_quarter_date_to" id="4_quarter_date_from" class="form-control" value="{{ $configs['4_quarter_date_to'] }}">
                                        </div>
                                    </div>
                                </fieldset>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
