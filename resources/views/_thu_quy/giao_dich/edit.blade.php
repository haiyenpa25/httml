@extends('layouts.app')

@section('title', 'Chỉnh Sửa Giao Dịch')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chỉnh Sửa Giao Dịch: {{ $giaoDich->ma_giao_dich }}</h1>
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
                    <form action="{{ route('thu_quy.giao_dich.update', $giaoDich->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quy_tai_chinh_id">Quỹ Tài Chính</label>
                                    <select name="quy_tai_chinh_id" id="quy_tai_chinh_id" class="form-control select2"
                                        required>
                                        <option value="">Chọn quỹ</option>
                                        @foreach ($dsQuy as $quy)
                                            <option value="{{ $quy->id }}" {{ $giaoDich->quy_tai_chinh_id == $quy->id ? 'selected' : '' }}>{{ $quy->ten_quy }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="loai">Loại Giao Dịch</label>
                                    <select name="loai" id="loai" class="form-control" required>
                                        <option value="thu" {{ $giaoDich->loai == 'thu' ? 'selected' : '' }}>Thu</option>
                                        <option value="chi" {{ $giaoDich->loai == 'chi' ? 'selected' : '' }}>Chi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="hinh_thuc">Hình Thức</label>
                                    <select name="hinh_thuc" id="hinh_thuc" class="form-control" required>
                                        <option value="dang_hien" {{ $giaoDich->hinh_thuc == 'dang_hien' ? 'selected' : '' }}>
                                            Dâng Hiến</option>
                                        <option value="tai_tro" {{ $giaoDich->hinh_thuc == 'tai_tro' ? 'selected' : '' }}>Tài
                                            Trợ</option>
                                        <option value="luong" {{ $giaoDich->hinh_thuc == 'luong' ? 'selected' : '' }}>Lương
                                        </option>
                                        <option value="hoa_don" {{ $giaoDich->hinh_thuc == 'hoa_don' ? 'selected' : '' }}>Hóa
                                            Đơn</option>
                                        <option value="sua_chua" {{ $giaoDich->hinh_thuc == 'sua_chua' ? 'selected' : '' }}>
                                            Sửa Chữa</option>
                                        <option value="khac" {{ $giaoDich->hinh_thuc == 'khac' ? 'selected' : '' }}>Khác
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="so_tien">Số Tiền</label>
                                    <input type="number" name="so_tien" id="so_tien" class="form-control"
                                        value="{{ $giaoDich->so_tien }}" required min="1000">
                                </div>
                                <div class="form-group">
                                    <label for="nguoi_nhan">Người Nhận (nếu là chi)</label>
                                    <input type="text" name="nguoi_nhan" id="nguoi_nhan" class="form-control"
                                        value="{{ $giaoDich->nguoi_nhan }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mo_ta">Mô Tả</label>
                                    <textarea name="mo_ta" id="mo_ta" class="form-control"
                                        required>{{ $giaoDich->mo_ta }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="ngay_giao_dich">Ngày Giao Dịch</label>
                                    <input type="text" name="ngay_giao_dich" id="ngay_giao_dich"
                                        class="form-control date-picker"
                                        value="{{ $giaoDich->ngay_giao_dich->format('d/m/Y') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="phuong_thuc">Phương Thức</label>
                                    <select name="phuong_thuc" id="phuong_thuc" class="form-control" required>
                                        <option value="tien_mat" {{ $giaoDich->phuong_thuc == 'tien_mat' ? 'selected' : '' }}>
                                            Tiền Mặt</option>
                                        <option value="chuyen_khoan" {{ $giaoDich->phuong_thuc == 'chuyen_khoan' ? 'selected' : '' }}>Chuyển Khoản</option>
                                        <option value="the" {{ $giaoDich->phuong_thuc == 'the' ? 'selected' : '' }}>Thẻ
                                        </option>
                                        <option value="khac" {{ $giaoDich->phuong_thuc == 'khac' ? 'selected' : '' }}>Khác
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ban_nganh_id">Ban Ngành</label>
                                    <select name="ban_nganh_id" id="ban_nganh_id" class="form-control select2">
                                        <option value="">Chọn ban ngành</option>
                                        @foreach ($dsBanNganh as $ban)
                                            <option value="{{ $ban->id }}" {{ $giaoDich->ban_nganh_id == $ban->id ? 'selected' : '' }}>{{ $ban->ten }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="hoa_don">Hóa Đơn</label>
                                    <input type="file" name="hoa_don" id="hoa_don" class="form-control"
                                        accept=".jpeg,.png,.jpg,.pdf">
                                    @if ($giaoDich->duong_dan_hoa_don)
                                        <p><a href="{{ Storage::url($giaoDich->duong_dan_hoa_don) }}" target="_blank">Xem hóa
                                                đơn hiện tại</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập Nhật Giao Dịch</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-scripts')
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('#ngay_giao_dich').datetimepicker({
                format: 'DD/MM/YYYY'
            });
        });
    </script>
@endsection