@extends('layouts.app')

@section('title', 'Quản lý Lớp học')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý Lớp học</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Lớp học</li>
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

            <!-- Bộ lọc nâng cao -->
            <div class="card card-secondary filter-card">
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
                                <label>Tên lớp</label>
                                <input type="text" class="form-control" id="filter-ten-lop" placeholder="Tìm kiếm theo tên lớp">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label>Loại lớp</label>
                                <select class="form-control select2bs4" id="filter-loai-lop">
                                    <option value="">Tất cả</option>
                                    <option value="bap_tem">Lớp Báp-têm</option>
                                    <option value="thanh_nien">Thanh niên</option>
                                    <option value="trung_lao">Trung lão</option>
                                    <option value="khac">Khác</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label>Tần suất</label>
                                <select class="form-control select2bs4" id="filter-tan-suat">
                                    <option value="">Tất cả</option>
                                    <option value="co_dinh">Cố định</option>
                                    <option value="linh_hoat">Linh hoạt</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <label>Địa điểm</label>
                                <input type="text" class="form-control" id="filter-dia-diem" placeholder="Tìm kiếm theo địa điểm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lớp học Table -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-book"></i> Danh sách Lớp học</h3>
                    <div class="card-tools">
                        @can('tao-lop-hoc')
                            <a href="{{ route('lop-hoc.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Thêm Lớp học
                            </a>
                        @endcan
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table id="lop-hoc-table" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th style="width: 40px"></th> <!-- Cột điều khiển mở rộng -->
                                <th style="width: 50px" data-priority="1">STT</th>
                                <th data-priority="1">Tên lớp</th>
                                <th data-priority="3">Loại lớp</th>
                                <th data-priority="4">Thời gian</th>
                                <th data-priority="4">Địa điểm</th>
                                <th style="width: 120px" data-priority="2">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Thêm Học viên -->
            <div class="modal fade" id="themHocVienModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Thêm Học viên</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form id="form-them-hoc-vien" method="POST" action="">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="tin_huu_id">Tín hữu <span class="text-danger">*</span></label>
                                    <select name="tin_huu_id" id="tin_huu_id" class="form-control select2bs4" required>
                                        <option value="">-- Chọn tín hữu --</option>
                                        @foreach(\App\Models\TinHuu::all() as $tinHuu)
                                            <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                        @endforeach
                                    </select>
                                    @error('tin_huu_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="vai_tro">Vai trò <span class="text-danger">*</span></label>
                                    <select name="vai_tro" id="vai_tro" class="form-control select2bs4" required>
                                        <option value="hoc_vien" selected>Học viên</option>
                                        <option value="giao_vien">Giáo viên</option>
                                    </select>
                                    @error('vai_tro')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Hủy</button>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection

@section('page-styles')
    <style>
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            vertical-align: middle;
        }
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
            border-color: #dee2e6;
            vertical-align: middle;
            white-space: nowrap;
        }
        .table td {
            vertical-align: middle;
            padding: 0.75rem;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.03);
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075);
            transition: all 0.3s ease;
        }
        .action-btns .btn {
            margin: 0 4px;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }
        .btn-icon {
            width: 30px;
            height: 30px;
            padding: 0;
            line-height: 30px;
            text-align: center;
            border-radius: 50%;
        }
        .card {
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .card-header {
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            padding: 0.75rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .filter-card .card-body {
            padding: 1rem;
        }
        .child-row-info {
            padding: 12px;
            background-color: #f8f9fa;
            border-radius: 4px;
            margin: 8px 0;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }
        .child-row-table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        .child-row-table td {
            padding: 5px 10px;
            word-break: break-word;
        }
        .child-row-table td:first-child {
            font-weight: 600;
            width: 180px;
            white-space: nowrap;
        }
        @media (max-width: 768px) {
            .card-title {
                font-size: 1.1rem;
            }
            .btn {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
            }
            .child-row-table td:first-child {
                width: 120px;
            }
            table.dataTable {
                width: 100% !important;
                min-width: 0 !important;
            }
        }
        .dataTables_processing {
            background: rgba(255, 255, 255, 0.9) !important;
            border-radius: 4px !important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1) !important;
            color: #007bff !important;
            font-weight: 600 !important;
            padding: 10px 20px !important;
        }
    </style>
@endsection

@include('_lop_hoc.js.lop_hoc')