@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
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
						@can ('manage-page')
							<a href="{{ action('PageController@getEdit', $page->id) }}" class="pull-right" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil fa-fw"></i></a>
							<a href="{{ action('PageController@getDelete', $page->id) }}" onclick="return confirm('Are you sure you want to delete this page?')" class="pull-right" data-toggle="tooltip" title="Delete"><i class="fa fa-remove fa-fw text-danger"></i></a>
						@endcan
						<h1>{{ $page->title }}</h1>
                        <ul class="list-inline small text-muted">
                            <li><a href="#"><i class="fa fa-user"></i> {{ ucwords(strtolower($page->user->profile->last_name .', '. $page->user->profile->first_name)) }}</a></li>
                            <li><i class="fa fa-clock-o"></i> {{ $page->created_at->diffForHumans() }}</li>
                            <li><i class="fa fa-flag"></i> {{ ucwords(str_replace('_', ' ', $page->category)) }}</li>
                        </ul>
                        {!! $page->content !!}
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
