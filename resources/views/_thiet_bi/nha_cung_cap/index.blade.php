@extends('layouts.app')

@section('title', 'Quản lý Nhà Cung Cấp')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý Nhà Cung Cấp</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('thiet-bi.index') }}">Thiết bị</a></li>
                    <li class="breadcrumb-item active">Nhà cung cấp</li>
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-them-nha-cung-cap">
                            <i class="fas fa-plus"></i> Thêm Nhà Cung Cấp
                        </button>
                        <div class="btn-group">
                            <a href="{{ route('thiet-bi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                            <button type="button" class="btn btn-info" id="btn-refresh">
                                <i class="fas fa-sync"></i> Tải lại
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách Nhà Cung Cấp -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-building"></i>
                    Danh sách Nhà Cung Cấp
                </h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Tìm kiếm" id="search-nha-cung-cap">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="nha-cung-cap-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 50px">STT</th>
                            <th>Tên nhà cung cấp</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Số thiết bị</th>
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

<!-- Modal Thêm Nhà Cung Cấp -->
<div class="modal fade" id="modal-them-nha-cung-cap">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm Nhà Cung Cấp Mới</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-nha-cung-cap">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ten_nha_cung_cap">Tên nhà cung cấp <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ten_nha_cung_cap" name="ten_nha_cung_cap" placeholder="Nhập tên nhà cung cấp" required>
                    </div>
                    <div class="form-group">
                        <label for="dia_chi">Địa chỉ</label>
                        <input type="text" class="form-control" id="dia_chi" name="dia_chi" placeholder="Nhập địa chỉ">
                    </div>
                    <div class="form-group">
                        <label for="so_dien_thoai">Số điện thoại</label>
                        <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email">
                    </div>
                    <div class="form-group">
                        <label for="ghi_chu">Ghi chú</label>
                        <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="3" placeholder="Nhập ghi chú (nếu có)"></textarea>
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

<!-- Modal Sửa Nhà Cung Cấp -->
<div class="modal fade" id="modal-sua-nha-cung-cap">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa Nhà Cung Cấp</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-sua-nha-cung-cap">
                @csrf
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_ten_nha_cung_cap">Tên nhà cung cấp <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_ten_nha_cung_cap" name="ten_nha_cung_cap" placeholder="Nhập tên nhà cung cấp" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_dia_chi">Địa chỉ</label>
                        <input type="text" class="form-control" id="edit_dia_chi" name="dia_chi" placeholder="Nhập địa chỉ">
                    </div>
                    <div class="form-group">
                        <label for="edit_so_dien_thoai">Số điện thoại</label>
                        <input type="text" class="form-control" id="edit_so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại">
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" placeholder="Nhập email">
                    </div>
                    <div class="form-group">
                        <label for="edit_ghi_chu">Ghi chú</label>
                        <textarea class="form-control" id="edit_ghi_chu" name="ghi_chu" rows="3" placeholder="Nhập ghi chú (nếu có)"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Xóa Nhà Cung Cấp -->
<div class="modal fade" id="modal-xoa-nha-cung-cap">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Xác nhận xóa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa nhà cung cấp <strong id="delete_name"></strong>?</p>
                <input type="hidden" id="delete_id">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Xóa</button>
            </div>
        </div>
    </div>
</div>
@endsection

@include('_thiet_bi.partials.nha_cung_cap_scripts')