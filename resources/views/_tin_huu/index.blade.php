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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Loại Tín Hữu</label>
                            <select class="form-control" id="filter-loai-tin-huu">
                                <option value="">Tất cả</option>
                                <option value="tin_huu_chinh_thuc">Tín Hữu Chính Thức</option>
                                <option value="tan_tin_huu">Tân Tín Hữu</option>
                                <option value="tin_huu_ht_khac">Tín Hữu Hội Thánh Khác</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Giới Tính</label>
                            <select class="form-control" id="filter-gioi-tinh">
                                <option value="">Tất cả</option>
                                <option value="nam">Nam</option>
                                <option value="nu">Nữ</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tình Trạng Hôn Nhân</label>
                            <select class="form-control" id="filter-hon-nhan">
                                <option value="">Tất cả</option>
                                <option value="doc_than">Độc Thân</option>
                                <option value="ket_hon">Kết Hôn</option>
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
                    <span aria-hidden="true">&times;</span>
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
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-sua-tin-huu">
                @csrf
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <!-- Các trường tương tự như form Thêm Tín Hữu -->
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
                    <!-- Thêm các trường còn lại tương tự -->
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
                    <span aria-hidden="true">&times;</span>
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
                    <span aria-hidden="true">&times;</span>
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

@push('scripts')
<script>
    $(function () {
        // Khởi tạo DataTable
        let table = $('#tin-huu-table').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('api.tin_huu.list') }}", // Thay đổi route ở đây
                dataSrc: '' // Vì API trả về mảng trực tiếp
            },
            columns: [
                { 
                    data: null, 
                    render: function (data, type, row, meta) {
                        return meta.row + 1; // Số thứ tự
                    }
                },
                { data: 'ho_ten' },
                { 
                    data: 'ngay_sinh',
                    render: function(data) {
                        return moment(data).format('DD/MM/YYYY');
                    }
                },
                { 
                    data: 'loai_tin_huu',
                    render: function(data) {
                        const loaiMap = {
                            'tin_huu_chinh_thuc': 'Chính Thức',
                            'tan_tin_huu': 'Tân Tín Hữu',
                            'tin_huu_ht_khac': 'Hội Thánh Khác'
                        };
                        return loaiMap[data] || data;
                    }
                },
                { 
                    data: 'gioi_tinh',
                    render: function(data) {
                        return data === 'nam' ? 'Nam' : 'Nữ';
                    }
                },
                { data: 'so_dien_thoai' },
                {data: null,
                    render: function(data, type, row) {
                        return `<div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info btn-edit" data-id="${row.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="${row.id}" data-name="${row.ho_ten}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-primary btn-view" data-id="${row.id}">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>`;
                    }
                }
                ],
                "language": {
                    url: '{{ asset("dist/js/Vietnamese.json") }}'
                },
                responsive: true,
                autoWidth: false
            });
        
        // Áp dụng bộ lọc
        $('#filter-loai-tin-huu, #filter-gioi-tinh, #filter-hon-nhan').on('change', function() {
            table.columns(3).search($('#filter-loai-tin-huu').val())
                .columns(4).search($('#filter-gioi-tinh').val())
                .draw();
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
        
        // Khởi tạo Select2 cho các select
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: '-- Chọn --'
        });
        
        // Xử lý nút Tải lại
        $('#btn-refresh').click(function() {
            table.ajax.reload(); // Sử dụng phương thức reload của DataTables
        });

        // Xử lý submit form thêm tín hữu
        $('#form-tin-huu').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: "{{ route('_tin_huu.store') }}",
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#modal-them-tin-huu').modal('hide');
                        $('#form-tin-huu')[0].reset();
                        
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
                    let errorMessage = 'Đã xảy ra lỗi khi thêm tín hữu';
                    
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
            
            // Fetch tín hữu data
            $.ajax({
                url: `{{ url('quan-ly-tin-huu/tin-huu') }}/${id}/edit`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Đổ dữ liệu vào form
                    $('#edit_id').val(data.id);
                    $('#edit_ho_ten').val(data.ho_ten);
                    $('#edit_ngay_sinh').val(data.ngay_sinh);
                    $('#edit_so_dien_thoai').val(data.so_dien_thoai);
                    $('#edit_dia_chi').val(data.dia_chi);
                    $('#edit_loai_tin_huu').val(data.loai_tin_huu);
                    $('#edit_gioi_tinh').val(data.gioi_tinh);
                    $('#edit_tinh_trang_hon_nhan').val(data.tinh_trang_hon_nhan);
                    $('#edit_ho_gia_dinh_id').val(data.ho_gia_dinh_id).trigger('change');
                    $('#edit_ngay_tin_chua').val(data.ngay_tin_chua);
                    
                    // Hiện modal
                    $('#modal-sua-tin-huu').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                    showAlert("Không thể lấy thông tin tín hữu. Vui lòng thử lại sau!", 'danger');
                }
            });
        });
        
        // Xử lý submit form sửa tín hữu
        $('#form-sua-tin-huu').submit(function(e) {
            e.preventDefault();
            
            const id = $('#edit_id').val();
            
            $.ajax({
                url: `{{ url('quan-ly-tin-huu/tin-huu') }}/${id}`,
                method: 'PUT',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#modal-sua-tin-huu').modal('hide');
                        
                        // Hiển thị thông báo
                        showAlert(response.message);
                        
                        // Tải lại danh sách
                        table.ajax.reload();
                    } else {
                        showAlert(response.message, 'danger');
                    }
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'Đã xảy ra lỗi khi cập nhật tín hữu';
                    
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
            $('#modal-xoa-tin-huu').modal('show');
        });
        
        // Xử lý xác nhận xóa
        $('#confirm-delete').click(function() {
            const id = $('#delete_id').val();
            
            $.ajax({
                url: `{{ url('quan-ly-tin-huu/tin-huu') }}/${id}`,
                method: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#modal-xoa-tin-huu').modal('hide');
                        
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
                    showAlert("Không thể xóa tín hữu. Vui lòng thử lại sau!", 'danger');
                }
            });
        });
        
        // Xử lý khi click nút xem chi tiết
        $(document).on('click', '.btn-view', function() {
            const id = $(this).data('id');
            
            // Fetch chi tiết tín hữu
            $.ajax({
                url: `{{ url('quan-ly-tin-huu/tin-huu') }}/${id}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Điền thông tin vào modal
                    $('#view_ho_ten').text(data.ho_ten);
                    $('#view_ngay_sinh').text(moment(data.ngay_sinh).format('DD/MM/YYYY'));
                    $('#view_so_dien_thoai').text(data.so_dien_thoai);
                    $('#view_dia_chi').text(data.dia_chi);
                    
                    const loaiMap = {
                        'tin_huu_chinh_thuc': 'Tín Hữu Chính Thức',
                        'tan_tin_huu': 'Tân Tín Hữu',
                        'tin_huu_ht_khac': 'Tín Hữu Hội Thánh Khác'
                    };
                    $('#view_loai_tin_huu').text(loaiMap[data.loai_tin_huu] || data.loai_tin_huu);
                    
                    $('#view_gioi_tinh').text(data.gioi_tinh === 'nam' ? 'Nam' : 'Nữ');
                    
                    const hnMap = {
                        'doc_than': 'Độc Thân',
                        'ket_hon': 'Kết Hôn'
                    };
                    $('#view_tinh_trang_hon_nhan').text(hnMap[data.tinh_trang_hon_nhan] || data.tinh_trang_hon_nhan);
                    
                    // Hiện modal
                    $('#modal-xem-tin-huu').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching details:", error);
                    showAlert("Không thể xem chi tiết tín hữu. Vui lòng thử lại sau!", 'danger');
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