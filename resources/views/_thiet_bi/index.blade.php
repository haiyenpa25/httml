@extends('layouts.app')

@section('title', 'Quản lý Thiết Bị')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Quản lý Thiết Bị</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Thiết bị</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
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

            <!-- Các nút chức năng -->
            @include('_thiet_bi.partials.function_buttons')

            <!-- Bộ lọc nâng cao -->
            @include('_thiet_bi.partials.filters')

            <!-- Danh sách Thiết Bị -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tools"></i>
                        Danh sách Thiết Bị
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="thiet-bi-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 50px">STT</th>
                                <th>Tên thiết bị</th>
                                <th>Loại</th>
                                <th>Tình trạng</th>
                                <th>Ban Ngành</th>
                                <th>Vị trí</th>
                                <th>Mã tài sản</th>
                                <th style="width: 120px">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dữ liệu sẽ được nạp qua DataTables -->
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- Import modals -->
    @include('_thiet_bi.modals.them_thiet_bi')
    @include('_thiet_bi.modals.sua_thiet_bi')
    @include('_thiet_bi.modals.chi_tiet_thiet_bi')
    @include('_thiet_bi.modals.xoa_thiet_bi')
    @include('_thiet_bi.modals.bao_tri')
    @include('_thiet_bi.modals.xoa_bao_tri')

@endsection

