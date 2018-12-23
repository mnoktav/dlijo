<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Landing extends Controller
{
    public function index()
    {
    	return view('admin/landing');
    	
    	// $b = \Browser::browserName();
    	// $c = \Browser::platformName();
    	// $data = 'Dashboard';
    	// return view('pages/dashboard',['data'=>$data, 'ip'=>$request->ip(), 'brow'=>$b, 'c'=>$c]);
    }
}
