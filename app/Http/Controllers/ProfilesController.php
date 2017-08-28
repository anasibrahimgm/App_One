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

    public function currentUser()
    {
      $user = User::with('categories', 'posts.category', 'posts.comments', 'comments')
              ->find(Auth::id());
      return response()->json(['currentUser' => $user]);
    }

    public function show($username)//show profile
    {
        $user = User::where('username', $username)
                ->with('categories', 'posts.category', 'posts.user', 'posts.comments', 'posts.comments.user', 'comments')
                ->first();
        return view('profiles.show')->withUser($user);
    }

    public function edit()//edit Profile//only profile owner
    {
        return view('profiles.edit');
    }

    public function update(Request $request)
    {
      $user = User::find(Auth::id());

      $userLogout = false;

      if ($request->has('name'))
          $user->name = $request->name;

      if ($request->has('bio'))
          $user->bio = $request->bio;


      if ($request->has('avatar')) {
        if($user->avatar != $request->avatar) {
          $exploded = explode(",", $request->avatar);

          $decoded = base64_decode($exploded[1]);

          if(str_contains($exploded[0], 'jpeg'))
            $extension = 'jpg';
          else
            $extension = 'png';

          $fileName = time(). '.' . $extension;
          $location = public_path('images/users/avatars/' . $fileName);// storage path

          Image::make($decoded)->save($location);

          if ($user->avatar != 'avatar.png' && $user->avatar != 'app_one.png')
            Storage::delete('images/users/avatars/' . $user->avatar);

          $user->avatar = $fileName;
        }
      }

      if ($request->has('username'))
          $user->username = $request->username;

      if ($request->has('email')) {
        if ($user->email !== $request->email) {
          $user->confirmed = false;
          $user->confirmation_code = str_random(30);
          $userLogout = true;

          $user->email = $request->email;
        }
      }

      if ($request->has('password')) {
        if ($request->password != '')
          $user->password = bcrypt($request->password);
      }

      $user->save();

      if ($userLogout) {
        Auth::logout();
        $request->session()->put('user_id', $user->id);//@ vendor/bestmomo/laravel-email-confirmation/src/Traits/AuthenticatesUsers.php, function:login,  line:51
        $request->session()->put('email-change-success', 'Email successfully changed, please check your email to confirm');//we should use flash() instead of put() here bc it will only be available during the subsequent HTTP request, and then will be deleted
        return response()->json(['user' => $user, 'redirect' => route('confirmation.resend')], 200);
      } else {
        return response()->json(['user' => $user], 200);
      }


    }

    public function destroy()//delete profile
    {
        //
    }
}
