<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use GuzzleHttp\Client;
use DB;
use App\Spreadsheet;
use App\Sales;
use PDF;
use Session;

class AutoController extends Controller{

  private $OAUTH_CONSUMER_KEY = 'vfe4uh6h10umw6bx1m457sty'; // Etsy CONSUMER KEY
  private $OAUTH_CONSUMER_SECRET = 'ftt27s55mp'; // Etsy CONSUMER SECRET

  public function __construct(){
    $this->middleware(['auth', 'verified']);
  }

  public function ebay_auto(){
    $email_parent = auth()->user()->email;
    
    
    $ebay_account = DB::table('ebay_account')->where('parent_email', '=', "$email_parent")->limit(1)->get()->toArray();
    return view('auto.ebay',compact('ebay_account'))->with(['page'=>'ebay_auto']);
  }

  public function etsy_auto(){
    return view('auto.etsy')->with(['page'=>'etsy_auto']);
  }

  public function ebay_session(Request $request){
    
      $ruName = 'Brandon_Huynh-BrandonH-Finalf-kxqig';
    $dev_id='0bec824a-fa0d-468f-957c-1c0d89141310';
    $app_id='BrandonH-Finalfee-PRD-21e9cf7c1-de687d79';
    $cert_id='PRD-1e9cf7c123c0-043b-412c-b2c1-a82e';
    
    $site_id='0';
    $compat_level='967';
    $call_name='GetSessionID';
    $api_endpoint='https://api.ebay.com/ws/api.dll';
    $headers = array(
      'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compat_level,
      'X-EBAY-API-DEV-NAME: ' . $dev_id,
      'X-EBAY-API-APP-NAME: ' . $app_id,
      'X-EBAY-API-CERT-NAME: ' . $cert_id,
      'X-EBAY-API-CALL-NAME: ' . $call_name,
      'X-EBAY-API-SITEID: ' . $site_id,
    );
    $xml_request='<?xml version="1.0" encoding="utf-8"?>
      <GetSessionIDRequest xmlns="urn:ebay:apis:eBLBaseComponents">
        <ErrorLanguage>en_US</ErrorLanguage>
        <WarningLevel>High</WarningLevel>
        <!-- Enter you RuName -->
        <RuName>'.$ruName.'</RuName>
      </GetSessionIDRequest>';
    $connection = curl_init();
    curl_setopt($connection, CURLOPT_URL, $api_endpoint);
    curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($connection, CURLOPT_POST, 1);
    curl_setopt($connection, CURLOPT_POSTFIELDS, $xml_request);
    curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($connection);
    //print_r($response);
    $xml = simplexml_load_string($response); // assume XML in $x
    $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);
    $response_sesson=$array['SessionID'];
    $rupam='&ruparams=SessID%3D'.$response_sesson;
    $url_window='https://signin.ebay.com/ws/eBayISAPI.dll?SignIn&RUName='.$ruName.'&SessID='.$response_sesson.$rupam;

    $array_json=array('ruName'=>$ruName,'session'=>$response_sesson,'url_window'=>$url_window);
    return $array_json;
    curl_close($connection);
  }

  public function account(){
    $email_parent = auth()->user()->email;
    $ebay_account = DB::table('ebay_account')->where('parent_email', '=', "$email_parent")->get();
    return view('auto.widget.account', ['ebay_account' => $ebay_account])->render();
  }
  
  public function getOauthtoken(Request $request){
      
      Session::put('accountid',$request->accountid);
      return redirect('https://auth.ebay.com/oauth2/authorize?client_id=BrandonH-Finalfee-PRD-21e9cf7c1-de687d79&response_type=code&redirect_uri=Brandon_Huynh-BrandonH-Finalf-kxqig&scope=https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/sell.marketing.readonly https://api.ebay.com/oauth/api_scope/sell.marketing https://api.ebay.com/oauth/api_scope/sell.inventory.readonly https://api.ebay.com/oauth/api_scope/sell.inventory https://api.ebay.com/oauth/api_scope/sell.account.readonly https://api.ebay.com/oauth/api_scope/sell.account https://api.ebay.com/oauth/api_scope/sell.fulfillment.readonly https://api.ebay.com/oauth/api_scope/sell.fulfillment https://api.ebay.com/oauth/api_scope/sell.analytics.readonly https://api.ebay.com/oauth/api_scope/sell.finances https://api.ebay.com/oauth/api_scope/sell.payment.dispute https://api.ebay.com/oauth/api_scope/commerce.identity.readonly&prompt=login');
  }
  
  
  public function promotionlist(Request $request){
      if(isset($request->accountid)){
          $accountid = $request->accountid;
          $account_info = DB::table('ebay_account')->where('id',$accountid)->first();
          //var_dump($account_info);
          $oauth_token = $account_info->oauthtoken;
          
        $headers = array(
          'X-EBAY-C-MARKETPLACE-ID:EBAY_CA',
          'Content-Type:application/json',
          'Authorization:Bearer '.$oauth_token,
         );
         $api_endpoint = "https://api.ebay.com/sell/recommendation/v1/find?filter=recommendationTypes:{AD}&offset=0&limit=500";
        //$data = "filter=recommendationTypes:{AD}&offset=0"."&limit=500";
          $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $api_endpoint);
        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($connection, CURLOPT_POST, 1);
      //  curl_setopt($connection, CURLOPT_POSTFIELDS,  $data);
        //curl_setopt($connection, CURLOPT_POSTFIELDS, $body);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($connection);
       // $current_token = json_encode($response);
        $current_token = json_decode($response);
       // var_dump($response);
          
          
          
      }
      
      
  }
  

  public function create_acc_ebay(Request $request){
      
      if(isset($request->SessID)){
          $SessID=$request->SessID;
    $username=$request->username;
    $ruName = 'Brandon_Huynh-BrandonH-Finalf-kxqig';
    $dev_id='0bec824a-fa0d-468f-957c-1c0d89141310';
    $app_id='BrandonH-Finalfee-PRD-21e9cf7c1-de687d79';
    $cert_id='PRD-1e9cf7c123c0-043b-412c-b2c1-a82e';
    $site_id='0';
    $compat_level='967';
    $call_name='FetchToken';
    $api_endpoint='https://api.ebay.com/ws/api.dll';
    $headers = array(
      'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compat_level,
      'X-EBAY-API-DEV-NAME: ' . $dev_id,
      'X-EBAY-API-APP-NAME: ' . $app_id,
      'X-EBAY-API-CERT-NAME: ' . $cert_id,
      'X-EBAY-API-CALL-NAME: ' . $call_name,
      'X-EBAY-API-SITEID: ' . $site_id,
    );
    $xml_request='<?xml version="1.0" encoding="utf-8"?>
      <FetchTokenRequest xmlns="urn:ebay:apis:eBLBaseComponents">
        <ErrorLanguage>en_US</ErrorLanguage>
        <WarningLevel>High</WarningLevel>
         <!-- Enter the SessionID created for the user for whom the token needs to be retrieved -->
       <SessionID>'.$SessID.'</SessionID>
      </FetchTokenRequest>';
    $connection = curl_init();
    curl_setopt($connection, CURLOPT_URL, $api_endpoint);
    curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($connection, CURLOPT_POST, 1);
    curl_setopt($connection, CURLOPT_POSTFIELDS, $xml_request);
    curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($connection);
    //print_r($response);
    $xml = simplexml_load_string($response); // assume XML in $x
    $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);
    $email=$request->username;
    $email_parent = auth()->user()->email;
    $subs = DB::table('ebay_account')->where('ebay_email', '=', "$email")->where('parent_email', '=', "$email_parent")->count('ebay_email');
    if ($subs === 0) {
      $authtoken=$array['eBayAuthToken'];
      DB::insert('INSERT INTO `ebay_account` ( `ebay_email`, `parent_email`,`user_token`,`session_int`,`json`) values (?, ? ,? ,?,?)', array($email, $email_parent,$authtoken,$SessID,$json));
      return redirect('auto/ebay?message=success')->with('message','success');
      
     }else{
       return redirect('auto/ebay?message=exist')->with('message','exist');
     }
          
      } else {
   
        $api_endpoint = 'https://api.ebay.com/identity/v1/oauth2/token';
        $ruName = 'Brandon_Huynh-BrandonH-Finalf-kxqig';
        $dev_id='0bec824a-fa0d-468f-957c-1c0d89141310';
        $app_id='BrandonH-Finalfee-PRD-21e9cf7c1-de687d79';
        $cert_id='PRD-1e9cf7c123c0-043b-412c-b2c1-a82e';
        $authrization = base64_encode($app_id.':'.$cert_id);
        $headers = array(
              'Content-Type:application/x-www-form-urlencoded',
              'Authorization:Basic '.$authrization,
              
              
          );
     
          $data = "grant_type=authorization_code&code=".urlencode($request->code)."&redirect_uri=".$ruName;
          $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $api_endpoint);
        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($connection, CURLOPT_POST, 1);
        curl_setopt($connection, CURLOPT_POSTFIELDS,  $data);
        //curl_setopt($connection, CURLOPT_POSTFIELDS, $body);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($connection);
        $current_token = json_decode($response);
        $oauthToken = isset($current_token->access_token)?$current_token->access_token:'null';
        if(Session::get('accountid')){
            $updateData = DB::table('ebay_account')->where('id',Session::get('accountid'))->update(['oauthtoken'=>$oauthToken,'verifiedOauth'=>1]);
        }
        return redirect('auto/ebay');
        
      }
    
  }
  
  public function testpromotion(Request $request){
      if(isset($request->accountid)){
  
      }
  }

  public function delete_acc_ebay(Request $request){
    $id=$_GET['id'];
    DB::table('ebay_account')->where('id', '=', $id)->delete();
    return redirect('auto/ebay');
  }




  public function fetchFinalValueFees($order_xml_list, $authKey){
 
    $client = new Client();
    $call_name = 'GetOrders';
    $sited = '0';
    $compatibility_level = '967';
    $request_uri = 'https://api.ebay.com/ws/api.dll';
    $authToken = $authKey;
    $xml_body = '<?xml version="1.0" encoding="utf-8"?>
      <GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">
        <RequesterCredentials>
          <eBayAuthToken>'.$authToken.'</eBayAuthToken>
        </RequesterCredentials>
        <ErrorLanguage>en_US</ErrorLanguage>
        <WarningLevel>High</WarningLevel>
        <OrderIDArray>
          '.$order_xml_list.'
        </OrderIDArray>
        <OrderRole>Seller</OrderRole>
        <IncludeFinalValueFee>true</IncludeFinalValueFee>
        <DetailLevel>ReturnAll</DetailLevel>

      </GetOrdersRequest>';
    if(!empty($order_xml_list) && $authKey){
      $response = $client->request('POST', $request_uri, [
                'headers' => [
                  'Content-Type' => 'text/xml',
                  'X-EBAY-API-SITEID' => $sited,
                  'X-EBAY-API-COMPATIBILITY-LEVEL' => $compatibility_level,
                  'X-EBAY-API-CALL-NAME' => $call_name,
                ],
                'body' => $xml_body
              ]);
      $data = $response->getBody()->getContents();
      if($data){
        $xml_data = simplexml_load_string($data);
        $json_data = json_encode($xml_data);
        $array_data = json_decode($json_data, true);

        $order = $array_data['OrderArray']['Order'];
        //var_dump($order);
        $return_data = array();
        $index = 0;
        foreach($order as $orderOne){
            if($orderOne['OrderStatus'] == 'Completed' && isset($orderOne['OrderStatus']) ){
                $return_data[$index] = array(
                    'index' => $index,
                    'OrderID'=> $orderOne['OrderID'],
                    'CreatedTime' => isset($orderOne['PaidTime'])?$orderOne['PaidTime']:null,
                    'OrderStatus' => isset($orderOne['OrderStatus'])?$orderOne['OrderStatus']:null,
                        'AdjustmentAmount' => isset($orderOne['AdjustmentAmount'])?$orderOne['AdjustmentAmount']:null,
                    'AmountPaid' =>isset( $orderOne['AmountPaid'])?$orderOne['AmountPaid']:0.0,
                    'Subtotal' => isset($orderOne['Subtotal'])?$orderOne['Subtotal']:0.0,
                    'Total' => isset($orderOne['Total'])?$orderOne['Total']:0.0,
                 
                    'ShippingService' => isset($orderOne['ShippingDetails']['ShippingService'])?$orderOne['ShippingDetails']['ShippingService']:null,
                    'ShippingServiceCost' => isset($orderOne['ShippingServiceSelected']['ShippingServiceCost'])?$orderOne['ShippingServiceSelected']['ShippingServiceCost']:0.0,

                    'ActualShippingCost' => isset($orderOne['TransactionArray']['Transaction']['ActualShippingCost'])?$orderOne['TransactionArray']['Transaction']['ActualShippingCost']:0.0,
                    'FinalValueFee' => isset($orderOne['TransactionArray']['Transaction']['FinalValueFee'])?$orderOne['TransactionArray']['Transaction']['FinalValueFee']:0.0,
                    'FeeOrCreditAmount' => isset($orderOne['ExternalTransaction']['FeeOrCreditAmount'])?$orderOne['ExternalTransaction']['FeeOrCreditAmount']:0.0,
                    'TotalTaxAmount'=>isset($orderOne['TransactionArray']['Transaction']['Taxes']['TotalTaxAmount'])?$orderOne['TransactionArray']['Transaction']['Taxes']['TotalTaxAmount']:0.0,
                    'TaxAmount'=>isset($orderOne['TransactionArray']['Transaction']['Taxes']['TaxDetails']['TaxAmount'])?$orderOne['TransactionArray']['Transaction']['Taxes']['TaxDetails']['TaxAmount']:0.0,
                    'TaxOnSubtotalAmount'=>isset($orderOne['TransactionArray']['Transaction']['Taxes']['TaxDetails']['TaxOnSubtotalAmount'])?$orderOne['TransactionArray']['Transaction']['Taxes']['TaxDetails']['TaxOnSubtotalAmount']:0.0,
                    'TaxOnShippingAmount'=>isset($orderOne['TransactionArray']['Transaction']['Taxes']['TaxDetails']['TaxOnShippingAmount'])?$orderOne['TransactionArray']['Transaction']['Taxes']['TaxDetails']['TaxOnShippingAmount']:0.0,
                    'TaxOnHandlingAmount'=>isset($orderOne['TransactionArray']['Transaction']['Taxes']['TaxDetails']['TaxOnHandlingAmount'])?$orderOne['TransactionArray']['Transaction']['Taxes']['TaxDetails']['TaxOnHandlingAmount']:0.0
                    ,'title'=>isset($orderOne['TransactionArray']['Transaction']['Item']['Title'])?$orderOne['TransactionArray']['Transaction']['Item']['Title']:'no title',
                    'ActualShippingCost'=>isset($orderOne['TransactionArray']['Transaction']['ActualShippingCost'])?$orderOne['TransactionArray']['Transaction']['ActualShippingCost']:'0.0',
                    'ActualHandlingCost'=>isset($orderOne['TransactionArray']['Transaction']['ActualHandlingCost'])?$orderOne['TransactionArray']['Transaction']['ActualHandlingCost']:'0.0',
                    'QuantityPurchased'=>isset($orderOne['TransactionArray']['Transaction']['QuantityPurchased'])?$orderOne['TransactionArray']['Transaction']['QuantityPurchased']:'0',
                    'OrderLineItemID'=>isset($orderOne['TransactionArray']['Transaction']['OrderLineItemID'])?$orderOne['TransactionArray']['Transaction']['OrderLineItemID']:'0',
                    'ItemID'=>isset($orderOne['TransactionArray']['Transaction']['Item']['ItemID'])?$orderOne['TransactionArray']['Transaction']['Item']['ItemID']:'',
                    'adfee'=>'0.0',
                    'image_url'=>'https://www.finalfees.com/image/no_image.jpg',
                );
                
              
                $index++;
            }
        }
      
        return $return_data;
      }
    }
  }
  
  public function testapi(){
      $ruName = 'Brandon_Huynh-BrandonH-Finalf-kxqig';
    $dev_id='0bec824a-fa0d-468f-957c-1c0d89141310';
    $app_id='BrandonH-Finalfee-PRD-21e9cf7c1-de687d79';
    $cert_id='PRD-1e9cf7c123c0-043b-412c-b2c1-a82e';
    $site_id='0';
    $compat_level='967';
    $call_name='GetMyeBaySelling';
    $api_endpoint='https://api.ebay.com/ws/api.dll';
    $api_cred='AgAAAA**AQAAAA**aAAAAA**SqYxXQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AMk4unCJSLogidj6x9nY+seQ**aw4GAA**AAMAAA**GtT5uOiH3pYHPXsyKWJSqAR4rEgojKnFcJMypgAcR60l8MAatu1IZ9lCY08DWGW6F2NLilmjigyIo5zMWV+3divrZs4/9Kh2wioBKSQOhfyFznfatypsSVC1o3Ky0XQSeyWPuDYhNefVoDvF4vzPBOj1yVCVIusI3nXt64vYYZoEVWCJFjt8vYcKv9BcEsRgeWs78lAIPWzgrhhK/dtLUrMhlw9UFXpIpFbxfHb3fC1ARjdvqg4kNf0yMCfRXMPEown88hjHiWPnfTQBOG7KUDcqc4KJqZyX8WY5V2uVAW/JWC4RCoM+YVbE/YVscqymq15dBhm392Ec8bpz9U5QwNfa7z9EanbdF+cbowESf0I7NZci0Iwdewg2vodlcW5pWfYAojRhoI8r0o5DoJ/dYB5odsjAPrbRA4peHx9sEr4aNirJxaE2EAFRchMdP5S9EXsEjGsxXWZeQRI0d3+Yf4Fd9QNgD8tGFBYjHdIkRajs24FnWIkiLMAir5+2wDYgFrts707JWY2/Xbr/BIHH6pG4EkJR45pV8zRaG7pCJI2c8IeJkutXRzD3IjvYvk9UMHEdBb/yQNexkBEVHirGMRxozbzd0WLz59ltoCqMVw/+4DKeFbmRqzYq24/O9I4jakqoZsl/Qft6for9ZlDxBBzz0msa5JxTmfqmZeJ8ZttTqT9OFiDY6VIclJ6ICfR+vZYTV9YGNUW6JvCuZEqMIwmgYvhfkTYzZqiRJf7eOwSutn3KTegj+fxM+IRxDOOz';
    if(isset($_POST['active_select'])){
      $select_id=$_POST['active_select'];
      $ebay_accounts = DB::table('ebay_account')->where('id',$select_id)->first();
   
       $api_cred=$ebay_accounts->user_token;
    }
    $headers = array(
      'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compat_level,
      'X-EBAY-API-DEV-NAME: ' . $dev_id,
      'X-EBAY-API-APP-NAME: ' . $app_id,
      'X-EBAY-API-CERT-NAME: ' . $cert_id,
      'X-EBAY-API-CALL-NAME: ' . $call_name,
      'X-EBAY-API-SITEID: ' . $site_id,
    );
    $xml_request='<?xml version="1.0" encoding="utf-8"?>
    
    <GetPromotionalSaleDetailsRequest xmlns="urn:ebay:apis:eBLBaseComponents">
        <RequesterCredentials>
         <eBayAuthToken>'.$api_cred.'</eBayAuthToken>
        </RequesterCredentials>
  <ErrorLanguage>en_US</ErrorLanguage>
  <WarningLevel>High</WarningLevel>
</GetPromotionalSaleDetailsRequest>';
    $connection = curl_init();
    curl_setopt($connection, CURLOPT_URL, $api_endpoint);
    curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($connection, CURLOPT_POST, 1);
    curl_setopt($connection, CURLOPT_POSTFIELDS, $xml_request);
    curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($connection);
    print_r($response);
      
  }
  
  public function fetch_fees($select_id,$startdate, $enddate){
        
       
       if($startdate == $enddate){
           $startdate =  date('Y-m-d',strtotime($startdate)); 
            $enddate =  date('Y-m-d',strtotime('+2 day',strtotime($enddate))); 
           
       } else {
           $startdate =  date('Y-m-d',strtotime($startdate)); 
       $enddate =  date('Y-m-d',strtotime('+2 day',strtotime($enddate))); 
           
       }

       $ebay_accounts = DB::table('ebay_account')->where('id',$select_id)->first();
        $api_cred=$ebay_accounts->user_token;
        $api_cred = isset($api_cred)?$api_cred:
        
        $ruName = 'Brandon_Huynh-BrandonH-Finalf-kxqig';
        $dev_id='0bec824a-fa0d-468f-957c-1c0d89141310';
        $app_id='BrandonH-Finalfee-PRD-21e9cf7c1-de687d79';
        $cert_id='PRD-1e9cf7c123c0-043b-412c-b2c1-a82e';
        $site_id='0';
        $compat_level='967';
        $call_name='GetAccount';
        $api_endpoint='https://api.ebay.com/ws/api.dll';
        
        $headers = array(
          'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compat_level,
          'X-EBAY-API-DEV-NAME: ' . $dev_id,
          'X-EBAY-API-APP-NAME: ' . $app_id,
          'X-EBAY-API-CERT-NAME: ' . $cert_id,
          'X-EBAY-API-CALL-NAME: ' . $call_name,
          'X-EBAY-API-SITEID: ' . $site_id,
          'Content-Type:application/xml',
          
        );
        $xml_request="<?xml version='1.0' encoding='utf-8'?>
         <GetAccountRequest xmlns='urn:ebay:apis:eBLBaseComponents'><RequesterCredentials>
            <eBayAuthToken>".$api_cred."</eBayAuthToken>
          </RequesterCredentials>
            <ErrorLanguage>en_US</ErrorLanguage>
          <WarningLevel>High</WarningLevel>
          <AccountEntrySortType>AccountEntryFeeTypeAscending</AccountEntrySortType><AccountHistorySelection>BetweenSpecifiedDates</AccountHistorySelection><BeginDate>".$startdate."</BeginDate><EndDate>".$enddate."</EndDate></GetAccountRequest><OutputSelector>OrderLineItemID</OutputSelector><OutputSelector>NetDetailAmount</OutputSelector><OutputSelector>Memo</OutputSelector> ";
        $connection = curl_init();
        curl_setopt($connection, CURLOPT_URL, $api_endpoint);
        curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($connection, CURLOPT_POST, 1);
        curl_setopt($connection, CURLOPT_POSTFIELDS, $xml_request);
        curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($connection);
        $xml = simplexml_load_string($response); // assume XML in $x
        $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
 
        if(!empty($array['AccountEntries']) && isset( $array['AccountEntries'])){
           return $array['AccountEntries'];
        } else {
            return 'false';
           
        }
  }


  public function sold(){
    set_time_limit(0);
     $pagenumber = 1;
    if(isset($_POST['current_page'])){
        $pagenumber = $_POST['current_page'];
        
    }
      
    $ruName = 'Brandon_Huynh-BrandonH-Finalf-kxqig';
    $dev_id='0bec824a-fa0d-468f-957c-1c0d89141310';
    $app_id='BrandonH-Finalfee-PRD-21e9cf7c1-de687d79';
    $cert_id='PRD-1e9cf7c123c0-043b-412c-b2c1-a82e';
    $site_id='0';
    $compat_level='967';
    $call_name='GetMyeBaySelling';
    $api_endpoint='https://api.ebay.com/ws/api.dll';
    $api_cred='AgAAAA**AQAAAA**aAAAAA**SqYxXQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AMk4unCJSLogidj6x9nY+seQ**aw4GAA**AAMAAA**GtT5uOiH3pYHPXsyKWJSqAR4rEgojKnFcJMypgAcR60l8MAatu1IZ9lCY08DWGW6F2NLilmjigyIo5zMWV+3divrZs4/9Kh2wioBKSQOhfyFznfatypsSVC1o3Ky0XQSeyWPuDYhNefVoDvF4vzPBOj1yVCVIusI3nXt64vYYZoEVWCJFjt8vYcKv9BcEsRgeWs78lAIPWzgrhhK/dtLUrMhlw9UFXpIpFbxfHb3fC1ARjdvqg4kNf0yMCfRXMPEown88hjHiWPnfTQBOG7KUDcqc4KJqZyX8WY5V2uVAW/JWC4RCoM+YVbE/YVscqymq15dBhm392Ec8bpz9U5QwNfa7z9EanbdF+cbowESf0I7NZci0Iwdewg2vodlcW5pWfYAojRhoI8r0o5DoJ/dYB5odsjAPrbRA4peHx9sEr4aNirJxaE2EAFRchMdP5S9EXsEjGsxXWZeQRI0d3+Yf4Fd9QNgD8tGFBYjHdIkRajs24FnWIkiLMAir5+2wDYgFrts707JWY2/Xbr/BIHH6pG4EkJR45pV8zRaG7pCJI2c8IeJkutXRzD3IjvYvk9UMHEdBb/yQNexkBEVHirGMRxozbzd0WLz59ltoCqMVw/+4DKeFbmRqzYq24/O9I4jakqoZsl/Qft6for9ZlDxBBzz0msa5JxTmfqmZeJ8ZttTqT9OFiDY6VIclJ6ICfR+vZYTV9YGNUW6JvCuZEqMIwmgYvhfkTYzZqiRJf7eOwSutn3KTegj+fxM+IRxDOOz';
    if(isset($_POST['active_select'])){
      $select_id=$_POST['active_select'];
      $ebay_accounts = DB::table('ebay_account')->where('id',$select_id)->first();
     
       $api_cred=$ebay_accounts->user_token;
    }
    $headers = array(
      'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compat_level,
      'X-EBAY-API-DEV-NAME: ' . $dev_id,
      'X-EBAY-API-APP-NAME: ' . $app_id,
      'X-EBAY-API-CERT-NAME: ' . $cert_id,
      'X-EBAY-API-CALL-NAME: ' . $call_name,
      'X-EBAY-API-SITEID: ' . $site_id,
    );
    $xml_request='<?xml version="1.0" encoding="utf-8"?>
     <GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">
      <RequesterCredentials>
        <eBayAuthToken>'.$api_cred.'</eBayAuthToken>
      </RequesterCredentials>
      <DetailLevel>ReturnAll</DetailLevel>
        <ErrorLanguage>en_US</ErrorLanguage>
        <WarningLevel>High</WarningLevel>
      <SoldList>
        <include>true</include>
        <Pagination>
          <EntriesPerPage>100</EntriesPerPage>
          <PageNumber>'.$pagenumber.'</PageNumber>
        </Pagination>
           <DurationInDays>60</DurationInDays>
      </SoldList>
    </GetMyeBaySellingRequest>';
    $connection = curl_init();
    curl_setopt($connection, CURLOPT_URL, $api_endpoint);
    curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($connection, CURLOPT_POST, 1);
    curl_setopt($connection, CURLOPT_POSTFIELDS, $xml_request);
    curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($connection);
    //var_dump($response);
    
  
    $xml = simplexml_load_string($response); // assume XML in $x
    $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);
    //var_dump($array);
    $email_parent = auth()->user()->email;
    $ebay_account = DB::table('ebay_account')->where('parent_email', '=', "$email_parent")->get()->toArray();

    $order_list = array();
    $order_id_list = array();
    $order_list_index = 0;
    $order_xmd_list = "";
    $order_detail = array();
    $transactionOne = array();
    $transaction = array();
    $order_details = array();
    $confirm_package = array();
    $confirm_package_index = 0;
    $same_package = 0;
    
    $totalpages = isset($array['SoldList']['PaginationResult']['TotalNumberOfPages'])?$array['SoldList']['PaginationResult']['TotalNumberOfPages']:1;
    $totalentries = isset($array['SoldList']['PaginationResult']['TotalNumberOfEntries'])?$array['SoldList']['PaginationResult']['TotalNumberOfEntries']:1;
    $pagenation = array(['pagenumber'=>$pagenumber,'totalpages'=>$totalpages, 'totalentries'=>$totalentries]);
    if(isset($array['SoldList']['OrderTransactionArray']['OrderTransaction'])){
      //echo "fffffffffffffffffffffffffffffffffffffffff";
      $OrderTransaction = $array['SoldList']['OrderTransactionArray']['OrderTransaction'];
      
      
      foreach ($array['SoldList']['OrderTransactionArray']['OrderTransaction'] as  $transaction) {
         //var_dump($transaction);
           
        if(isset($transaction['Transaction']['OrderLineItemID']) && $transaction['Transaction']['OrderLineItemID'] != null){
            $current_order= $transaction['Transaction']['OrderLineItemID'];

            $order_id_list[$order_list_index] =  $current_order;
            
            $order_xmd_list .= "<OrderID>".$current_order."</OrderID>";
            $order_list_index++;

        } else {
            if(isset($transaction['Order']['TransactionArray']['Transaction']) && $transaction['Order']['TransactionArray']['Transaction'] != null){
                foreach($transaction['Order']['TransactionArray']['Transaction'] as $key=> $transactionone){
                    if(is_numeric($key)){
                        if(isset($transactionone['OrderLineItemID'])){
                            array_push($confirm_package,array('package'=>$confirm_package_index,'OrderLineItemID'=>$transactionone['OrderLineItemID']) );
                            $current_order= $transactionone['OrderLineItemID'];
                            $order_id_list[$order_list_index] =  $current_order;
                            $order_xmd_list =$order_xmd_list. "<OrderID>".$current_order."</OrderID>";
                            $order_list_index++;
                        }
                    }  else if($key == 'OrderLineItemID' && isset($transactionone)){
                        array_push($confirm_package,array('package'=>$confirm_package_index,'OrderLineItemID'=>$transactionone) );
                        $current_order= $transactionone;
                        $order_id_list[$order_list_index] =  $current_order;
                        $order_xmd_list =$order_xmd_list. "<OrderID>".$current_order."</OrderID>";
                        $order_list_index++;
                    } else {
                    }
                }   
            }
             $confirm_package_index++;
        }

      }
      $order_count = 0;
      if(!empty($order_id_list)){
        $order_details = $this->fetchFinalValueFees($order_xmd_list, $api_cred);
        foreach($order_details as $key1 => $one){
            foreach($OrderTransaction as $key => $transactionOne){
                if(isset($transactionOne['Transaction']['OrderLineItemID'] ) && $transactionOne['Transaction']['OrderLineItemID'] == $one['OrderID']){
                    $order_count++;
                    $order_details[$key1]['OrderLineItemID'] = $transactionOne['Transaction']['OrderLineItemID'];
                    $order_details[$key1]['image_url'] = isset($transactionOne['Transaction']['Item']['PictureDetails']['GalleryURL'])?$transactionOne['Transaction']['Item']['PictureDetails']['GalleryURL']:'https://thumbs.ebaystatic.com/pict/2834071312266464_1.jpg';
                    $order_details[$key1]['listingtype'] = isset($transactionOne['Transaction']['Item']['ListingType'])?$transactionOne['Transaction']['Item']['ListingType']:'https://thumbs.ebaystatic.com/pict/2834071312266464_1.jpg';
                   
                    $order_details[$key1]['QuantityPurchased'] = isset($transactionOne['Transaction']['QuantityPurchased'])?$transactionOne['Transaction']['QuantityPurchased']:'0';
                    $order_details[$key1]['ConvertedCurrentPrice'] = isset($transactionOne['Transaction']['Item']['SellingStatus']['ConvertedCurrentPrice'])?$transactionOne['Transaction']['Item']['SellingStatus']['ConvertedCurrentPrice']:'0.0';
                    $order_details[$key1]['CurrentPrice'] = isset($transactionOne['Transaction']['Item']['SellingStatus']['CurrentPrice'])?$transactionOne['Transaction']['Item']['SellingStatus']['CurrentPrice']:'0.0';
                    break;
                }
            }
        }
      }
    }
    
    $order_detail = usort($order_details, function ($a, $b)
    {
        $t1 = strtotime($a['CreatedTime']);
        $t2 = strtotime($b['CreatedTime']);
        return $t2 - $t1;
    }   );
    // if(empty($order_detail)){
    //     echo "<div style='text-align:center;'>There is no sold items!</div>";
    //     return;
    // }
    // echo  auth()->user()->email;;
    // return;
    if(!empty($order_details)){
        $enddate = $order_details[0]['CreatedTime'];
        $startdate =  $order_details[$order_count-1]['CreatedTime'];
        $other_fees = $this->fetch_fees($select_id, $startdate, $enddate);
        $index=0;
        $adfee_array = array();
        if($other_fees != 'false' && isset($other_fees['AccountEntry']) && !empty($other_fees['AccountEntry'])){

            foreach($other_fees['AccountEntry'] as $key1=>$feeOne){
                if($feeOne['AccountDetailsEntryType']=='FeeAd'){
                    $adfee_array[$index]['NetDetailAmount'] = $feeOne['NetDetailAmount'];
                    $adfee_array[$index]['ItemID'] = $feeOne['ItemID'];
                    $adfee_array[$index]['Memo'] = $feeOne['Memo'];
                    $adfee_array[$index]['Title'] = $feeOne['Title'];
                    $adfee_array[$index]['Date'] = date('Y-m-d',strtotime( $feeOne['Date']));
                    $index++;
                    
                }
            }
            
            foreach($order_details  as $keyv => $orderOne){
                foreach($adfee_array as $feeOne){
                    if(isset($feeOne['ItemID']) && isset($orderOne['ItemID']) && $feeOne['ItemID'] == $orderOne['ItemID'] &&  $feeOne['Date'] == date('Y-m-d',strtotime($orderOne['CreatedTime'])) ){
                        
                        $order_details[$keyv]['adfee'] = isset($feeOne['NetDetailAmount'])?$feeOne['NetDetailAmount']:'0.0';
                    }
                }
            }
        }
    
    } else {
        $myemail = auth()->user()->email;
        $ebay_account = DB::table('ebay_account')->where('parent_email',$myemail)->get()->toArray();       
        $pagenation = array(['pagenumber'=>'0','totalpages'=>'0', 'totalentries'=>'0']);
        return view('auto.widget.sold',compact('order_details','ebay_account','select_id','pagenation'))->render();
    }
    

    $myemail = auth()->user()->email;
    $ebay_account = DB::table('ebay_account')->where('parent_email',$myemail)->get()->toArray();
    $old_key =null;
    $old_key1 = null;
    $package_info = array();

    foreach($order_details as $key => $orderone){
        foreach($confirm_package as $key1 =>$packageone){
           
            if(isset($packageone['OrderLineItemID']) && $orderone['OrderLineItemID'] == $confirm_package[$key1]['OrderLineItemID']){
                    if( isset($order_details[$old_key1]) && isset($order_details[$old_key]) && $confirm_package[$old_key1]['package'] == $confirm_package[$key1]['package']){
                        
                        $order_details[$old_key] ['title'] .= isset($order_details[$key] ['title'])?','. $order_details[$key] ['title']:'';
                        $order_details[$old_key] ['QuantityPurchased'] += $order_details[$key] ['QuantityPurchased'];
                        $order_details[$old_key] ['ShippingServiceCost'] += $order_details[$key] ['ShippingServiceCost'];
                        
                        $order_details[$old_key] ['FeeOrCreditAmount'] += $order_details[$key] ['FeeOrCreditAmount'];
                        $order_details[$old_key] ['TotalTaxAmount'] += $order_details[$key] ['TotalTaxAmount'];
                        $order_details[$old_key] ['TaxOnSubtotalAmount'] += $order_details[$key] ['TaxOnSubtotalAmount'];
                        $order_details[$old_key] ['TaxOnHandlingAmount'] += isset($order_details[$key] ['TaxOnHandlingAmount'])?$order_details[$key] ['TaxOnHandlingAmount']:'';
                        $order_details[$old_key] ['FeeOrCreditAmount'] += $order_details[$key] ['FeeOrCreditAmount'];
                         $order_details[$key] ['adfee'] = '234';
                        $order_details[$old_key] ['adfee'] += (isset($order_details[$key] ['adfee']) && is_array($order_details[$key] ['adfee']))?$order_details[$key] ['adfee']:0;
                
                        unset($order_details[$key]);
                    }
                    $old_key1 = $key1;
                    $old_key = $key;
            }
        } 
    }
    //total entries 
    $total_entries = count($order_details);
    $pagenation[0]['totalentries'] = $total_entries;
   // var_dump($total_entried);
    
    //echo "<br>";
    if(isset($_POST['active_select'])){
      $select_id=$_POST['active_select'];
        if( sizeof($order_details) == 0 ){
          return view('auto.widget.sold',compact('ebay_account','select_id', 'order_details','pagenation'))->render();
        }else{
          return view('auto.widget.sold',compact('ebay_account','select_id', 'order_details','pagenation'))->render();
        }
      
    }else{
      return view('auto.widget.sold',compact('order_details','ebay_account','select_id','pagenation'))->render();
    }
     return view('auto.widget.sold',compact('order_details','ebay_account','select_id','pagenation'))->render();
  }

  public function active(Request $request){
    $ruName = 'Brandon_Huynh-BrandonH-Finalf-kxqig';
    $dev_id='0bec824a-fa0d-468f-957c-1c0d89141310';
    $app_id='BrandonH-Finalfee-PRD-21e9cf7c1-de687d79';
    $cert_id='PRD-1e9cf7c123c0-043b-412c-b2c1-a82e';
    $site_id='0';
    $compat_level='967';
    $call_name='GetMyeBaySelling';
    $api_endpoint='https://api.ebay.com/ws/api.dll';
    $api_cred='AgAAAA**AQAAAA**aAAAAA**SqYxXQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AMk4unCJSLogidj6x9nY+seQ**aw4GAA**AAMAAA**GtT5uOiH3pYHPXsyKWJSqAR4rEgojKnFcJMypgAcR60l8MAatu1IZ9lCY08DWGW6F2NLilmjigyIo5zMWV+3divrZs4/9Kh2wioBKSQOhfyFznfatypsSVC1o3Ky0XQSeyWPuDYhNefVoDvF4vzPBOj1yVCVIusI3nXt64vYYZoEVWCJFjt8vYcKv9BcEsRgeWs78lAIPWzgrhhK/dtLUrMhlw9UFXpIpFbxfHb3fC1ARjdvqg4kNf0yMCfRXMPEown88hjHiWPnfTQBOG7KUDcqc4KJqZyX8WY5V2uVAW/JWC4RCoM+YVbE/YVscqymq15dBhm392Ec8bpz9U5QwNfa7z9EanbdF+cbowESf0I7NZci0Iwdewg2vodlcW5pWfYAojRhoI8r0o5DoJ/dYB5odsjAPrbRA4peHx9sEr4aNirJxaE2EAFRchMdP5S9EXsEjGsxXWZeQRI0d3+Yf4Fd9QNgD8tGFBYjHdIkRajs24FnWIkiLMAir5+2wDYgFrts707JWY2/Xbr/BIHH6pG4EkJR45pV8zRaG7pCJI2c8IeJkutXRzD3IjvYvk9UMHEdBb/yQNexkBEVHirGMRxozbzd0WLz59ltoCqMVw/+4DKeFbmRqzYq24/O9I4jakqoZsl/Qft6for9ZlDxBBzz0msa5JxTmfqmZeJ8ZttTqT9OFiDY6VIclJ6ICfR+vZYTV9YGNUW6JvCuZEqMIwmgYvhfkTYzZqiRJf7eOwSutn3KTegj+fxM+IRxDOOz';
    if(isset($_POST['active_select'])){
      $select_id=$_POST['active_select'];
      $ebay_accounts = DB::table('ebay_account')->where('id',$select_id)->get()->toArray();
      $api_cred=@$ebay_accounts[0]->user_token;
    }
    $headers = array(
      'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compat_level,
      'X-EBAY-API-DEV-NAME: ' . $dev_id,
      'X-EBAY-API-APP-NAME: ' . $app_id,
      'X-EBAY-API-CERT-NAME: ' . $cert_id,
      'X-EBAY-API-CALL-NAME: ' . $call_name,
      'X-EBAY-API-SITEID: ' . $site_id,
    );
    $xml_request='<?xml version="1.0" encoding="utf-8"?>
    <GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">
      <RequesterCredentials>
        <eBayAuthToken>'.$api_cred.'</eBayAuthToken>
      </RequesterCredentials>
        <ErrorLanguage>en_US</ErrorLanguage>
        <WarningLevel>High</WarningLevel>
      <ActiveList>
        <Sort>TimeLeft</Sort>
        <Pagination>
          <EntriesPerPage>200</EntriesPerPage>
          <PageNumber>1</PageNumber>
        </Pagination>
      </ActiveList>
    </GetMyeBaySellingRequest>';
    $connection = curl_init();
    curl_setopt($connection, CURLOPT_URL, $api_endpoint);
    curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($connection, CURLOPT_POST, 1);
    curl_setopt($connection, CURLOPT_POSTFIELDS, $xml_request);
    curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($connection);
    //print_r($response);
    $xml = simplexml_load_string($response); // assume XML in $x
    $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);

    $email_parent = auth()->user()->email;
    $ebay_account = DB::table('ebay_account')->where('parent_email', '=', "$email_parent")->get()->toArray();
    //$ebay_account = DB::table('ebay_account')->get()->toArray();
    if(isset($_POST['active_select'])){
      $select_id=$_POST['active_select'];
      //$ebay_account='';
      if( sizeof($array) == 0 ) {
        $ebay_account=array();
        return view('auto.widget.active',compact('array','ebay_account','select_id'))->render();
      }else{
        return view('auto.widget.active',compact('array','ebay_account','select_id'))->render();
      }
    }else{
      return view('auto.widget.active',compact('array','ebay_account'))->render();
    }
  }

  public function import(){
    $ruName = 'Brandon_Huynh-BrandonH-Finalf-kxqig';
    $dev_id='0bec824a-fa0d-468f-957c-1c0d89141310';
    $app_id='BrandonH-Finalfee-PRD-21e9cf7c1-de687d79';
    $cert_id='PRD-1e9cf7c123c0-043b-412c-b2c1-a82e';
    $site_id='0';
    $compat_level='967';
    $call_name='GetMyeBaySelling';
    $api_endpoint='https://api.ebay.com/ws/api.dll';
    $headers = array(
      'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compat_level,
      'X-EBAY-API-DEV-NAME: ' . $dev_id,
      'X-EBAY-API-APP-NAME: ' . $app_id,
      'X-EBAY-API-CERT-NAME: ' . $cert_id,
      'X-EBAY-API-CALL-NAME: ' . $call_name,
      'X-EBAY-API-SITEID: ' . $site_id,
    );
    $xml_request='<?xml version="1.0" encoding="utf-8"?>
    <GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">
      <RequesterCredentials>
        <eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**SqYxXQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AMk4unCJSLogidj6x9nY+seQ**aw4GAA**AAMAAA**GtT5uOiH3pYHPXsyKWJSqAR4rEgojKnFcJMypgAcR60l8MAatu1IZ9lCY08DWGW6F2NLilmjigyIo5zMWV+3divrZs4/9Kh2wioBKSQOhfyFznfatypsSVC1o3Ky0XQSeyWPuDYhNefVoDvF4vzPBOj1yVCVIusI3nXt64vYYZoEVWCJFjt8vYcKv9BcEsRgeWs78lAIPWzgrhhK/dtLUrMhlw9UFXpIpFbxfHb3fC1ARjdvqg4kNf0yMCfRXMPEown88hjHiWPnfTQBOG7KUDcqc4KJqZyX8WY5V2uVAW/JWC4RCoM+YVbE/YVscqymq15dBhm392Ec8bpz9U5QwNfa7z9EanbdF+cbowESf0I7NZci0Iwdewg2vodlcW5pWfYAojRhoI8r0o5DoJ/dYB5odsjAPrbRA4peHx9sEr4aNirJxaE2EAFRchMdP5S9EXsEjGsxXWZeQRI0d3+Yf4Fd9QNgD8tGFBYjHdIkRajs24FnWIkiLMAir5+2wDYgFrts707JWY2/Xbr/BIHH6pG4EkJR45pV8zRaG7pCJI2c8IeJkutXRzD3IjvYvk9UMHEdBb/yQNexkBEVHirGMRxozbzd0WLz59ltoCqMVw/+4DKeFbmRqzYq24/O9I4jakqoZsl/Qft6for9ZlDxBBzz0msa5JxTmfqmZeJ8ZttTqT9OFiDY6VIclJ6ICfR+vZYTV9YGNUW6JvCuZEqMIwmgYvhfkTYzZqiRJf7eOwSutn3KTegj+fxM+IRxDOOz</eBayAuthToken>
      </RequesterCredentials>
        <ErrorLanguage>en_US</ErrorLanguage>
        <WarningLevel>High</WarningLevel>
      <ActiveList>
        <Sort>TimeLeft</Sort>
        <Pagination>
          <EntriesPerPage>200</EntriesPerPage>
          <PageNumber>1</PageNumber>
        </Pagination>
      </ActiveList>
    </GetMyeBaySellingRequest>';
    $connection = curl_init();
    curl_setopt($connection, CURLOPT_URL, $api_endpoint);
    curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($connection, CURLOPT_POST, 1);
    curl_setopt($connection, CURLOPT_POSTFIELDS, $xml_request);
    curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($connection);
    //print_r($response);
    $xml = simplexml_load_string($response); // assume XML in $x
    $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);
    return view('auto.widget.import',compact('array'))->render();
  }


