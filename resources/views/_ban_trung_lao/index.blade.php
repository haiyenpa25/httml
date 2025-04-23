@extends('layouts.app')

@section('title', 'Ban Trung Lão')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Ban Trung Lão</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('_ban_nganh.index') }}">Ban Ngành</a></li>
                    <li class="breadcrumb-item active">Ban Trung Lão</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Thông báo thành công hoặc lỗi -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Thành công!</h5>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
            {{ session('error') }}
        </div>
    @endif

    <!-- Các nút chức năng -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <div class="btn-group">
                        <a href="{{ route('_ban_trung_lao.index') }}" class="btn btn-primary">
                            <i class="fas fa-home"></i> Trang chính
                        </a>
                        <a href="{{ route('_ban_trung_lao.diem_danh') }}" class="btn btn-success">
                            <i class="fas fa-clipboard-check"></i> Điểm danh
                        </a>
                        <a href="{{ route('_ban_trung_lao.tham_vieng') }}" class="btn btn-info">
                            <i class="fas fa-user-friends"></i> Thăm viếng
                        </a>
                        <a href="{{ route('_ban_trung_lao.phan_cong') }}" class="btn btn-warning">
                            <i class="fas fa-tasks"></i> Phân công
                        </a>
                        <a href="{{ route('_ban_trung_lao.phan_cong_chi_tiet') }}" class="btn btn-info">
                            <i class="fas fa-tasks"></i> Phân công chi tiết
                        </a>
                        <a href="{{ route('_bao_cao.form_ban_trung_lao') }}" class="btn btn-success">
                            <i class="fas fa-tasks"></i> Nhập liệu báo cáo
                        </a>
                    </div>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-them-thanh-vien">
                        <i class="fas fa-user-plus"></i> Thêm thành viên
                    </button>
                </div>
            </div>
        </div>
    </div>

        <!-- Ban Điều Hành -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-tie"></i>
                    Ban Điều Hành
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px">STT</th>
                            <th>Vai trò</th>
                            <th>Họ tên</th>
                            <th style="width: 120px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($banDieuHanh as $index => $thanhVien)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $thanhVien->chuc_vu }}</td>
                            <td>{{ $thanhVien->tinHuu->ho_ten }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit-chuc-vu"
                                       data-id="{{ $thanhVien->tinHuu->id }}"
                                       data-ban-id="{{ $banTrungLao->id }}"
                                       data-ten="{{ $thanhVien->tinHuu->ho_ten }}"
                                       data-chucvu="{{ $thanhVien->chuc_vu }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-xoa-thanh-vien"
                                       data-id="{{ $thanhVien->tinHuu->id }}"
                                       data-ban-id="{{ $banTrungLao->id }}"
                                       data-ten="{{ $thanhVien->tinHuu->ho_ten }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Không có dữ liệu</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Danh sách Ban viên -->
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-users"></i>
                    Danh sách Ban viên
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px">STT</th>
                            <th>Họ tên</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th style="width: 120px">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($banVien as $index => $thanhVien)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $thanhVien->tinHuu->ho_ten }}</td>
                            <td>{{ $thanhVien->tinHuu->so_dien_thoai }}</td>
                            <td>{{ $thanhVien->tinHuu->dia_chi }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-edit-chuc-vu"
                                       data-id="{{ $thanhVien->tinHuu->id }}"
                                       data-ban-id="{{ $banTrungLao->id }}"
                                       data-ten="{{ $thanhVien->tinHuu->ho_ten }}"
                                       data-chucvu="{{ $thanhVien->chuc_vu }}">
                                    <i class="fas fa-user-tag"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-xoa-thanh-vien"
                                       data-id="{{ $thanhVien->tinHuu->id }}"
                                       data-ban-id="{{ $banTrungLao->id }}"
                                       data-ten="{{ $thanhVien->tinHuu->ho_ten }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Không có dữ liệu</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- Modal Thêm Thành Viên -->
<div class="modal fade" id="modal-them-thanh-vien">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm Thành Viên</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('api.ban_trung_lao.them_thanh_vien') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="ban_nganh_id" value="{{ $banTrungLao->id }}">
                    
                    <div class="form-group">
                        <label for="tin_huu_id">Chọn Tín Hữu <span class="text-danger">*</span></label>
                        <select class="form-control select2bs4" name="tin_huu_id" id="tin_huu_id" required>
                            <option value="">-- Chọn Tín Hữu --</option>
                            @foreach($tinHuuList as $tinHuu)
                                <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="chuc_vu">Chức Vụ</label>
                        <select class="form-control" name="chuc_vu" id="chuc_vu">
                            <option value="">-- Thành viên --</option>
                            <option value="Cố Vấn Linh Vụ">Cố Vấn Linh Vụ</option>
                            <option value="Trưởng Ban">Trưởng Ban</option>
                            <option value="Thư Ký">Thư Ký</option>
                            <option value="Thủ Quỹ">Thủ Quỹ</option>
                            <option value="Ủy Viên">Ủy Viên</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal Cập Nhật Chức Vụ -->
<!-- Modal Cập Nhật Chức Vụ (cần sửa) -->
<div class="modal fade" id="modal-edit-chuc-vu">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cập Nhật Chức Vụ</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('api.ban_trung_lao.cap_nhat_chuc_vu') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                  <input type="hidden" name="tin_huu_id"    id="edit_tin_huu_id">
                  <input type="hidden" name="ban_nganh_id"  id="edit_ban_nganh_id">
                  
                  <div class="form-group">
                    <label>Tín Hữu</label>
                    <p id="edit_ten_tin_huu" class="form-control-static font-weight-bold"></p>
                  </div>
                  
                  <div class="form-group">
                    <label for="edit_chuc_vu">Chức Vụ</label>
                    <select class="form-control" name="chuc_vu" id="edit_chuc_vu">
                      <option value="">-- Thành viên --</option>
                      <option value="Cố Vấn Linh Vụ">Cố Vấn Linh Vụ</option>
                      <option value="Trưởng Ban">Trưởng Ban</option>
                      <option value="Thư Ký">Thư Ký</option>
                      <option value="Thủ Quỹ">Thủ Quỹ</option>
                      <option value="Ủy Viên">Ủy Viên</option>
                    </select>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                  <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
              </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal Xóa Thành Viên -->
<div class="modal fade" id="modal-xoa-thanh-vien">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Xóa Thành Viên</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('api.ban_trung_lao.xoa_thanh_vien') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" name="tin_huu_id" id="delete_tin_huu_id">
                    <input type="hidden" name="ban_nganh_id" id="delete_ban_nganh_id">
                    
                    <p>Bạn có chắc chắn muốn xóa thành viên <span id="delete_ten_tin_huu" class="font-weight-bold"></span> khỏi Ban Trung Lão?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection

@push('scripts')
<script>
    $(function () {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
        
        // Xử lý dữ liệu cho modal chỉnh sửa
        $('#modal-edit-chuc-vu').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var banId = button.data('ban-id');
            var ten = button.data('ten');
            var chucVu = button.data('chucvu');
            
            var modal = $(this);
            modal.find('#edit_tin_huu_id').val(id);
            modal.find('#edit_ban_nganh_id').val(banId);
            modal.find('#edit_ten_tin_huu').text(ten);
            modal.find('#edit_chuc_vu').val(chucVu);
        });
        
        // Xử lý dữ liệu cho modal xóa
        $('#modal-xoa-thanh-vien').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var banId = button.data('ban-id');
            var ten = button.data('ten');
            
            var modal = $(this);
            modal.find('#delete_tin_huu_id').val(id);
            modal.find('#delete_ban_nganh_id').val(banId);
            modal.find('#delete_ten_tin_huu').text(ten);
        });
    });
</script>
@endpush