
@extends('admin/template')

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
    @if ($message = Session::get('gagal'))
        <div class="alert alert-danger alert-block">
        	<a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
                <strong style="text-transform: capitalize;">{{ $message }}</strong>
        </div>
    @endif
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<form action="{{ route('updatestok.admin') }}" method="POST">
						{{csrf_field()}}
						<div class="table-responsive">
							<table class="table table-striped" id="update-stok">
								<thead class="thead-light text-center">
									<tr>
										<th>Nama Produk</th>
										<th>Stok Produk Sekarang</th>
										<th>Update Stok Produk</th>
										<th>Satuan</th>
										<th>Terakhir Update (Jumlah)</th>
									</tr>
								</thead>
								<tbody>
									@foreach($cek as $cek)
									<tr>
										<input type="hidden" value="{{$cek->id_produk}}" name="id_produk[]">
										<td style="text-transform: capitalize;">{{$cek->nama_produk}}</td>
										<td><input class="form-control" name="stok[]" type="number" value="{{$cek->stok}}" readonly=""></td>
										<td><input class="form-control" name="update_stok[]" type="text" value="{{$cek->stok}}"></td>
										<td align="center" style="text-transform: capitalize;">
											@if($cek->satuan == 'gram')
											{{'kg'}}
											@else
											{{$cek->satuan}}
											@endif
										</td>
										<td align="center">
											@if($cek->update_stok_at != null && $cek->update_stok != null)
												{{date('d F Y h:i', strtotime($cek->update_stok_at)).' ('.$cek->update_stok.')'}}
												@else
												{{'-'}}
											@endif
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="row">
							<div class="col-2 offset-5">
								<br>
								<input type="submit" name="submit" value="update" class="btn btn-warning form-control">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
