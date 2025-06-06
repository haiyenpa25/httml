@extends('layouts.app')

@section('title', 'Trang Chủ - HTTL Thạnh Mỹ Lợi')

@section('page-styles')
<style>
    /* Base styles */
    :root {
        --primary: #3c8dbc;
        --success: #28a745;
        --danger: #dc3545;
        --warning: #ffc107;
        --info: #17a2b8;
        --secondary: #6c757d;
        --light: #f8f9fa;
        --dark: #343a40;
        --white: #ffffff;
        --card-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        --card-border-radius: 0.5rem;
        --hover-transition: all 0.3s ease;
    }
    
    /* Card styles */
    .dashboard-card {
        border-radius: var(--card-border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--hover-transition);
        margin-bottom: 1.5rem;
        height: 100%;
        border: none;
    }
    
    .dashboard-card:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        transform: translateY(-3px);
    }
    
    .dashboard-card .card-header {
        background: linear-gradient(135deg, var(--light), var(--white));
        border-bottom: 2px solid rgba(0, 0, 0, 0.05);
        border-radius: var(--card-border-radius) var(--card-border-radius) 0 0;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .dashboard-card .card-title {
        margin-bottom: 0;
        color: var(--dark);
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .dashboard-card .card-body {
        padding: 1.25rem;
    }
    
    .dashboard-card .card-footer {
        background-color: var(--white);
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 0 0 var(--card-border-radius) var(--card-border-radius);
    }
    
    /* Stats boxes */
    .stat-box {
        border-radius: var(--card-border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--hover-transition);
        overflow: hidden;
        position: relative;
        margin-bottom: 1.5rem;
        color: var(--white);
    }
    
    .stat-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
    
    .stat-box .inner {
        padding: 1.5rem;
        z-index: 10;
        position: relative;
    }
    
    .stat-box h3 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        white-space: nowrap;
    }
    
    .stat-box p {
        font-size: 1.1rem;
        margin-bottom: 0;
        opacity: 0.9;
    }
    
    .stat-box .icon {
        color: rgba(255, 255, 255, 0.2);
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 3.5rem;
        z-index: 5;
    }
    
    .stat-box .more-info {
        background-color: rgba(0, 0, 0, 0.1);
        position: relative;
        text-align: center;
        padding: 0.5rem;
        z-index: 10;
        color: var(--white);
        display: block;
        transition: all 0.2s ease;
    }
    
    .stat-box .more-info:hover {
        background-color: rgba(0, 0, 0, 0.2);
        text-decoration: none;
        color: var(--white);
    }
    
    .stat-box.bg-gradient-primary {
        background: linear-gradient(135deg, #3c8dbc 0%, #5bc0de 100%);
    }
    
    .stat-box.bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #84c442 100%);
    }
    
    .stat-box.bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    }
    
    .stat-box.bg-gradient-danger {
        background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
    }
    
    /* Birthday list */
    .birthday-list-container {
        height: 400px; /* Fixed height to match with event list */
        max-height: 400px;
        display: flex;
        flex-direction: column;
    }
    
    .filter-controls {
        background-color: rgba(0, 0, 0, 0.02);
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .birthday-list {
        flex: 1;
        overflow-y: auto;
        border-radius: 0.5rem;
        padding: 0;
    }
    
    .birthday-list .user-item {
        padding: 0.75rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }
    
    .birthday-list .user-item:hover {
        background-color: rgba(60, 141, 188, 0.05);
    }
    
    .birthday-list .user-item:last-child {
        border-bottom: none;
    }
    
    .birthday-list .user-info {
        display: flex;
        align-items: center;
    }
    
    .birthday-list .user-birthday {
        font-size: 0.85rem;
        color: var(--secondary);
    }
    
    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 0.75rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        flex-shrink: 0;
    }
    
    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .user-avatar .avatar-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--secondary);
        color: var(--white);
        font-size: 1.5rem;
    }
    
    .day-badge {
        background-color: var(--light);
        color: var(--dark);
        border-radius: 0.25rem;
        padding: 0.25rem 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .age-badge {
        background-color: var(--info);
        color: var(--white);
        border-radius: 0.25rem;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        font-weight: 500;
        margin-left: 0.5rem;
    }
    
    /* Event list */
    .event-list-container {
        height: 400px; /* Fixed height to match with birthday list */
        max-height: 400px;
        display: flex;
        flex-direction: column;
    }
    
    .event-list {
        flex: 1;
        overflow-y: auto;
        border-radius: 0.5rem;
    }
    
    .event-list .table {
        margin-bottom: 0;
    }
    
    .event-list .table th,
    .event-list .table td {
        padding: 0.75rem;
        vertical-align: middle;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .event-list .table thead th {
        position: sticky;
        top: 0;
        background-color: var(--light);
        z-index: 1;
        font-weight: 600;
        border-bottom: 2px solid rgba(0, 0, 0, 0.05);
    }
    
    .event-list .table tr {
        transition: all 0.2s ease;
    }
    
    .event-list .table tr:hover {
        background-color: rgba(60, 141, 188, 0.05);
    }
    
    .event-date {
        color: var(--primary);
        font-weight: 600;
    }
    
    .quote-block {
        font-style: italic;
        padding: 0.5rem;
        border-left: 3px solid var(--secondary);
        background-color: rgba(0, 0, 0, 0.03);
        font-size: 0.9rem;
        max-width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0;
    }
    
    /* Chart container */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
    
    .chart-container-lg {
        height: 400px;
    }
    
    /* Select2 customization */
    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(1.5em + 0.75rem + 2px) !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .stat-box h3 {
            font-size: 2rem;
        }
        
        .stat-box p {
            font-size: 1rem;
        }
        
        .stat-box .icon {
            font-size: 3rem;
        }
    }
    
    @media (max-width: 768px) {
        .birthday-list-container,
        .event-list-container {
            height: auto;
            max-height: 500px;
        }
    }
</style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Trang Chủ</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Trang Chủ</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Thống kê tổng quan -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-box bg-gradient-primary">
                    <div class="inner">
                        <h3>{{ App\Models\TinHuu::count() }}</h3>
                        <p>Tín Hữu</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="#" class="more-info">
                        Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stat-box bg-gradient-success">
                    <div class="inner">
                        <h3>{{ App\Models\BanNganh::count() }}</h3>
                        <p>Ban Ngành</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <a href="#" class="more-info">
                        Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                @php
                    $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
                    $endOfWeek = \Carbon\Carbon::now()->endOfWeek();
                    $buoiNhomTuanNay = App\Models\BuoiNhom::whereBetween('ngay_dien_ra', [$startOfWeek, $endOfWeek])->count();
                @endphp
                <div class="stat-box bg-gradient-warning">
                    <div class="inner">
                        <h3>{{ $buoiNhomTuanNay }}</h3>
                        <p>Buổi Nhóm Tuần Này</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <a href="#" class="more-info">
                        Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="stat-box bg-gradient-danger">
                    <div class="inner">
                        <h3>{{ App\Models\ThanHuu::count() }}</h3>
                        <p>Than Hữu</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <a href="#" class="more-info">
                        Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Sinh nhật và buổi nhóm -->
        <div class="row">
            <!-- Danh sách tín hữu có sinh nhật trong tháng -->
            <div class="col-md-4">
                <div class="dashboard-card h-100">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-birthday-cake text-warning mr-2"></i>
                            Sinh Nhật Tín Hữu
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="birthday-list-container">
                            <div class="filter-controls p-3">
                                <form action="{{ route('trang-chu') }}" method="GET" id="birthdayFilterForm">
                                    <div class="form-group mb-0">
                                        <label for="birthday-month" class="mb-2">Tháng:</label>
                                        <div class="input-group">
                                            <select name="thang" id="birthday-month" class="form-control">
                                                @for($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}" {{ $i == $thang ? 'selected' : '' }}>
                                                        Tháng {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-filter"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                            <div class="birthday-list px-3">
                                @if(isset($tinHuuSinhNhat) && $tinHuuSinhNhat->count() > 0)
                                    <ul class="list-unstyled mb-0">
                                        @foreach($tinHuuSinhNhat as $tinHuu)
                                            <li class="user-item">
                                                <div class="user-info">
                                                    <div class="user-avatar">
                                                        @if($tinHuu->anh_dai_dien)
                                                            <img src="{{ asset('storage/' . $tinHuu->anh_dai_dien) }}" alt="{{ $tinHuu->ho_ten }}">
                                                        @else
                                                            <div class="avatar-placeholder">
                                                                <i class="fas fa-user"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="user-details">
                                                        <div class="font-weight-bold">{{ $tinHuu->ho_ten }}</div>
                                                        <div class="user-birthday">
                                                            <i class="far fa-calendar-alt mr-1"></i>
                                                            {{ \Carbon\Carbon::parse($tinHuu->ngay_sinh)->format('d/m') }}
                                                            <span class="age-badge">
                                                                {{ \Carbon\Carbon::parse($tinHuu->ngay_sinh)->age }} tuổi
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <span class="day-badge">
                                                            Ngày {{ \Carbon\Carbon::parse($tinHuu->ngay_sinh)->format('d') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-center p-4">
                                        <i class="fas fa-calendar-times text-muted fa-3x mb-3"></i>
                                        <p class="text-muted">Không có tín hữu nào sinh nhật trong tháng này</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" class="text-primary">
                            <i class="fas fa-users mr-1"></i> Xem tất cả tín hữu
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Danh sách buổi nhóm trong tháng -->
            <div class="col-md-8">
                <div class="dashboard-card h-100">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt text-primary mr-2"></i>
                            Lịch Buổi Nhóm
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="event-list-container">
                            <div class="filter-controls p-3">
                                <form action="{{ route('trang-chu') }}" method="GET" id="eventFilterForm">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group mb-0">
                                                <label for="ban_nganh_id">Ban Ngành:</label>
                                                <select name="ban_nganh_id" id="ban_nganh_id" class="form-control select2">
                                                    <option value="">-- Tất cả --</option>
                                                    @foreach($danhSachBanNganh as $bn)
                                                        <option value="{{ $bn->id }}" {{ (isset($banNganhId) && $banNganhId == $bn->id) ? 'selected' : '' }}>
                                                            {{ $bn->ten }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-0">
                                                <label for="event-month">Tháng:</label>
                                                <select name="thang" id="event-month" class="form-control">
                                                    @for($i = 1; $i <= 12; $i++)
                                                        <option value="{{ $i }}" {{ $i == $thang ? 'selected' : '' }}>
                                                            Tháng {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-0">
                                                <label for="event-year">Năm:</label>
                                                <select name="nam" id="event-year" class="form-control">
                                                    @for($i = (int)date('Y') - 2; $i <= (int)date('Y') + 2; $i++)
                                                        <option value="{{ $i }}" {{ $i == $nam ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-filter"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                            <div class="event-list">
                                @if(isset($buoiNhomSapToi) && $buoiNhomSapToi->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Ngày</th>
                                                    <th>Giờ</th>
                                                    <th>Ban Ngành</th>
                                                    <th>Chủ đề</th>
                                                    <th>Câu gốc</th>
                                                    <th>Diễn giả</th>
                                                    <th>Địa điểm</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($buoiNhomSapToi as $buoiNhom)
                                                    <tr class="{{ $buoiNhom->trang_thai == 'da_dien_ra' ? 'text-muted' : '' }}">
                                                        <td class="event-date">{{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($buoiNhom->gio_bat_dau)->format('H:i') }}</td>
                                                        <td>
                                                            <span class="badge badge-info">
                                                                {{ $buoiNhom->banNganh->ten ?? 'N/A' }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $buoiNhom->chu_de ?? 'N/A' }}</td>
                                                        <td>
                                                            @if($buoiNhom->cau_goc)
                                                                <div class="quote-block">{{ $buoiNhom->cau_goc }}</div>
                                                            @else
                                                                <span class="text-muted">N/A</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($buoiNhom->dienGia)
                                                                <span class="badge badge-secondary">
                                                                    {{ $buoiNhom->dienGia->chuc_danh }} {{ $buoiNhom->dienGia->ho_ten }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">N/A</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ Str::limit($buoiNhom->dia_diem, 30) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center p-4">
                                        <i class="far fa-calendar-times text-muted fa-3x mb-3"></i>
                                        <p class="text-muted">Không có buổi nhóm nào trong thời gian này</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#" class="text-primary">
                            <i class="fas fa-calendar-alt mr-1"></i> Xem tất cả buổi nhóm
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Biểu đồ -->
        <div class="row">
            <div class="col-md-6">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar text-primary mr-2"></i>
                            Thống Kê Tín Hữu Theo Ban Ngành
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="departmentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line text-success mr-2"></i>
                            Thống Kê Thu Chi Tài Chính (6 Tháng Gần Nhất)
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="financeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users text-danger mr-2"></i>
                            Thống Kê Tham Gia Buổi Nhóm
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('trang-chu') }}" method="GET" id="attendanceFilterForm" class="filter-controls mb-4">
                            <input type="hidden" name="thang" value="{{ $thang }}">
                            <input type="hidden" name="nam" value="{{ $nam }}">
                            
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group mb-0">
                                        <label for="tham_gia_ban_nganh_id">Ban Ngành:</label>
                                        <select name="tham_gia_ban_nganh_id" id="tham_gia_ban_nganh_id" class="form-control select2">
                                            <option value="">-- Tất cả --</option>
                                            @foreach($danhSachBanNganh as $bn)
                                                <option value="{{ $bn->id }}" {{ (isset($thamGiaBanNganhId) && $thamGiaBanNganhId == $bn->id) ? 'selected' : '' }}>
                                                    {{ $bn->ten }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group mb-0">
                                        <label for="thoi_gian">Thời gian:</label>
                                        <select name="thoi_gian" id="thoi_gian" class="form-control">
                                            <option value="tuan" {{ (isset($thoiGian) && $thoiGian == 'tuan') ? 'selected' : '' }}>5 Tuần gần nhất</option>
                                            <option value="thang" {{ (isset($thoiGian) && $thoiGian == 'thang') ? 'selected' : '' }}>5 Tháng gần nhất</option>
                                            <option value="quy" {{ (isset($thoiGian) && $thoiGian == 'quy') ? 'selected' : '' }}>4 Quý gần nhất</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-filter mr-1"></i> Lọc
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <div class="chart-container chart-container-lg">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('page-scripts')
    @include('trang-chu.scripts')
@endsection