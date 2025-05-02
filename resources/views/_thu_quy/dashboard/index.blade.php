@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Overview Cards -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Tổng Quỹ</h3>
                        </div>
                        <div class="card-body">
                            <p>{{ $tongQuy }} quỹ</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Tổng Số Dư</h3>
                        </div>
                        <div class="card-body">
                            <p>{{ number_format($tongSoDu, 0, ',', '.') }} VNĐ</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Giao Dịch Chờ Duyệt</h3>
                        </div>
                        <div class="card-body">
                            <p>{{ $choDuyet }} giao dịch</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Biểu Đồ Thu Chi 12 Tháng</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="thuChiChart" style="min-height: 250px; height: 250px; max-height: 250px;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Phân Bổ Quỹ</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Notifications -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông Báo Gần Đây</h3>
                </div>
                <div class="card-body">
                    @if ($thongBaoMoi->isEmpty())
                        <p>Không có thông báo mới.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($thongBaoMoi as $tb)
                                <li class="list-group-item notification-item {{ $tb->da_doc ? 'read' : '' }}">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $tb->tieu_de }}</h5>
                                        <small>{{ $tb->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p class="mb-1">{{ $tb->noi_dung }}</p>
                                    @if (!$tb->da_doc)
                                        <button class="btn btn-sm btn-outline-primary mark-as-read" data-id="{{ $tb->id }}">Đánh Dấu Đã
                                            Đọc</button>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Giao Dịch Gần Đây</h3>
                </div>
                <div class="card-body">
                    @if ($giaoDichMoiNhat->isEmpty())
                        <p>Không có giao dịch nào.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Mã Giao Dịch</th>
                                    <th>Quỹ</th>
                                    <th>Số Tiền</th>
                                    <th>Loại</th>
                                    <th>Ngày</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($giaoDichMoiNhat as $gd)
                                    <tr>
                                        <td>{{ $gd->ma_giao_dich }}</td>
                                        <td>{{ $gd->quyTaiChinh ? $gd->quyTaiChinh->ten_quy : 'Không xác định' }}</td>
                                        <td class="{{ $gd->loai == 'thu' ? 'text-success' : 'text-danger' }}">
                                            {{ $gd->loai == 'thu' ? '+' : '-' }} {{ number_format($gd->so_tien, 0, ',', '.') }} VNĐ
                                        </td>
                                        <td>
                                            <span class="badge {{ $gd->loai == 'thu' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $gd->loai == 'thu' ? 'Thu' : 'Chi' }}
                                            </span>
                                        </td>
                                        <td>{{ $gd->ngay_giao_dich->format('d/m/Y') }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $gd->trang_thai == 'hoan_thanh' ? 'bg-info' : ($gd->trang_thai == 'cho_duyet' ? 'bg-warning' : 'bg-danger') }}">
                                                {{ $gd->trang_thai == 'cho_duyet' ? 'Chờ duyệt' : ($gd->trang_thai == 'hoan_thanh' ? 'Hoàn thành' : 'Từ chối') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-scripts')
    @include('_thu_quy.scripts.dashboard')
@endsection