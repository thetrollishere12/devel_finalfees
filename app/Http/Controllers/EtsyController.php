<?php

namespace App\Http\Controllers;

use Gentor\Etsy\Facades\Etsy;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\EtsyAccount;
use Carbon\Carbon;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Expense;
use Illuminate\Support\Facades\Auth;
use App\Spreadsheet;
use App\Sales;

class EtsyController extends Controller {

	const CONSUMER_KEY = '4qa9aor3z104sk3b0bmsdcix';

	const CONSUMER_SECRET = 'wcvszz12a5';

	const CALLBACK_URI = '/etsy/account/store';

	const SCOPE = 'transactions_r%20shops_rw%20profile_r%20billing_r';

	public function connect() {

		$authorizationUrl = Etsy::authorize(url(EtsyController::CALLBACK_URI));
		redirect()->to($authorizationUrl)->send();

	}

	public function index() {

		$email_parent = auth()->user()->email;
		$etsy_account = EtsyAccount::where('parent_email', '=', "$email_parent")->where('secret_key', '!=', null)->where('identifier', '!=',
				null)->get();
		$type = 'etsy';
		return view('auto.etsy', compact('etsy_account', 'type'))->with([
				'page' => 'etsy_account'
		]);

	}

	private function getEtsyEmail($etsy) {

		// $stack = HandlerStack::create();
		// $middleware = new Oauth1(
		// [
		// 'token' => $etsy->identifier,
		// 'token_secret' => $etsy->secret_key,
		// 'consumer_key' => EtsyController::CONSUMER_KEY,
		// 'consumer_secret' => EtsyController::CONSUMER_SECRET
		// ]);
		// $stack->push($middleware);
		// $client = new Client([
		// 'base_uri' => "https://openapi.etsy.com/v2/",
		// 'handler' => $stack
		// ]);
		// $res = $client->get('users/' . $etsy->etsy_user_id, [
		// 'auth' => 'oauth'
		// ]);
		// $response = json_decode($res->getBody()->getContents());
		// return $response->primary_email;
		Etsy::setTokenCredentials($etsy->identifier, $etsy->secret_key);
		$etsyUserRemote = json_decode(json_encode(Etsy::getUser([
				'params' => [
						'user_id' => '__SELF__'
				]
		])));

		$etsy->etsy_user_id = $etsyUserRemote->results[0]->user_id;
		$etsy->save();

	}

	public function account() {

		$email_parent = auth()->user()->email;
		$etsy_account = EtsyAccount::where('parent_email', '=', "$email_parent")->where('secret_key', '!=', null)->where('identifier', '!=',
				null)->get();

		return view('auto.widget.etsy_account', compact('etsy_account'))->render();

	}

	/*
	 * public function store() {
	 * $server = new Etsy([
	 * 'identifier' => '4qa9aor3z104sk3b0bmsdcix',
	 * 'secret' => 'wcvszz12a5'
	 * ]);
	 * if (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])) {
	 * try {
	 * // Retrieve the temporary credentials we saved before
	 * $etsy = $this->getEtsyAccount(auth()->user()->email);
	 * $temporaryCredentials = unserialize($etsy->temp_token);
	 * // We will now retrieve token credentials from the server
	 * $tokenCredentials = $server->getTokenCredentials($temporaryCredentials, $_GET['oauth_token'], $_GET['oauth_verifier']);
	 * $etsy->identifier = $tokenCredentials->getIdentifier();
	 * $etsy->secret_key = $tokenCredentials->getSecret();
	 * $this->getEtsyUserId($etsy);
	 * $shopid = $this->getEtsyShops();
	 * $etsy->etsy_shop_id = implode('|', $shopid);
	 * $etsy->email = $this->getEtsyEmail($etsy);
	 * $etsy->save();
	 * } catch ( Exception $e ) {
	 * Log::error($e->getMessage());
	 * }
	 * }
	 * return redirect('auto/etsy');
	 * }
	 */
	public function store(Request $request) {

		$tokenCredentials = Etsy::approve($request->get('oauth_token'), $request->get('oauth_verifier'));

        
        Etsy::setTokenCredentials($tokenCredentials->getIdentifier(), $tokenCredentials->getSecret());

		$etsyUserRemote = json_decode(json_encode(Etsy::getUser([
				'params' => [
						'user_id' => '__SELF__'
				]
		])));

        $exist = EtsyAccount::where('parent_email',auth()->user()->email)->where('etsy_email',$etsyUserRemote->results[0]->primary_email)->get();

        try {

        if(count($exist) > 0){
            return redirect('auto/etsy')->with('error', 'Error, Account is already Linked');
        }else{
            
    		$remoteUserShops = json_decode(json_encode(Etsy::findAllUserShops([
    				'params' => [
    						'user_id' => '__SELF__'
    				]
    		])));
    
            $etsy = new EtsyAccount();
            $etsy->etsy_email = $etsyUserRemote->results[0]->primary_email;
    		$etsy->parent_email = auth()->user()->email;
    		$etsy->identifier = $tokenCredentials->getIdentifier();
    		$etsy->secret_key = $tokenCredentials->getSecret();
    		$etsy->etsy_user_id = $etsyUserRemote->results[0]->user_id;
    		$etsy->etsy_shop_id = $remoteUserShops->results[0]->shop_id;
            $etsy->save();
            return redirect('auto/etsy')->with('success', 'Your Account Has Been Linked');
        }
        
        }catch ( Exception $e ) {
			return redirect('auto/etsy')->with('error', 'Error, Please Try Again');
		}
        
	}

	private function getEtsyUserId($etsy) {

		// $stack = HandlerStack::create();
		// $middleware = new Oauth1(
		// [
		// 'token' => $etsy->identifier,
		// 'token_secret' => $etsy->secret_key,
		// 'consumer_key' => EtsyController::CONSUMER_KEY,
		// 'consumer_secret' => EtsyController::CONSUMER_SECRET
		// ]);
		// $stack->push($middleware);
		// $client = new Client([
		// 'base_uri' => "https://openapi.etsy.com/v2/",
		// 'handler' => $stack
		// ]);
		// $res = $client->get('users/__SELF__', [
		// 'auth' => 'oauth'
		// ]);
		// $response = json_decode($res->getBody()->getContents());
		// $etsy->etsy_user_id = $response->results[0]->user_id;
		// $etsy->save();
		Etsy::setTokenCredentials($etsy->identifier, $etsy->secret_key);
		$etsyUserRemote = json_decode(json_encode(Etsy::getUser([
				'params' => [
						'user_id' => '__SELF__'
				]
		])));

		$etsy->etsy_user_id = $etsyUserRemote->results[0]->user_id;
		$etsy->save();

	}

	public function getTransactions(Request $request) {

		set_time_limit(0);
		$type = 'etsy';

        $etsy = EtsyAccount::where('etsy_shop_id', $request->etsy_id)->where('secret_key', '!=', null)->where('identifier', '!=', null)->first();
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
		$shopId = $etsy->etsy_shop_id;
        
		$url = ($request->current_page === 1 || empty($request->current_page)) ? 'shops/' . $etsy->etsy_shop_id . '/receipts?limit=50' : 'shops/' . $etsy->etsy_shop_id . '/receipts?limit=50&page=' . $request->current_page;

		$res = $client->get($url, [
				'auth' => 'oauth'
		]);
		$response = json_decode($res->getBody()->getContents());
		$transactions = collect($response->results);
		$pagination = $response->pagination;

		$transaction1 = [];
		$transaction_sale = [];
		$i = 0;
		$listing = [];
		
		foreach($transactions as $t) {
			$urls = 'receipts/' . $t->receipt_id . '/transactions';
			$res1 = $client->get($urls, [
					'auth' => 'oauth'
			]);
			$response2 = json_decode($res1->getBody()->getContents(), true);

			// $transactions1 = collect($response2->results);
			$listing = [];
			foreach($response2['results'] as $r) {
				$url = "listings/" . $r['listing_id'] . "/images/" . $r['image_listing_id'] . "";
				$fee_url = "shops/" . $etsy->etsy_shop_id . '/receipts/' . $r['receipt_id'] . '/payments';

				try {
					$res2 = $client->get($url, [
							'auth' => 'oauth'
					]);
					$response3 = json_decode($res2->getBody()->getContents(), true);

					$listing[] = [
							"transaction_id" => $r['transaction_id'],
							"title" => $r['title'],
							"price" => $r['price'],
							"currency" => $r['currency_code'],
							"quantity" => $r['quantity'],
							"image" => $response3['results'][0]['url_75x75']
					];
				} catch ( Exception $e ) {
					$listing[] = [
							"transaction_id" => $r['transaction_id'],
							"title" => $r['title'],
							"price" => $r['price'],
							"currency" => $r['currency_code'],
							"quantity" => $r['quantity'],
							"image" => null
					];
				}

				try {

					$res4 = $client->get($fee_url, [
							'auth' => 'oauth'
					]);
					$response4 = json_decode($res4->getBody()->getContents(), true);

					$fee = $response4['results'][0]['amount_fees'];
				} catch ( Exception $e ) {
					$fee = 0;
				}
			}

			$transaction_sale[] = [
					"receipt" => $t,
					"transaction" => $listing,
					"fee" => $fee
			];
		}

		$pagination->total_page = ceil($response->count /50);
		$pagination->total_transactions = $response->count;
		$accounts = DB::table('etsy_account')->where('parent_email', auth()->user()->email)->get();
		$activeShopId = $etsy->etsy_shop_id;

		return view('auto.widget.etsy_sold_table', compact('accounts', 'transaction_sale', 'pagination', 'type', 'activeShopId'))->render();

	}

