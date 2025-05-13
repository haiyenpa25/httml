@extends('layouts.app')

@section('title', 'Báo Cáo - ' . ($banNganh->ten ?? 'Ban Ngành'))

@section('page-styles')
<style>
    .modal-chart {
        min-height: 350px !important;
        height: 350px !important;
        max-height: 350px !important;
        width: 100% !important;
    }
    .modal-body {
        padding: 20px;
    }
</style>
@endsection

@section('content')
<section class="content-header">
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

        <!-- Thanh điều hướng nhanh -->
        @include('_ban_nganh.partials._ban_nganh_navigation')

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Báo Cáo {{ $banNganh->ten ?? 'Ban Ngành' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('_ban_nganh.' . $banType . '.bao_cao') }}">Báo Cáo</a></li>
                    <li class="breadcrumb-item active">{{ $banNganh->ten ?? 'Ban Ngành' }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Form lọc -->
        <div class="card mb-4">
            <div class="card-header bg-primary">
                <h5 class="card-title text-white">Lọc Báo Cáo</h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form id="filter-form" method="GET" action="{{ route('_ban_nganh.' . $banType . '.bao_cao') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="month">Tháng:</label>
                                <select id="month" name="month" class="form-control">
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                            Tháng {{ $m }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="year">Năm:</label>
                                <select id="year" name="year" class="form-control">
                                    @for ($y = date('Y') + 1; $y >= date('Y') - 5; $y--)
                                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-filter"></i> Lọc
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Thống kê tổng quan -->
        <div class="row">
            <div class="col-md-3">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $summary['totalMeetings'] }}</h3>
                        <p>Tổng số buổi nhóm</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $summary['avgAttendance'] }}</h3>
                        <p>Số lượng tham dự trung bình</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ number_format($summary['totalOffering'], 0, ',', '.') }} VNĐ</h3>
                        <p>Tổng dâng hiến</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-donate"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $summary['totalVisits'] }}</h3>
                        <p>Tổng số lần thăm viếng</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="card">
            <div class="card-header p-0">
                <ul class="nav nav-tabs" id="baocao-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="buoinhom-tab" data-toggle="pill" href="#buoinhom" role="tab">
                            <i class="fas fa-users"></i> Buổi Nhóm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="taichinh-tab" data-toggle="pill" href="#taichinh" role="tab">
                            <i class="fas fa-money-bill"></i> Tài Chính
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="thamvieng-tab" data-toggle="pill" href="#thamvieng" role="tab">
                            <i class="fas fa-handshake"></i> Thăm Viếng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="danhgia-tab" data-toggle="pill" href="#danhgia" role="tab">
                            <i class="fas fa-chart-line"></i> Đánh Giá
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="kehoach-tab" data-toggle="pill" href="#kehoach" role="tab">
                            <i class="fas fa-calendar-alt"></i> Kế Hoạch
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="kiennghi-tab" data-toggle="pill" href="#kiennghi" role="tab">
                            <i class="fas fa-comment-alt"></i> Kiến Nghị
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="baocao-tabContent">
                    <!-- Tab: Buổi Nhóm -->
                    <div class="tab-pane fade show active" id="buoinhom" role="tabpanel">
                        <!-- Nút xem biểu đồ -->
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#chartModal">
                                <i class="fas fa-chart-bar"></i> Xem biểu đồ
                            </button>
                        </div>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-church"></i> Nhóm Chúa Nhật (Hội Thánh)</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Ngày</th>
                                                <th>Đề tài</th>
                                                <th>Diễn giả</th>
                                                <th>Số lượng tham dự</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($buoiNhomHT as $index => $buoiNhom)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y') }}</td>
                                                <td>{{ $buoiNhom->chu_de ?? 'N/A' }}</td>
                                                <td>{{ $buoiNhom->dienGia->ho_ten ?? 'N/A' }}</td>
                                                <td>{{ $buoiNhom->so_luong_trung_lao ?? 0 }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Không có dữ liệu</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-users"></i> Nhóm Tối Thứ 7 ({{ $banNganh->ten ?? 'Ban Ngành' }})</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Ngày</th>
                                                <th>Đề tài</th>
                                                <th>Diễn giả</th>
                                                <th>Số lượng tham dự</th>
                                                <th>Dâng hiến (VNĐ)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($buoiNhomBN as $index => $buoiNhom)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y') }}</td>
                                                <td>{{ $buoiNhom->chu_de ?? 'N/A' }}</td>
                                                <td>{{ $buoiNhom->dienGia->ho_ten ?? 'N/A' }}</td>
                                                <td>{{ $buoiNhom->so_luong_trung_lao ?? 0 }}</td>
                                                <td>{{ number_format($buoiNhom->giaoDichTaiChinh->so_tien ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Không có dữ liệu</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Tài Chính -->
                    <div class="tab-pane fade" id="taichinh" role="tabpanel">
                        <div class="card card-warning card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-money-bill"></i> Tài Chính</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="small-box bg-success">
                                            <div class="inner">
                                                <h3>{{ number_format($taiChinh['tongThu'], 0, ',', '.') }} VNĐ</h3>
                                                <p>Tổng thu</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-arrow-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="small-box bg-danger">
                                            <div class="inner">
                                                <h3>{{ number_format($taiChinh['tongChi'], 0, ',', '.') }} VNĐ</h3>
                                                <p>Tổng chi</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-arrow-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="small-box bg-info">
                                            <div class="inner">
                                                <h3>{{ number_format($taiChinh['tongTon'], 0, ',', '.') }} VNĐ</h3>
                                                <p>Tổng tồn</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-balance-scale"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Ngày</th>
                                                <th>Loại</th>
                                                <th>Số tiền</th>
                                                <th>Mô tả</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($taiChinh['giaoDich'] as $index => $giaoDich)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($giaoDich->ngay_giao_dich)->format('d/m/Y') }}</td>
                                                <td>{{ $giaoDich->loai == 'thu' ? 'Thu' : 'Chi' }}</td>
                                                <td>{{ number_format($giaoDich->so_tien, 0, ',', '.') }} VNĐ</td>
                                                <td>{{ $giaoDich->mo_ta }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Không có giao dịch</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Thăm Viếng -->
                    <div class="tab-pane fade" id="thamvieng" role="tabpanel">
                        <div class="card card-info card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-handshake"></i> Thăm Viếng</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Ngày</th>
                                                <th>Tín hữu</th>
                                                <th>Người thăm</th>
                                                <th>Nội dung</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($thamVieng as $index => $tham)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($tham->ngay_tham)->format('d/m/Y') }}</td>
                                                <td>{{ $tham->tinHuu->ho_ten ?? 'N/A' }}</td>
                                                <td>{{ $tham->nguoiTham->ho_ten ?? 'N/A' }}</td>
                                                <td>{{ $tham->noi_dung }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Không có dữ liệu thăm viếng</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Đánh Giá -->
                    <div class="tab-pane fade" id="danhgia" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-thumbs-up"></i> Điểm mạnh</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Nội dung</th>
                                                    <th>Người đánh giá</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($diemManh as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item->noi_dung }}</td>
                                                    <td>{{ $item->nguoiDanhGia->ho_ten ?? 'N/A' }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">Không có điểm mạnh</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-outline card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-thumbs-down"></i> Điểm cần cải thiện</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>STT</th>
                                                    <th>Nội dung</th>
                                                    <th>Người đánh giá</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($diemYeu as $index => $item)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $item->noi_dung }}</td>
                                                    <td>{{ $item->nguoiDanhGia->ho_ten ?? 'N/A' }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="3" class="text-center">Không có điểm cần cải thiện</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Kế Hoạch -->
                    <div class="tab-pane fade" id="kehoach" role="tabpanel">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Kế hoạch tháng {{ $nextMonth }}/{{ $nextYear }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Hoạt động</th>
                                                <th>Thời gian</th>
                                                <th>Người phụ trách</th>
                                                <th>Ghi chú</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($keHoach as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->hoat_dong }}</td>
                                                <td>{{ $item->thoi_gian }}</td>
                                                <td>{{ $item->nguoiPhuTrach->ho_ten ?? 'N/A' }}</td>
                                                <td>{{ $item->ghi_chu }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Không có kế hoạch</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab: Kiến Nghị -->
                    <div class="tab-pane fade" id="kiennghi" role="tabpanel">
                        <div class="card card-outline card-primary">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-comment-alt"></i> Ý kiến & Kiến nghị</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tiêu đề</th>
                                                <th>Nội dung</th>
                                                <th>Người đề xuất</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($kienNghi as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->tieu_de }}</td>
                                                <td>{{ $item->noi_dung }}</td>
                                                <td>{{ $item->nguoiDeXuat->ho_ten ?? 'N/A' }}</td>
                                                <td>{{ $item->trang_thai }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Không có kiến nghị</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal hiển thị biểu đồ -->
        <div class="modal fade" id="chartModal" tabindex="-1" role="dialog" aria-labelledby="chartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="chartModalLabel">Biểu đồ Số lượng Tham dự Theo Tuần</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form chọn tháng so sánh -->
                        <form id="compare-form" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="compare_month">Tháng so sánh:</label>
                                        <select id="compare_month" name="month" class="form-control">
                                            <option value="">Chọn tháng</option>
                                            @for ($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}">Tháng {{ $m }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="compare_year">Năm so sánh:</label>
                                        <select id="compare_year" name="year" class="form-control">
                                            <option value="">Chọn năm</option>
                                            @for ($y = date('Y') + 1; $y >= date('Y') - 5; $y--)
                                                <option value="{{ $y }}">{{ $y }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-sync"></i> So sánh
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!-- Canvas biểu đồ -->
                        <canvas id="modalChart" class="modal-chart"></canvas>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('page-scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Handle filter form submission
    $('#filter-form').on('submit', function(e) {
        $('#alert-container').html('<div class="alert alert-info">Đang tải dữ liệu...</div>');
    });

    // Handle print report button
    $('#print-report').click(function() {
        window.print();
    });

    // Handle export Excel button
    $('#export-excel').click(function() {
        toastr.info('Chức năng xuất Excel đang được phát triển');
    });

    // Biến toàn cục để lưu biểu đồ
    let chartInstance = null;

    // Hàm vẽ biểu đồ
    function drawChart(dataHT, dataBN, month, year, compareDataHT = [], compareDataBN = [], compareMonth = null, compareYear = null) {
        console.log('Drawing chart with data:', {
            dataHT, dataBN, month, year,
            compareDataHT, compareDataBN, compareMonth, compareYear
        });

        const daysInMonth = new Date(year, month, 0).getDate();
        const daysInCompareMonth = compareMonth ? new Date(compareYear, compareMonth, 0).getDate() : daysInMonth;
        const numWeeks = Math.ceil(Math.max(daysInMonth, daysInCompareMonth) / 7);
        const weeks = Array.from({ length: numWeeks }, (_, i) => `Tuần ${i + 1}`);
        console.log('numWeeks:', numWeeks, 'weeks:', weeks);

        const attendanceHT = new Array(numWeeks).fill(0);
        const attendanceBN = new Array(numWeeks).fill(0);
        const compareAttendanceHT = new Array(numWeeks).fill(0);
        const compareAttendanceBN = new Array(numWeeks).fill(0);

        // Xử lý dữ liệu tháng hiện tại
        if (dataHT && Array.isArray(dataHT)) {
            dataHT.forEach(meeting => {
                if (meeting && meeting.ngay_dien_ra) {
                    const date = new Date(meeting.ngay_dien_ra);
                    if (isNaN(date.getTime())) {
                        console.warn('Invalid date for buoiNhomHT:', meeting.ngay_dien_ra);
                        return;
                    }
                    const dayOfMonth = date.getDate();
                    const weekIndex = Math.floor((dayOfMonth - 1) / 7);
                    console.log('Processing HT meeting:', {
                        id: meeting.id,
                        ngay_dien_ra: meeting.ngay_dien_ra,
                        so_luong_trung_lao: meeting.so_luong_trung_lao
                    });
                    attendanceHT[weekIndex] += parseInt(meeting.so_luong_trung_lao || 0);
                }
            });
        }

        if (dataBN && Array.isArray(dataBN)) {
            dataBN.forEach(meeting => {
                if (meeting && meeting.ngay_dien_ra) {
                    const date = new Date(meeting.ngay_dien_ra);
                    if (isNaN(date.getTime())) {
                        console.warn('Invalid date for buoiNhomBN:', meeting.ngay_dien_ra);
                        return;
                    }
                    const dayOfMonth = date.getDate();
                    const weekIndex = Math.floor((dayOfMonth - 1) / 7);
                    console.log('Processing BN meeting:', {
                        id: meeting.id,
                        ngay_dien_ra: meeting.ngay_dien_ra,
                        so_luong_trung_lao: meeting.so_luong_trung_lao
                    });
                    attendanceBN[weekIndex] += parseInt(meeting.so_luong_trung_lao || 0);
                }
            });
        }

        // Xử lý dữ liệu tháng so sánh
        if (compareDataHT && Array.isArray(compareDataHT)) {
            compareDataHT.forEach(meeting => {
                if (meeting && meeting.ngay_dien_ra) {
                    const date = new Date(meeting.ngay_dien_ra);
                    if (isNaN(date.getTime())) {
                        console.warn('Invalid date for compare buoiNhomHT:', meeting.ngay_dien_ra);
                        return;
                    }
                    const dayOfMonth = date.getDate();
                    const weekIndex = Math.floor((dayOfMonth - 1) / 7);
                    console.log('Processing compare HT meeting:', {
                        id: meeting.id,
                        ngay_dien_ra: meeting.ngay_dien_ra,
                        so_luong_trung_lao: meeting.so_luong_trung_lao
                    });
                    compareAttendanceHT[weekIndex] += parseInt(meeting.so_luong_trung_lao || 0);
                }
            });
        }

        if (compareDataBN && Array.isArray(compareDataBN)) {
            compareDataBN.forEach(meeting => {
                if (meeting && meeting.ngay_dien_ra) {
                    const date = new Date(meeting.ngay_dien_ra);
                    if (isNaN(date.getTime())) {
                        console.warn('Invalid date for compare buoiNhomBN:', meeting.ngay_dien_ra);
                        return;
                    }
                    const dayOfMonth = date.getDate();
                    const weekIndex = Math.floor((dayOfMonth - 1) / 7);
                    console.log('Processing compare BN meeting:', {
                        id: meeting.id,
                        ngay_dien_ra: meeting.ngay_dien_ra,
                        so_luong_trung_lao: meeting.so_luong_trung_lao
                    });
                    compareAttendanceBN[weekIndex] += parseInt(meeting.so_luong_trung_lao || 0);
                }
            });
        }

        console.log('Final attendanceHT:', attendanceHT);
        console.log('Final attendanceBN:', attendanceBN);
        console.log('Final compareAttendanceHT:', compareAttendanceHT);
        console.log('Final compareAttendanceBN:', compareAttendanceBN);

        // Sử dụng dữ liệu mẫu nếu không có dữ liệu
        if (attendanceHT.every(val => val === 0) && attendanceBN.every(val => val === 0) &&
            compareAttendanceHT.every(val => val === 0) && compareAttendanceBN.every(val => val === 0)) {
            console.log('Using sample data for', numWeeks, 'weeks');
            attendanceHT.splice(0, attendanceHT.length, ...Array(numWeeks).fill(0).map(() => Math.floor(Math.random() * 20 + 20)));
            attendanceBN.splice(0, attendanceBN.length, ...Array(numWeeks).fill(0).map(() => Math.floor(Math.random() * 15 + 15)));
        }

        // Hủy biểu đồ cũ nếu tồn tại
        if (chartInstance) {
            chartInstance.destroy();
        }

        const ctx = document.getElementById('modalChart').getContext('2d');
        console.log('Chart context:', ctx);
        chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: weeks,
                datasets: [
                    {
                        label: `Hội Thánh (Tháng ${month}/${year})`,
                        data: attendanceHT,
                        backgroundColor: '#6c757d',
                        borderColor: '#6c757d',
                        borderWidth: 1
                    },
                    {
                        label: `Ban Ngành (Tháng ${month}/${year})`,
                        data: attendanceBN,
                        backgroundColor: '#28a745',
                        borderColor: '#28a745',
                        borderWidth: 1
                    },
                    {
                        label: compareMonth ? `Hội Thánh (Tháng ${compareMonth}/${compareYear})` : 'Hội Thánh (So sánh)',
                        data: compareAttendanceHT,
                        backgroundColor: '#007bff',
                        borderColor: '#007bff',
                        borderWidth: 1
                    },
                    {
                        label: compareMonth ? `Ban Ngành (Tháng ${compareMonth}/${compareYear})` : 'Ban Ngành (So sánh)',
                        data: compareAttendanceBN,
                        backgroundColor: '#fd7e14',
                        borderColor: '#fd7e14',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Số lượng tham dự'
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tuần'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: compareMonth ? `So sánh Tháng ${month}/${year} với Tháng ${compareMonth}/${compareYear}` : `Số lượng Tham dự Tháng ${month}/${year}`
                    }
                }
            }
        });
    }

    // Vẽ biểu đồ ban đầu khi modal mở
    $('#chartModal').on('shown.bs.modal', function () {
        console.log('Chart modal shown');
        drawChart(@json($buoiNhomHT), @json($buoiNhomBN), {{ $month }}, {{ $year }});
    });

    // Xử lý form so sánh
    $('#compare-form').on('submit', function(e) {
        e.preventDefault();
        const compareMonth = $('#compare_month').val();
        const compareYear = $('#compare_year').val();

        if (!compareMonth || !compareYear) {
            toastr.warning('Vui lòng chọn tháng và năm để so sánh');
            return;
        }

        $.ajax({
            url: '{{ route("_ban_nganh.compare_data", $banType) }}',
            method: 'GET',
            data: {
                month: compareMonth,
                year: compareYear
            },
            success: function(response) {
                if (response.success) {
                    const compareData = response.data;
                    drawChart(
                        @json($buoiNhomHT),
                        @json($buoiNhomBN),
                        {{ $month }},
                        {{ $year }},
                        compareData.buoiNhomHT,
                        compareData.buoiNhomBN,
                        compareData.month,
                        compareData.year
                    );
                } else {
                    toastr.error(response.message || 'Lỗi khi lấy dữ liệu so sánh');
                }
            },
            error: function(xhr) {
                toastr.error('Lỗi server: ' + (xhr.responseJSON?.message || 'Không thể lấy dữ liệu'));
            }
        });
    });
});
</script>

<style>
@media print {
    .no-print {
        display: none !important;
    }

    .card-header {
        background-color: #4b545c !important;
        color: #fff !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    .main-header,
    .main-sidebar,
    .main-footer,
    .card-tools,
    .breadcrumb,
    .btn {
        display: none !important;
    }

    .content-wrapper {
        margin-left: 0 !important;
        padding-top: 0 !important;
    }

    .card {
        break-inside: avoid;
    }

    .chart {
        page-break-inside: avoid;
    }
}
</style>
@endsection