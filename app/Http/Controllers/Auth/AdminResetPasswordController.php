<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\ResetsPasswords;
use Bestmomo\LaravelEmailConfirmation\Traits\ResetsPasswords;
use Illuminate\Http\Request;//new
use Password;//new
use Auth;//new

class AdminResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    protected function guard()
    {
      return Auth::guard('admin');
    }

    protected function broker()
    {
      return Password::broker('admins');
    }

    public function showResetForm(Request $request, $token = null)
    // copied from vendor/laravel/framework/src/Illuminate/Foundation/Auth/ResetsPasswords.php
    {
        return view('auth.passwords.admin-reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
