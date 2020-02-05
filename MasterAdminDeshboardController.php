<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use Auth;


class MasterAdminDeshboardController extends Controller
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
        	return view ('master_admin_deshboard', [ 'bill_info' => $billing_info]);
        }else{
        	return view ('master_admin_deshboard');
        }

        // return view('deshboard');
    }

    public function sendPaymentNotice($flag)
    {
    	switch ($flag) {
    		case 'paidUser':
    			$users = DB::table('tbl_billinfo_stat')
                    ->where('bi_status_flag','paid')
                    ->orWhere('bi_status_flag','notPaid')
                    ->get();

                foreach ($users as $user_value) {
                	if ($user_value->bi_warning_count < 3) {
                		$warning=$user_value->bi_warning_count+1;
                		$data= array();
                		if ($warning>0) {
                			$data['bi_status_flag']='notPaid';
                		}
					    $data['bi_warning_count']=$warning;
				    	DB::table('tbl_billinfo_stat')
					        		->where('bill_stat_id',$user_value->bill_stat_id)
					        		->where('bus_id',$user_value->bus_id)
					        		->update($data);
                	}else{
                		$data= array();
                		$data['bi_status_flag']='disable';
				    	DB::table('tbl_billinfo_stat')
					        		->where('bill_stat_id',$user_value->bill_stat_id)
					        		->where('bus_id',$user_value->bus_id)
					        		->update($data);
                	}
                }

    			break;
    		case 'trialUser':

		        $users = DB::table('tbl_billinfo_stat')
                    ->where('bi_status_flag','trial')
                    ->get();

                foreach ($users as $user_value) {
                		$data= array();
					    $data['bi_status_flag']='notPaid';
					    $data['bi_warning_count']=$user_value->bi_warning_count+1;
				    	DB::table('tbl_billinfo_stat')
					        		->where('bill_stat_id',$user_value->bill_stat_id)
					        		->where('bus_id',$user_value->bus_id)
					        		->update($data);
                		
                }
    			break;
    		
    		default:
    			//code--
    			break;
    	}

    	return redirect()->route('master.admin.dashboard');
    	
    }
}
