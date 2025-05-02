@extends('layouts.app')

@section('title', 'Điểm Danh - {{ $banNganh->ten }}')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Dropdown chọn ban ngành -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Chọn Ban Ngành</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="ban_nganh_select">Ban Ngành</label>
                        <select class="form-control select2bs4" id="ban_nganh_select" onchange="location.href='{{ route('ban_muc_vu.diem_danh') }}?ban_nganh_id=' + this.value">
                            @foreach($banNganhs as $ban)
                                <option value="{{ $ban->id }}" {{ $banNganh->id == $ban->id ? 'selected' : '' }}>
                                    {{ $ban->ten }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

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
                    <a href="{{ route('ban_muc_vu.index', ['ban_nganh_id' => $banNganh->id]) }}" class="action-btn btn-primary-custom">
                        <i class="fas fa-home"></i> Trang chính
                    </a>
                    <a href="{{ route('ban_muc_vu.diem_danh', ['ban_nganh_id' => $banNganh->id]) }}" class="action-btn btn-success-custom">
                        <i class="fas fa-clipboard-check"></i> Điểm danh
                    </a>
                    <a href="{{ route('ban_muc_vu.tham_vieng', ['ban_nganh_id' => $banNganh->id]) }}" class="action-btn btn-info-custom">
                        <i class="fas fa-user-friends"></i> Thăm viếng
                    </a>
                </div>

                <!-- Hàng 2: Chức năng phân công và báo cáo -->
                <div class="button-row">
                    <a href="{{ route('ban_muc_vu.phan_cong', ['ban_nganh_id' => $banNganh->id]) }}" class="action-btn btn-warning-custom">
                        <i class="fas fa-tasks"></i> Phân công
                    </a>
                    <a href="{{ route('ban_muc_vu.phan_cong_chi_tiet', ['ban_nganh_id' => $banNganh->id]) }}" class="action-btn btn-info-custom">
                        <i class="fas fa-clipboard-list"></i> Chi tiết PC
                    </a>
                    <a href="{{ route('ban_muc_vu.nhap_lieu_bao_cao', ['ban_nganh_id' => $banNganh->id]) }}" class="action-btn btn-success-custom">
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
                    <button type="button" class="action-btn btn-primary-custom" data-toggle="modal"
                        data-target="#modal-them-buoi-nhom">
                        <i class="fas fa-plus"></i> Thêm buổi nhóm
                    </button>
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
                    <form action="{{ route('ban_muc_vu.diem_danh', ['ban_nganh_id' => $banNganh->id]) }}" method="GET" id="filter-form">
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
                                        <option value="">-- Tất cả --</option>
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
                                <a href="{{ route('ban_muc_vu.diem_danh', ['ban_nganh_id' => $banNganh->id]) }}" class="btn btn-default">
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

            <!-- Danh sách điểm danh -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clipboard-check"></i>
                        Danh sách điểm danh buổi nhóm
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    @if($selectedBuoiNhom)
                        <form id="attendance-form" action="{{ route('api.ban_muc_vu.luu_diem_danh') }}" method="POST">
                            @csrf
                            <input type="hidden" name="buoi_nhom_id" value="{{ $selectedBuoiNhom }}">

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px">STT</th>
                                            <th>Họ tên</th>
                                            <th style="width: 180px">Điện thoại</th>
                                            <th style="width: 150px">Trạng thái</th>
                                            <th>Ghi chú</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($danhSachTinHuu as $index => $tinHuu)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $tinHuu->ho_ten }}</td>
                                                <td>{{ $tinHuu->so_dien_thoai }}</td>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <select name="attendance[{{ $tinHuu->id }}][status]"
                                                            class="form-control attendance-status">
                                                            <option value="co_mat" {{ isset($diemDanhData[$tinHuu->id]) && $diemDanhData[$tinHuu->id]['status'] == 'co_mat' ? 'selected' : '' }}>
                                                                Có mặt</option>
                                                            <option value="vang_mat" {{ isset($diemDanhData[$tinHuu->id]) && $diemDanhData[$tinHuu->id]['status'] == 'vang_mat' ? 'selected' : '' }}>Vắng mặt</option>
                                                            <option value="vang_co_phep" {{ isset($diemDanhData[$tinHuu->id]) && $diemDanhData[$tinHuu->id]['status'] == 'vang_co_phep' ? 'selected' : '' }}>Vắng có phép</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="form-group mb-0">
                                                        <input type="text" name="attendance[{{ $tinHuu->id }}][note]"
                                                            class="form-control" placeholder="Ghi chú"
                                                            value="{{ isset($diemDanhData[$tinHuu->id]) ? $diemDanhData[$tinHuu->id]['note'] : '' }}">
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Không có dữ liệu</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Lưu điểm danh
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i> Chưa chọn buổi nhóm!</h5>
                            <p>Vui lòng chọn một buổi nhóm để xem và điểm danh.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Thống kê tổng hợp -->
            @if($selectedBuoiNhom)
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie"></i>
                            Thống kê tham dự
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="chart-responsive">
                                    <canvas id="pieChart" height="200"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <ul class="chart-legend clearfix">
                                    <li><i class="far fa-circle text-success"></i> Có mặt: {{ $stats['co_mat'] }} người</li>
                                    <li><i class="far fa-circle text-danger"></i> Vắng mặt: {{ $stats['vang_mat'] }} người</li>
                                    <li><i class="far fa-circle text-warning"></i> Vắng có phép: {{ $stats['vang_co_phep'] }} người</li>
                                </ul>
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ $stats['ti_le_tham_du'] }}%</h3>
                                        <p>Tỷ lệ tham dự</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-percentage"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                        <form id="add-buoi-nhom-form" action="{{ route('api.ban_muc_vu.them_buoi_nhom') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" name="ban_nganh_id" value="{{ $banNganh->id }}">
                                <div class="form-group">
                                    <label>Ngày diễn ra <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control date-picker" name="ngay_dien_ra" required
                                        value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <label>Chủ đề <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="chu_de" required placeholder="Nhập chủ đề">
                                </div>
                                <div class="form-group">
                                    <label>Diễn giả</label>
                                    <select class="form-control select2bs4" name="dien_gia_id">
                                        <option value="">-- Chọn diễn giả --</option>
                                        @foreach($dienGias as $dienGia)
                                            <option value="{{ $dienGia->id }}">{{ $dienGia->ho_ten }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Địa điểm <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="dia_diem" required placeholder="Nhập địa điểm">
                                </div>
                                <div class="form-group">
                                    <label>Giờ bắt đầu <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" name="gio_bat_dau" required value="19:00">
                                </div>
                                <div class="form-group">
                                    <label>Giờ kết thúc <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" name="gio_ket_thuc" required value="21:00">
                                </div>
                                <div class="form-group">
                                    <label>Ghi chú</label>
                                    <textarea class="form-control" name="ghi_chu" rows="3" placeholder="Nhập ghi chú"></textarea>
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

    <!-- Modal Thêm Thành Viên -->
    @include('_ban_muc_vu.partials._modal_them_thanh_vien', ['banNganh' => $banNganh, 'tinHuuList' => $tinHuuList])

    <!-- Modal Cập Nhật Chức Vụ -->
    @include('_ban_muc_vu.partials._modal_cap_nhat_chuc_vu', ['ban_nganh_id' => $banNganh->id])

    <!-- Modal Xóa Thành Viên -->
    @include('_ban_muc_vu.partials._modal_xoa_thanh_vien', ['ban_nganh_id' => $banNganh->id])
@endsection

@include('_ban_muc_vu.scripts._scripts_diem_danh', ['ban_nganh_id' => $banNganh->id])