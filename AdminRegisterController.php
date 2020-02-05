<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;
use Hash;
use DB;

class AdminRegisterController extends Controller
{
    public function __construct()
    {
      $this->middleware('guest:admin');
    }

    public function showRegistrationForm()
    {
        return view('auth.admin-register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'business_id' => ['required', 'Integer', 'max:255'],
        ]);
    }

    // protected function register(Request $request){
    // 	return Company::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //         'business_name' => $data['business_name'],
    //     ]);
    // }
    public function register(Request $request){
        $data= array();
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['password']=Hash::make($request->password);
        $data['business_id']=$request->business_id;
        // $data['business_id']=$request->business_id;

        DB::table('admins')->insert($data);
        Session::put('product_message','Product added sucsessfully!!!');
        return Redirect::to(route('admin.login'));
    }
}
