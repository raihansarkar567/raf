<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use Auth;
use Carbon\Carbon;
use Image; //intervention Image class
use File;

class AllProductController extends Controller
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
    	$all_products=DB::table('tbl_product')
                        ->where('business_id',Auth::user()->id)
                        ->get();
        // dd($deshboard_info);
        if ($all_products!=null) {
        	return view ('admin.all_products', [ 'all_products' => $all_products]);
        }else{
        	return view ('admin.all_products');
        }

        // return view('deshboard');
    }

    //Edit product on existing product field--------------
    public function updateProduct(Request $request, $id){
    	$data= array();
        $data['product_name']=$request->product_name;
        $data['product_details']=$request->details;
        $data['product_discount']=$request->discount;
        // $data['priority']=$request->priority;
        // dd($data['product_quantity']);
        //image Update---------------
        if ($request->hasFile('image')) {
        	$oldFile= DB::table('tbl_product')
        		->where('product_id', $id)
        		->first();
        	$oldImage=$oldFile->image_txt;
        	if ($oldImage!=null) {
        		$filePath =public_path('upload/product');
        		File::delete($filePath.'/'.$oldImage);
        	}
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
        }

        DB::table('tbl_product')
        		->where('product_id', $id)
        		->update($data);
        Session::put('product_message','Product added sucsessfully!!!');
        return redirect()->route('admin.all.product');
    }
    public function deleteProduct(Request $request, $id)
    {
        $dt = Carbon::now('Asia/Dhaka');
        if ($dt->month==1) {
            $pre_month=12;
        }else{
            $pre_month=$dt->month - 1;
        }

        $product=DB::table('tbl_product')
                        ->where([
                            ['product_id', $id],
                            ['business_id',Auth::user()->id],
                        ])
                        ->first();
        if ($product!=null) {
            $cost=$product->product_cost;
        }else{
            return redirect()->route('admin.all.product');
        }

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
        $yr_profit = DB::table('tbl_profit')
                ->where([
                            ['time_num', '13'],
                            ['business_id',Auth::user()->id],
                        ])
                ->first();
        $total_cost= $pre_profit->remaining + $profit->total_cost - $cost;
        $currentRemaining=$pre_profit->remaining + $profit->remaining - $cost;
        $yr_cost=$yr_profit->total_cost - $cost;
        $yr_remaining=$yr_profit->remaining - $cost;
        // dd($total_cost);
        // dd($currentRemaining);
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
        // dd($request->cost);
        
        DB::table('tbl_product')
        		->where('product_id', $id)
        		->delete();
        //image Delete---------------
        
        	$imageFile=$product->image_txt;
        	if ($imageFile!=null) {
        		$filePath =public_path('upload/product');
        		File::delete($filePath.'/'.$imageFile);
        	}

        Session::put('product_message','Product added sucsessfully!!!');
        return redirect()->route('admin.all.product');
    }
}
