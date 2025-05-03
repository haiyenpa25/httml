@extends('layouts.app')

@section('title', 'Chi Tiết Báo Cáo')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chi Tiết Báo Cáo: {{ $baoCao->tieu_de }}</h1>
                </div>
                <div class="col-sm-6">
                    @if ($baoCao->duong_dan_file)
                        <a href="{{ route('thu_quy.bao_cao.download', $baoCao->id) }}"
                            class="btn btn-sm btn-secondary float-right mr-2">
                            <i class="fas fa-download"></i> Tải PDF
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('_thu_quy.partials.messages')

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông Tin Báo Cáo</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tiêu Đề:</strong> {{ $baoCao->tieu_de }}</p>
                            <p><strong>Quỹ:</strong> {{ $baoCao->quyTaiChinh->ten_quy ?? 'Tổng Hợp' }}</p>
                            <p><strong>Loại Báo Cáo:</strong>
                                @php
                                    $loaiBaoCaoText = [
                                        'thang' => 'Tháng',
                                        'quy' => 'Quý',
                                        'sau_thang' => 'Sáu Tháng',
                                        'nam' => 'Năm',
                                        'tuy_chinh' => 'Tùy Chỉnh'
                                    ];
                                @endphp
                                {{ $loaiBaoCaoText[$baoCao->loai_bao_cao] ?? 'N/A' }}
                            </p>
                            <p><strong>Công Khai:</strong>
                                <span class="badge {{ $baoCao->cong_khai ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $baoCao->cong_khai ? 'Có' : 'Không' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Từ Ngày:</strong> {{ $baoCao->tu_ngay->format('d/m/Y') }}</p>
                            <p><strong>Đến Ngày:</strong> {{ $baoCao->den_ngay->format('d/m/Y') }}</p>
                            <p><strong>Người Tạo:</strong> {{ $baoCao->nguoiTao->tin_huu->ho_ten ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thống Kê</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tổng Thu:</strong> {{ number_format($baoCao->tong_thu, 0, ',', '.') }} VNĐ</p>
                            <p><strong>Tổng Chi:</strong> {{ number_format($baoCao->tong_chi, 0, ',', '.') }} VNĐ</p>
                            <p><strong>Số Dư Đầu Kỳ:</strong> {{ number_format($baoCao->so_du_dau_ky, 0, ',', '.') }} VNĐ
                            </p>
                            <p><strong>Số Dư Cuối Kỳ:</strong> {{ number_format($baoCao->so_du_cuoi_ky, 0, ',', '.') }} VNĐ
                            </p>
                        </div>
                        <div class="col-md-6">
                            <canvas id="thuChiChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Biểu Đồ Phân Bổ</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Thu Theo Hình Thức</h4>
                            <canvas id="pieThuChart"></canvas>
                        </div>
                        <div class="col-md-6">
                            <h4>Chi Theo Hình Thức</h4>
                            <canvas id="pieChiChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-scripts')
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Thu Chi Chart
            const thuChiChart = new Chart(document.getElementById('thuChiChart'), {
                type: 'line',
                data: {
                    labels: @json($chartData['line_chart']['labels']),
                    datasets: [
                        {
                            label: 'Thu',
                            data: @json($chartData['line_chart']['thu']),
                            borderColor: '#28a745',
                            fill: false
                        },
                        {
                            label: 'Chi',
                            data: @json($chartData['line_chart']['chi']),
                            borderColor: '#dc3545',
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Pie Chart Thu
            const pieThuChart = new Chart(document.getElementById('pieThuChart'), {
                type: 'pie',
                data: {
                    labels: @json($chartData['pie_thu']->pluck('name')),
                    datasets: [{
                        data: @json($chartData['pie_thu']->pluck('y')),
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
                    }]
                },
                options: {
                    responsive: true
                }
            });

            // Pie Chart Chi
            const pieChiChart = new Chart(document.getElementById('pieChiChart'), {
                type: 'pie',
                data: {
                    labels: @json($chartData['pie_chi']->pluck('name')),
                    datasets: [{
                        data: @json($chartData['pie_chi']->pluck('y')),
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
                    }]
                },
                options: {
                    responsive: true
                }
            });
        });
    </script>
@endsection