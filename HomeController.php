<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
        $my_product_info=DB::table('tbl_product')
        ->where('business_id',Auth::user()->id)
        ->orderBy('priority','desc')
        ->get();
        $manage_product=view('home')
        ->with('my_product', $my_product_info);
        return view('layouts.app')
        ->with('home',$manage_product);
        // return view('home');
    }

    //edit Profile function--------------------
    public function editProfile(Request $request, $id){
        $data= array();
        $data['name']=$request->user_name;
        $data['business_name']=$request->business_name;
        $data['address']=$request->address;
        $data['mobile']=$request->mobile;
        $data['catagories']=$request->catagories;

        DB::table('users')
                ->where('id', $id)
                ->update($data);
        DB::table('admins')
                ->where('id', $id)
                ->update(['name'=> $request->user_name]);
                
        return Redirect::to('/home');
    }

    

    // reset function--------------------------
    public function reset_product()
    {
        DB::table('tbl_product')
        ->where('business_id',Auth::user()->id)
        ->update(array('priority' => 0));
        
        return Redirect::to('/home');
    }



// init profit from home controller---------

    public function initProfit(){

        $profit_tbl= DB::table('tbl_profit')
        ->where('business_id',Auth::user()->id)
        ->first();

        if ($profit_tbl == null) {
            for ($i=0; $i <15 ; $i++) { 
                switch ($i) {
                    case '0':
                    $data= array();
                    $data['time_num']='1';
                    $data['time_name']='Jan';
                    $data['total_cost']='0';
                    $data['total_sale']='0';
                    $data['total_profit']='0';
                    $data['remaining']='0';
                    $data['business_id']=Auth::user()->id;

                    DB::table('tbl_profit')->insert($data);
                    break;
                    case '1':
                    $data= array();
                    $data['time_num']='2';
                    $data['time_name']='Fab';
                    $data['total_cost']='0';
                    $data['total_sale']='0';
                    $data['total_profit']='0';
                    $data['remaining']='0';
                    $data['business_id']=Auth::user()->id;

                    DB::table('tbl_profit')->insert($data);
                    break;
                    case '2':
                    $data= array();
                    $data['time_num']='3';
                    $data['time_name']='Mar';
                    $data['total_cost']='0';
                    $data['total_sale']='0';
                    $data['total_profit']='0';
                    $data['remaining']='0';
                    $data['business_id']=Auth::user()->id;

                    DB::table('tbl_profit')->insert($data);
                    break;
                    case '3':
                    $data= array();
                    $data['time_num']='4';
                    $data['time_name']='Apr';
                    $data['total_cost']='0';
                    $data['total_sale']='0';
                    $data['total_profit']='0';
                    $data['remaining']='0';
                    $data['business_id']=Auth::user()->id;

                    DB::table('tbl_profit')->insert($data);
                    break;
                    case '4':
                    $data= array();
                    $data['time_num']='5';
                    $data['time_name']='May';
                    $data['total_cost']='0';
                    $data['total_sale']='0';
                    $data['total_profit']='0';
                    $data['remaining']='0';
                    $data['business_id']=Auth::user()->id;

                    DB::table('tbl_profit')->insert($data);
                    break;
                    case '5':
                    $data= array();
                    $data['time_num']='6';
                    $data['time_name']='Jun';
                    $data['total_cost']='0';
                    $data['total_sale']='0';
                    $data['total_profit']='0';
                    $data['remaining']='0';
                    $data['business_id']=Auth::user()->id;

                    DB::table('tbl_profit')->insert($data);
                    break;
                    case '6':
                    $data= array();
                    $data['time_num']='7';
                    $data['time_name']='Jul';
                    $data['total_cost']='0';
                    $data['total_sale']='0';
                    $data['total_profit']='0';
                    $data['remaining']='0';
                    $data['business_id']=Auth::user()->id;

                    DB::table('tbl_profit')->insert($data);
                    break;
                    case '7':
                    $data= array();
                    $data['time_num']='8';
                    $data['time_name']='Aug';
                    $data['total_cost']='0';
                    $data['total_sale']='0';
                    $data['total_profit']='0';
                    $data['remaining']='0';
                    $data['business_id']=Auth::user()->id;

                    DB::table('tbl_profit')->insert($data);
                    break;
                    case '8':
                    $data= array();
                    $data['time_num']='9';
                    $data['time_name']='Sep';
                    $data['total_cost']='0';
                    $data['total_sale']='0';
                    $data['total_profit']='0';
                    $data['remaining']='0';
                    $data['business_id']=Auth::user()->id;

                    DB::table('tbl_profit')->insert($data);
                    break;
                    case '9':
                    $data= array();
                    $data['time_num']='10';
                    $data['time_name']='Oct';
                    $data['total_cost']='0';
                    $data['total_sale']='0';
                    $data['total_profit']='0';
                    $data['remaining']='0';
                    $data['business_id']=Auth::user()->id;

                    DB::table('tbl_profit')->insert($data);
                    break;
                    case '10':
                    $data= array();
                    $data['time_num']='11';
                    $data['time_name']='Nov';
                    $data['total_cost']='0';
                    $data['total_sale']='0';
                    $data['total_profit']='0';
                    $data['remaining']='0';
                    $data['business_id']=Auth::user()->id;

                    DB::table('tbl_profit')->insert($data);
                    break;
                    case '11':
                    $data= array();
                    $data['time_num']='12';
                    $data['time_name']='Dec';
                    $data['total_cost']='0';
                    $data['total_sale']='0';
                    $data['total_profit']='0';
                    $data['remaining']='0';
                    $data['business_id']=Auth::user()->id;

                    DB::table('tbl_profit')->insert($data);
                    break;
                    case '12':
                    $data= array();
                    $data['time_num']='13';
                    $data['time_name']='Current_yr';
                    $data['total_cost']='0';
                    $data['total_sale']='0';
                    $data['total_profit']='0';
                    $data['remaining']='0';
                    $data['business_id']=Auth::user()->id;

                    DB::table('tbl_profit')->insert($data);
                    break;
                    case '13':
                    $data= array();
                    $data['time_num']='14';
                    $data['time_name']='Last_yr';
                    $data['total_cost']='0';
                    $data['total_sale']='0';
                    $data['total_profit']='0';
                    $data['remaining']='0';
                    $data['business_id']=Auth::user()->id;

                    DB::table('tbl_profit')->insert($data);
                    break;
                    case '14':
                    $data= array();
                    $data['time_num']='15';
                    $data['time_name']='B2E';
                    $data['total_cost']='0';
                    $data['total_sale']='0';
                    $data['total_profit']='0';
                    $data['remaining']='0';
                    $data['business_id']=Auth::user()->id;

                    DB::table('tbl_profit')->insert($data);
                    break;

                    default:
                    # code...
                    break;
                }
            }
            return Redirect::to('/reference');

        }else {
           return Redirect::to('/home'); 
       }


   }



}
