
@extends('admin/template')

@section('title')
	{{$data}}
@endsection

@section('navbar')

	<a class="navbar-brand" href="">{{$data}}</a>

@endsection

@section('content')
	<div class="col-lg-12" div="cont">
		<div class="row">
	    	<div class="col text-right">
	    		<p>Update terakhir  @php
	    			echo date('h:i');
	    		@endphp &nbsp;&nbsp;&nbsp;<a href="{{ url('/admin') }}" class="btn btn-primary btn-sm">refresh</button> </a>
	    		
	    	</div>
	    </div> 
		<div class="row">
	        <div class="col-lg-3 col-md-6 col-sm-6">
	          <div class="card card-stats">
	            <div class="card-header card-header-info card-header-icon">
	              <div class="card-icon">
	                <i class="fas fa-store"></i>
	              </div>
	              <p class="card-category">Transaksi Hari Ini</p>
	              <h3 class="card-title"> {{$transaksi_hari_ini}} Transaksi<br> Sukses  </h3>
	            </div>
	            <div class="card-footer">
	            </div>
	          </div>
	        </div>
	        <div class="col-lg-3 col-md-6 col-sm-6">
	          <div class="card card-stats">
	            <div class="card-header card-header-warning card-header-icon">
	              <div class="card-icon">
	                <i class="fas fa-exclamation-triangle"></i>
	              </div>
	              <p class="card-category">T. Batal Hari Ini</p>
	              <h3 class="card-title"> {{$batal}} Transaksi<br> Batal  </h3>
	            </div>
	            <div class="card-footer">
	            </div>
	          </div>
	        </div>
	        <div class="col-lg-3 col-md-6 col-sm-6">
	          <div class="card card-stats">
	            <div class="card-header card-header-success card-header-icon">
	              <div class="card-icon">
	                <i class="fas fa-money-check-alt"></i>
	              </div>
	              <p class="card-category">Pemasukan Bulan Ini</p>
	              <h3 class="card-title">Rp <br>{{number_format($pemasukanperbulan,0,'.','.')}}</h3>
	            </div>
	            <div class="card-footer">
	            </div>
	          </div>
	        </div>
	        <div class="col-lg-3 col-md-6 col-sm-6">
	          <div class="card card-stats">
	            <div class="card-header card-header-danger card-header-icon">
	              <div class="card-icon">
	                <i class="fas fa-tags"></i>
	              </div>
	              <p class="card-category">Total Produk</p>
	              <h3 class="card-title" style="text-transform: capitalize;">
	              	{{$produk}}
	              	<br>Produk
	          	  </h3>
	            </div>
	            <div class="card-footer">
	            </div>
	          </div>
	        </div>
	    </div>
	    <div class="row">
		    <div class="col-md-12">
		      	<div class="card-group">
			      	<div class="card card-nav-tabs">
				        <div class="card-body">
				        	<div class="row">
				        		<div class="col">
				        			<h4 class="card-title">Pemasukan</h4>
				        		</div>
				        		<div class="col offset-md-4">
				        			<ul class="nav nav-pills">
									  <li class="nav-item">
									    <a class="nav-link active" data-toggle="pill" href="#harian">Harian</a>
									  </li>
									  <li class="nav-item">
									    <a class="nav-link" data-toggle="pill" href="#bulanan">Bulanan</a>
									  </li>
									</ul>
				        		</div>
				        	</div>
				        	<br>
				        	<div class="tab-content">
				        		<div class="tab-pane container active" id="harian">
				        			{!! $chart->container() !!}
				        		</div>
				        		<div class="tab-pane container" id="bulanan">
				        			{!! $chart3->container() !!}
				        		</div>
					        </div>	
				        </div>
				    </div>
				    <div class="card card-nav-tabs">
				        <div class="card-body">
				          <h4 class="card-title">Produk Terjual Harian</h4>
				          {!! $chart2->container() !!}
				        </div>
				        <div class="row" style="margin-bottom: 1rem;">
				        	<div class="col-md-3 offset-md-9">
				        		Lihat Detail <a href="{{ route('laporanharian.admin') }}">Disini</a>
				        	</div>
				        </div>
				    </div>
			  	</div>
		    </div>
		</div>
    </div>
    
@endsection
