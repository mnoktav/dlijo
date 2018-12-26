
@extends('admin/template')

@section('title')
	{{$data}}
@endsection

@section('navbar')

	<a class="navbar-brand" href="">{{$data}}</a>

@endsection

@section('content')
	<div class="row" style="margin-bottom: 2rem;">
		<div class="col">
			<ul class="nav nav-pills nav-pills-primary justify-content-center" role="tablist">
			    <li class="nav-item">
			      	<a href="{{route('laporanharian.admin')}}" class="nav-link active">Laporan Harian</a>
			    </li>
			    <li class="nav-item">
			      	<a href="{{route('laporan.admin')}}" class="nav-link">Laporan Bulanan</a>
			    </li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card-group">
				<div class="card card-nav-tabs col-md-3">
					<div class="card-header card-header-info text-center">
						Cetak Laporan Harian
					</div>
					<div class="card-body">
						<form action="{{ route('laporanharian.admin') }}">
							{{csrf_field()}}
							<div class="form-group">
								<label for="bulan">Tanggal</label><br>
								<input type="date" class="form-control" name="tanggal" value="{{$get_tanggal}}">
							</div>
							<div class="form-group">
								<input type="submit" value="submit" class="btn btn-primary">
							</div>
						</form>
					</div>
				</div>
				@if ($jumlah > 0 && isset($get_tanggal))
				<div class="card card-nav-tabs">
					<div class="card-body">
						<div class="row">
							<div class="col-md-8">
								
									<p align="center">Total Penjualan Tanggal {{date('d F Y',strtotime($tanggal))}}</p>
									@if ($jumlah > 1)
										{!!$chart_laporan_harian->container()!!}
									@endif
								
							</div>
							<div class="col-md-4">
								<table class="table">
									<tbody>
										<tr>
											<td width="50%">Total Transaksi Sukses</td>
											<td width="5%">:</td>
											<td>{{$jumlah_transaksi}}</td>
										</tr>
										<tr>
											<td>Total Pemasukan</td>
											<td>:</td>
											<td>Rp {{number_format($total_transaksi,0,',','.')}}</td>
										</tr>
										<tr>
											<td>Rata-Rata Transaksi</td>
											<td>:</td>
											<td>Rp {{number_format($rata_transaksi,2,',','.')}}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			@if ($jumlah > 0)			
			<div class="card">
				<div class="row">
					<div class="col-md-1 offset-md-8 mt-md-3">
						<p align="right"><b>Download :</b></p>
					</div>
					<div class="col-md-2  mt-md-2 mb-md-2" style="padding: 0 5%">
						<form action="{{ route('downloadlaporanharian.admin') }}" method="post">
							{{csrf_field()}}
							<select name="download" class="form-control">
								<option value="pdf">PDF</option>
								<option value="excel">Excel</option>
							</select>
							<input type="hidden" name="tanggal" value="{{$get_tanggal}}">
							<input type="submit" name="submit" value="download" class="btn btn-default btn-sm">
						</form>
					</div>
				</div>
				<div class="card-body" style="padding: 3%;">
					<h4 align="center" style="text-transform: uppercase; font-weight: bold;">Laporan Penjualan Tanggal {{date('d F Y ',strtotime($tanggal))}}</h4>
					<br>
					<div class="table-responsive">
						<table class="table table-bordered text-center" id="chart">
							<thead>
								<tr>
									<th>Nomor Nota</th>
									<th>Produk</th>
									<th>Jumlah</th>
									<th>Total</th>
									<th>Potongan</th>
									<th>Total Bayar</th>
									<th>Tanggal</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($details as $detail)
									@php
										$satuan = $detail->satuan;
										if($satuan == 'gram'){
											$satuan = 'kg';
										}
										else{
											$satuan = $detail->satuan;
										}
									@endphp
									<tr>
										<td>{{$detail->nomor_nota}}</td>
										<td style="text-transform: capitalize;">{{$detail->nama_produk}}</td>
										<td>{{$detail->jumlah.' '.$satuan}}</td>
										<td>Rp {{number_format($detail->subtotal,0,'.','.')}}</td>
										<td>Rp {{number_format($detail->potongan_harga,0,'.','.')}}</td>
										<td>Rp
											{{number_format($detail->subtotal2,0,'.','.')}}
										</td>
										<td>{{date('d F Y  h:i',strtotime($detail->created_at))}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
			@elseif(isset($get_tanggal))
				<div class="card">
					<div class="card-body" style="padding: 3%;">
						<h4 align="center">Data Tidak Tersedia Untuk Tanggal {{date('d F Y',strtotime($tanggal))}} </h4>
					</div>
				</div>
			@else
				<p style="color: red;">*isi form cetak laporan terlebih dahulu</p>
			@endif
		</div>
	</div>
	<style>
		#chart th{
			font-weight: bolder !important;
		}
	</style>
@endsection
