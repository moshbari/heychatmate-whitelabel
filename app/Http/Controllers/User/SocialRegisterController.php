<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Socialsetting;
use App\Models\SocialProvider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;


class SocialRegisterController extends Controller
{

    public function __construct()
    {

      Config::set('services.google.client_id',get_settings('google_client_id'));
      Config::set('services.google.client_secret', get_settings('google_client_secret'));
      Config::set('services.google.redirect', url('/auth/google/callback'));
      // Config::set('services.facebook.client_id', $link->fclient_id);
      // Config::set('services.facebook.client_secret', $link->fclient_secret);
      // $url = url('/auth/facebook/callback');
      // $url = preg_replace("/^http:/i", "https:", $url);
      // Config::set('services.facebook.redirect', $url);
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try
        {
            $socialUser = Socialite::driver($provider)->user();
        }
        catch(\Exception $e)
        {
            return redirect('/');
        }
        //check if we have logged provider
        $socialProvider = SocialProvider::where('provider_id',$socialUser->getId())->first();
        if(!$socialProvider)
        {

            //create a new user and provider
            $user = new User;
            $user->email = $socialUser->email;
            $user->name = $socialUser->name;
            $user->photo = $socialUser->avatar_original;
            $user->email_verified = 'Yes';
            $user->is_provider = 1;
            $user->affilate_code = $socialUser->name.$socialUser->email;
            $user->affilate_code = md5($user->affilate_code);
            $user->save();

            $user->socialProviders()->create(
                ['provider_id' => $socialUser->getId(), 'provider' => $provider]
            );

        }
        else
        {

            $user = $socialProvider->user;
        }

        Auth::guard('web')->login($user);
        return redirect()->route('user-dashboard');

    }
}
