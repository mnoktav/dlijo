
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
		<div class="col">
			<button class="btn btn-success" type="button" data-toggle="collapse" data-target="#input-data-pembelian" aria-expanded="false" aria-controls="input-data-pembelian">
		    Tambah Data</button>
		</div>
    </div>
    <div class="row">
    	<div class="col">
    		<div class="collapse" id="input-data-pembelian">
	    		<div class="card">
	    			<div class="card-body">
	    				<h4><b>Input Data Pembelian</b></h4>
	    				<hr>
	    				
	    				<form action="{{ route('addpembelian.admin') }}" method="POST" enctype="multipart/form-data">
							{{csrf_field()}}
							<div class="row">
								<div class="col-md-4">
									<div class="card">
										<div class="card-body">
											<div class="form-group">
												<label>Supplier</label>
												<select name="supplier" class="form-control" style="text-transform: capitalize;">
													<option value="">- Pilih -</option>
													@foreach ($supplier as $suppliers)
															<option value="{{$suppliers->id_supplier}}" style="text-transform: capitalize;">{{$suppliers->nama_supplier}}</option>
													@endforeach
												</select>
											</div>
											<div class="form-group">
												<label>Tanggal</label>
												<input type="date" class="form-control" name="tanggal" required="">
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
		    								<div class="form-group">
				    							<table class="table table-striped" id="dynamic_field"> 
				    								<tr>
				    									<th width="20%">Produk</th>
				    									<th width="20%">Jumlah (kg/satuan)</th>
				    									<th width="25%">Total</th>
				    									<th>Keterangan</th>
				    								</tr> 
				                                    <tr>  
				                                        <td>
				                                        	<select name="produk" id="produk" class="form-control produk_list">
				                                        		<option>- Pilih -</option>
				                                        		@foreach ($produk as $produk)
				                                        			<option value="{{$produk->id_produk}}">{{$produk->nama_produk}}</option>
				                                        		@endforeach
				                                        		
				                                        	</select>
				                                       	</td>
				                                        <td>
				                                        	<input type="number" name="jumlah" class="form-control jumlah_list" min="0" />
				                                        </td>
				                                        <th>
				                                        	<input type="text" name="total_bayar" class="form-control total_list" placeholder="Rp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"/>
				                                        </th>
				                                        <th>
				                                        	<input type="text" name="Keterangan" class="form-control ket_list" />
				                                        </th>     
				                                    </tr>  
				                               	</table>
				                            </div>
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
			  	<h3><b>Data Pembelian</b></h3>
			  	<hr>
				<div class="table-responsive">
					<table class="table table-hover text-center" id="data-pembelian">
						<thead class="thead-light">
							<tr>
								<th width="5%">No</th>
								<th>Tanggal</th>
								<th width="15%">Produk</th>
								<th width="10%">Jumlah</th>
								<th>Supplier</th>
								<th width="20%">-</th>
							</tr>
						</thead>
						<tbody>
							@php
								$i=1;
							@endphp
							@foreach ($pembelian as $beli)
							@php
								if($beli->satuan=='gram'){
		    						$satuan = 'kg';
		    					}else{
		    						$satuan = $beli->satuan;
		    					}
							@endphp
							<tr>
								<td>{{$i++}}</td>
								<td>{{date('d F Y', strtotime($beli->tanggal))}}</td>
								<td style="text-transform: capitalize;">{{$beli->nama_produk}}</td>
								<td>{{$beli->jumlah.' '.$satuan}}</td>
								<td>{{$beli->nama_supplier}}</td>
								<td>
									<a href="{{ route('detailpembelian.admin',$beli->id_pembelian) }}" class="btn btn-info btn-sm" target="_blank">
						                <i class="material-icons">info</i>
						            </a>
								</td>
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
			