
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
    @if ($message = Session::get('gagal'))
        <div class="alert alert-danger alert-block">
        	<a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
                <strong style="text-transform: capitalize;">{{ $message }}</strong>
        </div>
    @endif
    <div class="row">
		<div class="col">
			<button class="btn btn-success" type="button" data-toggle="collapse" data-target="#inputdata">Tambah Data</button>
			<a href="{{ route('cekstok.admin') }}" class="btn btn-rose">Update Stok</a>
		</div>
	</div> 
	<div class="row">
		<div class="col-md-12">
			<div class="collapse" id="inputdata">
				<div class="card-group">
					<div class="card card-nav-tabs">
					  	<div class="card-body">
					  		<h4><b>Input Kategori Produk</b></h4>
					  		<hr>
					  		<div class="card">
					  			<div class="card-body">
					  				<form action="{{ route('addkategori.admin') }}" method="POST" enctype="multipart/form-data">
										{{csrf_field()}}
										<div class="form-group">
											<label>Nama Kategori</label>
											<input type="text" name="nama_kategori" class="form-control" required="">
										</div>
										<br>
										<div class="text-right">
											<input type="submit" value="simpan" name="submit" class="btn btn-primary">
										</div>
									</form>
					  			</div>
					  		</div>
					  	</div>
					</div>
					<div class="card card-nav-tabs">
					  	<div class="card-body">
					  		<h4><b>Input Data Produk</b></h4>
					  		<hr>
					  		<div class="card">
					  			<div class="card-body">
					  				<form action="{{ route('addproduk.admin') }}" method="POST" enctype="multipart/form-data">
										{{csrf_field()}}
										<div class="form-group">
											<label>Kategori Produk</label>
											<select name="produk_cat" id="produk_cat" class="form-control" style="text-transform: capitalize;" required="">
												@foreach ($cat as $kat)
													<option style="text-transform: capitalize;" value="{{$kat->id_kat}}">{{$kat->nama_kategori}}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group">
											<label>Nama Produk</label>
											<input type="text" name="nama_produk" class="form-control" required="">
										</div>
										<div class="form-group">
											<label>Satuan</label>
											<select name="satuan" class="form-control" required="">
												<option value="gram">gram</option>
												<option value="kg">kilogram</option>
												<option value="pcs">pcs</option>
											</select>
										</div>
										<div class="form-group">
											<label>Harga Jual (per kg/satuan)</label>
											<input type="text" name="harga" class="form-control" required="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
										</div>
										<div>
											<label for="">Gambar (max : 1MB) </label><br>
											<input type="file" id="file" name="gambar">
										</div>
										<div class="text-right">
											<input type="submit" value="simpan" name="submit" class="btn btn-primary">
										</div>
									</form>
					  			</div>	
							</div>
					  	</div>
					</div>
				</div>
			</div>
		</div>	
	</div>
	<div class="row" style="">
		<div class="col-md-9">
			<div class="card card-nav-tabs">
			  <div class="card-body">
			  	<div class="row">
			  		<div class="col-sm-8">
			  			<h3><b>Produk</b></h3>
			  		</div>
			  		<div class="col-sm-2 mt-4 text-right">
			  			<label>Kategori :</label>
			  		</div>
			  		<div class="col-sm-2">
				  		<div class="card" style="margin: 0px !important;">
				  			<div class="card-body">
					  			<form action="{{ route('produk.admin') }}" method="get">
						  			{{csrf_field()}}
								  	<select name="produk_cat" id="produk_cat" class="form-control" style="text-transform: capitalize;" oninput=' this.form.submit(); '>
							  			<option value="">Semua</option>
										@foreach ($kategori as $kat)
											<option style="text-transform: capitalize;" @if ($selected == $kat->id_kat)
												{{'selected'}}
											@endif value="{{$kat->id_kat}}">{{$kat->nama_kategori}}</option>
										@endforeach
									</select>
								</form>
				  			</div>
				  		</div>
			  		</div>
			  	</div>
			  	<hr>
			  	<div class="row" style="padding: 10px; margin-top: 0px !important;">	
			  	@foreach ($produk as $produks)			
				    <div class="col-sm-4" style="padding: 1%;">
				    	<table class="table table-bordered" id="product-table">
				    		<tr>
				    			<td rowspan="4" width="100"><img src="
				    		@if ($produks->gambar != '')
				    			../img/{{$produks->gambar}}
				    		@else
				    			../img/no.jpg
				    		@endif" style="width: 100px; height: 100px;"></td>
				    			<td style="text-transform: capitalize; font-weight: bolder;"><b>{{$produks->nama_produk}}</b></td>
				    		</tr>
				    		<tr>
				    			<td style="text-transform: capitalize;">Kategori : 
				    				@foreach ($kategori as $key)
				    					@if ($key->id_kat == $produks->id_kat)
				    						{{$key->nama_kategori}}
				    					@endif
				    				@endforeach
				    			</td>
				    		</tr>
				    		<tr>
				    		@php
		    					if($produks->satuan=='gram'){
		    						$satuan = 'kg';
		    					}else{
		    						$satuan = $produks->satuan;
		    					}
		    				@endphp	
				    			<td>Harga : Rp {{number_format($produks->harga_jual,0,'.','.')}}/{{$satuan}}</td>
				    		</tr>
				    		<tr>
				    			<td>Stok : &plusmn;
									@if ($produks->stok != NULL)
										{{$produks->stok}}
									@else
										{{'-'}}
									@endif
									
				    				{{$satuan}}
								</td>
				    		</tr>
				    		
				    		<tr>
				    			<td colspan="2">
				    				<div class="text-center">
				    					<button class="btn btn-warning btn-sm" data-target="#edit_produk" data-toggle="modal" title="edit" data-produk="{{$produks->id_produk}}" data-harga="{{$produks->harga_jual}}" data-namaproduk="{{$produks->nama_produk}}" data-cat="{{$produks->id_kat}}" data-sat="{{$produks->satuan}}"><i class="fas fa-edit"></i></button>
										<button class="btn btn-danger btn-sm" data-target="#delete_produk" data-toggle="modal" title="hapus" data-produk="{{$produks->id_produk}}">
											<i class="fas fa-trash"></i></button>
				    				</div>
								</td>
				    		</tr>
				    	</table>
				    </div>
				    @endforeach
			    </div>
			  </div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="card card-nav-tabs">
			  	<div class="card-body">
			  		<h4><b>Daftar Kategori Produk</b></h4>
			  		<table class="table">
			  			<tr>
			  				<th>Nama</th>
			  				<th>Hapus</th>
			  			</tr>
			  			@foreach ($cat as $kats)
			  			<tr>
			  				<td>{{$kats->nama_kategori}}</td>
			  				<td>
			  					<a href="{{ route('deletekategori.admin',$kats->id_kat) }}" title="hapus"><i class="fas fa-trash text-danger"></i></a>
			  				</td>
			  			</tr>
			  			@endforeach
			  		</table>	
			  	</div>
			  	<div class="card-footer">
			  		<p class="text-danger" style="font-size: 12px;">*Sebelum menghapus kategori, hapus terlebih dahulu produk di dalam kategori yang akan dihapus!!!</p>
			  	</div>
			</div>
		</div>
	</div>

	{{-- modal delete --}}
	<div class="modal fade" id="delete_produk" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Hapus Produk</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="{{ route('deleteproduk.admin') }}" method="POST">
	      	{{csrf_field()}}
		      <div class="modal-body">
		        Yakin ingin menghapus produk ini?
		        <input type="hidden" name="id_produk" id="id_produk" value="">
		      </div>
		      <div class="modal-footer">
		      	<button type="submit" class="btn btn-primary">Ya</button>
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
		      </div>
	      </form>
	    </div>
	  </div>
	</div>
	{{-- modal edit --}}
	<div class="modal fade" id="edit_produk" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Edit Data Supplier</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="{{ route('updateproduk.admin') }}" method="POST" enctype="multipart/form-data"> 
	      	{{csrf_field()}}
		      <div class="modal-body">
		        <div class="form-group">
					<label>Nama Produk</label>
					<input type="text" name="nama_produk" id="nama_produk" class="form-control" value=""  required="">
				</div>
				<div class="form-group">
					<label>Satuan</label>
					<select name="satuan" id="satuan" class="form-control" required="">
						<option value="gram">gram</option>
						<option value="kg">kilogram</option>
						<option value="pcs">pcs</option>
					</select>
				</div>
				<div class="form-group">
					<label>Kategori Produk</label>
					<select name="produk_cat" id="produk_cat" class="form-control" style="text-transform: capitalize;" required="">
						@foreach ($kategori as $kategoris)
							<option style="text-transform: capitalize;" value="{{$kategoris->id_kat}}">{{$kategoris->nama_kategori}}</option>
						@endforeach
					</select>
				</div>
				<br>
				<div class="form-group">
					<label>Harga Jual (per kg/satuan)</label>
					<input type="text" name="harga" id="harga" class="form-control" value="" required="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
				</div>
				<div>
					<label for="">Gambar (max : 1MB) </label><br>
					<input type="file" id="gambar" name="gambar">
					<p class="text-danger" style="font-size: 12px;">*isi jika gambar ingin diganti</p>
				</div>
		        <input type="hidden" name="id_produk" id="id_produk" value="">
		      </div>
		      <div class="modal-footer">
		      	<input type="submit" value="ya" name="submit" class="btn btn-primary">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
		      </div>
	      </form>
	    </div>
	  </div>
	</div>
	<style>
		#product-table td{
			font-size: 13px;
		}
	</style>
@endsection
