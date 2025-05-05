@extends('layouts.app')

@section('title', 'Chi Tiết Giao Dịch')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chi Tiết Giao Dịch: {{ $giaoDich->ma_giao_dich }}</h1>
                </div>
                <div class="col-sm-6">
                    @if (Auth::user()->vai_tro == 'quan_tri' || $giaoDich->trang_thai == 'cho_duyet')
                        <a href="{{ route('thu_quy.giao_dich.edit', $giaoDich->id) }}"
                            class="btn btn-sm btn-primary float-right mr-2">
                            <i class="fas fa-edit"></i> Chỉnh Sửa
                        </a>
                    @endif
                    @if (Auth::user()->vai_tro == 'quan_tri' || (Auth::user()->vai_tro == 'truong_ban' && $giaoDich->trang_thai == 'cho_duyet'))
                        <a href="{{ route('thu_quy.giao_dich.duyet.show', $giaoDich->id) }}"
                            class="btn btn-sm btn-success float-right mr-2">
                            <i class="fas fa-check"></i> Duyệt
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
                    <h3 class="card-title">Thông Tin Giao Dịch</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Mã Giao Dịch:</strong> {{ $giaoDich->ma_giao_dich }}</p>
                            <p><strong>Quỹ:</strong> {{ $giaoDich->quyTaiChinh->ten_quy ?? 'N/A' }}</p>
                            <p><strong>Số Tiền:</strong>
                                <span class="{{ $giaoDich->loai == 'thu' ? 'text-success' : 'text-danger' }}">
                                    {{ $giaoDich->loai == 'thu' ? '+' : '-' }}
                                    {{ number_format($giaoDich->so_tien, 0, ',', '.') }} VNĐ
                                </span>
                            </p>
                            <p><strong>Loại:</strong> {{ $giaoDich->loai == 'thu' ? 'Thu' : 'Chi' }}</p>
                            <p><strong>Trạng Thái:</strong>
                                <span
                                    class="badge {{ $giaoDich->trang_thai == 'hoan_thanh' ? 'bg-info' : ($giaoDich->trang_thai == 'cho_duyet' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $giaoDich->trang_thai == 'hoan_thanh' ? 'Hoàn Thành' : ($giaoDich->trang_thai == 'cho_duyet' ? 'Chờ Duyệt' : 'Từ Chối') }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Ngày Giao Dịch:</strong> {{ $giaoDich->ngay_giao_dich->format('d/m/Y') }}</p>
                            <p><strong>Hình Thức:</strong>
                                @php
                                    $hinhThucText = [
                                        'dang_hien' => 'Dâng Hiến',
                                        'tai_tro' => 'Tài Trợ',
                                        'luong' => 'Lương',
                                        'hoa_don' => 'Hóa Đơn',
                                        'sua_chua' => 'Sửa Chữa',
                                        'khac' => 'Khác'
                                    ];
                                @endphp
                                {{ $hinhThucText[$giaoDich->hinh_thuc] ?? 'N/A' }}
                            </p>
                            <p><strong>Phương Thức:</strong> {{ ucfirst(str_replace('_', ' ', $giaoDich->phuong_thuc)) }}
                            </p>
                            <p><strong>Người Nhận:</strong> {{ $giaoDich->nguoi_nhan ?? 'N/A' }}</p>
                            <p><strong>Hóa Đơn:</strong>
                                @if ($giaoDich->duong_dan_hoa_don)
                                    <a href="{{ Storage::url($giaoDich->duong_dan_hoa_don) }}" target="_blank">Xem Hóa Đơn</a>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p><strong>Mô Tả:</strong> {{ $giaoDich->mo_ta }}</p>
                            <p><strong>Người Duyệt:</strong> {{ $giaoDich->nguoiDuyet->tin_huu->ho_ten ?? 'N/A' }}</p>
                            <p><strong>Ngày Duyệt:</strong>
                                {{ $giaoDich->ngay_duyet ? $giaoDich->ngay_duyet->format('d/m/Y') : 'N/A' }}</p>
                            @if ($giaoDich->trang_thai == 'tu_choi')
                                <p><strong>Lý Do Từ Chối:</strong> {{ $giaoDich->ly_do_tu_choi }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection