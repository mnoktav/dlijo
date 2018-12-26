<?php

namespace App\Http\Controllers;

use App\Exports\ExcelExportH;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Charts\Sample;


class AdminLaporanHarian extends Controller
{
    public function index(Request $request)
    {
    	$data = 'Laporan';

    	if(!isset($request->tanggal)){
    		$tanggal = date('Y-m-d');
    	}else{
    		$tanggal = $request->tanggal;
    	}

    	$jumlah = DB::table('transaksi_penjualan')
    		->whereDate('created_at', $tanggal)
    		->count('nomor_nota');

    	$details = DB::table('view_penjualan')
    		->select(DB::raw('*,CAST(nomor_nota AS SIGNED) as urut'))
    		->whereDate('created_at', $tanggal)
    		->orderBy('urut','DESC')
    		->get();

    	//chart
    	if ($jumlah>0) {
    		$view_produk = DB::table('view_penjualan')
    			->select('nama_produk', DB::raw('SUM(jumlah) as jumlah'),'id_produk')
    			->whereDate('created_at', $tanggal)
	            ->where([
	            	['status', 1],
	            	['jumlah','>=',0],
	            ])
	            ->groupBy('id_produk')
	            ->get();
	        $chart2 = new Sample;
	        $chart2->labels([date('d F Y', strtotime($tanggal))]);
	        for($i=0; $i<count($view_produk->pluck('id_produk')); $i++){
	        	for ($o=0; $o<1 ; $o++) { 
	        		$produk_terjual[$o] = DB::table('view_penjualan')
	                ->whereDate('created_at', $tanggal)
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
	                ->whereDate('created_at', $tanggal)
	                ->where('status',1)
	                ->count('nomor_nota');
	    $total_transaksi = DB::table('transaksi_penjualan')
	                ->whereDate('created_at', $tanggal)
	                ->where('status',1)
	                ->sum('total_bayar');
    	$rata_transaksi = DB::table('transaksi_penjualan')
	                ->whereDate('created_at', $tanggal)
	                ->where('status',1)
	                ->avg('total_bayar');
        
        //dd($chart2);
    	return view('admin/laporan-harian',[
    		'details' => $details,
    		'jumlah' => $jumlah,
    		'tanggal' => $tanggal,
    		'get_tanggal' => $tanggal,
    		'chart_laporan_harian' => $chart2,
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
    	$tanggal = $request->tanggal;
    	$details = DB::table('view_penjualan')
    		->select(DB::raw('*,CAST(nomor_nota AS SIGNED) as urut'))
    		->whereDate('created_at', $tanggal)
    		->orderBy('urut','DESC')
    		->get();
    	

    	$jumlah_transaksi = DB::table('transaksi_penjualan')
	                ->whereDate('created_at', $tanggal)
	                ->where('status',1)
	                ->count('nomor_nota');
	    $total_transaksi = DB::table('transaksi_penjualan')
	                ->whereDate('created_at', $tanggal)
	                ->where('status',1)
	                ->sum('total_bayar');
    	$rata_transaksi = DB::table('transaksi_penjualan')
	                ->whereDate('created_at', $tanggal)
	                ->where('status',1)
	                ->avg('total_bayar');

	    $view_produk = DB::table('view_penjualan')
	    		->select('id_produk','nama_produk','satuan',DB::raw('SUM(jumlah) as jumlah, SUM(subtotal2) as total'))
	    		->whereDate('created_at', $tanggal)
	            ->where('status', 1)
				->groupBy('id_produk')
	            ->get();
    	if($request->download == 'pdf'){
    		$output = '
		    <h3 align="center">Laporan Penjualan Tanggal '.date('d F Y', strtotime($tanggal)).' </h3><br>
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
		    	$satuan = $detail->satuan;
				if($satuan == 'gram'){
					$satuan = 'kg';
				}
				else{
					$satuan = $detail->satuan;
				}
		    $output .= '
		      	<tr>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px;">'.$detail->nomor_nota.'</td>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px; text-transform:capitalize;">'.$detail->nama_produk.'</td>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px; text-transform:capitalize;">'.$detail->jumlah.' '.$satuan.'</td>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px;">Rp '.number_format($detail->subtotal,0,'.','.').'</td>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px;">Rp '.number_format($detail->potongan_harga,0,'.','.').'</td>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px;">Rp '.number_format($detail->subtotal2,0,'.','.').'</td>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px;">'.date('d F Y h:i',strtotime($detail->created_at)).'</td>
		      	</tr>
		    	';
		    }
		    $output .= '</table> <br><br>';
		    
		    $output .= '<h3 align="center">Data Produk Terjual Tanggal '.date('d F Y', strtotime($tanggal)).' </h3><br>
		    <table width="100%" style="border-collapse: collapse; border: 0px;">
		    	<tr>
				    <th align="center" style="border: 1px solid; padding:10px; background-color:#c6dcff;">Produk</th>
				    <th align="center" style="border: 1px solid; padding:10px;background-color:#c6dcff;">Jumlah</th>
				    <th align="center" style="border: 1px solid; padding:10px;background-color:#c6dcff;">Total Harga</th>
			   	</tr>
			';
			foreach($view_produk as $produk)
		    {
		    	$satuan = $produk->satuan;
				if($satuan == 'gram'){
					$satuan = 'kg';
				}
				else{
					$satuan = $produk->satuan;
				}
		    $output .= '
		      	<tr>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px;">'.$produk->nama_produk.'</td>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px; text-transform:capitalize;">'.$produk->jumlah.' '.$satuan.'</td>
			       <td align="center" style="border: 1px solid; padding:5px;font-size:14px;">Rp '.number_format($produk->total,0,'.','.').'</td>
		      	</tr>
		    	';
		    }
		    $output .= '</table>';
		    $output .= '
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
				<br>
		    ';

	    	$pdf = \App::make('dompdf.wrapper');
		    $pdf->loadHTML($output);
		    return $pdf->download('LP'.date('d F Y', strtotime($tanggal)).'.pdf');
    	}
    	elseif($request->download == 'excel'){
			return (new ExcelExportH)->Tanggal($request->tanggal)->download('LP'.date('dFY', strtotime($tanggal)).'.xlsx');
		}
    	
    }
}
