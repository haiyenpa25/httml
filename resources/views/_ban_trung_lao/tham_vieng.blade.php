@extends('layouts.app')

@section('title', 'Thăm Viếng - Ban Trung Lão')

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

            <!-- Các nút chức năng - Bố cục được tối ưu hóa -->
            <div class="action-buttons-container">
                <!-- Hàng 1: Chức năng điều hướng chính -->
                <div class="button-row">
                    <a href="{{ route('_ban_trung_lao.index') }}" class="action-btn btn-primary-custom">
                        <i class="fas fa-home"></i> Trang chính
                    </a>
                    <a href="{{ route('_ban_trung_lao.diem_danh') }}" class="action-btn btn-success-custom">
                        <i class="fas fa-clipboard-check"></i> Điểm danh
                    </a>
                    <a href="{{ route('_ban_trung_lao.tham_vieng') }}" class="action-btn btn-info-custom">
                        <i class="fas fa-user-friends"></i> Thăm viếng
                    </a>
                </div>

                <!-- Hàng 2: Chức năng phân công và báo cáo -->
                <div class="button-row">
                    <a href="{{ route('_ban_trung_lao.phan_cong') }}" class="action-btn btn-warning-custom">
                        <i class="fas fa-tasks"></i> Phân công
                    </a>
                    <a href="{{ route('_ban_trung_lao.phan_cong_chi_tiet') }}" class="action-btn btn-info-custom">
                        <i class="fas fa-clipboard-list"></i> Chi tiết PC
                    </a>
                    <a href="{{ route('_bao_cao.form_ban_trung_lao') }}" class="action-btn btn-success-custom">
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
                </div>
            </div>

            <div class="row">
                <!-- Cột trái: Danh sách đề xuất thăm viếng -->
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users"></i>
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
                                <label>Thời gian chưa thăm:</label>
                                <select class="form-control" id="filter-time">
                                    <option value="30">Lâu hơn 30 ngày</option>
                                    <option value="60" selected>Lâu hơn 60 ngày</option>
                                    <option value="90">Lâu hơn 90 ngày</option>
                                    <option value="180">Lâu hơn 6 tháng</option>
                                    <option value="365">Lâu hơn 1 năm</option>
                                </select>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
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
                                                <td>{{ $tinHuu->ho_ten }}</td>
                                                <td>{{ $tinHuu->so_dien_thoai }}</td>
                                                <td>
                                                    @if($tinHuu->ngay_tham_vieng_gan_nhat)
                                                        {{ Carbon\Carbon::parse($tinHuu->ngay_tham_vieng_gan_nhat)->format('d/m/Y') }}
                                                        <span
                                                            class="badge badge-{{ $tinHuu->so_ngay_chua_tham > 60 ? 'danger' : 'warning' }}">
                                                            {{ $tinHuu->so_ngay_chua_tham }} ngày
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">Chưa thăm bao giờ</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-info btn-them-tham-vieng"
                                                            data-id="{{ $tinHuu->id }}" data-ten="{{ $tinHuu->ho_ten }}"
                                                            data-toggle="modal" data-target="#modal-them-tham-vieng">
                                                            <i class="fas fa-plus"></i> Thăm
                                                        </button>
                                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $tinHuu->vi_do ?? '' }},{{ $tinHuu->kinh_do ?? '' }}"
                                                            class="btn btn-sm btn-success {{ (!$tinHuu->vi_do || !$tinHuu->kinh_do) ? 'disabled' : '' }}"
                                                            target="_blank">
                                                            <i class="fas fa-map-marker-alt"></i> Chỉ đường
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Không có dữ liệu</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Bản đồ tọa độ các tín hữu -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-map-marked-alt"></i>
                                Bản đồ vị trí
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="map" style="height: 400px; width: 100%;"></div>
                        </div>
                    </div>
                </div>

                <!-- Cột phải: Lịch sử thăm viếng -->
                <div class="col-md-6">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-history"></i>
                                Lịch sử thăm viếng
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="date" class="form-control date-picker" id="date-from"
                                            value="{{ date('Y-m-d', strtotime('-30 days')) }}">
                                    </div>
                                </div>
                                <div class="col-md-1 text-center pt-2">
                                    <span>đến</span>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <input type="date" class="form-control date-picker" id="date-to"
                                            value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button id="btn-filter-history" class="btn btn-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
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
                                                <td>{{ Carbon\Carbon::parse($thamVieng->ngay_tham)->format('d/m/Y') }}</td>
                                                <td>{{ $thamVieng->tinHuu->ho_ten ?? 'N/A' }}</td>
                                                <td>{{ $thamVieng->nguoiTham->ho_ten ?? 'N/A' }}</td>
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
                                                <td colspan="4" class="text-center">Không có dữ liệu</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Thống kê thăm viếng -->
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar"></i>
                                Thống kê thăm viếng
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{ $thongKe['total_visits'] }}</h3>
                                            <p>Tổng số lần thăm</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-users-medical"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3>{{ $thongKe['this_month'] }}</h3>
                                            <p>Trong tháng này</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-calendar-check"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="chart">
                                <canvas id="visitChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Thêm Thăm Viếng -->
    <div class="modal fade" id="modal-them-tham-vieng">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm lần thăm</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('api.ban_trung_lao.them_tham_vieng') }}" method="POST" id="form-them-tham-vieng">
                    @csrf
                    <div class="modal-body">
                        <!-- Tín hữu được thăm -->
                        <div class="form-group">
                            <label>Tín hữu <span class="text-danger">*</span></label>
                            <select class="form-control select2bs4" name="tin_huu_id" id="tin_huu_id" required>
                                <option value="">-- Chọn tín hữu --</option>
                                @foreach($danhSachTinHuu as $tinHuu)
                                    <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Người đi thăm -->
                        <div class="form-group">
                            <label>Người thăm <span class="text-danger">*</span></label>
                            <select class="form-control select2bs4" name="nguoi_tham_id" required>
                                <option value="">-- Chọn người thăm --</option>
                                @foreach($thanhVienBanTrungLao as $thanhVien)
                                    <option value="{{ $thanhVien->tinHuu->id }}">{{ $thanhVien->tinHuu->ho_ten }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ngày thăm -->
                        <div class="form-group">
                            <label>Ngày thăm <span class="text-danger">*</span></label>
                            <input type="date" class="form-control date-picker" name="ngay_tham" value="{{ date('Y-m-d') }}"
                                required>
                        </div>

                        <!-- Nội dung thăm viếng -->
                        <div class="form-group">
                            <label>Nội dung <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="noi_dung" rows="3" placeholder="Nhập nội dung thăm viếng"
                                required></textarea>
                        </div>

                        <!-- Kết quả -->
                        <div class="form-group">
                            <label>Kết quả</label>
                            <textarea class="form-control" name="ket_qua" rows="2"
                                placeholder="Nhập kết quả thăm viếng"></textarea>
                        </div>

                        <!-- Trạng thái -->
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select class="form-control" name="trang_thai">
                                <option value="da_tham">Đã thăm</option>
                                <option value="ke_hoach">Kế hoạch</option>
                            </select>
                        </div>

                        <input type="hidden" name="id_ban" value="{{ $banTrungLao->id }}">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Chi Tiết Thăm Viếng -->
    <div class="modal fade" id="modal-chi-tiet-tham-vieng">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Chi tiết thăm viếng</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p>Đang tải dữ liệu...</p>
                    </div>
                    <div id="chi-tiet-content" style="display: none;">
                        <dl class="row">
                            <dt class="col-sm-4">Tín hữu:</dt>
                            <dd class="col-sm-8" id="detail-tin-huu"></dd>

                            <dt class="col-sm-4">Người thăm:</dt>
                            <dd class="col-sm-8" id="detail-nguoi-tham"></dd>

                            <dt class="col-sm-4">Ngày thăm:</dt>
                            <dd class="col-sm-8" id="detail-ngay-tham"></dd>

                            <dt class="col-sm-4">Trạng thái:</dt>
                            <dd class="col-sm-8" id="detail-trang-thai"></dd>
                        </dl>

                        <div class="form-group">
                            <label>Nội dung:</label>
                            <div class="p-2 bg-light" id="detail-noi-dung"></div>
                        </div>

                        <div class="form-group">
                            <label>Kết quả:</label>
                            <div class="p-2 bg-light" id="detail-ket-qua"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endsection



@include('scripts.ban_trung_lao.ban_trung_lao_tham_vieng')