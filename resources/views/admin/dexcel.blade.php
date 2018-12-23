<table class="table table-bordered text-center" id="chart">
	<thead>
		<tr>
			<th colspan="7">Laporan Penjualan Bulan {{$bulan.' '.$tahun}}</th>
		</tr>
		<tr>
			<th>Nomor Nota</th>
			<th>Produk</th>
			<th>Jumlah</th>
			<th>Total</th>
			<th>Potongan Harga</th>
			<th>Total Bayar</th>
			<th>Tanggal</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($details as $detail)
			<tr>
				<td>{{$detail->nomor_nota}}</td>
				<td style="text-transform: capitalize;">{{$detail->nama_produk}}</td>
				<td>{{$detail->jumlah}}</td>
				<td>Rp {{number_format($detail->subtotal2,0,'.','.')}}</td>
				<td>
					Rp {{number_format($detail->potongan_harga,0,'.','.')}}
				</td>
				<td>Rp
					{{number_format($detail->subtotal,0,'.','.')}}
				</td>
				<td>{{date('d F Y  h:i',strtotime($detail->created_at))}}</td>
			</tr>
		@endforeach
	</tbody>
</table>