<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Session;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getProductDetails($product_id)
    {
        $product=DB::table('tbl_product')
                        ->where([
						    ['product_id', $product_id],
						    ['business_id',Auth::user()->id],
						])
                        ->first();
        if ($product!=null) {
            if ($product->product_quantity != 0) {
                $perCost = $product->product_cost / $product->product_quantity;
            }else{
                $perCost= 0.00;
            }
        	
        	return view ('product_details', [ 'product' => $product, 'perCost' => $perCost]);
        }else{
        	return "No product found";
        }
    }



    //Add product on existing product field--------------
    public function add_more_product(Request $request, $id){

        $dt = Carbon::now('Asia/Dhaka');
        if ($dt->month==1) {
            $pre_month=12;
        }else{
            $pre_month=$dt->month - 1;
        }

        $product=DB::table('tbl_product')
                        ->where([
                            ['product_id', $id],
                            ['business_id',Auth::user()->id],
                        ])
                        ->first();
        if ($product!=null) {
            $qty=$product->product_quantity + $request->qty;
            $cost=$product->product_cost + $request->cost;
            $rate=$request->rate;
        }else{
            return "No product found"; //return home
        }
    	
        $data= array();
        $data['product_quantity']=$qty;
        $data['product_cost']=$cost;
        $data['product_rate']=$rate;

        $profit = DB::table('tbl_profit')
                ->where([
                            ['time_num', $dt->month],
                            ['business_id',Auth::user()->id],
                        ])
                ->first();
        $pre_profit = DB::table('tbl_profit')
                ->where([
                            ['time_num', $pre_month],
                            ['business_id',Auth::user()->id],
                        ])
                ->first();
        $yr_profit = DB::table('tbl_profit')
                ->where([
                            ['time_num', '13'],
                            ['business_id',Auth::user()->id],
                        ])
                ->first();
        $total_cost= $pre_profit->remaining + $profit->total_cost + $request->cost;
        $currentRemaining=$pre_profit->remaining+$profit->remaining+$request->cost;
        $yr_cost=$yr_profit->total_cost + $request->cost;
        $yr_remaining=$yr_profit->remaining+$request->cost;
        // dd($total_cost);
        // dd($currentRemaining);
        DB::table('tbl_profit')
                ->where([
                            ['time_num', $dt->month],
                            ['business_id',Auth::user()->id],
                        ])
                ->update(['total_cost'=> $total_cost,
                            'remaining'=> $currentRemaining]);
                // dd($total_cost);
        if ($pre_profit->remaining != 0) {
            DB::table('tbl_profit')
                ->where([
                            ['time_num', $pre_month],
                            ['business_id',Auth::user()->id],
                        ])
                ->update(['remaining'=> 0]);
        }
        DB::table('tbl_profit')
                ->where([
                            ['time_num', '13'],
                            ['business_id',Auth::user()->id],
                        ])
                ->update(['total_cost'=> $yr_cost,
                            'remaining'=> $yr_remaining]);
        // dd($request->cost);
        
        DB::table('tbl_product')
        		->where('product_id', $id)
        		->update($data);
        Session::put('product_message','Product added sucsessfully!!!');
        return redirect()->route('product_details', [$id]);
    }

    

    public function priority_update(Request $request, $id){
    	if ($request->priority!=0) {
    		DB::table('tbl_product')
        		->where([
						    ['priority', '>=', $request->priority],
						    ['business_id',Auth::user()->id],
						])
        		->increment('priority', 1);
    	}
    	

    	$data= array();
        $data['priority']=$request->priority;
        // dd($data['product_quantity']);
        DB::table('tbl_product')
        		->where('product_id', $id)
        		->update($data);
        Session::put('product_message','Product added sucsessfully!!!');
        return redirect()->route('product_details', [$id]);
    }

    //return product field--------------
    public function return_product(Request $request, $id){
        // dd($id);
        $product=DB::table('tbl_product')
                        ->where([
                            ['product_id', $id],
                            ['business_id',Auth::user()->id],
                        ])
                        ->first();
        if ($product!=null) {
            $qty=$product->product_quantity;
            $cost=$product->product_cost;
            if ($qty != 0) {
                $perCost = $cost / $qty;
            }else{
                $perCost= 0.00;
            }
            // $perCost = $cost / $qty;
        }else{
            return "No product found";
        }
        $dt = Carbon::now('Asia/Dhaka');

        $r_qty=$request->return_qty;
        $r_price=$request->return_price;
        $r_cost=$perCost*$r_qty;
        $r_profit=$r_price-$r_cost;

        $product_data= array();
        $product_data['product_quantity']=$qty+$r_qty;
        $product_data['product_cost']=$cost+$r_cost;

        $profit = DB::table('tbl_profit')
                ->where([
                            ['time_num', $dt->month],
                            ['business_id',Auth::user()->id],
                        ])
                ->first();
        $profit_data= array();
        $profit_data['total_sale']=$profit->total_sale-$r_price;
        $profit_data['total_profit']=$profit->total_profit-$r_profit;
        $profit_data['remaining']=$profit->remaining+$r_cost;

        $yr_profit = DB::table('tbl_profit')
                ->where([
                            ['time_num', '13'],
                            ['business_id',Auth::user()->id],
                        ])
                ->first();
        $profit_yr= array();
        $profit_yr['total_sale']=$yr_profit->total_sale-$r_price;
        $profit_yr['total_profit']=$yr_profit->total_profit-$r_profit;
        $profit_yr['remaining']=$yr_profit->remaining+$r_cost;

        DB::table('tbl_profit')
                ->where([
                            ['time_num', $dt->month],
                            ['business_id',Auth::user()->id],
                        ])
                ->update($profit_data);
        DB::table('tbl_profit')
                ->where([
                            ['time_num', '13'],
                            ['business_id',Auth::user()->id],
                        ])
                ->update($profit_yr);

        DB::table('tbl_product')
                ->where('product_id', $id)
                ->update($product_data);
        Session::put('product_message','Product added sucsessfully!!!');
        return redirect()->route('product_details', [$id]);
    }
}
