@extends('layouts.app')

@section('title', "|Categories")

@section('content')
<category
  :category='{!! $category->toJson() !!}'
  @if (Auth::guard('web')->check())
  :auth-id='{!! Auth::id() !!}'
  @endif
>
</category>

@endsection
