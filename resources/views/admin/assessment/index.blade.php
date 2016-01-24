@extends('admin')

@section('content')
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Assessment</h1>

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
                        <div class="dropdown">
                            <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-list"></i> Menu</button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Add Category</a></li>
                            </ul>
                        </div>
                    </div>
                                    
                    <table data-toggle="table" data-url="{{ action('Admin\AssessmentController@getApi') }}" data-pagination="true" data-search="true" data-show-refresh="true" data-toolbar="#toolbar">
                        <thead>
                            <tr>
                                <th data-field="assessmentGradeFormatter" data-sortable="true">Grade</th>
                                <th data-field="source" data-sortable="true">Source</th>
                                <th data-formatter="studentProfileNameFormatter" data-sortable="true">Taken by</th>
                                <th data-formatter="assessedByProfileNameFormatter" data-sortable="true">Assessed by</th>
                                <th data-formatter="schoolNameFormatter" data-sortable="true">School</th>
                                <th data-field="created_at" data-sortable="true">Date Added</th>
                                <th data-formatter="actionAssessmentFormatter" data-align="center"></th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection