@extends('layouts.app')

@section('title', 'Tạo Báo Cáo')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tạo Báo Cáo Tài Chính</h1>
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
                    <form action="{{ route('thu_quy.bao_cao.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tieu_de">Tiêu Đề</label>
                                    <input type="text" name="tieu_de" id="tieu_de" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="loai_bao_cao">Loại Báo Cáo</label>
                                    <select name="loai_bao_cao" id="loai_bao_cao" class="form-control" required>
                                        <option value="thang">Tháng</option>
                                        <option value="quy">Quý</option>
                                        <option value="sau_thang">Sáu Tháng</option>
                                        <option value="nam">Năm</option>
                                        <option value="tuy_chinh">Tùy Chỉnh</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="quy_tai_chinh_id">Quỹ Tài Chính</label>
                                    <select name="quy_tai_chinh_id" id="quy_tai_chinh_id" class="form-control select2">
                                        <option value="">Tổng Hợp</option>
                                        @foreach ($dsQuy as $quy)
                                            <option value="{{ $quy->id }}">{{ $quy->ten_quy }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="ban_nganh_id">Ban Ngành</label>
                                    <select name="ban_nganh_id" id="ban_nganh_id" class="form-control select2">
                                        <option value="">Tất cả</option>
                                        @foreach ($dsBanNganh as $ban)
                                            <option value="{{ $ban->id }}">{{ $ban->ten }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" id="ky_bao_cao_group">
                                    <label for="ky_bao_cao">Kỳ Báo Cáo</label>
                                    <select name="ky_bao_cao" id="ky_bao_cao" class="form-control">
                                        <option value="">Chọn kỳ</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">Tháng {{ $i }}</option>
                                        @endfor
                                        <option value="1">Quý 1</option>
                                        <option value="2">Quý 2</option>
                                        <option value="3">Quý 3</option>
                                        <option value="4">Quý 4</option>
                                        <option value="1">Nửa Năm 1</option>
                                        <option value="2">Nửa Năm 2</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nam_bao_cao">Năm Báo Cáo</label>
                                    <input type="number" name="nam_bao_cao" id="nam_bao_cao" class="form-control"
                                        value="{{ date('Y') }}" required min="2020" max="2030">
                                </div>
                                <div class="form-group" id="tu_ngay_group" style="display: none;">
                                    <label for="tu_ngay">Từ Ngày</label>
                                    <input type="text" name="tu_ngay" id="tu_ngay" class="form-control date-picker">
                                </div>
                                <div class="form-group" id="den_ngay_group" style="display: none;">
                                    <label for="den_ngay">Đến Ngày</label>
                                    <input type="text" name="den_ngay" id="den_ngay" class="form-control date-picker">
                                </div>
                                <div class="form-group">
                                    <label for="cong_khai">Công Khai</label>
                                    <input type="checkbox" name="cong_khai" id="cong_khai" value="1">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Tạo Báo Cáo</button>
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

            $('.date-picker').datetimepicker({
                format: 'DD/MM/YYYY'
            });

            $('#loai_bao_cao').change(function () {
                if ($(this).val() === 'tuy_chinh') {
                    $('#ky_bao_cao_group').hide();
                    $('#tu_ngay_group, #den_ngay_group').show();
                    $('#ky_bao_cao').prop('required', false);
                    $('#tu_ngay, #den_ngay').prop('required', true);
                } else {
                    $('#ky_bao_cao_group').show();
                    $('#tu_ngay_group, #den_ngay_group').hide();
                    $('#ky_bao_cao').prop('required', true);
                    $('#tu_ngay, #den_ngay').prop('required', false);
                }
            });
        });
    </script>
@endsection