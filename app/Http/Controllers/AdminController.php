<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Mail;
use Auth;
use App\User;
use App\Apikey;
use App\referalmails;
use App\extensionsale;
use App\Mail\MassEmail;
use App\Mail\ReferalMail;

class AdminController extends Controller
{
    public function massemail(Request $request){
    	set_time_limit(0);
    		$list = DB::table('users')->whereNotNull("email_verified_at")->skip(950)->take(150)->pluck("email");
 		
    	foreach ($list as $key) {
    		  Mail::to($key)->send(new massemail());
    	}

    }

    public function mail_referal(Request $request){

    	$saved = new referalmails;
        $saved->user_email = $request->your_email;
        $saved->ref_email = $request->referal_email;
        $saved->save();
    	Mail::to($request->referal_email)->send(new referalmail($request->name));
    	return redirect()->back()->with('success', ['Thank you for refering! Winners will be announced soon.']);
    }

    public function get_api(Request $request){
        $credentials = $request->only('api_client_id');

        if (User::where('api_client_id',$request->api_client_id)->exists()) {
            $secret = Apikey::where('client_id',$request->api_client_id)->value('secret_key');
            return array("secret_key" => $secret);
        }else{
            return abort(404);
        }

    }


    public function submit_data(Request $request){
        $credentials = $request->only('secret_key');

        if (Apikey::where('secret_key',$request->secret_key)->exists()) {
            $user_id = Apikey::where('secret_key',$request->secret_key)->value('user_id');
            foreach ($request['data']['transactions'] as $transaction) {
                $sale = new extensionsale;
                $sale->user_id = $user_id;
                $sale->sale_date = $transaction['date'];
                $sale->order_id = $transaction['order_id'];
                $sale->platform = $transaction['type'];
                $sale->currency = $transaction['currency'];
                $sale->name = $transaction['title'];
                $sale->img = $transaction['img'];
                $sale->quantity = $transaction['quantity'];
                $sale->sold_price = $transaction['price'];
                $sale->shipping = $transaction['shipping'];
                $sale->fees = $transaction['fee'];
                $sale->tax = $transaction['tax'];
                $sale->total = $transaction['total'];
                $sale->save();

            }
            
            return "success";
            
        }else{
            return abort(404);
        }

    }



}
