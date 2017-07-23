<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:admin', ['except' => ['logout']]);
      //not use this middleware on the logout fn, because with it we have to be logged out to log out!!
    }

    public function showLogin()
    {
      return view('auth.admin');
    }

    public function login(AdminLoginRequest $request)
    {
      if(Auth::guard('admin')->attempt(['email' => $request->email,'password' => $request->password,], $request->remember)) {
        return redirect()->intended(route('admin.dashboard'));
      }

      //can't login admin
      return redirect()->back()->withInput($request->only('email', 'remember'));
    }


    // if we wanted to logOut only admins
    public function logout()// Copied from /vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php
    {
      Auth::guard('admin')->logout();
      //$request->session()->flush();
      // flushing all the sessions gonna log out of all users 'admin and user here'

      //$request->session()->regenerate();
      return redirect('/');
    }

}
