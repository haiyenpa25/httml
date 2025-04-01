@extends('layouts.app')

@section('title', 'Chỉnh Sửa Người Dùng')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chỉnh Sửa Người Dùng</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Quản lý Người Dùng</a></li>
                        <li class="breadcrumb-item active">Chỉnh Sửa</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thông Tin Người Dùng</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('nguoi-dung.update', $nguoiDung->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Tín Hữu</label>
                                    <select class="form-control select2" style="width: 100%;" name="tin_huu_id">
                                        @foreach($tinHuuS as $tinHuu)
                                            <option value="{{ $tinHuu->id }}" {{ $nguoiDung->tin_huu_id == $tinHuu->id ? 'selected' : '' }}>{{ $tinHuu->ho_ten }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $nguoiDung->email }}" placeholder="Nhập email">
                                </div>

                                <div class="form-group">
                                    <label for="mat_khau">Mật Khẩu (Để trống nếu không muốn thay đổi)</label>
                                    <input type="password" class="form-control" id="mat_khau" name="mat_khau" placeholder="Nhập mật khẩu mới">
                                </div>

                                <div class="form-group">
                                    <label>Vai Trò</label>
                                    <select class="form-control select2" style="width: 100%;" name="vai_tro">
                                        <option value="quan_tri" {{ $nguoiDung->vai_tro == 'quan_tri' ? 'selected' : '' }}>Quản Trị</option>
                                        <option value="truong_ban" {{ $nguoiDung->vai_tro == 'truong_ban' ? 'selected' : '' }}>Trưởng Ban</option>
                                        <option value="thanh_vien" {{ $nguoiDung->vai_tro == 'thanh_vien' ? 'selected' : '' }}>Thành Viên</option>
                                    </select>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Cập Nhật</button>
                                <a href="{{ route('nguoi-dung.index') }}" class="btn btn-secondary">Hủy</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        });
    </script>
@endpush