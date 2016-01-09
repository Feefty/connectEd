@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">My Class</div>
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

					<table data-url="{{ action('ClassSubjectController@getApi') }}?teacher_id={{ auth()->user()->id }}" data-toggle="table" data-pagination="true" data-search="true">
						<thead>
							<tr>
								<th data-field="room" data-sortable="true">Room</th>
								<th data-formatter="classSectionNameFormatter" data-sortable="true">Section</th>
								<th data-formatter="subjectNameFormatter" data-sortable="true">Subject</th>
								<th data-align="center" data-formatter="actionMyClassFormatter"></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection