<?php

namespace App\Http\Controllers\MasterAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use Auth;

class AllUserController extends Controller
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
                        ->get();
        
        if ($billing_info!=null) {
        	return view ('master.all_user', [ 'bill_info' => $billing_info]);
        }else{
        	return view ('master.all_user');
        }
    }

    public function paymentStatusSetup($bus_id, $status)
    {
    	switch ($status) {
    		case 'paid':
    			$data= array();
			    $data['bi_status_flag']='paid';
			    $data['bi_warning_count']='0';
		    	DB::table('tbl_billinfo_stat')
			        		->where('bus_id',$bus_id)
			        		->update($data);
    			break;
    		case 'notPaid':
    			$data= array();
			    $data['bi_status_flag']='notPaid';
		    	DB::table('tbl_billinfo_stat')
			        		->where('bus_id',$bus_id)
			        		->update($data);
    			break;
    		case 'disable':
    			$data= array();
			    $data['bi_status_flag']='disable';
		    	DB::table('tbl_billinfo_stat')
			        		->where('bus_id',$bus_id)
			        		->update($data);
    			break;
    		case 'delete':
    			# code...
    			break;

    		default:
    			$data= array();
			    $data['bi_status_flag']='trial';
			    $data['bi_warning_count']='0';
		    	DB::table('tbl_billinfo_stat')
			        		->where('bus_id',$bus_id)
			        		->update($data);
    			break;
    	}
    	return redirect()->route('all.user');
    }
}
