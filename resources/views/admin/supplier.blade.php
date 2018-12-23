
@extends('admin/template')

@section('title')
	{{$data}}
@endsection

@section('navbar')

	<a class="navbar-brand" href="">{{$data}}</a>

@endsection

@section('content') 
	@if (\Session::has('success'))       
        <div class="alert alert-success">
            <a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>           
            <p>{{ \Session::get('success') }}</p>       
        </div><br/> 
    @endif 
    <div class="row">
		<div class="col">
			<button class="btn btn-success" type="button" data-toggle="collapse" data-target="#input-data-supplier" aria-expanded="false" aria-controls="input-data-supplier">
		    Tambah Data</button>
		</div>
    </div>
    <div class="row">
    	<div class="col">
    		<div class="collapse" id="input-data-supplier">
    			<div class="card card-nav-tabs">
				  	<div class="card-body">
				  		<h4><b>Input Data Supplier</b></h4>
				  		<hr>
				  		<form action="{{ route('addsupplier.admin') }}" method="POST" >
				  			{{csrf_field()}}
				  			<div class="row">
				  				<div class="col-md-8 offset-md-2">
				  					<div class="card-group">
				  					<div class="card card-nav-tabs" id="card-input">
				  						<div class="card-body">
				  							<div class="form-group">
												<label>Nama Supplier</label>
												<input type="text" name="nama_supplier" class="form-control" required="">
											</div>
											<div class="form-group">
												<label>No Telepon </label>
												<input type="text" name="telp" class="form-control" required="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
											</div>
				  						</div>
					  				</div>
									<div class="card card-nav-tabs" id="card-input">
				  						<div class="card-body">
											<div class="form-group">
												<label>Alamat</label>
												<textarea name="alamat" class="form-control" id="" cols="30" rows="4"></textarea>
											</div>
											<div class="form-group">
												<label>Catatan</label>
												<textarea name="catatan" class="form-control" id="" cols="30" rows="4"></textarea>
											</div>
										</div>
									</div>
									</div>
								</div>
				  			</div>
				  			<br> 
				  			<div class="row">
				  				<div class="col-md-10 text-right">
				  					<div class>
										<input type="submit" value="simpan" name="submit" class="btn btn-primary">
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
			  	<h3><b>Data Supplier</b></h3>
			  	<hr>
				<div class="table-responsive">
					<table class="table table-hover" id="supplier">
						<thead class="thead-light">
							<tr>
								<th width="5%">No</th>
								<th width="10%">Nama</th>
								<th width="13%">Telephone</th>
								<th>Alamat</th>
								<th>Catatan</th>
								<th width="13%">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@php
								$i=1;
							@endphp
							@foreach($supplier as $data_supplier)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$data_supplier->nama_supplier}}</td>
								<td>{{$data_supplier->nomor_telephone}}</td>
								<td>{{$data_supplier->alamat}}</td>
								<td>{{$data_supplier->catatan}}</td>
								<td>
									<button data-target="#edit_supplier" data-toggle="modal" data-idsupp="{{$data_supplier->id_supplier}}" data-namasupp="{{$data_supplier->nama_supplier}}" data-telpsupp="{{$data_supplier->nomor_telephone}}" data-alamat="{{$data_supplier->alamat}}" data-catatan="{{$data_supplier->catatan}}" class="btn btn-warning btn-sm"><i class="material-icons">create</i></button>
									<button data-target="#delete_supplier" data-toggle="modal" data-idsupp="{{$data_supplier->id_supplier}}" class="btn btn-danger btn-sm"><i class="material-icons">cancel</i></button>
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

	{{-- modal delete --}}
	<div class="modal fade" id="delete_supplier" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Hapus Data Supplier</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="{{ route('deletesupplier.admin') }}" method="POST">
	      	{{csrf_field()}}
		      <div class="modal-body">
		        Yakin ingin menghapus data supplier ini?
		        <input type="hidden" name="id_supplier" id="id_supplier" value="">
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
	<div class="modal fade" id="edit_supplier" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Edit Data Supplier</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form action="{{ route('updatesupplier.admin') }}" method="POST">
	      	{{csrf_field()}}
		      <div class="modal-body">
		      	<div class="row">
		      		<div class="col">
		      			<div class="form-group">
				        	<h6>Nama Supplier</h6>
							<input type="text" name="nama_supplier" id="nama_supplier" class="form-control" value=" " readonly="">
						</div>
						<div class="form-group">
							<label>No Telepon </label>
							<input type="text" name="telp" id="telp" class="form-control" required="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="">
						</div>
						<div class="form-group">
							<label>Alamat</label>
							<textarea name="alamat" class="form-control" id="alamat" cols="30" rows="5"></textarea>
						</div>
		      		</div>
		      		<div class="col">
		      			
						<div class="form-group">
							<label>Catatan</label>
							<textarea name="catatan" class="form-control" id="catatan" cols="30" rows="12"></textarea>
						</div>
		      		</div>
		      	</div>
		        <div class="row">
		        	<di class="col">
		        		<input type="hidden" name="id_supplier" id="id_supplier" value="">
		        	</di>
		        </div>
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
		#card-input{
			margin: 0px !important;
		}
	</style>
@endsection
