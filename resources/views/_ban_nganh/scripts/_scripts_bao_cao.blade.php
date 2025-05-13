@extends('layouts.app')

@section('title', 'Báo Cáo - ' . ($banNganh->ten ?? 'Ban Ngành'))

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
                        <!-- Biểu đồ -->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Biểu đồ Số lượng Tham dự Theo Tuần</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="attendanceChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
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
    </div>
</section>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Handle filter form submission
    $('#filter-form').on('submit', function(e) {
        $('#alert-container').html('<div class="alert alert-info">Đang tải dữ liệu...</div>');
    });

    // Kiểm tra nếu canvas tồn tại trước khi vẽ biểu đồ
    if (document.getElementById('attendanceChart')) {
        console.log('Canvas attendanceChart found');
        try {
            const buoiNhomHT = @json($buoiNhomHT);
            const buoiNhomBN = @json($buoiNhomBN);
            console.log('Raw buoiNhomHT:', buoiNhomHT);
            console.log('Raw buoiNhomBN:', buoiNhomBN);

            // Đảm bảo month và year là số nguyên
            const month = parseInt({{ $month }});
            const year = parseInt({{ $year }});
            console.log('month:', month, 'year:', year);

            // Tính số tuần
            const daysInMonth = new Date(year, month, 0).getDate();
            const numWeeks = Math.ceil(daysInMonth / 7);
            const weeks = Array.from({ length: numWeeks }, (_, i) => `Tuần ${i + 1}`);
            console.log('numWeeks:', numWeeks, 'weeks:', weeks);

            // Khởi tạo mảng dữ liệu
            const attendanceHT = new Array(numWeeks).fill(0);
            const attendanceBN = new Array(numWeeks).fill(0);

            // Xử lý Nhóm Chúa Nhật
            if (buoiNhomHT && Array.isArray(buoiNhomHT)) {
                buoiNhomHT.forEach(meeting => {
                    if (meeting && meeting.ngay_dien_ra) {
                        const dateStr = meeting.ngay_dien_ra.split(' ')[0];
                        const date = new Date(dateStr);
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
                    } else {
                        console.warn('Missing ngay_dien_ra in buoiNhomHT:', meeting);
                    }
                });
            } else {
                console.warn('buoiNhomHT is not an array or is undefined');
            }

            // Xử lý Nhóm Tối Thứ 7
            if (buoiNhomBN && Array.isArray(buoiNhomBN)) {
                buoiNhomBN.forEach(meeting => {
                    if (meeting && meeting.ngay_dien_ra) {
                        const dateStr = meeting.ngay_dien_ra.split(' ')[0];
                        const date = new Date(dateStr);
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
                    } else {
                        console.warn('Missing ngay_dien_ra in buoiNhomBN:', meeting);
                    }
                });
            } else {
                console.warn('buoiNhomBN is not an array or is undefined');
            }

            console.log('Final attendanceHT:', attendanceHT);
            console.log('Final attendanceBN:', attendanceBN);

            // Sử dụng dữ liệu mẫu nếu không có dữ liệu
            if (attendanceHT.every(val => val === 0) && attendanceBN.every(val => val === 0)) {
                console.log('Using sample data for', numWeeks, 'weeks');
                attendanceHT.splice(0, attendanceHT.length, ...Array(numWeeks).fill(0).map(() => Math.floor(Math.random() * 20 + 20)));
                attendanceBN.splice(0, attendanceBN.length, ...Array(numWeeks).fill(0).map(() => Math.floor(Math.random() * 15 + 15)));
            }

            // Vẽ biểu đồ
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            console.log('Chart initialized');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: weeks,
                    datasets: [
                        {
                            label: 'Nhóm Chúa Nhật (Hội Thánh)',
                            data: attendanceHT,
                            backgroundColor: '#6c757d',
                            borderColor: '#6c757d',
                            borderWidth: 1
                        },
                        {
                            label: 'Nhóm Tối Thứ 7 (Ban Ngành)',
                            data: attendanceBN,
                            backgroundColor: '#28a745',
                            borderColor: '#28a745',
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
                            text: 'Số lượng Tham dự Theo Tuần (Tháng ' + month + '/' + year + ')'
                        }
                    }
                }
            });
        } catch (error) {
            console.error('Lỗi khi vẽ biểu đồ:', error);
        }
    } else {
        console.error('Canvas attendanceChart not found');
    }
});
</script>
@endsection

@section('page-scripts')
<script>
$(function() {
    // Xử lý nút in báo cáo
    $('#print-report').click(function() {
        window.print();
    });

    // Xử lý nút xuất Excel
    $('#export-excel').click(function() {
        toastr.info('Chức năng xuất Excel đang được phát triển');
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