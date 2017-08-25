@extends('layouts.app')

@section('title', "|Categories")

@section('content')
<show-categories
@if(Auth::guard('admin')->check())
  :current-admin='{!! Auth::guard('admin')->user()->toJson() !!}'
@endif
></show-categories>
@endsection
