@extends('layouts.app')

@section('title', 'Tìm Kiếm Giao Dịch')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tìm Kiếm Nâng Cao</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            @include('_thu_quy.partials.messages')

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tùy Chọn Tìm Kiếm</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('thu_quy.giao_dich.search.results') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quy_tai_chinh_id">Quỹ Tài Chính</label>
                                    <select name="quy_tai_chinh_id" id="quy_tai_chinh_id" class="form-control select2">
                                        <option value="">Tất cả</option>
                                        @foreach ($dsQuy as $quy)
                                            <option value="{{ $quy->id }}">{{ $quy->ten_quy }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="loai">Loại Giao Dịch</label>
                                    <select name="loai" id="loai" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="thu">Thu</option>
                                        <option value="chi">Chi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="hinh_thuc">Hình Thức</label>
                                    <select name="hinh_thuc" id="hinh_thuc" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="dang_hien">Dâng Hiến</option>
                                        <option value="tai_tro">Tài Trợ</option>
                                        <option value="luong">Lương</option>
                                        <option value="hoa_don">Hóa Đơn</option>
                                        <option value="sua_chua">Sửa Chữa</option>
                                        <option value="khac">Khác</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tu_ngay">Từ Ngày</label>
                                    <input type="text" name="tu_ngay" id="tu_ngay" class="form-control date-picker">
                                </div>
                                <div class="form-group">
                                    <label for="den_ngay">Đến Ngày</label>
                                    <input type="text" name="den_ngay" id="den_ngay" class="form-control date-picker">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="trang_thai">Trạng Thái</label>
                                    <select name="trang_thai" id="trang_thai" class="form-control">
                                        <option value="">Tất cả</option>
                                        <option value="cho_duyet">Chờ Duyệt</option>
                                        <option value="hoan_thanh">Hoàn Thành</option>
                                        <option value="tu_choi">Từ Chối</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="so_tien_min">Số Tiền Tối Thiểu</label>
                                    <input type="number" name="so_tien_min" id="so_tien_min" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="so_tien_max">Số Tiền Tối Đa</label>
                                    <input type="number" name="so_tien_max" id="so_tien_max" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mo_ta">Mô Tả</label>
                            <input type="text" name="mo_ta" id="mo_ta" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Tìm Kiếm</button>
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
        });
    </script>
@endsection