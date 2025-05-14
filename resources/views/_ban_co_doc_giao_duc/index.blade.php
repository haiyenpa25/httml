@extends('layouts.app')

@section('title', 'Quản lý thành viên - ' . $config['name'])

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý thành viên - {{ $config['name'] }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('_ban_' . $banType . '.index', ['banType' => 'ban-co-doc-giao-duc']) }}">{{ $config['name'] }}</a></li>
                        <li class="breadcrumb-item active">Thành viên</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Thông báo -->
            <div id="alert-container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Thành công!</h5>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <!-- Thanh điều hướng nhanh -->
            @include('_ban_co_doc_giao_duc.partials._ban_nganh_navigation', ['banType' => $banType])

            <!-- Bộ lọc nâng cao -->
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-filter"></i> Bộ Lọc Tìm Kiếm</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="filter-ho-ten">Họ tên</label>
                                <input type="text" class="form-control form-control-sm" id="filter-ho-ten" placeholder="Nhập họ tên">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="filter-loai-tin-huu">Loại tín hữu</label>
                                <select class="form-control form-control-sm select2bs4" id="filter-loai-tin-huu">
                                    <option value="">-- Chọn loại tín hữu --</option>
                                    <option value="tin_huu_chinh_thuc">Tín hữu chính thức</option>
                                    <option value="tan_tin_huu">Tân tín hữu</option>
                                    <option value="tin_huu_ht_khac">Tín hữu Hội Thánh khác</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="filter-so-dien-thoai">Số điện thoại</label>
                                <input type="text" class="form-control form-control-sm" id="filter-so-dien-thoai" placeholder="Nhập số điện thoại">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="filter-dia-chi">Địa chỉ</label>
                                <input type="text" class="form-control form-control-sm" id="filter-dia-chi" placeholder="Nhập địa chỉ">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="filter-ngay-sinh">Ngày sinh</label>
                                <input type="date" class="form-control form-control-sm" id="filter-ngay-sinh">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="filter-gioi-tinh">Giới tính</label>
                                <select class="form-control form-control-sm select2bs4" id="filter-gioi-tinh">
                                    <option value="">-- Chọn giới tính --</option>
                                    <option value="nam">Nam</option>
                                    <option value="nu">Nữ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="filter-tinh-trang-hon-nhan">Tình trạng hôn nhân</label>
                                <select class="form-control form-control-sm select2bs4" id="filter-tinh-trang-hon-nhan">
                                    <option value="">-- Chọn tình trạng --</option>
                                    <option value="doc_than">Độc thân</option>
                                    <option value="ket_hon">Kết hôn</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="filter-hoan-thanh-bap-tem">Hoàn thành báp têm</label>
                                <select class="form-control form-control-sm select2bs4" id="filter-hoan-thanh-bap-tem">
                                    <option value="">-- Chọn trạng thái --</option>
                                    <option value="1">Có</option>
                                    <option value="0">Không</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="filter-tuoi">Tuổi</label>
                                <select class="form-control form-control-sm select2bs4" id="filter-tuoi">
                                    <option value="">-- Chọn độ tuổi --</option>
                                    <option value="under_18">Dưới 18</option>
                                    <option value="18_to_30">18 - 30</option>
                                    <option value="above_30">Trên 30</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="filter-thoi-gian-sinh-hoat">Thời gian sinh hoạt</label>
                                <select class="form-control form-control-sm select2bs4" id="filter-thoi-gian-sinh-hoat">
                                    <option value="">-- Chọn thời gian --</option>
                                    <option value="under_1_year">Dưới 1 năm</option>
                                    <option value="1_to_5_years">1 - 5 năm</option>
                                    <option value="above_5_years">Trên 5 năm</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label for="filter-chuc-vu">Chức vụ</label>
                                <select class="form-control form-control-sm select2bs4" id="filter-chuc-vu">
                                    <option value="">-- Chọn chức vụ --</option>
                                    <option value="Trưởng Ban">Trưởng Ban</option>
                                    <option value="Phó Ban">Phó Ban</option>
                                    <option value="Thư Ký">Thư Ký</option>
                                    <option value="Ủy Viên">Ủy Viên</option>
                                    <option value="Thành Viên">Thành Viên</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex align-items-end">
                            <button id="btn-reset-filter" class="btn btn-secondary btn-sm">
                                <i class="fas fa-undo"></i> Đặt lại bộ lọc
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bảng Ban Điều Hành -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-user-tie"></i> Ban Điều Hành</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-them-thanh-vien">
                            <i class="fas fa-plus"></i> Thêm thành viên
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table id="ban-dieu-hanh-table" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th style="width: 40px"></th> <!-- Cột mở rộng -->
                                <th style="width: 50px" data-priority="1">STT</th>
                                <th data-priority="3">Họ tên</th>
                                <th data-priority="4">Chức vụ</th>
                                <th style="width: 120px" data-priority="2">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Bảng Ban Viên -->
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-users"></i> Ban Viên</h3>
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
                                <th style="width: 40px"></th> <!-- Cột mở rộng -->
                                <th style="width: 50px" data-priority="1">STT</th>
                                <th data-priority="1">Họ tên</th>
                                <th data-priority="3">Ngày sinh</th>
                                <th data-priority="3">Số điện thoại</th>
                                <th data-priority="4">Địa chỉ</th>
                                <th data-priority="4">Ban ngành</th>
                                <th data-priority="4">Loại tín hữu</th>
                                <th style="width: 120px" data-priority="2">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Thêm Thành Viên -->
            @include('_ban_co_doc_giao_duc.partials._modal_them_thanh_vien', ['config' => $config, 'tinHuuList' => $tinHuuList, 'banType' => $banType])

            <!-- Modal Chỉnh Sửa Chức Vụ -->
            @include('_ban_co_doc_giao_duc.partials._modal_cap_nhat_chuc_vu', ['banType' => $banType])

            <!-- Modal Xóa Thành Viên -->
            @include('_ban_co_doc_giao_duc.partials._modal_xoa_thanh_vien', ['config' => $config, 'banType' => $banType])
        </div>
    </section>
@endsection

@include('_ban_co_doc_giao_duc.scripts._scripts_index', ['banType' => $banType])