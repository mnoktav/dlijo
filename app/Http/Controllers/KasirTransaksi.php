<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;


class KasirTransaksi extends Controller
{
    public function index()
    {
    	$penjualan = DB::table('transaksi_penjualan')
            ->select(DB::raw('*,CAST(substring(nomor_nota,9,5) AS SIGNED) as urut'))
            ->where('status', 1)
            ->orderBy('urut', 'desc')
            ->get();
    	$penjualan_batal = DB::table('transaksi_penjualan')
            ->where('status', 0)
            ->orderBy('nomor_nota', 'desc')
            ->get();
    	$data = 'Riwayat Transaksi';
    	return view('kasir/transaksi',[
    		'data' => $data,
    		'penjualan' => $penjualan,
    		'batal' => $penjualan_batal
    	]);
    }
    public function Nota(Request $request)
    {
    	$cart = session()->get('cart');

    	if($request->tots_bayar==0){
    		return redirect()->back()->with('kosong', 'Keranjang Kosong!');
    	}
        elseif($request->pembayaran<$request->tots_bayar){
            return redirect()->back()->with('kosong', 'Pembayaran Tidak Mencukupi!');
        }
        elseif(isset($request->simpan)){
            $nota = DB::table('transaksi_penjualan')
            ->select(DB::raw('*,CAST(nomor_nota AS SIGNED) as urut'))
            ->orderBy('urut', 'desc')
            ->first();

            if(isset($nota->nomor_nota)){
                if(strlen($nota->nomor_nota)<13){
                    $no_urut = (int) substr($nota->nomor_nota, 8, 4);
                    $no_urut++;
                    $no_nota = date('Ymd').sprintf("%04s", $no_urut);
                }
                else{
                    $no_urut = (int) substr($nota->nomor_nota, 8, 5);
                    $no_urut++;
                    $no_nota = date('Ymd').sprintf("%04s", $no_urut);
                }
            }
            else{
                $no_nota = date('Ymd').'0001'; 
            }
            
            
            // die($no_nota);
            $insert = DB::table('transaksi_penjualan')->insert([
                'nomor_nota' => $no_nota,
                'total_bayar' => $request->tots_bayar,
                'pembayaran' => $request->pembayaran,
                'uang_kembali' => $request->uang_kembali,
                'created_at' => NOW(),
                'created_by' => 1,
                'status' => 1,
                'delivery' => $request->delivery,
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat_pelanggan' => $request->alamat_pelanggan
            ]);

            $jumlah = count($request->id_produk);
            for($i=0; $i<$jumlah; $i++){
                if($request->satuan[$i] == 'gram'){
                    $b = $request->jumlah[$i]/1000;
                }else{
                    $b = $request->jumlah[$i];
                }
                $insert_detail = DB::table('detail_penjualan')->insert([
                    'nomor_nota' => $no_nota,
                    'id_produk' => $request->id_produk[$i],
                    'jumlah' => $b,
                    'potongan_harga' => $request->potongan[$i],
                    'subtotal' => $request->subtotal[$i]+$request->potongan[$i],
                    'subtotal2' => $request->subtotal[$i],
                    'status' => 1
                ]);
            }
            if ($i == $jumlah) {
                if(!$cart){
                    return redirect()->back()->with('kosong', 'Keranjang Kosong!');
                }else{
                    session()->forget('cart');
                    return redirect()->back()->with('success', 'Berhasil Disimpan!');
                }
            }
        }
    	else{
    		$nota = DB::table('transaksi_penjualan')
            ->select(DB::raw('*,CAST(nomor_nota AS SIGNED) as urut'))
            ->orderBy('urut', 'desc')
            ->first();

            if(isset($nota->nomor_nota)){
                if(strlen($nota->nomor_nota)<13){
                    $no_urut = (int) substr($nota->nomor_nota, 8, 4);
                    $no_urut++;
                    $no_nota = date('Ymd').sprintf("%04s", $no_urut);
                }
                else{
                    $no_urut = (int) substr($nota->nomor_nota, 8, 5);
                    $no_urut++;
                    $no_nota = date('Ymd').sprintf("%04s", $no_urut);
                }
            }
            else{
                $no_nota = date('Ymd').'0001'; 
            }

	    	$insert = DB::table('transaksi_penjualan')->insert([
			    'nomor_nota' => $no_nota,
			    'total_bayar' => $request->tots_bayar,
			    'pembayaran' => $request->pembayaran,
			    'uang_kembali' => $request->uang_kembali,
			    'created_at' => NOW(),
			    'created_by' => 1,
			    'status' => 1,
                'delivery' => $request->delivery,
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat_pelanggan' => $request->alamat_pelanggan
			]);

	    	$jumlah = count($request->id_produk);
	    	for($i=0; $i<$jumlah; $i++){
                if($request->satuan[$i] == 'gram'){
                    $b = $request->jumlah[$i]/1000;
                }else{
                    $b = $request->jumlah[$i];
                }
	    		$insert_detail = DB::table('detail_penjualan')->insert([
					'nomor_nota' => $no_nota,
					'id_produk' => $request->id_produk[$i],
					'jumlah' => $b,
                    'potongan_harga' => $request->potongan[$i],
                    'subtotal' => $request->subtotal[$i]+$request->potongan[$i],
                    'subtotal2' => $request->subtotal[$i],
					'status' => 1
				]);
	    	}
			
	    	if ($i == $jumlah) {
		    	if(!$cart){
		            
		            return redirect()->back()->with('kosong', 'Keranjang Kosong!');
		        }
		        else{
                    $connector = new WindowsPrintConnector("ZJ-58");
            
                    $printer = new Printer($connector);

                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> setTextSize(2,1);
                    $printer -> text("D'Lijo\n");
                    $printer -> setTextSize(1,1);
                    $printer -> text("Jl. Seroja No. 109, Jombang\n");
                    $printer -> text("Tlp : 082145310284\n");
                    $printer -> text("Instagram : dlijo.jbg\n\n");
                    $printer -> text("***************************\n\n");
                    $printer -> setJustification(Printer::JUSTIFY_LEFT);
                    $printer -> setPrintLeftMargin(0);
                    for($i=0; $i<$jumlah; $i++){
                        $produk = DB::table('produk')
                            ->where('id_produk',$request->id_produk[$i])
                            ->get();
                        if($request->satuan[$i] == 'gram'){
                            $b = $request->jumlah[$i]/1000;
                            $c = 'kg';
                        }else{
                            $b = $request->jumlah[$i];
                            $c = $request->satuan[$i];
                        }
                        foreach($produk as $produk){
                            $printer -> text($produk->nama_produk."\n");
                            $printer -> text("Jumlah     : ".$b." ".$c."\n");
                            $printer -> text("Potongan   : Rp ".number_format($request->potongan[$i],0,'.','.')."\n");
                            $printer -> text("Subtotal           Rp ".number_format($request->subtotal[$i],0,'.','.')."\n");
                            $printer -> text("-------------------------------\n");
                        }
                    }
                    $printer -> text("\nTotal            : Rp ".number_format($request->tots_bayar,0,'.','.')."\n");
                    $printer -> text("Bayar            : Rp ".number_format($request->pembayaran,0,'.','.')."");
                    $printer -> text("\n-------------------------------\n");
                    $printer -> text("Kembali          : Rp ".number_format($request->uang_kembali,0,'.','.')."\n");
                    $printer -> text("===============================\n\n");
                    $printer -> text("No. Transaksi : ".$no_nota."\n");
                    $printer -> text("Tanggal       : ".date("d-m-y H:i")."\n\n");
                    if(isset($request->nama_pelanggan)){
                    $printer -> text("*Delivery To\n");
                    $printer -> text("Nama   : ".$request->nama_pelanggan."\n");
                    $printer -> text("Alamat :".$request->alamat_pelanggan."\n");
                    }
                    $printer -> text("===============================\n\n");
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> text("Matur Suwun, Nggeh :)\n");
                    $printer -> text("\n\n");
                    $printer -> text("\n");
                    $printer -> cut();
                    $printer -> close(); 
		            session()->forget('cart');
		            return redirect()->back()->with('success', 'Berhasil Disimpan!');
		        }
	    	}
    	}
    }
    public function DetailTransaksi($id)
    {
    	$nota = DB::table('transaksi_penjualan')->where('nomor_nota', $id)->get();
    	$details = DB::table('detail_penjualan')
            ->join('produk', 'detail_penjualan.id_produk', '=', 'produk.id_produk')
            ->select('detail_penjualan.*', 'produk.nama_produk', 'produk.harga_jual', 'produk.satuan')
            ->where('nomor_nota',$id)
            ->get();
    	$data = 'Detail Transaksi';
    	return view('kasir/detail-transaksi',[
    		'data' => $data,
    		'nota' => $nota,
    		'details' => $details
    	]);
    }
    public function DeleteTransaksi(Request $request)
    {
        DB::table('transaksi_penjualan')
            ->where('nomor_nota', $request->nota)
            ->update(['status' => 0]);
        $detail = DB::table('detail_penjualan')
            ->where('nomor_nota', $request->nota)
            ->update(['status' => 0]);

        $detail = DB::table('detail_penjualan')
            ->where('nomor_nota', $request->nota)->get();
        

        foreach ($detail as $key) {
            DB::table('produk')
                ->where('id_produk', $key->id_produk)
               ->increment('stok',$key->jumlah);
        }
            return redirect()->back()->with('success', 'Transaksi Dibatalkan : '.$request->nota);

    }
    public function RestoreTransaksi(Request $request)
    {
        DB::table('transaksi_penjualan')
            ->where('nomor_nota', $request->nota)
            ->update(['status' => 1]);
        DB::table('detail_penjualan')
            ->where('nomor_nota', $request->nota)
            ->update(['status' => 1]);

        $detail = DB::table('detail_penjualan')
            ->where('nomor_nota', $request->nota)->get();
        

        foreach ($detail as $key) {
            DB::table('produk')
                ->where('id_produk', $key->id_produk)
               ->decrement('stok',$key->jumlah);
        }
            return redirect()->back()->with('success', 'Berhasil Dikembalikan : '.$request->nota);

    }
    public function Cek()
    {
        
    }
}
