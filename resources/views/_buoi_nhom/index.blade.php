@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Danh sách Buổi Nhóm</h2>
        <a href="{{ route('buoi_nhom.create') }}" class="btn btn-primary mb-3">Thêm Buổi Nhóm</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Lịch Buổi Nhóm</th>
                    <th>Ngày Diễn Ra</th>
                    <th>Giờ Bắt Đầu</th>
                    <th>Giờ Kết Thúc</th>
                    <th>Địa Điểm</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($buoiNhoms as $buoiNhom)
                    <tr>
                        <td>{{ $buoiNhom->id }}</td>
                        <td>{{ $buoiNhom->lichBuoiNhom->ten ?? 'N/A' }}</td>
                        <td>{{ $buoiNhom->ngay_dien_ra->format('d/m/Y') }}</td>
                        <td>{{ $buoiNhom->gio_bat_dau->format('H:i') }}</td>
                        <td>{{ $buoiNhom->gio_ket_thuc->format('H:i') }}</td>
                        <td>{{ $buoiNhom->dia_diem }}</td>
                        <td>{{ $buoiNhom->trang_thai }}</td>
                        <td>
                            <a href="{{ route('buoi_nhom.show', $buoiNhom->id) }}" class="btn btn-info btn-sm">Xem</a>
                            <a href="{{ route('buoi_nhom.edit', $buoiNhom->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                            <form action="{{ route('buoi_nhom.destroy', $buoiNhom->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8">Không có buổi nhóm nào.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{ $buoiNhoms->links() }}
    </div>
@endsection