@if (session('confirmation-success') and strpos(session('confirmation-success') , "signing") )
    <div class="col-md-10 col-md-offset-1 alert alert-success">
        {{ session('confirmation-success') }}
    </div>
@else
    <form class="form-horizontal register" role="form" method="POST" action="{{ url('/register') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <div class="col-md-10 col-md-offset-1">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Name">

                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <div class="col-md-10 col-md-offset-1">
                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus placeholder="Username">

                @if ($errors->has('username'))
                    <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ ( $errors->has('email') and $registerActive ) ? ' has-error' : '' }}">
            <div class="col-md-10 col-md-offset-1">
                <input id="email" type="email" class="form-control" name="email" value="{{ $registerActive ? old('email') : "" }}" required placeholder="E-Mail Address">

                @if ($errors->has('email') and $registerActive)
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ ( $errors->has('password') and $registerActive ) ? ' has-error' : '' }}">
            <div class="col-md-10 col-md-offset-1">
                <input id="password" type="password" class="form-control" name="password" required placeholder="Password">

                @if ($errors->has('password') and $registerActive)
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-10 col-md-offset-1">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
            </div>
        </div>

        <div class="form-group">
            <div style="text-align: center">
                <button type="submit" class="btn btn-primary btn-lg" style="width: 200px;">
                    Register
                </button>
            </div>
        </div>

        <hr />

        <div class="row social-links">
          <p style="text-align:center">Or Register With:</p>
          @include('../partials._social-links')
        </div>

    </form>
@endif
