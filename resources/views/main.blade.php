<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.title') }}</title>
	<link rel="stylesheet" href="{{ asset('/css/all.app.css') }}">
</head>
<body>

	<nav class="navbar navbar-default navbar-fixed-top">
	  	<div class="container-fluid">
		    <div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-navbar-collapse" aria-expanded="false">
				    <span class="sr-only">Toggle navigation</span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
				</button>
		    </div>

		    <div class="collapse navbar-collapse" id="bs-navbar-collapse">
		     	<ul class="nav navbar-nav">
			        <li><a href="{{ action('HomeController@getIndex') }}"><i class="fa fa-home"></i> Home</a></li>
			        @can ('read-my-room', 'strict')
			        	<li><a href="{{ action('RoomController@getIndex') }}"><i class="fa fa-umbrella"></i> My Room</a></li>
			        @endcan
			        @can ('read-my-class', 'strict')
			        	<li><a href="{{ action('MyClassController@getIndex') }}"><i class="fa fa-hourglass-1"></i> My Class</a></li>
			        @endcan
			        @can ('manage-lesson')
			        	<li><a href="{{ action('LessonController@getIndex') }}"><i class="fa fa-book"></i> Lessons</a></li>
			        @endcan
			        @can ('read-assessment', 'strict')
			        	<li><a href="{{ action('AssessmentController@getIndex') }}"><i class="fa fa-line-chart"></i> Assessment</a></li>
			        @endcan
			        @can ('read-class-section', 'strict')
			        	<li><a href="{{ action('ClassSectionController@getIndex') }}">Sections</a></li>
			        @endcan
			        @can ('read-school-member', 'strict')
			        	<li><a href="{{ action('SchoolMemberController@getIndex') }}"><i class="fa fa-users"></i> Members</a></li>
			        @endcan
			        @can ('read-exam', 'strict')
			        <li><a href="{{ action('ExamController@getIndex') }}"><i class="fa fa-file-text"></i> Exams</a></li>
			        @endcan
		      	</ul>
		      	<ul class="nav navbar-nav navbar-right">
		      		@if ( ! auth()->check())
			        	<li><a href="{{ action('Auth\AuthController@getLogin') }}">Sign In</a></li>
			        	<li><a href="{{ action('Auth\AuthController@getRegister') }}">Register</a></li>
			        @else
			        	<li class="dropdown">
			        		<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell notification-icon"></i></a>
			        		<ul class="dropdown-menu notification-holder">
			        			<li><a href="#">Hello World</a></li>
			        		</ul>
			        	</li>
			        	<li><a href="#"><i class="fa fa-envelope"></i></a></li>
				        <li class="dropdown">
			          		<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ auth()->user()->username }} <span class="caret"></span></a>
			          		<ul class="dropdown-menu">
			          			@can ('read-dashboard')
				      			<li><a href="{{ action('Admin\DashboardController@getIndex') }}">Admin</a></li>
				      			@endcan
			          			<li><a href="{{ action('ProfileController@getIndex') }}">Profile</a></li>
					        	<li><a href="{{ action('SettingsController@getProfile') }}">Settings</a></li>
					        	<li class="divider"></li>
					        	<li><a href="{{ action('Auth\AuthController@getLogout') }}">Logout</a></li>
			          		</ul>
				        </li>
		        	@endif
		      	</ul>
		    </div>
	  	</div>
	</nav>

	<div class="padding-md">
		<a href="{{ action('HomeController@getIndex') }}"><img src="{{ asset('/img/logo.png') }}" alt="" class="img-responsive center-block"></a>
	</div>

	<div class="container-fluid">
		@yield('content')
	</div>

	<footer>
		<p class="text-center small"><a href="{{ action('HomeController@getIndex') }}">{{ config('app.brand') }}</a> {{ date('Y') }} &copy; All rights reserved.</p>
	</footer>
	
	<script src="{{ asset('/js/app.vendor.js') }}"></script>
	<script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>