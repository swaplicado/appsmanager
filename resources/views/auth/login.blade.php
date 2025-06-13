<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SIIE APP</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('varios/feather/feather.css')}}">
  <link rel="stylesheet" href="{{asset('varios/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{asset('varios/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{ asset('boxicons/css/boxicons.min.css') }}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <link href="{{ asset('css/loginstyle.css') }}" rel="stylesheet">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" />

  <script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('js/myApp/gui/SGui.js') }}"></script>
  
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper ">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="{{asset('images/aeth.png')}}" alt="logo">
              </div>
              <h4>¡Hola! Vamos a comenzar</h4>
              <h6 class="font-weight-light">Inicia sesión para continuar.</h6>
              <form id="login_form" class="pt-3" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">
                    Usuario 
                    <div class="myTooltip">
                        <span class="bx bx-info-circle" style="color: rgb(39, 63, 243)"></span>
                        <div class="bottom-right">
                            <div class="text-content">
                                <ul>
                                    <li>
                                        Para ingresar como proveedor ingresa tu RFC en el campo "Usuario"
                                    </li>
                                    <li>
                                        Para ingresar como colaborador ingresa tu nombre de usuario en el campo "Usuario"
                                    </li>
                                </ul>
                            </div>
                            <i></i>
                        </div>
                    </div>
                  </label>
                  <input class="form-control form-control-lg @error('username') is-invalid @enderror" id="username" placeholder="Proveedor: tu RFC / Comprador: tu nombre de usuario" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                  @error('username')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Contraseña</label>
                  <div class="input-group">
                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                            id="password" placeholder="Contraseña" name="password" required autocomplete="current-password">
                    <button type="button" class="btn btn-outline-secondary btn-sm" id="togglePassword">
                      <i class='bx bx-show bx-sm'></i>
                    </button>
                  </div>
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Continuar</button>
                </div>
                <br>
                <div class="row">
                  <div class="my-2 d-flex justify-content-between align-items-center col-md-6">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-link text-black" onclick="SGui.showWaitingUnlimit()">¿Olvidaste la contraseña?</a>
                    @endif
                  </div>
                  <div class="my-2 justify-content-between align-items-center col-md-6">
                      <a href="{{ $registerProviderRoute }}" class="auth-link text-black f-right">Registrarse como proveedor</a>
                  </div>
                </div>
                <footer class="footer mt-5">
                  <div class="d-flex flex-column align-items-center justify-content-center text-center py-3" style="font-size: 14px;">
                    <p style="margin: 0;">Creado por:</p>
                    <img src="{{ asset('images/swap_logo.jpg') }}" alt="Logo Software Aplicado" style="width: 140px; height: auto; margin-top: 8px;">
                  </div>
                </footer>
              </form>
            </div>
          </div>
        </div>
      </div>
    <!-- content-wrapper ends -->
    </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{asset('varios/js/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{asset('js/principal/off-canvas.js')}}"></script>
  <script src="{{asset('js/principal/hoverable-collapse.js')}}"></script>
  <script src="{{asset('js/principal/template.js')}}"></script>
  <script src="{{asset('js/principal/settings.js')}}"></script>
  <script src="{{asset('js/principal/todolist.js')}}"></script>
  <script src="{{asset('js/myApp/login/Login_js.js')}}"></script>
  <!-- endinject -->
@if(session('message') != null)
    <script>
      let Message = "<?php echo session('message') ?>";
      let icon = "<?php echo session('icon') ?>";
      $(document).ready(function () {
        icon != '' ? icon : 'info';
        SGui.showMessage('', Message, icon);
      });
    </script>
@endif
<script>
  function disableSubmitButton(form) {
      form.addEventListener('submit', function() {
          // Disable the submit button to prevent multiple submissions
          var submitButton = form.querySelector('[type="submit"]');
          if (submitButton) {
              submitButton.disabled = true;
              SGui.showWaitingUnlimit();
          }
      });
  }

  $(document).ready(function () {
      var form = document.getElementById('login_form');
      disableSubmitButton(form);
  });
</script>
<script>
  document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');

    // Alternar entre tipo "password" y "text"
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('bx-show');
        icon.classList.add('bx-hide'); // Cambiar el ícono a "ojo tachado"
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('bx-hide');
        icon.classList.add('bx-show'); // Cambiar el ícono a "ojo"
    }
  });
</script>

</body>
</html>