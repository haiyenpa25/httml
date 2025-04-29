@extends('layouts.app')

@section('title', 'Cảnh Báo Thiết Bị')@section('content')<!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cảnh Báo Thiết Bị</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('thiet-bi.index') }}">Thiết bị</a></li>
                        <li class="breadcrumb-item active">Cảnh báo</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Nút quay lại -->
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('thiet-bi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>

            <!-- Thiết bị cần bảo trì -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tools"></i>
                        Thiết bị cần bảo trì
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($thietBiCanBaoTri) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px">STT</th>
                                                <th>Tên thiết bị</th>
                                                <th>Loại</th>
                                                <th>Tình trạng</th>
                                                <th>Ban ngành quản lý</th>
                                                <th>Vị trí hiện tại</th>
                                                <th>Ngày bảo trì gần nhất</th>
                                                <th>Chu kỳ bảo trì</th>
                                                <th style="width: 100px">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($thietBiCanBaoTri as $index => $thietBi)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $thietBi->ten }}</td>
                                                                        <td>
                                                                            @php
                                                                                $loaiMap = [
                                                                                    'nhac_cu' => 'Nhạc cụ',
                                                                                    'anh_sang' => 'Ánh sáng',
                                                                                    'am_thanh' => 'Âm thanh',
                                                                                    'hinh_anh' => 'Hình ảnh',
                                                                                    'khac' => 'Khác'
                                                                                ];
                                                                            @endphp
                                                                            {{ $loaiMap[$thietBi->loai] ?? $thietBi->loai }}
                                                                        </td>
                                                                        <td>
                                                                            @php
                                                                                $tinhTrangMap = [
                                                                                    'tot' => '<span class="badge badge-success">Tốt</span>',
                                                                                    'hong' => '<span class="badge badge-danger">Hỏng</span>',
                                                                                    'dang_sua' => '<span class="badge badge-warning">Đang sửa</span>'
                                                                                ];
                                                                            @endphp
                                                                            {!! $tinhTrangMap[$thietBi->tinh_trang] ?? $thietBi->tinh_trang !!}
                                                                        </td>
                                                                        <td>{{ $thietBi->banNganh->ten ?? 'N/A' }}</td>
                                                                        <td>{{ $thietBi->vi_tri_hien_tai ?? 'N/A' }}</td>
                                                                        <td>
                                                                            @php
                                                                                $ngayBaoTriGanNhat = $thietBi->ngayBaoTriGanNhat();
                                                                            @endphp
                                                                            {{ $ngayBaoTriGanNhat ? date('d/m/Y', strtotime($ngayBaoTriGanNhat)) : 'Chưa bảo trì' }}
                                                                        </td>
                                                                        <td>{{ $thietBi->chu_ky_bao_tri ? $thietBi->chu_ky_bao_tri . ' ngày' : 'N/A' }}</td>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <a href="{{ route('thiet-bi.index') }}#detail-{{ $thietBi->id }}" class="btn btn-info btn-sm btn-view" data-id="{{ $thietBi->id }}">
                                                                                    <i class="fas fa-eye"></i>
                                                                                </a>
                                                                                <button type="button" class="btn btn-primary btn-sm btn-add-bao-tri" data-id="{{ $thietBi->id }}" data-name="{{ $thietBi->ten }}">
                                                                                    <i class="fas fa-plus"></i>
                                                                                </button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                    @else
                        <div class="alert alert-info">
                            <i class="icon fas fa-info-circle"></i> Không có thiết bị nào cần bảo trì.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Thiết bị sắp hết hạn bảo hành -->
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-triangle"></i>
                        Thiết bị sắp hết hạn bảo hành
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($thietBiSapHetHanBaoHanh) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px">STT</th>
                                                <th>Tên thiết bị</th>
                                                <th>Loại</th>
                                                <th>Tình trạng</th>
                                                <th>Ban ngành quản lý</th>
                                                <th>Vị trí hiện tại</th>
                                                <th>Thời gian bảo hành</th>
                                                <th>Ngày còn lại</th>
                                                <th style="width: 70px">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($thietBiSapHetHanBaoHanh as $index => $thietBi)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $thietBi->ten }}</td>
                                                                        <td>
                                                                            @php
                                                                                $loaiMap = [
                                                                                    'nhac_cu' => 'Nhạc cụ',
                                                                                    'anh_sang' => 'Ánh sáng',
                                                                                    'am_thanh' => 'Âm thanh',
                                                                                    'hinh_anh' => 'Hình ảnh',
                                                                                    'khac' => 'Khác'
                                                                                ];
                                                                            @endphp
                                                                            {{ $loaiMap[$thietBi->loai] ?? $thietBi->loai }}
                                                                        </td>
                                                                        <td>
                                                                            @php
                                                                                $tinhTrangMap = [
                                                                                    'tot' => '<span class="badge badge-success">Tốt</span>',
                                                                                    'hong' => '<span class="badge badge-danger">Hỏng</span>',
                                                                                    'dang_sua' => '<span class="badge badge-warning">Đang sửa</span>'
                                                                                ];
                                                                            @endphp
                                                                            {!! $tinhTrangMap[$thietBi->tinh_trang] ?? $thietBi->tinh_trang !!}
                                                                        </td>
                                                                        <td>{{ $thietBi->banNganh->ten ?? 'N/A' }}</td>
                                                                        <td>{{ $thietBi->vi_tri_hien_tai ?? 'N/A' }}</td>
                                                                        <td>{{ $thietBi->thoi_gian_bao_hanh ? date('d/m/Y', strtotime($thietBi->thoi_gian_bao_hanh)) : 'N/A' }}</td>
                                                                        <td>
                                                                            @php
                                                                                $ngayConLai = now()->diffInDays($thietBi->thoi_gian_bao_hanh, false);
                                                                            @endphp
                                                                            <span class="badge badge-{{ $ngayConLai <= 7 ? 'danger' : 'warning' }}">
                                                                                {{ $ngayConLai }} ngày
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{ route('thiet-bi.index') }}#detail-{{ $thietBi->id }}" class="btn btn-info btn-sm btn-view" data-id="{{ $thietBi->id }}">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                    @else
                        <div class="alert alert-info">
                            <i class="icon fas fa-info-circle"></i> Không có thiết bị nào sắp hết hạn bảo hành.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Thiết bị sắp hết hạn sử dụng -->
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-times"></i>
                        Thiết bị sắp hết hạn sử dụng
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($thietBiSapHetHanSuDung) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px">STT</th>
                                                <th>Tên thiết bị</th>
                                                <th>Loại</th>
                                                <th>Tình trạng</th>
                                                <th>Ban ngành quản lý</th>
                                                <th>Vị trí hiện tại</th>
                                                <th>Ngày hết hạn</th>
                                                <th>Ngày còn lại</th>
                                                <th style="width: 70px">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($thietBiSapHetHanSuDung as $index => $thietBi)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ $thietBi->ten }}</td>
                                                                        <td>
                                                                            @php
                                                                                $loaiMap = [
                                                                                    'nhac_cu' => 'Nhạc cụ',
                                                                                    'anh_sang' => 'Ánh sáng',
                                                                                    'am_thanh' => 'Âm thanh',
                                                                                    'hinh_anh' => 'Hình ảnh',
                                                                                    'khac' => 'Khác'
                                                                                ];
                                                                            @endphp
                                                                            {{ $loaiMap[$thietBi->loai] ?? $thietBi->loai }}
                                                                        </td>
                                                                        <td>
                                                                            @php
                                                                                $tinhTrangMap = [
                                                                                    'tot' => '<span class="badge badge-success">Tốt</span>',
                                                                                    'hong' => '<span class="badge badge-danger">Hỏng</span>',
                                                                                    'dang_sua' => '<span class="badge badge-warning">Đang sửa</span>'
                                                                                ];
                                                                            @endphp
                                                                            {!! $tinhTrangMap[$thietBi->tinh_trang] ?? $thietBi->tinh_trang !!}
                                                                        </td>
                                                                        <td>{{ $thietBi->banNganh->ten ?? 'N/A' }}</td>
                                                                        <td>{{ $thietBi->vi_tri_hien_tai ?? 'N/A' }}</td>
                                                                        <td>{{ $thietBi->ngay_het_han_su_dung ? date('d/m/Y', strtotime($thietBi->ngay_het_han_su_dung)) : 'N/A' }}</td>
                                                                        <td>
                                                                            @php
                                                                                $ngayConLai = now()->diffInDays($thietBi->ngay_het_han_su_dung, false);
                                                                            @endphp
                                                                            <span class="badge badge-{{ $ngayConLai <= 7 ? 'danger' : 'warning' }}">
                                                                                {{ $ngayConLai }} ngày
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{ route('thiet-bi.index') }}#detail-{{ $thietBi->id }}" class="btn btn-info btn-sm btn-view" data-id="{{ $thietBi->id }}">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                    @else
                        <div class="alert alert-info">
                            <i class="icon fas fa-info-circle"></i> Không có thiết bị nào sắp hết hạn sử dụng.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Thêm Lịch Sử Bảo Trì Nhanh -->
    <div class="modal fade" id="modal-bao-tri-nhanh">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm Lịch Sử Bảo Trì</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="form-bao-tri-nhanh">
                    @csrf
                    <input type="hidden" id="bao_tri_thiet_bi_id" name="thiet_bi_id">
                    <div class="modal-body">
                        <p>Thiết bị: <strong id="bao_tri_ten_thiet_bi"></strong></p>

                        <div class="form-group">
                            <label for="ngay_bao_tri">Ngày Bảo Trì <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="ngay_bao_tri" name="ngay_bao_tri" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="chi_phi">Chi Phí (VNĐ)</label>
                            <input type="number" class="form-control" id="chi_phi" name="chi_phi" min="0" step="1000">
                        </div>
                        <div class="form-group">
                            <label for="nguoi_thuc_hien">Người Thực Hiện <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nguoi_thuc_hien" name="nguoi_thuc_hien" required>
                        </div>
                        <div class="form-group">
                            <label for="mo_ta_bao_tri">Mô Tả</label>
                            <textarea class="form-control" id="mo_ta_bao_tri" name="mo_ta" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script>
        $(document).ready(function() {
            // Xử lý thêm bảo trì nhanh
            $('.btn-add-bao-tri').click(function() {
                var id = $(this).data('id');
                var name = $(this).data('name');

                $('#bao_tri_thiet_bi_id').val(id);
                $('#bao_tri_ten_thiet_bi').text(name);
                $('#modal-bao-tri-nhanh').modal('show');
            });

            // Xử lý form thêm bảo trì nhanh
            $('#form-bao-tri-nhanh').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('lich-su-bao-tri.store') }}",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#modal-bao-tri-nhanh').modal('hide');
                            toastr.success(response.message);

                            // Reload trang sau khi thêm thành công
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('Có lỗi xảy ra. Vui lòng thử lại sau.');
                        }
                    }
                });
            });
        });
    </script>
@endsection