@extends('layouts.app')

@section('title', 'Phân Công Chi Tiết - Ban Trung Lão')

@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Thông báo thành công hoặc lỗi -->
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

        <!-- Các nút chức năng -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex justify-content-between">
                        <div class="btn-group">
                            <a href="{{ route('_ban_trung_lao.index') }}" class="btn btn-primary">
                                <i class="fas fa-home"></i> Trang chính
                            </a>
                            <a href="{{ route('_ban_trung_lao.diem_danh') }}" class="btn btn-success">
                                <i class="fas fa-clipboard-check"></i> Điểm danh
                            </a>
                            <a href="{{ route('_ban_trung_lao.tham_vieng') }}" class="btn btn-info">
                                <i class="fas fa-user-friends"></i> Thăm viếng
                            </a>
                            <a href="{{ route('_ban_trung_lao.phan_cong') }}" class="btn btn-warning">
                                <i class="fas fa-tasks"></i> Phân công
                            </a>
                            <a href="{{ route('_ban_trung_lao.phan_cong_chi_tiet') }}" class="btn btn-warning">
                                <i class="fas fa-tasks"></i> Phân công chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-filter"></i>
                    Lọc dữ liệu
                </h3>
            </div>
            
            <div class="card-body">
                <form action="{{ route('_ban_trung_lao.phan_cong_chi_tiet') }}" method="GET" id="filter-form">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tháng:</label>
                                <select name="month" class="form-control" id="month-select">
                                    @foreach($months as $monthNum => $monthName)
                                        <option value="{{ $monthNum }}" {{ $month == $monthNum ? 'selected' : '' }}>
                                            {{ $monthName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Năm:</label>
                                <select name="year" class="form-control" id="year-select">
                                    @foreach($years as $yearNum)
                                        <option value="{{ $yearNum }}" {{ $year == $yearNum ? 'selected' : '' }}>
                                            {{ $yearNum }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Buổi nhóm:</label>
                                <select name="buoi_nhom_id" class="form-control" id="buoi-nhom-select">
                                    <option value="">-- Chọn buổi nhóm --</option>
                                    @foreach($buoiNhomOptions as $buoiNhom)
                                        <option value="{{ $buoiNhom->id }}" {{ $selectedBuoiNhom == $buoiNhom->id ? 'selected' : '' }}>
                                            {{ $buoiNhom->ngay_dien_ra->format('d/m/Y') }} - {{ $buoiNhom->chu_de }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Tìm kiếm
                            </button>
                            <a href="{{ route('_ban_trung_lao.phan_cong_chi_tiet') }}" class="btn btn-default">
                                <i class="fas fa-sync"></i> Làm mới
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Chi tiết buổi nhóm -->
        @if($selectedBuoiNhom)
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    Thông tin buổi nhóm
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 140px">Ngày:</th>
                                <td>{{ $currentBuoiNhom->ngay_dien_ra->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Chủ đề:</th>
                                <td>{{ $currentBuoiNhom->chu_de }}</td>
                            </tr>
                            <tr>
                                <th>Điều hành:</th>
                                <td>{{ $currentBuoiNhom->tinHuuHdct->ho_ten ?? 'Chưa phân công' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 140px">Diễn giả:</th>
                                <td>{{ $currentBuoiNhom->dienGia->ho_ten ?? 'Chưa phân công' }}</td>
                            </tr>
                            <tr>
                                <th>Đọc Kinh Thánh:</th>
                                <td>{{ $currentBuoiNhom->tinHuuDoKt->ho_ten ?? 'Chưa phân công' }}</td>
                            </tr>
                            <tr>
                                <th>Địa điểm:</th>
                                <td>{{ $currentBuoiNhom->dia_diem ?? 'Chưa cập nhật' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Danh sách phân công nhiệm vụ -->
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list-check"></i>
                    Danh sách phân công nhiệm vụ
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            
            <div class="card-body">
                @if($selectedBuoiNhom)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Nhiệm vụ</th>
                                    <th>Người thực hiện</th>
                                    <th>Ghi chú</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($nhiemVuPhanCong as $index => $phanCong)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $phanCong->nhiemVu->ten_nhiem_vu }}</td>
                                    <td>{{ $phanCong->tinHuu->ho_ten ?? 'Chưa phân công' }}</td>
                                    <td>{{ $phanCong->ghi_chu }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-warning btn-edit-phan-cong"
                                                data-id="{{ $phanCong->id }}"
                                                data-nhiem-vu-id="{{ $phanCong->nhiem_vu_id }}"
                                                data-tin-huu-id="{{ $phanCong->tin_huu_id }}"
                                                data-ghi-chu="{{ $phanCong->ghi_chu }}"
                                                data-toggle="modal"
                                                data-target="#modal-phan-cong">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger btn-delete-phan-cong"
                                                data-id="{{ $phanCong->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Chưa có phân công nhiệm vụ cho buổi nhóm này</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modal-phan-cong">
                                <i class="fas fa-plus"></i> Thêm phân công
                            </button>
                        </div>
                    </div>
                @else
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info"></i> Chưa chọn buổi nhóm!</h5>
                    <p>Vui lòng chọn một buổi nhóm để xem và phân công nhiệm vụ.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Danh sách thành viên trong ban -->
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users"></i>
                    Danh sách thành viên Ban Trung Lão
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Họ tên</th>
                                <th>Chức vụ</th>
                                <th>Điện thoại</th>
                                <th>Đã phân công</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($thanhVienBan as $thanhVien)
                            <tr>
                                <td>{{ $thanhVien->tinHuu->ho_ten }}</td>
                                <td>{{ $thanhVien->chuc_vu ?? 'Thành viên' }}</td>
                                <td>{{ $thanhVien->tinHuu->so_dien_thoai }}</td>
                                <td>
                                    @if($selectedBuoiNhom && isset($daPhanCong[$thanhVien->tinHuu->id]))
                                        <span class="badge badge-success">{{ $daPhanCong[$thanhVien->tinHuu->id] }}</span>
                                    @else
                                        <span class="badge badge-secondary">Chưa phân công</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Phân công nhiệm vụ -->
<div class="modal fade" id="modal-phan-cong">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Phân công nhiệm vụ</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-phan-cong" action="{{ route('api.ban_trung_lao.phan_cong_nhiem_vu') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="phan-cong-id">
                <input type="hidden" name="buoi_nhom_id" value="{{ $selectedBuoiNhom }}">
                
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nhiệm vụ <span class="text-danger">*</span></label>
                        <select class="form-control select2bs4" name="nhiem_vu_id" id="nhiem-vu-id" required>
                            <option value="">-- Chọn nhiệm vụ --</option>
                            @foreach($danhSachNhiemVu as $nhiemVu)
                                <option value="{{ $nhiemVu->id }}">{{ $nhiemVu->ten_nhiem_vu }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Người thực hiện <span class="text-danger">*</span></label>
                        <select class="form-control select2bs4" name="tin_huu_id" id="tin-huu-id" required>
                            <option value="">-- Chọn người thực hiện --</option>
                            @foreach($thanhVienBan as $thanhVien)
                                <option value="{{ $thanhVien->tinHuu->id }}">{{ $thanhVien->tinHuu->ho_ten }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Ghi chú</label>
                        <textarea class="form-control" name="ghi_chu" id="ghi-chu" rows="3" placeholder="Nhập ghi chú (nếu có)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu phân công</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    // Khởi tạo Select2
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });
    
    // Xử lý chọn buổi nhóm
    $('#buoi-nhom-select').on('change', function() {
        $('#filter-form').submit();
    });
    
    // Xử lý click nút chỉnh sửa phân công
    $(document).on('click', '.btn-edit-phan-cong', function() {
        const id = $(this).data('id');
        const nhiemVuId = $(this).data('nhiem-vu-id');
        const tinHuuId = $(this).data('tin-huu-id');
        const ghiChu = $(this).data('ghi-chu');
        
        // Cập nhật form
        $('#phan-cong-id').val(id);
        $('#nhiem-vu-id').val(nhiemVuId).trigger('change');
        $('#tin-huu-id').val(tinHuuId).trigger('change');
        $('#ghi-chu').val(ghiChu);
        
        // Cập nhật tiêu đề modal
        $('.modal-title').text('Cập nhật phân công nhiệm vụ');
    });
    
    // Xử lý mở modal thêm mới
    $('#modal-phan-cong').on('show.bs.modal', function (e) {
        // Nếu không có trigger từ nút edit thì là thêm mới
        if (!$(e.relatedTarget).hasClass('btn-edit-phan-cong')) {
            // Reset form
            $('#phan-cong-id').val('');
            $('#form-phan-cong').trigger('reset');
            $('#nhiem-vu-id').val('').trigger('change');
            $('#tin-huu-id').val('').trigger('change');
            
            // Cập nhật tiêu đề modal
            $('.modal-title').text('Thêm phân công nhiệm vụ');
        }
    });
    
    // Xử lý submit form phân công
    $('#form-phan-cong').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const isEdit = $('#phan-cong-id').val() !== '';
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert('Phân công nhiệm vụ thành công!');
                    location.reload();
                } else {
                    alert('Lỗi: ' + response.message);
                }
            },
            error: function(xhr) {
                let errorMsg = 'Đã xảy ra lỗi!';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMsg = '';
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        errorMsg += value[0] + '\n';
                    });
                }
                alert(errorMsg);
            }
        });
    });
    
    // Xử lý xóa phân công
    $(document).on('click', '.btn-delete-phan-cong', function() {
        const id = $(this).data('id');
        
        if (confirm('Bạn có chắc chắn muốn xóa phân công này?')) {
            $.ajax({
                url: '{{ route("api.ban_trung_lao.xoa_phan_cong", ["id" => "__ID__"]) }}'.replace('__ID__', id),
                method: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        alert('Xóa phân công thành công!');
                        location.reload();
                    } else {
                        alert('Lỗi: ' + response.message);
                    }
                },
                error: function() {
                    alert('Đã xảy ra lỗi khi xóa phân công!');
                }
            });
        }
    });
});
</script>
@endpush