@extends('kasir/templates')

@section('title')
	{{$data}}
@endsection

@section('navbar')
	<a class="navbar-brand" href="">Transaksi <i class="fas fa-chevron-right"></i> {{$data}}</a>
@endsection

@section('content')
@foreach ($nota as $nota)
	
	<div class="col-sm-8" style="background-color: white; padding:20px; border-radius: 5px; margin-top: 1%;">
		<div>
			<div class="row">
		    	<div class="col">
		    		<table>
		    			<tr>
		    				<td width="70">No. Nota</td>
		    				<td width="10">:</td>
		    				<td width="200"><b>{{$nota->nomor_nota}}</b></td>
		    			</tr>
		    			<tr>
		    				<td>Tanggal</td>
		    				<td>:</td>
		    				<td>{{date('d F Y H:i',strtotime($nota->created_at))}}</td>
		    			</tr>	    			
		    		</table>
		    	</div>
		    	<div class="col" style="padding-left: 200px;">
		    		<table>
		    			<tr>
		    				<td width="70">Status</td>
		    				<td width="10">:</td>
		    				<td>@if ($nota->status=='1')
		    					{{'Lunas'}}
		    				@else
		    				{{'Batal'}}
		    				@endif</td>
		    			</tr>
		    		</table>
		    	</div>
		    </div>
		    <hr>
		    <div class="row">
		    	<div class="col">
			    	<table class="table table-bordered">
			    		<thead>
			    			<tr>
			    				<th>Produk</th>
								<th>Harga</th>
								<th>Jumlah</th>
								<th>Potongan Harga</th>
								<th>Subtotal</th>	
			    			</tr>
			    		</thead>
			    		<tbody>
			    			@foreach ($details as $detail)
			    			<tr>
			    				<td style="text-transform: capitalize;">{{$detail->nama_produk}}</td>
			    				<td>Rp {{number_format($detail->harga_jual,0,'.','.')}}</td>
			    				@php
			    					if($detail->satuan=='gram'){
			    						$satuan = 'kg';
			    					}else{
			    						$satuan = $detail->satuan;
			    					}
			    				@endphp
			    				<td>{{$detail->jumlah.' '.$satuan}}</td>
			    				<td>Rp {{number_format($detail->potongan_harga,0,'.','.')}}</td>
			    				<td>Rp {{number_format($detail->subtotal2,0,'.','.')}}</td>
			    			</tr>
			    			@endforeach
			    			<tr>
			    				<td colspan="4"><b>TOTAL</b></td>
			    				<td>Rp {{number_format($nota->total_bayar,0,'.','.')}}</td>
			    			</tr>
			    		</tbody>
			    	</table>
			    </div>
		    </div>
		    <hr>
		    <div class="row">
		    	<div class="col">
		    		<table>
		    			<tr>
		    				<td width="70">Bayar</td>
		    				<td width="10">:</td>
		    				<td>Rp {{number_format($nota->pembayaran,0,'.','.')}}</td>
		    			</tr>	    			
		    		</table>
		    	</div>
		    	<div class="col" style="padding-left: 200px;">
		    		<table>
		    			<tr>
		    				<td width="70">Kembali</td>
		    				<td width="10">:</td>
		    				<td>Rp {{number_format($nota->uang_kembali,0,'.','.')}}</td>
		    			</tr>
		    		</table>
		    	</div>
		    </div>
		    @if ($nota->delivery == 1)

		    <div class="row" id="deliv">
		    	<div class="col">
		    		<p><br>
		    			Delivery To : <br>
						{{$nota->nama_pelanggan}} <br>
						{{$nota->alamat_pelanggan}}
		    		</p>
		    	</div>
		    </div>
		    @endif
	    </div>
	</div> 
@endforeach
<style>
    	.table td{
    		text-align: center;

    	}
    	#deliv p{
    		font-size: 12px;
    		line-height: normal;
    	}
    	td{
    		font-size: 13px;
    		margin: 0px;
    		padding: 0px;
    	}
    	th{
    		font-size: 13px !important;
    		padding: 1% !important;
    		text-align: center;
    	}
    </style>
@endsection