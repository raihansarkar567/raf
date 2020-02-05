<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Session;
use Carbon\Carbon;

class CartController extends Controller
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

    public function getAddToCart(Request $request, $product_id)
    {
        $products=DB::table('tbl_product')
        ->where('product_id', $product_id)
        ->first();
        // $products_id=DB::table('tbl_product')
        //                 ->where('product_id', $product_id)
        //                 ->first()->business_id;
        
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->addCart($products, $products->product_id);

        // $request->session()->put('cart' $cart);

        // dd($request->session()->get('cart'));

        Session::put('cart', $cart);

        // dd(Session::get('cart'));

        return redirect()->route('home');
           // print_r($products->product_id);
        // return $products_id;
    }


    public function getCart(){
    	if (!Session::has('cart')) {
    		return view ('shopping_cart');
    	}
    	$oldCart = Session::get('cart');
    	$cart= new Cart($oldCart);
    	// dd($cart->items);
    	return view ('shopping_cart', [ 'products' => $cart->items, 'totalPrice' => $cart->totalPrice ]);
    }

    // add value from input form-----------------------------------------

    public function getAddToCartVaue(Request $request, $product_id)
    {
        $products=DB::table('tbl_product')
        ->where('product_id', $product_id)
        ->first();
        $inputData= array();
        $inputData['quantityNumber']=$request->quantityNumber;
        $inputData['rateNumber']=$request->rateNumber;
        
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->addCartValue($products, $inputData, $products->product_id);

        // $request->session()->put('cart' $cart);

        // dd($request->session()->get('cart'));

        Session::put('cart', $cart);

        // dd(Session::get('cart'));

        return redirect()->route('home');
           // print_r($products->product_id);
        // return $products_id;
    }

    public function getAddToCartTbl(Request $request, $product_id)
    {
        $products=DB::table('tbl_product')
        ->where('product_id', $product_id)
        ->first();
        $inputData= array();
        $inputData['quantityNumber']=$_GET['input_quantity'];
        $inputData['rateNumber']=$_GET['input_rate'];
        
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->addCartValue($products, $inputData, $products->product_id);

        // $request->session()->put('cart' $cart);

        // dd($request->session()->get('cart'));

        Session::put('cart', $cart);

        // dd(Session::get('cart'));

        // return redirect()->route('home');
           // print_r($products->product_id);
        $totalQty= Session::has('cart') ? Session::get('cart') -> totalQty : '';
        $totalPrice= Session::has('cart') ? Session::get('cart') -> totalPrice : '';
        return ['totalQty'=>$totalQty, 'totalPrice'=>$totalPrice];
    }

    public function getCheckout(){
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
    Session::forget('cart');
    return Redirect::to('/home');

}


    public function dueCheckout(){
        if (!Session::has('cart')) {
            return view ('shopping_cart');
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

}