	public function getBillingCharge(Request $request) {
	    
    		$etsy = EtsyAccount::where('etsy_shop_id', $request->etsy_id)->where('secret_key', '!=', null)->where('identifier', '!=', null)->first();

    		$month = $request->get('month');
    		$years = $request->get('year');
    		
    		$current_page = $request->get('page');
            
    		$transactions = $this->getAdsFee($month,$etsy,$years);
    		$ledger = $this->getLedgerEntry($month,$etsy,$years);

    		$response = collect($transactions)->merge($ledger);
    		$response = collect($response)->sortBy('creation_tsz', SORT_DESC);
    		
    		// $transactions = $transactions->sortBy("creation_tsz",SORT_DESC);
  
    		$pagination = [
    				'total_page' => 1,
    				'total_transactions' => count($transactions)
    		];
    		$type = 'etsy';
    		$pagination = (object)$pagination;
    		return view('auto.widget.etsy_billing_table', compact('transactions', 'pagination', 'month', 'type'))->render();
	        
	   
  

	}


	public function getSoldView() {

		$etsy_account = EtsyAccount::where('parent_email', auth()->user()->email)->orderBy('id', 'ASC')->where('secret_key', '!=', null)->where(
				'identifier', '!=', null)->get();
		
		$type = 'etsy';
		return view('auto.etsy_sold', compact('etsy_account', 'type'))->with([
				'page' => 'etsy_auto'
		]);
		;

	}
	

	private function getEtsyAccount($email, $acountId = null) {
        
		$query = EtsyAccount::where('parent_email', $email)->where('secret_key', '!=', null)->where('identifier', '!=', null);

		if ($acountId) {
			$query = $query->where('etsy_shop_id', $acountId);
		}

		return $query->first();

	}

	private function getAdsFee($month,$etsy,$years) {

		$year = $years;
		$startMonth = Carbon::parse($year.'-' . $month)->startOfMonth()->toDateString();
		$endMonth = Carbon::parse($year.'-' . $month)->endOfMonth()->toDateString();
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
		$shopId = $etsy->etsy_shop_id;

		// $url = "users/225432101/charges?min_created=.$startMonth.'&max_created='.$endMonth.'&limit=1000'";
		// $url = "users/225432101".'/charges?min_created='.$startMonth.'&max_created='.$endMonth.'&limit=1000';
		// $url = "users/225432101/payments";
        
		$url = "shops/".$etsy->etsy_shop_id."/payment_account/entries?min_created=".$startMonth."-01&max_created=".$endMonth."&limit=1000";
		// get sale fee
// 		$url = "shops/".$etsy->etsy_shop_id.'/payment_account/entries/7750370542/payment';
		// $url = "shops/".$etsy->etsy_shop_id.'/payment_account/entries/7750370542/payment';
		// get sale fee from receipt id
		// $url = "shops/".$etsy->etsy_shop_id.'/receipts/1810458068/payments';
		// listing_id = 819245351
		// shipping_listing_id = 20965730865
		// $url = "shops/".$etsy->etsy_shop_id."/payment_account/entries/7392283911/payment";

		$res = $client->get($url, [
				'auth' => 'oauth'
		]);
	
		$response = json_decode($res->getBody()->getContents());
// 		dd($response);
		$page = ceil($response->count / 100);

		$transactions = $response->results;

		$pagination = $response->pagination;
		$pagination->total_page = ceil($response->count / 100);
		$pagination->total_transactions = $response->count;
		$result = $transactions;
		for($i = 2; $i <= $page; $i ++) {
			$page = (int)$page;
			$url = "shops/" .$etsy->etsy_shop_id. '/payment_account/entries?min_created=' . $startMonth . '&max_created=' . $endMonth . '&limit=1000&page=' . $i;
			$res = $client->get($url, [
					'auth' => 'oauth'
			]);
			$response = json_decode($res->getBody()->getContents());
			$transactions = $response->results;
			$result = array_merge($result, $transactions);
		}
		$response = [];
		foreach($result as $key => $transaction) {
			if ($transaction->description == "offsite_ads_fee_refund" || $transaction->description == "RECOUP" || $transaction->description == "shipping_transaction_refund" || $transaction->description == "REFUND" || $transaction->description == "listing_refund" || $transaction->description == "PAYMENT" || $transaction->description == "DISBURSE2" || $transaction->description == "transaction_refund") {
				unset($result[$key]);
			} else {
				$temp = [
						'bill_charge_id' => $transaction->entry_id,
						'amount' => number_format(($transaction->amount * - 1) / 100, 2),
						'label' => ucwords(str_replace('_', ' ', $transaction->description)),
						'creation_tsz' => $transaction->create_date,
						'currency_code' => $transaction->currency
				];
				$response[] = (object)$temp;
			}
		}
		return $response;

	}

	private function setArrayBillingData($transactions) {

		foreach($transactions as $key => $transaction) {
			switch ($transaction->type) {
				case "shipping_labels" :
					$transactions[$key]->label = "Shipping Labels";
					break;
				case "renew_sold_auto" :
					unset($transactions[$key]);
					break;
				case "transaction_quantity" :
					$transactions[$key]->label = "Quantity Fee";
					break;
				case "listing" :
					$transactions[$key]->label = "Listing Fee";
					break;
				case "shipping_label_taxes" :
					$transactions[$key]->label = "Shipping Label Taxes";
					break;
			}
		}
		return $transaction;

	}

	private function getLedgerEntry($month, $etsy,$years) {

		try {
			$year = $years;
		    $startMonth = Carbon::parse($year.'-' . $month)->startOfMonth()->toDateString();
		    $endMonth = Carbon::parse($year.'-' . $month)->endOfMonth()->toDateString();
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
			$shopId = $etsy->etsy_shop_id;
			$url = "shops/" . $etsy->etsy_shop_id . "/ledger";
			$res = $client->get($url, [
					'auth' => 'oauth'
			]);
			$response = json_decode($res->getBody()->getContents());
			$page = ceil($response->count / 100);
			$ledger = $response->results;
			$newUrl = "shops/" . $etsy->etsy_shop_id . "/payment_account/entries?min_created=" . $startMonth . "&max_created=" . $endMonth . "&limit=1000";
			$res = $client->get($newUrl, [
					'auth' => 'oauth'
			]);
			$response = json_decode($res->getBody()->getContents());
			$page = ceil($response->count / 100);
			$result = $response->results;
			for($i = 2; $i <= $page; $i ++) {
				$page = (int)$page;
				$newUrl = "shops/" . $etsy->etsy_shop_id . "/payment_account/entries?min_created=" . $startMonth . "&max_created=" . $endMonth . "&limit=1000&page=" . $i;
				$res = $client->get($newUrl, [
						'auth' => 'oauth'
				]);
				$response = json_decode($res->getBody()->getContents());
				$transactions = $response->results;
				$result = array_merge($result, $transactions);
			}
			$response = [];
			foreach($result as $item) {
				if ($item->description === "transaction") {
					$temp = [
							'bill_charge_id' => $item->entry_id,
							'amount' => number_format(($item->amount * - 1) / 100, 2),
							'label' => ucwords(str_replace('_', ' ', $item->description)),
							'creation_tsz' => $item->create_date,
							'currency_code' => $item->currency
					];
					$response[] = (object)$temp;
				}
			}
			return $response;
		} catch ( Exception $e ) {
		}

	}


	public function delete_acc_etsy(Request $req) {

		$id = $req->acc_id;
		DB::table('etsy_account')->where('id', '=', $id)->delete();
		return redirect('auto/etsy');

	}
	
