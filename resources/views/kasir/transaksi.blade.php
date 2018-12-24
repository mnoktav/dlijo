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
    <ul class="nav nav-pills nav-pills-icons" role="tablist">
	    <!--
	        color-classes: "nav-pills-primary", "nav-pills-info", "nav-pills-success", "nav-pills-warning","nav-pills-danger"
	    -->
	    <li class="nav-item" style="background-color: white; border-radius: 5px; margin-right: 1%;">
	        <a class="nav-link active" href="#berhasil" role="tab" data-toggle="tab">
	            <i class="fas fa-check-square" style="color: green;"></i>
	            Transaksi Sukses
	        </a>
	    </li>
	    <li class="nav-item" style="background-color: white; border-radius: 5px;">
	        <a class="nav-link" href="#gagal" role="tab" data-toggle="tab">
	            <i class="fas fa-window-close" style="color: red;"></i>
	            Transaksi Batal
	        </a>
	    </li>
	</ul>
	<div class="card">
	  	<div class="card-body">
			<div class="tab-content tab-space">
			    <div class="tab-pane active" id="berhasil">
			    	<div class="row" style="padding: 0 15px; margin-bottom: 2%;">
			    		<div class="col-sm-3 text-center" style="background-color: #defcdb; margin-bottom: 1%; padding-top: 1%; border-radius: 5px;">
			    			<h5><b>Transaksi Berhasil</b></h5>
			    		</div>
			    	</div>
			    	<div class="table-responsive">
			      		<table class="table" id="lunas">
						    <thead class="text-center">
						        <tr>
						            <th>No.</th>
						            <th>No. Nota</th>
						            <th>Tanggal Transaksi</th>
						            <th>Total Bayar</th>
						            <th>Actions</th>
						        </tr>
						    </thead>
						    <tbody class="text-center">
						    	@php
						    		$i=1;
						    	@endphp
						    	@foreach ($penjualan as $key)
						        <tr>
						            <td class="text-center">{{$i++}}</td>
						            <td><b>{{$key->nomor_nota.' '}}</b> @if ($key->delivery == 1)
						            	<sup>*</sup>
						            @endif</td>
						            <td>{{ date('d F Y, H:i',strtotime($key->created_at))}}</td>
						            <td>Rp {{number_format($key->total_bayar,0,'.','.')}}</td>
						            <td>
						                <a href="{{ route('detailtransaksi.kasir',$key->nomor_nota) }}" class="btn btn-info btn-sm" target="_blank">
						                    <i class="fas fa-info"></i>
						                </a>
						                <button type="button" rel="tooltip" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_transaksi" data-nota="{{$key->nomor_nota}}">
						                    <i class="fas fa-times"></i>
						                </button> 
						            </td>
						        </tr>
						        @endforeach
								
						    </tbody>
						</table>	
					</div>
			    </div>
			    <div class="tab-pane" id="gagal">
			    	<div class="row" style="padding: 0 15px; margin-bottom: 2%">
			    		<div class="col-sm-3 text-center" style="background-color: #fcdbdb; margin-bottom: 1%; padding-top: 1%; border-radius: 5px;">
			    			<h5><b>Transaksi Dibatalkan</b></h5>
			    		</div>
			    	</div>
			    	<div class="table-responsive">
				      	<table class="table" id="batal">
						    <thead class="text-center">
						        <tr>
						            <th>No.</th>
						            <th>No. Nota</th>
						            <th>Tanggal Transaksi</th>
						            <th>Total Bayar</th>
						            <th>Actions</th>
						        </tr>
						    </thead>
						    <tbody class="text-center">
						        @php
						    		$i=1;
						    	@endphp
						    	@foreach ($batal as $key)
						        <tr>
						            <td class="text-center">{{$i++}}</td>
						            <td><b>{{$key->nomor_nota}}</b></td>
						            <td>{{ date('d F Y, H:i',strtotime($key->created_at))}}</td>
						            <td>Rp {{number_format($key->total_bayar,0,'.','.')}}</td>
						            <td>
						                <a href="{{ route('detailtransaksi.kasir',$key->nomor_nota) }}" class="btn btn-info btn-sm" target="_blank">
						                    <i class="fas fa-info"></i>
						                </a>
						                <button type="button" rel="tooltip" class="btn btn-success btn-sm" data-toggle="modal" data-target="#restore_transaksi" data-nota="{{$key->nomor_nota}}">
						                    <i class="fas fa-undo"></i>
						                </button> 
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
	{{-- hapus --}}
	<div class="modal fade" id="delete_transaksi" tabindex="-1" role="dialog" aria-labelledby="hapus_transaksi" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Batalkan Data Transaksi</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="{{ route('deletetransaksi.kasir') }}" method="post">
	      	{{csrf_field()}}
	      <div class="modal-body">
	        Yakin ingin membatalkan transaksi ini?
			<input type="hidden" id="nota" value="" name="nota">
	      </div>
	      <div class="modal-footer">
	      	<button type="submit" class="btn btn-primary">Ya</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
	      </div>
	      </form>
	    </div>
	  </div>
	</div>
	{{-- restore --}}
	<div class="modal fade" id="restore_transaksi" tabindex="-1" role="dialog" aria-labelledby="restore_transaksi" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Batalkan Data Transaksi</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="{{ route('restoretransaksi.kasir') }}" method="post">
	      {{csrf_field()}}
	      <div class="modal-body">
	        Yakin ingin mengembalikan transaksi ini?
	        <input type="hidden" id="nota" value="" name="nota">
	      </div>
	      <div class="modal-footer">
	      	<button type="submit" class="btn btn-primary">Ya</button>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
	      </div>
	  	  </form>
	    </div>
	  </div>
	</div>
@endsection