@extends('layouts.app')

@section('title', "|$post->title")

@section('content')
  <post-content
    :post-data='{!! $post->toJson() !!}'
    :complete-post='true'
    @if (Auth::guard('web')->check())
      :auth-id='{!! Auth::id() !!}'
    @endif
    >
  </post-content>
@endsection
