@extends('layouts.app')

@section('title', 'Quản lý Diễn Giả')

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
        display: none !important; /* Ẩn mặc định */
        align-items: center !important;
        justify-content: center !important;
    }
    .loading-spinner {
        width: 3rem;
        height: 3rem;
    }
</style>
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-microphone-alt mr-2"></i>Quản lý Diễn Giả
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Diễn Giả</li>
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
                <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Lọc Diễn Giả</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @include('_dien_gia.partials.filter')
            </div>
        </div>

        <!-- Các nút chức năng -->
        <div class="card mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-them-dien-gia">
                    <i class="fas fa-user-plus mr-1"></i> Thêm Diễn Giả
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-info" id="btn-refresh">
                        <i class="fas fa-sync mr-1"></i> Tải Lại
                    </button>
                    <a href="{{ route('api.dien_gia.export') }}" class="btn btn-success">
                        <i class="fas fa-file-excel mr-1"></i> Xuất Excel
                    </a>
                </div>
            </div>
        </div>

        <!-- Bảng dữ liệu DataTables -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list mr-1"></i> Danh Sách Diễn Giả</h3>
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
                    <table id="dien-gia-table" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%">STT</th>
                                <th width="25%">Họ Tên</th>
                                <th width="20%">Chức Danh</th>
                                <th width="20%">Hội Thánh</th>
                                <th width="15%">Số Điện Thoại</th>
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

<!-- Modal Thêm Diễn Giả -->
<div class="modal fade" id="modal-them-dien-gia">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"><i class="fas fa-user-plus mr-2"></i>Thêm Diễn Giả</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-dien-gia">
                @csrf
                <div class="modal-body">
                    @include('_dien_gia.form')
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

<!-- Modal Sửa Diễn Giả -->
<div class="modal fade" id="modal-sua-dien-gia">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title"><i class="fas fa-user-edit mr-2"></i>Sửa Diễn Giả</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-sua-dien-gia">
                @csrf
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    @include('_dien_gia.form', ['prefix' => 'edit_'])
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

<!-- Modal Xóa Diễn Giả -->
<div class="modal fade" id="modal-xoa-dien-gia">
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
                <p class="text-center">Bạn có chắc chắn muốn xóa diễn giả <strong id="delete_name"></strong>?</p>
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

