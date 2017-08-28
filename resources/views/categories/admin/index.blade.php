@extends('layouts.app')

@section('title', "|Categories")

@section('content')
<admin-categories
@if(Auth::guard('admin')->check())
  :current-admin='{!! Auth::guard('admin')->user()->toJson() !!}'
@endif
>
</admin-categories>
@endsection
