<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use Auth;

class DeshboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    	$deshboard_info=DB::table('tbl_profit')
                        ->where('business_id',Auth::user()->id)
                        ->get();
        // dd($deshboard_info);
        if ($deshboard_info!=null) {
        	return view ('deshboard', [ 'deshboard_info' => $deshboard_info]);
        }else{
        	return Redirect::to('/init_profit');
        }

        // return view('deshboard');
    }

    //delete account-------
    public function deleteAccount($id){
    	DB::table('tbl_product')
        		->where('business_id', $id)
        		->delete();
        DB::table('tbl_profit')
        		->where('business_id', $id)
        		->delete();
        DB::table('tbl_due_amo')
        		->where('bus_id', $id)
        		->delete();
        DB::table('users')
        		->where('id', $id)
        		->delete();
        DB::table('admins')
        		->where('business_id', $id)
        		->delete();
        return Redirect::to('/login')
        		->with('success','You have successfully Delete your account.');
    }


    public function backMethod(Request $request){
    	return back();
    }

    
}
