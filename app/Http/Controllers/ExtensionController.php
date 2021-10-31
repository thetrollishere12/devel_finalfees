<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Spreadsheet;
use App\Sales;
use App\extensionsale;

class ExtensionController extends Controller
{
    public function index(){

        return view('auto.extension.extension')->with(['page'=>'extension']);;
    }

    public function ajax(){
        $poshsales = DB::table('extensionsales')->where('user_id', '=',Auth::id())->where('platform','poshmark')->get();
        $grailedsales = DB::table('extensionsales')->where('user_id', '=',Auth::id())->where('platform','grailed')->get();
        $depopsales = DB::table('extensionsales')->where('user_id', '=',Auth::id())->where('platform','depop')->get();

        return view('auto.extension.extension-sale',['poshsales'=>$poshsales,'grailedsales'=>$grailedsales,'depopsales'=>$depopsales]);
    }

    public function post(Request $request){

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

  
                switch ($feeone['currency']) {
                  case "USD":
                    $currency = "$";
                    break;
                  case "CAD":
                    $currency = "C$";
                    break;
                  case "EUR":
                    $currency = "€";
                    break;
                  default:
                    $currency = "$";
                }


                if ($count > 0) {
                    $sale = new Sales;
                    $sale->user_id = Auth::id();
                    $sale->sales_id ="";
                    $sale->item_id = $feeone['item_id'];
                    $sale->spreadsheet_id = $spreadsheet_id;
                    $sale->sale_date = $feeone['date'];
                    $sale->platform = $feeone['platform'];
                    $sale->quantity =$feeone['quantity'];
                    $sale->name = $feeone['name'];
                    $sale->currency = $currency;
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
                        $delete = extensionsale::where('user_id', '=', Auth::id())->where('id', '=', $feeone['extension_id'])->where('order_id','=', $feeone['item_id'])->delete();
                        // return response()->json(['status'=>'valid','message'=>'Added To Spreadsheet','color'=>'#d4edda','text'=>'#262626']);
                    }else{
                        if ($sales_count < 25) {
                            $delete = extensionsale::where('user_id', '=', Auth::id())->where('id', '=', $feeone['extension_id'])->where('order_id','=', $feeone['item_id'])->delete();
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

    public function delete(Request $request){

        extensionsale::whereIn('id',$request->id)->delete();

        return response()->json(['status'=>'valid','message'=>'Deleted From Spreadsheet','color'=>'rgba(226, 40, 58, .9)','text'=>'white']);

    }

}