<!-- Modal Xem Chi Tiết Diễn Giả -->
<div class="modal fade" id="modal-xem-dien-gia">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"><i class="fas fa-user-circle mr-2"></i>Chi Tiết Diễn Giả</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-user-circle text-primary" style="font-size: 5rem;"></i>
                    <h4 id="view_ho_ten" class="mt-2"></h4>
                    <span id="view_chuc_danh" class="badge badge-info"></span>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 30%"><i class="fas fa-church mr-1"></i> Hội Thánh</th>
                                <td id="view_hoi_thanh"></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-map-marker-alt mr-1"></i> Địa Chỉ</th>
                                <td id="view_dia_chi"></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-phone-alt mr-1"></i> Số Điện Thoại</th>
                                <td id="view_so_dien_thoai"></td>
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
<script>
$(function () {
    // Cập nhật thời gian hiện tại
    function updateCurrentTime() {
        const currentTime = new Date().toLocaleString('vi-VN', { 
            year: 'numeric', 
            month: '2-digit', 
            day: '2-digit',
            hour: '2-digit', 
            minute: '2-digit'
        });
        $('#update-time').text(currentTime);
    }
    
    // Cập nhật thời gian lần đầu
    updateCurrentTime();

    // Khởi tạo DataTable
    let table = $('#dien-gia-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('api.dien_gia.list') }}",
            data: function (d) {
                d.ho_ten = $('#filter_ho_ten').val();
                d.chuc_danh = $('#filter_chuc_danh').val();
                d.hoi_thanh = $('#filter_hoi_thanh').val();
            },
            error: function (xhr, error, thrown) {
                console.error('DataTables AJAX error:', xhr.responseText);
                showAlert('Không thể tải danh sách diễn giả: ' + (xhr.responseJSON?.message || 'Lỗi không xác định'), 'danger');
                // Ẩn processing khi lỗi
                $('#dien-gia-table_processing').hide();
            },
            complete: function () {
                // Ẩn processing khi AJAX hoàn tất
                $('#dien-gia-table_processing').hide();
            }
        },
        columns: [
            { 
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            { 
                data: 'ho_ten',
                name: 'ho_ten',
                render: function(data, type, row) {
                    return `<a href="javascript:void(0)" class="text-primary btn-view" data-id="${row.id}">${data}</a>`;
                }
            },
            { 
                data: 'chuc_danh',
                name: 'chuc_danh',
                render: function(data, type, row) {
                    return data ? `<span class="badge badge-info badge-custom">${data}</span>` : '<span class="text-muted">(Không có)</span>';
                }
            },
            { 
                data: 'hoi_thanh',
                name: 'hoi_thanh',
                render: function(data, type, row) {
                    return data || '<span class="text-muted">(Không có)</span>';
                }
            },
            { 
                data: 'so_dien_thoai',
                name: 'so_dien_thoai',
                render: function(data, type, row) {
                    return data ? `<a href="tel:${data}" class="text-primary"><i class="fas fa-phone-alt mr-1"></i>${data}</a>` : '<span class="text-muted">(Không có)</span>';
                }
            },
            { 
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ],
        language: {
            url: '{{ asset("dist/js/Vietnamese.json") }}',
            processing: '<div class="d-flex justify-content-center align-items-center"><div class="spinner-border text-primary loading-spinner" role="status"><span class="sr-only">Đang tải...</span></div></div>'
        },
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Tất cả"]],
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        drawCallback: function () {
            $('[data-toggle="tooltip"]').tooltip();
            updateCurrentTime();
            // Ẩn processing sau khi vẽ bảng
            $('#dien-gia-table_processing').hide();
        }
    });

    // Xử lý form lọc
    $('#form-filter').submit(function (e) {
        e.preventDefault();
        table.ajax.reload();
        showAlert('Đã áp dụng bộ lọc', 'info');
    });

    // Reset form lọc
    $('#btn-reset-filter').click(function () {
        $('#form-filter')[0].reset();
        table.ajax.reload();
        showAlert('Đã xóa bộ lọc', 'info');
    });

    // Hiển thị thông báo
    function showAlert(message, type = 'success') {
        const iconClass = type === 'success' ? 'check' : (type === 'info' ? 'info-circle' : 'ban');
        const title = type === 'success' ? 'Thành công!' : (type === 'info' ? 'Thông báo!' : 'Lỗi!');
        
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <h5><i class="icon fas fa-${iconClass}"></i> ${title}</h5>
                ${message}
            </div>`;
            
        $('#alert-container').html(alertHtml);
        setTimeout(() => $('.alert').alert('close'), 5000);
    }

    // Xử lý nút Tải lại
    $('#btn-refresh').click(function () {
        $(this).find('i').addClass('fa-spin');
        table.ajax.reload();
        setTimeout(() => {
            $(this).find('i').removeClass('fa-spin');
            showAlert('Dữ liệu đã được cập nhật');
        }, 1000);
    });

    // Xử lý nút xem chi tiết
    $(document).on('click', '.btn-view', function() {
        const id = $(this).data('id');
        
        $.ajax({
            url: `{{ url('api/dien-gia') }}/${id}`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#view_ho_ten').text(data.ho_ten);
                $('#view_chuc_danh').text(data.chuc_danh || 'Không có');
                $('#view_hoi_thanh').text(data.hoi_thanh || 'Không có');
                $('#view_dia_chi').text(data.dia_chi || 'Không có');
                $('#view_so_dien_thoai').html(data.so_dien_thoai ? 
                    `<a href="tel:${data.so_dien_thoai}" class="text-primary">${data.so_dien_thoai}</a>` : 
                    '<span class="text-muted">Không có</span>');
                $('#modal-xem-dien-gia').modal('show');
            },
            error: function () {
                showAlert('Không thể lấy thông tin diễn giả', 'danger');
            }
        });
    });

    // Xử lý submit form thêm diễn giả
    $('#form-dien-gia').submit(function (e) {
        e.preventDefault();
        
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i>Đang xử lý...');
        submitBtn.attr('disabled', true);
        
        $.ajax({
            url: "{{ route('api.dien_gia.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#modal-them-dien-gia').modal('hide');
                    $('#form-dien-gia')[0].reset();
                    showAlert(response.message);
                    table.ajax.reload();
                } else {
                    showAlert(response.message, 'danger');
                }
            },
            error: function (xhr) {
                let errorMessage = 'Đã xảy ra lỗi khi thêm diễn giả';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
                }
                showAlert(errorMessage, 'danger');
            },
            complete: function() {
                submitBtn.html(originalText);
                submitBtn.attr('disabled', false);
            }
        });
    });

    // Xử lý nút sửa
    $(document).on('click', '.btn-edit', function () {
        const id = $(this).data('id');
        
        $(this).html('<i class="fas fa-spinner fa-spin"></i>');
        $(this).attr('disabled', true);
        
        $.ajax({
            url: `{{ url('api/dien-gia') }}/${id}`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#edit_id').val(data.id);
                $('#edit_ho_ten').val(data.ho_ten);
                $('#edit_chuc_danh').val(data.chuc_danh);
                $('#edit_hoi_thanh').val(data.hoi_thanh);
                $('#edit_dia_chi').val(data.dia_chi);
                $('#edit_so_dien_thoai').val(data.so_dien_thoai);
                $('#modal-sua-dien-gia').modal('show');
            },
            error: function () {
                showAlert('Không thể lấy thông tin diễn giả', 'danger');
            },
            complete: function() {
                $('.btn-edit[data-id="'+id+'"]').html('<i class="fas fa-edit"></i>');
                $('.btn-edit[data-id="'+id+'"]').attr('disabled', false);
            }
        });
    });

    // Xử lý submit form sửa diễn giả
    $('#form-sua-dien-gia').submit(function (e) {
        e.preventDefault();
        
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i>Đang xử lý...');
        submitBtn.attr('disabled', true);
        
        const id = $('#edit_id').val();
        $.ajax({
            url: `{{ url('api/dien-gia') }}/${id}`,
            method: 'PUT',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#modal-sua-dien-gia').modal('hide');
                    showAlert(response.message);
                    table.ajax.reload();
                } else {
                    showAlert(response.message, 'danger');
                }
            },
            error: function (xhr) {
                let errorMessage = 'Đã xảy ra lỗi khi cập nhật diễn giả';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).join('<br>');
                }
                showAlert(errorMessage, 'danger');
            },
            complete: function() {
                submitBtn.html(originalText);
                submitBtn.attr('disabled', false);
            }
        });
    });

    // Xử lý nút xóa
    $(document).on('click', '.btn-delete', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');
        $('#delete_id').val(id);
        $('#delete_name').text(name);
        $('#modal-xoa-dien-gia').modal('show');
    });

    // Xử lý xác nhận xóa
    $('#confirm-delete').click(function () {
        const submitBtn = $(this);
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin mr-1"></i>Đang xử lý...');
        submitBtn.attr('disabled', true);
        
        const id = $('#delete_id').val();
        $.ajax({
            url: `{{ url('api/dien-gia') }}/${id}`,
            method: 'DELETE',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#modal-xoa-dien-gia').modal('hide');
                    showAlert(response.message);
                    table.ajax.reload();
                } else {
                    showAlert(response.message, 'danger');
                }
            },
            error: function () {
                showAlert('Không thể xóa diễn giả', 'danger');
            },
            complete: function() {
                submitBtn.html(originalText);
                submitBtn.attr('disabled', false);
            }
        });
    });

    // Khởi tạo tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection