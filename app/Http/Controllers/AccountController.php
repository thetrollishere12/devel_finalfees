<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\Message;
use ReCaptcha\ReCaptcha;
use Redirect;
use Session;
use Mail;
use Carbon\Carbon;
use GuzzleHttp\Client;

class AccountController extends Controller
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

    public function index(){
        $sales = DB::table('sales')->where('user_id', '=', Auth::id());

        $sum = array(
            "sold"=>$sales->sum('sold_price')+$sales->sum('shipping_charge'),
            "cost"=>$sales->sum('item_cost')+$sales->sum('shipping_cost'),
            "fees"=>$sales->sum('fees')+$sales->sum('other_fees')+$sales->sum('processing_fees')+$sales->sum('tax'),
            "profit"=>$sales->sum('profit')

        );
        return view('account.home')->with(['page'=>'login','sum'=>$sum]);
    }

    public function settings(){
         $subscription = DB::table('subscriptions')->where('user_id', '=',auth()->user()->id)->orderBy('created_at', 'desc')->limit(1)->get()[0];
        return view('account.settings')->with(['page'=>'settings','subscription'=>$subscription]);
    }

    public function subscription(){

        $page = "subscription";

        if (Auth::user()->subscribed('main')) {
        
            $id = auth()->user()->id;
            $subscription = DB::table('subscriptions')->where('user_id', '=', $id)->orderBy('created_at', 'desc')->limit(1);

            switch ($subscription->value('payment_method')) {
                case 'Stripe':

                    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

                    $id = $subscription->value('stripe_id');

                    $account = \Stripe\Subscription::retrieve($id);
                    
                    return view('account.subscription')->with([
                        'page'=>$page,
                        'subscription'=>$subscription->get()[0],
                        'user'=>auth()->user(),
                        'period_end'=>$account->current_period_end,
                        'period_valid'=>$account->current_period_start,
                        'amount'=>$account->plan->amount,
                        'active'=>$account->plan->active,
                        'cancel'=>$account->cancel_at_period_end
                    ]);

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

                    // $response = $client->request(
                    //     'GET', /*instead of POST, you can use GET, PUT, DELETE, etc*/
                    //     'https://api-m.sandbox.paypal.com/v1/billing/plans/'.$subscription_details->plan_id,
                    //     ['headers' => 
                    //         [
                    //             'Authorization' => "Bearer {$bearer_token}"
                    //         ]
                    //     ]
                    // );

                    // $plan_details = json_decode($response->getBody());


                    // $response = $client->request(
                    //     'POST', /*instead of POST, you can use GET, PUT, DELETE, etc*/
                    //     'https://api-m.sandbox.paypal.com/v1/billing/subscriptions/I-D4YU2NA45DL1/activate',
                    //     ['headers' => 
                    //         [
                    //             'Content-Type'=>"application/json",
                    //             'Authorization' => "Bearer {$bearer_token}"
                    //         ]
                    //     ]
                    // );

                    return view('account.subscription')->with([
                        'page'=>$page,
                        'subscription'=>$subscription->get()[0],
                        'user'=>auth()->user(),
                        'details'=>$subscription_details,
                        'period_end'=>Carbon::parse($subscription_details->billing_info->last_payment->time)->addDays(30),
                        'period_valid'=>$subscription_details->billing_info->last_payment->time,
                        'amount'=>str_replace('.','',$subscription_details->billing_info->last_payment->amount->value),
                        'active'=>$subscription_details->status,
                        'cancel'=>$subscription_details->status
                    ]);

                    break;
                default:
                    return view('account.subscription')->with([
                        'page'=>$page,
                        'user'=>auth()->user(),
                    ]);
                    break;
            }

        }else{

            return view('account.subscription')->with([
                'page'=>$page,
                'user'=>auth()->user(),
            ]);

        }
    }

    public function editpayment(){
        $page = 'editpayment';

        $id = auth()->user()->id;
        $sub = DB::table('users')->where('id', '=', $id)->value('stripe_id');

        if (!empty($sub)) {
            return view('account.editpayment')->with(['page'=>$page]);
        }else{
            return redirect('/subscription');
        }
    }

    /**
    * Sending Email.
    * @param  int $request->user_id
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function change_tax(Request $request){
        if ($request->ajax()) {

            $validator = \Validator::make($request->all(), [
                'user_id' => 'required',
                'tax'=>'required'
            ]);

            if (!$validator->fails()) {
                if ($request->user_id == Auth::id()) {
                 
                    $save = new User;
                    $save = User::find(Auth::id());
                    $save->tax = $request->tax;
                    $save->save();
                    if ($save) {
                        return "success";
                    }else{
                        return "error";
                    }
                }
            }
        }
    }


    public function suggestion(Request $request){

        $recaptcha = new ReCaptcha(env('GOOGLE_RECAPTCHA_SECRET_KEY'));
        $response = $recaptcha->verify($request->get('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);

        if ($response->isSuccess()) {
        
            if (!empty($request->textarea)) {
                Mail::to("brandonsanghuynh123@gmail.com")->send(new message($request));
                Session::flash('message','Email Sent');
                return redirect('/subscription');
            }else{
                return redirect('/subscription');
            }

        }else{
            return Redirect::back()->withErrors(['Please Complete', 'The Message']);
        }

    }


}
