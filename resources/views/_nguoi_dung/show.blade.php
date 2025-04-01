@extends('layouts.app')

@section('title', 'Chi Tiết Người Dùng')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chi Tiết Người Dùng</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Quản lý Người Dùng</a></li>
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
                            <h3 class="card-title">Thông Tin Người Dùng</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Họ Tên</td>
                                    <td>{{ $nguoiDung->tinHuu->ho_ten ?? 'Không có' }}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>{{ $nguoiDung->email }}</td>
                                </tr>
                                <tr>
                                    <td>Vai Trò</td>
                                    <td>{{ $nguoiDung->vai_tro }}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="{{ route('nguoi-dung.edit', $nguoiDung->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <a href="{{ route('nguoi-dung.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>
    <!-- /.content -->
@endsection