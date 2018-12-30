<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminPenjualan extends Controller
{
    public function __construct()
    {
        $this->middleware('usersession');

    }
    public function index()
    {	
    	$penjualan = DB::table('transaksi_penjualan')
            ->where('status', 1)
            ->orderBy('nomor_nota', 'desc')
            ->get();
    	$penjualan_batal = DB::table('transaksi_penjualan')->where('status', 0)->get();
    	$data = 'Data Penjualan';
    	return view('admin/penjualan',[
    		'data'=>$data,
    		'penjualan' => $penjualan,
    		'batal' => $penjualan_batal
    	]);
    }
    
}
