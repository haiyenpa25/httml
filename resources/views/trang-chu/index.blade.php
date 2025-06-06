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

        /* Tăng margin cho các row */
        .row {
            margin-bottom: 2.5rem;
        }

        /* Card styles */
        .dashboard-card {
            border-radius: var(--card-border-radius);
            box-shadow: var(--card-shadow);
            transition: var(--hover-transition);
            height: 100%;
            border: none;
            min-width: 300px;
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
            min-width: 250px;
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
        .birthday-list-container,
        .event-list-container {
            display: flex;
            flex-direction: column;
            min-width: 350px;
        }

        .filter-controls {
            background-color: rgba(0, 0, 0, 0.02);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            min-width: 300px;
        }

        .birthday-list,
        .event-list {
            flex: 1;
            border-radius: 0.5rem;
            padding: 0;
            overflow-x: auto;
        }

        .birthday-list .user-info {
            display: flex;
            align-items: center;
            min-width: 200px;
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
        .event-list .table {
            margin-bottom: 0;
            width: 100%;
        }

        .event-list .table th,
        .event-list .table td {
            padding: 0.75rem;
            vertical-align: middle;
            white-space: normal;
            word-wrap: break-word;
        }

        .event-list .table th:nth-child(1),
        .event-list .table td:nth-child(1) {
            min-width: 120px;
            max-width: 150px;
        }

        /* Ngày */
        .event-list .table th:nth-child(2),
        .event-list .table td:nth-child(2) {
            min-width: 80px;
            max-width: 100px;
        }

        /* Giờ */
        .event-list .table th:nth-child(3),
        .event-list .table td:nth-child(3) {
            min-width: 120px;
            max-width: 150px;
        }

        /* Ban Ngành */
        .event-list .table th:nth-child(4),
        .event-list .table td:nth-child(4) {
            min-width: 150px;
            max-width: 200px;
        }

        /* Chủ đề */
        .event-list .table th:nth-child(5),
        .event-list .table td:nth-child(5) {
            min-width: 150px;
            max-width: 200px;
        }

        /* Câu gốc */
        .event-list .table th:nth-child(6),
        .event-list .table td:nth-child(6) {
            min-width: 120px;
            max-width: 150px;
        }

        /* Diễn giả */
        .event-list .table th:nth-child(7),
        .event-list .table td:nth-child(7) {
            min-width: 150px;
            max-width: 200px;
        }

        /* Địa điểm */

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
            min-width: 400px;
        }

        .chart-container-lg {
            height: 400px;
            min-width: 600px;
        }

        /* Select2 customization */
        .select2-container--bootstrap4 .select2-selection--single {
            height: calc(1.5em + 0.75rem + 2px) !important;
        }

        /* DataTables customization */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .stat-box {
                min-width: 200px;
            }

            .stat-box h3 {
                font-size: 2rem;
            }

            .stat-box p {
                font-size: 1rem;
            }

            .stat-box .icon {
                font-size: 3rem;
            }

            .chart-container {
                min-width: 300px;
            }
        }

        @media (max-width: 768px) {

            .birthday-list-container,
            .event-list-container {
                min-width: 100%;
            }

            .dashboard-card,
            .stat-box {
                min-width: 100%;
            }

            .chart-container-lg {
                min-width: 100%;
            }

            .event-list .table th,
            .event-list .table td {
                min-width: 100px;
                max-width: 120px;
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

            <!-- Sinh nhật tín hữu -->
            <div class="row">
                <div class="col-12">
                    <div class="dashboard-card">
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
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <label for="birthday-month" class="mb-2">Tháng:</label>
                                                    <select name="thang" id="birthday-month" class="form-control">
                                                        @for($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}" {{ $i == $thang ? 'selected' : '' }}>
                                                                Tháng {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-0">
                                                    <label for="birthday-year" class="mb-2">Năm:</label>
                                                    <select name="nam" id="birthday-year" class="form-control">
                                                        @for($i = (int) date('Y') - 2; $i <= (int) date('Y') + 2; $i++)
                                                            <option value="{{ $i }}" {{ $i == $nam ? 'selected' : '' }}>
                                                                {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-filter"></i> Lọc
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="birthday-list px-3">
                                    <table id="birthdayTable" class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Họ Tên</th>
                                                <th>Ngày Sinh</th>
                                                <th>Tuổi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Dữ liệu sẽ được tải bằng AJAX -->
                                        </tbody>
                                    </table>
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
            </div>

            <!-- Lịch buổi nhóm -->
            <div class="row">
                <div class="col-12">
                    <div class="dashboard-card">
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
                                            <div class="col-md-3">
                                                <div class="form-group mb-0">
                                                    <label for="ban_nganh_id">Ban Ngành:</label>
                                                    <select name="ban_nganh_id" id="ban_nganh_id"
                                                        class="form-control select2">
                                                        <option value="">-- Tất cả --</option>
                                                        @foreach($danhSachBanNganh as $bn)
                                                            <option value="{{ $bn->id }}" {{ (isset($banNganhId) && $banNganhId == $bn->id) ? 'selected' : '' }}>
                                                                {{ $bn->ten }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
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
                                            <div class="col-md-2">
                                                <div class="form-group mb-0">
                                                    <label for="event-year">Năm:</label>
                                                    <select name="nam" id="event-year" class="form-control">
                                                        @for($i = (int) date('Y') - 2; $i <= (int) date('Y') + 2; $i++)
                                                            <option value="{{ $i }}" {{ $i == $nam ? 'selected' : '' }}>
                                                                {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-filter"></i> Lọc
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="event-list px-3">
                                    <table id="eventTable" class="table table-hover">
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
                                            <!-- Dữ liệu sẽ được tải bằng AJAX -->
                                        </tbody>
                                    </table>
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
                            <form action="{{ route('trang-chu') }}" method="GET" id="attendanceFilterForm"
                                class="filter-controls mb-4">
                                <input type="hidden" name="thang" value="{{ $thang }}">
                                <input type="hidden" name="nam" value="{{ $nam }}">

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group mb-0">
                                            <label for="tham_gia_ban_nganh_id">Ban Ngành:</label>
                                            <select name="tham_gia_ban_nganh_id" id="tham_gia_ban_nganh_id"
                                                class="form-control select2">
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
    <script>
        $(function () {
            // Khởi tạo Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: "-- Chọn --",
                width: '100%'
            });

            // Lấy giá trị tháng và năm từ form
            let thang = $('#birthday-month').val();
            let nam = $('#birthday-year').val();
            let banNganhId = $('#ban_nganh_id').val();
            let eventThang = $('#event-month').val();
            let eventNam = $('#event-year').val();

            // Khởi tạo DataTable cho Sinh Nhật Tín Hữu
            let birthdayTable = $('#birthdayTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route("api.trang_chu.birthday_list") }}',
                    type: 'GET',
                    data: function (d) {
                        d.thang = thang;
                        d.nam = nam;
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error: function (xhr, error, thrown) {
                        console.error('Lỗi khi tải dữ liệu Sinh Nhật Tín Hữu:', {
                            status: xhr.status,
                            response: xhr.responseJSON,
                            error: error,
                            thrown: thrown
                        });
                        toastr.error(xhr.responseJSON?.message || 'Không thể tải dữ liệu Sinh Nhật Tín Hữu.');
                    }
                },
                columns: [
                    {
                        data: 'ho_ten',
                        name: 'ho_ten',
                        render: function (data, type, row) {
                            return `
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                ${row.anh_dai_dien ?
                                    `<img src="${row.anh_dai_dien}" alt="${data}">` :
                                    `<div class="avatar-placeholder"><i class="fas fa-user"></i></div>`
                                }
                                            </div>
                                            <div class="user-details">
                                                <div class="font-weight-bold">${data}</div>
                                            </div>
                                        </div>
                                    `;
                        }
                    },
                    {
                        data: 'ngay_sinh',
                        name: 'ngay_sinh',
                        render: function (data) {
                            return data ? moment(data).format('DD/MM') : 'N/A';
                        }
                    },
                    {
                        data: 'tuoi',
                        name: 'tuoi',
                        render: function (data) {
                            return data ? `<span class="age-badge">${data} tuổi</span>` : 'N/A';
                        }
                    }
                ],
                language: {
                    url: '{{ asset("dist/js/Vietnamese.json") }}'
                },
                pageLength: 5,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Tất cả"]],
                order: [[1, 'asc']],
                drawCallback: function (settings) {
                    var totalRecords = settings.oInstance.api().data().count();
                    if (totalRecords === 0) {
                        $('#birthdayTable_wrapper').find('.empty-table-message').remove();
                        $('#birthdayTable_wrapper').append('<div class="empty-table-message text-center p-4">Không có tín hữu nào sinh nhật trong tháng này</div>');
                        $('#birthdayTable_wrapper .empty-table-message').show();
                    } else {
                        $('#birthdayTable_wrapper .empty-table-message').hide();
                    }
                }
            });

            // Khởi tạo DataTable cho Lịch Buổi Nhóm
            let eventTable = $('#eventTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route("api.trang_chu.event_list") }}',
                    type: 'GET',
                    data: function (d) {
                        d.ban_nganh_id = banNganhId;
                        d.thang = eventThang;
                        d.nam = eventNam;
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error: function (xhr, error, thrown) {
                        console.error('Lỗi khi tải dữ liệu Lịch Buổi Nhóm:', {
                            status: xhr.status,
                            response: xhr.responseJSON,
                            error: error,
                            thrown: thrown
                        });
                        toastr.error(xhr.responseJSON?.message || 'Không thể tải dữ liệu Lịch Buổi Nhóm.');
                    }
                },
                columns: [
                    {
                        data: 'ngay_dien_ra',
                        name: 'ngay_dien_ra',
                        render: function (data) {
                            return data ? moment(data).format('DD/MM/YYYY') : 'N/A';
                        }
                    },
                    {
                        data: 'gio_bat_dau',
                        name: 'gio_bat_dau',
                        render: function (data) {
                            return data ? moment(data, 'HH:mm:ss').format('HH:mm') : 'N/A';
                        }
                    },
                    {
                        data: 'ban_nganh',
                        name: 'ban_nganh',
                        render: function (data) {
                            return data ? `<span class="badge badge-info">${data.ten}</span>` : '<span class="text-muted">N/A</span>';
                        }
                    },
                    {
                        data: 'chu_de',
                        name: 'chu_de',
                        render: function (data) {
                            return data || 'N/A';
                        }
                    },
                    {
                        data: 'cau_goc',
                        name: 'cau_goc',
                        render: function (data) {
                            return data ? `<div class="quote-block">${data}</div>` : '<span class="text-muted">N/A</span>';
                        }
                    },
                    {
                        data: 'dien_gia',
                        name: 'dien_gia',
                        render: function (data) {
                            return data ? `<span class="badge badge-secondary">${data.chuc_danh} ${data.ho_ten}</span>` : '<span class="text-muted">N/A</span>';
                        }
                    },
                    {
                        data: 'dia_diem',
                        name: 'dia_diem',
                        render: function (data) {
                            return data ? data.substring(0, 30) : 'N/A';
                        }
                    }
                ],
                language: {
                    url: '{{ asset("dist/js/Vietnamese.json") }}'
                },
                pageLength: 5,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Tất cả"]],
                order: [[0, 'desc']],
                drawCallback: function (settings) {
                    var totalRecords = settings.oInstance.api().data().count();
                    if (totalRecords === 0) {
                        $('#eventTable_wrapper').find('.empty-table-message').remove();
                        $('#eventTable_wrapper').append('<div class="empty-table-message text-center p-4">Không có buổi nhóm nào trong thời gian này</div>');
                        $('#eventTable_wrapper .empty-table-message').show();
                    } else {
                        $('#eventTable_wrapper .empty-table-message').hide();
                    }
                }
            });

            // Auto submit khi thay đổi bộ lọc
            $('#birthday-month, #birthday-year').change(function () {
                thang = $('#birthday-month').val();
                nam = $('#birthday-year').val();
                birthdayTable.ajax.reload();
            });

            $('#ban_nganh_id, #event-month, #event-year').change(function () {
                banNganhId = $('#ban_nganh_id').val();
                eventThang = $('#event-month').val();
                eventNam = $('#event-year').val();
                eventTable.ajax.reload();
            });

            $('#tham_gia_ban_nganh_id, #thoi_gian').change(function () {
                $('#attendanceFilterForm').submit();
            });

            // Dữ liệu cho biểu đồ thống kê tín hữu theo ban ngành
            const departmentData = @json($thongKeBanNganh ?? []);
            const departmentLabels = departmentData.map(item => item.ten || '');
            const departmentValues = departmentData.map(item => item.tin_huu_count || 0);

            // Dữ liệu cho biểu đồ thống kê thu chi tài chính
            const financeData = @json($thongKeTaiChinh ?? []);
            const financeLabels = financeData.map(item => item.thang || '');
            const financeIncome = financeData.map(item => item.thu || 0);
            const financeExpense = financeData.map(item => item.chi || 0);

            // Dữ liệu cho biểu đồ thống kê tham gia buổi nhóm
            const attendanceData = @json($thongKeThamGia);

            // Cấu hình màu sắc chung
            const chartColors = {
                primary: 'rgba(60, 141, 188, 1)',
                primaryLight: 'rgba(60, 141, 188, 0.2)',
                success: 'rgba(40, 167, 69, 1)',
                successLight: 'rgba(40, 167, 69, 0.2)',
                danger: 'rgba(220, 53, 69, 1)',
                dangerLight: 'rgba(220, 53, 69, 0.2)',
                warning: 'rgba(255, 193, 7, 1)',
                warningLight: 'rgba(255, 193, 7, 0.2)',
                info: 'rgba(23, 162, 184, 1)',
                infoLight: 'rgba(23, 162, 184, 0.2)',
                purple: 'rgba(102, 16, 242, 1)',
                purpleLight: 'rgba(102, 16, 242, 0.2)',
                colorPalette: [
                    'rgba(60, 141, 188, 0.8)',
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(220, 53, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(23, 162, 184, 0.8)',
                    'rgba(108, 117, 125, 0.8)'
                ],
                colorPaletteBorder: [
                    'rgba(60, 141, 188, 1)',
                    'rgba(40, 167, 69, 1)',
                    'rgba(220, 53, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(23, 162, 184, 1)',
                    'rgba(108, 117, 125, 1)'
                ]
            };

            // Biểu đồ thống kê tín hữu theo ban ngành
            const departmentChartCtx = document.getElementById('departmentChart').getContext('2d');

            if (departmentLabels.length > 0 && departmentValues.length > 0) {
                const departmentChart = new Chart(departmentChartCtx, {
                    type: 'bar',
                    data: {
                        labels: departmentLabels,
                        datasets: [{
                            label: 'Số lượng tín hữu',
                            data: departmentValues,
                            backgroundColor: chartColors.colorPalette,
                            borderColor: chartColors.colorPaletteBorder,
                            borderWidth: 1,
                            borderRadius: 4,
                            maxBarThickness: 50
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    font: { size: 11 }
                                },
                                grid: { color: 'rgba(0, 0, 0, 0.05)' }
                            },
                            x: {
                                ticks: { font: { size: 11 } },
                                grid: { display: false }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { boxWidth: 12, padding: 15 }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                titleFont: { size: 13 },
                                bodyFont: { size: 12 },
                                cornerRadius: 4,
                                padding: 10,
                                callbacks: {
                                    title: function (tooltipItems) {
                                        return tooltipItems[0].label;
                                    },
                                    label: function (tooltipItem) {
                                        return tooltipItem.dataset.label + ': ' + tooltipItem.formattedValue + ' người';
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                $(departmentChartCtx.canvas).parent().html('<div class="text-center p-4"><i class="fas fa-chart-bar text-muted fa-3x mb-3"></i><p class="text-muted">Không có dữ liệu thống kê</p></div>');
            }

            // Biểu đồ thống kê thu chi tài chính
            const financeChartCtx = document.getElementById('financeChart').getContext('2d');

            if (financeLabels.length > 0 && (financeIncome.length > 0 || financeExpense.length > 0)) {
                const financeChart = new Chart(financeChartCtx, {
                    type: 'line',
                    data: {
                        labels: financeLabels,
                        datasets: [
                            {
                                label: 'Thu',
                                data: financeIncome,
                                backgroundColor: chartColors.successLight,
                                borderColor: chartColors.success,
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            },
                            {
                                label: 'Chi',
                                data: financeExpense,
                                backgroundColor: chartColors.dangerLight,
                                borderColor: chartColors.danger,
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { intersect: false, mode: 'index' },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function (value) {
                                        return new Intl.NumberFormat('vi-VN', {
                                            style: 'currency',
                                            currency: 'VND',
                                            maximumFractionDigits: 0
                                        }).format(value);
                                    },
                                    font: { size: 11 }
                                },
                                grid: { color: 'rgba(0, 0, 0, 0.05)' }
                            },
                            x: {
                                ticks: { font: { size: 11 } },
                                grid: { display: false }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { boxWidth: 12, padding: 15 }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                titleFont: { size: 13 },
                                bodyFont: { size: 12 },
                                cornerRadius: 4,
                                padding: 10,
                                callbacks: {
                                    label: function (tooltipItem) {
                                        return tooltipItem.dataset.label + ': ' +
                                            new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND',
                                                maximumFractionDigits: 0
                                            }).format(tooltipItem.raw);
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                $(financeChartCtx.canvas).parent().html('<div class="text-center p-4"><i class="fas fa-chart-line text-muted fa-3x mb-3"></i><p class="text-muted">Không có dữ liệu thống kê</p></div>');
            }

            // Biểu đồ thống kê tham gia buổi nhóm
            const attendanceChartCtx = document.getElementById('attendanceChart').getContext('2d');

            if (attendanceData.labels && attendanceData.labels.length > 0 && attendanceData.datasets && attendanceData.datasets.length > 0 && attendanceData.so_buoi_nhom && attendanceData.so_buoi_nhom.length > 0) {
                const buoiNhomDataset = {
                    label: 'Số buổi nhóm',
                    data: attendanceData.so_buoi_nhom,
                    type: 'line',
                    backgroundColor: chartColors.purpleLight,
                    borderColor: chartColors.purple,
                    borderWidth: 2,
                    fill: false,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    yAxisID: 'y1',
                    order: 0
                };

                const enhancedDatasets = attendanceData.datasets.map((dataset, index) => ({
                    ...dataset,
                    borderRadius: 4,
                    maxBarThickness: 40,
                    borderWidth: 1
                }));

                const attendanceChart = new Chart(attendanceChartCtx, {
                    type: 'bar',
                    data: {
                        labels: attendanceData.labels,
                        datasets: [...enhancedDatasets, buoiNhomDataset]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Số người tham gia',
                                    font: { size: 12, weight: 'bold' }
                                },
                                ticks: { precision: 0, font: { size: 11 } },
                                grid: { color: 'rgba(0, 0, 0, 0.05)' }
                            },
                            y1: {
                                beginAtZero: true,
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Số buổi nhóm',
                                    font: { size: 12, weight: 'bold' }
                                },
                                grid: { drawOnChartArea: false },
                                ticks: { precision: 0, font: { size: 11 } }
                            },
                            x: {
                                ticks: { font: { size: 11 } },
                                grid: { display: false }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { boxWidth: 12, padding: 15 }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                                titleFont: { size: 13 },
                                bodyFont: { size: 12 },
                                cornerRadius: 4,
                                padding: 10,
                                callbacks: {
                                    title: function (tooltipItems) {
                                        return tooltipItems[0].label;
                                    },
                                    label: function (tooltipItem) {
                                        const unit = tooltipItem.datasetIndex === attendanceData.datasets.length
                                            ? ' buổi' : ' người';
                                        return tooltipItem.dataset.label + ': ' + tooltipItem.formattedValue + unit;
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                $(attendanceChartCtx.canvas).parent().html('<div class="text-center p-4"><i class="fas fa-chart-bar text-muted fa-3x mb-3"></i><p class="text-muted">Không có dữ liệu thống kê</p></div>');
            }

            // Tự động cập nhật chiều cao của biểu đồ khi thay đổi kích thước cửa sổ
            function adjustChartContainers() {
                $('.chart-container').each(function () {
                    $(this).css('height', Math.max(300, $(this).parent().height() - 20));
                });

                $('.chart-container-lg').each(function () {
                    $(this).css('height', Math.max(400, $(this).parent().height() - 80));
                });
            }

            $(window).resize(adjustChartContainers).resize();

            // Fix cho select2 khi card được collapse
            $('.card').on('expanded.lte.cardwidget', function () {
                $(this).find('.select2').select2({
                    theme: 'bootstrap4',
                    width: '100%'
                });
            });
        });
    </script>
@endsection