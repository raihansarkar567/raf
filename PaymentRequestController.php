<?php

namespace App\Http\Controllers\MasterAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use Auth;

class PaymentRequestController extends Controller
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
    	$payment_req = DB::table('tbl_payment_request_dts')
    		->get();
    	return view('master_admin_payment_request', ['payment_req' => $payment_req]);
        // return view('deshboard');
    }

    public function paymentAccept($bus_id, $flag)
    {
    	switch ($flag) {
    		case 'delete':
    			dd("delete");
    			break;
    		case 'accept':
    			$fnf_ref=$_GET['fnf_ref'];
		        $warning_count=$_GET['warning_count'];
		        $paid_amount=$_GET['paidAmount'];
		        $monthly_fee=$_GET['monthly_fee'];
		        if ($paid_amount>0) {
		        	$count = $paid_amount / $monthly_fee;
		        	$warning = $warning_count-round($count,2);
		        	$reff_amo= ($paid_amount*10)/100;

		        	$data= array();
		        	if ($warning<=0) {
		        		$data['bi_status_flag']='paid';
		        	}
				    $data['bi_warning_count']=$warning;
			    	DB::table('tbl_billinfo_stat')
				        		->where('bus_id',$bus_id)
				        		->update($data);

				    // reference money update--
				    $refData=DB::table('tbl_billinfo_stat')
			        		->where('bi_ref_code',$fnf_ref)
			        		->first();
			        $refAmount=$refData->bi_ref_amo;
			        $refAmount=$refAmount+$reff_amo;
			        DB::table('tbl_billinfo_stat')
				        		->where('bi_ref_code',$fnf_ref)
				        		->update(['bi_ref_amo' => $refAmount]);
				    // ---------
				    DB::table('tbl_payment_request_dts')
			        		->where('bus_id',$bus_id)
			        		->delete();
		        }
    			return json_encode($warning);
    			break;
    		
    		default:
    			//code--
    			break;
    	}

    	return redirect()->route('master.admin.paymentRequest');
    	
    }
}
