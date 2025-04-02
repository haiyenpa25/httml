@extends('layouts.app')

@section('title', 'Thêm Mới Tín Hữu')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Thêm Mới Tín Hữu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Quản lý Tín Hữu</a></li>
                        <li class="breadcrumb-item active">Thêm Mới</li>
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
                            <h3 class="card-title">Thông Tin Tín Hữu</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('_tin_huu.store') }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="ho_ten">Họ và Tên</label>
                                    <input type="text" class="form-control" id="ho_ten" name="ho_ten" placeholder="Nhập họ và tên">
                                </div>


                                
                                <div class="form-group">
                                    <label>Ngày Sinh:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask name="ngay_sinh">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="dia_chi">Địa Chỉ</label>
                                    <textarea class="form-control" id="dia_chi" name="dia_chi" rows="3" placeholder="Nhập địa chỉ"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="so_dien_thoai">Số Điện Thoại</label>
                                    <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại">
                                </div>

                                <div class="form-group">
                                    <label>Loại Tín Hữu</label>
                                    <select class="form-control select2" style="width: 100%;" name="loai_tin_huu">
                                        <option value="tin_huu_chinh_thuc">Tín Hữu Chính Thức</option>
                                        <option value="tan_tin_huu">Tân Tín Hữu</option>
                                        <option value="tin_huu_ht_khac">Tín Hữu HT Khác</option>
                                    </select>
                                </div>

                                  <div class="form-group">
                                    <label>Hộ gia đình</label>
                                    <select class="form-control select2" style="width: 100%;" name="ho_gia_dinh_id">
                                       <option value="">--Chọn--</option>
                                       @foreach($hoGiaDinhs as $item)
                                        <option value="{{$item->id}}">{{$item->so_ho}}</option>
                                       @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Giới Tính</label>
                                    <select class="form-control select2" style="width: 100%;" name="gioi_tinh">
                                        <option value="nam">Nam</option>
                                        <option value="nu">Nữ</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Tình Trạng Hôn Nhân</label>
                                    <select class="form-control select2" style="width: 100%;" name="tinh_trang_hon_nhan">
                                        <option value="doc_than">Độc Thân</option>
                                        <option value="ket_hon">Kết Hôn</option>
                                    </select>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Lưu</button>
                                <a href="{{ route('_tin_huu.index') }}" class="btn btn-secondary">Hủy</a>
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

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
    </script>
@endpush