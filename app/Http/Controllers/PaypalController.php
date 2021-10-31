<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DB;
use Auth;
use Carbon\Carbon;

class PaypalController extends Controller
{

	public function paypal_sub_approved(Request $req){
		
		$client = new Client();

    	$response = $client->request(
		    'POST', /*instead of POST, you can use GET, PUT, DELETE, etc*/
		    'https://api-m.sandbox.paypal.com/v1/oauth2/token?grant_type=client_credentials',
		    ['auth' => [env('PAYPAL_CLIENT_ID'),env('PAYPAL_SECRET')]] 
		);

		$bearer_token = json_decode($response->getBody())->access_token;

		$response = $client->request(
		    'GET', /*instead of POST, you can use GET, PUT, DELETE, etc*/
		    'https://api-m.sandbox.paypal.com/v1/billing/subscriptions/'.$req->sub_id,
		    ['headers' => 
		        [
		            'Authorization' => "Bearer {$bearer_token}"
		        ]
		    ]
		);


		$data = json_decode($response->getBody());

		if ($data->status === 'ACTIVE' && $req->sub_id === $data->id) {

			 DB::table('users')->where('id', '=', Auth::id())->update([
			 	'paypal_id'=>$data->id,
			 	'paypal_email'=>$data->subscriber->email_address
			 ]);

			 DB::table('subscriptions')->insert([
			 	'user_id'=>Auth::id(),
			 	'name'=>'main',
			 	'payment_method'=>'Paypal',
			 	'paypal_id'=>$data->id,
			 	'stripe_plan'=>$data->plan_id,
			 	'quantity'=>$data->quantity,
			 	'trial_ends_at'=>null,
			 	'ends_at'=>null,
			 	'created_at'=> Carbon::now(),
			 	'updated_at'=> Carbon::now(),
			 ]);

		}else{
			return 321;
		}


	}

    public function token(){

		$response = $client->request(
		    'GET', /*instead of POST, you can use GET, PUT, DELETE, etc*/
		    'https://api-m.sandbox.paypal.com/v1/billing/subscriptions/I-2NVHAEH9ESE8',
		    ['headers' => 
		        [
		            'Authorization' => "Bearer {$bearer_token}"
		        ]
		    ]
		);
		dd(json_decode($response->getBody()));
		return json_decode($response->getBody())->status;

    }
}
