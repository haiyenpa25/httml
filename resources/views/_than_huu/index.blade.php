@extends('layouts.app')

@section('title', 'Quản lý Thân Hữu')

@section('page-styles')
<style>
    .action-btn {
        margin: 0 3px;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .badge-custom {
        font-size: 90%;
        font-weight: 500;
    }
    .card-header {
        background-color: #f8f9fa;
    }
    .card-outline {
        border-top: 3px solid #007bff;
    }
    .dataTables_info, .dataTables_paginate {
        padding-top: 15px;
    }
    .btn-actions {
        white-space: nowrap;
    }
    .dataTables_processing {
        background-color: rgba(255, 255, 255, 0.9) !important;
        height: 100% !important;
        width: 100% !important;
        top: 0 !important;
        left: 0 !important;
        z-index: 10 !important;
        display: none !important;
        align-items: center !important;
        justify-content: center !important;
    }
    .loading-spinner {
        width: 3rem;
        height: 3rem;
    }
    /* Thêm CSS để làm đẹp select2 */
    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(2.25rem + 2px) !important;
    }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        line-height: 2.25rem;
    }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
        height: 2.25rem;
    }
    .select2-container--bootstrap4 .select2-results__option--highlighted {
        background-color: #007bff !important;
    }
    .select2-container--bootstrap4 .select2-search--dropdown .select2-search__field {
        border-radius: 0.25rem;
        padding: 0.375rem 0.75rem;
    }
    /* Modal form styling */
    .form-group label.required::after {
        content: ' *';
        color: #dc3545;
    }
    .modal-body .nav-tabs .nav-link.active {
        background-color: #f8f9fa;
        border-bottom-color: #f8f9fa;
    }
    .tab-content {
        padding: 1.25rem;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-top: none;
        border-bottom-left-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-users mr-2"></i>Quản lý Thân Hữu
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Thân Hữu</li>
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
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <h5><i class="icon fas fa-check"></i> Thành công!</h5>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Form lọc -->
        <div class="card card-outline card-primary mb-3">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Lọc Thân Hữu</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @include('_than_huu.partials.filter')
            </div>
        </div>

        <!-- Các nút chức năng -->
        <div class="card mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-them-than-huu">
                    <i class="fas fa-user-plus mr-1"></i> Thêm Thân Hữu
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-info" id="btn-refresh">
                        <i class="fas fa-sync mr-1"></i> Tải Lại
                    </button>
                    <a href="{{ route('api.than_huu.export') }}" class="btn btn-success">
                        <i class="fas fa-file-excel mr-1"></i> Xuất Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Bảng dữ liệu DataTables -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list mr-1"></i> Danh Sách Thân Hữu</h3>
                <div class="card-tools">
                    <span class="text-muted mr-2" style="font-size: 85%">
                        <i class="far fa-clock mr-1"></i>Cập nhật: <span id="update-time"></span>
                    </span>
                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                        <i class="fas fa-expand"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="than-huu-table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%">STT</th>
                                <th width="20%">Họ Tên</th>
                                <th width="15%">Năm Sinh</th>
                                <th width="15%">Trạng Thái</th>
                                <th width="20%">Tín Hữu Giới Thiệu</th>
                                <th width="15%">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dữ liệu sẽ được load bởi DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Thêm Thân Hữu -->
<div class="modal fade" id="modal-them-than-huu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"><i class="fas fa-user-plus mr-2"></i>Thêm Thân Hữu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-than-huu">
                @csrf
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="true">
                                <i class="fas fa-info-circle mr-1"></i>Thông Tin Cơ Bản
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="additional-tab" data-toggle="tab" href="#additional" role="tab" aria-controls="additional" aria-selected="false">
                                <i class="fas fa-clipboard-list mr-1"></i>Thông Tin Bổ Sung
                            </a>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ho_ten" class="required">Họ Tên</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="ho_ten" name="ho_ten" placeholder="Nhập họ tên" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="nam_sinh">Năm Sinh</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="number" class="form-control" id="nam_sinh" name="nam_sinh" placeholder="Nhập năm sinh" min="1900" max="{{ date('Y') }}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="so_dien_thoai">Số Điện Thoại</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="trang_thai" class="required">Trạng Thái</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-heart"></i></span>
                                            </div>
                                            <select class="form-control" id="trang_thai" name="trang_thai" required>
                                                <option value="">-- Chọn trạng thái --</option>
                                                <option value="chua_tin">Chưa tin</option>
                                                <option value="da_tham_gia">Đã tham gia</option>
                                                <option value="da_tin_chua">Đã tin Chúa</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="tin_huu_gioi_thieu_id">Tín Hữu Giới Thiệu</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                            </div>
                                            <select class="form-control select2bs4" id="tin_huu_gioi_thieu_id" name="tin_huu_gioi_thieu_id" data-placeholder="Chọn tín hữu giới thiệu">
                                                <option value=""></option>
                                                @foreach($tinHuus as $tinHuu)
                                                    <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }} {{ $tinHuu->thong_tin_bo_sung ? '- '.$tinHuu->thong_tin_bo_sung : '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle mr-1"></i>Gõ để tìm kiếm tín hữu
                                        </small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="dia_chi">Địa Chỉ</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="dia_chi" name="dia_chi" placeholder="Nhập địa chỉ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-tab">
                            <div class="form-group">
                                <label for="ghi_chu">Ghi Chú</label>
                                <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="5" placeholder="Nhập ghi chú về thân hữu"></textarea>
                            </div>
                            
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-1"></i> Thêm thông tin chi tiết về thân hữu để dễ dàng theo dõi và chăm sóc.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Đóng
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Lưu Thông Tin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sửa Thân Hữu -->
<div class="modal fade" id="modal-sua-than-huu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title"><i class="fas fa-user-edit mr-2"></i>Sửa Thân Hữu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-sua-than-huu">
                @csrf
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="editTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="edit-info-tab" data-toggle="tab" href="#edit-info" role="tab" aria-controls="edit-info" aria-selected="true">
                                <i class="fas fa-info-circle mr-1"></i>Thông Tin Cơ Bản
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="edit-additional-tab" data-toggle="tab" href="#edit-additional" role="tab" aria-controls="edit-additional" aria-selected="false">
                                <i class="fas fa-clipboard-list mr-1"></i>Thông Tin Bổ Sung
                            </a>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="editTabContent">
                        <div class="tab-pane fade show active" id="edit-info" role="tabpanel" aria-labelledby="edit-info-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_ho_ten" class="required">Họ Tên</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="edit_ho_ten" name="ho_ten" placeholder="Nhập họ tên" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="edit_nam_sinh">Năm Sinh</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="number" class="form-control" id="edit_nam_sinh" name="nam_sinh" placeholder="Nhập năm sinh" min="1900" max="{{ date('Y') }}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="edit_so_dien_thoai">Số Điện Thoại</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="edit_so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edit_trang_thai" class="required">Trạng Thái</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-heart"></i></span>
                                            </div>
                                            <select class="form-control" id="edit_trang_thai" name="trang_thai" required>
                                                <option value="">-- Chọn trạng thái --</option>
                                                <option value="chua_tin">Chưa tin</option>
                                                <option value="da_tham_gia">Đã tham gia</option>
                                                <option value="da_tin_chua">Đã tin Chúa</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="edit_tin_huu_gioi_thieu_id">Tín Hữu Giới Thiệu</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                            </div>
                                            <select class="form-control select2bs4" id="edit_tin_huu_gioi_thieu_id" name="tin_huu_gioi_thieu_id" data-placeholder="Chọn tín hữu giới thiệu">
                                                <option value=""></option>
                                                @foreach($tinHuus as $tinHuu)
                                                    <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }} {{ $tinHuu->thong_tin_bo_sung ? '- '.$tinHuu->thong_tin_bo_sung : '' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle mr-1"></i>Gõ để tìm kiếm tín hữu
                                        </small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="edit_dia_chi">Địa Chỉ</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="edit_dia_chi" name="dia_chi" placeholder="Nhập địa chỉ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane fade" id="edit-additional" role="tabpanel" aria-labelledby="edit-additional-tab">
                            <div class="form-group">
                                <label for="edit_ghi_chu">Ghi Chú</label>
                                <textarea class="form-control" id="edit_ghi_chu" name="ghi_chu" rows="5" placeholder="Nhập ghi chú về thân hữu"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Đóng
                    </button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-save mr-1"></i>Cập Nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Xóa Thân Hữu -->
<div class="modal fade" id="modal-xoa-than-huu">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title"><i class="fas fa-trash-alt mr-2"></i>Xác Nhận Xóa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle text-danger" style="font-size: 5rem;"></i>
                </div>
                <p class="text-center">Bạn có chắc chắn muốn xóa thân hữu <strong id="delete_name"></strong>?</p>
                <p class="text-center text-danger">Hành động này không thể hoàn tác!</p>
                <input type="hidden" id="delete_id">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Đóng
                </button>
                <button type="button" class="btn btn-danger" id="confirm-delete">
                    <i class="fas fa-trash-alt mr-1"></i>Xác Nhận Xóa
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xem Chi Tiết Thân Hữu -->
<div class="modal fade" id="modal-xem-than-huu">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"><i class="fas fa-user-circle mr-2"></i>Chi Tiết Thân Hữu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-user-circle text-primary" style="font-size: 5rem;"></i>
                    <h4 id="view_ho_ten" class="mt-2"></h4>
                    <span id="view_trang_thai" class="badge badge-info"></span>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 30%"><i class="fas fa-calendar mr-1"></i> Năm Sinh</th>
                                <td id="view_nam_sinh"></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-phone-alt mr-1"></i> Số Điện Thoại</th>
                                <td id="view_so_dien_thoai"></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-map-marker-alt mr-1"></i> Địa Chỉ</th>
                                <td id="view_dia_chi"></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-user mr-1"></i> Tín Hữu Giới Thiệu</th>
                                <td id="view_tin_huu_gioi_thieu"></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-comment mr-1"></i> Ghi Chú</th>
                                <td id="view_ghi_chu"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Đóng
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
    @include('_than_huu.scripts')
@endsection