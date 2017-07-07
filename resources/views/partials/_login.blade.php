@if (session('confirmation-success')  and strpos(session('confirmation-success') , "login") )
    <div class="col-md-10 col-md-offset-1 alert alert-success">
        {{ session('confirmation-success') }}
    </div>
@endif

@if (session('confirmation-danger'))
    <div class="col-md-10 col-md-offset-1 alert alert-danger">
        {!! session('confirmation-danger') !!}
    </div>
@endif

<form class="form-horizontal login" role="form" method="POST" action="{{ url('/login') }}">
    {{ csrf_field() }}

    <div class="form-group{{ ( $errors->has('email') and !$registerActive ) ? ' has-error' : '' }}">
        <div class="col-md-10 col-md-offset-1">
            <input id="email" type="email" class="form-control" name="email" value="{{ !$registerActive ? old('email') : "" }}" required autofocus placeholder="Email Address">

            @if ($errors->has('email') and !$registerActive)
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ ( $errors->has('password') and !$registerActive ) ? ' has-error' : '' }}">
        <div class="col-md-10 col-md-offset-1">
            <input id="password" type="password" class="form-control" name="password" required placeholder="Password">

            @if ($errors->has('password') and !$registerActive)
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-1">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div style="text-align: center">
            <button type="submit" class="btn btn-primary btn-lg" style="width: 200px;">
                Sign In
            </button>
            <br />
            <a class="btn btn-link" href="{{ url('/password/reset') }}">
                Forgot Your Password?
            </a>
        </div>
    </div>

    <hr />
    <div class="row social-links" style="text-align: center">
      <p>Or Sign In With:</p>
      @include('../partials._social-links')
    </div>

</form>
