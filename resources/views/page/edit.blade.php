@extends('main')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default margin-lg-top">
                    <div class="panel-heading">
                        Page
                    </div>
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
                        <form method="POST" action="{{ action('PageController@postEdit') }}">
    		   				{!! csrf_field() !!}
							<input type="hidden" name="page_id value="{{ $page->id }}">

    		   				<div class="form-group">
    		   					<label for="title">Title</label>
    		   					<input type="text" name="title" id="title" class="form-control" value="{{ $page->title }}">
    		   				</div>
    		   				<div class="form-group">
    		   					<label for="content">Content</label>
    		   					<textarea name="content" data-toggle="wysiwyg" id="content" class="form-control">{{ $page->content }}</textarea>
    		   				</div>
    		   				<div class="form-group">
    		   					<label for="category">Category</label>
    		   					<select id="category" name="category" class="form-control">
    		   						@foreach (config('content_category') as $row)
                                        @if ($page->category == $row)
    		   							    <option value="{{ $row }}" selected>{{ ucwords(strtolower(str_replace('_', ' ', $row))) }}</option>
                                        @else
    		   							    <option value="{{ $row }}">{{ ucwords(strtolower(str_replace('_', ' ', $row))) }}</option>
                                        @endif
    		   						@endforeach
    		   					</select>
    		   				</div>
    		   				<div class="form-group">
    		   					<label for="privacy">Privacy</label>
    		   					<div class="radio">
    		   						<label>
    		   							<input type="radio" name="privacy" value="1"{{ $page->privacy == 1 ? ' checked' : '' }}>
    		   							Public
    		   						</label>
    		   						<label>
    		   							<input type="radio" name="privacy" value="0"{{ $page->privacy == 0 ? ' checked' : '' }}>
    		   							Private
    		   						</label>
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
