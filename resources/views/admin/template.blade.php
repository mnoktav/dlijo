<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material/assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    @yield('title') - Admin -
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons|Caveat|Satisfy" />
  
  
  <!-- CSS Files -->
  <link href="{{ asset('material/assets/css/material-dashboard.css?v=2.1.0') }} " rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="azure" data-background-color="black" data-image="{{ asset('img/logo.png') }}">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo text-center">
        <img align="center" class="mt-3" src="{{ asset('img/logo.png') }}" width="80" height="80">
        <a href="http://127.0.0.1:8000/admin" class="simple-text logo-normal" style="font-family: Caveat; font-weight: bold; font-size: 20px;">
          Admin
        </a>
      </div>


      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item @php
            if(Request::segment(2)=='dashboard-admin'){
              echo "active";
            }elseif(Request::segment(1)=='admin' && Request::segment(2)==''){
               echo "active";
            }
          @endphp">
            <a class="nav-link" href="{{route('dashboard.admin')}}">
              <i class="material-icons">dashboard</i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item  {{ Request::segment(2) === 'produk-admin' ? 'active' : null }}">
            <a class="nav-link" href="{{route('produk.admin')}}">
              <i class="material-icons">loyalty</i>
              <p>Produk</p>
            </a>
          </li>
          <li class="nav-item  {{ Request::segment(2) === 'supplier-admin' ? 'active' : null }}">
            <a class="nav-link" href="{{route('supplier.admin')}}">
              <i class="material-icons">recent_actors</i>
              <p>Supplier</p>
            </a>
          </li>
          <li class="nav-item  {{ Request::segment(2) === 'pembelian-admin' ? 'active' : null }}">
            <a class="nav-link" href="{{route('pembelian.admin')}}">
              <i class="material-icons">attach_money</i>
              <p>Data Pembelian</p>
            </a>
          </li>
          <li class="nav-item  {{ Request::segment(2) === 'penjualan-admin' ? 'active' : null }}">
            <a class="nav-link" href="{{route('penjualan.admin')}}">
              <i class="material-icons">account_balance_wallet</i>
              <p>Data Penjualan</p>
            </a>
          </li>
          <li class="nav-item  {{ Request::segment(2) === 'laporan-admin' ? 'active' : null }}">
            <a class="nav-link" href="{{route('laporan.admin')}}">
              <i class="material-icons">timeline</i>
              <p>Laporan</p>
            </a>
          </li>
          <li class="nav-item active-pro ">
            <a class="nav-link" href="#logout" data-toggle="modal">
              <i class="material-icons">open_in_new</i>
              <p>Logout</p>
            </a>
          </li>
          <!-- your sidebar here -->
        </ul>
      </div>
    </div>

    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            @yield('navbar')
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="">
                  username
                  <i class="material-icons">person_pin_circle</i>
                </a>
              </li>
              <!-- your navbar here -->
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->

      <div class="content">
        <div class="container-fluid">
            @yield('content')
        </div>
      </div>


      <footer class="footer">
        <div class="container-fluid">
          <div class="float-left ml-3">
            <img src="{{ asset('img/logo.png') }}" alt="" width="50" height="50">
          </div>
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, MNO | D'Lijo
          </div>
          <!-- your footer here -->
        </div>
      </footer>
    </div>
  </div>
  <!--   modal_logout   -->
  <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="logout" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Yakin ingin keluar?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
          <button type="button" class="btn btn-primary">Ya</button>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="{{ asset('material/assets/js/core/jquery.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('material/assets/js/core/popper.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('material/assets/js/core/bootstrap-material-design.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('material/assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
  <!-- Chartist JS -->
  <script src="{{ asset('material/assets/js/plugins/chartist.min.js') }}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{ asset('material/assets/js/plugins/bootstrap-notify.js') }}"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('material/assets/js/material-dashboard.min.js?v=2.1.0') }}" type="text/javascript"></script>
  <script src="{{ asset('js/datatables.min.js') }}"></script>
  <script src="{{ asset('highchart/highcharts.src.js') }}"></script>
  @if (Request::segment(2)=='' && Request::segment(1)=='admin')
    {!! $chart->script() !!}
    {!! $chart2->script() !!}
    {!! $chart3->script() !!}
  @elseif(Request::segment(2)=='dashboard-admin')
    {!! $chart->script() !!}
    {!! $chart2->script() !!}
    {!! $chart3->script() !!}
  @elseif(Request::segment(2)=='laporan-admin' && $jumlah>1)
    {!! $chart_laporan->script() !!}
  @endif
  
  <script>
    $('#delete_supplier').on('show.bs.modal', function (event){
      var button = $(event.relatedTarget)

      var id_supplier = button.data('idsupp')
      var modal = $(this)

      modal.find('.modal-body #id_supplier').val(id_supplier);
    })
    $('#delete_produk').on('show.bs.modal', function (event){
      var button = $(event.relatedTarget)

      var id_supplier = button.data('produk')
      var modal = $(this)

      modal.find('.modal-body #id_produk').val(id_supplier);
    })

    $('#edit_supplier').on('show.bs.modal', function (event){
      var button = $(event.relatedTarget)

      var id_supplier = button.data('idsupp')
      var nama_supplier = button.data('namasupp')
      var telp = button.data('telpsupp')
      var alamat = button.data('alamat')
      var catatan = button.data('catatan')
      var produks = button.data('produk_supp')
      var modal = $(this)

      modal.find('.modal-body #id_supplier').val(id_supplier);
      modal.find('.modal-body #nama_supplier').val(nama_supplier);
      modal.find('.modal-body #telp').val(telp);
      modal.find('.modal-body #alamat').val(alamat);
      modal.find('.modal-body #catatan').val(catatan);
      modal.find('.modal-body #produk').val(produks);
    })

    $('#edit_produk').on('show.bs.modal', function (event){
      var button = $(event.relatedTarget)

      var id_produk = button.data('produk')
      var nama_produk = button.data('namaproduk')
      var harga = button.data('harga')
      var kategori = button.data('cat')
      var satuan = button.data('sat')
      var modal = $(this)

      modal.find('.modal-body #id_produk').val(id_produk);
      modal.find('.modal-body #satuan').val(satuan);
      modal.find('.modal-body #nama_produk').val(nama_produk);
      modal.find('.modal-body #harga').val(harga);
      modal.find('.modal-body #produk_cat').val(kategori);
    })
  </script>
  <script>
    $(document).ready(function() {
      $('#lunas').DataTable();
      $('#batal').DataTable();
      $('#data-pembelian').DataTable();
      $('#supplier').DataTable();
    } );
  </script>
  
  
</body>

</html>