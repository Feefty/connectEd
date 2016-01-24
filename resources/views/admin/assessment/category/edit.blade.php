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
                                    
                    <form method="POST" action="{{ action('Admin\AssessmentCategoryController@postEdit') }}">
                        {!! csrf_field() !!}

                        <input type="hidden" name="assessment_category_id" value="{{ $assessment_category->id }}">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $assessment_category->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control">{{ $assessment_category->description }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="{{ action('Admin\AssessmentCategoryController@getIndex') }}">Cancel</a>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection