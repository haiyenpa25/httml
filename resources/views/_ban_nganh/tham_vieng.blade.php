@extends('layouts.app')

@section('title', 'Thăm Viếng - ' . ($banNganh->ten ?? 'Ban Ngành'))

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Thông báo thành công hoặc lỗi -->
            <div id="alert-container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check-circle"></i> Thành công!</h5>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Lỗi!</h5>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <!-- Thẻ thông tin tổng quan -->
            <div class="dashboard-overview mb-4">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="info-box bg-gradient-info">
                            <span class="info-box-icon"><i class="fas fa-users-medical"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Tổng số lần thăm</span>
                                <span class="info-box-number">{{ $thongKe['total_visits'] }}</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                                <span class="progress-description">
                                    Tính đến {{ date('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="info-box bg-gradient-success">
                            <span class="info-box-icon"><i class="fas fa-calendar-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Trong tháng này</span>
                                <span class="info-box-number">{{ $thongKe['this_month'] }}</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ ($thongKe['total_visits'] > 0) ? ($thongKe['this_month']/$thongKe['total_visits'])*100 : 0 }}%"></div>
                                </div>
                                <span class="progress-description">
                                    Tháng {{ date('m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="info-box bg-gradient-warning">
                            <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Cần thăm viếng</span>
                                <span class="info-box-number">{{ $deXuatThamVieng->total() }}</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                                <span class="progress-description">
                                    Lâu hơn 60 ngày
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="info-box bg-gradient-primary">
                            <span class="info-box-icon"><i class="fas fa-map-marked-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Bản đồ khu vực</span>
                                <span class="info-box-number">Chỉ đường</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                </div>
                                <span class="progress-description">
                                    <a href="#map-section" class="text-white">Xem bản đồ <i class="fas fa-arrow-down"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thanh điều hướng nhanh -->
            @include('_ban_nganh.partials._ban_nganh_navigation')

            <div class="row">
                <!-- Cột trái: Danh sách đề xuất thăm viếng -->
                <div class="col-md-6">
                    <div class="card card-primary card-outline shadow-sm">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-hand-holding-heart text-primary mr-2"></i>
                                Đề xuất thăm viếng
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white">
                                            <i class="fas fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <select class="form-control" id="filter-time">
                                        <option value="30">Lâu hơn 30 ngày</option>
                                        <option value="60" selected>Lâu hơn 60 ngày</option>
                                        <option value="90">Lâu hơn 90 ngày</option>
                                        <option value="180">Lâu hơn 6 tháng</option>
                                        <option value="365">Lâu hơn 1 năm</option>
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-striped" id="table-de-xuat">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Họ tên</th>
                                            <th>Số điện thoại</th>
                                            <th>Lần thăm cuối</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="de-xuat-table-body">
                                        @forelse($deXuatThamVieng as $tinHuu)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-circle bg-primary">
                                                            <span>{{ substr($tinHuu->ho_ten, 0, 1) }}</span>
                                                        </div>
                                                        <div class="ml-2">
                                                            {{ $tinHuu->ho_ten }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="tel:{{ $tinHuu->so_dien_thoai }}" class="text-decoration-none">
                                                        <i class="fas fa-phone-alt text-success mr-1"></i>
                                                        {{ $tinHuu->so_dien_thoai }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if($tinHuu->ngay_tham_vieng_gan_nhat)
                                                        <div class="d-flex align-items-center">
                                                            <i class="far fa-calendar-alt mr-1 text-muted"></i>
                                                            <span>{{ Carbon\Carbon::parse($tinHuu->ngay_tham_vieng_gan_nhat)->format('d/m/Y') }}</span>
                                                        </div>
                                                        <span class="badge badge-{{ $tinHuu->so_ngay_chua_tham > 90 ? 'danger' : ($tinHuu->so_ngay_chua_tham > 60 ? 'warning' : 'info') }} mt-1">
                                                            {{ $tinHuu->so_ngay_chua_tham }} ngày trước
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                                            Chưa thăm bao giờ
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-primary btn-them-tham-vieng"
                                                            data-id="{{ $tinHuu->id }}" data-ten="{{ $tinHuu->ho_ten }}"
                                                            data-toggle="modal" data-target="#modal-them-tham-vieng">
                                                            <i class="fas fa-plus"></i> Thăm
                                                        </button>
                                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $tinHuu->vi_do ?? '' }},{{ $tinHuu->kinh_do ?? '' }}"
                                                            class="btn btn-sm btn-success {{ (!$tinHuu->vi_do || !$tinHuu->kinh_do) ? 'disabled' : '' }}"
                                                            target="_blank">
                                                            <i class="fas fa-directions"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <div class="empty-state">
                                                        <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                                                        <p class="text-muted">Không có tín hữu nào cần thăm viếng</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="mt-3 d-flex justify-content-center">
                                    <nav aria-label="Page navigation">
                                        {{ $deXuatThamVieng->links('vendor.pagination.bootstrap-4') }}
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bản đồ tọa độ các tín hữu -->
                    <div class="card card-success card-outline shadow-sm" id="map-section">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-map-marked-alt text-success mr-2"></i>
                                Bản đồ vị trí
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div id="map" style="height: 400px; width: 100%;"></div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Nhấp vào điểm đánh dấu để xem thông tin</small>
                                <button class="btn btn-sm btn-outline-success" id="btn-locate-me">
                                    <i class="fas fa-location-arrow mr-1"></i> Vị trí của tôi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cột phải: Lịch sử thăm viếng và thống kê -->
                <div class="col-md-6">
                    <div class="card card-info card-outline shadow-sm">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-history text-info mr-2"></i>
                                Lịch sử thăm viếng
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="date-range-filter mb-3">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group mb-0">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-info text-white">
                                                        <i class="fas fa-calendar-day"></i>
                                                    </span>
                                                </div>
                                                <input type="date" class="form-control date-picker" id="date-from"
                                                    value="{{ date('Y-m-d', strtotime('-30 days')) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-center pt-2">
                                        <i class="fas fa-arrow-right text-muted"></i>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group mb-0">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-info text-white">
                                                        <i class="fas fa-calendar-day"></i>
                                                    </span>
                                                </div>
                                                <input type="date" class="form-control date-picker" id="date-to"
                                                    value="{{ date('Y-m-d') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <button id="btn-filter-history" class="btn btn-info">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="date-shortcuts mt-2">
                                    <button class="btn btn-xs btn-outline-info date-preset" data-days="30">1 tháng</button>
                                    <button class="btn btn-xs btn-outline-info date-preset" data-days="90">3 tháng</button>
                                    <button class="btn btn-xs btn-outline-info date-preset" data-days="270">9 tháng</button>
                                    <button class="btn btn-xs btn-outline-info date-preset" data-days="365">1 năm</button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover" id="table-lich-su">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Ngày thăm</th>
                                            <th>Tín hữu</th>
                                            <th>Người thăm</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lich-su-table-body">
                                        @forelse($lichSuThamVieng as $thamVieng)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="event-date-badge">
                                                            <div class="event-date-month">{{ Carbon\Carbon::parse($thamVieng->ngay_tham)->format('M') }}</div>
                                                            <div class="event-date-day">{{ Carbon\Carbon::parse($thamVieng->ngay_tham)->format('d') }}</div>
                                                        </div>
                                                        <div class="ml-2">
                                                            {{ Carbon\Carbon::parse($thamVieng->ngay_tham)->format('d/m/Y') }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $thamVieng->tinHuu->ho_ten ?? 'N/A' }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="visitor-icon">
                                                            <i class="fas fa-user-circle"></i>
                                                        </span>
                                                        <span>{{ $thamVieng->nguoiTham->ho_ten ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info btn-xem-chi-tiet"
                                                        data-id="{{ $thamVieng->id }}" data-toggle="modal"
                                                        data-target="#modal-chi-tiet-tham-vieng">
                                                        <i class="fas fa-eye"></i> Chi tiết
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <div class="empty-state">
                                                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                                        <p class="text-muted">Không có lịch sử thăm viếng trong khoảng thời gian này</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="text-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-them-tham-vieng">
                                    <i class="fas fa-plus mr-1"></i> Thêm thăm viếng mới
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Thống kê thăm viếng -->
                    <div class="card card-warning card-outline shadow-sm">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar text-warning mr-2"></i>
                                Thống kê thăm viếng
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body pb-0">
                            <div class="chart-container">
                                <canvas id="visitChart" height="200"></canvas>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <div class="text-warning">
                                        <i class="far fa-calendar-check fa-2x"></i>
                                    </div>
                                    <div class="text-muted">Tháng này</div>
                                    <h5>{{ $thongKe['this_month'] }}</h5>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="text-info">
                                        <i class="far fa-calendar-alt fa-2x"></i>
                                    </div>
                                    <div class="text-muted">Tháng trước</div>
                                    <h5>{{ $thongKe['last_month'] ?? 0 }}</h5>
                                </div>
                                <div class="col-4 text-center">
                                    <div class="text-success">
                                        <i class="fas fa-chart-line fa-2x"></i>
                                    </div>
                                    <div class="text-muted">Tỉ lệ tăng</div>
                                    <h5 class="{{ ($thongKe['last_month'] ?? 0) > 0 ? (($thongKe['this_month'] > ($thongKe['last_month'] ?? 0)) ? 'text-success' : 'text-danger') : '' }}">
                                        @if(($thongKe['last_month'] ?? 0) > 0)
                                            {{ round((($thongKe['this_month'] - ($thongKe['last_month'] ?? 0)) / ($thongKe['last_month'] ?? 1)) * 100) }}%
                                            <i class="fas {{ ($thongKe['this_month'] > ($thongKe['last_month'] ?? 0)) ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                                        @else
                                            --
                                        @endif
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Thêm Thăm Viếng -->
    <div class="modal fade" id="modal-them-tham-vieng">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title">
                        <i class="fas fa-hand-holding-heart mr-2"></i>
                        Thêm lần thăm viếng
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('api.ban_nganh.' . $banType . '.them_tham_vieng') }}" method="POST" id="form-them-tham-vieng">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Tín hữu được thăm -->
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-user text-primary mr-1"></i>
                                        Tín hữu <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control select2bs4" name="tin_huu_id" id="tin_huu_id" required>
                                        <option value="">-- Chọn tín hữu --</option>
                                        @foreach($danhSachTinHuu as $tinHuu)
                                            <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Người đi thăm -->
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-user-friends text-primary mr-1"></i>
                                        Người thăm <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control select2bs4" name="nguoi_tham_id" required>
                                        <option value="">-- Chọn người thăm --</option>
                                        @foreach($thanhVienBan as $thanhVien)
                                            <option value="{{ $thanhVien->tinHuu->id }}">{{ $thanhVien->tinHuu->ho_ten }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Ngày thăm -->
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-calendar-alt text-primary mr-1"></i>
                                        Ngày thăm <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="date" class="form-control date-picker" name="ngay_tham" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>

                                <!-- Trạng thái -->
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-tag text-primary mr-1"></i>
                                        Trạng thái
                                    </label>
                                    <div class="d-flex">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="trang-thai-da-tham" name="trang_thai" value="da_tham" class="custom-control-input" checked>
                                            <label class="custom-control-label" for="trang-thai-da-tham">Đã thăm</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="trang-thai-ke-hoach" name="trang_thai" value="ke_hoach" class="custom-control-input">
                                            <label class="custom-control-label" for="trang-thai-ke-hoach">Kế hoạch</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Nội dung thăm viếng -->
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-file-alt text-primary mr-1"></i>
                                        Nội dung <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" name="noi_dung" rows="5" placeholder="Nhập nội dung thăm viếng" required></textarea>
                                </div>

                                <!-- Kết quả -->
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-clipboard-check text-primary mr-1"></i>
                                        Kết quả
                                    </label>
                                    <textarea class="form-control" name="ket_qua" rows="3" placeholder="Nhập kết quả thăm viếng"></textarea>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="id_ban" value="{{ $banNganh->id }}">
                    </div>
                    <div class="modal-footer justify-content-between bg-light">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i> Đóng
                        </button>
                        <button type="submit" class="btn btn-primary" id="btn-save-tham-vieng">
                            <i class="fas fa-save mr-1"></i> Lưu thông tin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Chi Tiết Thăm Viếng -->
    <div class="modal fade" id="modal-chi-tiet-tham-vieng">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h4 class="modal-title">
                        <i class="fas fa-info-circle mr-2"></i>
                        Chi tiết thăm viếng
                    </h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="loading-container text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Đang tải dữ liệu...</p>
                    </div>

                    <div id="chi-tiet-content" class="visit-detail-content" style="display: none;">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="visit-info-card">
                                    <div class="visit-info-icon bg-primary">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="visit-info-content">
                                        <h6 class="text-muted font-weight-light">Tín hữu</h6>
                                        <h5 class="font-weight-bold" id="detail-tin-huu">-</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="visit-info-card">
                                    <div class="visit-info-icon bg-success">
                                        <i class="fas fa-user-friends"></i>
                                    </div>
                                    <div class="visit-info-content">
                                        <h6 class="text-muted font-weight-light">Người thăm</h6>
                                        <h5 class="font-weight-bold" id="detail-nguoi-tham">-</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="visit-info-card">
                                    <div class="visit-info-icon bg-warning">
                                        <i class="fas fa-calendar-day"></i>
                                    </div>
                                    <div class="visit-info-content">
                                        <h6 class="text-muted font-weight-light">Ngày thăm</h6>
                                        <h5 class="font-weight-bold" id="detail-ngay-tham">-</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="visit-info-card">
                                    <div class="visit-info-icon bg-info">
                                        <i class="fas fa-clipboard-list"></i>
                                    </div>
                                    <div class="visit-info-content">
                                        <h6 class="text-muted font-weight-light">Trạng thái</h6>
                                        <div id="detail-trang-thai">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light mb-3">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-file-alt text-primary mr-2"></i>
                                    Nội dung thăm viếng
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="content-box" id="detail-noi-dung">-</div>
                            </div>
                        </div>

                        <div class="card bg-light">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">
                                    <i class="fas fa-clipboard-check text-success mr-2"></i>
                                    Kết quả thăm viếng
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="content-box" id="detail-ket-qua">-</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Đóng
                    </button>
                    <button type="button" class="btn btn-info" id="btn-print-detail">
                        <i class="fas fa-print mr-1"></i> In thông tin
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <style>
        /* Thẻ thông tin tổng quan */
        .info-box {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            border-radius: 0.5rem;
            background-color: #fff;
            display: flex;
            margin-bottom: 1rem;
            min-height: 80px;
            padding: .5rem;
            position: relative;
            width: 100%;
            transition: all 0.3s ease;
        }

        .info-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,.15);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #17a2b8 0%, #0097a7 100%) !important;
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%) !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%) !important;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        }

        .info-box-icon {
            border-radius: 0.25rem;
            display: flex;
            font-size: 1.875rem;
            justify-content: center;
            align-items: center;
            text-align: center;
            width: 70px;
            color: #fff;
        }

        .info-box-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            line-height: 1.8;
            flex: 1;
            padding: 0 10px;
            color: #fff;
        }

        .info-box-number {
            display: block;
            margin-top: .25rem;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .info-box .progress {
            background-color: rgba(255, 255, 255, 0.3);
            height: 4px;
            margin: 5px 0;
        }

        .info-box .progress-bar {
            background-color: #fff;
        }

        .progress-description {
            display: block;
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.75rem;
        }

        /* Danh sách đề xuất thăm viếng */
        .card {
            border: none;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .card-outline {
            border-top: 3px solid;
        }

        .card-primary.card-outline {
            border-top-color: #007bff;
        }

        .card-success.card-outline {
            border-top-color: #28a745;
        }

        .card-info.card-outline {
            border-top-color: #17a2b8;
        }

        .card-warning.card-outline {
            border-top-color: #ffc107;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }

        .card-title {
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Avatar circle cho danh sách tín hữu */
        .avatar-circle {
            width: 36px;
            height: 36px;
            background-color: #007bff;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
        }

        /* Trạng thái trống */
        .empty-state {
            padding: 1.5rem;
            text-align: center;
            color: #6c757d;
        }

        /* Bảng thăm viếng */
        .table thead th {
            border-top: none;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.02);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,.05);
        }

        /* Calendar date badge cho lịch sử thăm viếng */
        .event-date-badge {
            width: 40px;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,.1);
            text-align: center;
        }

        .event-date-month {
            background-color: #007bff;
            color: white;
            font-size: 10px;
            text-transform: uppercase;
            padding: 2px 0;
        }

        .event-date-day {
            background-color: white;
            color: #343a40;
            font-size: 16px;
            font-weight: bold;
            padding: 2px 0;
        }

        .visitor-icon {
            color: #28a745;
            font-size: 18px;
            margin-right: 8px;
        }

        /* Date range shortcuts */
        .date-shortcuts {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .date-preset {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        /* Chart container */
        .chart-container {
            position: relative;
            margin: auto;
            height: 250px;
        }

        /* Modal styles */
        .modal-header {
            border-radius: 0.3rem 0.3rem 0 0;
        }

        .modal-content {
            border: none;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        /* Visit detail styles */
        .visit-detail-content {
            padding: 1rem;
        }

        .visit-info-card {
            display: flex;
            align-items: center;
            padding: 1rem;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            height: 100%;
        }

        .visit-info-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            margin-right: 1rem;
        }

        .visit-info-content {
            flex: 1;
        }

        .content-box {
            background-color: white;
            border-radius: 0.25rem;
            padding: 1rem;
            min-height: 80px;
            white-space: pre-line;
        }

        /* Animation for loading */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Pagination styles */
        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .pagination .page-link {
            color: #007bff;
        }

        .pagination .page-link:hover {
            color: #0056b3;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }
    </style>
@endsection

@include('_ban_nganh.scripts._scripts_tham_vieng')

@section('page-scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(function() {
            // Khởi tạo Select2 trong modal
            $('#modal-them-tham-vieng, #modal-chi-tiet-tham-vieng').on('shown.bs.modal', function () {
                $(this).find('.select2bs4').select2({
                    theme: 'bootstrap4',
                    dropdownParent: $(this),
                    width: '100%'
                });
            });

            // Hủy Select2 khi modal đóng để tránh lỗi
            $('#modal-them-tham-vieng, #modal-chi-tiet-tham-vieng').on('hidden.bs.modal', function () {
                $(this).find('.select2bs4').select2('destroy');
            });

            // DataTables cho bảng lịch sử
            $('#table-lich-su').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json"
                },
                "pageLength": 5,
                "dom": '<"top"f>rt<"bottom"p><"clear">'
            });

            // Khởi tạo bản đồ Leaflet
            @if($tinHuuWithLocations->isNotEmpty())
                if ($('#map').length) {
                    var map = L.map('map').setView([{{ $tinHuuWithLocations[0]->vi_do }}, {{ $tinHuuWithLocations[0]->kinh_do }}], 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(map);

                    @foreach($tinHuuWithLocations as $tinHuu)
                        L.marker([{{ $tinHuu->vi_do }}, {{ $tinHuu->kinh_do }}])
                            .addTo(map)
                            .bindPopup("<b>{{ $tinHuu->ho_ten }}</b><br>{{ $tinHuu->dia_chi }}<br><a href='https://www.google.com/maps/dir/?api=1&destination={{ $tinHuu->vi_do }},{{ $tinHuu->kinh_do }}' target='_blank'>Chỉ đường</a>");
                    @endforeach
                }
            @else
                if ($('#map').length) {
                    document.getElementById('map').innerHTML = '<div class="text-center p-3"><i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i><p>Không có dữ liệu tọa độ của tín hữu.</p></div>';
                }
            @endif

            // Button loading state on form submit
            $('#form-them-tham-vieng').on('submit', function() {
                const btnSave = $('#btn-save-tham-vieng');
                btnSave.html('<i class="fas fa-spinner fa-spin mr-1"></i> Đang lưu...');
                btnSave.prop('disabled', true);
            });

            // Hiệu ứng fade-in cho chi tiết thăm viếng
            $(document).on('click', '.btn-xem-chi-tiet', function() {
                setTimeout(function() {
                    $('.loading-container').hide();
                    $('#chi-tiet-content').addClass('fade-in').show();
                }, 500);
            });

            // Locate me button for map
            $('#btn-locate-me').on('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const currentPos = [position.coords.latitude, position.coords.longitude];
                        if (typeof map !== 'undefined') {
                            map.setView(currentPos, 15);
                            L.marker(currentPos)
                                .addTo(map)
                                .bindPopup("Vị trí của bạn")
                                .openPopup();
                        }
                    }, function(error) {
                        toastr.error('Không thể lấy vị trí của bạn: ' + error.message);
                    });
                } else {
                    toastr.error('Trình duyệt của bạn không hỗ trợ định vị.');
                }
            });

            // Print button functionality
            $('#btn-print-detail').on('click', function() {
                const printContents = $('#chi-tiet-content').html();
                const originalContents = document.body.innerHTML;

                const printTemplate = `
                    <html>
                    <head>
                        <title>Chi tiết thăm viếng</title>
                        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
                        <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
                        <style>
                            body { padding: 2rem; font-family: Arial, sans-serif; }
                            .print-header { text-align: center; margin-bottom: 2rem; }
                            .print-title { font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem; }
                            .print-subtitle { font-size: 1rem; color: #6c757d; }
                            .visit-info-card { margin-bottom: 1rem; padding: 1rem; border: 1px solid #dee2e6; border-radius: 0.5rem; }
                            .content-box { padding: 1rem; border: 1px solid #dee2e6; border-radius: 0.5rem; margin-bottom: 1rem; min-height: 5rem; }
                            @media print {
                                .no-print { display: none; }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="print-header">
                            <div class="print-title">Chi tiết thăm viếng</div>
                            <div class="print-subtitle">Ngày in: ${new Date().toLocaleDateString('vi-VN')}</div>
                        </div>
                        ${printContents}
                        <div class="mt-5 text-center no-print">
                            <button onclick="window.print()" class="btn btn-primary">In ngay</button>
                            <button onclick="window.close()" class="btn btn-secondary ml-2">Đóng</button>
                        </div>
                    </body>
                    </html>
                `;

                const printWindow = window.open('', '_blank');
                printWindow.document.write(printTemplate);
                printWindow.document.close();
            });
        });
    </script>
@endsection