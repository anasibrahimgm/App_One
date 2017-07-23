@extends('layouts.app')

@section('content')
<h1 style="text-align:center;">Admin SignIn</h1>
<form class="form-horizontal login" role="form" method="POST" action="{{ route('admin.login') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <div class="col-md-8 col-md-offset-2">
            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <div class="col-md-8 col-md-offset-2">
            <input id="password" type="password" class="form-control" name="password" required placeholder="Password">

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-8 col-md-offset-2">
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
            <a class="btn btn-link" href="{{ route('admin.password.request') }}">
                Forgot Your Password?
            </a>
        </div>
    </div>
</form>
@endsection
