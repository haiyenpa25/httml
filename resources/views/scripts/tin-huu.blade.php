@section('page-styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Select2 CSS -->
    <style>
        .select2-container--bootstrap4 .select2-selection__rendered {
            color: #333 !important;
            line-height: 34px !important;
            padding-left: 10px !important;
        }
        .select2-container--bootstrap4 .select2-selection--single {
            height: 38px !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem !important;
        }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__placeholder {
            color: #6c757d !important;
        }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
            top: 0 !important;
        }
        .select2-container--bootstrap4 .select2-selection--single .select2-selection__clear {
            margin-top: 0 !important;
            line-height: 38px !important;
        }
        .select2-container--bootstrap4 .select2-dropdown {
            border: 1px solid #ced4da !important;
        }
        .select2-container--bootstrap4 .select2-results__option {
            color: #333 !important;
        }
    </style>
@endsection

@section('page-scripts')
    <script>
        $(document).ready(function () {
            // Kiểm tra và hủy DataTable nếu đã tồn tại
            let table;
            if ($.fn.DataTable.isDataTable('#tin-huu-table')) {
                $('#tin-huu-table').DataTable().destroy();
            }

            // Khởi tạo DataTable
            table = $('#tin-huu-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ route('api.tin_huu.list') }}",
                    dataSrc: ''
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1; // Số thứ tự
                        }
                    },
                    { data: 'ho_ten' },
                    {
                        data: 'ngay_sinh',
                        render: function (data) {
                            return formatDate(data);
                        }
                    },
                    {
                        data: 'loai_tin_huu',
                        render: function (data) {
                            const loaiMap = {
                                'tin_huu_chinh_thuc': 'Chính Thức',
                                'tan_tin_huu': 'Tân Tín Hữu',
                                'tin_huu_ht_khac': 'Hội Thánh Khác'
                            };
                            return loaiMap[data] || data;
                        }
                    },
                    {
                        data: 'gioi_tinh',
                        render: function (data) {
                            return data === 'nam' ? 'Nam' : 'Nữ';
                        }
                    },
                    {
                        data: 'ban_nganhs',
                        render: function (data, type, row) {
                            // Kiểm tra chặt chẽ dữ liệu ban_nganhs
                            if (Array.isArray(data) && data.length > 0) {
                                return data
                                    .filter(banNganh => banNganh && banNganh.ten)
                                    .map(banNganh => banNganh.ten)
                                    .join(', ');
                            }
                            return 'N/A';
                        }
                    },
                    { data: 'so_dien_thoai' },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-info btn-edit" data-id="${row.id}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="${row.id}" data-name="${row.ho_ten}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-primary btn-view" data-id="${row.id}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>`;
                        }
                    }
                ],
                language: {
                    url: '{{ asset("dist/js/Vietnamese.json") }}'
                },
                responsive: true,
                autoWidth: false
            });

            // Khởi tạo Select2 với class .select2bs4 sau khi DOM sẵn sàng
            if ($('.select2bs4').length) {
                $('.select2bs4').each(function () {
                    const $select = $(this);
                    $select.select2({
                        theme: 'bootstrap4',
                        placeholder: $select.find('option[value=""]').text() || '-- Chọn --',
                        width: '100%',
                        dropdownAutoWidth: true,
                        minimumResultsForSearch: 10, // Ẩn thanh tìm kiếm nếu ít hơn 10 option
                        allowClear: true // Cho phép xóa giá trị đã chọn
                    }).on('select2:open', function () {
                        // Đảm bảo dropdown hiển thị đúng
                        $('.select2-container--bootstrap4 .select2-results__option').css('color', '#333');
                    });
                });
            }

            // Khởi tạo Select2 cho trường Hộ Gia Đình trong modal thêm và sửa
            if ($('#ho_gia_dinh_id').length) {
                $('#ho_gia_dinh_id').select2({
                    theme: 'bootstrap4',
                    placeholder: '-- Chọn Hội Thánh --',
                    width: '100%',
                    dropdownAutoWidth: true,
                    minimumResultsForSearch: 10,
                    allowClear: true
                });
            }
            if ($('#edit_ho_gia_dinh_id').length) {
                $('#edit_ho_gia_dinh_id').select2({
                    theme: 'bootstrap4',
                    placeholder: '-- Chọn Hội Thánh --',
                    width: '100%',
                    dropdownAutoWidth: true,
                    minimumResultsForSearch: 10,
                    allowClear: true
                });
            }

            // Áp dụng bộ lọc
            $('#filter-loai-tin-huu, #filter-gioi-tinh, #filter-hon-nhan, #filter-ban-nganh').on('change', function () {
                const loaiTinHuu = $('#filter-loai-tin-huu').val();
                const gioiTinh = $('#filter-gioi-tinh').val();
                const tinhTrangHonNhan = $('#filter-hon-nhan').val();
                const banNganh = $('#filter-ban-nganh').val();

                // Lọc dữ liệu
                table.draw();
            });

            // Tùy chỉnh bộ lọc với search API của DataTable
            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    const loaiTinHuuFilter = $('#filter-loai-tin-huu').val();
                    const gioiTinhFilter = $('#filter-gioi-tinh').val();
                    const tinhTrangHonNhanFilter = $('#filter-hon-nhan').val();
                    const banNganhFilter = $('#filter-ban-nganh').val();

                    // Lấy dữ liệu gốc của hàng (row) từ API
                    const rowData = table.row(dataIndex).data();

                    // Kiểm tra từng điều kiện lọc
                    const loaiTinHuuMatch = !loaiTinHuuFilter || rowData.loai_tin_huu === loaiTinHuuFilter;
                    const gioiTinhMatch = !gioiTinhFilter || rowData.gioi_tinh === gioiTinhFilter;
                    const tinhTrangHonNhanMatch = !tinhTrangHonNhanFilter || rowData.tinh_trang_hon_nhan === tinhTrangHonNhanFilter;
                    const banNganhMatch = !banNganhFilter || (Array.isArray(rowData.ban_nganhs) && rowData.ban_nganhs.some(banNganh => banNganh && banNganh.id == banNganhFilter));

                    // Trả về true nếu tất cả điều kiện đều khớp
                    return loaiTinHuuMatch && gioiTinhMatch && tinhTrangHonNhanMatch && banNganhMatch;
                }
            );

            // Xử lý nút Tải lại
            $('#btn-refresh').click(function () {
                // Reset các bộ lọc
                $('#filter-loai-tin-huu').val('').trigger('change');
                $('#filter-gioi-tinh').val('').trigger('change');
                $('#filter-hon-nhan').val('').trigger('change');
                $('#filter-ban-nganh').val('').trigger('change');
                table.ajax.reload();
            });

            // Xử lý submit form thêm tín hữu
            $('#form-tin-huu').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('_tin_huu.store') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json'
                })
                .done(response => {
                    if (response.success) {
                        $('#modal-them-tin-huu').modal('hide');
                        $('#form-tin-huu')[0].reset();
                        $('.select2bs4').val(null).trigger('change');
                        $('#ho_gia_dinh_id').val(null).trigger('change');
                        toastr.success(response.message);
                        table.ajax.reload();
                    } else {
                        toastr.error(response.message || 'Đã xảy ra lỗi.');
                    }
                })
                .fail(xhr => {
                    let errorMessage = 'Đã xảy ra lỗi khi thêm tín hữu.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }
                    toastr.error(errorMessage);
                });
            });

            // Xử lý khi click nút sửa
            $(document).on('click', '.btn-edit', function () {
                const id = $(this).data('id');
                $.ajax({
                    url: `{{ url('quan-ly-tin-huu/tin-huu') }}/${id}/edit`,
                    method: 'GET',
                    dataType: 'json'
                })
                .done(data => {
                    $('#edit_id').val(data.id);
                    $('#edit_ho_ten').val(data.ho_ten);
                    $('#edit_ngay_sinh').val(data.ngay_sinh);
                    $('#edit_so_dien_thoai').val(data.so_dien_thoai);
                    $('#edit_dia_chi').val(data.dia_chi);
                    $('#edit_loai_tin_huu').val(data.loai_tin_huu);
                    $('#edit_gioi_tinh').val(data.gioi_tinh);
                    $('#edit_tinh_trang_hon_nhan').val(data.tinh_trang_hon_nhan);
                    $('#edit_ho_gia_dinh_id').val(data.ho_gia_dinh_id).trigger('change');
                    $('#edit_ngay_tin_chua').val(data.ngay_tin_chua);
                    $('#modal-sua-tin-huu').modal('show');
                })
                .fail(xhr => {
                    toastr.error('Không thể lấy thông tin tín hữu. Vui lòng thử lại sau!');
                });
            });

            // Xử lý submit form sửa tín hữu
            $('#form-sua-tin-huu').submit(function (e) {
                e.preventDefault();
                const id = $('#edit_id').val();
                $.ajax({
                    url: `{{ url('quan-ly-tin-huu/tin-huu') }}/${id}`,
                    method: 'PUT',
                    data: $(this).serialize(),
                    dataType: 'json'
                })
                .done(response => {
                    if (response.success) {
                        $('#modal-sua-tin-huu').modal('hide');
                        toastr.success(response.message);
                        table.ajax.reload();
                    } else {
                        toastr.error(response.message || 'Đã xảy ra lỗi.');
                    }
                })
                .fail(xhr => {
                    let errorMessage = 'Đã xảy ra lỗi khi cập nhật tín hữu.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }
                    toastr.error(errorMessage);
                });
            });

            // Xử lý khi click nút xóa
            $(document).on('click', '.btn-delete', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                $('#delete_id').val(id);
                $('#delete_name').text(name);
                $('#modal-xoa-tin-huu').modal('show');
            });

            // Xử lý xác nhận xóa
            $('#confirm-delete').click(function () {
                const id = $('#delete_id').val();
                $.ajax({
                    url: `{{ url('quan-ly-tin-huu/tin-huu') }}/${id}`,
                    method: 'DELETE',
                    dataType: 'json'
                })
                .done(response => {
                    if (response.success) {
                        $('#modal-xoa-tin-huu').modal('hide');
                        toastr.success(response.message);
                        table.ajax.reload();
                    } else {
                        toastr.error(response.message || 'Không thể xóa tín hữu.');
                    }
                })
                .fail(xhr => {
                    toastr.error('Không thể xóa tín hữu. Vui lòng thử lại sau!');
                });
            });

            // Xử lý khi click nút xem chi tiết
            $(document).on('click', '.btn-view', function () {
                const id = $(this).data('id');
                $.ajax({
                    url: `{{ url('quan-ly-tin-huu/tin-huu') }}/${id}`,
                    method: 'GET',
                    dataType: 'json'
                })
                .done(data => {
                    $('#view_ho_ten').text(data.ho_ten);
                    $('#view_ngay_sinh').text(formatDate(data.ngay_sinh));
                    $('#view_so_dien_thoai').text(data.so_dien_thoai);
                    $('#view_dia_chi').text(data.dia_chi);
                    const loaiMap = {
                        'tin_huu_chinh_thuc': 'Tín Hữu Chính Thức',
                        'tan_tin_huu': 'Tân Tín Hữu',
                        'tin_huu_ht_khac': 'Tín Hữu Hội Thánh Khác'
                    };
                    $('#view_loai_tin_huu').text(loaiMap[data.loai_tin_huu] || data.loai_tin_huu);
                    $('#view_gioi_tinh').text(data.gioi_tinh === 'nam' ? 'Nam' : 'Nữ');
                    const hnMap = {
                        'doc_than': 'Độc Thân',
                        'ket_hon': 'Kết Hôn'
                    };
                    $('#view_tinh_trang_hon_nhan').text(hnMap[data.tinh_trang_hon_nhan] || data.tinh_trang_hon_nhan);
                    $('#modal-xem-tin-huu').modal('show');
                })
                .fail(xhr => {
                    toastr.error('Không thể xem chi tiết tín hữu. Vui lòng thử lại sau!');
                });
            });

            // Xử lý xuất Excel
            $('#btn-export').click(function () {
                toastr.info('Chức năng xuất Excel sẽ được phát triển sau.');
            });
        });
    </script>
@endsection