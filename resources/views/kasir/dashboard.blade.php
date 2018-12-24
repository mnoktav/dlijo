
@extends('kasir/template')

@section('title')
	{{$data}}
@endsection

@section('navbar')

	<a class="navbar-brand" href="">{{$data}}</a>

@endsection

@section('content')

	@if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
        	<a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
                <strong>{{ $message }}</strong>
        </div>
    @endif 
    @if ($message = Session::get('kosong'))
        <div class="alert alert-warning alert-block">
        	<a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
                <strong>{{ $message }}</strong>
        </div>
    @endif

	<div class="row">
		{{-- produk --}}
		<div class="col-md-6">
			<div class="card card-nav-tabs">
			  <div class="card-header card-header-danger text-center">
	 		   Produk
			  </div>
			  <div class="card-body">
			  	<div class="table-responsive" style="margin-top: 10px;">
			  		<style>
			  			#kasir-produk th {
							font-weight: bolder;
			  			}
			  		</style>
			  		<table class="table text-center" id="kasir-produk">
			  			<thead>
			  				<tr>
			  					<th colspan="2">Jenis Produk</th>
			  					<th>Kategori</th>
			  					<th>Harga(kg/satuan)</th>
			  					<th>Stok</th>
			  					<th></th>
			  				</tr>
			  			</thead>
			  			<tbody>
			  				@foreach($produk as $produk)
			  				<tr>
			  					<td>
			  						<img src="
					    				@if ($produk->gambar != '')
					    					../img/{{$produk->gambar}}
					    				@else
					    					../img/no.jpg
					    				@endif" style="width: 60px; height: 60px;">
			  					</td>
			  					<td style="text-transform: capitalize; text-align: left;"><b>{{$produk->nama_produk}}</b></td>
			  					<td style="text-transform: capitalize;">
			  						@foreach ($cat as $kategori)
			  							@if ($kategori->id_kat == $produk->id_kat)
			  								{{$kategori->nama_kategori}}
			  							@endif
			  						@endforeach
			  					</td>
			  					<td>Rp {{number_format($produk->harga_jual,0,'.','.')}}</td>
			  					<td>
			  						&plusmn;
								@if ($produk->stok != NULL)
									{{$produk->stok}}
								@else
									{{'-'}}
								@endif
								@php
									if($produk->satuan=='gram'){
		    							$satuan = 'kg';
		    						}else{
		    							$satuan = $produk->satuan;
		    						}
								@endphp
								{{$satuan}}
			  					</td>
			  					<td>
			  						<a href="{{ route('addtocart.kasir',$produk->id_produk) }}" class="btn btn-success btn-sm"><i class="fas fa-plus-circle"></i></a>
			  					</td>
			  				</tr>
			  				@endforeach
			  			</tbody>
			  		</table>
			  	</div>
			  </div>
			</div>
		</div>

		{{-- Keranjang --}}
		<div class="col-md-6">
			<form action="{{ route('nota.kasir') }}" method="post">
				{{csrf_field()}}
			<div class="card card-nav-tabs">
			  <div class="card-header card-header-primary text-center">
	 		   Keranjang
			  </div>
			  <div class="card-body">
			  	<div class="row" style="padding: 2%;">
				    <div class="table-responsive">
	                    <table class="table table-striped table-bordered">
	                      <thead class="thead-light text-center text-primary">
	                      	<tr>
	                      		<th width="25%">Produk</th>
	                      		<th width="15%">Jumlah</th>
	                      		<th>Satuan</th>
	                      		<th>Potongan</th>
	                      		<th width="18%">Subtotal</th>
	                      		
	                      		<th>-</th>
	                      	</tr>
	                      </thead>
	                      <tbody class="text-center">
	                      	@php
	                      		$total=0
	                      	@endphp

	                      	@if(session('cart'))
	            				@foreach(session('cart') as $id => $details)
	            				@php
	            					if($details['satuan']=='gram'){
	            						$sub = $details['harga'] * $details['jumlah']/1000 - $details['potongan'];
	            					
	            					}
	            					else{
	            						$sub = $details['harga'] * $details['jumlah'] - $details['potongan'];
	            					}
	            					$total += $sub;
	        
	            				@endphp
	                      	<tr>
								<td style="text-transform: uppercase;">
									<b>{{ $details['nama_produk'] }}</b>
									<input type="hidden" name="id_produk[]" value="{{$id}}">
								</td>
								<td> 
	                          		<input type="number" name="jumlah[]" class="form-control jumlah" value="{{ $details['jumlah'] }}">
	                      		</td>
	                      		<td>
	                      			{{ $details['satuan'] }}
	                      			<input type="hidden" name="satuan[]" class="form-control jumlah" value="{{ $details['satuan'] }}">
	                      		</td>
	                      		<td>
	                      			<input type="text" name="potongan[]" value="{{$details['potongan']}}" class="form-control potongan" placeholder="Rp">
	                      		</td>
	                      		<td>
	                      			Rp {{ number_format($sub,0,'.','.') }}
	                      			<input type="hidden" name="subtotal[]" value="{{$sub}}">
	                      		</td>
	                      		<td>
	                      			<button class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fas fa-sync-alt"></i></button>
	                      			<button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fas fa-trash"></i></button>
	                      		</td>
	                      	</tr>
	                      		@endforeach
	                      	@endif
	                      </tbody>
				    	</table>
				    </div>
				</div>
				<hr>
				<div class="row" style="margin-top: -5%; ">
			    	<div class="col">
			    		<div class="card">
				    		<div class="card-body">
				    			<div class="col">
									<h6 align="center">Total Bayar</h6>
									<h3 align="center">Rp {{$total}}</span></h3>
									<input type="hidden" value="{{$total}}" id="tots_bayar" name="tots_bayar">
						    	</div>
				    		</div>
				    	</div>
			    	</div>
			    </div>
				<div class="row text-center" style="margin-top: -5%;">
					<div class="col">
						<div class="card">
							<div class="card-body">						
					    		<label for="">Pembayaran</label>
					    		<div class="input-group mb-3">
								  <div class="input-group-prepend">
								    <span class="input-group-text" id="basic-addon1">Rp</span>
								  </div>
								  <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="pembayaran" class="form-control uang" id="bayar" required="" >
								</div>
					    	</div>
						</div>
					</div>
	    			<div class="col">
	    				<div class="card">
							<div class="card-body">	
			    				<label for="">Kembali</label>
			    				<div class="input-group mb-3">
								  <div class="input-group-prepend">
								    <span class="input-group-text" id="basic-addon1">Rp</span>
								  </div>
								  <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="uang_kembali" class="form-control uang" readonly="" data-a-dec="," data-a-sep="." id="kembali">
								</div>
							</div>
						</div>
	    			</div>
	    		</div>
			    
			    <div class="row" style="margin-bottom: 20px; padding: 0 1%;">
			    	<div class="col">
			    		<input type="checkbox" id="delivery" value="1" name="delivery"> Delivery
			    		<div class="card" id="deliv">
			    			<div class="card-body">
			    				<input type="text" name="nama_pelanggan" class="form-control" placeholder="Nama Pelanggan" id="nama_pelanggan">
			    				<textarea name="alamat_pelanggan" id="alamat_pelanggan" rows="3" class="form-control" placeholder="Alamat Pelanggan"></textarea>
			    			</div>
			    		</div>
			    		
			    	</div>
			    </div>
			    <div class="row">
	    			<div class="col text-center">
	    				<a href="{{ route('removecart.kasir') }}" class="btn btn-danger">Batalkan</a>
	    				<button type="submit" class="btn btn-warning">Simpan & Cetak</button>
	    				<input type="submit" value="simpan" name="simpan" class="btn btn-success">
	    			</div>
	    		</div>
			    
			  </div>
			</div>
			</form>
		</div>
	</div>
	<style>
		#kasir-produk thead .sorting, 
		#kasir-produk thead .sorting_asc, 
		#kasir-produk thead .sorting_desc {
		    background : none;
		}
	</style>
@endsection
