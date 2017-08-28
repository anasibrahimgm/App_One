@extends('layouts.app')

@section('title', "|$post->title")

@section('content')
  <post-content
    :post-data='{!! $post->toJson() !!}'
    :complete-post='true'
    @if (Auth::id() == $post->user->id)
      :auth-id='{!! Auth::id() !!}'
    @endif
    >
  </post-content>
@endsection
