@extends('layouts.app')

@section('title', 'Quản lý Thiết Bị')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý Thiết Bị</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Thiết bị</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div id="alert-container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Thành công!</h5>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <!-- Các nút chức năng -->
            @include('_thiet_bi.partials.function_buttons')

            <!-- Bộ lọc nâng cao -->
            @include('_thiet_bi.partials.filters')

            <!-- Danh sách Thiết Bị -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tools"></i>
                        Danh sách Thiết Bị
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="thiet-bi-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 50px">STT</th>
                                <th>Tên thiết bị</th>
                                <th>Loại</th>
                                <th>Tình trạng</th>
                                <th>Ban Ngành</th>
                                <th>Vị trí</th>
                                <th>Mã tài sản</th>
                                <th style="width: 120px">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dữ liệu sẽ được nạp qua DataTables -->
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Import modals -->
    @include('_thiet_bi.modals.them_thiet_bi')
    @include('_thiet_bi.modals.sua_thiet_bi')
    @include('_thiet_bi.modals.chi_tiet_thiet_bi')
    @include('_thiet_bi.modals.xoa_thiet_bi')
    @include('_thiet_bi.modals.bao_tri')
    @include('_thiet_bi.modals.xoa_bao_tri')

@endsection

@include('scripts.thiet_bi_scripts')