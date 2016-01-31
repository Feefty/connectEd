@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="{{ \URL::previous() }}"><i class="fa fa-arrow-left"></i></a> Course Calendar</div>
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

                    <div data-toggle="calendar"></div>
				</div>
			</div>
		</div>
	</div>

@endsection
