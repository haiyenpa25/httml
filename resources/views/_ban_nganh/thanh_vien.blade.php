@extends('layouts.app')

@section('title', 'Quản lý thành viên - ' . $config['name'])

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý thành viên - {{ $config['name'] }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('_ban_nganh.index') }}">Ban Ngành</a></li>
                        <li class="breadcrumb-item active">{{ $config['name'] }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Nội dung chính: bộ lọc -->
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
            @include('_ban_nganh.partials._ban_nganh_navigation', ['banType' => $banType])

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách thành viên</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-them-thanh-vien">
                                    <i class="fas fa-plus"></i> Thêm thành viên
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
                                        @if($banType == 'trung_lao')
                                            <option value="above_21" selected>Trên 21</option>
                                        @endif
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
                                <div class="col-md-12">
                                    <button id="btn-reset-filter" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-undo"></i> Đặt lại bộ lọc
                                    </button>
                                </div>
                            </div>

                            <!-- Bảng Ban Điều Hành -->
                            <div class="mb-4">
                                <h4>Ban Điều Hành</h4>
                                <div class="table-responsive">
                                    <table id="ban-dieu-hanh-table" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th></th> <!-- Cột cho nút mở rộng -->
                                                <th>STT</th>
                                                <th>Họ tên</th>
                                                <th>Chức vụ</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Bảng Ban Viên -->
                            <div>
                                <h4>Ban Viên</h4>
                                <div class="table-responsive">
                                    <table id="ban-vien-table" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th></th> <!-- Cột cho nút mở rộng -->
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
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Thêm Thành Viên -->
    <div class="modal fade" id="modal-them-thanh-vien" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm Thành Viên</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="form-them-thanh-vien">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tin_huu_id">Tín hữu</label>
                            <select name="tin_huu_id" class="form-control select2bs4" required>
                                <option value="">-- Chọn tín hữu --</option>
                                @foreach($tinHuuList as $tinHuu)
                                    <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="ban_nganh_id" value="{{ $config['id'] }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Chỉnh Sửa Chức Vụ -->
    <div class="modal fade" id="modal-edit-chuc-vu" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chỉnh sửa chức vụ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="form-sua-chuc-vu">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tín hữu: <span id="edit_ten_tin_huu"></span></label>
                            <input type="hidden" name="tin_huu_id" id="edit_tin_huu_id">
                            <input type="hidden" name="ban_nganh_id" id="edit_ban_nganh_id">
                        </div>
                        <div class="form-group">
                            <label for="edit_chuc_vu">Chức vụ</label>
                            <select name="chuc_vu" id="edit_chuc_vu" class="form-control" required>
                                <option value="Trưởng ban">Trưởng ban</option>
                                <option value="Phó ban">Phó ban</option>
                                <option value="Thư ký">Thư ký</option>
                                <option value="Thành viên">Thành viên</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Xóa Thành Viên -->
    <div class="modal fade" id="modal-xoa-thanh-vien" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xóa Thành Viên</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa thành viên <strong id="delete_ten_tin_huu"></strong> khỏi {{ $config['name'] }}?</p>
                    <input type="hidden" id="delete_tin_huu_id">
                    <input type="hidden" id="delete_ban_nganh_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" id="confirm-delete" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@include('_ban_nganh.scripts._scripts_index')
