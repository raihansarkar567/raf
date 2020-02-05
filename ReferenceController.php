<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class ReferenceController extends Controller
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
    public function index()
    {
    	$bill_info = DB::table('tbl_billinfo_stat')
    		->where('bus_id',Auth::user()->id)
    		->first();
    	if ($bill_info==null) {
    		$id=Auth::user()->id;
    		$ref= (5*($id+1993))-14;

    		$data= array();
	    	$data['bi_ac_name']=Auth::user()->name;
	    	$data['bi_ac_mobile']=Auth::user()->mobile;
	    	$data['bi_total_paid_amo']='0';
	    	$data['bi_due_amo']='0';
	    	$data['bi_status_flag']='trial';
	    	$data['bi_paid_amo']='100';
	    	$data['bi_warning_count']='0';
	    	$data['bi_ref_code']=$ref;
	    	$data['bi_ref_amo']='0';
	    	$data['bus_id']=Auth::user()->id;

	    	DB::table('tbl_billinfo_stat')->insert($data);

		    $billInfo= DB::table('tbl_billinfo_stat')
	    		->where('bus_id',Auth::user()->id)
	    		->first();

    		if ($billInfo != null) {
    			 return view('reference', ['bill_info' => $billInfo]);
    		}

    	}else{
    		return Redirect::to('/home');
    	}
        
    }

    public function submitReference(Request $request){
    	$data= array();
        $data['bi_fnf_ref']=$request->reference_code;
        DB::table('tbl_billinfo_stat')
        		->where('bus_id',Auth::user()->id)
        		->update($data);
        return redirect()->route('home');
    }
}
