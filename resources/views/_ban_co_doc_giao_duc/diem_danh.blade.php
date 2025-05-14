@extends('layouts.app')

@section('title', 'Điểm danh - ' . $config['name'])

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Điểm danh - {{ $config['name'] }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('_ban_nganh.' . $banType . '.index') }}">{{ $config['name'] }}</a></li>
                        <li class="breadcrumb-item active">Điểm danh</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Thông báo -->
            <div id="alert-container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Thành công!</h5>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <!-- Thanh điều hướng nhanh -->
            @include('_ban_co_doc_giao_duc.partials._ban_nganh_navigation', ['banType' => $banType])

            <!-- Card chọn tháng/năm và buổi nhóm -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-check"></i> Điểm danh</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-filter-diem-danh" method="GET" action="{{ route('_ban_nganh.co_doc_giao_duc.diem_danh') }}">
                        <div class="row mb-3">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="month">Tháng</label>
                                    <select name="month" id="month" class="form-control select2bs4">
                                        @foreach($months as $key => $monthName)
                                            <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>{{ $monthName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="year">Năm</label>
                                    <select name="year" id="year" class="form-control select2bs4">
                                        @foreach($years as $y)
                                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="buoi_nhom_id">Buổi nhóm</label>
                                    <select name="buoi_nhom_id" id="buoi_nhom_id" class="form-control select2bs4">
                                        <option value="">-- Chọn buổi nhóm --</option>
                                        @foreach($buoiNhomOptions as $buoiNhom)
                                            <option value="{{ $buoiNhom->id }}"
                                                {{ $selectedBuoiNhom == $buoiNhom->id ? 'selected' : '' }}>
                                                {{ $buoiNhom->chu_de }} ({{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y') }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-filter"></i> Lọc
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Thống kê và điểm danh -->
            @if($selectedBuoiNhom)
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-users"></i> Danh sách điểm danh</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Thống kê -->
                        <div class="row mb-3">
                            <div class="col-md-3 col-sm-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Có mặt</span>
                                        <span class="info-box-number">{{ $stats['co_mat'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Vắng mặt</span>
                                        <span class="info-box-number">{{ $stats['vang_mat'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-warning"><i class="fas fa-exclamation"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Vắng có phép</span>
                                        <span class="info-box-number">{{ $stats['vang_co_phep'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info"><i class="fas fa-percentage"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Tỷ lệ tham dự</span>
                                        <span class="info-box-number">{{ $stats['ti_le_tham_du'] }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form điểm danh -->
                        <form id="form-diem-danh" action="{{ route('api.co_doc_giao_duc.luu_diem_danh') }}" method="POST">
                            @csrf
                            <input type="hidden" name="buoi_nhom_id" value="{{ $selectedBuoiNhom }}">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px">STT</th>
                                            <th>Họ tên</th>
                                            <th style="width: 150px">Trạng thái</th>
                                            <th>Ghi chú</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($danhSachTinHuu as $index => $tinHuu)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $tinHuu->ho_ten }}</td>
                                                <td>
                                                    <select name="attendance[{{ $tinHuu->id }}][status]"
                                                        class="form-control form-control-sm">
                                                        <option value="co_mat"
                                                            {{ isset($diemDanhData[$tinHuu->id]) && $diemDanhData[$tinHuu->id]['status'] == 'co_mat' ? 'selected' : '' }}>
                                                            Có mặt
                                                        </option>
                                                        <option value="vang_mat"
                                                            {{ isset($diemDanhData[$tinHuu->id]) && $diemDanhData[$tinHuu->id]['status'] == 'vang_mat' ? 'selected' : '' }}>
                                                            Vắng mặt
                                                        </option>
                                                        <option value="vang_co_phep"
                                                            {{ isset($diemDanhData[$tinHuu->id]) && $diemDanhData[$tinHuu->id]['status'] == 'vang_co_phep' ? 'selected' : '' }}>
                                                            Vắng có phép
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text"
                                                        name="attendance[{{ $tinHuu->id }}][note]"
                                                        class="form-control form-control-sm"
                                                        value="{{ isset($diemDanhData[$tinHuu->id]) ? $diemDanhData[$tinHuu->id]['note'] : '' }}"
                                                        placeholder="Ghi chú">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Lưu điểm danh
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Vui lòng chọn một buổi nhóm để điểm danh.
                </div>
            @endif

            <!-- Modal Thêm Buổi Nhóm -->
            <div class="modal fade" id="modal-them-buoi-nhom">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Thêm Buổi Nhóm</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form id="form-them-buoi-nhom" action="{{ route('api.co_doc_giao_duc.them_buoi_nhom') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="ban_nganh_id" value="{{ $config['id'] }}">
                                <div class="form-group">
                                    <label for="ngay_dien_ra">Ngày diễn ra <span class="text-danger">*</span></label>
                                    <input type="date" name="ngay_dien_ra" id="ngay_dien_ra" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="chu_de">Chủ đề <span class="text-danger">*</span></label>
                                    <input type="text" name="chu_de" id="chu_de" class="form-control" required placeholder="Nhập chủ đề">
                                </div>
                                <div class="form-group">
                                    <label for="dien_gia_id">Diễn giả</label>
                                    <select name="dien_gia_id" id="dien_gia_id" class="form-control select2bs4">
                                        <option value="">-- Chọn diễn giả --</option>
                                        @foreach($dienGias as $dienGia)
                                            <option value="{{ $dienGia->id }}">{{ $dienGia->ho_ten }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="dia_diem">Địa điểm <span class="text-danger">*</span></label>
                                    <input type="text" name="dia_diem" id="dia_diem" class="form-control" required placeholder="Nhập địa điểm">
                                </div>
                                <div class="form-group">
                                    <label for="gio_bat_dau">Giờ bắt đầu <span class="text-danger">*</span></label>
                                    <input type="time" name="gio_bat_dau" id="gio_bat_dau" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="gio_ket_thuc">Giờ kết thúc <span class="text-danger">*</span></label>
                                    <input type="time" name="gio_ket_thuc" id="gio_ket_thuc" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="ghi_chu">Ghi chú</label>
                                    <textarea name="ghi_chu" id="ghi_chu" class="form-control" rows="4" placeholder="Nhập ghi chú"></textarea>
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
        </div>
    </section>
@endsection

@section('page-scripts')
    <script>
        $(function () {
            // Khởi tạo Select2
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                placeholder: '-- Chọn một mục --',
                allowClear: true,
                width: '100%'
            });

            // Xử lý form điểm danh
            $('#form-diem-danh').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                console.log('Gửi yêu cầu điểm danh:', formData);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('#form-diem-danh button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (điểm danh):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            window.location.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi khi lưu điểm danh!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (điểm danh):', xhr.responseJSON);
                        let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                        if (xhr.responseJSON?.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        $('#form-diem-danh button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save"></i> Lưu điểm danh');
                    }
                });
            });

            // Xử lý form thêm buổi nhóm
            $('#form-them-buoi-nhom').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                console.log('Gửi yêu cầu thêm buổi nhóm:', formData);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('#form-them-buoi-nhom button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (thêm buổi nhóm):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            $('#modal-them-buoi-nhom').modal('hide');
                            window.location.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi khi thêm buổi nhóm!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (thêm buổi nhóm):', xhr.responseJSON);
                        let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                        if (xhr.responseJSON?.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        $('#form-them-buoi-nhom button[type="submit"]').prop('disabled', false).html('Lưu');
                    }
                });
            });

            // Nút mở modal thêm buổi nhóm
            $('#btn-them-buoi-nhom').on('click', function () {
                $('#modal-them-buoi-nhom').modal('show');
            });
        });
    </script>
@endsection