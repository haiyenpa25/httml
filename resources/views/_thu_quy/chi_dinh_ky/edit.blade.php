@extends('layouts.app')

@section('title', 'Chỉnh Sửa Chi Định Kỳ')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chỉnh Sửa Chi Định Kỳ: {{ $chiDinhKy->ten_chi }}</h1>
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
                    <form action="{{ route('thu_quy.chi_dinh_ky.update', $chiDinhKy->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ten_chi">Tên Chi</label>
                                    <input type="text" name="ten_chi" id="ten_chi" class="form-control"
                                        value="{{ $chiDinhKy->ten_chi }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="quy_tai_chinh_id">Quỹ Tài Chính</label>
                                    <select name="quy_tai_chinh_id" id="quy_tai_chinh_id" class="form-control select2"
                                        required>
                                        <option value="">Chọn quỹ</option>
                                        @foreach ($dsQuy as $quy)
                                            <option value="{{ $quy->id }}" {{ $chiDinhKy->quy_tai_chinh_id == $quy->id ? 'selected' : '' }}>{{ $quy->ten_quy }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="so_tien">Số Tiền</label>
                                    <input type="number" name="so_tien" id="so_tien" class="form-control"
                                        value="{{ $chiDinhKy->so_tien }}" required min="1000">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tan_suat">Tần Suất</label>
                                    <select name="tan_suat" id="tan_suat" class="form-control" required>
                                        <option value="hang_thang" {{ $chiDinhKy->tan_suat == 'hang_thang' ? 'selected' : '' }}>Hàng Tháng</option>
                                        <option value="hang_quy" {{ $chiDinhKy->tan_suat == 'hang_quy' ? 'selected' : '' }}>
                                            Hàng Quý</option>
                                        <option value="nua_nam" {{ $chiDinhKy->tan_suat == 'nua_nam' ? 'selected' : '' }}>Nửa
                                            Năm</option>
                                        <option value="hang_nam" {{ $chiDinhKy->tan_suat == 'hang_nam' ? 'selected' : '' }}>
                                            Hàng Năm</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ngay_thanh_toan">Ngày Thanh Toán</label>
                                    <input type="number" name="ngay_thanh_toan" id="ngay_thanh_toan" class="form-control"
                                        value="{{ $chiDinhKy->ngay_thanh_toan }}" min="1" max="31">
                                </div>
                                <div class="form-group">
                                    <label for="trang_thai">Trạng Thái</label>
                                    <select name="trang_thai" id="trang_thai" class="form-control" required>
                                        <option value="hoat_dong" {{ $chiDinhKy->trang_thai == 'hoat_dong' ? 'selected' : '' }}>Hoạt Động</option>
                                        <option value="tam_dung" {{ $chiDinhKy->trang_thai == 'tam_dung' ? 'selected' : '' }}>
                                            Tạm Dừng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mo_ta">Mô Tả</label>
                            <textarea name="mo_ta" id="mo_ta" class="form-control">{{ $chiDinhKy->mo_ta }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập Nhật Chi Định Kỳ</button>
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
        });
    </script>
@endsection