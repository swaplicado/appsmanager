<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{config('app.name', 'Laravel')}}</title>
  <!-- CSS files-->
  <link rel="stylesheet" href="{{asset('varios/feather/feather.css')}}">
  <link rel="stylesheet" href="{{asset('varios/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{asset('varios/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('varios/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{ asset('boxicons/css/boxicons.min.css') }}">

  <!-- Datatables CSS -->
    <link rel="stylesheet" href="{{ asset("datatables/datatables.css") }}">
    <link rel="stylesheet" href="{{asset('varios/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('js/principal/select.dataTables.min.css') }}">
  <!-- End datatables CSS -->

  <!-- Select2 CSS -->
  <link href={{asset('select2js/css/select2.min.css')}} rel="stylesheet" />
  
  <!-- CSS principal -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!-- End CSS principal -->
  <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" />
  @yield('headStyles')

  <script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('js/myApp/gui/SGui.js') }}"></script>
  @yield('headJs')

</head>
<body class="sidebar-dark">
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
        @include('layouts.topbar')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">

      <!-- partial:partials/_settings-panel.html -->
        <div class="theme-setting-wrapper">
          <div id="settings-trigger"><i class="ti-settings"></i></div>
          <div id="theme-settings" class="settings-panel">
            <i class="settings-close ti-close"></i>
            <p class="settings-heading">SIDEBAR SKINS</p>
            <div class="sidebar-bg-options selected" id="sidebar-light-theme"><div class="img-ss rounded-circle bg-light border mr-3"></div>Light</div>
            <div class="sidebar-bg-options" id="sidebar-dark-theme"><div class="img-ss rounded-circle bg-dark border mr-3"></div>Dark</div>
            <p class="settings-heading mt-2">HEADER SKINS</p>
            <div class="color-tiles mx-0 px-4">
              <div class="tiles success"></div>
              <div class="tiles warning"></div>
              <div class="tiles danger"></div>
              <div class="tiles info"></div>
              <div class="tiles dark"></div>
              <div class="tiles default"></div>
            </div>
          </div>
        </div>

      <!-- Right sidebar -->
        @include('layouts.right_sidebar')
      <!-- End Right sidebar -->
          
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
        @include('layouts.aside')
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="loader"></div>
          <div id="toasts"></div>
          <div class="hiddeToLoad">
            @yield('content')
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
            @include('layouts.footer')
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>   
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script type="text/javascript" src="{{ asset('vue/vue.js') }}"></script>
  <script type="text/javascript" src="{{ asset('myApp/Utils/vueUtils.js') }}"></script>
  <script src="{{asset('varios/js/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="{{asset('varios/chart.js/Chart.min.js')}}"></script>
  <!-- Datatables js -->
    <script src="{{asset('datatables/datatables.js')}}"></script>
    <script src="{{asset('varios/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
  <!-- End datatables js -->

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{asset('js/principal/off-canvas.js')}}"></script>
  <script src="{{asset('js/principal/hoverable-collapse.js')}}"></script>
  <script src="{{asset('js/principal/template.js')}}"></script>
  <script src="{{asset('js/principal/settings.js')}}"></script>
  <script src="{{asset('js/principal/todolist.js')}}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{asset('js/principal/Chart.roundedBarCharts.js')}}"></script>
  <!-- End custom js for this page-->
  <script src="{{asset('axios/axios.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('myApp/Utils/toastNotifications.js') }}"></script>
  <script src="{{asset('varios/select2/select2.min.js')}}"></script>

  @yield('footerScripts')

  <script>
    window.onload = function() {
          
      const loader = document.querySelector('.loader');
      loader.style.opacity = 0; /* Cambia la opacidad a 0 para que el círculo desaparezca */
      // loader.style.display = 'none'; /* Oculta el círculo después de una pequeña transición */
      // setTimeout(function() {
      // }, 1000);

      var elementos = document.getElementsByClassName("hiddeToLoad");
      for (var i = 0; i < elementos.length; i++) {
        // Establecer el estilo "display" de cada elemento a "block"
        elementos[i].style.display = 'block';
      }
      loader.style.display = 'none'; /* Oculta el círculo después de una pequeña transición */

    };
</script>
</body>

</html>