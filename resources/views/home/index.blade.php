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
						<div class="row">
							<div class="col-sm-6">
								<h3>ANNOUNCEMENTS</h3>
								<table class="table">
									@foreach ($announcements as $row)
										<tr>
											<h4>{{ $row->title }}</h4>
											{{ $row->content }}
										</tr>
									@endforeach
								</table>
							</div>
							<div class="col-sm-6">
								<h3>
									NEWS & EVENTS
									@can ('create-page')
										<a href="#contentManagerModal" data-toggle="modal" class="btn btn-default btn-xs pull-right"><i class="fa fa-plus"></i> Create Content</a>
									@endcan
								</h3>
								<table class="table">
									@foreach ($news as $row)
										<tr>
											<h4>{{ $row->title }}</h4>
											{{ $row->content }}
										</tr>
									@endforeach
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="contentManagerModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
		    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    		<h4 class="modal-title" id="modalLabel">Content Manager</h4>
		   		</div>
		   		<div class="modal-body">
		   			<form method="POST" action="{{ action('PageController@postAdd') }}">
		   				{!! csrf_field() !!}

		   				<div class="form-group">
		   					<label for="title">Title</label>
		   					<input type="text" name="title" id="title" class="form-control">
		   				</div>
		   				<div class="form-group">
		   					<label for="content">Content</label>
		   					<textarea name="content" id="content" class="form-control"></textarea>
		   				</div>
		   				<div class="form-group">
		   					<label for="category">Category</label>
		   					<select id="category" name="category" class="form-control">
		   						@foreach (config('content_category') as $row)
		   							<option value="{{ $row }}">{{ ucwords(strtolower(str_replace('_', ' ', $row))) }}</option>
		   						@endforeach
		   					</select>
		   				</div>
		   				<div class="form-group">
		   					<label for="privacy">Privacy</label>
		   					<div class="radio">
		   						<label>
		   							<input type="radio" name="privacy" value="1" checked>
		   							Public
		   						</label>
		   						<label>
		   							<input type="radio" name="privacy" value="0">
		   							Private
		   						</label>
		   					</div>
		   				</div>
		   				<button type="submit" class="btn btn-primary">Publish</button>
		   			</form>
		   		</div>
		   	</div>
		</div>
	</div>

@endsection
