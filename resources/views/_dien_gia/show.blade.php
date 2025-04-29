@extends('layouts.app')
@section('title', 'Chi Tiết Diễn Giả')

@section('content')
<section class="content-header"><h1>Chi Tiết Diễn Giả</h1></section>
<section class="content">
    <table class="table table-bordered">
        <tr><th>Họ Tên</th><td>{{ $dienGia->ho_ten }}</td></tr>
        <tr><th>Chức Danh</th><td>{{ $dienGia->chuc_danh }}</td></tr>
        <tr><th>Hội Thánh</th><td>{{ $dienGia->hoi_thanh }}</td></tr>
        <tr><th>Địa Chỉ</th><td>{{ $dienGia->dia_chi }}</td></tr>
        <tr><th>SĐT</th><td>{{ $dienGia->so_dien_thoai }}</td></tr>
    </table>
    <a href="{{ route('_dien_gia.edit', $dienGia->id) }}" class="btn btn-warning">Sửa</a>
    <a href="{{ route('_dien_gia.index') }}" class="btn btn-secondary">Quay lại</a>
</section>
@endsection
