
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
			      	<a href="{{route('laporanharian.admin')}}" class="nav-link">Laporan Harian</a>
			    </li>
			    <li class="nav-item">
			      	<a href="{{route('laporan.admin')}}" class="nav-link active">Laporan Bulanan</a>
			    </li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card-group">
				<div class="card card-nav-tabs col-md-3">
					<div class="card-header card-header-info text-center">
						Cetak Laporan Bulanan
					</div>
					<div class="card-body">
						<form action="{{ url('admin/laporan-admin/') }}">
							{{csrf_field()}}
							<div class="form-group">
								<label for="bulan">Bulan</label>
								<select name="bulan" id="bulan" class="form-control">
									<option value=""></option>
									@for ($i = 0; $i <=11 ; $i++)
										<option value="{{$i+1}}" 
										@if ($get_b == $i+1)
											{{'selected'}}
										@endif>
										{{$months[$i]}}</option>
									@endfor
								</select>
							</div>
							<div class="form-group">
								<label for="tahun">Tahun</label>
								<select name="tahun" id="tahun" class="form-control">
									<option value=""></option>
									@for ($i = 2018; $i <=2050 ; $i++)
										<option value="{{$i}}" 
										@if ($get_t == $i)
											{{'selected'}}
										@endif>
										{{$i}}</option>
									@endfor
								</select>
							</div>
							<div class="form-group">
								<input type="submit" value="submit" class="btn btn-primary">
							</div>
						</form>
					</div>
				</div>
				@if ($jumlah > 0 && isset($get_b) && isset($get_t))
				<div class="card card-nav-tabs">
					<div class="card-body">
						<div class="row">
							<div class="col-md-8">
								
									<p align="center">Total Penjualan Bulan {{$months[$get_b-1].' '.$get_t}}</p>
									@if ($jumlah > 1)
										{!!$chart_laporan->container()!!}
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
								<hr>
								<div class="card" style="border: 1px solid orange">
									<form action="{{ route('downloadlaporan.admin') }}" method="post">
									{{csrf_field()}}
									<div class="card-body">
										<h4>Download Laporan : </h4>
										<div class="">
											<select name="download" class="form-control">
												<option value="pdf">PDF</option>
												<option value="excel">Excel</option>
											</select>
											<input type="hidden" name="bulan" value="{{$get_b}}">
											<input type="hidden" name="tahun" value="{{$get_t}}">
										</div>
										<div class="text-right">
											<input type="submit" name="submit" value="download" class="btn btn-default btn-sm">
										</div>
									</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
	<div class="row">
		@if ($jumlah > 0)
		<div class="col-9">
			<div class="card">
				<div class="card-body" style="padding: 2%;">
					<h4 align="center" style="text-transform: uppercase; font-weight: bold;">Laporan Penjualan Bulan {{$months[$get_b-1].' '.$get_t}}</h4>
					<br>
					<div class="table-responsive">
						<table class="table table-bordered text-center" id="chart">
							<thead class="thead-dark">
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
		</div>			
		<div class="col-3">
			<div class="card" style="padding: 2%">
				<div class="card-body">
					<h4 align="center" style="text-transform: uppercase; font-weight: bold;">Produk Terjual</h4><br>
					<table class="table table-bordered">
						<thead class="thead-dark">
							<tr>
								<th>Produk</th>
								<th>Jumlah</th>
							</tr>
						</thead>

						<tbody>
							@foreach($terjual as $terjual)
							<tr>
								<td style="text-transform: capitalize;">{{$terjual->nama_produk}}</td>
								@php
									$satuan = $terjual->satuan;
									if($satuan == 'gram'){
										$satuan = 'kg';
									}
									else{
										$satuan = $terjual->satuan;
									}
								@endphp
								<td style="text-transform: capitalize;">{{$terjual->jumlah.' '.$satuan}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
			
			@elseif(isset($get_b) && isset($get_t))
				<div class="card">
					<div class="card-body" style="padding: 3%;">
						<h4 align="center">Data Tidak Tersedia Untuk Bulan {{$months[$get_b-1].' '.$get_t}} </h4>
					</div>
				</div>
			@else
				<p style="color: red;">*isi form cetak laporan terlebih dahulu</p>
		@endif
	</div>
	<style>
		#chart th{
			font-weight: bolder !important;
		}
	</style>
@endsection
