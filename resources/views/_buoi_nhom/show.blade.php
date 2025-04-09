@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Chi Tiết Buổi Nhóm</h2>
        <div class="mb-3">
            <strong>ID:</strong> {{ $buoiNhom->id }}
        </div>
        <div class="mb-3">
            <strong>Lịch Buổi Nhóm:</strong> {{ $buoiNhom->lichBuoiNhom->ten ?? 'N/A' }}
        </div>
        <div class="mb-3">
            <strong>Ngày Diễn Ra:</strong> {{ $buoiNhom->ngay_dien_ra->format('d/m/Y') }}
        </div>
        <div class="mb-3">
            <strong>Giờ Bắt Đầu:</strong> {{ $buoiNhom->gio_bat_dau->format('H:i') }}
        </div>
        <div class="mb-3">
            <strong>Giờ Kết Thúc:</strong> {{ $buoiNhom->gio_ket_thuc->format('H:i') }}
        </div>
        <div class="mb-3">
            <strong>Địa Điểm:</strong> {{ $buoiNhom->dia_diem }}
        </div>
        <div class="mb-3">
            <strong>Chủ Đề:</strong> {{ $buoiNhom->chu_de ?? 'N/A' }}
        </div>
        <div class="mb-3">
            <strong>Kinh Thánh:</strong> {{ $buoiNhom->kinh_thanh ?? 'N/A' }}
        </div>
        <div class="mb-3">
            <strong>Câu Gốc:</strong> {{ $buoiNhom->cau_goc ?? 'N/A' }}
        </div>
        <div class="mb-3">
            <strong>Số Lượng Trung Lão:</strong> {{ $buoiNhom->so_luong_trung_lao }}
        </div>
        <div class="mb-3">
            <strong>Số Lượng Thanh Tráng:</strong> {{ $buoiNhom->so_luong_thanh_trang }}
        </div>
        <div class="mb-3">
            <strong>Số Lượng Thanh Niên:</strong> {{ $buoiNhom->so_luong_thanh_nien }}
        </div>
        <div class="mb-3">
            <strong>Số Lượng Thiếu Nhi Âu:</strong> {{ $buoiNhom->so_luong_thieu_nhi_au }}
        </div>
        <div class="mb-3">
            <strong>Số Lượng Tín Hữu Khác:</strong> {{ $buoiNhom->so_luong_tin_huu_khac }}
        </div>
        <div class="mb-3">
            <strong>Tổng Số Tín Hữu:</strong> {{ $buoiNhom->so_luong_tin_huu }}
        </div>
        <div class="mb-3">
            <strong>Số Lượng Thân Hữu:</strong> {{ $buoiNhom->so_luong_than_huu }}
        </div>
        <div class="mb-3">
            <strong>Số Người Tin Chúa:</strong> {{ $buoiNhom->so_nguoi_tin_chua }}
        </div>
        <div class="mb-3">
            <strong>Tổ:</strong> {{ $buoiNhom->to->ten_to ?? 'N/A' }}
        </div>
        {{-- Hiển thị thông tin các trường ID khác nếu cần --}}
        <div class="mb-3">
            <strong>Trạng Thái:</strong> {{ $buoiNhom->trang_thai }}
        </div>
        <div class="mb-3">
            <strong>Ghi Chú:</strong> {{ $buoiNhom->ghi_chu ?? 'N/A' }}
        </div>

        <a href="{{ route('buoi_nhom.index') }}" class="btn btn-secondary">Quay lại</a>
        <a href="{{ route('buoi_nhom.edit', $buoiNhom->id) }}" class="btn btn-warning">Sửa</a>
    </div>
@endsection