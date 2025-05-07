@extends('layouts.app')

@section('title', 'Quản lý Thành viên ' . ($banNganh->ten ?? 'Ban Ngành'))

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý Thành viên {{ $banNganh->ten ?? 'Ban Ngành' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('_ban_nganh.' . $banType . '.index') }}">{{ $banNganh->ten ?? 'Ban Ngành' }}</a></li>
                    <li class="breadcrumb-item active">Thành viên</li>
                </ol>
            </div>
        </div>
    </div>
</div>

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
        @include('_ban_nganh.partials._ban_nganh_navigation')

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
                            <label>Loại tín hữu</label>
                            <select class="form-control select2bs4" id="filter-loai-tin-huu">
                                <option value="">Tất cả</option>
                                <option value="tin_huu_chinh_thuc">Tín hữu chính thức</option>
                                <option value="tan_tin_huu">Tân tín hữu</option>
                                <option value="tin_huu_ht_khac">Tín hữu Hội Thánh khác</option>
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
                            <label>Ngày sinh</label>
                            <input type="date" class="form-control" id="filter-ngay-sinh">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <label>Giới tính</label>
                            <select class="form-control select2bs4" id="filter-gioi-tinh">
                                <option value="">Tất cả</option>
                                <option value="nam">Nam</option>
                                <option value="nu">Nữ</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <label>Tình trạng hôn nhân</label>
                            <select class="form-control select2bs4" id="filter-tinh-trang-hon-nhan">
                                <option value="">Tất cả</option>
                                <option value="doc_than">Độc thân</option>
                                <option value="ket_hon">Kết hôn</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <label>Hoàn thành báp têm</label>
                            <select class="form-control select2bs4" id="filter-hoan-thanh-bap-tem">
                                <option value="">Tất cả</option>
                                <option value="1">Có</option>
                                <option value="0">Không</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <label>Tuổi</label>
                            <select class="form-control select2bs4" id="filter-tuoi">
                                <option value="">Tất cả</option>
                                <option value="under_15">0 - dưới 15 tuổi</option>
                                <option value="15">15 tuổi</option>
                                <option value="18">18 tuổi</option>
                                <option value="21">21 tuổi</option>
                                <option value="above_21" selected>trên 21 tuổi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <label>Thời gian sinh hoạt</label>
                            <select class="form-control select2bs4" id="filter-thoi-gian-sinh-hoat">
                                <option value="">Tất cả</option>
                                <option value="6_months">6 tháng</option>
                                <option value="1_year">1 năm</option>
                                <option value="2_years_plus">2 năm trở lên</option>
                            </select>
                        </div>
                    </div>
                </div>
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
                            <th style="width: 40px" data-priority="1"></th> <!-- Cột điều khiển mở rộng -->
                            <th style="width: 50px" data-priority="2">ID</th>
                            <th data-priority="3">Họ tên</th>
                            <th data-priority="4">Ngày sinh</th>
                            <th data-priority="5">Số điện thoại</th>
                            <th data-priority="6">Ban ngành</th>
                            <th data-priority="7">Loại tín hữu</th>
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
    @include('_ban_nganh.partials._modal_them_thanh_vien', ['banNganh' => $banNganh, 'tinHuuList' => $tinHuuList])

    <!-- Modal Cập Nhật Chức Vụ -->
    @include('_ban_nganh.partials._modal_cap_nhat_chuc_vu')

    <!-- Modal Xóa Thành Viên -->
    @include('_ban_nganh.partials._modal_xoa_thanh_vien')
</section>
@endsection

@include('_ban_nganh.scripts._scripts_index')