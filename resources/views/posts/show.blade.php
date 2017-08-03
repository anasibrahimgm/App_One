@extends('layouts.app')

@section('title', "|$post->title")

@section('content')
  @include('partials._postContent')

  @component('components.postBodyExtended', ['post' => $post])
  @endcomponent
  </div>

  @if($post->image)
  <div class="col-md-12">
      <img src={{ asset("images/posts/$post->image") }} width="100%" />
  </div>
  @endif
  </div>
@endsection
