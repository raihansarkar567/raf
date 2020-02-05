<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Cart;
use Session;
use DB;

class DueController extends Controller
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

    public function index()
    {
    	if (!Session::has('cart')) {
    		$d_info = DB::table('tbl_due_amo')
    		->where('bus_id',Auth::user()->id)
    		->orderBy('d_ac_name')
    		->get();
// dd($d_info);
    		return view ('due', ['d_info' => $d_info]);
    	}
    	$oldCart = Session::get('cart');
    	$cart= new Cart($oldCart);
        // dd($cart->items);
        // $dt = Carbon::now('Asia/Dhaka');
    	$d_info = DB::table('tbl_due_amo')
    	->where('bus_id',Auth::user()->id)
    	->orderBy('d_ac_name')
    	->get();
// dd($d_info);
    	return view ('due', [ 'products' => $cart->items, 'totalPrice' => $cart->totalPrice, 'd_info' => $d_info]);

    }

    public function addDueAccount(Request $request)
    {
    	$data= array();
    	$data['d_ac_name']=$request->due_name;
    	$data['d_ac_mobile']=$request->due_num;
    	$data['d_total_amo']='0';
    	$data['d_last_paid_amo']='0';
    	$data['d_last_due_amo']='0';
    	$data['bus_id']=Auth::user()->id;

    	DB::table('tbl_due_amo')->insert($data);
    	Session::put('product_message','Product added sucsessfully!!!');
    	return Redirect::to('/due_checkout');

    }

    public function submitDueCheckout(Request $request){
    	if (!Session::has('cart')) {
    		return view ('shopping_cart');
    	}
    	$oldCart = Session::get('cart');
    	$cart= new Cart($oldCart);

    	// print_r($cart->items[1]['item']->product_name);
    	$length = count($cart->items);
    	// print_r($length);
		// print_r($cart->items);

      foreach ($cart->items as $value) {
        $product = DB::table('tbl_product')
        ->where('product_id',$value['item']->product_id)
        ->first();

			// print_r($value['item'] -> product_name);
        $perCost= $product->product_cost/$product->product_quantity;

        $data= array();
        $data['product_quantity']=$product->product_quantity - $value['qty'];
        $data['product_cost']=$product->product_cost - ($value['qty']*$perCost);
        DB::table('tbl_product')
        ->where('product_id',$value['item']->product_id)
        ->update($data);

            // get prifit table
        $dt = Carbon::now('Asia/Dhaka');
        if ($dt->month==1) {
            $pre_month=12;
        }else{
            $pre_month=$dt->month - 1;
        }
        $pre_profit = DB::table('tbl_profit')
        ->where([
            ['time_num', $pre_month],
            ['business_id',Auth::user()->id],
        ])
        ->first();
        $profit = DB::table('tbl_profit')
        ->where([
            ['time_num', $dt->month],
            ['business_id',Auth::user()->id],
        ])
        ->first();
        $yr_profit = DB::table('tbl_profit')
        ->where([
            ['time_num', '13'],
            ['business_id',Auth::user()->id],
        ])
        ->first();
        $totalSale=$profit->total_sale+$value['price'];
        $totalProfit=$profit->total_profit+($value['price']-($value['qty']*$perCost));
        $sale_yr=$yr_profit->total_sale+$value['price'];
        $profit_yr=$yr_profit->total_profit+($value['price']-($value['qty']*$perCost));

            // dd($currentRemaining);
            // Update profit table
        if ($pre_profit->remaining != 0) {
            $currentRemaining=($profit->remaining - ($value['qty']*$perCost))+$pre_profit->remaining;
            $currentRemaining_yr=$yr_profit->remaining - ($value['qty']*$perCost);
            $totalCost=$profit->total_cost+$pre_profit->remaining;
            DB::table('tbl_profit')
            ->where([
                ['time_num', $dt->month],
                ['business_id',Auth::user()->id],
            ])
            ->update(['total_cost'=> $totalCost,
                'total_sale'=> $totalSale,
                'total_profit'=> $totalProfit,
                'remaining'=> $currentRemaining]);
            DB::table('tbl_profit')
            ->where([
                ['time_num', $pre_month],
                ['business_id',Auth::user()->id],
            ])
            ->update(['remaining'=> 0]);
            DB::table('tbl_profit')
            ->where([
                ['time_num', '13'],
                ['business_id',Auth::user()->id],
            ])
            ->update(['total_sale'=> $sale_yr,
                'total_profit'=> $profit_yr,
                'remaining'=> $currentRemaining_yr]);
        }
        else{
            $currentRemaining=$profit->remaining - ($value['qty']*$perCost);
            $currentRemaining_yr=$yr_profit->remaining - ($value['qty']*$perCost);
            DB::table('tbl_profit')
            ->where([
                ['time_num', $dt->month],
                ['business_id',Auth::user()->id],
            ])
            ->update(['total_sale'=> $totalSale,
                'total_profit'=> $totalProfit,
                'remaining'=> $currentRemaining]);

            DB::table('tbl_profit')
            ->where([
                ['time_num', '13'],
                ['business_id',Auth::user()->id],
            ])
            ->update(['total_sale'=> $sale_yr,
                'total_profit'=> $profit_yr,
                'remaining'=> $currentRemaining_yr]);
        }

    }
    // due update
    $due = DB::table('tbl_due_amo')
        ->where([
            ['d_ac_name', $request->due_name],
            ['bus_id',Auth::user()->id],
        ])
        ->first();

    $lastDue = $request->total_amount - $request->money_paid;
    $totalDue = $due->d_total_amo + $lastDue;

    // $data= array();
    	// $data['d_ac_name']=$request->due_name;
    	// $data['updated_at']=$request->date_time;
    	// $data['d_total_amo']=$totalDue;
    	// $data['d_last_paid_amo']=$request->money_paid;
    	// $data['d_last_due_amo']=$lastDue;
    	// $data['bus_id']=Auth::user()->id;

    	DB::table('tbl_due_amo')
            ->where([
	                ['d_ac_name', $request->due_name],
	                ['bus_id',Auth::user()->id],
            	])
            ->update(['d_total_amo'=> $totalDue,
                'd_last_paid_amo'=> $request->money_paid,
                'd_last_due_amo'=> $lastDue]);

    	// DB::table('tbl_due_amo')
     //    		->where([
	    //             ['d_ac_name', $request->due_name],
	    //             ['bus_id',Auth::user()->id],
     //        	])
     //    		->update($data);

    Session::forget('cart');
    return Redirect::to('/home');

}

	public function submitDuePaid(Request $request, $name)
    {
    	$lastPaid = $request->payNow;
        $totalDue = $request->total_due - $request->payNow;
        // dd($totalDue);
        $data= array();
    	$data['d_total_amo']=$totalDue;
    	$data['d_last_paid_amo']=$lastPaid;

        DB::table('tbl_due_amo')
            ->where([
	                ['bus_id',Auth::user()->id],
	                ['d_ac_name', $name],
            	])
            ->update($data);

        return redirect()->route('due');
    }


}
