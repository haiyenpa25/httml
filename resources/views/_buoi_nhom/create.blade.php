@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Thêm Buổi Nhóm Mới</h2>
        <form action="{{ route('buoi_nhom.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="lich_buoi_nhom_id" class="form-label">Lịch Buổi Nhóm</label>
                <select class="form-control" id="lich_buoi_nhom_id" name="lich_buoi_nhom_id" required>
                    <option value="">-- Chọn Lịch Buổi Nhóm --</option>
                    @foreach ($lichBuoiNhoms as $lich)
                        <option value="{{ $lich->id }}">{{ $lich->ten }}</option>
                    @endforeach
                </select>
                @error('lich_buoi_nhom_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="ngay_dien_ra" class="form-label">Ngày Diễn Ra</label>
                <input type="date" class="form-control" id="ngay_dien_ra" name="ngay_dien_ra" required>
                @error('ngay_dien_ra')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="gio_bat_dau" class="form-label">Giờ Bắt Đầu</label>
                <input type="time" class="form-control" id="gio_bat_dau" name="gio_bat_dau" required>
                @error('gio_bat_dau')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="gio_ket_thuc" class="form-label">Giờ Kết Thúc</label>
                <input type="time" class="form-control" id="gio_ket_thuc" name="gio_ket_thuc" required>
                @error('gio_ket_thuc')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="dia_diem" class="form-label">Địa Điểm</label>
                <textarea class="form-control" id="dia_diem" name="dia_diem" required></textarea>
                @error('dia_diem')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="chu_de" class="form-label">Chủ Đề</label>
                <input type="text" class="form-control" id="chu_de" name="chu_de">
                @error('chu_de')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="kinh_thanh" class="form-label">Kinh Thánh</label>
                <input type="text" class="form-control" id="kinh_thanh" name="kinh_thanh">
                @error('kinh_thanh')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="cau_goc" class="form-label">Câu Gốc</label>
                <input type="text" class="form-control" id="cau_goc" name="cau_goc">
                @error('cau_goc')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="id_to" class="form-label">Tổ</label>
                <select class="form-control" id="id_to" name="id_to">
                    <option value="">-- Chọn Tổ (nếu có) --</option>
                    @foreach ($buoiNhomsTo as $to)
                        <option value="{{ $to->id }}">{{ $to->ten_to }}</option>
                    @endforeach
                </select>
                @error('id_to')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('buoi_nhom.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection