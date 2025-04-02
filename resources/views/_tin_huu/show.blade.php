@extends('layouts.app')

@section('title', 'Thông Tin Chi Tiết Tín Hữu')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thông Tin Chi Tiết Tín Hữu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Quản lý Tín Hữu</a></li>
                        <li class="breadcrumb-item active">Chi Tiết</li>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thông Tin Chi Tiết</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Họ và Tên</th>
                                    <td>{{ $tinHuu->ho_ten }}</td>
                                </tr>
                                <tr>
                                    <th>Ngày Sinh</th>
                                    <td>{{ $tinHuu->ngay_sinh }}</td>
                                </tr>
                                <tr>
                                    <th>Địa Chỉ</th>
                                    <td>{{ $tinHuu->dia_chi }}</td>
                                </tr>
                                <tr>
                                    <th>Số Điện Thoại</th>
                                    <td>{{ $tinHuu->so_dien_thoai }}</td>
                                </tr>
                                <tr>
                                    <th>Loại Tín Hữu</th>
                                    <td>{{ $tinHuu->loai_tin_huu }}</td>
                                </tr>
                                <tr>
                                    <th>Giới Tính</th>
                                    <td>{{ $tinHuu->gioi_tinh }}</td>
                                </tr>
                                <tr>
                                    <th>Tình Trạng Hôn Nhân</th>
                                    <td>{{ $tinHuu->tinh_trang_hon_nhan }}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="{{ route('_tin_huu.edit', $tinHuu->id) }}" class="btn btn-primary">Sửa</a>
                            <a href="{{ route('_tin_huu.index') }}" class="btn btn-secondary">Quay lại</a>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>
@endsection