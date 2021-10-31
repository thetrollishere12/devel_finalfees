<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Spreadsheet;
use App\Sales;
use App\expense;
use App\User;
use DB;
use Mail;
use App\Mail\Message;
use Session;
use ReCaptcha\ReCaptcha;
use Redirect;

class PagesController extends Controller
{

    public function index(){
        $page = "index";
        return view('pages.index')->with('page',$page);
    }

    public function depop(){
        $page = "depop";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.depop')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.depop')->with(['page'=>$page]);
        }
    }

    public function paypal(){
        $page = "paypal";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.paypal')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.paypal')->with(['page'=>$page]);
        }
    }

    public function poshmark(){
        $page = "poshmark";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.poshmark')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.poshmark')->with(['page'=>$page]);
        }
    }

    public function ebay(){
        $page = "ebay";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.ebay')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.ebay')->with(['page'=>$page]);
        }
    }

    public function ebay_ca(){
        $page = "ebay";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.ebay-ca')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.ebay-ca')->with(['page'=>$page]);
        }
    }

    public function ebay_us(){
        $page = "ebay";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.ebay-us')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.ebay-us')->with(['page'=>$page]);
        }
    }

    public function ebay_au(){
        $page = "ebay";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.ebay-au')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.ebay-au')->with(['page'=>$page]);
        }
    }

    public function ebay_uk(){
        $page = "ebay";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.ebay-uk')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.ebay-uk')->with(['page'=>$page]);
        }
    }

    public function amazon(){
        $page = "amazon";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.amazon')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.amazon')->with(['page'=>$page]);
        }
    }

    public function fiverr(){
        $page = "fiverr";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.fiverr')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.fiverr')->with(['page'=>$page]);
        }
    }

    public function etsy(){
        $page = "etsy";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.etsy')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.etsy')->with(['page'=>$page]);
        }
    }

    public function grailed(){
        $page = "grailed";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.grailed')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.grailed')->with(['page'=>$page]);
        }
    }

    public function stockx(){
        $page = "stockx";

        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.stockx')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.stockx')->with(['page'=>$page]);
        }
    }

    public function goat(){
        $page = "goat";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.goat')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.goat')->with(['page'=>$page]);
        }
    }

    public function bonanza(){
        $page = "bonanza";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.bonanza')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.bonanza')->with(['page'=>$page]);
        }
    }

    public function tradesy(){
        $page = "tradesy";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.tradesy')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.tradesy')->with(['page'=>$page]);
        }
    }

    public function stripe(){
        $page = "stripe";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.stripe')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.stripe')->with(['page'=>$page]);
        }
    }

    public function mercari(){
        $page = "mercari";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.mercari')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.mercari')->with(['page'=>$page]);
        }
    }

    public function offerup(){
        $page = "offerup";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.offerup')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.offerup')->with(['page'=>$page]);
        }
    }

    public function letgo(){
        $page = "letgo";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.letgo')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.letgo')->with(['page'=>$page]);
        }
    }

    public function craigslist(){
        $page = "craigslist";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.craigslist')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.craigslist')->with(['page'=>$page]);
        }
    }

    public function facebook(){
        $page = "facebook";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.facebook')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.facebook')->with(['page'=>$page]);
        }
    }

    public function kijiji(){
        $page = "kijiji";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.kijiji')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.kijiji')->with(['page'=>$page]);
        }
    }

    public function ecrater(){
        $page = "ecrater";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.ecrater')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.ecrater')->with(['page'=>$page]);
        }
    }

    public function newegg(){
        $page = "newegg";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.newegg')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.newegg')->with(['page'=>$page]);
        }
    }

    public function chairish(){
        $page = "chairish";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.chairish')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.chairish')->with(['page'=>$page]);
        }
    }

    public function rubylane(){
        $page = "rubylane";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.rubylane')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.rubylane')->with(['page'=>$page]);
        }
    }

    public function ebid(){
        $page = "ebid";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.ebid')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.ebid')->with(['page'=>$page]);
        }
    }

    public function rakuten(){
        $page = "rakuten";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.rakuten')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.rakuten')->with(['page'=>$page]);
        }
    }

    public function refund(){
        $page = "refund";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.refund')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.refund')->with(['page'=>$page]);
        }
    }

    public function expense(){
        $page = "expense";
        if (Auth::check()) {
            $spreadsheet = DB::table('spreadsheets')->where('user_id', '=', Auth::id())->get();
            return view('pages.expense')->with(['page'=>$page,'spreadsheet'=>$spreadsheet]);
        }else{
            return view('pages.expense')->with(['page'=>$page]);
        }
    }

    public function error(){
        return view('pages.error');
    }

    public function company(){
        return view('pages.company')->with(['page'=>'index']);
    }

    public function tut_spreadsheet(){
        return view('tutorial.spreadsheet')->with(['page'=>'tut_spreadsheet']);
    }

    public function tut_auto(){
        return view('tutorial.automated')->with(['page'=>'tut_spreadsheet']);
    }

    public function tut_extension(){
        return view('tutorial.extension')->with(['page'=>'tut_spreadsheet']);
    }

    public function send_email(Request $request){

        $recaptcha = new ReCaptcha(env('GOOGLE_RECAPTCHA_SECRET_KEY'));
        $response = $recaptcha->verify($request->get('g-recaptcha-response'), $_SERVER['REMOTE_ADDR']);

        if ($response->isSuccess()) {
        
            if (!empty($request->description)) {
                Mail::to("help@finalfees.com")->send(new message($request));
                Session::flash('message','Email Sent');
                return redirect('/');
            }else{
                return redirect('/');
            }

        }else{
            return Redirect::back()->withErrors(['Please Complete', 'The Message']);
        }

      
    }

    public function list(Request $request){
        if ($request->ajax()) {
            $spreadsheet = Spreadsheet::where('user_id', '=', Auth::id())->get();
            return view('pg_widget.list')->with(['spreadsheet'=>$spreadsheet]);
        }else{
            return "Error";
        }
    }

    public function list_expense(Request $request){
        if ($request->ajax()) {
            $spreadsheet = Spreadsheet::where('user_id', '=', Auth::id())->get();
            return view('pg_widget.list_expense')->with(['spreadsheet'=>$spreadsheet]);
        }else{
            return "Error";
        }
    }

    public function list_refund(Request $request){
        if ($request->ajax()) {
            $spreadsheet = Spreadsheet::where('user_id', '=', Auth::id())->get();
            return view('pg_widget.list_refund')->with(['spreadsheet'=>$spreadsheet]);
        }else{
            return "Error";
        }
    }

    public function auto(){
        $page = "auto";
        return view('auto.index')->with(['page'=>$page]);
    }

    public function store(Request $request){
        
        $validator = \Validator::make($request->all(), [
            'spreadsheet_id' => 'required',
            'name'=>'required|max:20'
        ]);

        if (!$validator->fails()) {

            $spreadsheet_id = $request->spreadsheet_id;
            $count = Spreadsheet::where('user_id', '=', Auth::id())
            ->where('spreadsheet_id', '=', $spreadsheet_id)
            ->where('spreadsheet_name','=', $request->spreadsheet_name)
            ->count();
            $sales_count = DB::table('sales')
            ->where('user_id', '=', Auth::id())
            ->count();
            
            if ($count > 0) {
                $sale = new Sales;
                $sale->user_id = Auth::id();
                $sale->spreadsheet_id = $spreadsheet_id;
                $sale->sale_date = $request->date;
                $sale->platform = $request->platform;
                $sale->name = $request->name;
                $sale->currency = $request->currency;
                $sale->quantity = 1;
                $sale->sold_price = $request->sold_price;
                $sale->item_cost = $request->item_cost;
                $sale->shipping_charge = $request->shipping_charge;
                $sale->shipping_cost = $request->shipping_cost;
                $sale->fees = $request->fees;
                $sale->other_fees = $request->other_fees;
                $sale->processing_fees = $request->processing_fees;
                $sale->tax = $request->tax;
                $sale->profit = $request->profit;
                if (Auth::user()->subscribed('main')) {
                    $sale->save();
                    return response()->json(['status'=>'valid','message'=>'Added To Spreadsheet','color'=>'#d4edda','text'=>'#262626']);
                }else{
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

    public function store_expense(Request $request){
        
        $validator = \Validator::make($request->all(), [
            'spreadsheet_id' => 'required',
            'name'=>'required|max:20'
        ]);

        if (!$validator->fails()) {

            $spreadsheet_id = $request->spreadsheet_id;
            $count = Spreadsheet::where('user_id', '=', Auth::id())
            ->where('spreadsheet_id', '=', $spreadsheet_id)
            ->where('spreadsheet_name','=', $request->spreadsheet_name)
            ->count();
            $sales_count = DB::table('expenses')
            ->where('user_id', '=', Auth::id())
            ->count();
            
            if ($count > 0) {
                $sale = new expense;
                $sale->user_id = Auth::id();
                $sale->spreadsheet_id = $spreadsheet_id;
                $sale->date = $request->date;
                $sale->currency = $request->currency;
                $sale->name = $request->name;
                $sale->amount = $request->expense;
                $sale->description = $request->description;
                $sale->tax = $request->tax;
                $sale->account = $request->account;
                if (Auth::user()->subscribed('main')) {
                    $sale->save();
                    return response()->json(['status'=>'valid','message'=>'Added To Spreadsheet','color'=>'#d4edda','text'=>'#262626']);
                }else{
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
}