@extends('layouts.app')

@section('title', 'Báo Cáo - ' . ($banNganh->ten ?? 'Ban Cơ Đốc Giáo Dục'))

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
        @include('_ban_co_doc_giao_duc.partials._navigation')

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Báo Cáo {{ $banNganh->ten ?? 'Ban Cơ Đốc Giáo Dục' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('_ban_co_doc_giao_duc.bao_cao', ['banType' => 'ban-co-doc-giao-duc']) }}">Báo Cáo</a></li>
                    <li class="breadcrumb-item active">{{ $banNganh->ten ?? 'Ban Cơ Đốc Giáo Dục' }}</li>
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
                <form id="filter-form" method="GET" action="{{ route('_ban_co_doc_giao_duc.bao_cao', ['banType' => 'ban-co-doc-giao-duc']) }}">
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
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Biểu đồ Số lượng Tham dự Theo Tuần</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart">
                                    <canvas id="attendanceChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>                        

                        <!-- Bảng Nhóm TCN - Lớp Trung Lão -->
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-users"></i> Buổi nhóm Trường Chúa Nhật (Lớp Trung Lão)</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Ngày</th>
                                                <th>Số lượng</th>
                                                <th>Đề tài</th>
                                                <th>Kinh Thánh</th>
                                                <th>Dâng hiến (VNĐ)</th>
                                                <th>Diễn giả</th>
                                                <th>Ghi chú</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($buoiNhomBN as $index => $buoiNhom)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y') }}</td>
                                                <td>{{ $buoiNhom->so_luong_trung_lao ?? 0 }}</td>
                                                <td>{{ $buoiNhom->chu_de ?? 'N/A' }}</td>
                                                <td>{{ $buoiNhom->kinh_thanh ?? 'N/A' }}</td>
                                                <td>
                                                    {{ number_format($buoiNhom->giaoDichTaiChinh && $buoiNhom->giaoDichTaiChinh->ban_nganh_id_goi == config('ban_nganh.trung_lao.id', 1) ? $buoiNhom->giaoDichTaiChinh->so_tien : 0, 0, ',', '.') }}
                                                </td>
                                                <td>{{ $buoiNhom->dienGia->ho_ten ?? 'N/A' }}</td>
                                                <td>{{ $buoiNhom->ghi_chu ?? 'N/A' }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Không có dữ liệu</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        @if($buoiNhomBN->count() > 0)
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-right font-weight-bold">Tổng cộng:</td>
                                                <td class="font-weight-bold">{{ number_format($taiChinh['tongThuTrungLao'], 0, ',', '.') }}</td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Bảng Buổi nhóm Trường Chúa Nhật - Lớp Thanh Tráng -->
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-users"></i> Buổi nhóm Trường Chúa Nhật (Lớp Thanh Tráng)</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Ngày</th>
                                                <th>Số lượng</th>
                                                <th>Đề tài</th>
                                                <th>Kinh Thánh</th>
                                                <th>Dâng hiến (VNĐ)</th>
                                                <th>Diễn giả</th>
                                                <th>Ghi chú</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($buoiNhomBN as $index => $buoiNhom)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y') }}</td>
                                                <td>{{ $buoiNhom->so_luong_thanh_trang ?? 0 }}</td>
                                                <td>{{ $buoiNhom->chu_de ?? 'N/A' }}</td>
                                                <td>{{ $buoiNhom->kinh_thanh ?? 'N/A' }}</td>
                                                <td>
                                                    {{ number_format($buoiNhom->giaoDichTaiChinh && $buoiNhom->giaoDichTaiChinh->ban_nganh_id_goi == config('ban_nganh.thanh_trang.id', 2) ? $buoiNhom->giaoDichTaiChinh->so_tien : 0, 0, ',', '.') }}
                                                </td>
                                                <td>{{ $buoiNhom->dienGia->ho_ten ?? 'N/A' }}</td>
                                                <td>{{ $buoiNhom->ghi_chu ?? 'N/A' }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Không có dữ liệu</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        @if($buoiNhomBN->count() > 0)
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-right font-weight-bold">Tổng cộng:</td>
                                                <td class="font-weight-bold">{{ number_format($taiChinh['tongThuThanhTrang'], 0, ',', '.') }}</td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Bảng Buổi nhóm Trường Chúa Nhật - Lớp Thanh Niên -->
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-users"></i> Buổi nhóm Trường Chúa Nhật (Lớp Thanh Niên)</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Ngày</th>
                                                <th>Số lượng</th>
                                                <th>Đề tài</th>
                                                <th>Kinh Thánh</th>
                                                <th>Dâng hiến (VNĐ)</th>
                                                <th>Diễn giả</th>
                                                <th>Ghi chú</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($buoiNhomBN as $index => $buoiNhom)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y') }}</td>
                                                <td>{{ $buoiNhom->so_luong_thanh_nien ?? 0 }}</td>
                                                <td>{{ $buoiNhom->chu_de ?? 'N/A' }}</td>
                                                <td>{{ $buoiNhom->kinh_thanh ?? 'N/A' }}</td>
                                                <td>
                                                    {{ number_format($buoiNhom->giaoDichTaiChinh && $buoiNhom->giaoDichTaiChinh->ban_nganh_id_goi == config('ban_nganh.thanh_nien.id', 3) ? $buoiNhom->giaoDichTaiChinh->so_tien : 0, 0, ',', '.') }}
                                                </td>
                                                <td>{{ $buoiNhom->dienGia->ho_ten ?? 'N/A' }}</td>
                                                <td>{{ $buoiNhom->ghi_chu ?? 'N/A' }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="8" class="text-center">Không có dữ liệu</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        @if($buoiNhomBN->count() > 0)
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-right font-weight-bold">Tổng cộng:</td>
                                                <td class="font-weight-bold">{{ number_format($taiChinh['tongThuThanhNien'], 0, ',', '.') }}</td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                        @endif
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
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="small-box bg-success">
                                            <div class="inner">
                                                <h3>{{ number_format($taiChinh['tongThuTrungLao'], 0, ',', '.') }} VNĐ</h3>
                                                <p>Tổng thu (Trung Lão)</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-arrow-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="small-box bg-success">
                                            <div class="inner">
                                                <h3>{{ number_format($taiChinh['tongThuThanhTrang'], 0, ',', '.') }} VNĐ</h3>
                                                <p>Tổng thu (Thanh Tráng)</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-arrow-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="small-box bg-success">
                                            <div class="inner">
                                                <h3>{{ number_format($taiChinh['tongThuThanhNien'], 0, ',', '.') }} VNĐ</h3>
                                                <p>Tổng thu (Thanh Niên)</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fas fa-arrow-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
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
                                                <th>Lớp</th>
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
                                                <td>
                                                    @if($giaoDich->ban_nganh_id_goi == config('ban_nganh.trung_lao.id', 1))
                                                        Trung Lão
                                                    @elseif($giaoDich->ban_nganh_id_goi == config('ban_nganh.thanh_trang.id', 2))
                                                        Thanh Tráng
                                                    @elseif($giaoDich->ban_nganh_id_goi == config('ban_nganh.thanh_nien.id', 3))
                                                        Thanh Niên
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>{{ number_format($giaoDich->so_tien, 0, ',', '.') }} VNĐ</td>
                                                <td>{{ $giaoDich->mo_ta }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">Không có giao dịch</td>
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
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
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
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
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
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
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

@include('_ban_co_doc_giao_duc.scripts._scripts_bao_cao')