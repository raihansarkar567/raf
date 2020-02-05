<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Session;
use Carbon\Carbon;
use Image; //intervention Image class

class AddProductController extends Controller
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
    public function add_product()
    {
        return view('add_product');
    }

    public function save_product(Request $request){
        $this->validate($request, [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $dt = Carbon::now('Asia/Dhaka');
        if ($dt->month==1) {
            $pre_month=12;
        }else{
            $pre_month=$dt->month - 1;
        }

        $data= array();
        $data['product_name']=$request->product_name;
        $data['product_quantity']=$request->product_quantity;
        $data['product_cost']=$request->product_cost;
        $data['product_rate']=$request->product_rate;
        $data['product_discount']=$request->product_discount;
        $data['product_unit']=$request->product_unit;
        $data['product_details']=$request->product_details;
        $data['business_id']=$request->business_id;
        //image insert---------------
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); //getting image extension
            $filename = time().".".$extension;
            // $file->move('upload/product', $filename); //file uploaded commend
            $filePath =public_path('upload/product');
            // open an image file
            $resize_img=Image::make($file->getRealPath());
            // now you are able to resize the instance
            $resize_img->resize(100, 100, function($constraint){
                $constraint->aspectRatio();
            })->save($filePath.'/'.$filename);

            $data['image_txt']=$filename;
        }else{
            $data['image_txt']=null;
        }
// Update to profit table----------------------------
        $profit = DB::table('tbl_profit')
                ->where([
                            ['time_num', $dt->month],
                            ['business_id',Auth::user()->id],
                        ])
                ->first();
        $pre_profit = DB::table('tbl_profit')
                ->where([
                            ['time_num', $pre_month],
                            ['business_id',Auth::user()->id],
                        ])
                ->first();
        $current_yr= DB::table('tbl_profit')
                ->where([
                            ['time_num', '13'],
                            ['business_id',Auth::user()->id],
                        ])
                ->first();
        $total_cost= $pre_profit->remaining + $profit->total_cost + $request->product_cost;
        $currentRemaining=$pre_profit->remaining+$profit->remaining+$request->product_cost;
        $yr_cost=$current_yr->total_cost + $request->product_cost;
        $yr_remaining=$current_yr->remaining+$request->product_cost;
        // dd($total_cost);
        DB::table('tbl_profit')
                ->where([
                            ['time_num', $dt->month],
                            ['business_id',Auth::user()->id],
                        ])
                ->update(['total_cost'=> $total_cost,
                            'remaining'=> $currentRemaining]);
                // dd($total_cost);
        if ($pre_profit->remaining != 0) {
            DB::table('tbl_profit')
                ->where([
                            ['time_num', $pre_month],
                            ['business_id',Auth::user()->id],
                        ])
                ->update(['remaining'=> 0]);
        }
        DB::table('tbl_profit')
                ->where([
                            ['time_num', '13'],
                            ['business_id',Auth::user()->id],
                        ])
                ->update(['total_cost'=> $yr_cost,
                            'remaining'=> $yr_remaining]);
// Add Product--------------------
        DB::table('tbl_product')->insert($data);
        // Session::put('product_message','Product added sucsessfully!!!');
        // return Redirect::to('/home');
        return back()
            ->with('success','You have successfully upload Product.')
            ->with('product_name',$request->product_name);
    }

}
