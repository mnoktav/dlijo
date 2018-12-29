<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminProduk extends Controller
{
    public function __construct()
    {
        $this->middleware('usersession');

    }
    public function index(Request $request)
    {

    	$data = 'Produk';
    	$produk = DB::table('produk')->where([
            ['status', 1],
            ['id_kat', 'like', '%'.$request->produk_cat.'%'],
        ])->get();
    	$cat = DB::table('produk_cat')->get();
    	$cats = DB::table('produk_cat')->get();
    	
    	return view('admin/produk',[
    		'data' => $data,
    		'produk' => $produk,
    		'cat' => $cat,
    		'kategori' => $cats,
            'selected' => $request->produk_cat
    	]);
    }
    public function AddProduk(Request $request)
    { 	
    	if(isset($request->submit)){
    		if(isset($request->gambar)){
	    		$this->validate($request, [
	            	'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
	        	]);

	        	$gambar = date('Ymd').time().'.'.$request->gambar->getClientOriginalExtension();
	        	$request->gambar->move(public_path('img'), $gambar);

		    	DB::table('produk')->insert([
				    'nama_produk' => $request->nama_produk,
				    'harga_jual' => $request->harga,
				    'id_kat' => $request->produk_cat,
				    'gambar' => $gambar,
                    'stok' => 0,
                    'satuan' => $request->satuan,
				    'created_at' => NOW(),
				    'created_by' => 1,
				    'status' => 1

				]);	
	    	}
	    	else{
	    		DB::table('produk')->insert([
				    'nama_produk' => $request->nama_produk,
				    'harga_jual' => $request->harga,
				    'id_kat' => $request->produk_cat,
                    'satuan' => $request->satuan,
                    'stok' => 0,
				    'created_at' => NOW(),
				    'created_by' => 1,
				    'status' => 1

				]);	
	    	}
    	}
    	
    	return redirect()->route('produk.admin')->with('success','Berhasil Tambah Data!');
    }
    public function DeleteProduk(Request $request)
    {
    	DB::table('produk')
            ->where('id_produk', $request->id_produk)
            ->update(['status' => 0]);

            return redirect()->route('produk.admin')->with('success','Berhasil di hapus!');

    }
    public function UpdateProduk(Request $request)
    {
        if(isset($request->submit)){
        	if(isset($request->gambar)){
        		$this->validate($request, [
            	'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
		    	]);

		    	$gambar = date('Ymd').time().'.'.$request->gambar->getClientOriginalExtension();
		    	$request->gambar->move(public_path('img'), $gambar);

		        DB::table('produk')
		            ->where('id_produk', $request->id_produk)
		            ->update([
		            'nama_produk' => $request->nama_produk,
		            'harga_jual' => $request->harga,
		            'id_kat' => $request->produk_cat,
                    'satuan' => $request->satuan,
		            'gambar' => $gambar,
		            'updated_at' => NOW()
		        ]);
        	}
        	else{
        		DB::table('produk')
		            ->where('id_produk', $request->id_produk)
		            ->update([
		            'nama_produk' => $request->nama_produk,
		            'harga_jual' => $request->harga,
                    'satuan' => $request->satuan,
		            'id_kat' => $request->produk_cat,
		            'updated_at' => NOW()
		        ]);
        	}
        	 
        return redirect()->route('produk.admin')->with('success','Berhasil di edit!');
        }
    }
    public function AddKategori(Request $request)
    {
    	if(isset($request->submit)){
	    	DB::table('produk_cat')->insert([
			    'nama_kategori' => $request->nama_kategori,
			]);	
    	}
    	
    	return redirect()->route('produk.admin')->with('success','Berhasil Tambah Kategori!');
    }
    public function DeleteKategori($id)
    {
    	$cek = DB::table('produk')
            ->where([
            	'id_kat' => $id,
            	'status' => '1'
            ])
            ->count();
        if($cek>=1){
        	return redirect()->route('produk.admin')->with('gagal','Hapus/Edit terlebih dahulu produk yang ada pada kategori tersebut!');
        }else{
        	DB::table('produk_cat')->where('id_kat', $id)->delete();
        	return redirect()->route('produk.admin')->with('success','Kategori Berhasil Dihapus!');
        }
    }
    public function CekStok()
    {
        $cek = DB::table('produk')
            ->where('status',1)
            ->get();
        return view('admin/cek-stok',[
            'cek' => $cek,
            'data'=> 'Update Stok'
        ]);
    }
    public function UpdateStok(Request $request)
    {
        if($request->submit != null){
            for($i=0;$i<count($request->id_produk);$i++){
                if($request->stok[$i] != $request->update_stok[$i]){
                   DB::table('produk')
                    ->where('id_produk', $request->id_produk[$i])
                    ->update([
                    'stok' => $request->update_stok[$i],
                    'update_stok' => $request->update_stok[$i],
                    'update_stok_at' => NOW()
                    ]); 
                }
            }
            return redirect()->back()->with('success','Stok Berhasil Diupdate!');
        }
    }
}
