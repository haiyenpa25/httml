@extends('layouts.app')

@section('title', 'Chi tiết Lớp học: ' . $lopHoc->ten_lop)

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Chi tiết Lớp học: {{ $lopHoc->ten_lop }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('lop-hoc.index') }}">Lớp học</a></li>
                        <li class="breadcrumb-item active">Chi tiết</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Thông báo -->
            <div id="alert-container">
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
            </div>

            <!-- Thông tin lớp học -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-book"></i> Thông tin Lớp học</h3>
                    <div class="card-tools">
                        @can('edit-lop-hoc')
                            <a href="{{ route('lop-hoc.edit', $lopHoc) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                        @endcan
                        @can('delete-lop-hoc')
                            <button class="btn btn-danger btn-sm btn-xoa-lop-hoc" data-lop-hoc-id="{{ $lopHoc->id }}" data-ten-lop="{{ $lopHoc->ten_lop }}">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered child-row-table">
                        <tr>
                            <td style="width: 200px"><strong>Tên lớp:</strong></td>
                            <td>{{ $lopHoc->ten_lop }}</td>
                        </tr>
                        <tr>
                            <td><strong>Loại lớp:</strong></td>
                            <td>
                                {{ [
                                    'bap_tem' => 'Lớp Báp-têm',
                                    'thanh_nien' => 'Thanh niên',
                                    'trung_lao' => 'Trung lão',
                                    'khac' => 'Khác'
                                ][$lopHoc->loai_lop] ?? $lopHoc->loai_lop }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Thời gian bắt đầu:</strong></td>
                            <td>{{ $lopHoc->thoi_gian_bat_dau ? $lopHoc->thoi_gian_bat_dau->format('d/m/Y H:i') : 'Chưa cập nhật' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Thời gian kết thúc:</strong></td>
                            <td>{{ $lopHoc->thoi_gian_ket_thuc ? $lopHoc->thoi_gian_ket_thuc->format('d/m/Y H:i') : 'Chưa cập nhật' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tần suất:</strong></td>
                            <td>{{ $lopHoc->tan_suat == 'co_dinh' ? 'Cố định' : 'Linh hoạt' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Địa điểm:</strong></td>
                            <td>{{ $lopHoc->dia_diem ?? 'Chưa cập nhật' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Mô tả:</strong></td>
                            <td>{{ $lopHoc->mo_ta ?? 'Chưa cập nhật' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Danh sách học viên và giáo viên -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-users"></i> Danh sách Thành viên</h3>
                    <div class="card-tools">
                        @can('manage-hoc-vien')
                            <button class="btn btn-primary btn-sm btn-them-hoc-vien" data-lop-hoc-id="{{ $lopHoc->id }}" data-toggle="modal" data-target="#themHocVienModal">
                                <i class="fas fa-user-plus"></i> Thêm Thành viên
                            </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table id="thanh-vien-table" class="table table-bordered table-striped w-100">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên tín hữu</th>
                                <th>Vai trò</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <!-- Modal Thêm Thành viên -->
            <div class="modal fade" id="themHocVienModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Thêm Thành viên vào Lớp học</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form id="form-them-hoc-vien" method="POST" action="{{ route('lop-hoc.them-hoc-vien', $lopHoc) }}">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="tin_huu_id">Tín hữu <span class="text-danger">*</span></label>
                                    <select name="tin_huu_id" id="tin_huu_id" class="form-control select2bs4" required>
                                        <option value="">-- Chọn tín hữu --</option>
                                    </select>
                                    @error('tin_huu_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="vai_tro">Vai trò <span class="text-danger">*</span></label>
                                    <select name="vai_tro" id="vai_tro" class="form-control select2bs4" required>
                                        <option value="hoc_vien" selected>Học viên</option>
                                        <option value="giao_vien">Giáo viên</option>
                                    </select>
                                    @error('vai_tro')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Hủy</button>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-scripts')
    <script>
        $(function () {
            // Khởi tạo DataTable cho danh sách thành viên
            let thanhVienTable = $('#thanh-vien-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route("lop-hoc.thanh-vien", $lopHoc->id) }}',
                    type: 'GET',
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Không thể tải danh sách thành viên.');
                    }
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    { data: 'ho_ten', name: 'ho_ten' },
                    {
                        data: 'vai_tro',
                        name: 'vai_tro',
                        render: function (data) {
                            return data == 'hoc_vien' ? 'Học viên' : 'Giáo viên';
                        }
                    },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                                @can('manage-hoc-vien')
                                    <button class="btn btn-danger btn-sm btn-xoa-thanh-vien" data-tin-huu-id="${row.tin_huu_id}" title="Xóa">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                @endcan
                            `;
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    url: '{{ asset("dist/js/Vietnamese.json") }}'
                },
                order: [],
                pageLength: 10
            });

            // Khởi tạo Select2 với AJAX cho tín hữu
            $('#tin_huu_id').select2({
                theme: 'bootstrap4',
                placeholder: '-- Chọn tín hữu --',
                allowClear: true,
                minimumInputLength: 2,
                ajax: {
                    url: '{{ route("tin-huu.search") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.items.map(item => ({
                                id: item.id,
                                text: item.ho_ten
                            })),
                            pagination: {
                                more: data.hasMore
                            }
                        };
                    },
                    cache: true
                }
            });

            // Xử lý xóa thành viên
            $('#thanh-vien-table').on('click', '.btn-xoa-thanh-vien', function () {
                if (!confirm('Bạn có chắc chắn muốn xóa thành viên này khỏi lớp học?')) {
                    return;
                }

                const tinHuuId = $(this).data('tin-huu-id');
                $.ajax({
                    url: '{{ route("lop-hoc.xoa-hoc-vien", [$lopHoc, ""]) }}/' + tinHuuId,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            thanhVienTable.ajax.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi khi xóa thành viên!');
                        }
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!');
                    }
                });
            });

            // Xử lý thêm thành viên
            $('#form-them-hoc-vien').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('#form-them-hoc-vien button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#themHocVienModal').modal('hide');
                            thanhVienTable.ajax.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi khi thêm thành viên!');
                        }
                    },
                    error: function (xhr) {
                        let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                        if (xhr.responseJSON?.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        $('#form-them-hoc-vien button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save"></i> Lưu');
                    }
                });
            });
        });
    </script>
@endsection