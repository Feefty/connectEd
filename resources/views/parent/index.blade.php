@extends('main')

@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Parent</div>
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


                    <div id="toolbar">
						<button type="button" data-toggle="collapse" class="btn btn-default pull-left" data-target="#parentCodeForm"><i class="fa fa-key"></i> Parent Code</button>
						<div class="collapse pull-left margin-lg-left" id="parentCodeForm">
							<form action="{{ action('ParentController@postAdd') }}" method="POST" class="form-inline">
								{!! csrf_field() !!}
								<div class="form-group">
									<input type="text" id="parent_code" name="parent_code" class="form-control" placeholder="Enter Parent Code">
								</div>
								<button type="submit" class="btn btn-primary">Add</button>
							</form>
						</div>
                    </div>

					<table data-toggle="table" data-search="true" data-toolbar="#toolbar" data-url="{{ action('ParentController@getApi') }}">
						<thead>
							<tr>
								<th data-formatter="profileNameFormatter">Name</th>
								<th data-field="class_student.class_section.name">Section</th>
								<th data-field="class_student.class_section.level">Grade</th>
								<th data-formatter="classStudentClassSectionTeacherProfileNameFormatter">Adivser</th>
							</tr>
						</thead>
					</table>
                </div>
            </div>
		</div>
	</div>

@endsection
