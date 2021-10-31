<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gentor\Etsy\Facades\Etsy;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use App\EtsyAccount;

class EtsyEmailController extends Controller{


	const CONSUMER_KEY = '4qa9aor3z104sk3b0bmsdcix';

	const CONSUMER_SECRET = 'wcvszz12a5';

	const CALLBACK_URI = '/etsy/account/store';

	const SCOPE = 'transactions_r%20shops_rw%20profile_r%20billing_r';


    public function index(){

    	set_time_limit(0);
    	$email_parent = auth()->user()->email;
    	$etsy = EtsyAccount::where('parent_email',$email_parent)->where('secret_key', '!=', null)->where('identifier', '!=', null)->first();


    	$stack = HandlerStack::create();
		$middleware = new Oauth1(
		[
			'token' => $etsy->identifier,
			'token_secret' => $etsy->secret_key,
			'consumer_key' => EtsyController::CONSUMER_KEY,
			'consumer_secret' => EtsyController::CONSUMER_SECRET
		]);
		$stack->push($middleware);
		$client = new Client([
				'base_uri' => "https://openapi.etsy.com/v2/",
				'handler' => $stack
		]);

		$url = 'shops/20464863/receipts?limit=100';

		$res = $client->get($url, [
				'auth' => 'oauth'
		]);

		$response = json_decode($res->getBody()->getContents());

		$transactions = $response->results;

		$page = ceil($response->count / 100);

		$result = $transactions;

		for($i = 2; $i <= $page; $i ++) {
			$url = 'shops/20464863/receipts?limit=100&page='.$i;
			$res = $client->get($url, [
					'auth' => 'oauth'
			]);
			$response = json_decode($res->getBody()->getContents());
			$transactions = $response->results;
			$result = array_merge($result, $transactions);
		}

    	return view('etsyemail.etsy_email',['emails'=>$result]);

    }
}
