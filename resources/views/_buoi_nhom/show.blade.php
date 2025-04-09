@extends('layouts.app')
@section('title', 'Chi Tiết Buổi Nhóm')

@section('content')
    <div class="container">
        <h2>Chi Tiết Buổi Nhóm</h2>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thông tin chung</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Ngày Diễn Ra:</strong>
                    {{ $buoiNhom->ngay_dien_ra->format('d/m/Y') }}
                </div>
                <div class="mb-3">
                    <strong>Chủ Đề:</strong>
                    {{ $buoiNhom->chu_de ?? 'N/A' }}
                </div>
                <div class="mb-3">
                    <strong>Diễn Giả:</strong>
                    {{ $buoiNhom->dienGia->ho_ten ?? 'N/A' }}
                </div>
                <div class="mb-3">
                    <strong>Hướng Dẫn Chương Trình:</strong>
                    {{ $buoiNhom->nguoiHuongDan->ho_ten ?? 'N/A' }}
                </div>
                <div class="mb-3">
                    <strong>Số Lượng Tham Dự:</strong>
                    {{ $buoiNhom->so_luong_tin_huu ?? '0' }}
                </div>
                <div class="mb-3">
                    <strong>Dâng Hiến:</strong>
                    {{ $buoiNhom->dang_hien ?? '0' }} VNĐ
                </div>
            </div>
        </div>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Thông tin Thăm Viếng</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Người Thăm Viếng:</strong>
                    {{ $buoiNhom->nguoiThamVieng->ho_ten ?? 'N/A' }}
                </div>
                <div class="mb-3">
                    <strong>Lý Do Thăm Viếng:</strong>
                    {{ $buoiNhom->ly_do_tham_vieng ?? 'N/A' }}
                </div>
                <div class="mb-3">
                    <strong>Ngày Thăm Viếng:</strong>
                    {{ $buoiNhom->ngay_tham_vieng ? $buoiNhom->ngay_tham_vieng->format('d/m/Y') : 'N/A' }}
                </div>
            </div>
        </div>

        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Ý Kiến</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Hiện Trạng:</strong>
                    {{ $buoiNhom->hien_trang ?? 'N/A' }}
                </div>
                <div class="mb-3">
                    <strong>Đề Xuất:</strong>
                    {{ $buoiNhom->de_xuat ?? 'N/A' }}
                </div>
                <div class="mb-3">
                    <strong>Lưu Ý:</strong>
                    {{ $buoiNhom->luu_y ?? 'N/A' }}
                </div>
            </div>
        </div>

        <a href="{{ route('buoi_nhom.index') }}" class="btn btn-secondary">Quay lại</a>
    </div>
@endsection