	public function getBillingPage(){
	    
	    $etsy_account = EtsyAccount::where('parent_email', auth()->user()->email)->orderBy('id', 'ASC')->where('secret_key', '!=', null)->where(
				'identifier', '!=', null)->get();
	    
	    return view('auto.etsy_billing_page',compact('etsy_account'))->with([
				'page' => 'etsy_auto'
		]);
	    
	    
	}
	
	public function addBillingExpense(Request $request){
	    
        $expenses = (empty($request->expense)) ? [] :  $request->expense;
        
        foreach($expenses as $expense) {
            if( $expense['platform'] === "etsy") {
                    $expense['account'] = "429 - General Expenses";
                if($expense['name'] === "Shipping Labels") {
                    $expense['account'] = "425 - Freight & Courier";   
                }
            }
            $expenseModel = new Expense();
            $expenseModel->user_id = Auth::id();
            $expenseModel->spreadsheet_id = $expense['spreadsheet_id'];
            $expenseModel->date = Carbon::parse($expense['date'])->format('Y-m-d');
            $expenseModel->currency = $expense['currency'];
            $expenseModel->name = $expense['name'];
            $expenseModel->amount = $expense['other_fees'];
            $expenseModel->account = $expense['account'];
            $expenseModel->save();
        }
    
        return response()->json(['status'=>'valid','message'=>'Added To Spreadsheet','color'=>'#d4edda','text'=>'#262626']);

	    
	}
	
	public function addSoldListing(Request $request){
	    
        $fee_array = (empty($request->fee_array)) ? [] : $request->fee_array;
      
        foreach($fee_array as  $feeone){
            $spreadsheet_id = $feeone['spreadsheet_id'];
            if(isset($spreadsheet_id)){
                $count = Spreadsheet::where('user_id', '=', Auth::id())
                ->where('spreadsheet_id', '=', $spreadsheet_id)
                ->where('spreadsheet_name','=', $feeone['spreadsheet_name'])
                ->count();
                $sales_count = DB::table('sales')
                ->where('user_id', '=', Auth::id())
                ->count();
    
                if ($count > 0) {
                    $sale = new Sales;
                    $sale->user_id = Auth::id();
                    $sale->sales_id = $feeone['sale_id'];
                    $sale->item_id = $feeone['item_id'];
                    $sale->spreadsheet_id = $spreadsheet_id;
                    $sale->sale_date = Carbon::parse($feeone['date'])->format('Y-m-d');
                    $sale->platform = $feeone['platform'];
                    $sale->quantity = $feeone['quantity'];
                    $sale->name = $feeone['name'];
                    $sale->currency = $feeone['currency'];
                    $sale->sold_price = ($feeone['sold_price']) ? $feeone['sold_price'] : 0;
                    $sale->item_cost = ($feeone['item_cost']) ? $feeone['item_cost'] : 0;
                    $sale->shipping_charge = ($feeone['shipping_charge']) ? $feeone['shipping_charge'] : 0;
                    $sale->shipping_cost = ($feeone['shipping_cost']) ? $feeone['shipping_cost'] : 0;
                    $sale->fees = ($feeone['fees']) ? $feeone['fees']: 0;
                    $sale->other_fees =  ($feeone['other_fees']) ? $feeone['other_fees'] : 0;
                    $sale->processing_fees = ($feeone['processing_fees']) ? $feeone['processing_fees'] : 0;
                    $sale->tax = ($feeone['tax']) ? $feeone['tax'] : 0;
                    $sale->profit = ($feeone['profit']) ? $feeone['profit'] : 0;
    
                    if (Auth::user()->subscribed('main')) {
                        $sale->save();
                        // return response()->json(['status'=>'valid','message'=>'Added To Spreadsheet','color'=>'#d4edda','text'=>'#262626']);
                    } else{
                        if ($sales_count < 25) {
                            $sale->save();
                            return response()->json(['status'=>'valid','message'=>'Added To Spreadsheet','color'=>'#d4edda','text'=>'#262626']);
                        }else{
                            return response()->json(['status'=>'upgrade','message'=>'<a class="upgrade_acc" href="subscription">Please Upgrade Account</a>','color'=>'#ea3f4f','text'=>'white']);
                        }
                    }
    
                }else{
                    return response()->json(['message'=>'Error Spreadsheet','color'=>'#ea3f4f','text'=>'white']);
                }
    
            }
        }
        
        return response()->json(['status'=>'valid','message'=>'Added To Spreadsheet','color'=>'#d4edda','text'=>'#262626']);
	    
	}



}