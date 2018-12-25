<table class="table table-bordered text-center" id="chart">

	<tr>
		<th colspan="7">Laporan Penjualan Tanggal {{date('d F Y', strtotime($tanggal))}}</th>
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

	@foreach ($details as $detail)
		<tr>
			<td>{{$detail->nomor_nota}}</td>
			<td style="text-transform: capitalize;">{{$detail->nama_produk}}</td>
			<td>{{$detail->jumlah}}</td>
			<td>{{$detail->subtotal}}</td>
			<td>
				{{$detail->potongan_harga}}
			</td>
			<td>
				{{$detail->subtotal2}}
			</td>
			<td>{{date('d F Y  h:i',strtotime($detail->created_at))}}</td>
		</tr>
	@endforeach

	<tr>
		<th colspan="7"></th>
	</tr>

	<tr>
		<th colspan="7">Data Produk Terjual Tanggal {{date('d F Y', strtotime($tanggal))}}</th>
	</tr>
	
	<tr>
		<th>Produk</th>
		<th>Jumlah</th>
		<th>Total</th>
	</tr>

	@foreach($produk as $produk)
  	<tr>
       <td>{{$produk->nama_produk}}</td>
       <td>{{$produk->jumlah}}</td>
       <td>{{$produk->total}}</td>
  	</tr>
   	@endforeach

</table>