<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\User;
use App\Provider;

class AuthProvidersController extends Controller
{
    //

    //-----------every thing in this calss is copied from socialite repo-------//
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub for ex..
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $selectProvider = Provider::where('provider_id', $user->getId())->first();

        if(!$selectProvider)//new user
        {
          $registeredUser = User::where('email', $user->getEmail())->first();//the user is already registered with the same email

          if(!$registeredUser) {//totally new user
            $registeredUser = new User();
            $registeredUser->name = $user->getName();
            $registeredUser->email = $user->getEmail();
            $registeredUser->save();
          }

          $newProvider = new Provider();
          $newProvider->provider_id = $user->getId();
          $newProvider->provider_name = $provider;
          $newProvider->user_id = $registeredUser->id;
          $newProvider->save();
        }
        else //registered user
        {
          $registeredUser = User::find($selectProvider->user_id);
        }

        auth()->login($registeredUser);
        return Redirect('/');

    }
}
