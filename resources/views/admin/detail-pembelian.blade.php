@extends('admin/templates')

@section('title')
	{{$data}}
@endsection

@section('navbar')
	<a class="navbar-brand" href="">Transaksi <i class="material-icons">keyboard_arrow_right</i>{{$data}}</a>
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
@foreach ($pembelian as $beli)
<div class="row">	
	<div class="col-sm-7">
		<div style="background-color: white; padding:20px; border-radius: 5px; margin-top: 1%; ">
			<div class="row">
		    	<div class="col">
		    		<table>
		    			<tr>
		    				<td width="70">Supplier</td>
		    				<td width="10">:</td>
		    				<td>{{$beli->nama_supplier}}</td>
		    			</tr>
		    			<tr>
		    				<td>Tanggal</td>
		    				<td>:</td>
		    				<td>{{date('d F Y',strtotime($beli->tanggal))}}</td>
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
			    				<th>Jumlah</th>
								<th>Keterangan</th>
			    			</tr>
			    		</thead>
			    		<tbody>
			    			<tr>
			    				<td style="text-transform: capitalize;">{{$beli->nama_produk}}</td>
			    				<td>{{$beli->jumlah}} kg</td>
			    				<td>
			    					@if ($beli->keterangan == '')
			    						{{'-'}}
			    					@else
			    						{{$beli->keterangan}}
			    					@endif
			    					
			    				</td>
			    			</tr>
			    			<tr>
			    				<td colspan="2"><b>TOTAL PEMBAYARAN</b></td>
			    				<td>Rp {{number_format($beli->total_bayar,0,'.','.')}}</td>
			    			</tr>
			    		</tbody>
			    	</table>
			    </div>
		    </div>
		    <div class="row">
		    	<div class="col">
		    		<p>Harga/kg = Rp{{number_format($beli->total_bayar/$beli->jumlah,0,'.','.')}}</p>
		    	</div>
		    </div>
		    <hr>
	    </div>
	</div>
	<div class="col-sm-3">
		<div style="padding:20px;">
			@if ($beli->bukti_pembayaran == '')
				{{'Tidak ada bukti pembayaran'}}
			@else
				<img src="{{ asset('img/'.$beli->bukti_pembayaran) }}" alt="" width="420">
			@endif
		</div>
	</div>
</div> 
<div class="row" style="margin-top: 1%">
	<div class="col">
		<button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#edit_pembelian" aria-expanded="false">
			Edit
		</button>
		<div class="collapse" id="edit_pembelian">
		  	<div class="card card-body col-sm-8">
		  		<div class="row">
		  			<div class="col">
		  			<form action="{{ route('updatepembelian.admin') }}" method="POST" enctype="multipart/form-data">
		    		{{csrf_field()}}
						<div class="form-group">
							<label>Produk</label>
							<select name="produk" class="form-control" style="text-transform: capitalize;">
								@foreach ($produk as $produks)
									<option value="{{$produks->id_produk}}" style="text-transform: capitalize;" @if ($produks->id_produk == $beli->id_produk)
										{{'selected'}}
									@endif>{{$produks->nama_produk}}</option>	
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>Supplier</label>
							<select name="supplier" class="form-control" style="text-transform: capitalize;">
								@foreach ($supplier as $suppliers)
									<option value="{{$suppliers->id_supplier}}" style="text-transform: capitalize;" @if ($suppliers->id_supplier == $beli->id_supplier)
										{{'selected'}}
									@endif>{{$suppliers->nama_supplier}}</option>	
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>Jumlah(kg)</label>
							<input value="{{$beli->jumlah}}" type="number" class="form-control" name="jumlah" required="">
						</div>
						
						<div class="form-group">
							<label>Total Bayar</label>
							<input type="text" class="form-control" name="bayar" placeholder="Rp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{$beli->total_bayar}}">
						</div>
		  			</div>
		  			<div class="col">
		  				<div class="form-group">
							<label>Tanggal</label>
							<input type="date" value="{{$beli->tanggal}}" class="form-control" name="tanggal" required="">
						</div>
		  				<div style="margin-top: 2%;">
							<label for="">Bukti Pembayaran : </label><br>
							<input type="file" id="gambar" name="gambar">
							<p style="color: red; font-size: 12px;">*ukuran maksimal 1MB</p>
						</div>
						<div class="form-group">
							<label>Keterangan :</label>
							<textarea class="form-control" name="keterangan" cols="30" rows="5">{{$beli->keterangan}}</textarea>
						</div>
						<input type="hidden" value="{{$beli->id_pembelian}}" name="id_pembelian">
						<div class="text-right">
							<br>
							<input type="submit" value="simpan" name="submit" class="btn btn-primary">
						</div>
						</form>	
		  			</div>
		  		</div>
		  	</div>
		</div>
	</div>
</div>
@endforeach
<style>
		p{
			font-size: 13px;
		}
    	.table td{
    		text-align: center;
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