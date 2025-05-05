@extends('layouts.app')

@section('title', 'Chi Tiết Quỹ')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chi Tiết Quỹ: {{ $quy->ten_quy }}</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('thu_quy.quy.edit', $quy->id) }}" class="btn btn-sm btn-primary float-right mr-2">
                        <i class="fas fa-edit"></i> Chỉnh Sửa
                    </a>
                    <a href="{{ route('thu_quy.quy.giao_dich', $quy->id) }}" class="btn btn-sm btn-info float-right mr-2">
                        <i class="fas fa-exchange-alt"></i> Xem Giao Dịch
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('_thu_quy.partials.messages')

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông Tin Quỹ</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tên Quỹ:</strong> {{ $quy->ten_quy }}</p>
                            <p><strong>Số Dư Hiện Tại:</strong> {{ number_format($quy->so_du_hien_tai, 0, ',', '.') }} VNĐ
                            </p>
                            <p><strong>Người Quản Lý:</strong> {{ $quy->nguoiQuanLy->ho_ten ?? 'Chưa có' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Trạng Thái:</strong>
                                <span class="badge {{ $quy->trang_thai == 'hoat_dong' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $quy->trang_thai == 'hoat_dong' ? 'Hoạt Động' : 'Tạm Dừng' }}
                                </span>
                            </p>
                            <p><strong>Mô Tả:</strong> {{ $quy->mo_ta ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thống Kê Giao Dịch</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tổng Thu:</strong> {{ number_format($thongKeThu, 0, ',', '.') }} VNĐ</p>
                            <p><strong>Tổng Chi:</strong> {{ number_format($thongKeChi, 0, ',', '.') }} VNĐ</p>
                        </div>
                        <div class="col-md-6">
                            <canvas id="quyChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Giao Dịch Gần Đây</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Mã Giao Dịch</th>
                                <th>Số Tiền</th>
                                <th>Loại</th>
                                <th>Ngày</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($giaoDichMoiNhat as $gd)
                                <tr>
                                    <td>{{ $gd->ma_giao_dich }}</td>
                                    <td class="{{ $gd->loai == 'thu' ? 'text-success' : 'text-danger' }}">
                                        {{ $gd->loai == 'thu' ? '+' : '-' }} {{ number_format($gd->so_tien, 0, ',', '.') }} VNĐ
                                    </td>
                                    <td>{{ $gd->loai == 'thu' ? 'Thu' : 'Chi' }}</td>
                                    <td>{{ $gd->ngay_giao_dich->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-scripts')
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            const quyChart = new Chart(document.getElementById('quyChart'), {
                type: 'bar',
                data: {
                    labels: @json($dataChartLabels),
                    datasets: [
                        {
                            label: 'Thu',
                            data: @json($dataChartThu),
                            backgroundColor: '#28a745'
                        },
                        {
                            label: 'Chi',
                            data: @json($dataChartChi),
                            backgroundColor: '#dc3545'
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
        });
    </script>
@endsection