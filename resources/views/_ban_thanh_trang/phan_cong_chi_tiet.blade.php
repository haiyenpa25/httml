@extends('layouts.app')

@section('title', 'Phân Công Chi Tiết - Ban Thanh Tráng')

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
            <!-- Thanh điều hướng nhanh -->
            @include('_ban_thanh_trang.partials._navigation')

            <!-- Filter Form -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter"></i>
                        Lọc dữ liệu
                    </h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('_ban_thanh_trang.phan_cong_chi_tiet') }}" method="GET" id="filter-form">
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
                                <a href="{{ route('_ban_thanh_trang.phan_cong_chi_tiet') }}" class="btn btn-default">
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
                                                        data-ghi-chu="{{ $phanCong->ghi_chu }}" data-toggle="modal"
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
                        Danh sách thành viên Ban Thanh Tráng
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
                <form id="form-phan-cong" action="{{ route('api.ban_thanh_trang.phan_cong_nhiem_vu') }}" method="POST">
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
                            <textarea class="form-control" name="ghi_chu" id="ghi-chu" rows="3"
                                placeholder="Nhập ghi chú (nếu có)"></textarea>
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

@include('_ban_thanh_trang.scripts._scripts_phan_cong_chi_tiet')