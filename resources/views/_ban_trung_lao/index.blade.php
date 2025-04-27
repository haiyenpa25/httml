@extends('layouts.app')

@section('title', 'Ban Trung Lão')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">Ban Trung Lão</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('_ban_nganh.index') }}">Ban Ngành</a></li>
                        <li class="breadcrumb-item active">Ban Trung Lão</li>
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

            <!-- Các nút chức năng - Bố cục được tối ưu hóa -->
            <div class="action-buttons-container">
                <!-- Hàng 1: Chức năng điều hướng chính -->
                <div class="button-row">
                    <a href="{{ route('_ban_trung_lao.index') }}" class="action-btn btn-primary-custom">
                        <i class="fas fa-home"></i> Trang chính
                    </a>
                    <a href="{{ route('_ban_trung_lao.diem_danh') }}" class="action-btn btn-success-custom">
                        <i class="fas fa-clipboard-check"></i> Điểm danh
                    </a>
                    <a href="{{ route('_ban_trung_lao.tham_vieng') }}" class="action-btn btn-info-custom">
                        <i class="fas fa-user-friends"></i> Thăm viếng
                    </a>
                </div>

                <!-- Hàng 2: Chức năng phân công và báo cáo -->
                <div class="button-row">
                    <a href="{{ route('_ban_trung_lao.phan_cong') }}" class="action-btn btn-warning-custom">
                        <i class="fas fa-tasks"></i> Phân công
                    </a>
                    <a href="{{ route('_ban_trung_lao.phan_cong_chi_tiet') }}" class="action-btn btn-info-custom">
                        <i class="fas fa-clipboard-list"></i> Chi tiết PC
                    </a>
                    <a href="{{ route('_ban_trung_lao.nhap_lieu_bao_cao') }}" class="action-btn btn-success-custom">
                        <i class="fas fa-file-alt"></i> Nhập báo cáo
                    </a>
                </div>

                <!-- Hàng 3: Chức năng quản lý -->
                <div class="button-row">
                    <button type="button" class="action-btn btn-success-custom" data-toggle="modal"
                        data-target="#modal-them-thanh-vien">
                        <i class="fas fa-user-plus"></i> Thêm thành viên
                    </button>
                    <button type="button" class="action-btn btn-info-custom" id="btn-refresh">
                        <i class="fas fa-sync"></i> Tải lại
                    </button>
                    <button type="button" class="action-btn btn-primary-custom" id="btn-export">
                        <i class="fas fa-file-excel"></i> Xuất Excel
                    </button>
                </div>
            </div>

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
                    <table id="ban-dieu-hanh-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 50px">STT</th>
                                <th>Vai trò</th>
                                <th>Họ tên</th>
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
                    <table id="ban-vien-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 50px">STT</th>
                                <th>Họ tên</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
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

    <!-- Modal Thêm Thành Viên -->
    <div class="modal fade" id="modal-them-thanh-vien">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm Thành Viên</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="form-them-thanh-vien" action="{{ route('api.ban_trung_lao.them_thanh_vien') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="ban_nganh_id" value="{{ $banTrungLao->id }}">
                        <div class="form-group">
                            <label for="tin_huu_id">Chọn Tín Hữu <span class="text-danger">*</span></label>
                            <select class="form-control select2bs4" name="tin_huu_id" id="tin_huu_id" required
                                style="width: 100%">
                                <option value="">-- Chọn Tín Hữu --</option>
                                @foreach($tinHuuList as $tinHuu)
                                    <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="chuc_vu">Chức Vụ</label>
                            <select class="form-control" name="chuc_vu" id="chuc_vu" style="width: 100%">
                                <option value="">-- Thành viên --</option>
                                <option value="Cố Vấn Linh Vụ">Cố Vấn Linh Vụ</option>
                                <option value="Trưởng Ban">Trưởng Ban</option>
                                <option value="Thư Ký">Thư Ký</option>
                                <option value="Thủ Quỹ">Thủ Quỹ</option>
                                <option value="Ủy Viên">Ủy Viên</option>
                            </select>
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
    <!-- /.modal -->

    <!-- Modal Cập Nhật Chức Vụ -->
    <div class="modal fade" id="modal-edit-chuc-vu">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cập Nhật Chức Vụ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="form-sua-chuc-vu" action="{{ route('api.ban_trung_lao.cap_nhat_chuc_vu') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="tin_huu_id" id="edit_tin_huu_id">
                        <input type="hidden" name="ban_nganh_id" id="edit_ban_nganh_id">
                        <div class="form-group">
                            <label>Tín Hữu</label>
                            <p id="edit_ten_tin_huu" class="form-control-static font-weight-bold"></p>
                        </div>
                        <div class="form-group">
                            <label for="edit_chuc_vu">Chức Vụ</label>
                            <select class="form-control" name="chuc_vu" id="edit_chuc_vu" style="width: 100%">
                                <option value="">-- Thành viên --</option>
                                <option value="Cố Vấn Linh Vụ">Cố Vấn Linh Vụ</option>
                                <option value="Trưởng Ban">Trưởng Ban</option>
                                <option value="Thư Ký">Thư Ký</option>
                                <option value="Thủ Quỹ">Thủ Quỹ</option>
                                <option value="Ủy Viên">Ủy Viên</option>
                            </select>
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
    <!-- /.modal -->

    <!-- Modal Xóa Thành Viên -->
    <div class="modal fade" id="modal-xoa-thanh-vien">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Xóa Thành Viên</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa thành viên <strong id="delete_ten_tin_huu"></strong> khỏi Ban Trung Lão?
                    </p>
                    <input type="hidden" id="delete_tin_huu_id">
                    <input type="hidden" id="delete_ban_nganh_id">
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

@include('scripts.ban_trung_lao.ban-trung-lao')