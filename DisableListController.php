<?php

namespace App\Http\Controllers\MasterAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use Auth;

class DisableListController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:master_admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    	$billing_info=DB::table('tbl_billinfo_stat')
    					->where('bi_status_flag','disable')
                        ->get();
        
        if ($billing_info!=null) {
        	return view ('master.disable_list', [ 'bill_info' => $billing_info]);
        }else{
        	return view ('master.disable_list');
        }
    }

    public function paymentEnable($bus_id)
    {
    	$data= array();
	    $data['bi_status_flag']='paid';
    	DB::table('tbl_billinfo_stat')
	        		->where('bus_id',$bus_id)
	        		->update($data);

	    return redirect()->route('disable.list');
    }
}
