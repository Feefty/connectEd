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

                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
