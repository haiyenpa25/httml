@extends('layouts.app')

@section('title', 'Danh Sách Ban Ngành')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h1>Danh Sách Ban Ngành</h1>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách ban ngành</h3>
                <div class="card-tools">
                    <a href="{{ route('_ban_nganh.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Thêm Mới
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tên</th>
                            <th>Loại</th>
                            <th>Trưởng Ban</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banNganhs as $item)
                            <tr>
                                <td>{{ $item->ten }}</td>
                                <td>{{ $item->loai }}</td>
                                <td>{{ optional($item->truongBan)->ho_ten }}</td>
                                <td>
                                    <a href="{{ route('_ban_nganh.show', $item->id) }}" class="btn btn-sm btn-info">Xem</a>
                                    <a href="{{ route('_ban_nganh.edit', $item->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                    <form action="{{ route('_ban_nganh.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
