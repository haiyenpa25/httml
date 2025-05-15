@extends('layouts.app')
@section('title', 'Chỉnh Sửa Thân Hữu')

@section('content')
<section class="content-header">
    <h1>Chỉnh Sửa Thân Hữu</h1>
</section>
<section class="content">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('_than_huu.update', $thanHuu->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('_than_huu.form', ['prefix' => 'edit_', 'thanHuu' => $thanHuu, 'tinHuus' => $tinHuus])
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    <a href="{{ route('_than_huu.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
$(function () {
    // Điền dữ liệu vào form
    $('#edit_ho_ten').val('{{ $thanHuu->ho_ten }}');
    $('#edit_nam_sinh').val('{{ $thanHuu->nam_sinh }}');
    $('#edit_so_dien_thoai').val('{{ $thanHuu->so_dien_thoai }}');
    $('#edit_dia_chi').val('{{ $thanHuu->dia_chi }}');
    $('#edit_tin_huu_gioi_thieu_id').val('{{ $thanHuu->tin_huu_gioi_thieu_id }}');
    $('#edit_trang_thai').val('{{ $thanHuu->trang_thai }}');
    $('#edit_ghi_chu').val('{{ $thanHuu->ghi_chu }}');
});
</script>
@endpush
@endsection