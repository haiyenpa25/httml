@extends('layouts.app')

@section('title', 'Quản lý Tín Hữu')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý Tín Hữu</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Tín Hữu</li>
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Loại Tín Hữu</label>
                            <select class="form-control select2bs4" id="filter-loai-tin-huu">
                                <option value="">Tất cả</option>
                                <option value="tin_huu_chinh_thuc">Tín Hữu Chính Thức</option>
                                <option value="tan_tin_huu">Tân Tín Hữu</option>
                                <option value="tin_huu_ht_khac">Tín Hữu Hội Thánh Khác</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Giới Tính</label>
                            <select class="form-control select2bs4" id="filter-gioi-tinh">
                                <option value="">Tất cả</option>
                                <option value="nam">Nam</option>
                                <option value="nu">Nữ</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tình Trạng Hôn Nhân</label>
                            <select class="form-control select2bs4" id="filter-hon-nhan">
                                <option value="">Tất cả</option>
                                <option value="doc_than">Độc Thân</option>
                                <option value="ket_hon">Kết Hôn</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Ban Ngành</label>
                            <select class="form-control select2bs4" id="filter-ban-nganh">
                                <option value="">Tất cả</option>
                                @foreach($banNganhs as $banNganh)
                                    <option value="{{ $banNganh->id }}">{{ $banNganh->ten }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách Tín Hữu -->
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
            <!-- /.card-header -->
            <div class="card-body">
                <table id="tin-huu-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 50px">STT</th>
                            <th>Họ tên</th>
                            <th>Ngày Sinh</th>
                            <th>Loại Tín Hữu</th>
                            <th>Giới Tính</th>
                            <th>Ban Ngành</th>
                            <th>Số Điện Thoại</th>
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

<!-- Modal Thêm Tín Hữu -->
<div class="modal fade" id="modal-them-tin-huu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm Tín Hữu Mới</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-tin-huu">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ho_ten">Họ tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ho_ten" name="ho_ten" placeholder="Nhập họ tên" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ngay_sinh">Ngày Sinh <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="ngay_sinh" name="ngay_sinh" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="so_dien_thoai">Số Điện Thoại <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dia_chi">Địa Chỉ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="dia_chi" name="dia_chi" placeholder="Nhập địa chỉ" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="loai_tin_huu">Loại Tín Hữu <span class="text-danger">*</span></label>
                                <select class="form-control" id="loai_tin_huu" name="loai_tin_huu" required>
                                    <option value="">-- Chọn Loại Tín Hữu --</option>
                                    <option value="tin_huu_chinh_thuc">Tín Hữu Chính Thức</option>
                                    <option value="tan_tin_huu">Tân Tín Hữu</option>
                                    <option value="tin_huu_ht_khac">Tín Hữu Hội Thánh Khác</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gioi_tinh">Giới Tính <span class="text-danger">*</span></label>
                                <select class="form-control" id="gioi_tinh" name="gioi_tinh" required>
                                    <option value="">-- Chọn Giới Tính --</option>
                                    <option value="nam">Nam</option>
                                    <option value="nu">Nữ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tinh_trang_hon_nhan">Tình Trạng Hôn Nhân <span class="text-danger">*</span></label>
                                <select class="form-control" id="tinh_trang_hon_nhan" name="tinh_trang_hon_nhan" required>
                                    <option value="">-- Chọn Tình Trạng --</option>
                                    <option value="doc_than">Độc Thân</option>
                                    <option value="ket_hon">Kết Hôn</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ho_gia_dinh_id">Hộ Gia Đình</label>
                                <select class="form-control select2" id="ho_gia_dinh_id" name="ho_gia_dinh_id">
                                    <option value="">-- Chọn Hội Thánh --</option>
                                    @foreach($hoGiaDinhs as $hoGiaDinh)
                                        <option value="{{ $hoGiaDinh->id }}">{{ $hoGiaDinh->so_ho }} - {{ $hoGiaDinh->dia_chi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ngay_tin_chua">Ngày Tin Chúa</label>
                                <input type="date" class="form-control" id="ngay_tin_chua" name="ngay_tin_chua">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal Sửa Tín Hữu -->
<div class="modal fade" id="modal-sua-tin-huu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa Tín Hữu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-sua-tin-huu">
                @csrf
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ho_ten">Họ tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_ho_ten" name="ho_ten" placeholder="Nhập họ tên" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ngay_sinh">Ngày Sinh <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit_ngay_sinh" name="ngay_sinh" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_so_dien_thoai">Số Điện Thoại <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_dia_chi">Địa Chỉ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_dia_chi" name="dia_chi" placeholder="Nhập địa chỉ" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_loai_tin_huu">Loại Tín Hữu <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_loai_tin_huu" name="loai_tin_huu" required>
                                    <option value="">-- Chọn Loại Tín Hữu --</option>
                                    <option value="tin_huu_chinh_thuc">Tín Hữu Chính Thức</option>
                                    <option value="tan_tin_huu">Tân Tín Hữu</option>
                                    <option value="tin_huu_ht_khac">Tín Hữu Hội Thánh Khác</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_gioi_tinh">Giới Tính <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_gioi_tinh" name="gioi_tinh" required>
                                    <option value="">-- Chọn Giới Tính --</option>
                                    <option value="nam">Nam</option>
                                    <option value="nu">Nữ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_tinh_trang_hon_nhan">Tình Trạng Hôn Nhân <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_tinh_trang_hon_nhan" name="tinh_trang_hon_nhan" required>
                                    <option value="">-- Chọn Tình Trạng --</option>
                                    <option value="doc_than">Độc Thân</option>
                                    <option value="ket_hon">Kết Hôn</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ho_gia_dinh_id">Hộ Gia Đình</label>
                                <select class="form-control select2" id="edit_ho_gia_dinh_id" name="ho_gia_dinh_id">
                                    <option value="">-- Chọn Hội Thánh --</option>
                                    @foreach($hoGiaDinhs as $hoGiaDinh)
                                        <option value="{{ $hoGiaDinh->id }}">{{ $hoGiaDinh->so_ho }} - {{ $hoGiaDinh->dia_chi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ngay_tin_chua">Ngày Tin Chúa</label>
                                <input type="date" class="form-control" id="edit_ngay_tin_chua" name="ngay_tin_chua">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Xem Chi Tiết Tín Hữu -->
<div class="modal fade" id="modal-xem-tin-huu">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Chi Tiết Tín Hữu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Họ tên:</strong>
                        <p id="view_ho_ten"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Ngày Sinh:</strong>
                        <p id="view_ngay_sinh"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Số Điện Thoại:</strong>
                        <p id="view_so_dien_thoai"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Địa Chỉ:</strong>
                        <p id="view_dia_chi"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Loại Tín Hữu:</strong>
                        <p id="view_loai_tin_huu"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Giới Tính:</strong>
                        <p id="view_gioi_tinh"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <strong>Tình Trạng Hôn Nhân:</strong>
                        <p id="view_tinh_trang_hon_nhan"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xóa Tín Hữu -->
<div class="modal fade" id="modal-xoa-tin-huu">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Xác nhận xóa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa tín hữu <strong id="delete_name"></strong>?</p>
                <input type="hidden" id="delete_id">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Xóa</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
@endsection

@include('scripts.tin-huu')