<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Socialite;
use Auth;
use App\Apikey;
use Exception;
use Carbon\Carbon;
use Session;


class GoogleAuth extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $existUser = User::where('email', $googleUser->email)->first();

            if ($existUser) {
                Auth::loginUsingId($existUser->id);
            } else {
                $user = new User;
                $user->name = $googleUser->name;
                $user->email = $googleUser->email;
                $user->google_id = $googleUser->id;
                $user->email_verified_at = Carbon::now()->toDateTimeString();
                $user->password = bcrypt(request('password'));
                $user->save();
                Auth::loginUsingId($user->id);
            }

            $client_id = 'CI_' . str_random(6) . now()->timestamp . uniqid() . Auth::id() . str_random(4);
            $secret_key = 'SK_' . str_random(6) . now()->timestamp . uniqid() . Auth::id() . str_random(4);

            if (Apikey::where('user_id',Auth::id())->exists()) {
                Apikey::where('user_id',Auth::id())->delete();
            }

            $api = new Apikey;
            $api->user_id = Auth::id();
            $api->client_id = $client_id;
            $api->secret_key = $secret_key;
            $api->save();
            User::where('id',Auth::id())->update(['api_client_id'=>$client_id]);
            session()->put('user_client_id',$client_id);
            
            return redirect()->to('/home');
        } catch (Exception $e) {
            return redirect('/register');
        }
    }
}