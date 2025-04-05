@extends('layouts.app')

@section('title', 'Thêm Mới Ban Ngành')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h1>Thêm Mới Ban Ngành</h1>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thông Tin Ban Ngành</h3>
            </div>
            <form action="{{ route('_ban_nganh.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="ten">Tên Ban Ngành</label>
                        <input type="text" class="form-control" name="ten" id="ten" placeholder="Nhập tên ban ngành">
                    </div>
                    <div class="form-group">
                        <label>Loại</label>
                        <select class="form-control" name="loai">
                            <option value="sinh_hoat">Sinh Hoạt</option>
                            <option value="muc_vu">Mục Vụ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mo_ta">Mô Tả</label>
                        <textarea class="form-control" name="mo_ta" id="mo_ta" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Trưởng Ban</label>
                        <select class="form-control select2" name="truong_ban_id">
                            <option value="">-- Chọn Trưởng Ban --</option>
                            @foreach($tinHuus as $item)
                                <option value="{{ $item->id }}">{{ $item->ho_ten }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">Lưu</button>
                    <a href="{{ route('_ban_nganh.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
