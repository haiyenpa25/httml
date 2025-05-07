@section('page-scripts')
    <script>
        $(function () {
            // Khởi tạo Select2
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                placeholder: $(this).data('placeholder') || '-- Chọn một mục --',
                allowClear: true,
                minimumResultsForSearch: 5,
                width: '100%'
            });

            // Hàm chuẩn hóa và định dạng giá trị tiền tệ
            function cleanMoneyFormat(value) {
                if (!value) return '0';
                return value.replace(/[^0-9]/g, '');
            }

            function formatMoney(value) {
                return new Intl.NumberFormat('vi-VN').format(value);
            }

            // Định dạng giá trị ban đầu cho tất cả input có class money-format
            $('.money-format').each(function () {
                let value = $(this).val();
                let cleanedValue = cleanMoneyFormat(value);
                $(this).val(formatMoney(cleanedValue));
            });

            // Xử lý định dạng tiền tệ khi nhập
            $('.money-format').on('input', function () {
                let value = $(this).val().replace(/\D/g, '');
                $(this).val(formatMoney(value));
            });

            // Hàm format chi tiết mở rộng
            function formatChildRow(data) {
                return '<table class="table table-bordered mb-0">' +
                    '<tr>' +
                    '<td style="width: 150px;"><strong>Địa chỉ:</strong></td>' +
                    '<td>' + (data.dia_chi || 'N/A') + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><strong>Ngày sinh hoạt với Hội Thánh:</strong></td>' +
                    '<td>' + (data.ngay_sinh_hoat_voi_hoi_thanh ? moment(data.ngay_sinh_hoat_voi_hoi_thanh).format('DD/MM/YYYY') : 'N/A') + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><strong>Ngày tin Chúa:</strong></td>' +
                    '<td>' + (data.ngay_tin_chua ? moment(data.ngay_tin_chua).format('DD/MM/YYYY') : 'N/A') + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><strong>Hoàn thành báp têm:</strong></td>' +
                    '<td>' + (data.hoan_thanh_bap_tem ? 'Có' : 'Không') + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><strong>Giới tính:</strong></td>' +
                    '<td>' + (data.gioi_tinh === 'nam' ? 'Nam' : data.gioi_tinh === 'nu' ? 'Nữ' : 'N/A') + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><strong>Tình trạng hôn nhân:</strong></td>' +
                    '<td>' + (data.tinh_trang_hon_nhan === 'doc_than' ? 'Độc thân' : data.tinh_trang_hon_nhan === 'ket_hon' ? 'Kết hôn' : 'N/A') + '</td>' +
                    '</tr>' +
                    '</table>';
            }

            // Khởi tạo DataTable cho bảng Ban Điều Hành
            try {
                $('#ban-dieu-hanh-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: {
                        details: {
                            type: 'inline',
                            renderer: function (api, rowIdx, columns) {
                                var data = $.map(columns, function (col, i) {
                                    return col.hidden ?
                                        '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                            '<td>' + col.title + ':' + '</td> ' +
                                            '<td>' + col.data + '</td>' +
                                        '</tr>' : '';
                                }).join('');

                                return data ? $('<table/>').append(data) : false;
                            }
                        }
                    },
                    ajax: {
                        url: '{{ route("api.ban_nganh." . $banType . ".dieu_hanh_list") }}',
                        type: 'GET',
                        data: function (d) {
                            d.ho_ten = $('#filter-ho-ten').val();
                            d.chuc_vu = $('#filter-chuc-vu').val();
                        },
                        error: function (xhr, error, thrown) {
                            console.error('Lỗi khi tải dữ liệu Ban Điều Hành:', {
                                status: xhr.status,
                                response: xhr.responseJSON,
                                error: error,
                                thrown: thrown
                            });
                            let errorMessage = xhr.responseJSON?.message || 'Không thể tải dữ liệu Ban Điều Hành. Vui lòng kiểm tra kết nối hoặc liên hệ quản trị viên.';
                            toastr.error(errorMessage);
                        }
                    },
                    columns: [
                        {
                            className: 'dt-control',
                            orderable: false,
                            data: null,
                            defaultContent: '<i class="fas fa-plus-circle"></i>',
                            searchable: false
                        },
                        {
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1; // Sinh STT tự động
                            },
                            orderable: false,
                            searchable: false
                        },
                        { data: 'chuc_vu', name: 'chuc_vu' },
                        { data: 'ho_ten', name: 'ho_ten' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ],
                    language: {
                        url: '{{ asset("dist/js/Vietnamese.json") }}'
                    },
                    columnDefs: [
                        { targets: [0, 1, 4], responsivePriority: 1 },
                        { targets: [2, 3], responsivePriority: 100 }
                    ],
                    order: [],
                    drawCallback: function (settings) {
                        console.log('DataTables Responsive state (Ban Điều Hành):', settings.oInstance.api().responsive.hasHidden());
                    }
                });
            } catch (e) {
                console.error('Lỗi khởi tạo DataTables (ban-dieu-hanh-table):', e);
            }

            // Khởi tạo DataTable cho bảng Ban Viên
            try {
                $('#ban-vien-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: {
                        details: {
                            type: 'inline',
                            renderer: function (api, rowIdx, columns) {
                                var data = $.map(columns, function (col, i) {
                                    return col.hidden ?
                                        '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                            '<td>' + col.title + ':' + '</td> ' +
                                            '<td>' + col.data + '</td>' +
                                        '</tr>' : '';
                                }).join('');

                                return data ? $('<table/>').append(data) : false;
                            }
                        }
                    },
                    ajax: {
                        url: '{{ route("api.ban_nganh." . $banType . ".ban_vien_list") }}',
                        type: 'GET',
                        data: function (d) {
                            d.ho_ten = $('#filter-ho-ten').val();
                            d.loai_tin_huu = $('#filter-loai-tin-huu').val();
                            d.so_dien_thoai = $('#filter-so-dien-thoai').val();
                            d.ngay_sinh = $('#filter-ngay-sinh').val();
                            d.gioi_tinh = $('#filter-gioi-tinh').val();
                            d.tinh_trang_hon_nhan = $('#filter-tinh-trang-hon-nhan').val();
                            d.hoan_thanh_bap_tem = $('#filter-hoan-thanh-bap-tem').val();
                            d.tuoi = $('#filter-tuoi').val();
                            d.thoi_gian_sinh_hoat = $('#filter-thoi-gian-sinh-hoat').val();
                        },
                        error: function (xhr, error, thrown) {
                            console.error('Lỗi khi tải dữ liệu Ban Viên:', {
                                status: xhr.status,
                                response: xhr.responseJSON,
                                error: error,
                                thrown: thrown
                            });
                            let errorMessage = xhr.responseJSON?.message || 'Không thể tải dữ liệu Ban Viên. Vui lòng kiểm tra kết nối hoặc liên hệ quản trị viên.';
                            toastr.error(errorMessage);
                        }
                    },
                    columns: [
                        {
                            className: 'dt-control',
                            orderable: false,
                            data: null,
                            defaultContent: '<i class="fas fa-plus-circle"></i>',
                            searchable: false
                        },
                        {
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1; // Sinh STT tự động
                            },
                            orderable: false,
                            searchable: false
                        },
                        { data: 'ho_ten', name: 'ho_ten' },
                        {
                            data: 'ngay_sinh',
                            name: 'ngay_sinh',
                            render: function(data, type, row) {
                                if (!data) {
                                    console.error('Dữ liệu ngay_sinh không hợp lệ cho hàng:', row);
                                    return 'N/A';
                                }
                                return moment(data).format('DD/MM/YYYY');
                            }
                        },
                        { data: 'so_dien_thoai', name: 'so_dien_thoai' },
                        { data: 'ban_nganh', name: 'ban_nganh' },
                        {
                            data: 'loai_tin_huu',
                            name: 'loai_tin_huu',
                            render: function(data) {
                                return {
                                    'tin_huu_chinh_thuc': 'Tín hữu chính thức',
                                    'tan_tin_huu': 'Tân tín hữu',
                                    'tin_huu_ht_khac': 'Tín hữu Hội Thánh khác'
                                }[data] || data;
                            }
                        },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ],
                    language: {
                        url: '{{ asset("dist/js/Vietnamese.json") }}'
                    },
                    columnDefs: [
                        { targets: [0, 1, 7], responsivePriority: 1 },
                        { targets: [2, 3, 4, 5, 6], responsivePriority: 100 }
                    ],
                    order: [],
                    drawCallback: function (settings) {
                        console.log('DataTables Responsive state (Ban Viên):', settings.oInstance.api().responsive.hasHidden());
                    }
                });
            } catch (e) {
                console.error('Lỗi khởi tạo DataTables (ban-vien-table):', e);
            }

            // Xử lý mở rộng hàng trong DataTable trên desktop
            $('#ban-dieu-hanh-table, #ban-vien-table').on('click', 'td.dt-control', function () {
                var tr = $(this).closest('tr');
                var table = $(this).closest('table').DataTable();
                var row = table.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).html('<i class="fas fa-plus-circle"></i>');
                } else {
                    row.child(formatChildRow(row.data())).show();
                    tr.addClass('shown');
                    $(this).html('<i class="fas fa-minus-circle"></i>');
                }
            });

            // Xử lý lọc khi người dùng thay đổi bộ lọc
            $('#filter-ho-ten, #filter-so-dien-thoai, #filter-ngay-sinh, #filter-loai-tin-huu, #filter-gioi-tinh, #filter-tinh-trang-hon-nhan, #filter-hoan-thanh-bap-tem, #filter-tuoi, #filter-thoi-gian-sinh-hoat').on('keyup change input', function () {
                $('#ban-vien-table').DataTable().ajax.reload();
            });

            $('#filter-ho-ten, #filter-chuc-vu').on('keyup change', function () {
                $('#ban-dieu-hanh-table').DataTable().ajax.reload();
            });

            // Xử lý modal thêm thành viên
            $('#form-them-thanh-vien').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                console.log('Gửi yêu cầu thêm thành viên:', formData);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (thêm thành viên):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            $('#modal-them-thanh-vien').modal('hide');
                            $('#ban-vien-table').DataTable().ajax.reload();
                            $('#ban-dieu-hanh-table').DataTable().ajax.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra khi thêm thành viên!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (thêm thành viên):', xhr.responseJSON);
                        let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                        if (xhr.responseJSON?.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        $('button[type="submit"]').prop('disabled', false).html('Lưu');
                    }
                });
            });

            // Xử lý modal chỉnh sửa chức vụ
            $('#modal-edit-chuc-vu').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var tinHuuId = button.data('tin-huu-id');
                var banNganhId = button.data('ban-nganh-id');
                var tenTinHuu = button.data('ten-tin-huu');
                var chucVu = button.data('chuc-vu');

                var modal = $(this);
                modal.find('#edit_tin_huu_id').val(tinHuuId);
                modal.find('#edit_ban_nganh_id').val(banNganhId);
                modal.find('#edit_ten_tin_huu').text(tenTinHuu);
                modal.find('#edit_chuc_vu').val(chucVu);
            });

            $('#form-sua-chuc-vu').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                console.log('Gửi yêu cầu cập nhật chức vụ:', formData);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (cập nhật chức vụ):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            $('#modal-edit-chuc-vu').modal('hide');
                            $('#ban-dieu-hanh-table').DataTable().ajax.reload();
                            $('#ban-vien-table').DataTable().ajax.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra khi cập nhật chức vụ!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (cập nhật chức vụ):', xhr.responseJSON);
                        let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                        if (xhr.responseJSON?.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        $('button[type="submit"]').prop('disabled', false).html('Lưu');
                    }
                });
            });

            // Xử lý modal xóa thành viên
            $('#modal-xoa-thanh-vien').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var tinHuuId = button.data('tin-huu-id');
                var banNganhId = button.data('ban-nganh-id');
                var tenTinHuu = button.data('ten-tin-huu');

                var modal = $(this);
                modal.find('#delete_tin_huu_id').val(tinHuuId);
                modal.find('#delete_ban_nganh_id').val(banNganhId);
                modal.find('#delete_ten_tin_huu').text(tenTinHuu);
            });

            $('#confirm-delete').on('click', function () {
                var tinHuuId = $('#delete_tin_huu_id').val();
                var banNganhId = $('#delete_ban_nganh_id').val();

                $.ajax({
                    url: '{{ route("api.ban_nganh." . $banType . ".xoa_thanh_vien") }}',
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        tin_huu_id: tinHuuId,
                        ban_nganh_id: banNganhId
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (xóa thành viên):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            $('#modal-xoa-thanh-vien').modal('hide');
                            $('#ban-dieu-hanh-table').DataTable().ajax.reload();
                            $('#ban-vien-table').DataTable().ajax.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra khi xóa thành viên!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (xóa thành viên):', xhr.responseJSON);
                        toastr.error(xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!');
                    }
                });
            });
        });
    </script>
@endsection