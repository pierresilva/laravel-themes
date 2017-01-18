@extends('DummySlug::layouts.app')

@section('content')
@if (Session::has('error_message'))
    <div class="container">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('error_message') }}
        </div>
    </div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Welcome to our web page!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
