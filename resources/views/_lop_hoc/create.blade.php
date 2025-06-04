@extends('layouts.app')

@section('title', 'Tạo Lớp học')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tạo Lớp học</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('lop-hoc.index') }}">Lớp học</a></li>
                        <li class="breadcrumb-item active">Tạo</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-plus"></i> Thêm lớp học mới</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('lop-hoc.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="ten_lop">Tên lớp <span class="text-danger">*</span></label>
                            <input type="text" name="ten_lop" class="form-control" value="{{ old('ten_lop') }}" required>
                            @error('ten_lop')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="loai_lop">Loại lớp <span class="text-danger">*</span></label>
                            <select name="loai_lop" class="form-control select2bs4" required>
                                <option value="bap_tem" {{ old('loai_lop') == 'bap_tem' ? 'selected' : '' }}>Lớp Báp-têm</option>
                                <option value="thanh_nien" {{ old('loai_lop') == 'thanh_nien' ? 'selected' : '' }}>Thanh niên</option>
                                <option value="trung_lao" {{ old('loai_lop') == 'trung_lao' ? 'selected' : '' }}>Trung lão</option>
                                <option value="khac" {{ old('loai_lop') == 'khac' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('loai_lop')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="thoi_gian_bat_dau">Thời gian bắt đầu</label>
                            <input type="datetime-local" name="thoi_gian_bat_dau" class="form-control" value="{{ old('thoi_gian_bat_dau') }}">
                            @error('thoi_gian_bat_dau')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="thoi_gian_ket_thuc">Thời gian kết thúc</label>
                            <input type="datetime-local" name="thoi_gian_ket_thuc" class="form-control" value="{{ old('thoi_gian_ket_thuc') }}">
                            @error('thoi_gian_ket_thuc')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tan_suat">Tần suất <span class="text-danger">*</span></label>
                            <select name="tan_suat" class="form-control select2bs4" required>
                                <option value="co_dinh" {{ old('tan_suat') == 'co_dinh' ? 'selected' : '' }}>Cố định</option>
                                <option value="linh_hoat" {{ old('tan_suat') == 'linh_hoat' ? 'selected' : '' }}>Linh hoạt</option>
                            </select>
                            @error('tan_suat')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="dia_diem">Địa điểm <span class="text-danger">*</span></label>
                            <input type="text" name="dia_diem" class="form-control" value="{{ old('dia_diem') }}" required>
                            @error('dia_diem')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="mo_ta">Mô tả</label>
                            <textarea name="mo_ta" class="form-control">{{ old('mo_ta') }}</textarea>
                            @error('mo_ta')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-scripts')
    @include('_lop_hoc.scripts.lop_hoc')
@endsection