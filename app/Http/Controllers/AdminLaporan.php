<?php

namespace App\Http\Controllers;

use App\Exports\ExcelExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Charts\Sample;


class AdminLaporan extends Controller
{
    public function index(Request $request)
    {
    	$data = 'Laporan';
    	$months = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    	//value bulan
    	for($i=1;$i<=12;$i++){
    		$value[$i] = $i;
    	}

    	if(!isset($request->bulan) && !isset($request->tahun)){
    		$bulan_b = date('m');
    		$tahun_t = date('Y');
    	}else{
    		$bulan_b = $request->bulan;
    		$tahun_t = $request->tahun;
    	}

    	$jumlah = DB::table('transaksi_penjualan')
    		->whereMonth('created_at', $bulan_b)
    		->whereYear('created_at',$tahun_t)
    		->count('nomor_nota');

    	$details = DB::table('view_penjualan')
    		->whereMonth('created_at', $bulan_b)
    		->whereYear('created_at',$tahun_t)
    		->orderBy('nomor_nota','ASC')
    		->get();

    	//chart
    	if ($jumlah>=1) {
    		$view_produk = DB::table('view_penjualan')
    			->select('nama_produk', DB::raw('SUM(jumlah) as jumlah'),'id_produk')
	            ->where([
	            	['status', 1],
	            	['jumlah','>',0],
	            ])
	            ->groupBy('id_produk')
	            ->get();
	        $chart2 = new Sample;
	        $chart2->labels([$months[$bulan_b-1].' '.$tahun_t]);
	        for($i=0; $i<count($view_produk->pluck('id_produk')); $i++){
	        	for ($o=0; $o<1 ; $o++) { 
	        		$produk_terjual[$o] = DB::table('view_penjualan')
	                ->whereMonth('created_at', $bulan_b)
	                ->whereYear('created_at', $tahun_t)
	                ->where('id_produk',$view_produk->pluck('id_produk')[$i])
	                ->sum('jumlah');
	        	}
	            $chart2->dataset($view_produk->pluck('nama_produk')[$i],'column',$produk_terjual);
	        }
    	}
    	else{
    		$chart2 = 0;
    	}

    	$jumlah_transaksi = DB::table('transaksi_penjualan')
	                ->whereMonth('created_at', $bulan_b)
	                ->whereYear('created_at', $tahun_t)
	                ->where('status',1)
	                ->count('nomor_nota');
	    $total_transaksi = DB::table('transaksi_penjualan')
	                ->whereMonth('created_at', $bulan_b)
	                ->whereYear('created_at', $tahun_t)
	                ->where('status',1)
	                ->sum('total_bayar');
    	$rata_transaksi = DB::table('transaksi_penjualan')
	                ->whereMonth('created_at', $bulan_b)
	                ->whereYear('created_at', $tahun_t)
	                ->where('status',1)
	                ->avg('total_bayar');
        
        //dd($chart2);
    	return view('admin/laporan',[
    		'details' => $details,
    		'jumlah' => $jumlah,
    		'months' => $months,
    		'value' => $value,
    		'get_b' => $bulan_b,
    		'get_t' => $tahun_t,
    		'chart_laporan' => $chart2,
    		'jumlah_transaksi' => $jumlah_transaksi,
    		'total_transaksi' => $total_transaksi,
    		'rata_transaksi' => $rata_transaksi,
    		'data'=>$data
    	]);

    	if($request->download == 'pdf'){
    		echo "pdf";
    	}
    	else{
    		echo "excel";
    	}
    }
    public function Download(Request $request)
    {

    	$details = DB::table('view_penjualan')
    		->whereMonth('created_at', $request->bulan)
    		->whereYear('created_at',$request->tahun)
    		->orderBy('nomor_nota','ASC')
    		->get();
    	$months = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

    	$jumlah_transaksi = DB::table('transaksi_penjualan')
	                ->whereMonth('created_at', $request->bulan)
	                ->whereYear('created_at', $request->tahun)
	                ->where('status',1)
	                ->count('nomor_nota');
	    $total_transaksi = DB::table('transaksi_penjualan')
	                ->whereMonth('created_at', $request->bulan)
	                ->whereYear('created_at', $request->tahun)
	                ->where('status',1)
	                ->sum('total_bayar');
    	$rata_transaksi = DB::table('transaksi_penjualan')
	                ->whereMonth('created_at', $request->bulan)
	                ->whereYear('created_at', $request->tahun)
	                ->where('status',1)
	                ->avg('total_bayar');

	    $view_produk = DB::table('produk')
	            ->where('status', 1)
	            ->get();
        for($i=0; $i<count($view_produk->pluck('id_produk')); $i++){
        	for ($o=0; $o<1 ; $o++) { 
        		$produk_terjual[$o] = DB::table('view_penjualan')
                ->whereMonth('created_at', $request->bulan)
                ->whereYear('created_at', $request->tahun)
                ->where('id_produk',$view_produk->pluck('id_produk')[$i])
                ->sum('jumlah');
        	}
        }
    	if($request->download == 'pdf'){
    		$output = '
		    <h3 align="center">Laporan Penjualan Bulan '.$months[$request->bulan-1].' '.$request->tahun.' </h3><br>
		    <table width="100%" style="border-collapse: collapse; border: 0px;">
		    	<tr>
				    <th align="center" style="border: 1px solid; padding:10px; background-color:#c6dcff;">Nomor Nota</th>
				    <th align="center" style="border: 1px solid; padding:10px;background-color:#c6dcff;">Produk</th>
				    <th align="center" width="5%" style="border: 1px solid; padding:10px;background-color:#c6dcff;">Jumlah</th>
				    <th align="center" style="border: 1px solid; padding:10px;background-color:#c6dcff;">Total</th>
				    <th align="center" width="5%" style="border: 1px solid; padding:10px;background-color:#c6dcff;">Potongan Harga</th>
				    <th align="center" style="border: 1px solid; padding:10px;background-color:#c6dcff;">Total Bayar</th>
				    <th align="center" style="border: 1px solid; padding:10px;background-color:#c6dcff;">Tanggal</th>
			   	</tr>
			';  
		    foreach($details as $detail)
		    {
		    $output .= '
		      	<tr>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px;">'.$detail->nomor_nota.'</td>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px; text-transform:capitalize;">'.$detail->nama_produk.'</td>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px;">'.$detail->jumlah.'</td>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px;">Rp '.number_format($detail->subtotal2,0,'.','.').'</td>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px;">'.number_format($detail->potongan_harga,0,'.','.').'</td>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px;">Rp '.number_format($detail->subtotal,0,'.','.').'</td>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px;">'.date('d F Y h:i',strtotime($detail->created_at)).'</td>
		      	</tr>
		    	';
		    }
		    $output .= '</table>';
		    $output .= '
				<br>
				<br>
				<br>
				<table width="100%" style="border-collapse: collapse; border: 0px;">
					<tbody>
				';
			$output .='
						<tr>
							<td width="50%">Total Transaksi Sukses</td>
							<td width="5%">:</td>
							<td>'.$jumlah_transaksi.'</td>
						</tr>
						<tr>
							<td>Total Pemasukan</td>
							<td>:</td>
							<td>Rp '.number_format($total_transaksi,0,',','.').'</td>
						</tr>
						<tr>
							<td>Rata-Rata Transaksi</td>
							<td>:</td>
							<td>Rp '.number_format($rata_transaksi,2,',','.').'</td>
						</tr>
					</tbody>
			';
			$output .= '
				</table>
		    ';
		    
	    	$pdf = \App::make('dompdf.wrapper');
		    $pdf->loadHTML($output);
		    return $pdf->download('LP'.$request->bulan.$request->tahun.'.pdf');
    	}
    	elseif($request->download == 'excel'){
			return (new ExcelExport)->Bulan($request->bulan)->Tahun($request->tahun)->download('LP'.$request->bulan.$request->tahun.'.xlsx');
		}
    	
    }
}
