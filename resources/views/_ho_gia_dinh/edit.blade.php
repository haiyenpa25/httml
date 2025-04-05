@extends('layouts.app')

@section('title', 'Sửa Thông Tin Hộ Gia Đình')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sửa Thông Tin Hộ Gia Đình</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Quản lý Hộ Gia Đình</a></li>
                        <li class="breadcrumb-item active">Sửa</li>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Sửa Thông Tin Hộ Gia Đình</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('_ho_gia_dinh.update', $hoGiaDinh->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="so_ho">Số Hộ</label>
                                    <input type="text" class="form-control" id="so_ho" name="so_ho" value="{{ $hoGiaDinh->so_ho }}" placeholder="Nhập số hộ">
                                </div>
                                <div class="form-group">
                                    <label for="dia_chi">Địa Chỉ</label>
                                    <textarea class="form-control" id="dia_chi" name="dia_chi" rows="3">{{ $hoGiaDinh->dia_chi }}</textarea>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Cập Nhật</button>
                                <a href="{{ route('_ho_gia_dinh.index') }}" class="btn btn-secondary">Hủy</a>
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