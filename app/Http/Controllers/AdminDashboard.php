<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Charts\Sample;

class AdminDashboard extends Controller
{   
    
    public function __construct()
    {
        $this->middleware('usersession');

    }
    public function index()
    {
    	$data = 'Dashboard';
    	$penjualan = DB::table('transaksi_penjualan')
            ->where('status', 1)
            ->whereDate('created_at',date('Y-m-d'))
            ->count();

        $pemasukanperbulan = DB::table('transaksi_penjualan')
            ->where('status', 1)
            ->whereMonth('created_at',date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total_bayar');

        $produk = DB::table('produk')
            ->where('status', 1)
            ->count('id_produk')
            ;

        $penjualangagal = DB::table('transaksi_penjualan')
            ->where('status', 0)
            ->whereDate('created_at',date('Y-m-d'))
            ->count();



        //chart 1  
        for($i=0; $i<=6; $i++){
            $penjualans[$i] = DB::table('transaksi_penjualan')
            ->where('status', 1)
            ->whereDate('created_at',today()->subDays($i))
            ->sum('total_bayar');
        }
        $penjualansz = array_map('intval', array_reverse($penjualans));
        //dd($penjualansz);
        $max_date=6;
        for($i=0;$i<=$max_date;$i++){
            $date = mktime(0,0,0,date('m'),date('d')-$i,date('Y'));
            $zz[$i] = date('d F', $date);
        }
        $hari_ini = $penjualans[0];
        $hari_kemarin = $penjualans[1];
        if($hari_kemarin==0){
            $hari_kemarin = 1;
        }
        else{
            $hari_kemarin = $penjualans[1];
        }
        $persen = intval(($hari_ini-$hari_kemarin)/$hari_kemarin*100);

        $chart = new Sample;
        $chart->labels(array_reverse($zz));
        $chart->dataset('Penjualan','line',$penjualansz);

        #Chart 3
        for($i=1; $i<=date('m'); $i++){
            $penjualan_bulan[$i] = DB::table('transaksi_penjualan')
            ->where('status', 1)
            ->whereMonth('created_at',$i)
            ->whereYear('created_at',date('Y'))
            ->sum('total_bayar');
        }
        $penjualan_bulans = array_map('intval', array_reverse($penjualan_bulan));
        $months = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        for($i=0; $i<=date('m')-1; $i++){
            $bulan[$i] = $months[$i]; 
        }
        $chart3 = new Sample;
        $chart3->labels($bulan);
        $chart3->dataset('Penjualan','line',array_reverse($penjualan_bulans));

        //Chart 2
        $max_dates=2;
        for($i=0;$i<=$max_dates;$i++){
            $dates = mktime(0,0,0,date('m'),date('d')-$i,date('Y'));
            $zu[$i] = date('d F', $dates);
        }
        $view_produk = DB::table('view_penjualan')
                ->select('nama_produk', DB::raw('SUM(jumlah) as jumlah'),'id_produk')
                ->where([
                    ['status', 1],
                    ['jumlah','>',0],
                ])
                ->groupBy('id_produk')
                ->get();
        $chart2 = new Sample;
        $chart2->labels(array_reverse($zu));
        for($i=0; $i<count($view_produk->pluck('id_produk')); $i++){
            for($u=0; $u<=2; $u++){
            $produk_terjual[$u] = DB::table('view_penjualan')
                ->whereDate('created_at',today()->subDays($u))
                ->where('id_produk',$view_produk->pluck('id_produk')[$i])
                ->sum('jumlah');
            }
            $chart2->dataset($view_produk->pluck('nama_produk')[$i],'column',array_map('intval',array_reverse($produk_terjual)));
        }        
        


    	return view('admin/dashboard',[
    		'data'=>$data,
    		'transaksi_hari_ini' => $penjualan,
            'batal' => $penjualangagal,
    		'pemasukanperbulan' => $pemasukanperbulan,
    		'produk' => $produk,
            'chart' => $chart,
            'chart2' => $chart2,
            'chart3' => $chart3,
            'persen' => $persen
    	]);
    }
}
