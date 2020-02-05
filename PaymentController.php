<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Cart;
use Session;
use DB;

class PaymentController extends Controller
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

    public function index(){
    	$bill_info = DB::table('tbl_billinfo_stat')
    		->where('bus_id',Auth::user()->id)
    		->first();
    	if ($bill_info != null) {
    		$count = $bill_info->bi_warning_count;
    		$dueFee=$count*$bill_info->bi_monthly_fee;
    		 return view('billing', ['bill_info' => $bill_info, 'due_fee' => $dueFee]);
    	}else{
    		return Redirect::to('/login');
    	}
    }


    public function trxIdSubmit(Request $request){
    	$bill_info = DB::table('tbl_billinfo_stat')
    		->where('bus_id',Auth::user()->id)
    		->first();

    	$payment_req = DB::table('tbl_payment_request_dts')
    		->where('bus_id',Auth::user()->id)
    		->first();
    	if ($payment_req==null) {
    		$data= array();
	        $data['bi_ac_name']=$bill_info->bi_ac_name;
	        $data['bi_ac_mobile']=$bill_info->bi_ac_mobile;
	        $data['bi_trx_id']=$request->trxid;
	        $data['bi_ref_code']=$bill_info->bi_ref_code;
	        $data['bi_fnf_ref']=$bill_info->bi_fnf_ref;
	        $data['bi_status_flag']=$bill_info->bi_status_flag;
	        $data['bi_warning_count']=$bill_info->bi_warning_count;
	        $data['bi_monthly_fee']=$bill_info->bi_monthly_fee;
	        $data['bus_id']=$bill_info->bus_id;
	        DB::table('tbl_payment_request_dts')
	        		->insert($data);
    	}else{
    		$data= array();
	        $data['bi_trx_id']=$request->trxid;
	        DB::table('tbl_payment_request_dts')
	        		->where('bus_id',Auth::user()->id)
	        		->update($data);
    	}
    	
        return redirect()->route('home')
        		->with('success','Bill successfully paid, within 48h your payment will be approved.');
    }

    
}
