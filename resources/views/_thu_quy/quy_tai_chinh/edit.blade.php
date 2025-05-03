@extends('layouts.app')

@section('title', 'Chỉnh Sửa Quỹ')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chỉnh Sửa Quỹ: {{ $quy->ten_quy }}</h1>
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
                    <form action="{{ route('thu_quy.quy.update', $quy->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ten_quy">Tên Quỹ</label>
                                    <input type="text" name="ten_quy" id="ten_quy" class="form-control"
                                        value="{{ $quy->ten_quy }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nguoi_quan_ly_id">Người Quản Lý</label>
                                    <select name="nguoi_quan_ly_id" id="nguoi_quan_ly_id" class="form-control select2">
                                        <option value="">Chọn người quản lý</option>
                                        @foreach ($nguoiQuanLy as $nguoi)
                                            <option value="{{ $nguoi->id }}" {{ $quy->nguoi_quan_ly_id == $nguoi->id ? 'selected' : '' }}>{{ $nguoi->ho_ten }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mo_ta">Mô Tả</label>
                            <textarea name="mo_ta" id="mo_ta" class="form-control">{{ $quy->mo_ta }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="trang_thai">Trạng Thái</label>
                            <select name="trang_thai" id="trang_thai" class="form-control" required>
                                <option value="hoat_dong" {{ $quy->trang_thai == 'hoat_dong' ? 'selected' : '' }}>Hoạt Động
                                </option>
                                <option value="tam_dung" {{ $quy->trang_thai == 'tam_dung' ? 'selected' : '' }}>Tạm Dừng
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập Nhật Quỹ</button>
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