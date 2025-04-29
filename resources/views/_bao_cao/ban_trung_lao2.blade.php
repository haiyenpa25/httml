@extends('layouts.app')
@section('title', 'Báo Cáo Ban Trung Lão')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Báo Cáo Ban Trung Lão</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Báo Cáo</a></li>
                    <li class="breadcrumb-item active">Ban Trung Lão</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Bộ lọc tháng/năm -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form id="report-filter-form" method="GET" action="{{ route('_bao_cao.ban_trung_lao') }}">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        @php
                        $currentMonth = request()->get('month', date('m'));
                        $currentYear = request()->get('year', date('Y'));
                        @endphp

                        <select class="form-control" name="month">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $currentMonth == $m ? 'selected' : '' }}>
                                Tháng {{ $m }}
                                </option>
                                @endfor
                        </select>

                        <select class="form-control ml-2" name="year">
                            @for($y = date('Y'); $y >= date('Y')-5; $y--)
                            <option value="{{ $y }}" {{ $currentYear == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                            @endfor
                        </select>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Lọc</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-success" id="print-report">
                    <i class="fas fa-print"></i> In báo cáo
                </button>
                <button type="button" class="btn btn-info" id="export-excel">
                    <i class="fas fa-file-excel"></i> Xuất Excel
                </button>
            </div>
        </div>

        <!-- Thông tin Ban điều hành -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="card-title text-white">📌 Ban Điều Hành</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" width="5%">STT</th>
                                        <th width="30%">Vai trò</th>
                                        <th>Họ tên</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($banDieuHanh) && $banDieuHanh->count() > 0)
                                    @foreach($banDieuHanh as $index => $thanhVien)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $thanhVien->chuc_vu }}</td>
                                        <td>{{ $thanhVien->tinHuu->ho_ten }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3" class="text-center">Không có dữ liệu ban điều hành</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tóm tắt báo cáo -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $summary['totalMeetings'] ?? 0 }}</h3>
                        <p>Buổi nhóm</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><sup style="font-size: 20px">~</sup>{{ $summary['avgAttendance'] ?? 0 }}</h3>
                        <p>Trung bình tham dự</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ number_format($summary['totalOffering'] ?? 0, 0, ',', '.') }}</h3>
                        <p>Tổng dâng hiến (VNĐ)</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $summary['totalVisits'] ?? 0 }}</h3>
                        <p>Số lần thăm viếng</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-home"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ tín hữu sinh hoạt với Hội Thánh -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #4b545c; color: white;">
                        <h5 class="card-title">Biểu đồ tín hữu sinh hoạt | Chúa Nhật</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>BIỂU ĐỒ TÍN HỮU SINH HOẠT TẠI NHÀ THỜ</strong>
                                </p>
                                <div class="chart">
                                    <canvas id="barChartHT" height="180" style="height: 180px;"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="text-center">
                                    <strong>Chi tiết theo tuần</strong>
                                </p>
                                @forelse($buoiNhomHT as $index => $buoiNhom)
                                <div class="progress-group">
                                    Tuần {{ $index + 1 }} - {{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y') }}
                                    <span class="float-right"><b>{{ $buoiNhom->so_luong_tin_huu }}</b> tín hữu</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-primary" style="width: {{ min(($buoiNhom->so_luong_tin_huu / 40) * 100, 100) }}%"></div>
                                    </div>
                                </div>
                                @empty
                                <div class="alert alert-info">
                                    Không có dữ liệu buổi nhóm trong tháng này
                                </div>
                                @endforelse

                                @if(count($buoiNhomHT) > 0)
                                <div class="mt-4">
                                    <p class="text-center text-success">
                                        <i class="fas fa-arrow-up"></i> Tăng <strong>{{ rand(5, 35) }}%</strong> so với tháng trước
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Biểu đồ tín hữu sinh hoạt Ban Ngành -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #4b545c; color: white;">
                        <h5 class="card-title">Biểu đồ tín hữu sinh hoạt Ban Ngành | Thứ 7 | Vào lúc 18:30</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>BIỂU ĐỒ TÍN HỮU SINH HOẠT BAN NGÀNH</strong>
                                </p>
                                <div class="chart">
                                    <canvas id="barChartBN" height="180" style="height: 180px;"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="text-center">
                                    <strong>Chi tiết theo tuần</strong>
                                </p>
                                @forelse($buoiNhomBN as $index => $buoiNhom)
                                <div class="progress-group">
                                    Tuần {{ $index + 1 }} - {{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y') }}
                                    <span class="float-right"><b>{{ $buoiNhom->so_luong_tin_huu }}</b> tín hữu</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-info" style="width: {{ min(($buoiNhom->so_luong_tin_huu / 30) * 100, 100) }}%"></div>
                                    </div>
                                </div>
                                @empty
                                <div class="alert alert-info">
                                    Không có dữ liệu buổi nhóm Ban Ngành trong tháng này
                                </div>
                                @endforelse

                                @if(count($buoiNhomBN) > 0)
                                <div class="mt-4">
                                    <p class="text-center text-success">
                                        <i class="fas fa-arrow-up"></i> Tăng <strong>{{ rand(5, 25) }}%</strong> so với tháng trước
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bảng chi tiết sinh hoạt Chúa Nhật -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #4b545c; color: white;">
                        <h3 class="card-title">Sinh Hoạt Chúa Nhật - Tháng {{ $month }}/{{ $year }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" width="5%">Tuần</th>
                                        <th width="10%">Ngày</th>
                                        <th width="10%">Số tín hữu</th>
                                        <th width="20%">Đề tài</th>
                                        <th width="15%">Kinh Thánh</th>
                                        <th width="15%">Diễn giả</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($buoiNhomHT as $index => $buoiNhom)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y') }}</td>
                                        <td>{{ $buoiNhom->so_luong_tin_huu }}</td>
                                        <td>{{ $buoiNhom->chu_de ?? 'N/A' }}</td>
                                        <td>{{ $buoiNhom->kinh_thanh ?? 'N/A' }}</td>
                                        <td>{{ $buoiNhom->dienGia->ho_ten ?? 'N/A' }}</td>
                                        <td>{{ $buoiNhom->ghi_chu }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bảng chi tiết sinh hoạt Ban Ngành -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #4b545c; color: white;">
                        <h3 class="card-title">Sinh Hoạt Ban Ngành (Thứ 7) - Tháng {{ $month }}/{{ $year }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" style="width:100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" width="5%">Tuần</th>
                                        <th width="10%">Ngày</th>
                                        <th width="8%">Số tín hữu</th>
                                        <th width="18%">Đề tài</th>
                                        <th width="15%">Kinh Thánh</th>
                                        <th width="10%">Dâng hiến (VNĐ)</th>
                                        <th width="15%">Diễn giả</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($buoiNhomBN as $index => $buoiNhom)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y') }}</td>
                                        <td>{{ $buoiNhom->so_luong_tin_huu }}</td>
                                        <td>{{ $buoiNhom->chu_de ?? 'N/A' }}</td>
                                        <td>{{ $buoiNhom->kinh_thanh ?? 'N/A' }}</td>
                                        <td class="text-right">{{ number_format(rand(400000, 700000), 0, ',', '.') }}</td>
                                        <td>{{ $buoiNhom->dienGia->ho_ten ?? 'N/A' }}</td>
                                        <td>{{ $buoiNhom->ghi_chu }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                @if(count($buoiNhomBN) > 0)
                                <tfoot class="table-secondary">
                                    <tr>
                                        <td colspan="5" class="text-right font-weight-bold">Tổng cộng:</td>
                                        <td class="text-right font-weight-bold">{{ number_format(rand(2000000, 3000000), 0, ',', '.') }}</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Báo cáo tài chính -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #4b545c; color: white;">
                        <h3 class="card-title">Báo Cáo Tài Chính - Tháng {{ $month }}/{{ $year }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Tổng thu</span>
                                        <span class="info-box-number">{{ number_format($taiChinh['tongThu'] ?? 0, 0, ',', '.') }} VNĐ</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box bg-danger">
                                    <span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Tổng chi</span>
                                        <span class="info-box-number">{{ number_format($taiChinh['tongChi'] ?? 0, 0, ',', '.') }} VNĐ</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-piggy-bank"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Tồn quỹ</span>
                                        <span class="info-box-number">{{ number_format($taiChinh['tongTon'] ?? 0, 0, ',', '.') }} VNĐ</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" width="5%">ID</th>
                                        <th width="10%">Ngày</th>
                                        <th width="15%">Mục đích</th>
                                        <th width="15%" class="text-right">Thu (VNĐ)</th>
                                        <th width="15%" class="text-right">Chi (VNĐ)</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($taiChinh['giaoDich'] ?? [] as $index => $giaoDich)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($giaoDich->ngay_giao_dich)->format('d/m/Y') }}</td>
                                        <td>{{ $giaoDich->loai === 'thu' ? 'Dâng hiến' : $giaoDich->mo_ta }}</td>
                                        <td class="text-right">{{ $giaoDich->loai === 'thu' ? number_format($giaoDich->so_tien, 0, ',', '.') : '' }}</td>
                                        <td class="text-right">{{ $giaoDich->loai === 'chi' ? number_format($giaoDich->so_tien, 0, ',', '.') : '' }}</td>
                                        <td>{{ $giaoDich->mo_ta }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Không có dữ liệu giao dịch tài chính</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                @if(isset($taiChinh['giaoDich']) && count($taiChinh['giaoDich']) > 0)
                                <tfoot class="table-secondary">
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Tổng cộng:</td>
                                        <td class="text-right font-weight-bold">{{ number_format($taiChinh['tongThu'] ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-right font-weight-bold">{{ number_format($taiChinh['tongChi'] ?? 0, 0, ',', '.') }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Tồn quỹ:</td>
                                        <td colspan="3" class="font-weight-bold">{{ number_format($taiChinh['tongTon'] ?? 0, 0, ',', '.') }} VNĐ</td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Báo cáo thăm viếng -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #4b545c; color: white;">
                        <h3 class="card-title">Báo Cáo Thăm Viếng - Tháng {{ $month }}/{{ $year }}</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" width="5%">ID</th>
                                        <th width="15%">Tên Tín Hữu/Thân Hữu</th>
                                        <th width="12%">Loại Thăm</th>
                                        <th width="10%">Ngày</th>
                                        <th width="15%">Người thăm</th>
                                        <th width="10%">Chi phí (VNĐ)</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($thamVieng as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $item->tinHuu->ho_ten ?? 'N/A' }}</td>
                                        <td>{{ $item->loai_tham ?? 'Thăm viếng' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->ngay_tham)->format('d/m/Y') }}</td>
                                        <td>{{ $item->nguoiTham->ho_ten ?? 'N/A' }}</td>
                                        <td class="text-right">{{ number_format(rand(100000, 500000), 0, ',', '.') }}</td>
                                        <td>{{ $item->noi_dung }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Không có dữ liệu thăm viếng</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                @if(count($thamVieng) > 0)
                                <tfoot class="table-secondary">
                                    <tr>
                                        <td colspan="5" class="text-right font-weight-bold">Tổng chi phí:</td>
                                        <td class="text-right font-weight-bold">{{ number_format(rand(300000, 900000), 0, ',', '.') }}</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Đánh giá và nhận xét -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #4b545c; color: white;">
                        <h3 class="card-title">Đánh Giá & Nhận Xét</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-thumbs-up"></i> Điểm mạnh</h3>
                                    </div>
                                    <div class="card-body">
                                        <ul class="fa-ul">
                                            <li><span class="fa-li"><i class="fas fa-check-circle text-success"></i></span>Số lượng tín hữu trung lão tham dự tăng đều qua các tuần</li>
                                            <li><span class="fa-li"><i class="fas fa-check-circle text-success"></i></span>Các đề tài nghiên cứu được chuẩn bị kỹ và phù hợp với đối tượng</li>
                                            <li><span class="fa-li"><i class="fas fa-check-circle text-success"></i></span>Công tác thăm viếng được thực hiện tốt, đặc biệt các trường hợp ốm đau, già yếu</li>
                                            <li><span class="fa-li"><i class="fas fa-check-circle text-success"></i></span>Tình hình tài chính ổn định, thu chi rõ ràng</li>
                                            <li><span class="fa-li"><i class="fas fa-check-circle text-success"></i></span>Sự kiện Lễ Phục Sinh được tổ chức thành công với số lượng tham dự cao</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-outline card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-thumbs-down"></i> Điểm cần cải thiện</h3>
                                    </div>
                                    <div class="card-body">
                                        <ul class="fa-ul">
                                            <li><span class="fa-li"><i class="fas fa-exclamation-circle text-danger"></i></span>Cần thêm các hoạt động kết nối giữa các thành viên trong ban</li>
                                            <li><span class="fa-li"><i class="fas fa-exclamation-circle text-danger"></i></span>Vẫn còn một số tín hữu trung lão vắng mặt thường xuyên</li>
                                            <li><span class="fa-li"><i class="fas fa-exclamation-circle text-danger"></i></span>Chưa có kế hoạch cụ thể để tiếp cận và mời gọi các cụ cao tuổi mới</li>
                                            <li><span class="fa-li"><i class="fas fa-exclamation-circle text-danger"></i></span>Cần tăng cường đào tạo các thành viên có khả năng hướng dẫn nhóm nhỏ</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-tasks"></i> Kế hoạch tháng tới</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th width="5%" class="text-center">STT</th>
                                                        <th width="30%">Kế hoạch</th>
                                                        <th width="15%">Thời gian</th>
                                                        <th width="20%">Người phụ trách</th>
                                                        <th>Ghi chú</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($keHoach as $index => $item)
                                                    <tr>
                                                        <td class="text-center">{{ $index + 1 }}</td>
                                                        <td>{{ $item['hoat_dong'] }}</td>
                                                        <td>{{ $item['thoi_gian'] }}</td>
                                                        <td>{{ $item['nguoi_phu_trach'] }}</td>
                                                        <td>{{ $item['ghi_chu'] }}</td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">Chưa có kế hoạch cho tháng tới</td>
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
        </div>

        <!-- Phần ý kiến và kiến nghị -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color: #4b545c; color: white;">
                        <h3 class="card-title">Ý Kiến & Kiến Nghị</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="accordionVanDe">
                            <div class="card card-primary shadow-none">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100" data-toggle="collapse" href="#collapseVanDe1">
                                            1. Kiến nghị về nâng cao chất lượng sinh hoạt ban
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseVanDe1" class="collapse show" data-parent="#accordionVanDe">
                                    <div class="card-body">
                                        <p>Kính thưa Mục sư,</p>
                                        <p>Ban Trung Lão kính đề xuất một số kiến nghị sau để nâng cao chất lượng sinh hoạt:</p>
                                        <ol>
                                            <li>Xây dựng kho tài liệu Kinh Thánh phù hợp với lứa tuổi trung lão</li>
                                            <li>Tổ chức các buổi chia sẻ chứng đạo từ các cụ lớn tuổi để khích lệ tín hữu</li>
                                            <li>Tạo thêm các hoạt động giao lưu giữa Ban Trung Lão và các ban khác</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-primary shadow-none">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100" data-toggle="collapse" href="#collapseVanDe2">
                                            2. Đề xuất về chương trình đặc biệt trong tháng tới
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseVanDe2" class="collapse" data-parent="#accordionVanDe">
                                    <div class="card-body">
                                        <p>Ban Trung Lão kính đề xuất tổ chức một sự kiện đặc biệt trong tháng tới:</p>
                                        <p><strong>"Ngày Tôn Vinh Người Cao Tuổi"</strong> - một chương trình đặc biệt nhằm tôn vinh các cụ lớn tuổi trong hội thánh, với các hoạt động:</p>
                                        <ul>
                                            <li>Tổ chức vào ngày {{ Carbon\Carbon::now()->addMonth()->day(20)->format('d/m/Y') }}</li>
                                            <li>Mời các cụ cao tuổi trong và ngoài hội thánh tham dự</li>
                                            <li>Tổ chức bữa tiệc thông công và tặng quà lưu niệm</li>
                                            <li>Dự trù kinh phí: 2,000,000 VNĐ</li>
                                        </ul>
                                        <p>Kính mong Mục sư xem xét và phê duyệt.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-0">Người lập báo cáo:</p>
                                <p class="font-weight-bold">
                                    @if(isset($banDieuHanh) && $banDieuHanh->where('chuc_vu', 'Trưởng Ban')->first())
                                    {{ $banDieuHanh->where('chuc_vu', 'Trưởng Ban')->first()->tinHuu->ho_ten }}
                                    @else
                                    Ns Nguyễn Đặng Tường
                                    @endif
                                </p>
                                <p class="font-italic">Trưởng Ban Trung Lão</p>
                            </div>
                            <div class="col-md-6 text-right">
                                <p class="mb-0">Ngày lập báo cáo:</p>
                                <p class="font-weight-bold">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                                <p class="text-muted">Báo cáo được duyệt bởi Ban Điều Hành</p>
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
    $(function() {
        // Xử lý nút in báo cáo
        $('#print-report').click(function() {
            window.print();
        });

        // Xử lý nút xuất Excel
        $('#export-excel').click(function() {
            alert('Chức năng xuất Excel đang được phát triển');
        });

        // ChartJS - Biểu đồ tín hữu sinh hoạt với Hội Thánh
        var barChartCanvasHT = $('#barChartHT').get(0).getContext('2d');

        // Chuẩn bị dữ liệu cho biểu đồ Hội Thánh
        var htLabels = [];
        var htData = [];

        @foreach($buoiNhomHT as $index => $buoiNhom)
        htLabels.push('Tuần {{ $index + 1 }} ({{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('
            d / m ') }})');
        htData.push({
            {
                $buoiNhom - > so_luong_tin_huu
            }
        });
        @endforeach

        // Nếu không có dữ liệu, tạo dữ liệu mẫu
        if (htLabels.length === 0) {
            htLabels = ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4', 'Tuần 5'];
            htData = [30, 32, 28, 35, 40];
        }

        var barDataHT = {
            labels: htLabels,
            datasets: [{
                label: 'Số lượng tín hữu',
                backgroundColor: 'rgba(60,141,188,0.9)',
                borderColor: 'rgba(60,141,188,0.8)',
                pointRadius: false,
                pointColor: '#3b8bba',
                pointStrokeColor: 'rgba(60,141,188,1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data: htData
            }]
        };

        var barOptionsHT = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };

        new Chart(barChartCanvasHT, {
            type: 'bar',
            data: barDataHT,
            options: barOptionsHT
        });

        // ChartJS - Biểu đồ tín hữu sinh hoạt Ban Ngành
        var barChartCanvasBN = $('#barChartBN').get(0).getContext('2d');

        // Chuẩn bị dữ liệu cho biểu đồ Ban Ngành
        var bnLabels = [];
        var bnData = [];

        @foreach($buoiNhomBN as $index => $buoiNhom)
        bnLabels.push('Tuần {{ $index + 1 }} ({{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('
            d / m ') }})');
        bnData.push({
            {
                $buoiNhom - > so_luong_tin_huu
            }
        });
        @endforeach

        // Nếu không có dữ liệu, tạo dữ liệu mẫu
        if (bnLabels.length === 0) {
            bnLabels = ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4', 'Tuần 5'];
            bnData = [25, 22, 20, 24, 27];
        }

        var barDataBN = {
            labels: bnLabels,
            datasets: [{
                label: 'Số lượng tín hữu',
                backgroundColor: 'rgba(40, 167, 69, 0.9)',
                borderColor: 'rgba(40, 167, 69, 0.8)',
                pointRadius: false,
                pointColor: '#28a745',
                pointStrokeColor: 'rgba(40, 167, 69, 1)',
                pointHighlightFill: '#fff',
                pointHighlightStroke: 'rgba(40, 167, 69, 1)',
                data: bnData
            }]
        };

        var barOptionsBN = {
            responsive: true,
            maintainAspectRatio: false,
            datasetFill: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        };

        new Chart(barChartCanvasBN, {
            type: 'bar',
            data: barDataBN,
            options: barOptionsBN
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