<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SIIE APP</title>
    <!-- End meta tags -->

    <!-- CSS files-->
    <link rel="stylesheet" href="{{ asset('varios/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('varios/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('varios/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('varios/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('select2js/css/select2.min.css') }}">

    <!-- Datatables CSS -->
    <link rel="stylesheet" href="{{ asset('datatables/datatables.css') }}">
    <!-- End datatables CSS -->

    <!-- CSS principal -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- End CSS principal -->

    <!-- CSS section -->
    @yield('headStyles')
    <!-- End CSS section -->
    <!-- End CSS files -->

    <!-- Icon browser -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
    <!-- End icon browser -->

    <!-- Header scripts -->
    <script src="{{ asset('jquery/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vue/vue.js') }}"></script>
    <script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/myApp/gui/SGui.js') }}"></script>
    <script src="{{ asset('moment/moment.js') }}"></script>
    <script src="{{ asset('moment/moment-with-locales.js') }}"></script>
    <!-- Header scripts section -->
    <!-- end Header scripts section-->
    <!-- End header scripts -->

</head>

<body class="sidebar-dark">
    <!-- Page container -->
    <div class="container-scroller">

        <!-- Topbar -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row navbar-dark">
            <!-- logo -->
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="{{route('home')}}"><img src="{{ asset('images/aeth.png') }}"
                        class="mr-2" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="{{route('home')}}"><img
                        src="{{ asset('images/aeth_mini.png') }}" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

            </div>
        </nav>
        <!-- End Topbar -->

        <!-- Main container -->

        <div class="content-wrapper" id="formEmail">
            <div class="loader"></div>
            <div class="hiddeToLoad">
                <!-- Panel content -->
                <div class="container-scroller">
                    <div class="container-fluid page-body-wrapper full-page-wrapper">
                        <div class="content-wrapper d-flex align-items-center auth px-0">
                            <div class="row w-100 mx-0">
                                <div class="col-lg-6 mx-auto">
                                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                                        <div class="brand-logo">
                                            <img src="{{ asset('images/aeth.png') }}" alt="logo">
                                        </div>
                                        <h4>
                                            Para reiniciar su contraseña debe ingresar su nombre de usuario
                                        </h4>
                                        <br>
                                        @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                        <div class="card">
                                            <div class="card-body">
                                                <form method="POST" action="{{ route('password.email') }}">
                                                    @csrf

                                                    <div class="form-group row">
                                                        <label for="username"
                                                            class="col-md-4 col-form-label text-md-right">{{ __('Nombre de usuario') }}</label>

                                                        <div class="col-md-6">
                                                            <input id="username" type="text"
                                                                class="form-control @error('username') is-invalid @enderror"
                                                                name="username" value="{{ old('username') }}" required
                                                                autofocus>
                                                            @error('username')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="form-group row mb-0">
                                                        <div class="col-md-6 offset-md-4">
                                                            <button type="submit" class="btn btn-primary">
                                                                {{ __('Enviar link de reinicio de contraseña') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- content-wrapper ends -->
                    </div>
                    <!-- page-body-wrapper ends -->
                </div>
                <!-- End Panel content -->
            </div>
            <!-- Footer -->
            @include('layouts.footer')
            <!-- End Footer -->
        </div>
        <!-- End Page container -->

        <!-- JS files -->
        <script src="{{ asset('varios/js/vendor.bundle.base.js') }}"></script>
        <script src="{{ asset('varios/chart.js/Chart.min.js') }}"></script>
        <!-- Datatables js -->
        <script src="{{ asset('datatables/datatables.js') }}"></script>
        <!-- End datatables js -->
        <script src="{{ asset('js/principal/off-canvas.js') }}"></script>
        <script src="{{ asset('js/principal/hoverable-collapse.js') }}"></script>
        <script src="{{ asset('js/principal/template.js') }}"></script>
        <script src="{{ asset('js/principal/settings.js') }}"></script>
        <script src="{{ asset('js/principal/todolist.js') }}"></script>
        <script src="{{ asset('js/principal/Chart.roundedBarCharts.js') }}"></script>
        <script src="{{ asset('axios/axios.min.js') }}"></script>
        <script src="{{ asset('varios/select2/select2.min.js') }}"></script>
        <!-- JS section -->
        @yield('scripts')
        <!-- End JS section -->

        <script>
            window.onload = function() {

                const loader = document.querySelector('.loader');
                loader.style.opacity = 0; /* Cambia la opacidad a 0 para que el círculo desaparezca */

                var elementos = document.getElementsByClassName("hiddeToLoad");
                for (var i = 0; i < elementos.length; i++) {
                    // Establecer el estilo "display" de cada elemento a "block"
                    elementos[i].style.display = 'block';
                }
                loader.style.display = 'none'; /* Oculta el círculo después de una pequeña transición */

            };
        </script>
        <!-- End JS files -->
</body>

</html>
