@extends('layouts.app')

@section('title', '|Edit Post')

@section('content')
  <edit-post
  :post='{!! $post->toJson() !!}'
  >
  </edit-post>
@endsection
