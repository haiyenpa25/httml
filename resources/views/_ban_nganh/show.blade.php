@extends('layouts.app')

@section('title', 'Chi Tiết Ban Ngành')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h1>Chi Tiết Ban Ngành</h1>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Thông Tin Chi Tiết</h3></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr><th>Tên</th><td>{{ $banNganh->ten }}</td></tr>
                    <tr><th>Loại</th><td>{{ $banNganh->loai }}</td></tr>
                    <tr><th>Mô Tả</th><td>{{ $banNganh->mo_ta }}</td></tr>
                    <tr><th>Trưởng Ban</th><td>{{ optional($banNganh->truongBan)->ho_ten }}</td></tr>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('_ban_nganh.edit', $banNganh->id) }}" class="btn btn-primary">Sửa</a>
                <a href="{{ route('_ban_nganh.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
</section>
@endsection
