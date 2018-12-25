<?php

namespace App\Exports;

use App\view_penjualan;
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
    	return view('admin/dexcelh', [
            'details' => $details,
            'tanggal' => $this->tanggal
        ]);
    }
}
