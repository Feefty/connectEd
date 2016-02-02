@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Messages by Month
                                </div>
                                <div class="panel-body">
                                    <canvas data-toggle="chart" data-url="{{ action('Admin\MessageController@getData') }}" data-type="line" data-target="#message-chart" id="message-chart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Users
                                </div>
                                <div class="panel-body">
                                    <canvas data-toggle="chart" data-url="{{ action('Admin\MessageController@getData') }}" data-type="line" data-target="#message-chart" id="message-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
