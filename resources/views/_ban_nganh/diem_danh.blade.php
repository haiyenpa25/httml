@extends('layouts.app')

@section('title', 'Điểm Danh - ' . ($banNganh->ten ?? 'Ban Ngành'))

@section('content')
    <section class="content">
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

            <!-- Filter Form -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter"></i>
                        Lọc dữ liệu
                    </h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('_ban_nganh.trung_lao.diem_danh') }}" method="GET" id="filter-form">
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
                                <a href="{{ route('_ban_nganh.trung_lao.diem_danh') }}" class="btn btn-default">
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
                        <form id="attendance-form" action="{{ route('api.ban_nganh.trung_lao.luu_diem_danh') }}" method="POST">
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
                                    <li><i class="far fa-circle text-warning"></i> Vắng có phép: {{ $stats['vang_co_phep'] }}
                                        người</li>
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
        </div>
    </section>

    <!-- Modal Thêm Buổi Nhóm -->
    <div class="modal fade" id="modal-them-buoi-nhom">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm Buổi Nhóm Mới</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('api.ban_nganh.trung_lao.them_buoi_nhom') }}" method="POST" id="add-buoi-nhom-form">
                    @csrf
                    <input type="hidden" name="ban_nganh_id" value="{{ $banNganh->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Ngày tổ chức <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="ngay_dien_ra" required>
                        </div>

                        <div class="form-group">
                            <label>Chủ đề <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="chu_de" placeholder="Nhập chủ đề buổi nhóm"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Diễn giả</label>
                            <select class="form-control select2bs4" name="dien_gia_id">
                                <option value="">-- Chọn Diễn Giả --</option>
                                @foreach($dienGias as $dienGia)
                                    <option value="{{ $dienGia->id }}">
                                        {{ $dienGia->ho_ten }} - {{ $dienGia->chuc_danh }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Địa điểm <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="dia_diem" placeholder="Nhập địa điểm" required>
                        </div>

                        <div class="form-group">
                            <label>Giờ bắt đầu <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" name="gio_bat_dau" required>
                        </div>

                        <div class="form-group">
                            <label>Giờ kết thúc <span class="text-danger">*</span></label>
                            <input type="time" class="form-control" name="gio_ket_thuc" required>
                        </div>

                        <div class="form-group">
                            <label>Ghi chú</label>
                            <textarea class="form-control" name="ghi_chu" rows="3"
                                placeholder="Nhập ghi chú (nếu có)"></textarea>
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
@endsection

@include('_ban_nganh.scripts._scripts_diem_danh')