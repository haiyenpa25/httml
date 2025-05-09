@extends('layouts.app')

@section('title', 'Quản lý Tín Hữu')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý Tín Hữu</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Tín Hữu</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
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

        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-between">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-them-tin-huu">
                            <i class="fas fa-user-plus"></i> Thêm Tín Hữu
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info" id="btn-refresh">
                                <i class="fas fa-sync"></i> Tải lại
                            </button>
                            <button type="button" class="btn btn-success" id="btn-export">
                                <i class="fas fa-file-excel"></i> Xuất Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="filter-ho-ten">Họ tên</label>
                        <input type="text" class="form-control form-control-sm" id="filter-ho-ten" placeholder="Nhập họ tên">
                    </div>
                    <div class="col-md-4">
                        <label for="filter-loai-tin-huu">Loại tín hữu</label>
                        <select class="form-control form-control-sm select2bs4" id="filter-loai-tin-huu">
                            <option value="">-- Chọn loại tín hữu --</option>
                            <option value="tin_huu_chinh_thuc">Tín hữu chính thức</option>
                            <option value="tan_tin_huu">Tân tín hữu</option>
                            <option value="tin_huu_du_le">Tín hữu dự lễ</option>
                            <option value="tin_huu_ht_khac">Tín hữu Hội Thánh khác</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filter-so-dien-thoai">Số điện thoại</label>
                        <input type="text" class="form-control form-control-sm" id="filter-so-dien-thoai" placeholder="Nhập số điện thoại">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="filter-ngay-sinh">Ngày sinh</label>
                        <input type="date" class="form-control form-control-sm" id="filter-ngay-sinh">
                    </div>
                    <div class="col-md-4">
                        <label for="filter-gioi-tinh">Giới tính</label>
                        <select class="form-control form-control-sm select2bs4" id="filter-gioi-tinh">
                            <option value="">-- Chọn giới tính --</option>
                            <option value="nam">Nam</option>
                            <option value="nu">Nữ</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filter-tinh-trang-hon-nhan">Tình trạng hôn nhân</label>
                        <select class="form-control form-control-sm select2bs4" id="filter-tinh-trang-hon-nhan">
                            <option value="">-- Chọn tình trạng --</option>
                            <option value="doc_than">Độc thân</option>
                            <option value="ket_hon">Kết hôn</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="filter-hoan-thanh-bap-tem">Hoàn thành báp têm</label>
                        <select class="form-control form-control-sm select2bs4" id="filter-hoan-thanh-bap-tem">
                            <option value="">-- Chọn trạng thái --</option>
                            <option value="1">Có</option>
                            <option value="0">Không</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filter-tuoi">Tuổi</label>
                        <select class="form-control form-control-sm select2bs4" id="filter-tuoi">
                            <option value="">-- Chọn độ tuổi --</option>
                            <option value="under_18">Dưới 18</option>
                            <option value="18_to_30">18 - 30</option>
                            <option value="above_30">Trên 30</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="filter-thoi-gian-sinh-hoat">Thời gian sinh hoạt</label>
                        <select class="form-control form-control-sm select2bs4" id="filter-thoi-gian-sinh-hoat">
                            <option value="">-- Chọn thời gian --</option>
                            <option value="under_1_year">Dưới 1 năm</option>
                            <option value="1_to_5_years">1 - 5 năm</option>
                            <option value="above_5_years">Trên 5 năm</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="filter-ban-nganh">Ban Ngành</label>
                        <select class="form-control form-control-sm select2bs4" id="filter-ban-nganh">
                            <option value="">-- Chọn ban ngành --</option>
                            @foreach($banNganhs as $banNganh)
                                <option value="{{ $banNganh->id }}">{{ $banNganh->ten }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <button id="btn-reset-filter" class="btn btn-secondary btn-sm">
                            <i class="fas fa-undo"></i> Đặt lại bộ lọc
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-id-card"></i>
                    Danh sách Tín Hữu
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tin-huu-table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>STT</th>
                                <th>Họ tên</th>
                                <th>Ngày sinh</th>
                                <th>Số điện thoại</th>
                                <th>Ban ngành</th>
                                <th>Loại tín hữu</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@include('_tin_huu.partials.modal_them_tin_huu')
@include('_tin_huu.partials.modal_sua_tin_huu')
@include('_tin_huu.partials.modal_xoa_tin_huu')
@endsection

@include('_tin_huu.scripts._scripts_index')