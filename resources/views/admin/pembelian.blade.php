
@extends('admin/template')

@section('title')
	{{$data}}
@endsection

@section('navbar')

	<a class="navbar-brand" href="">{{$data}}</a>

@endsection

@section('content')
	@if (count($errors) > 0)
            <div class="alert alert-danger">
            	<a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif


    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
        	<a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
                <strong>{{ $message }}</strong>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-warning alert-block">
        	<a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
                <strong>{{ $message }}</strong>
        </div>
    @endif
    <div class="row">
		<div class="col-2">
			<button class="btn btn-success" type="button" data-toggle="collapse" data-target="#input-data-pembelian" aria-expanded="false" aria-controls="input-data-pembelian">
		    Tambah Data</button>
		</div>
		<div class="col-7 mt-1">
			<marquee scrollamount="9" style="padding: 0.5rem; background-color: #e5e5e5;">
				<i>Pengeluaran Hari Ini ({{date('d F Y')}}) : Rp {{number_format($pengeluaranh,0,'.','.')}}</i> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<i>Pengeluaran Bulan Ini ({{date('F')}}) : Rp {{number_format($pengeluaranb,0,'.','.')}}</i>
			</marquee>	
		</div>
    </div>
    <div class="row">
    	<div class="col">
    		<div class="collapse" id="input-data-pembelian">
	    		<div class="card">
	    			<div class="card-body">
	    				<h4><b>Input Data Pengeluaran</b></h4>
	    				<hr>
	    				
	    				<form action="{{ route('addpembelian.admin') }}" method="POST" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="row">
								<div class="col-md-4">
									<div class="card">
										<div class="card-body">
											<div class="form-group">
												<label>Tanggal</label>
												<input type="date" class="form-control" name="tanggal" required="">
											</div>
											<div class="form-group">
												<label>Total Pengeluaran</label>
												<input type="text" class="form-control" name="total" placeholder="Rp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
											</div>
											<div style="margin-top: 2%;">
												<label for="">Bukti Pembayaran : </label><br>
												<input type="file" id="gambar" name="gambar">
												<p style="color: red; font-size: 12px;">*ukuran maksimal 1MB</p>
											</div>	
										</div>
									</div>
								</div>						
	    						<div class="col">
	    							<div class="card">
	    								<div class="card-body">
		    								<textarea name="keterangan" id="" cols="30" rows="5" class="form-control" placeholder="Catatan....."></textarea>
											<div class="text-right">
												<br>
												<input type="submit" value="simpan" name="submit" class="btn btn-primary">
											</div>
										</div>
	    							</div>
								</div>
							</div>
						</form>
	    			</div>
	    		</div>
	    	</div>
    	</div>
    </div>  
	<div class="row">
		<div class="col-md-12">
			<div class="card">
			  <div class="card-body">
			  	<h3><b>Data Pengeluaran</b></h3>
			  	<hr>
				<div class="table-responsive">
					<table class="table table-hover text-center" id="data-pembelian">
						<thead class="thead-light">
							<tr>
								<th width="5%">No</th>
								<th width="15%">Tanggal</th>
								<th width="15%">Total Pengeluaran</th>
								<th>Keterangan</th>
								<th width="20%">Bukti Pembayaran & Edit</th>
							</tr>
						</thead>
						<tbody>
							@php
								$i = 1;
							@endphp
							@foreach($data_pengeluaran as $key)
							<tr>
								<td>{{$i++}}</td>
								<td>{{date('d F Y', strtotime($key->tanggal))}}</td>
								<td>Rp {{number_format($key->total,0,'.','.')}}</td>
								<td>{{$key->keterangan}}</td>
								<td><a href="{{ route('detailpembelian.admin',$key->id_pembelian)}}" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-info fa-1x"></i></a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			  </div>
			</div>
		</div>
	</div>
@endsection
			