@extends('layouts.app')

@section('title', 'Ban Trung Lão')

@section('page-styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Select2 CSS -->
    <style>
        /* Select2 adjustments */
        .select2-container--bootstrap4 .select2-selection__rendered {
            color: #333 !important;
            line-height: 34px !important;
            padding-left: 10px !important;
        }
        .select2-container--bootstrap4 .select2-selection--single {
            height: 38px !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem !important;
        }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__placeholder {
            color: #6c757d !important;
        }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
            top: 0 !important;
        }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__clear {
            margin-top: 0 !important;
            line-height: 38px !important;
        }
        .select2-container--bootstrap4 .select2-dropdown {
            border: 1px solid #ced4da !important;
        }
        .select2-container--bootstrap4 .select2-results__option {
            color: #333 !important;
        }

        /* General styling */
        .content-header {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7ea 100%);
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
        }
        .content-header h1 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #343a40;
        }
        .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 0;
        }
        .breadcrumb-item a {
            color: #007bff;
            font-weight: 500;
        }
        .breadcrumb-item.active {
            color: #6c757d;
        }

        /* Alert styling */
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        .alert h5 {
            font-size: 1.1rem;
            font-weight: 600;
        }

        /* Button grid */
        .button-grid {
            display: grid;
            gap: 10px;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            padding: 15px 0;
        }
        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            transition: all 0.2s ease;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            color: #fff;
            text-decoration: none;
        }
        .action-btn i {
            margin-right: 6px;
            font-size: 16px;
        }
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }
        .action-btn:active {
            transform: translateY(0);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        /* Button colors */
        .btn-primary-custom { background-color: #007bff; }
        .btn-success-custom { background-color: #28a745; }
        .btn-info-custom { background-color: #17a2b8; }
        .btn-warning-custom { background-color: #ffc107; }

        /* Filter card */
        .card-secondary {
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }
        .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 15px 20px;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #343a40;
        }
        .card-body {
            padding: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
            white-space: normal;
            word-wrap: break-word;
        }
        .form-control {
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 10px;
            font-size: 14px;
            width: 100%;
            box-sizing: border-box;
        }
        .form-control::placeholder {
            color: #6c757d;
            font-size: 14px;
            white-space: normal;
            word-wrap: break-word;
        }

        /* DataTables */
        .card-primary, .card-success {
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }
        .table {
            margin-bottom: 0;
        }
        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #343a40;
            padding: 12px;
        }
        .table tbody tr {
            transition: background 0.2s ease;
        }
        .table tbody tr:hover {
            background: #f1f3f5;
        }
        .table td {
            padding: 12px;
            vertical-align: middle;
        }
        .btn-sm {
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 4px;
        }

        /* Modal */
        .modal-content {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .modal-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 15px 20px;
        }
        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #343a40;
        }
        .modal-body {
            padding: 20px;
        }
        .modal-footer {
            border-top: 1px solid #dee2e6;
            padding: 15px 20px;
        }
        .modal-footer .btn {
            padding: 8px 20px;
            border-radius: 6px;
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .content-header h1 {
                font-size: 1.5rem;
            }
            .breadcrumb {
                font-size: 14px;
            }
            .button-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            .action-btn {
                padding: 10px;
                font-size: 14px;
                border-radius: 8px;
            }
            .action-btn i {
                font-size: 16px;
            }
            .card-header {
                padding: 12px 15px;
            }
            .card-title {
                font-size: 1.1rem;
            }
            .card-body {
                padding: 15px;
            }
            .form-group {
                margin-bottom: 15px;
            }
            .form-group label {
                font-size: 14px;
            }
            .form-control {
                font-size: 14px;
                padding: 8px;
            }
            .form-control::placeholder {
                font-size: 14px;
            }
            .table thead th, .table td {
                font-size: 14px;
                padding: 10px;
            }
            .modal-body, .modal-footer {
                padding: 15px;
            }
            .modal-title {
                font-size: 1.1rem;
            }
        }
        @media (min-width: 577px) and (max-width: 768px) {
            .button-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@endsection

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

        <!-- Các nút chức năng -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="button-grid">
                            <a href="{{ route('_ban_trung_lao.index') }}" class="action-btn btn-primary-custom">
                                <i class="fas fa-home"></i> Trang chính
                            </a>
                            <a href="{{ route('_ban_trung_lao.diem_danh') }}" class="action-btn btn-success-custom">
                                <i class="fas fa-clipboard-check"></i> Điểm danh
                            </a>
                            <a href="{{ route('_ban_trung_lao.tham_vieng') }}" class="action-btn btn-info-custom">
                                <i class="fas fa-user-friends"></i> Thăm viếng
                            </a>
                            <a href="{{ route('_ban_trung_lao.phan_cong') }}" class="action-btn btn-warning-custom">
                                <i class="fas fa-tasks"></i> Phân công
                            </a>
                            <a href="{{ route('_ban_trung_lao.phan_cong_chi_tiet') }}" class="action-btn btn-info-custom">
                                <i class="fas fa-tasks"></i> Phân công chi tiết
                            </a>
                            <a href="{{ route('_bao_cao.form_ban_trung_lao') }}" class="action-btn btn-success-custom">
                                <i class="fas fa-tasks"></i> Nhập liệu báo cáo
                            </a>
                            <button type="button" class="action-btn btn-success-custom" data-toggle="modal" data-target="#modal-them-thanh-vien">
                                <i class="fas fa-user-plus"></i> Thêm thành viên
                            </button>
                            <button type="button" class="action-btn btn-info-custom" id="btn-refresh">
                                <i class="fas fa-sync"></i> Tải lại
                            </button>
                            <button type="button" class="action-btn btn-success-custom" id="btn-export">
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
                            <select class="form-control select2bs4" id="filter-chuc-vu">
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
                            <input type="text" class="form-control" id="filter-so-dien-thoai" placeholder="Nhập số điện thoại">
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
            <div class="card-body">
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
            <div class="card-body">
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
                        <select class="form-control select2bs4" name="tin_huu_id" id="tin_huu_id" required>
                            <option value="">-- Chọn Tín Hữu --</option>
                            @foreach($tinHuuList as $tinHuu)
                                <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="chuc_vu">Chức Vụ</label>
                        <select class="form-control" name="chuc_vu" id="chuc_vu">
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
                        <select class="form-control" name="chuc_vu" id="edit_chuc_vu">
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
                <p>Bạn có chắc chắn muốn xóa thành viên <strong id="delete_ten_tin_huu"></strong> khỏi Ban Trung Lão?</p>
                <input type="hidden" id="delete_tin_huu_id">
                <input type="hidden" id="delete_ban_nganh_id">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Xóa</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection

@include('scripts.ban-trung-lao')