@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
					<div class="panel-body">
						<form method="POST">
							<div class="form-group">
								<label for="achievement">Student</label>
								<select name="achievement" id="achievement" class="form-control">
									@foreach ($achievements as $row)
										<option value="{{ $row->id }}">{{ $row->title }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label for="achievement">Achievement</label>
								<select name="achievement" id="achievement" class="form-control">
									@foreach ($achievements as $row)
										<option value="{{ $row->id }}">{{ $row->title }}</option>
									@endforeach
								</select>
							</div>
							<button type="submit" class="btn btn-primary" onclick="return confirm('Do you want to continue your action?')">Submit</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection