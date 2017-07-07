@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row myTabsRow">
    <div class="col-md-12 myTabs">
      <div class="content">

        <ul class="nav nav-tabs myUl">
          <li class="{{ Request::is('login') ?  "active" : "" }} loginli"><a data-toggle="tab" href="#login" id="loginA">Login</a></li>
          <li class="{{ Request::is('register') ?  "active" : "" }} registerLi"><a data-toggle="tab" href="#register" id="registerA">Register</a></li>
        </ul>

        <div class="tab-content">
          <div id="login" class="tab-pane fade in active">
            @include('../partials._login')
          </div>

          <div id="register" class="tab-pane fade">
            @include('../partials._register')
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection
