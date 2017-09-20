@extends('layouts.app')

@section('title', '|Home')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <posts
            :user-data='{!! $user->toJson() !!}'
            @if (Auth::guard('web')->check())
              :auth-id='{!! Auth::id() !!}'
              :home-page=true
            @endif
          >
        </posts>
        </div>
    </div>
</div>
@endsection
