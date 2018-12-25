<?php

namespace App\Exports;

use App\view_penjualan;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class ExcelExportH implements FromView
{	
	use Exportable;

    public function Tanggal($tanggal)
    {
        $this->tanggal = $tanggal;
        return $this;
    }
    public function view(): View
    {	
    	$details = view_penjualan::whereDate('created_at',$this->tanggal)
    							->orderBy('nomor_nota','asc')
    							->get();
       $view_produk = DB::table('view_penjualan')
                ->select('id_produk','nama_produk',DB::raw('SUM(jumlah) as jumlah, SUM(subtotal2) as total'))
                ->whereDate('created_at',$this->tanggal)
                ->where('status', 1)
                ->groupBy('id_produk')
                ->get();
    	return view('admin/dexcelh', [
            'details' => $details,
            'tanggal' => $this->tanggal,
            'produk' => $view_produk
        ]);
    }
}
