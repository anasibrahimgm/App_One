<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Image;
use Storage;

class ProfilesController extends Controller
{
    public function show($id)//show profile
    {
        $user = User::find($id);
        return view('profiles.show')->withUser($user);
    }

    public function edit()//edit Profile//only profile owner
    {
        if (Auth::check()) {
          return view('profiles.edit');
        }
        session()->put('intendedRoute', 'editProfile');
        return redirect()->route('login');//if not a logged-in user
    }

    public function update(Request $request)
    {
      $user = User::find(Auth::id());

      $userLogout = false;

      $this->validate($request, [
          'name' => 'required|string|max:255',
          'username' => 'required|string|alpha_dash|max:255',
          'email' => 'required|string|email|max:255',
          'avatar' => 'sometimes|image',
      ]);

      if ($request->hasFile('avatar')) {
        $image = $request->file('avatar');
        $fileName = time(). '.' . $image->getClientOriginalExtension();// we can use  $image->encode('png');
        $location = public_path('images/users/avatars/' . $fileName);// storage path
        Image::make($image)->resize(200, 200)->save($location);

        if ($user->avatar != "avatar.png") {//delete the old image if existed
          Storage::delete('images/users/avatars/' . $user->avatar);
        }

        $user->avatar = $fileName;
      }

      if ($user->username != $request->username) {
          $this->validate($request,['username' => 'unique:users_one']);
        }

      if ($user->email !== $request->email) {
        $this->validate($request,['email' => 'unique:users_one']);
        $user->confirmed = false;
        $user->confirmation_code = str_random(30);
        $userLogout = true;
      }

      if ($request->password) {
          $this->validate($request,['password' => 'string|min:6|confirmed']);
          $user->password = bcrypt($request->password);
        }

      $user->name = $request->name;
      $user->email = $request->email;
      $user->username = $request->username;

      if ($request->bio)
        $user->bio = $request->bio;

      $user->save();

      if ($userLogout) {
        Auth::logout();
        $request->session()->put('user_id', $user->id);//@ vendor/bestmomo/laravel-email-confirmation/src/Traits/AuthenticatesUsers.php, function:login,  line:51
        $request->session()->put('email-change-success', 'Email successfully changed, please check your email to confirm');
        return redirect()->route('confirmation.resend');
      } else {
        return redirect()->route('users.show', Auth::user());
      }
    }

    public function destroy()//delete profile
    {
        //
    }
}