@section('page-scripts')

    <script>
        $(document).ready(function () {
            // Initialize Select2
            $('.select2').select2();

            // Load danh sách người quản lý 
            loadTinHuuList('#nguoi_quan_ly_id, #edit_nguoi_quan_ly_id');

            // Load danh sách nhà cung cấp
            loadNhaCungCapList('#nha_cung_cap_id, #edit_nha_cung_cap_id');

            // DataTable thiết bị
            var table = $('#thiet-bi-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ route('thiet-bi.get-thiet-bis') }}",
                    data: function (d) {
                        d.loai = $('#filter-loai-thiet-bi').val();
                        d.tinh_trang = $('#filter-tinh-trang').val();
                        d.ban_nganh_id = $('#filter-ban-nganh').val();
                        d.vi_tri = $('#filter-vi-tri').val();
                    }
                },
                columns: [
                    { data: null, render: function (data, type, row, meta) { return meta.row + 1; } },
                    { data: 'ten' },
                    {
                        data: 'loai',
                        render: function (data) {
                            return formatLoaiThietBi(data);
                        }
                    },
                    {
                        data: 'tinh_trang',
                        render: function (data) {
                            return formatTinhTrang(data);
                        }
                    },
                    {
                        data: 'ban_nganh',
                        render: function (data) {
                            return data ? data.ten : 'N/A';
                        }
                    },
                    { data: 'vi_tri_hien_tai' },
                    { data: 'ma_tai_san' },
                    {
                        data: null,
                        render: function (data) {
                            return `
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm btn-detail" data-id="${data.id}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm btn-edit" data-id="${data.id}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${data.id}" data-name="${data.ten}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    `;
                        }
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json'
                }
            });

            // Làm mới bảng dữ liệu
            $('#btn-refresh').click(function () {
                table.ajax.reload();
            });

            // Lọc dữ liệu
            $('#filter-loai-thiet-bi, #filter-tinh-trang, #filter-ban-nganh').change(function () {
                table.ajax.reload();
            });

            $('#filter-vi-tri').on('keyup', debounce(function () {
                table.ajax.reload();
            }, 500));

            // Xử lý thêm thiết bị
            $('#form-thiet-bi').submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('thiet-bi.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            $('#modal-them-thiet-bi').modal('hide');
                            $('#form-thiet-bi')[0].reset();
                            table.ajax.reload();
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr) {
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

            // Xử lý sửa thiết bị
            $('#thiet-bi-table').on('click', '.btn-edit', function () {
                var id = $(this).data('id');

                // Lấy thông tin thiết bị
                $.ajax({
                    url: '/thiet-bi/' + id + '/edit',
                    type: 'GET',
                    success: function (response) {
                        $('#edit_id').val(response.id);
                        $('#edit_ten').val(response.ten);
                        $('#edit_ma_tai_san').val(response.ma_tai_san);
                        $('#edit_loai').val(response.loai);
                        $('#edit_tinh_trang').val(response.tinh_trang);
                        $('#edit_vi_tri_hien_tai').val(response.vi_tri_hien_tai);
                        $('#edit_id_ban').val(response.id_ban).trigger('change');
                        $('#edit_nguoi_quan_ly_id').val(response.nguoi_quan_ly_id).trigger('change');
                        $('#edit_nha_cung_cap_id').val(response.nha_cung_cap_id).trigger('change');
                        $('#edit_ngay_mua').val(response.ngay_mua);
                        $('#edit_gia_tri').val(response.gia_tri);
                        $('#edit_thoi_gian_bao_hanh').val(response.thoi_gian_bao_hanh);
                        $('#edit_chu_ky_bao_tri').val(response.chu_ky_bao_tri);
                        $('#edit_ngay_het_han_su_dung').val(response.ngay_het_han_su_dung);
                        $('#edit_mo_ta').val(response.mo_ta);

                        // Hiển thị hình ảnh nếu có
                        if (response.hinh_anh) {
                            $('#preview-hinh-anh').html('<img src="{{ asset('storage') }}/' + response.hinh_anh + '" class="img-fluid mt-2" style="max-height: 100px;">');
                        } else {
                            $('#preview-hinh-anh').html('');
                        }

                        $('#modal-sua-thiet-bi').modal('show');
                    },
                    error: function () {
                        toastr.error('Không thể lấy thông tin thiết bị. Vui lòng thử lại sau.');
                    }
                });
            });

            $('#form-sua-thiet-bi').submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                var id = $('#edit_id').val();

                $.ajax({
                    url: '/thiet-bi/' + id,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            $('#modal-sua-thiet-bi').modal('hide');
                            table.ajax.reload();
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr) {
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

            // Xem chi tiết thiết bị
            $('#thiet-bi-table').on('click', '.btn-detail', function () {
                var id = $(this).data('id');

                // Lấy thông tin thiết bị
                $.ajax({
                    url: '/thiet-bi/' + id,
                    type: 'GET',
                    success: function (response) {
                        // Hiển thị thông tin chi tiết
                        $('#detail_ten').text(response.ten);
                        $('#detail_ma_tai_san').text(response.ma_tai_san || 'N/A');
                        $('#detail_loai').text(formatLoaiThietBi(response.loai));
                        $('#detail_tinh_trang').text(response.tinh_trang === 'tot' ? 'Tốt' : (response.tinh_trang === 'hong' ? 'Hỏng' : 'Đang sửa'));

                        // Thông tin quản lý
                        $('#detail_ban_nganh').text(response.ban_nganh ? response.ban_nganh.ten : 'N/A');
                        $('#detail_nguoi_quan_ly').text(response.nguoi_quan_ly ? response.nguoi_quan_ly.ho_ten : 'N/A');
                        $('#detail_vi_tri').text(response.vi_tri_hien_tai || 'N/A');

                        // Thông tin mua
                        $('#detail_ngay_mua').text(response.ngay_mua ? formatDate(response.ngay_mua) : 'N/A');
                        $('#detail_gia_tri').text(response.gia_tri ? formatCurrency(response.gia_tri) : 'N/A');
                        $('#detail_nha_cung_cap').text(response.nha_cung_cap ? response.nha_cung_cap.ten_nha_cung_cap : 'N/A');

                        // Thông tin hạn sử dụng và bảo trì
                        $('#detail_bao_hanh').text(response.thoi_gian_bao_hanh ? formatDate(response.thoi_gian_bao_hanh) : 'N/A');
                        $('#detail_chu_ky_bao_tri').text(response.chu_ky_bao_tri ? response.chu_ky_bao_tri + ' ngày' : 'N/A');
                        $('#detail_ngay_het_han').text(response.ngay_het_han_su_dung ? formatDate(response.ngay_het_han_su_dung) : 'N/A');

                        // Mô tả
                        $('#detail_mo_ta').text(response.mo_ta || 'N/A');

                        // Hiển thị hình ảnh
                        if (response.hinh_anh) {
                            $('#detail_image').attr('src', '{{ asset('storage') }}/' + response.hinh_anh);
                        } else {
                            $('#detail_image').attr('src', '{{ asset('img/no-image.png') }}');
                        }

                        // Lưu ID thiết bị cho các chức năng khác
                        $('#bao_tri_thiet_bi_id').val(response.id);
                        $('#btn-edit-thiet-bi').data('id', response.id);

                        // Hiển thị lịch sử bảo trì
                        loadLichSuBaoTri(response.id, '#detail_bao_tri_list');

                        $('#modal-chi-tiet-thiet-bi').modal('show');
                    },
                    error: function () {
                        toastr.error('Không thể lấy thông tin thiết bị. Vui lòng thử lại sau.');
                    }
                });
            });

            // Nút chỉnh sửa từ chi tiết
            $('#btn-edit-thiet-bi').click(function () {
                var id = $(this).data('id');
                $('#modal-chi-tiet-thiet-bi').modal('hide');

                // Trigger click nút edit
                $('.btn-edit[data-id="' + id + '"]').click();
            });

            // Xử lý xóa thiết bị
            $('#thiet-bi-table').on('click', '.btn-delete', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                $('#delete_id').val(id);
                $('#delete_name').text(name);
                $('#modal-xoa-thiet-bi').modal('show');
            });

            $('#confirm-delete').click(function () {
                var id = $('#delete_id').val();

                $.ajax({
                    url: '/thiet-bi/' + id,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#modal-xoa-thiet-bi').modal('hide');
                            table.ajax.reload();
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Không thể xóa thiết bị. Vui lòng thử lại sau.');
                    }
                });
            });

            // Thêm lịch sử bảo trì
            $('#btn-add-bao-tri').click(function () {
                $('#bao-tri-title').text('Thêm Lịch Sử Bảo Trì');
                $('#bao_tri_id').val('');
                $('#form-bao-tri')[0].reset();
                $('#modal-bao-tri').modal('show');
            });

            // Chỉnh sửa lịch sử bảo trì
            $('#detail_bao_tri_list').on('click', '.btn-edit-bao-tri', function () {
                var id = $(this).data('id');

                $.ajax({
                    url: '/lich-su-bao-tri/' + id + '/edit',
                    type: 'GET',
                    success: function (response) {
                        $('#bao-tri-title').text('Sửa Lịch Sử Bảo Trì');
                        $('#bao_tri_id').val(response.id);
                        $('#ngay_bao_tri').val(response.ngay_bao_tri);
                        $('#chi_phi').val(response.chi_phi);
                        $('#nguoi_thuc_hien').val(response.nguoi_thuc_hien);
                        $('#mo_ta_bao_tri').val(response.mo_ta);
                        $('#modal-bao-tri').modal('show');
                    }
                });
            });

            // Xử lý form thêm/sửa lịch sử bảo trì
            $('#form-bao-tri').submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                var id = $('#bao_tri_id').val();
                var url = id ? '/lich-su-bao-tri/' + id : "{{ route('lich-su-bao-tri.store') }}";
                var method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            $('#modal-bao-tri').modal('hide');
                            toastr.success(response.message);
                            loadLichSuBaoTri($('#bao_tri_thiet_bi_id').val(), '#detail_bao_tri_list');
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr) {
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

            // Xóa lịch sử bảo trì
            $('#detail_bao_tri_list').on('click', '.btn-delete-bao-tri', function () {
                var id = $(this).data('id');
                $('#delete_bao_tri_id').val(id);
                $('#modal-xoa-bao-tri').modal('show');
            });

            $('#confirm-delete-bao-tri').click(function () {
                var id = $('#delete_bao_tri_id').val();

                $.ajax({
                    url: '/lich-su-bao-tri/' + id,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#modal-xoa-bao-tri').modal('hide');
                            toastr.success(response.message);
                            loadLichSuBaoTri($('#bao_tri_thiet_bi_id').val(), '#detail_bao_tri_list');
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Không thể xóa lịch sử bảo trì. Vui lòng thử lại sau.');
                    }
                });
            });

            // Reset form khi đóng modal
            $('#modal-them-thiet-bi').on('hidden.bs.modal', function () {
                $('#form-thiet-bi')[0].reset();
            });

            $('#modal-sua-thiet-bi').on('hidden.bs.modal', function () {
                $('#form-sua-thiet-bi')[0].reset();
                $('#preview-hinh-anh').html('');
            });

            // Hiển thị tên file khi chọn hình ảnh
            $('.custom-file-input').on('change', function () {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });
    </script>
@endsection