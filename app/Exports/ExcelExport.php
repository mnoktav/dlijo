<?php

namespace App\Exports;

use App\view_penjualan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class ExcelExport implements FromView
{	
	use Exportable;

    public function Tahun(int $year)
    {
        $this->year = $year;
        return $this;
    }
    public function Bulan(int $month)
    {
        $this->month = $month;
        return $this;
    }
    public function view(): View
    {	
        $months = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    	$details = view_penjualan::whereMonth('created_at',$this->month)
    							->whereYear('created_at',$this->year)
    							->orderBy('nomor_nota','asc')
    							->get();
    	return view('admin/dexcel', [
            'details' => $details,
            'bulan' => $months[$this->month-1],
            'tahun' => $this->year
        ]);
    }
}
