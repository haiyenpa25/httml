@extends('layouts.app')

@section('title', 'Báo Cáo Thiết Bị')

@section('page-styles')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Báo Cáo Thống Kê Thiết Bị</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('thiet-bi.index') }}">Thiết bị</a></li>
                        <li class="breadcrumb-item active">Báo cáo</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Nút quay lại và xuất báo cáo -->
            <div class="row mb-3">
                <div class="col-12 d-flex justify-content-between">
                    <a href="{{ route('thiet-bi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-success" id="btn-export-excel">
                            <i class="fas fa-file-excel"></i> Xuất Excel
                        </button>
                        <button type="button" class="btn btn-danger" id="btn-export-pdf">
                            <i class="fas fa-file-pdf"></i> Xuất PDF
                        </button>
                    </div>
                </div>
            </div>

            <!-- Thống kê tổng quan -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- Tổng số thiết bị -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ array_sum(array_column($thongKeTheoTrangThai, 'count')) }}</h3>
                            <p>Tổng số thiết bị</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-tools"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- Thiết bị đang hoạt động tốt -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $thongKeTheoTrangThai['tot']['count'] ?? 0 }}</h3>
                            <p>Thiết bị hoạt động tốt</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- Thiết bị hỏng -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $thongKeTheoTrangThai['hong']['count'] ?? 0 }}</h3>
                            <p>Thiết bị hỏng</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- Thiết bị đang sửa -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $thongKeTheoTrangThai['dang_sua']['count'] ?? 0 }}</h3>
                            <p>Thiết bị đang sửa</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-wrench"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ thống kê -->
            <div class="row">
                <!-- Biểu đồ theo tình trạng -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê theo tình trạng</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chart-tinh-trang"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Biểu đồ theo loại thiết bị -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê theo loại thiết bị</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chart-loai-thiet-bi"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Biểu đồ theo ban ngành -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê thiết bị theo ban ngành</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chart-ban-nganh"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Biểu đồ chi phí bảo trì -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Chi phí bảo trì theo tháng</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="chart-chi-phi"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bảng dữ liệu chi tiết -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Chi tiết chi phí bảo trì</h3>
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
                                            <th>Năm</th>
                                            <th>Tháng</th>
                                            <th>Chi phí bảo trì</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($chiPhiBaoTri as $chiPhi)
                                            <tr>
                                                <td>{{ $chiPhi->nam }}</td>
                                                <td>{{ $chiPhi->thang }}</td>
                                                <td>{{ number_format($chiPhi->tong_chi_phi, 0, ',', '.') }} VNĐ</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Tổng chi phí</th>
                                            <th>{{ number_format($chiPhiBaoTri->sum('tong_chi_phi'), 0, ',', '.') }} VNĐ
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bảng thống kê theo ban ngành -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê thiết bị theo ban ngành</h3>
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
                                            <th>Ban ngành</th>
                                            <th>Số lượng thiết bị</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($thongKeTheoBanNganh as $index => $banNganh)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $banNganh->ten }}</td>
                                                <td>{{ $banNganh->thiet_bis_count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Tổng số thiết bị</th>
                                            <th>{{ $thongKeTheoBanNganh->sum('thiet_bis_count') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-scripts')
    <script>
        $(document).ready(function () {
            // Biểu đồ theo tình trạng
            var ctxTinhTrang = document.getElementById('chart-tinh-trang').getContext('2d');
            var chartTinhTrang = new Chart(ctxTinhTrang, {
                type: 'pie',
                data: {
                    labels: [
                        @foreach($thongKeTheoTrangThai as $key => $value)
                            '{{ $value['label'] }}',
                        @endforeach
                        ],
                    datasets: [{
                        data: [
                            @foreach($thongKeTheoTrangThai as $key => $value)
                                {{ $value['count'] }},
                            @endforeach
                            ],
                        backgroundColor: [
                            '#28a745',  // Tốt - xanh lá
                            '#dc3545',  // Hỏng - đỏ
                            '#ffc107',  // Đang sửa - vàng
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: true,
                            text: 'Phân bố thiết bị theo tình trạng'
                        }
                    }
                }
            });

            // Biểu đồ theo loại thiết bị
            var ctxLoaiThietBi = document.getElementById('chart-loai-thiet-bi').getContext('2d');
            var chartLoaiThietBi = new Chart(ctxLoaiThietBi, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($thongKeTheoLoai as $key => $value)
                            '{{ $value['label'] }}',
                        @endforeach
                        ],
                    datasets: [{
                        label: 'Số lượng',
                        data: [
                            @foreach($thongKeTheoLoai as $key => $value)
                                {{ $value['count'] }},
                            @endforeach
                            ],
                        backgroundColor: [
                            '#007bff',  // Nhạc cụ
                            '#6f42c1',  // Ánh sáng
                            '#fd7e14',  // Âm thanh
                            '#20c997',  // Hình ảnh
                            '#6c757d',  // Khác
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'Số lượng thiết bị theo loại'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            // Biểu đồ theo ban ngành
            var ctxBanNganh = document.getElementById('chart-ban-nganh').getContext('2d');
            var chartBanNganh = new Chart(ctxBanNganh, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach($thongKeTheoBanNganh as $banNganh)
                            '{{ $banNganh->ten }}',
                        @endforeach
                        ],
                    datasets: [{
                        label: 'Số lượng thiết bị',
                        data: [
                            @foreach($thongKeTheoBanNganh as $banNganh)
                                {{ $banNganh->thiet_bis_count }},
                            @endforeach
                            ],
                        backgroundColor: '#17a2b8'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'Phân bố thiết bị theo ban ngành'
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 90,
                                minRotation: 45
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });

            // Biểu đồ chi phí bảo trì theo tháng
            var ctxChiPhi = document.getElementById('chart-chi-phi').getContext('2d');
            var chartChiPhi = new Chart(ctxChiPhi, {
                type: 'line',
                data: {
                    labels: [
                        @foreach($chiPhiBaoTri as $chiPhi)
                            '{{ $chiPhi->thang }}/{{ $chiPhi->nam }}',
                        @endforeach
                        ],
                    datasets: [{
                        label: 'Chi phí bảo trì',
                        data: [
                            @foreach($chiPhiBaoTri as $chiPhi)
                                {{ $chiPhi->tong_chi_phi }},
                            @endforeach
                            ],
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        title: {
                            display: true,
                            text: 'Chi phí bảo trì theo tháng/năm'
                        }
                    },
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
                                }
                            }
                        }
                    }
                }
            });

            // Xuất báo cáo Excel
            $('#btn-export-excel').click(function () {
                window.location.href = "{{ route('thiet-bi.export-excel') }}";
            });

            // Xuất báo cáo PDF
            $('#btn-export-pdf').click(function () {
                window.location.href = "{{ route('thiet-bi.export-pdf') }}";
            });
        });
    </script>
@endsection