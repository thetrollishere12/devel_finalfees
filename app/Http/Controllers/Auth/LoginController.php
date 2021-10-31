<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\User;
USE App\Apikey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(){
        Auth::logout();
        unset($_COOKIE['user_client_id']);
        setcookie('user_client_id', '', time() - 3600, '/');
        return redirect('/');
    }

    protected function authenticated(){
                
        if (Auth::user()->hasVerifiedEmail()) {
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
            setcookie('user_client_id', $client_id, time() + (86400 * 30), "/");
        
        }else{
            return redirect('email/verify');
        }

    }

}