@extends('layouts.app')

@section('title', 'Chi Tiết Chi Định Kỳ')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chi Tiết Chi Định Kỳ: {{ $chiDinhKy->ten_chi }}</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('thu_quy.chi_dinh_ky.edit', $chiDinhKy->id) }}"
                        class="btn btn-sm btn-primary float-right mr-2">
                        <i class="fas fa-edit"></i> Chỉnh Sửa
                    </a>
                    <a href="{{ route('thu_quy.chi_dinh_ky.tao_giao_dich', $chiDinhKy->id) }}"
                        class="btn btn-sm btn-success float-right mr-2">
                        <i class="fas fa-plus"></i> Tạo Giao Dịch
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
                    <h3 class="card-title">Thông Tin Chi Định Kỳ</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tên Chi:</strong> {{ $chiDinhKy->ten_chi }}</p>
                            <p><strong>Quỹ:</strong> {{ $chiDinhKy->quyTaiChinh->ten_quy ?? 'N/A' }}</p>
                            <p><strong>Số Tiền:</strong> {{ number_format($chiDinhKy->so_tien, 0, ',', '.') }} VNĐ</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tần Suất:</strong>
                                @php
                                    $tanSuatText = [
                                        'hang_thang' => 'Hàng Tháng',
                                        'hang_quy' => 'Hàng Quý',
                                        'nua_nam' => 'Nửa Năm',
                                        'hang_nam' => 'Hàng Năm'
                                    ];
                                @endphp
                                {{ $tanSuatText[$chiDinhKy->tan_suat] ?? 'N/A' }}
                            </p>
                            <p><strong>Ngày Thanh Toán:</strong> {{ $chiDinhKy->ngay_thanh_toan ?? 'N/A' }}</p>
                            <p><strong>Trạng Thái:</strong>
                                <span
                                    class="badge {{ $chiDinhKy->trang_thai == 'hoat_dong' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $chiDinhKy->trang_thai == 'hoat_dong' ? 'Hoạt Động' : 'Tạm Dừng' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p><strong>Mô Tả:</strong> {{ $chiDinhKy->mo_ta ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection