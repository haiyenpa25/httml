@extends('layouts.app')

@section('title', 'Thêm Mới Người Dùng')

@section('page-styles')
<style>
    .required-label::after {
        content: " *";
        color: red;
    }
    .form-control:focus {
        border-color: #0056b3;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .card {
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .card-header {
        background-color: #007bff;
        color: white;
        border-radius: 0.5rem 0.5rem 0 0;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }
</style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-user-plus mr-2"></i>Thêm Mới Người Dùng</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('nguoi_dung.index') }}">Quản lý Người Dùng</a></li>
                    <li class="breadcrumb-item active">Thêm Mới</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user-edit mr-1"></i>Thông Tin Người Dùng
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('nguoi_dung.store') }}" method="POST" id="userForm">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tin_huu_id" class="required-label">Tín Hữu</label>
                                        <select class="form-control select2" id="tin_huu_id" style="width: 100%;" name="tin_huu_id" required>
                                            <option value="">-- Chọn Tín Hữu --</option>
                                            @foreach($tinHuuS as $tinHuu)
                                            <option value="{{ $tinHuu->id }}" {{ old('tin_huu_id') == $tinHuu->id ? 'selected' : '' }}>
                                                {{ $tinHuu->ho_ten }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="required-label">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                placeholder="Nhập email" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mat_khau" class="required-label">Mật Khẩu</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            </div>
                                            <input type="password" class="form-control" id="mat_khau" name="mat_khau" 
                                                placeholder="Nhập mật khẩu" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="togglePassword">
                                                    <i class="far fa-eye-slash"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <small id="passwordHelp" class="form-text text-muted">
                                            Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số.
                                        </small>
                                    </div>

                                    <div class="form-group">
                                        <label for="vai_tro" class="required-label">Vai Trò</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                            </div>
                                            <select class="form-control select2" id="vai_tro" style="width: 100%;" name="vai_tro" required>
                                                <option value="quan_tri" {{ old('vai_tro') == 'quan_tri' ? 'selected' : '' }}>Quản Trị</option>
                                                <option value="truong_ban" {{ old('vai_tro') == 'truong_ban' ? 'selected' : '' }}>Trưởng Ban</option>
                                                <option value="thanh_vien" {{ old('vai_tro') == 'thanh_vien' ? 'selected' : '' }}>Thành Viên</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('nguoi_dung.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i>Quay Lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i>Lưu Người Dùng
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
</section>
@endsection

@section('page-scripts')
<script>
    $(function () {
        // Initialize Select2 Elements
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: "Chọn...",
            allowClear: true
        });

        // Hiển thị/ẩn mật khẩu
        $('#togglePassword').click(function() {
            const passwordField = $('#mat_khau');
            const passwordFieldType = passwordField.attr('type');
            const eyeIcon = $(this).find('i');
            
            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                passwordField.attr('type', 'password');
                eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });

        // Form validation
        $('#userForm').submit(function(e) {
            const email = $('#email').val();
            const password = $('#mat_khau').val();
            const tinHuuId = $('#tin_huu_id').val();
            
            let isValid = true;
            let errorMessages = [];

            if (!tinHuuId) {
                errorMessages.push('Vui lòng chọn Tín Hữu');
                isValid = false;
            }

            if (!email) {
                errorMessages.push('Vui lòng nhập Email');
                isValid = false;
            } else if (!isValidEmail(email)) {
                errorMessages.push('Email không hợp lệ');
                isValid = false;
            }

            if (!password) {
                errorMessages.push('Vui lòng nhập Mật khẩu');
                isValid = false;
            } else if (password.length < 8) {
                errorMessages.push('Mật khẩu phải có ít nhất 8 ký tự');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                
                // Hiển thị thông báo lỗi
                toastr.error(errorMessages.join('<br>'), 'Lỗi Nhập Liệu', {
                    closeButton: true,
                    timeOut: 5000,
                    extendedTimeOut: 1000,
                    positionClass: 'toast-top-right',
                    preventDuplicates: true
                });
            }
        });

        // Hàm kiểm tra email hợp lệ
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    });
</script>
@endsection