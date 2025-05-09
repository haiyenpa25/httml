<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HTTL Thạnh Mỹ Lợi | 403 Forbidden</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

  <style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    body.hold-transition {
        position: relative;
        font-family: 'Source Sans Pro', sans-serif;
    }

    .background-layer {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #001529 0%, #0a4d8c 50%, #0077cc 100%);
        z-index: -1;
    }

    .geometric-crosses {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('{{ asset("dist/img/geometric-crosses.svg") }}') no-repeat bottom left;
        background-size: contain;
        opacity: 0.8;
        z-index: -1;
    }

    .wave-overlay {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 30%;
        background: url('{{ asset("dist/img/wave-overlay.svg") }}') no-repeat bottom center;
        background-size: cover;
        z-index: -1;
    }

    .container-wrapper {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        z-index: 1;
    }

    .error-box {
        width: 500px;
        background-color: rgba(0, 0, 0, 0.6);
        padding: 40px 30px;
        border-radius: 16px;
        box-shadow: 0 0 25px rgba(0, 123, 255, 0.3);
        color: #fff;
        text-align: center;
    }
    
    .logo {
        margin-bottom: 20px;
    }
    
    .logo img {
        max-width: 120px;
    }

    .error-code {
        font-size: 72px;
        font-weight: 700;
        color: #ff6a6a;
        margin: 0;
        line-height: 1;
        text-shadow: 0 0 15px rgba(255, 106, 106, 0.5);
    }
    
    .error-message {
        font-size: 24px;
        margin-top: 10px;
        margin-bottom: 20px;
        color: #ffffff;
    }
    
    .error-description {
        font-size: 16px;
        color: #cccccc;
        margin-bottom: 30px;
    }

    .btn {
        border-radius: 50px;
        padding: 10px 25px;
        font-weight: 600;
        margin: 0 10px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #0d6efd;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }
    
    .btn-secondary {
        background-color: transparent;
        border: 2px solid #ffffff;
    }
    
    .btn-secondary:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 255, 255, 0.2);
    }

    @media (max-width: 768px) {
        .error-box {
            width: 90%;
            padding: 30px 20px;
        }
        
        .error-code {
            font-size: 60px;
        }
    }
  </style>
</head>
<body class="hold-transition">
  <div class="background-layer"></div>
  <div class="geometric-crosses"></div>
  <div class="wave-overlay"></div>
  <div class="container-wrapper">
    <div class="error-box">
      <div class="logo">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="HTTL Logo">
      </div>
      <h1 class="error-code">403</h1>
      <h2 class="error-message">Không Có Quyền Truy Cập</h2>
      <p class="error-description">Bạn không có quyền truy cập trang này. Vui lòng liên hệ quản trị viên để được hỗ trợ.</p>
      <div class="mt-4">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">
          <i class="fas fa-home mr-2"></i> Quay Lại Trang Chủ
        </a>
        <a href="{{ route('logout') }}" class="btn btn-secondary">
          <i class="fas fa-sign-out-alt mr-2"></i> Đăng Xuất
        </a>
      </div>
    </div>
  </div>
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>