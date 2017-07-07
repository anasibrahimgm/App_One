@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row myTabsRow">
    <div class="col-md-12 myTabs">
      <div class="content">
        <?php $registerActive = ( ( Request::is('register') and !old('email') ) || old('name') || ( session('confirmation-success')  and strpos(session('confirmation-success') , "signing") ) ) ? true : false; ?>

        <ul class="nav nav-tabs myUl">
          <li class="{{ $registerActive ?  "" : "active" }} loginli"><a data-toggle="tab" href="#login" id="loginA">Login</a></li>
          <li class="{{ $registerActive ?  "active" : "" }} registerLi"><a data-toggle="tab" href="#register" id="registerA">Register</a></li>
        </ul>

        <div class="tab-content tab-content-sign">
          <div id="login" class="tab-pane fade in {{ $registerActive ?  "" : "active" }}">
            @include('../partials._login')
          </div>

          <div id="register" class="tab-pane fade in {{ $registerActive ?  "active" : "" }}">
            @include('../partials._register')
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

@endsection
