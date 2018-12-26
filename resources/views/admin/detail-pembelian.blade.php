@extends('admin/templates')

@section('title')
	{{$data}}
@endsection

@section('navbar')
	<a class="navbar-brand" href="">Transaksi <i class="material-icons">keyboard_arrow_right</i>{{$data}}</a>
@endsection

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
        	<a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
                <strong>{{ $message }}</strong>
        </div>
    @endif
@foreach ($pembelian as $beli)
<div class="row" style="margin-top: 1%">
	
</div>
<div class="row">	
	<div class="col-sm-7">
		<div class="row">
			<div class="col-2">
				<button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#edit_pembelian" aria-expanded="false">Edit</button>
			</div>
			<form action="{{ route('deletepembelian.admin') }}" method="POST">
				{{csrf_field()}}
				<input type="hidden" value="{{$beli->id_pembelian}}" name="id_pembelian">
				<input type="submit" value="hapus" name="hapus" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data pengeluaran ini? *Data tidak akan bisa dikembalikan')">
			</form>
		</div>
		<div class="collapse" id="edit_pembelian">
		  	<div class="card card-body col-sm-12">
		  		<div class="row">
		  			<div class="col">
		  			<form action="{{ route('updatepembelian.admin') }}" method="POST" enctype="multipart/form-data">
		    		{{csrf_field()}}
						<div class="form-group">
							<label>Total Pengeluaran</label>
							<input type="text" class="form-control" name="total" placeholder="Rp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{$beli->total}}">
						</div>
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
		<div style="background-color: white; padding:20px; border-radius: 5px; margin-top: 1%; ">
			<div class="row">
		    	<div class="col">
		    		<table>
		    			<tr>
		    				<td width="140">Tanggal</td>
		    				<td width="10">:</td>
		    				<td>{{date('d F Y',strtotime($beli->tanggal))}}</td>
		    			</tr>
		    			<tr>
		    				<td>Total Pengeluaran</td>
		    				<td>:</td>
		    				<td>Rp {{number_format($beli->total,0,'.','.')}}</td>
		    			</tr>
		    			<tr>
		    				<td style="vertical-align: top;">Keterangan</td>
		    				<td style="vertical-align: top;">:</td>
		    				<td>
		    					@if($beli->keterangan == null)
		    					{{'Tidak ada catatan'}}
		    					@else
		    					{{$beli->keterangan}}
		    					@endif
		    				</td>
		    			</tr>		    			
		    		</table>
		    	</div>
		    </div>
	    </div>
	</div>
	<div class="col-sm-3">
		<div style="padding:20px;">
			<h3>Bukti Pembayaran :</h3>
			@if ($beli->bukti_pembayaran == '')
				{{'Tidak ada bukti pembayaran'}}
			@else
				<img src="{{ asset('img/'.$beli->bukti_pembayaran) }}" alt="" width="420">
			@endif
		</div>
	</div>
</div> 

@endforeach
<style>
	td{
		line-height:2rem;
	}
</style>
@endsection