@extends('layouts.app')
@section('title', 'Chi Tiết Thân Hữu')

@section('content')
<section class="content-header">
    <h1>Chi Tiết Thân Hữu</h1>
</section>
<section class="content">
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th>Họ Tên</th><td>{{ $thanHuu->ho_ten }}</td></tr>
                <tr><th>Năm Sinh</th><td>{{ $thanHuu->nam_sinh }}</td></tr>
                <tr><th>Số Điện Thoại</th><td>{{ $thanHuu->so_dien_thoai ?: '(Không có)' }}</td></tr>
                <tr><th>Địa Chỉ</th><td>{{ $thanHuu->dia_chi ?: '(Không có)' }}</td></tr>
                <tr><th>Tín Hữu Giới Thiệu</th><td>{{ $thanHuu->tinHuuGioiThieu ? $thanHuu->tinHuuGioiThieu->ho_ten : '(Không có)' }}</td></tr>
                <tr><th>Trạng Thái</th><td>
                    @php
                        $labels = [
                            'chua_tin' => 'Chưa tin',
                            'da_tham_gia' => 'Đã tham gia',
                            'da_tin_chua' => 'Đã tin Chúa'
                        ];
                    @endphp
                    {{ $labels[$thanHuu->trang_thai] ?? $thanHuu->trang_thai }}
                </td></tr>
                <tr><th>Ghi Chú</th><td>{{ $thanHuu->ghi_chu ?: '(Không có)' }}</td></tr>
            </table>
            <div class="mt-3">
                <a href="{{ route('_than_huu.edit', $thanHuu->id) }}" class="btn btn-warning">Sửa</a>
                <a href="{{ route('_than_huu.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
</section>
@endsection