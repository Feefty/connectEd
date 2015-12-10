@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">My Room</div>
				<div class="panel-body">
					<ul class="list-inline">
						<li><strong>Adviser:</strong> <a href="#">{{ $section->adviser }}</a></li>
					</ul>

					<h3><i class="fa fa-book"></i> Subjects</h3>
					<table data-toggle="table" data-url="{{ action('ClassSubjectController@getAPI', $section->id) }}">
						<thead>
							<tr>
								<th>Subject</th>
								<th>Teacher</th>
							</tr>
						</thead>
					</table>

					<h3><i class="fa fa-users"></i> Students</h3>
				</div>
			</div>
		</div>
	</div>

@endsection