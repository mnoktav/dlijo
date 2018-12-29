<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminSupplier extends Controller
{
    public function __construct()
    {
        $this->middleware('usersession');

    }
    public function index()
    {
    	$data = 'Supplier';
        $supplier = DB::table('supplier')
            ->where('supplier.status',1)
            ->get();
        $produk = DB::table('produk')->where('status', 1)->get();

    	return view('admin/supplier',[
    		'data' => $data,
    		'supplier' => $supplier,
            'produks' => $produk
    	]);
    }
    public function AddSupplier(Request $request)
    { 	
    	if(isset($request->submit)){
	    	DB::table('supplier')->insert([
			    'nama_supplier' => $request->nama_supplier,
			    'nomor_telephone' => $request->telp,
			    'alamat' => $request->alamat,
			    'catatan' => $request->catatan,
			    'created_at' => NOW(),
			    'created_by' => 1,
			    'status' => 1
			]);	
    	}
    	
    	return redirect()->route('supplier.admin')->with('success','Berhasil Tambah Data!');
    }
    public function DeleteSupplier(Request $request)
    {
    	DB::table('supplier')
            ->where('id_supplier', $request->id_supplier)
            ->update(['status' => 0]);

            return redirect()->route('supplier.admin')->with('success','Berhasil di hapus!');

    }
    public function UpdateSupplier(Request $request)
    {
        if(isset($request->submit)){
            DB::table('supplier')
                ->where('id_supplier', $request->id_supplier)
                ->update([
                'nomor_telephone' => $request->telp,
                'alamat' => $request->alamat,
                'catatan' => $request->catatan,
                'updated_at' => NOW()
            ]); 
        return redirect()->route('supplier.admin')->with('success','Berhasil di edit!');
        }
    }
}
