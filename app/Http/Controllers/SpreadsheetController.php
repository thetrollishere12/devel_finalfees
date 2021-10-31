<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Spreadsheet;
use App\Sales;
use App\expense;
use DB;
use PDF;
use File;
use Carbon\Carbon;

class SpreadsheetController extends Controller
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

    /**
     * Display spreadsheet.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {   
            $page = "spreadsheet";
            return view('spreadsheet.index')->with(['page'=>$page]);
    }

    /**
    * Query.
    * @param  int $request->spreadsheet_id
    * @return \Illuminate\Http\Response
    * @param  \Illuminate\Http\Request $request
    */

    private function query($request){
         $query  = DB::table('sales')
        ->where('user_id', '=', Auth::id())
        ->whereBetween('sale_date',[$request->start_date, $request->end_date])
        ->orderBy($request->sort,$request->sort_order)
        ->where('name','LIKE',"%{$request->name}%");

        // $expense = DB::table('expenses')
        // ->where('user_id', '=', Auth::id())
        // ->whereBetween('sale_date',[$request->start_date, $request->end_date])
        // ->orderBy($request->sort,$request->sort_order)
        // ->where('name','LIKE',"%{$request->name}%");
        $expense = DB::table('expenses')
        ->where('user_id', '=', Auth::id())
        ->whereBetween('date',[$request->start_date, $request->end_date]);

        if (Auth::user()->subscribed('main')) {
           if ($request->sheet_sum == "summary-page") {
                $sales = $query->get();
                $limit = $query->paginate(25);
                $ex = $expense->get();
                $exlimit = $expense->paginate(25);
           }else{
                $sales = $query->where('spreadsheet_id', '=', $request->spreadsheet_id)->get();
                $limit = $query->where('spreadsheet_id', '=', $request->spreadsheet_id)->paginate(25);
                $ex = $expense->where('spreadsheet_id', '=', $request->spreadsheet_id)->get();
                $exlimit = $expense->where('spreadsheet_id', '=', $request->spreadsheet_id)->paginate(25);
           }
        }else{
            if ($request->sheet_sum == "summary-page") {
                $sales = $query->take(25)->get();
                $limit = $query->paginate(25);
                $ex = $expense->take(25)->get();
                $exlimit = $expense->paginate(25);
           }else{
                $sales = $query->where('spreadsheet_id', '=', $request->spreadsheet_id)->take(25)->get();
                $limit = $query->where('spreadsheet_id', '=', $request->spreadsheet_id)->paginate(25);
                $ex = $expense->where('spreadsheet_id', '=', $request->spreadsheet_id)->take(25)->get();
                $exlimit = $expense->where('spreadsheet_id', '=', $request->spreadsheet_id)->paginate(25);
           }
        } 
        return array(
        'sales'=>$sales,
        'limit'=>$limit,
        'expense'=>$ex,
        'exlimit'=>$exlimit
        );
    }

    /**
    * Selecting Spreadsheet.
    * @param  int $request->spreadsheet_id
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */

    public function select(Request $request){

        if ($request->spreadsheet_id && $request->ajax()) { 

           $query = $this->query($request);
            return response()->json([
                "sales"=> $this->numbers($query['sales']),
                "limit"=> $this->grid($query['limit'],$query['sales']),
                "expense"=>$this->exnumbers($query['expense']),
                "exlimit"=> $this->gridexpense($query['exlimit'],$query['expense'])
            ]);

        }       

    }


    public function gridexpense($limit,$sales){
        if ($sales->count()>0) {
            return view('pg_widget.expense', compact('limit'))->render();
        }else{
            return "<a href='expense'><button id='emp' class='empty_btn'>Enter Expense</button></a>";
        }
    }

    public function exnumbers($sales){
        if ($sales->count()>0) {

            return array(
                'status'=> 'valid',
                'spreadsheet_ex'=>array(
                "expense"=>$sales->sum('amount')+$sales->sum('tax')
                )
            );

        }else{

            return array(
                'status' => 'empty',
                'spreadsheet_ex'=>array(
                "expense"         =>0.00
                )
            );
        }
    }

    /**
    * Paginating Spreadsheets.
    * @param  int $request->spreadsheet_id
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */

    public function paginate(Request $request){
        if($request->ajax()){

            $query = $this->query($request);
            return $this->grid($query['limit'],$query['sales']);

        }
            
    }

    public function paginate_ex(Request $request){
        if($request->ajax()){

            $query = $this->query($request);
            return $this->gridexpense($query['exlimit'],$query['expense']);

        }
            
    }

    /**
    * Deleting a sale.
    * @param  int $request->spreadsheet_id
    * @param  int $request->item_id
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */

    public function delete_sale(Request $request){

        $validator = \Validator::make($request->all(), [
            'action' => 'required',
            'item_id'=>'required'
        ]);

        if (!$validator->fails() && $request->ajax()) {
        $saved = Sales::where('id',$request->item_id)->where('spreadsheet_id', $request->spreadsheet_id)->delete();

            if ($saved) {

            $query = $this->query($request);
            
            return response()->json([
                "sales"=> $this->numbers($query['sales']),
                "limit"=> $this->grid($query['limit'],$query['sales']),
                "expense"=>$this->exnumbers($query['expense']),
                "exlimit"=> $this->gridexpense($query['exlimit'],$query['expense'])
            ]);

            }

        }

    }

    public function delete_expense(Request $request){

        $validator = \Validator::make($request->all(), [
            'action' => 'required',
            'item_id'=>'required'
        ]);

        if (!$validator->fails() && $request->ajax()) {
        $saved = expense::where('id',$request->item_id)->where('spreadsheet_id', $request->spreadsheet_id)->delete();

            if ($saved) {

            $query = $this->query($request);
            
            return response()->json([
                "sales"=> $this->numbers($query['sales']),
                "limit"=> $this->grid($query['limit'],$query['sales']),
                "expense"=>$this->exnumbers($query['expense']),
                "exlimit"=> $this->gridexpense($query['exlimit'],$query['expense'])
            ]);

            }

        }

    }

    /**
    * Editing a sale.
    * @param  int $request->spreadsheet_id
    * @param  int $request->item_id
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */

    public function edit_sale(Request $request){

        $validator = \Validator::make($request->all(), [
            'action' => 'required',
            'item_id'=>'required'
        ]);

        if (!$validator->fails() && $request->ajax()) {
            $saved = new Sales;
            $saved = Sales::find($request->item_id);
            // if ($saved->profit != $request->profit) {
            //     $profit = $request->profit;
            // }else{
            //     $profit = ($request->sold_price+$request->shipping_charge)-($request->item_cost+$request->shipping_cost+$request->fees+$request->other_fees+$request->processing_fees+$request->tax);
            // }
            $saved->spreadsheet_id = $request->spreadsheet_id;
            $saved->sale_date = $request->date;
            $saved->currency = $request->currency;
            $saved->name = $request->itm_name;
            $saved->sold_price = $request->name;
            $saved->sold_price = $request->sold_price;
            $saved->item_cost = $request->item_cost;
            $saved->shipping_charge = $request->shipping_charge;
            $saved->shipping_cost = $request->shipping_cost;
            $saved->fees = $request->fees;
            $saved->other_fees = $request->other_fees;
            $saved->processing_fees = $request->processing_fees;
            $saved->tax = $request->tax;
            $saved->profit = ($request->sold_price+$request->shipping_charge)-($request->item_cost+$request->shipping_cost+$request->fees+$request->other_fees+$request->processing_fees+$request->tax);
            $saved->save();
            if ($saved) {

                $query = $this->query($request);

                return [
                    "sales" => $this->numbers($query['sales']),
                    "expense" => $this->exnumbers($query['expense'])
                ];

            }
        }
    }

    public function edit_expense(Request $request){

        $validator = \Validator::make($request->all(), [
            'action' => 'required',
            'item_id'=>'required'
        ]);

        if (!$validator->fails() && $request->ajax()) {
            $saved = new expense;
            $saved = expense::find($request->item_id);
            $saved->spreadsheet_id = $request->spreadsheet_id;
            $saved->date = $request->date;
            $saved->currency = $request->currency;
            $saved->name = $request->itm_name;
            $saved->amount = $request->amount;
            $saved->description = $request->description;
            $saved->account = $request->account;
            $saved->tax = $request->tax;
            $saved->save();

            if ($saved) {

                $query = $this->query($request);

                return [
                    "sales" => $this->numbers($query['sales']),
                    "expense" => $this->exnumbers($query['expense'])
                ];

            }
        }
    }


    /**
    * Getting Spreadsheet List.
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */

    public function sheet_list(Request $request){
        if ($request->ajax()) {
        
            if (Auth::user()->subscribed('main')) {
                $spreadsheet = Spreadsheet::where('user_id', '=', Auth::id());
            }else{
                $spreadsheet = Spreadsheet::where('user_id', '=', Auth::id())->take(3);
            }

            return response()->json([
                'list'=>$spreadsheet->get()->toArray()
            ]);
        }
    }

    /**
    * Storing a List.
    * @param  int $request->spreadsheet_id
    * @param  int $request->item_id
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
                 
    public function store(Request $request){
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

    /**
    * Updating a List.
    * @param  int $request->spreadsheet_id
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */

    public function list_update(Request $request){
  
        $validator = \Validator::make($request->all(), [
            'action' => [
                'required',
                Rule::in(["Save"])
            ],
            'new_name'=>'required'
        ]);

        if (!$validator->fails() && $request->ajax()) {

            if ($request->action === "Save") {
                $saved = Spreadsheet::where('spreadsheet_id',$request->spreadsheet_id)
                ->where('user_id', Auth::id())
                ->update(['spreadsheet_name'=>$request->new_name]);
                return $this->popup($saved);
            }
        }
    }

    /**
    * Deleting a List.
    * @param  int $request->spreadsheet_id
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */

    public function list_delete(Request $request){

        $validator = \Validator::make($request->all(), [
            'action' => [
                'required',
                Rule::in(['Delete List',"Save"])
            ],
            'spreadsheet_name'=>'required'
        ]);

        if (!$validator->fails() && $request->ajax()) {

            if ($request->action === "Delete List") {
                $saved = Spreadsheet::where('spreadsheet_id',$request->spreadsheet_id)
                ->where('user_id', Auth::id())
                ->where('spreadsheet_name', $request->spreadsheet_name)->delete();

                Sales::where('spreadsheet_id',$request->spreadsheet_id)
                ->where('user_id', Auth::id())->delete(); 
                
                return $this->popup($saved);
            }  
        }
    }

    public function numbers($sales){
        if ($sales->count()>0) {

            return array(
                'status'=> 'valid',
                'spreadsheet_sales'=>array(
                "sales"          =>$sales->count(),
                "sold_price"     =>$sales->sum('sold_price'),
                "shipping_charge"=>$sales->sum('shipping_charge'),
                "item_cost"      =>$sales->sum('item_cost'),
                "shipping_cost"  =>$sales->sum('shipping_cost'),
                "fees"           =>$sales->sum('fees')+$sales->sum('other_fees'),
                "p_fees"         =>$sales->sum('processing_fees'),
                "tax"            =>$sales->sum('tax'),
                "profit"         =>$sales->sum('profit')
                )
            );

        }else{

            return array(
                'status' => 'empty',
                'spreadsheet_sales'=>array(
                "sales"          =>0,
                "sold_price"     =>0.00,
                "shipping_charge"=>0.00,
                "item_cost"      =>0.00,
                "shipping_cost"  =>0.00,
                "fees"           =>0.00,
                "other_fees"     =>0.00,
                "p_fees"         =>0.00,
                "tax"            =>0.00,
                "profit"         =>0.00
                )
            );
        }
    }

    public function grid($limit,$sales){
        if ($sales->count()>0) {
            return view('pg_widget.sales', compact('limit'))->render();
        }else{
            return "<a href='company'><button id='emp' class='empty_btn'>Empty</button></a>";
        }
     }

    /**
    * Get Monthly Stats.
    * @param  int $request->id
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */

    public function yearly(Request $request){
        if (Auth::user()->subscribed('main')) {
            
            if ($request->sheet_sum == "summary-page") {
                if ($request->type == "total_fees") {
                    for ($i=1; $i <= 12; $i++) { 
                        $out[] = Sales::whereMonth('sale_date', date($i))
                        ->whereYear('sale_date','=',$request->year)
                        ->where('user_id', Auth::id())
                        ->sum(\DB::raw('fees+other_fees+processing_fees+tax'));
                    }
                }elseif($request->type == "expense"){
                    for ($i=1; $i <= 12; $i++) { 
                        $out[] = expense::whereMonth('date', date($i))
                        ->whereYear('date','=',$request->year)
                        ->where('user_id', Auth::id())
                        ->sum(\DB::raw('amount+tax'));
                    }
                }else{
                    for ($i=1; $i <= 12; $i++) { 
                        $out[] = Sales::whereMonth('sale_date', date($i))
                        ->whereYear('sale_date','=',$request->year)
                        ->where('user_id', Auth::id())
                        ->sum($request->type);
                    }
                }
            }else{
            
                if ($request->type == "total_fees") {
                    for ($i=1; $i <= 12; $i++) { 
                        $out[] = Sales::whereMonth('sale_date', date($i))
                        ->where('spreadsheet_id',$request->id)
                        ->whereYear('sale_date','=',$request->year)
                        ->where('user_id', Auth::id())
                        ->sum(\DB::raw('fees+other_fees+processing_fees+tax'));
                    }
                }elseif($request->type == "expense"){
                    for ($i=1; $i <= 12; $i++) { 
                        $out[] = expense::whereMonth('date', date($i))
                        ->whereYear('date','=',$request->year)
                        ->where('user_id', Auth::id())
                        ->sum(\DB::raw('amount+tax'));
                    }
                }else{
                    for ($i=1; $i <= 12; $i++) { 
                        $out[] = Sales::whereMonth('sale_date', date($i))
                        ->where('spreadsheet_id',$request->id)
                        ->whereYear('sale_date','=',$request->year)
                        ->where('user_id', Auth::id())
                        ->sum($request->type);
                    }
                }
            }
            return $out;
            
        }else{
            return null;
        }
    }

    public function popup($saved){
       if ($saved) {
           return $status = "valid";
       }else{
            return $status = "error";
       }
    }

    public function year_break(){
        $page = "yearbreak";
        return view('spreadsheet.yearly')->with(['page'=>$page]);
    }

    public function year_req(Request $request){
        

        if ($request->sheet_sum == "summary-page") {
        $query  = DB::table('sales')
        ->where('user_id', '=', Auth::id())->where('sale_date','LIKE','%'.date("Y").'%')->get();
        $ex = DB::table('expenses')
        ->where('user_id', '=', Auth::id())->where('date','LIKE','%'.date("Y").'%')->get();
        }else{
        $query  = DB::table('sales')
        ->where('user_id', '=', Auth::id())->where('sale_date','LIKE','%'.date("Y").'%')->where('spreadsheet_id',$request->spreadsheet_id)->get();
        $ex = DB::table('expenses')
        ->where('user_id', '=', Auth::id())->where('date','LIKE','%'.date("Y").'%')->where('spreadsheet_id',$request->spreadsheet_id)->get();
        }

        return [
            "sales" => $query,
            "expense" => $ex
        ];
    }

    public function download(Request $request){

             $query  = DB::table('sales')
            ->where('user_id', '=', Auth::id())
            ->whereBetween('sale_date',[$request->start_date, $request->end_date])
            ->orderBy($request->sort,$request->sort_order)
            ->where('name','LIKE',"%{$request->name}%");

            $expense = DB::table('expenses')
            ->where('user_id', '=', Auth::id())
            ->whereBetween('date',[$request->start_date, $request->end_date]);

            if (Auth::user()->subscribed('main')) {
               if ($request->sheet_sum == "summary-page") {
                    $sales = $query->get();
                    $limit = $query->paginate(25);
                    $ex = $expense->get();
                    $exlimit = $expense->paginate(25);
               }else{
                    $sales = $query->where('spreadsheet_id', '=', $request->spreadsheet_id)->get();
                    $limit = $query->where('spreadsheet_id', '=', $request->spreadsheet_id)->paginate(25);
                    $ex = $expense->where('spreadsheet_id', '=', $request->spreadsheet_id)->get();
                    $exlimit = $expense->where('spreadsheet_id', '=', $request->spreadsheet_id)->paginate(25);
               }
            }else{
                if ($request->sheet_sum == "summary-page") {
                    $sales = $query->take(25)->get();
                    $limit = $query->paginate(25);
                    $ex = $expense->take(25)->get();
                    $exlimit = $expense->paginate(25);
               }else{
                    $sales = $query->where('spreadsheet_id', '=', $request->spreadsheet_id)->take(25)->get();
                    $limit = $query->where('spreadsheet_id', '=', $request->spreadsheet_id)->paginate(25);
                    $ex = $expense->where('spreadsheet_id', '=', $request->spreadsheet_id)->take(25)->get();
                    $exlimit = $expense->where('spreadsheet_id', '=', $request->spreadsheet_id)->paginate(25);
               }
            }

            $array = array(
                'sales'=>$sales,
                'limit'=>$limit,
                'expense'=>$ex,
                'exlimit'=>$exlimit
            );

            $sku=str_replace([' ',':'],'-',Carbon::now()->addDays(1)->format('d-m H:i:s:u'));

            $codes = 'id='.Auth::id().uniqid().'e='.$sku;

            $fp = fopen(storage_path()."/download/".$codes.".csv", 'wb');

            $columns = array('Sales');
            fputcsv($fp,$columns);

            $columns = array('Date','Platform','Currency','Quantity','Name','Sold Price','Item Cost','Shipping Charge','Shipping Cost','Fees','Other Fees','Processing Fee','Tax','Profit');
            fputcsv($fp,$columns);

            foreach ($array['sales'] as $key => $value) {
                $columns = array($value->sale_date,$value->platform,$value->currency,$value->quantity,$value->name,$value->sold_price,$value->item_cost,$value->shipping_charge,$value->shipping_cost,$value->fees,$value->other_fees,$value->processing_fees,$value->tax,$value->profit);
                fputcsv($fp,$columns);
            }

            $columns = [];
            fputcsv($fp,$columns);

            $columns = array('Expenses');
            fputcsv($fp,$columns);

            $columns = array('Date','Currency','Name','Description','Amount','Tax','Account');
            fputcsv($fp,$columns);

            foreach ($array['expense'] as $key => $value) {
                $columns = array($value->date,$value->currency,$value->name,$value->description,$value->amount,$value->tax,$value->account);
                fputcsv($fp,$columns);
            }


            fclose($fp);

            return response()->download(storage_path()."/download/".$codes.".csv");

    }




}


