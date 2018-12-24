<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material/assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    @yield('title') - Kasir -
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="{{ asset('font-awesome/css/all.css') }} " rel="stylesheet">
  <!-- CSS Files -->
  <link href="{{ asset('material/assets/css/material-dashboard.css?v=2.1.0') }} " rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('img/logo.png') }}">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo text-center">
        <img align="center" class="mt-3" src="{{ asset('img/logo.png') }}" width="80" height="80">
        <a href="http://127.0.0.1:8000/kasir" class="simple-text logo-normal" style="font-family: Caveat; font-weight: bold; font-size: 20px;">
          KASIR
        </a>
      </div>


      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item @php
            if(Request::segment(2)=='dashboard-kasir'){
              echo "active";
            }elseif(Request::segment(1)=='kasir' && Request::segment(2)==''){
               echo "active";
            }
          @endphp">
            <a class="nav-link" href="{{route('dashboard.kasir')}}">
              <i class="fas fa-cash-register"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item  {{ Request::segment(2) === 'transaksi-kasir' ? 'active' : null }}">
            <a class="nav-link" href="{{route('transaksi.kasir')}}">
              <i class="fas fa-list"></i>
              <p>Transaksi</p>
            </a>
          </li>
          <li class="nav-item active-pro ">
            <a class="nav-link" href="#logout" data-toggle="modal">
              <i class="fas fa-logout"></i>
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
                  <i class="fas fa-user-circle"></i>
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
  <!--  Google Maps Plugin    -->
  <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
  <!-- Chartist JS -->
  <script src="{{ asset('material/assets/js/plugins/chartist.min.js') }}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{ asset('material/assets/js/plugins/bootstrap-notify.js') }}"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('material/assets/js/material-dashboard.min.js?v=2.1.0') }}" type="text/javascript"></script>
  <script src="{{ asset('js/datatables.min.js') }}"></script>
  <script>
    $(".remove-from-cart").click(function (e) {
            e.preventDefault();
 
            var ele = $(this);

            $.ajax({
                url: '{{ route('removefromcart.kasir') }}',
                method: "POST",
                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                success: function (response) {
                    window.location.reload();
                }
            });
         
        });

      $(".update-cart").click(function (e) {
           e.preventDefault();
 
           var ele = $(this);
 
            $.ajax({
               url: '{{ route('updatecart.kasir') }}',
               method: "POST",
               data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), jumlah: ele.parents("tr").find(".jumlah").val(),potongan: ele.parents("tr").find(".potongan").val()},
               success: function (response) {
                   window.location.reload();
               }
            });
        });
  </script>
  {{-- <script type="text/javascript">
    $(document).ready(function(){
        $('.uang').autoNumeric('init');
    })
  </script> --}}
  <script>
    $(document).ready(function(){
       $("#bayar").bind("change", function(e) {
        var total = $('#tots_bayar').val();
        var bayar = $('#bayar').val();
        var kembali = bayar-total;
        $("#kembali").val(kembali);
        // if($('#kembali').val() < 0){
        //   $("#kembali").val(0);
        // }
      });

    });
  </script>
  <script>
    $('#delete_transaksi').on('show.bs.modal', function (event){
      var button = $(event.relatedTarget)

      var nota = button.data('nota')
      var modal = $(this)

      modal.find('.modal-body #nota').val(nota);
    })
    $('#restore_transaksi').on('show.bs.modal', function (event){
      var button = $(event.relatedTarget)

      var nota = button.data('nota')
      var modal = $(this)

      modal.find('.modal-body #nota').val(nota);
    })
  </script>
  <script>
    $(document).ready(function() {
      $('#lunas').DataTable();
      $('#batal').DataTable();
      $('#kasir-produk').DataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false,
        "bSortable": false,
        "ordering":  false
      });
    } );
  </script>
  <script>
    $(function () {
      $('#deliv').hide();
      //show it when the checkbox is clicked
      $('#delivery').on('click', function () {
          if ($(this).prop('checked')) {
              $('#deliv').fadeIn();
          } else {
              $('#deliv').hide();
          }
      });
  });
  </script>
</body>

</html>