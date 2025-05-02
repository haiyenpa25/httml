@extends('layouts.app')

@section('title', 'Tạo Quỹ Mới')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tạo Quỹ Tài Chính</h1>
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
                    <form action="{{ route('thu_quy.quy.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ten_quy">Tên Quỹ</label>
                                    <input type="text" name="ten_quy" id="ten_quy" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="so_du_hien_tai">Số Dư Ban Đầu</label>
                                    <input type="number" name="so_du_hien_tai" id="so_du_hien_tai" class="form-control"
                                        required min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nguoi_quan_ly_id">Người Quản Lý</label>
                                    <select name="nguoi_quan_ly_id" id="nguoi_quan_ly_id" class="form-control select2">
                                        <option value="">Chọn người quản lý</option>
                                        @foreach ($nguoiQuanLy as $nguoi)
                                            <option value="{{ $nguoi->id }}">{{ $nguoi->ho_ten }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="trang_thai">Trạng Thái</label>
                                    <select name="trang_thai" id="trang_thai" class="form-control" required>
                                        <option value="hoat_dong">Hoạt Động</option>
                                        <option value="tam_dung">Tạm Dừng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mo_ta">Mô Tả</label>
                            <textarea name="mo_ta" id="mo_ta" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu Quỹ</button>
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