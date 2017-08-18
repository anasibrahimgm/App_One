@extends('layouts.app')

@section('title', "|$post->title")

@section('content')
  <post-content
    :post='{!! $post->toJson() !!}'
    :post-owner='{!! $post->user->toJson() !!}'
    :complete-post='true'
    @if (Auth::id() == $post->user->id)
      :owner='true'
    @else
      :owner='false'
    @endif
    >
  </post-content>
@endsection
