@extends('layouts.app')

@section('title', 'Thông Tin Chi Tiết Hộ Gia Đình')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thông Tin Chi Tiết Hộ Gia Đình</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Quản lý Hộ Gia Đình</a></li>
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
                                    <th>Số Hộ</th>
                                    <td>{{ $hoGiaDinh->so_ho }}</td>
                                </tr>
                                <tr>
                                    <th>Địa Chỉ</th>
                                    <td>{{ $hoGiaDinh->dia_chi }}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="{{ route('_ho_gia_dinh.edit', $hoGiaDinh->id) }}" class="btn btn-primary">Sửa</a>
                            <a href="{{ route('_ho_gia_dinh.index') }}" class="btn btn-secondary">Quay lại</a>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>
@endsection