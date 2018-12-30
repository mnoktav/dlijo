<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Login extends Controller
{
    public function index()
    {
    	return view('admin/login');
    	
    	// $b = \Browser::browserName();
    	// $c = \Browser::platformName();
    	// $data = 'Dashboard';
    	// return view('pages/dashboard',['data'=>$data, 'ip'=>$request->ip(), 'brow'=>$b, 'c'=>$c]);
    }
    public function DoLogin(Request $request)
    {
    	if(isset($request->login)){
    		if($request->password == 'dlijo-jbg'){
    			$session = session()->get('login');
    			$session = [
    				"username" => "admin-jombang",
    				"id_admin" => 1
    			];
    			session()->put('login',$session);
    			return redirect()->route('dashboard.admin');
    		}else{
    			return redirect()->route('login.admin')->with('error', 'Password Salah!');;
    		}
    	}
    }

    public function DoLogout()
    {
    	session()->forget('login');
    	return redirect()->route('dashboard.admin');
    }
}
