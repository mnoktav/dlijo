
@extends('admin/template')

@section('title')
	{{$data}}
@endsection

@section('navbar')

	<a class="navbar-brand" href="">{{$data}}</a>

@endsection

@section('content') 
	<ul class="nav nav-pills nav-pills-icons" role="tablist">
	    <!--
	        color-classes: "nav-pills-primary", "nav-pills-info", "nav-pills-success", "nav-pills-warning","nav-pills-danger"
	    -->
	    <li class="nav-item" style="background-color: white; border-radius: 5px; margin-right: 1%;">
	        <a class="nav-link active" href="#berhasil" role="tab" data-toggle="tab">
	            <i class="fas fa-check-square" style="color: green"></i>
	             Transaksi Sukses
	        </a>
	    </li>
	    <li class="nav-item" style="background-color: white; border-radius: 5px;">
	        <a class="nav-link" href="#gagal" role="tab" data-toggle="tab">
	            <i class="fas fa-window-close" style="color: red"></i>
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
						    <thead class="thead-light text-center">
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
						            <td><b>{{$key->nomor_nota}}</b>@if ($key->delivery == 1)
						            	<sup>*</sup>
						            @endif
						            </td>
						            <td>{{ date('d F Y, H:i',strtotime($key->created_at))}}</td>
						            <td>Rp {{number_format($key->total_bayar,0,'.','.')}}</td>
						            <td>
						                <a href="{{ route('detailtransaksi.kasir',$key->nomor_nota) }}" class="btn btn-info btn-sm" target="_blank">
						                    <i class="fas fa-info"></i>
						                </a>
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
						    <thead class="thead-light text-center">
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
						                </div>
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
