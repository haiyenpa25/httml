@extends('layouts.app')

@section('title', 'Quản lý Thành viên - {{ $banNganh->ten }}')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý Thành viên - {{ $banNganh->ten }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('ban_muc_vu.index', ['ban_nganh_id' => $banNganh->id]) }}">{{ $banNganh->ten }}</a>
                        </li>
                        <li class="breadcrumb-item active">Thành viên</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Dropdown chọn ban ngành -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Chọn Ban Ngành</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="ban_nganh_select">Ban Ngành</label>
                        <select class="form-control select2bs4" id="ban_nganh_select"
                            onchange="location.href='{{ route('ban_muc_vu.thanh_vien') }}?ban_nganh_id=' + this.value">
                            @foreach($banNganhs as $ban)
                                <option value="{{ $ban->id }}" {{ $banNganh->id == $ban->id ? 'selected' : '' }}>
                                    {{ $ban->ten }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

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
            @include('_ban_muc_vu.partials._ban_muc_vu_navigation', ['ban_nganh_id' => $banNganh->id])

            <!-- Bộ lọc nâng cao -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Bộ Lọc Tìm Kiếm</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label>Họ tên</label>
                                <input type="text" class="form-control" id="filter-ho-ten"
                                    placeholder="Tìm kiếm theo họ tên">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label>Chức vụ</label>
                                <select class="form-control select2bs4" id="filter-chuc-vu">
                                    <option value="">Tất cả</option>
                                    <option value="Trưởng Ban">Trưởng Ban</option>
                                    <option value="Phó Ban">Phó Ban</option>
                                    <option value="Thư Ký">Thư Ký</option>
                                    <option value="Ủy Viên">Ủy Viên</option>
                                    <option value="Thành Viên">Thành Viên</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" class="form-control" id="filter-so-dien-thoai"
                                    placeholder="Tìm kiếm theo SĐT">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input type="text" class="form-control" id="filter-dia-chi"
                                    placeholder="Tìm kiếm theo địa chỉ">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ban Điều Hành Table -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-tie"></i> Ban Điều Hành</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table id="ban-dieu-hanh-table" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th style="width: 50px" data-priority="1">STT</th>
                                <th data-priority="3">Chức vụ</th>
                                <th data-priority="1">Họ tên</th>
                                <th style="width: 120px" data-priority="2">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dữ liệu sẽ được nạp từ DataTables AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ban Viên Table -->
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-users"></i> Thành Viên</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
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
                            <!-- Dữ liệu sẽ được nạp từ DataTables AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Thêm Thành Viên -->
        @include('_ban_muc_vu.partials._modal_them_thanh_vien', ['banNganh' => $banNganh, 'tinHuuList' => $tinHuuList])

        <!-- Modal Cập Nhật Chức Vụ -->
        @include('_ban_muc_vu.partials._modal_cap_nhat_chuc_vu', ['ban_nganh_id' => $banNganh->id])

        <!-- Modal Xóa Thành Viên -->
        @include('_ban_muc_vu.partials._modal_xoa_thanh_vien', ['ban_nganh_id' => $banNganh->id])
    </section>
@endsection

<!-- Bao gồm script từ file _scripts_index -->
@include('_ban_muc_vu.scripts._scripts_index', ['ban_nganh_id' => $banNganh->id])