@extends('layouts.app')

@section('title', "|Categories")

@section('content')
<category-posts
  :category='{!! $category->toJson() !!}'
  @if(Auth::check())
  :auth-id='{!! Auth::id() !!}'
  @endif
>
</category-posts>

@endsection
