@extends('layouts.app')

@section('title', "| $user->name")

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-9">
      <div class="user-basicInfo">
        <div class="basicInfo-left">
          <img src={{ asset("images/users/avatars/$user->avatar") }} />
        </div>

        <div class="basicInfo-right">
          <div class="info">
            <h3 class="userName"> {{ ucwords($user->name) }} </h3>
            <p class="userBio"> {{ $user->bio }} </p>
          </div>
        </div>
      </div>
      <div class="horizontalTab"></div>

      <div class="feeds">
        <div class="feeds-left">
          <p class="horizontalTabSmall">Feeds</p>
          <ul class="nav nav-pills nav-stacked">
            <li class="active"><a data-toggle="pill" href="#posts">Posts&nbsp;<span class="badge">{{ $user->posts }}</span></a></li>
            <li><a data-toggle="pill" href="#comments">Comments&nbsp;<span class="badge">{{ $user->comments }}</span></a></li>
            <li><a data-toggle="pill" href="#replies">Replies&nbsp;<span class="badge">{{ $user->replies }}</span></a></li>
          </ul>
        </div>

        <div class="feeds-right">
            <div class="tab-content info">
              <div id="posts" class="tab-pane fade in active">
                <p class="horizontalTabSmall">Posts</p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </div>

              <div id="comments" class="tab-pane fade">
                <p class="horizontalTabSmall">Comments</p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </div>

              <div id="replies" class="tab-pane fade">
                <p class="horizontalTabSmall">Replies</p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </div>
          </div>
        </div>
      </div>

    </div>

    <div class="col-md-3">
      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </div>
  </div>
</div>
@endsection