/*==============Etsy Start==============*/

public function etsyAuthentication(Request $request){
  $oauth = new OAuth($this->OAUTH_CONSUMER_KEY, $this->OAUTH_CONSUMER_SECRET);
}

public function sold_etsy(){
  return view('auto.widget.sold')->render();
}

public function active_etsy(Request $request){
  return view('auto.widget.active')->render();
}

public function import_etsy(){
  return view('auto.widget.import')->render();
}

public function create_acc_etsy(Request $request){

}

public function ebay_sold_item(Request $request){
    $email_parent = auth()->user()->email;
    $ebay_account = DB::table('ebay_account')->where('parent_email', '=', "$email_parent")->limit(1)->get()->toArray();
    return view('auto.ebay_sold',compact('ebay_account'))->with(['page'=>'ebay_auto']);;
}
// Start : creating the new sheet group
public function multinewsheet(Request $request){
    $fee_array = $request->fee_array;
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
                $sale->sale_date = $feeone['date'];
                $sale->platform = $feeone['platform'];
                $sale->quantity = $feeone['quantity'];
                $sale->name = $feeone['name'];
                $sale->currency = $feeone['currency'];
                $sale->sold_price = $feeone['sold_price'];
                $sale->item_cost = $feeone['item_cost'];
                $sale->shipping_charge = $feeone['shipping_charge'];
                $sale->shipping_cost = $feeone['shipping_cost'];
                $sale->fees = $feeone['fees'];
                $sale->other_fees = $feeone['other_fees'];
                $sale->processing_fees = $feeone['processing_fees'];
                $sale->tax = $feeone['tax'];
                $sale->profit = $feeone['profit'];
                if (Auth::user()->subscribed('main')) {
                    $sale->save();
                    // return response()->json(['status'=>'valid','message'=>'Added To Spreadsheet','color'=>'#d4edda','text'=>'#262626']);
                }else{
                    if ($sales_count < 25) {
                        $sale->save();
                        // return response()->json(['status'=>'valid','message'=>'Added To Spreadsheet','color'=>'#d4edda','text'=>'#262626']);
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

// END: creating new sheet group

public function autoebay_newsheet(Request $request){
      if ($request->ajax()) {

        $validator = \Validator::make($request->all(), [
            'action' => 'required',
            'spreadsheet_name'=>'required'
        ]);

        if (!$validator->fails()) {
            $saved = new Spreadsheet;
            $saved->user_id = Auth::id();
            $saved->spreadsheet_name = $request->spreadsheet_name;

            if (Auth::user()->subscribed('main')) {
                $saved->save();
                return response()->json([
                     "status"=>$this->popup($saved),
                     "account"=>"premium"
                ]);
            }else{
                $count = Spreadsheet::where('user_id', '=', Auth::id())->count();
                if ($count < 3) {
                    $saved->save();
                    return response()->json([
                         "status"=>$this->popup($saved),
                         "account"=>"regular"
                    ]);
                }else{
                    return response()->json([
                         "status"=>"error",
                         "account"=>"upgrade"
                    ]);
                }
            }
        }
    }
}

public function popup($saved){
    if ($saved) {
        return $status = "valid";
    }else{
         return $status = "error";
    }
 }

/*==============Etsy End==============*/

}