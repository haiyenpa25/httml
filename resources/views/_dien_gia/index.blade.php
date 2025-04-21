@extends('layouts.app')

@section('title', 'Quản lý Diễn Giả')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quản lý Diễn Giả</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Diễn Giả</li>
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-them-dien-gia">
                            <i class="fas fa-user-plus"></i> Thêm diễn giả
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

        <!-- Danh sách Diễn Giả -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-tie"></i>
                    Danh sách Diễn Giả
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="dien-gia-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 50px">STT</th>
                            <th>Họ tên</th>
                            <th>Chức danh</th>
                            <th>Hội Thánh</th>
                            <th>Số điện thoại</th>
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

<!-- Modal Thêm Diễn Giả -->
<div class="modal fade" id="modal-them-dien-gia">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm Diễn Giả</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-dien-gia">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ho_ten">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ho_ten" name="ho_ten" placeholder="Nhập họ tên" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="chuc_danh">Chức danh <span class="text-danger">*</span></label>
                        <select class="form-control" id="chuc_danh" name="chuc_danh" required>
                            <option value="">-- Chọn chức danh --</option>
                            <option value="Thầy">Thầy</option>
                            <option value="Cô">Cô</option>
                            <option value="Mục sư">Mục sư</option>
                            <option value="Mục sư nhiệm chức">Mục sư nhiệm chức</option>
                            <option value="Truyền Đạo">Truyền Đạo</option>
                            <option value="Chấp Sự">Chấp Sự</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="hoi_thanh">Hội thánh</label>
                        <input type="text" class="form-control" id="hoi_thanh" name="hoi_thanh" placeholder="Nhập hội thánh">
                    </div>
                    
                    <div class="form-group">
                        <label for="dia_chi">Địa chỉ</label>
                        <input type="text" class="form-control" id="dia_chi" name="dia_chi" placeholder="Nhập địa chỉ">
                    </div>
                    
                    <div class="form-group">
                        <label for="so_dien_thoai">Số điện thoại</label>
                        <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại">
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

<!-- Modal Sửa Diễn Giả -->
<div class="modal fade" id="modal-sua-dien-gia">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa Diễn Giả</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-sua-dien-gia">
                @csrf
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_ho_ten">Họ tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_ho_ten" name="ho_ten" placeholder="Nhập họ tên" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_chuc_danh">Chức danh <span class="text-danger">*</span></label>
                        <select class="form-control" id="edit_chuc_danh" name="chuc_danh" required>
                            <option value="">-- Chọn chức danh --</option>
                            <option value="Thầy">Thầy</option>
                            <option value="Cô">Cô</option>
                            <option value="Mục sư">Mục sư</option>
                            <option value="Mục sư nhiệm chức">Mục sư nhiệm chức</option>
                            <option value="Truyền Đạo">Truyền Đạo</option>
                            <option value="Chấp Sự">Chấp Sự</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_hoi_thanh">Hội thánh</label>
                        <input type="text" class="form-control" id="edit_hoi_thanh" name="hoi_thanh" placeholder="Nhập hội thánh">
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_dia_chi">Địa chỉ</label>
                        <input type="text" class="form-control" id="edit_dia_chi" name="dia_chi" placeholder="Nhập địa chỉ">
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_so_dien_thoai">Số điện thoại</label>
                        <input type="text" class="form-control" id="edit_so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại">
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

<!-- Modal Xóa Diễn Giả -->
<div class="modal fade" id="modal-xoa-dien-gia">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Xác nhận xóa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa diễn giả <strong id="delete_name"></strong>?</p>
                <input type="hidden" id="delete_id">
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

@push('scripts')
<script>
    $(function () {
        // Khởi tạo DataTable
        let table = $('#dien-gia-table').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('api.dien_gia.list') }}",
                dataSrc: ''
            },
            columns: [
                { 
                    data: null, 
                    render: function (data, type, row, meta) {
                        return meta.row + 1; // Số thứ tự
                    }
                },
                { data: 'ho_ten' },
                { data: 'chuc_danh' },
                { 
                    data: 'hoi_thanh',
                    render: function(data) {
                        return data || '(Không có)';
                    }
                },
                { 
                    data: 'so_dien_thoai',
                    render: function(data) {
                        return data || '(Không có)';
                    }
                },
                { 
                    data: null,
                    render: function(data, type, row) {
                        return `<div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info btn-edit" data-id="${row.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="${row.id}" data-name="${row.ho_ten}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>`;
                    }
                }
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Vietnamese.json"
            },
            responsive: true,
            autoWidth: false
        });
        
        // Hàm hiển thị thông báo
        function showAlert(message, type = 'success') {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-${type === 'success' ? 'check' : 'ban'}"></i> ${type === 'success' ? 'Thành công!' : 'Lỗi!'}</h5>
                    ${message}
                </div>
            `;
            
            $('#alert-container').html(alertHtml);
            
            // Tự động ẩn sau 5 giây
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        }
        
        // Xử lý nút Tải lại
        $('#btn-refresh').click(function() {
            table.ajax.reload(); // Sử dụng phương thức reload của DataTables
        });

        // Xử lý submit form thêm diễn giả
        $('#form-dien-gia').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: "{{ route('api.dien_gia.store') }}",
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#modal-them-dien-gia').modal('hide');
                        $('#form-dien-gia')[0].reset();
                        
                        // Hiển thị thông báo
                        showAlert(response.message);
                        
                        // Tải lại danh sách
                        table.ajax.reload();
                    } else {
                        showAlert(response.message, 'danger');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error response:", xhr.responseText);
                    let errorMessage = 'Đã xảy ra lỗi khi thêm diễn giả';
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = '';
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            errorMessage += value[0] + '<br>';
                        });
                    }
                    
                    showAlert(errorMessage, 'danger');
                }
            });
        });
        
        // Xử lý khi click nút sửa
        $(document).on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            
            // Fetch diễn giả data
            $.ajax({
                url: `{{ url('api/dien-gia') }}/${id}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Đổ dữ liệu vào form
                    $('#edit_id').val(data.id);
                    $('#edit_ho_ten').val(data.ho_ten);
                    $('#edit_chuc_danh').val(data.chuc_danh);
                    $('#edit_hoi_thanh').val(data.hoi_thanh);
                    $('#edit_dia_chi').val(data.dia_chi);
                    $('#edit_so_dien_thoai').val(data.so_dien_thoai);
                    
                    // Hiện modal
                    $('#modal-sua-dien-gia').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                    showAlert("Không thể lấy thông tin diễn giả. Vui lòng thử lại sau!", 'danger');
                }
            });
        });
        
        // Xử lý submit form sửa diễn giả
        $('#form-sua-dien-gia').submit(function(e) {
            e.preventDefault();
            
            const id = $('#edit_id').val();
            
            $.ajax({
                url: `{{ url('api/dien-gia') }}/${id}`,
                method: 'PUT',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#modal-sua-dien-gia').modal('hide');
                        
                        // Hiển thị thông báo
                        showAlert(response.message);
                        
                        // Tải lại danh sách
                        table.ajax.reload();
                    } else {
                        showAlert(response.message, 'danger');
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'Đã xảy ra lỗi khi cập nhật diễn giả';
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = '';
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            errorMessage += value[0] + '<br>';
                        });
                    }
                    
                    showAlert(errorMessage, 'danger');
                }
            });
        });
        
        // Xử lý khi click nút xóa
        $(document).on('click', '.btn-delete', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            
            $('#delete_id').val(id);
            $('#delete_name').text(name);
            $('#modal-xoa-dien-gia').modal('show');
        });
        
        // Xử lý xác nhận xóa
        $('#confirm-delete').click(function() {
            const id = $('#delete_id').val();
            
            $.ajax({
                url: `{{ url('api/dien-gia') }}/${id}`,
                method: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#modal-xoa-dien-gia').modal('hide');
                        
                        // Hiển thị thông báo
                        showAlert(response.message);
                        
                        // Tải lại danh sách
                        table.ajax.reload();
                    } else {
                        showAlert(response.message, 'danger');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error deleting:", error);
                    showAlert("Không thể xóa diễn giả. Vui lòng thử lại sau!", 'danger');
                }
            });
        });
        
        // Xử lý xuất Excel
        $('#btn-export').click(function() {
            alert('Chức năng xuất Excel sẽ được phát triển sau');
            // TODO: Implement export functionality
        });
    });
</script>

@endpush