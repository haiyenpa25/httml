@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Chỉnh Sửa Buổi Nhóm</h2>
        <form action="{{ route('buoi_nhom.update', $buoiNhom->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="lich_buoi_nhom_id" class="form-label">Lịch Buổi Nhóm</label>
                <select class="form-control" id="lich_buoi_nhom_id" name="lich_buoi_nhom_id" required>
                    <option value="">-- Chọn Lịch Buổi Nhóm --</option>
                    @foreach ($lichBuoiNhoms as $lich)
                        <option value="{{ $lich->id }}" {{ $buoiNhom->lich_buoi_nhom_id == $lich->id ? 'selected' : '' }}>{{ $lich->ten }}</option>
                    @endforeach
                </select>
                @error('lich_buoi_nhom_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="ngay_dien_ra" class="form-label">Ngày Diễn Ra</label>
                <input type="date" class="form-control" id="ngay_dien_ra" name="ngay_dien_ra" value="{{ $buoiNhom->ngay_dien_ra->format('Y-m-d') }}" required>
                @error('ngay_dien_ra')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="gio_bat_dau" class="form-label">Giờ Bắt Đầu</label>
                <input type="time" class="form-control" id="gio_bat_dau" name="gio_bat_dau" value="{{ $buoiNhom->gio_bat_dau->format('H:i') }}" required>
                @error('gio_bat_dau')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="gio_ket_thuc" class="form-label">Giờ Kết Thúc</label>
                <input type="time" class="form-control" id="gio_ket_thuc" name="gio_ket_thuc" value="{{ $buoiNhom->gio_ket_thuc->format('H:i') }}" required>
                @error('gio_ket_thuc')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="dia_diem" class="form-label">Địa Điểm</label>
                <textarea class="form-control" id="dia_diem" name="dia_diem" required>{{ $buoiNhom->dia_diem }}</textarea>
                @error('dia_diem')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="chu_de" class="form-label">Chủ Đề</label>
                <input type="text" class="form-control" id="chu_de" name="chu_de" value="{{ $buoiNhom->chu_de }}">
                @error('chu_de')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="kinh_thanh" class="form-label">Kinh Thánh</label>
                <input type="text" class="form-control" id="kinh_thanh" name="kinh_thanh" value="{{ $buoiNhom->kinh_thanh }}">
                @error('kinh_thanh')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="cau_goc" class="form-label">Câu Gốc</label>
                <input type="text" class="form-control" id="cau_goc" name="cau_goc" value="{{ $buoiNhom->cau_goc }}">
                @error('cau_goc')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="id_to" class="form-label">Tổ</label>
                <select class="form-control" id="id_to" name="id_to">
                    <option value="">-- Chọn Tổ (nếu có) --</option>
                    @foreach ($buoiNhomsTo as $to)
                        <option value="{{ $to->id }}" {{ $buoiNhom->id_to == $to->id ? 'selected' : '' }}>{{ $to->ten_to }}</option>
                    @endforeach
                </select>
                @error('id_to')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="so_luong_trung_lao" class="form-label">Số Lượng Trung Lão</label>
                <input type="number" class="form-control" id="so_luong_trung_lao" name="so_luong_trung_lao" value="{{ $buoiNhom->so_luong_trung_lao }}">
                @error('so_luong_trung_lao')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="so_luong_thanh_trang" class="form-label">Số Lượng Thanh Tráng</label>
                <input type="number" class="form-control" id="so_luong_thanh_trang" name="so_luong_thanh_trang" value="{{ $buoiNhom->so_luong_thanh_trang }}">
                @error('so_luong_thanh_trang')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="so_luong_thanh_nien" class="form-label">Số Lượng Thanh Niên</label>
                <input type="number" class="form-control" id="so_luong_thanh_nien" name="so_luong_thanh_nien" value="{{ $buoiNhom->so_luong_thanh_nien }}">
                @error('so_luong_thanh_nien')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="so_luong_thieu_nhi_au" class="form-label">Số Lượng Thiếu Nhi Âu</label>
                <input type="number" class="form-control" id="so_luong_thieu_nhi_au" name="so_luong_thieu_nhi_au" value="{{ $buoiNhom->so_luong_thieu_nhi_au }}">
                @error('so_luong_thieu_nhi_au')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="so_luong_tin_huu_khac" class="form-label">Số Lượng Tín Hữu Khác</label>
                <input type="number" class="form-control" id="so_luong_tin_huu_khac" name="so_luong_tin_huu_khac" value="{{ $buoiNhom->so_luong_tin_huu_khac }}">
                @error('so_luong_tin_huu_khac')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="so_luong_tin_huu" class="form-label">Tổng Số Tín Hữu</label>
                <input type="number" class="form-control" id="so_luong_tin_huu" name="so_luong_tin_huu" value="{{ $buoiNhom->so_luong_tin_huu }}">
                @error('so_luong_tin_huu')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="so_luong_than_huu" class="form-label">Số Lượng Thân Hữu</label>
                <input type="number" class="form-control" id="so_luong_than_huu" name="so_luong_than_huu" value="{{ $buoiNhom->so_luong_than_huu }}">
                @error('so_luong_than_huu')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="so_nguoi_tin_chua" class="form-label">Số Người Tin Chúa</label>
                <input type="number" class="form-control" id="so_nguoi_tin_chua" name="so_nguoi_tin_chua" value="{{ $buoiNhom->so_nguoi_tin_chua }}">
                @error('so_nguoi_tin_chua')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="trang_thai" class="form-label">Trạng Thái</label>
                <select class="form-control" id="trang_thai" name="trang_thai">
                    <option value="sap_dien_ra" {{ $buoiNhom->trang_thai == 'sap_dien_ra' ? 'selected' : '' }}>Sắp Diễn Ra</option>
                    <option value="da_dien_ra" {{ $buoiNhom->trang_thai == 'da_dien_ra' ? 'selected' : '' }}>Đã Diễn Ra</option>
                    <option value="huy" {{ $buoiNhom->trang_thai == 'huy' ? 'selected' : '' }}>Hủy</option>
                </select>
                @error('trang_thai')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="ghi_chu" class="form-label">Ghi Chú</label>
                <textarea class="form-control" id="ghi_chu" name="ghi_chu">{{ $buoiNhom->ghi_chu }}</textarea>
                @error('ghi_chu')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
            <a href="{{ route('buoi_nhom.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>
@endsection