<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminPembelian extends Controller
{
    public function index()
    {
    	$produk = DB::table('produk')
            ->where('status', 1)
            ->get();
        $supplier = DB::table('supplier')
        	->where('status', 1)
        	->get();
        $pembelian = DB::table('transaksi_pembelian')
            ->join('supplier', 'transaksi_pembelian.id_supplier', '=', 'supplier.id_supplier')
            ->join('produk','transaksi_pembelian.id_produk', '=', 'produk.id_produk')
            ->select('transaksi_pembelian.*', 'produk.nama_produk','produk.satuan','supplier.nama_supplier')
            ->get();

    	$data = 'Data Pembelian';
    	return view('admin/pembelian',[
    		'data' => $data,
    		'produk' => $produk,
    		'supplier' => $supplier,
    		'pembelian' => $pembelian
    	]);
    }
    public function AddPembelian(Request $request)
    {
    	if(isset($request->submit)){
    		if(isset($request->supplier) && isset($request->produk)){
    			if(isset($request->gambar)){
	    		$this->validate($request, [
	            	'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
	        	]);

	    		$gambar = 'P'.date('Ymd').time().'.'.$request->gambar->getClientOriginalExtension();
	        	$request->gambar->move(public_path('img'), $gambar);

		    	DB::table('transaksi_pembelian')->insert([
				    'id_produk' => $request->produk,
				    'id_supplier' => $request->supplier,
				    'total_bayar' => $request->total_bayar,
				    'jumlah' => $request->jumlah,
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
	    			'id_produk' => $request->produk,
				    'id_supplier' => $request->supplier,
				    'total_bayar' => $request->total_bayar,
				    'jumlah' => $request->jumlah,
				    'tanggal' => $request->tanggal,
				    'keterangan' => $request->keterangan,
				    'created_at' => NOW(),
				    'created_by' => 1,
				    'status' => 1

					]);	
	    		}
    		}
    		else{
    			return redirect()->route('pembelian.admin')->with('error','Produk atau Supplier tidak boleh kosong!');
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
					    'id_produk' => $request->produk,
					    'id_supplier' => $request->supplier,
					    'total_bayar' => $request->bayar,
					    'jumlah' => $request->jumlah,
					    'tanggal' => $request->tanggal,
					    'bukti_pembayaran' => $gambar,
					    'keterangan' => $request->keterangan
					]);	
	    	}
	    	else{
	    		
	    		DB::table('transaksi_pembelian')
		    		->where('id_pembelian', $request->id_pembelian)
		    		->update([
					    'id_produk' => $request->produk,
					    'id_supplier' => $request->supplier,
					    'total_bayar' => $request->bayar,
					    'jumlah' => $request->jumlah,
					    'tanggal' => $request->tanggal,
					    'keterangan' => $request->keterangan
					]);
	    	}
    	}
    	return redirect()->back()->with('success', 'Berhasil Disimpan!');
    }

    public function DetailPembelian($id)
    {
    	$produk = DB::table('produk')
            ->where('status', 1)
            ->get();
        $supplier = DB::table('supplier')
        	->where('status', 1)
        	->get();
    	$pembelian = DB::table('transaksi_pembelian')
            ->join('produk', 'transaksi_pembelian.id_produk', '=', 'produk.id_produk')
            ->join('supplier', 'transaksi_pembelian.id_supplier', '=', 'supplier.id_supplier')
            ->select('transaksi_pembelian.*', 'produk.nama_produk', 'supplier.nama_supplier')
            ->where('id_pembelian',$id)
            ->get();
    	$data = 'Detail Pembelian';
    	return view('admin/detail-pembelian',[
    		'data' => $data,
    		'pembelian' => $pembelian,
    		'produk' => $produk,
    		'supplier' => $supplier
    	]);
    }
}
