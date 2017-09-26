@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">ADMIN Dashboard</div>

                <div class="panel-body">
                    <a href="{{ route('categories.index') }}" class="btn btn-default">Categories</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
