<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HTTL Thạnh Mỹ Lợi | @yield('title', 'Dashboard')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

  <style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    body.hold-transition.login-page {
        position: relative;
        font-family: 'Source Sans Pro', sans-serif;
    }

    .background-layer {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('{{ asset('dist/img/background-login.jpg') }}') no-repeat center center fixed;
        background-size: cover;
        z-index: -1;
    }

    .container-wrapper {
        position: relative;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        height: 100vh;
        padding-left: 0%;
        z-index: 1;
    }

    .login-box {
        width: 360px;
        background-color: rgba(0, 0, 0, 0.6);
        padding: 30px 25px;
        border-radius: 16px;
        box-shadow: 0 0 25px rgba(0, 123, 255, 0.3);
        color: #fff;
        z-index: 2;
    }

    .card {
        background-color: transparent;
        box-shadow: none;
        margin: 0;
    }

    .card-header {
        text-align: center;
        border: none;
        margin-bottom: 10px;
    }

    .card-header img {
        max-width: 100px;
        margin-bottom: 10px;
    }

    .card-header h1 {
        font-size: 28px;
        font-weight: 600;
        color: #ffffff;
        margin: 0;
    }

    .form-control {
        border-radius: 0.4rem;
        background-color: rgba(255, 255, 255, 0.1);
        border: none;
        color: #fff;
    }

    .form-control::placeholder {
        color: #aaa;
    }

    .input-group-text {
        background-color: rgba(255, 255, 255, 0.1);
        border: none;
        color: #fff;
        border-radius: 0.4rem 0 0 0.4rem;
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
        border-radius: 0.4rem;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
    }

    .mb-1 a,
    .mb-0 a {
        color: #66bfff;
        font-size: 0.9rem;
        text-decoration: none;
    }

    .mb-0 {
        text-align: center;
        margin-top: 1rem;
    }

    @media (max-width: 768px) {
        .container-wrapper {
            justify-content: center;
            padding-right: 0;
        }
    }
  </style>
</head>
<body class="hold-transition login-page">
  <div class="background-layer"></div>
  <div class="container-wrapper">
    <div class="login-box">
      <div class="card card-outline">
        <div class="card-header">
          <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="HTTL Logo">
          <h1>Login</h1>
        </div>
        <div class="card-body">
          <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="input-group mb-3">
              <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Username" name="email" value="{{ old('email') }}">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control @error('mat_khau') is-invalid @enderror" placeholder="Password" name="mat_khau">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
              @error('mat_khau')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Log in</button>
              </div>
            </div>
          </form>
          <p class="mt-3 mb-1 text-center">
            <a href="forgot-password.html">Forgot password?</a>
          </p>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>