<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Spreadsheet;
use App\Sales;
use Auth;
use Billable;
use Stripe;
use Illuminate\Support\Facades\Redirect;
use DB;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    

    public function payment(Request $request){
         
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            $token  = $_POST['stripeToken'];

            auth()->user()->newSubscription('main', env('STRIPE_PLAN_CODE'))->create($token);

            DB::table('subscriptions')->where('user_id', '=', Auth::id())->update([
                'payment_method'=>'Stripe'
             ]);

            return redirect('/subscription')->with(['subscribed'=>'subbed']);

    }

    public function payment_page(Request $req){

        if (!Auth::user()->subscribed('main')) {

            return view('payment.payment');

        }else{

            return redirect('/subscription');

        }

    }

    public function cancel_subscription(Request $request){

        $id = auth()->user()->id;
        $subscription = DB::table('subscriptions')->where('user_id', '=', $id)->orderBy('created_at', 'desc')->limit(1);

        switch ($subscription->value('payment_method')) {
            case 'Stripe':

                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
                auth()->user()->subscription('main')->cancel();
                return Redirect::back();
                
                break;
            case 'Paypal':
                
                $client = new Client();

                $response = $client->request(
                    'POST', /*instead of POST, you can use GET, PUT, DELETE, etc*/
                    'https://api-m.sandbox.paypal.com/v1/oauth2/token?grant_type=client_credentials',
                    ['auth' => [env('PAYPAL_CLIENT_ID'),env('PAYPAL_SECRET')]] 
                );

                $bearer_token = json_decode($response->getBody())->access_token;

                $response = $client->request(
                    'GET', /*instead of POST, you can use GET, PUT, DELETE, etc*/
                    'https://api-m.sandbox.paypal.com/v1/billing/subscriptions/'.$subscription->value('paypal_id'),
                    ['headers' => 
                        [
                            'Authorization' => "Bearer {$bearer_token}"
                        ]
                    ]
                );

                $subscription_details = json_decode($response->getBody());

                $subscription->update([
                    'ends_at'=>$subscription_details->billing_info->next_billing_time
                ]);

                $response = $client->request(
                    'POST', /*instead of POST, you can use GET, PUT, DELETE, etc*/
                    'https://api-m.sandbox.paypal.com/v1/billing/subscriptions/'.$subscription_details->id.'/suspend',
                    ['headers' => 
                        [
                            'Content-Type'=>"application/json",
                            'Authorization' => "Bearer {$bearer_token}"
                        ]
                    ]
                );

                return Redirect::back();

                break;
            default:
                return view('account.subscription')->with([
                    'page'=>$page,
                    'user'=>auth()->user(),
                ]);
                break;
        }

    }

    public function resume_subscription(Request $request){

        $id = auth()->user()->id;
        $subscription = DB::table('subscriptions')->where('user_id', '=', $id)->orderBy('created_at', 'desc')->limit(1);

        switch ($subscription->value('payment_method')) {
            case 'Stripe':

                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                auth()->user()->subscription('main')->resume();
                return Redirect::back();
                
                break;
            case 'Paypal':
                
                $client = new Client();

                $response = $client->request(
                    'POST', /*instead of POST, you can use GET, PUT, DELETE, etc*/
                    'https://api-m.sandbox.paypal.com/v1/oauth2/token?grant_type=client_credentials',
                    ['auth' => [env('PAYPAL_CLIENT_ID'),env('PAYPAL_SECRET')]] 
                );

                $bearer_token = json_decode($response->getBody())->access_token;

                $response = $client->request(
                    'GET', /*instead of POST, you can use GET, PUT, DELETE, etc*/
                    'https://api-m.sandbox.paypal.com/v1/billing/subscriptions/'.$subscription->value('paypal_id'),
                    ['headers' => 
                        [
                            'Authorization' => "Bearer {$bearer_token}"
                        ]
                    ]
                );

                $subscription_details = json_decode($response->getBody());

                $response = $client->request(
                    'POST', /*instead of POST, you can use GET, PUT, DELETE, etc*/
                    'https://api-m.sandbox.paypal.com/v1/billing/subscriptions/'.$subscription_details->id.'/activate',
                    ['headers' => 
                        [
                            'Content-Type'=>"application/json",
                            'Authorization' => "Bearer {$bearer_token}"
                        ]
                    ]
                );

                $subscription->update([
                    'ends_at'=>null
                 ]);

                return Redirect::back();

                break;
            default:
                return view('account.subscription')->with([
                    'page'=>$page,
                    'user'=>auth()->user(),
                ]);
                break;
        }

    }

    public function paymentchange(Request $request){

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $token  = $_POST['stripeToken'];
        auth()->user()->updateCard($token);
        return redirect('/subscription');
    }
}

