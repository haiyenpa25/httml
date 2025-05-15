@extends('layouts.app')

@section('title', 'Điểm danh - ' . $config['name'])

@section('page-styles')
    @include('_ban_co_doc_giao_duc.partials._attendance_styles')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-3">
                <div class="col-sm-6">
                    <h1 class="m-0 text-primary">
                        <i class="fas fa-clipboard-check mr-2"></i>Điểm danh - {{ $config['name'] }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('_ban_co_doc_giao_duc.index', ['banType' => 'ban-co-doc-giao-duc']) }}">{{ $config['name'] }}</a></li>
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
            @include('_ban_co_doc_giao_duc.partials._navigation', ['banType' => $banType])

            <!-- Card chọn tháng/năm, buổi nhóm và ban ngành -->
            <div class="card card-primary card-outline mb-4">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-filter mr-2"></i> Bộ lọc điểm danh
                    </h3>
                    <div class="card-tools ml-auto">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-filter-diem-danh" method="GET" action="{{ route('_ban_co_doc_giao_duc.diem_danh', ['banType' => 'ban-co-doc-giao-duc']) }}">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="month" class="text-muted"><i class="far fa-calendar-alt mr-1"></i>Tháng</label>
                                    <select name="month" id="month" class="form-control select2bs4">
                                        @foreach($months as $key => $monthName)
                                            <option value="{{ $key }}" {{ $month == $key ? 'selected' : '' }}>{{ $monthName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="year" class="text-muted"><i class="far fa-calendar-check mr-1"></i>Năm</label>
                                    <select name="year" id="year" class="form-control select2bs4">
                                        @foreach($years as $y)
                                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="buoi_nhom_id" class="text-muted"><i class="fas fa-users mr-1"></i>Buổi nhóm</label>
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
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="ban_nganh" class="text-muted"><i class="fas fa-layer-group mr-1"></i>Ban ngành</label>
                                    <select name="ban_nganh" id="ban_nganh" class="form-control select2bs4">
                                        <option value="">-- Chọn ban ngành --</option>
                                        <option value="trung_lao" {{ $selectedBanNganh == 'trung_lao' ? 'selected' : '' }}>Ban Trung Lão</option>
                                        <option value="thanh_trang" {{ $selectedBanNganh == 'thanh_trang' ? 'selected' : '' }}>Ban Thanh Tráng</option>
                                        <option value="thanh_nien" {{ $selectedBanNganh == 'thanh_nien' ? 'selected' : '' }}>Ban Thanh Niên</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-filter mr-1"></i> Áp dụng bộ lọc
                                    </button>
                                    <button type="button" id="btn-them-buoi-nhom" class="btn btn-success ml-2">
                                        <i class="fas fa-plus-circle mr-1"></i> Thêm buổi nhóm mới
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Thống kê và điểm danh -->
            @if($selectedBuoiNhom && $selectedBanNganh)
                <!-- Thẻ thống kê -->
                <div class="row mb-4">
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card stat-card h-100 border-left-success">
                            <div class="card-body">
                                <div class="stat-label">Có mặt</div>
                                <div class="stat-value text-success" id="stats-co-mat">{{ $stats['co_mat'] }}</div>
                                <i class="fas fa-check-circle stat-icon text-success"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card stat-card h-100 border-left-danger">
                            <div class="card-body">
                                <div class="stat-label">Vắng mặt</div>
                                <div class="stat-value text-danger" id="stats-vang">{{ $stats['vang'] }}</div>
                                <i class="fas fa-times-circle stat-icon text-danger"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card stat-card h-100 border-left-info">
                            <div class="card-body">
                                <div class="stat-label">Tỷ lệ tham dự</div>
                                <div class="stat-value text-info" id="stats-ti-le">{{ $stats['ti_le_tham_du'] }}%</div>
                                <i class="fas fa-chart-pie stat-icon text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danh sách điểm danh -->
                <div class="card card-success card-outline mb-4">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-clipboard-list mr-2"></i> 
                            Danh sách điểm danh - 
                            <span class="badge badge-pill badge-light">
                                {{ $selectedBanNganh == 'trung_lao' ? 'Ban Trung Lão' : ($selectedBanNganh == 'thanh_trang' ? 'Ban Thanh Tráng' : 'Ban Thanh Niên') }}
                            </span>
                        </h3>
                        <div class="card-tools ml-auto">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Form điểm danh -->
                        <form id="form-diem-danh" action="{{ route('api._ban_co_doc_giao_duc.luu_diem_danh', ['banType' => 'ban-co-doc-giao-duc']) }}" method="POST">
                            @csrf
                            <input type="hidden" name="buoi_nhom_id" value="{{ $selectedBuoiNhom }}">
                            <input type="hidden" name="ban_nganh" value="{{ $selectedBanNganh }}">
                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 60px" class="text-center">STT</th>
                                            <th>Họ tên</th>
                                            <th style="width: 120px" class="text-center">Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($danhSachTinHuu as $index => $tinHuu)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td>{{ $tinHuu->ho_ten }}</td>
                                                <td class="text-center">
                                                    <label class="attendance-toggle">
                                                        <input type="checkbox"
                                                               name="attendance[{{ $tinHuu->id }}]"
                                                               value="co_mat"
                                                               class="attendance-checkbox"
                                                               {{ isset($diemDanhData[$tinHuu->id]) && $diemDanhData[$tinHuu->id]['status'] == 'co_mat' ? 'checked' : '' }}>
                                                        <span class="attendance-slider"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-4 text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save mr-2"></i> Lưu điểm danh
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info d-flex align-items-center">
                    <i class="fas fa-info-circle mr-3 fa-2x"></i>
                    <div>
                        <strong>Lưu ý:</strong> Vui lòng chọn một buổi nhóm và ban ngành từ bộ lọc phía trên để xem danh sách điểm danh.
                    </div>
                </div>
            @endif

            @include('_ban_co_doc_giao_duc.partials._attendance_modal')
        </div>
    </section>
@endsection

@section('page-scripts')
    @include('_ban_co_doc_giao_duc.partials._attendance_scripts')
@endsection