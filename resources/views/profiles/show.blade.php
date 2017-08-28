@extends('layouts.app')

@section('title', "| $user->name")

@section('content')
<user-profile
  :profile-user='{!! $user->toJson() !!}'
  @if (Auth::check())
    :auth-id='{!! Auth::id() !!}'
  @endif
>
</user-profile>
@endsection


@section('scripts')
  <script>
  $('.select2-single').select2();
  </script>
@endsection
