@extends('layouts.app')

@section('title', "| $user->name")

@section('content')
<user-profile
  :profile-user='{!! $user->toJson() !!}'
  @if (Auth::check())
    :current-user='{!! Auth::user()->toJson() !!}'
  @endunless
  >
</user-profile>
@endsection

{{--
@section('scripts')
  <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
  <script>
  tinymce.init({
     selector: 'textarea',
     plugins: 'link code',
     menubar: false,
     branding: false,
     height: 100,
     statusbar: true,
   });
  </script>
@endsection
--}}
