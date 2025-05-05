@extends('layouts.app')

@section('title', 'Ban Thanh Tráng')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">Ban Thanh Tráng</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('_ban_nganh.index') }}">Ban Ngành</a></li>
                        <li class="breadcrumb-item active">Ban Thanh Tráng</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Thông báo thành công hoặc lỗi -->
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

            <!-- Thanh điều hướng nhanh -->
            @include('_ban_co_doc_giao_duc.partials._navigation')

            <!-- Bộ lọc nâng cao -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-filter mr-2"></i>Bộ Lọc Tìm Kiếm</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Họ tên</label>
                                <input type="text" class="form-control" id="filter-ho-ten" placeholder="Nhập họ tên">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Chức vụ</label>
                                <select class="form-control select2bs4" id="filter-chuc-vu" style="width: 100%">
                                    <option value="">Tất cả</option>
                                    <option value="Cố Vấn Linh Vụ">Cố Vấn Linh Vụ</option>
                                    <option value="Trưởng Ban">Trưởng Ban</option>
                                    <option value="Thư Ký">Thư Ký</option>
                                    <option value="Thủ Quỹ">Thủ Quỹ</option>
                                    <option value="Ủy Viên">Ủy Viên</option>
                                    <option value="">Thành viên</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" class="form-control" id="filter-so-dien-thoai"
                                    placeholder="Nhập số điện thoại">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input type="text" class="form-control" id="filter-dia-chi" placeholder="Nhập địa chỉ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ban Điều Hành -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-tie mr-2"></i>Ban Điều Hành
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table id="ban-dieu-hanh-table" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th style="width: 50px" data-priority="1">STT</th>
                                <th data-priority="3">Vai trò</th>
                                <th data-priority="1">Họ tên</th>
                                <th style="width: 120px" data-priority="2">Thao tác</th>
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

            <!-- Danh sách Ban viên -->
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users mr-2"></i>Danh sách Ban viên
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table id="ban-vien-table" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th style="width: 50px" data-priority="1">STT</th>
                                <th data-priority="1">Họ tên</th>
                                <th data-priority="3">Số điện thoại</th>
                                <th data-priority="4">Địa chỉ</th>
                                <th style="width: 120px" data-priority="2">Thao tác</th>
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

    <!-- Modal Thêm Thành Viên -->
    @include('_ban_co_doc_giao_duc.partials._modal_them_thanh_vien', ['banThanhTrang' => $banThanhTrang, 'tinHuuList' => $tinHuuList])

    <!-- Modal Cập Nhật Chức Vụ -->
    @include('_ban_co_doc_giao_duc.partials._modal_cap_nhat_chuc_vu')

    <!-- Modal Xóa Thành Viên -->
    @include('_ban_co_doc_giao_duc.partials._modal_xoa_thanh_vien')
@endsection

<!-- Bao gồm script từ file _scripts_index -->
@include('_ban_co_doc_giao_duc.scripts._scripts_index')