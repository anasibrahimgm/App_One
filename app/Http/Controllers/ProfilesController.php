<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Image;
use Storage;
use App\Post;
use App\Http\Requests\ProfileUpdateRequest;

class ProfilesController extends Controller
{
    public function __construct ()
    {
      $this->middleware('auth')->except('show');
    }

    public function show($username)//show profile
    {
        $user = User::where('username', $username)->first();
        //$posts = Post::where('user_id', $user->id)->get();
        return view('profiles.show')->withUser($user);//->withPosts($posts);
    }

    public function edit()//edit Profile//only profile owner
    {
        return view('profiles.edit');
    }

    public function change(Request $request)
    {
      $user = User::find(Auth::id());
      $user->name = $request->name;
      //$user->bio = $request->bio;

      $user->save();

      return response()->json(['user' => $user], 200);
    }

    public function update(ProfileUpdateRequest $request)
    {
      $user = User::find(Auth::id());

      $userLogout = false;

      // User Avatar

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

      // Email Change

      if ($user->email !== $request->email) {
        $user->confirmed = false;
        $user->confirmation_code = str_random(30);
        $userLogout = true;
      }

      // Password Change

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

      // Log out the user if email changed

      if ($userLogout) {
        Auth::logout();
        $request->session()->put('user_id', $user->id);//@ vendor/bestmomo/laravel-email-confirmation/src/Traits/AuthenticatesUsers.php, function:login,  line:51
        $request->session()->put('email-change-success', 'Email successfully changed, please check your email to confirm');//we should use flash() instead of put() here bc it will only be available during the subsequent HTTP request, and then will be deleted
        return redirect()->route('confirmation.resend');
      } else {
        return redirect()->route('users.show', $user->username);
      }
    }

    public function destroy()//delete profile
    {
        //
    }
}
