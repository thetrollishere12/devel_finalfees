<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Auth\Events\Verified;
use App\Apikey;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request){

        $userId = $request->route('id');
        $user = User::findOrFail($userId);

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            $client_id = 'CI_' . str_random(6) . now()->timestamp . uniqid() . $userId . str_random(4);
            $secret_key = 'SK_' . str_random(6) . now()->timestamp . uniqid() . $userId . str_random(4);

            if (Apikey::where('user_id',$userId)->exists()) {
                Apikey::where('user_id',$userId)->delete();
            }

            $api = new Apikey;
            $api->user_id = $userId;
            $api->client_id = $client_id;
            $api->secret_key = $secret_key;
            $api->save();
            User::where('id',$userId)->update(['api_client_id'=>$client_id]);
            setcookie('user_client_id', $client_id, time() + (86400 * 30), "/");

        }

        return redirect($this->redirectPath())->with('verified', true);
    }


}
