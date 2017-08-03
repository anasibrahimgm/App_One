@extends('layouts.app')

@section('title', "|Edit Profile")

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-9">
      {{-- start form --}}

      {!! Form::model(Auth::user(), ['class' => 'form-horizontal', 'route' => 'updateProfile', 'method' => 'put', 'files' => true]) !!}
        <div class="user-basicInfo">
          <div class="basicInfo-left">
            <div class="basicInfo-left-edit">
              <img src="{{asset('images/users/avatars/')}}/{{ Auth::user()->avatar }}" class="img img-edit" id="profile-img-edit" hidden/>
            </div>

            <br />
            {{ Form::label('avatar', 'Change Profile Picture') }}
            {{ Form::file('avatar', ['class' => 'form-control-file', 'id' => 'avatar']) }}
            @if ($errors->has('avatar'))
            <span class="help-block danger">
              <strong>{{ $errors->first('avatar') }}</strong>
            </span>
            @endif
          </div>

          <div class="basicInfo-right">
            <div class="info">
              {{ Form::text('name', old('name') ? old('name') : ucwords(Auth::user()->name),  ['class' => 'form-control userName userNameEdit', 'id' => 'editName', 'required' => true, 'placeholder' => 'Name']) }}
              {{ Form::textarea('bio', old('bio') ? old('bio') : Auth::user()->bio , ['class' => 'form-control userBio userBioEdit', 'rows' => '5', 'cols' => '40',  'placeholder' => 'Bio']) }}
            </div>
          </div>
        </div>
                              <div class="horizontalTab"></div>
      <div class="edit_fields">
        <div class="edit_fields-left">
          <p>Username:</p>
        </div>

        <div class="edit_fields-right">
          <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <div class="col-md-10">
              {{ Form::text('username', old('username') ? old('username') : Auth::user()->username, ['class' => 'form-control', 'placeholder' => 'Username', 'autofocus' => true, 'id' => 'username', 'required' => true]) }}
              @if ($errors->has('username'))
              <span class="help-block">
                <strong>{{ $errors->first('username') }}</strong>
              </span>
              @endif
            </div>
          </div>
        </div>
      </div>

      <div class="edit_fields">
        <div class="edit_fields-left">
          <p>Email:</p>
        </div>
        <div class="edit_fields-right">
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <div class="col-md-10">
              {{ Form::email('email', old('email') ? old('email') : Auth::user()->email, ['class' => 'form-control', 'placeholder' => 'E-Mail Address', 'id' => 'email', 'required' => true]) }}
              @if ($errors->has('email') )
              <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
              @endif
            </div>
          </div>
        </div>
      </div>

      <div class="edit_fields">
        <div class="edit_fields-left">
          <p>Password:</p>
        </div>
        <div class="edit_fields-right">
          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <div class="col-md-10">
              {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Change Password', 'id' => 'password']) }}
              @if ($errors->has('password'))
              <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
              </span>
              @endif
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-10">
              {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password Change', 'id' => 'password-confirm']) }}
            </div>
          </div>
        </div>
      </div>

        <div class="form-group">
            <div style="text-align: center">
              {{ Form::submit('Save Changes', ['class' => 'btn btn-primary btn-lg']) }}
            </div>
        </div>

      {!! Form::close() !!}
      {{-- END --}}

    </div>

    <div class="col-md-3">
      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </div>
  </div>
</div>
@endsection
