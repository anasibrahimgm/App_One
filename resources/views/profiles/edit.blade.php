@extends('layouts.app')

@section('title', "|Edit Profile")

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-9">
      <edit-profile
        @if (Auth::check())
          :auth-user='{!! Auth::user()->toJson() !!}'
        @endif
        >
      </edit-profile>
    </div>

    <div class="col-md-3">
      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </div>
  </div>
</div>
@endsection