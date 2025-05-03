@extends('layouts.app')

@section('title', 'Duyệt Giao Dịch')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Duyệt Giao Dịch: {{ $giaoDich->ma_giao_dich }}</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('thu_quy.giao_dich.show', $giaoDich->id) }}" class="btn btn-sm btn-info float-right">
                        <i class="fas fa-arrow-left"></i> Quay Lại
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Hành Động Duyệt</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('thu_quy.giao_dich.duyet.update', $giaoDich->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="hanh_dong">Hành Động</label>
                            <select name="hanh_dong" id="hanh_dong" class="form-control" required>
                                <option value="duyet">Duyệt</option>
                                <option value="tu_choi">Từ Chối</option>
                            </select>
                        </div>
                        <div class="form-group" id="ly_do_tu_choi_group" style="display: none;">
                            <label for="ly_do_tu_choi">Lý Do Từ Chối</label>
                            <textarea name="ly_do_tu_choi" id="ly_do_tu_choi" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Xác Nhận</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-scripts')
    <script>
        $(document).ready(function () {
            $('#hanh_dong').change(function () {
                if ($(this).val() === 'tu_choi') {
                    $('#ly_do_tu_choi_group').show();
                    $('#ly_do_tu_choi').prop('required', true);
                } else {
                    $('#ly_do_tu_choi_group').hide();
                    $('#ly_do_tu_choi').prop('required', false);
                }
            });
        });
    </script>
@endsection