<nav class="navbar navbar-default navbar-static-top">
  @if(Request::is('login') || Request::is('register'))
    <div class="container navContainer">
        <div class="navbar-header">
            <a class="navbar-brand navA" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>
    </div>
  @else
  <div class="container">
      <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
              <span class="sr-only">Toggle Navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>

          <a class="navbar-brand" href="{{ url('/') }}">
              <i class="fa fa-home fa-lg" aria-hidden="true"></i> {{ config('app.name', 'Laravel') }}
          </a>
      </div>


      <div class="collapse navbar-collapse" id="app-navbar-collapse">
          <!-- Left Side Of Navbar -->
          <ul class="nav navbar-nav">
              &nbsp;
          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="nav navbar-nav navbar-right">
              <!-- Authentication Links -->
              @if (Auth::guest())
                  <li><a href="{{ route('login') }}">Login</a></li>
                  <li><a href="{{ route('register') }}">Register</a></li>
              @else
                  <show-notifications
                  :notifications= '{!! Auth::user()->notifications->toJson() !!}'
                  :unread-count= '{!! count(Auth::user()->unreadNotifications) !!}'
                  :userid= '{!! Auth::guard('web')->id() !!}'
                  ></show-notifications>

                  @if (Request::is('editProfile') || Request::is('users/'. Auth::guard('web')->user()->username) )
                    <navbar
                      :auth-user='{!! Auth::user()->toJson() !!}'
                    ></navbar>
                  @else
                    <li><a id="currentUser_data" href="{{ route('users.show', Auth::user()->username ) }}"><img  src="{{asset('images/users/avatars/')}}/{{ Auth::user()->avatar }}" /><span id="currentUser_name"> {{ ucwords(explode(" ", Auth::user()->name)[0]) }}</span></a></li>
                  @endif
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                          <span class="caret"></span>
                      </a>

                      <ul class="dropdown-menu" role="menu">
                          <li>
                            <a href="{{ route('editProfile') }}"><i class="fa fa-cog fa-lg" aria-hidden="true"></i> Edit Profile</a>
                          </li>

                          <li>
                              <a href="{{ Auth::guard('admin')->check() ? route('admin.logout') : route('logout') }}"
                                  onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                                  <i class="fa fa-sign-out fa-lg" aria-hidden="true"></i> Logout
                              </a>

                              <form id="logout-form" action="{{ Auth::guard('admin')->check() ? route('admin.logout') : route('logout') }}" method="POST" style="display: none;">
                                  {{ csrf_field() }}
                              </form>
                          </li>
                      </ul>
                  </li>
              @endif
          </ul>
      </div>
  </div>
  @endif
</nav>
