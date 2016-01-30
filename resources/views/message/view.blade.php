@extends('main')

@section('content')

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading"><a href="{{ $message_to->username }}">{{ ucwords(strtolower($message_to->profile->first_name .' '. $message_to->profile->last_name)) }}'s</a> Conversation</div>
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

                    <div class="messages">
                        @foreach ($messages as $row)
                            <div class="message-bit" id="message-{{ $row->id }}">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="pull-left">
                                            <a href="{{ action('ProfileController@getUser', $row->from->username) }}">{{ ucwords(strtolower($row->from->profile->first_name .' '. $row->from->profile->last_name)) }}</a>
                                        </p>
                                        <p class="pull-right text-muted small margin-md-right">
                                            <i class="fa fa-clock-o" data-toggle="tooltip" title="{{ $row->created_at }}"></i> {{ $row->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        {!! nl2br(e($row->content)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row margin-lg-top">
                        <div class="col-sm-12">
                            <form action="" method="post" id="sendMessageForm">
                                {!! csrf_field() !!}
                                <input type="hidden" name="to_id" value="{{ $to_id }}">
                                <div class="form-group">
                                    <textarea name="content" class="form-control" placeholder="Message here"></textarea>
                                </div>
                                <button type="button" class="btn btn-primary">Send</button>
                            </form>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>

@endsection
