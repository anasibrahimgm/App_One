@if (session('confirmation-success'))
    <div class="alert alert-success">
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

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <div class="col-md-10 col-md-offset-1">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="E-Mail Address">

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <div class="col-md-10 col-md-offset-1">
                <input id="password" type="password" class="form-control" name="password" required placeholder="Password">

                @if ($errors->has('password'))
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
