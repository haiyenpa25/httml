@extends('layouts.app')

@section('title', 'Sửa Thông Tin Ban Ngành')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <h1>Sửa Thông Tin Ban Ngành</h1>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Thông Tin Ban Ngành</h3>
            </div>

            {{-- Sửa action route truyền đúng tên tham số --}}
            <form action="{{ route('_ban_nganh.update', ['danh_sach' => $banNganh->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group">
                        <label for="ten">Tên Ban Ngành</label>
                        <input type="text" class="form-control" name="ten" id="ten" value="{{ old('ten', $banNganh->ten) }}">
                    </div>

                    <div class="form-group">
                        <label>Loại</label>
                        <select class="form-control" name="loai">
                            <option value="sinh_hoat" {{ $banNganh->loai == 'sinh_hoat' ? 'selected' : '' }}>Sinh Hoạt</option>
                            <option value="muc_vu" {{ $banNganh->loai == 'muc_vu' ? 'selected' : '' }}>Mục Vụ</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="mo_ta">Mô Tả</label>
                        <textarea class="form-control" name="mo_ta" id="mo_ta">{{ old('mo_ta', $banNganh->mo_ta) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Trưởng Ban</label>
                        <select class="form-control select2" name="truong_ban_id">
                            <option value="">-- Chọn Trưởng Ban --</option>
                            @foreach($tinHuus as $item)
                                <option value="{{ $item->id }}" {{ $banNganh->truong_ban_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->ho_ten }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cập Nhật</button>
                    <a href="{{ route('_ban_nganh.index') }}" class="btn btn-secondary">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
