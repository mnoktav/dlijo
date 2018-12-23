<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class KasirDashboard extends Controller
{
    public function index()
    {
    	$data = 'Dashboard';
    	$produk = DB::table('produk')->where('status', 1)->orderBy('id_kat','asc')->get();
        $cat = DB::table('produk_cat')->get();
    	return view('kasir/dashboard',[
    		'data' => $data,
    		'produk' => $produk,
            'cat' => $cat
    	]);
    }

    public function AddToCart($id)
    {
    	$produk = DB::table('produk')->where('id_produk', $id)->first();
    	if($produk->satuan == 'gram'){
            $a = 1000;
        } else{
            $a = 1;
        }
    	$cart = session()->get('cart');
        
    	if(!$cart){
            
    		$cart = [
                    $id => [
                        "nama_produk" => $produk->nama_produk,
                        "satuan" => $produk->satuan,
                        "jumlah" => $a,
                        "harga" => $produk->harga_jual,
                        "potongan" => 0
                    ]
            ];
 
            session()->put('cart', $cart);
 
            return redirect()->back()->with('success', 'Produk Berhasil Ditambahkan Ke Keranjang!');
    	}

    	if(isset($cart[$id])) {
            
            if($cart[$id]['satuan'] == 'gram'){
                $cart[$id]['jumlah']+=1000;
            }
            else{
                $cart[$id]['jumlah']+=1;
            }
            
 
            session()->put('cart', $cart);
 
            return redirect()->back()->with('success', 'Produk Berhasil Ditambahkan Ke Keranjang!');
 
        }

        $cart[$id] = [
            "nama_produk" => $produk->nama_produk,
            "jumlah" => $a,
            "satuan" => $produk->satuan,
            "harga" => $produk->harga_jual,
            "potongan" => 0
        ];
 
        session()->put('cart', $cart);
 
        return redirect()->back()->with('success', 'Produk Berhasil Ditambahkan Ke Keranjang!');
    }

    public function RemoveFromCart(Request $request)
    {
        if($request->id) {
 
            $cart = session()->get('cart');
 
            if(isset($cart[$request->id])) {
 
                unset($cart[$request->id]);
 
                session()->put('cart', $cart);
            }
 
            session()->flash('success', 'Produk Berhasil Dihapus Dari Keranjang!');
        }
    }
    public function UpdateCart(Request $request)
    {

        if($request->id and $request->jumlah and $request->potongan)
        {
            $cart = session()->get('cart');
 
            $cart[$request->id]["jumlah"] = $request->jumlah;
            $cart[$request->id]["potongan"] = $request->potongan;
 
            session()->put('cart', $cart);
 
            session()->flash('success', 'Keranjang berhasil di update');
        }
        elseif($request->potongan==0 and $request->id and $request->jumlah){
            $cart = session()->get('cart');
 
            $cart[$request->id]["jumlah"] = $request->jumlah;
            $cart[$request->id]["potongan"] = 0;
 
            session()->put('cart', $cart);
 
            session()->flash('success', 'Keranjang berhasil di update');
        }
    }
    public function removecart()
    {
        $cart = session()->get('cart');

        if(!$cart){
            
            return redirect()->back()->with('kosong', 'Keranjang Kosong');
        }
        else{
            session()->forget('cart');
            return redirect()->back()->with('success', 'Berhasil Dibatalkan');
        }
        
        
    }
}
