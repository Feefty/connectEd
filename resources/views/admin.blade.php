<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ config('app.title') }}</title>
	<link rel="stylesheet" href="{{ asset('/css/all.admin.css') }}">
</head>
<body>

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="" href="{{ action('Admin\DashboardController@getIndex') }}"><img src="{{ asset('/img/logo.png') }}" class="img-brand" alt="{{ config('app.brand') }}"></a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ action('HomeController@getIndex') }}"><i class="fa fa-home"></i> Public</a></li>
                        <li><a href="{{ action('SettingsController@getProfile') }}"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ action('Auth\AuthController@getLogout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li><a href="{{ action('Admin\DashboardController@getIndex') }}">Dashboard</a></li>
                        <li>
                            <a href="#">Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ action('Admin\UserController@getIndex') }}">Users</a>
                                </li>
                                <li>
                                    <a href="{{ action('Admin\GroupController@getIndex') }}">Groups</a>
                                </li>
                                <li>
                                    <a href="{{ action('Admin\SchoolController@getIndex') }}">Schools</a>
                                </li>
                                <li>
                                    <a href="{{ action('Admin\SubjectController@getIndex') }}">Subjects</a>
                                </li>
                                <li>
                                    <a href="{{ action('Admin\AchievementController@getIndex') }}">Achievements</a>
                                </li>
                                <li>
                                    <a href="{{ action('Admin\GradeController@getIndex') }}">Grades</a>
                                </li>
                                <li>
                                    <a href="{{ action('Admin\PageController@getIndex') }}">Pages</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

    </div>
	
	<script src="{{ asset('/js/admin.vendor.js') }}"></script>
	<script src="{{ asset('/js/admin.js') }}"></script>

</body>
</html>
