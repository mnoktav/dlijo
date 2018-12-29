<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminPembelian extends Controller
{
    public function __construct()
    {
        $this->middleware('usersession');

    }
    public function index()
    {
    	$data_pengeluaran = DB::table('transaksi_pembelian')
    					->where('status',1)
    					->orderBy('tanggal', 'DESC')
    					->get();
    	$pengeluarany = DB::table('transaksi_pembelian')
    					->where('status',1)
    					->whereYear('tanggal', date('Y'))
    					->sum('total');
    	$pengeluaranb = DB::table('transaksi_pembelian')
    					->where('status',1)
    					->whereMonth('tanggal', date('m'))
    					->whereYear('tanggal', date('Y'))
    					->sum('total');
    	$data = 'Data Pembelian';
    	return view('admin/pembelian',[
    		'data' => $data,
    		'data_pengeluaran' => $data_pengeluaran,
    		'pengeluarany' => $pengeluarany,
    		'pengeluaranb' => $pengeluaranb
    	]);
    }
    public function AddPembelian(Request $request)
    {
    	if(isset($request->submit)){
    		if(isset($request->tanggal) && isset($request->total)){
    			if(isset($request->gambar)){
	    		$this->validate($request, [
	            	'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
	        	]);

	    		$gambar = 'P'.date('Ymd').time().'.'.$request->gambar->getClientOriginalExtension();
	        	$request->gambar->move(public_path('img'), $gambar);

		    	DB::table('transaksi_pembelian')->insert([
				    'total' => $request->total,
				    'tanggal' => $request->tanggal,
				    'bukti_pembayaran' => $gambar,
				    'keterangan' => $request->keterangan,
				    'created_at' => NOW(),
				    'created_by' => 1,
				    'status' => 1

				]);	
	    	}
	    	else{
	    		
	    		DB::table('transaksi_pembelian')->insert([
	    			'total' => $request->total,
				    'tanggal' => $request->tanggal,
				    'keterangan' => $request->keterangan,
				    'created_at' => NOW(),
				    'created_by' => 1,
				    'status' => 1

					]);	
	    		}
    		}
    		else{
    			return redirect()->route('pembelian.admin')->with('error','Tanggal dan Total Pengeluaran tidak boleh kosong!');
    		}
    		
    	}
    	
    	return redirect()->route('pembelian.admin')->with('success','Berhasil Tambah Data!');
    }

    public function UpdatePembelian(Request $request)
    {
    	if(isset($request->submit)){
    		
    		if(isset($request->gambar)){
	    		$this->validate($request, [
	            	'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
	        	]);

	    		$gambar = 'P'.date('Ymd').time().'.'.$request->gambar->getClientOriginalExtension();
	        	$request->gambar->move(public_path('img'), $gambar);

		    	DB::table('transaksi_pembelian')
		    		->where('id_pembelian', $request->id_pembelian)
		    		->update([
					    'total' => $request->total,
					    'tanggal' => $request->tanggal,
					    'bukti_pembayaran' => $gambar,
					    'keterangan' => $request->keterangan
					]);	
	    	}
	    	else{
	    		
	    		DB::table('transaksi_pembelian')
		    		->where('id_pembelian', $request->id_pembelian)
		    		->update([
					    'total' => $request->total,
					    'tanggal' => $request->tanggal,
					    'keterangan' => $request->keterangan
					]);
	    	}
    	}
    	return redirect()->back()->with('success', 'Berhasil Disimpan!');
    }

    public function DetailPembelian($id)
    {
    	$pembelian = DB::table('transaksi_pembelian')
    					->where([
    						['status',1],
    						['id_pembelian',$id]
    					])
    					->get();
    	$data = 'Detail Pengeluaran';
    	return view('admin/detail-pembelian',[
    		'data' => $data,
    		'pembelian' => $pembelian
    	]);
    }
    public function DeletePembelian(Request $request)
    {
    	if($request->hapus != null){
    		DB::table('transaksi_pembelian')
		    		->where('id_pembelian', $request->id_pembelian)
		    		->update([
					    'status' => 0
					]);
    	}
    	return redirect()->route('pembelian.admin')->with('success','Berhasil Hapus Data!');
    }
}
