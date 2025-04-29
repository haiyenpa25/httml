@section('page-scripts')
    <!-- resources/views/_thiet_bi/partials/nha_cung_cap_scripts.blade.php -->

    <script>
        /**
         * File JavaScript cho module quản lý nhà cung cấp
         * Chứa logic cho trang danh sách nhà cung cấp
         */

        $(document).ready(function () {
            // Logic cho trang danh sách nhà cung cấp
            if ($('#nha-cung-cap-table').length) {
                var nhaCungCapTable = $('#nha-cung-cap-table').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: {
                        url: "{{ route('nha-cung-cap.get-nha-cung-caps') }}",
                        data: function (d) {
                            // DataTable tự động gửi tham số search
                        },
                        dataSrc: function (json) {
                            console.log('Dữ liệu trả về từ server:', json);
                            if (json && json.data) {
                                return json.data; // Lấy dữ liệu từ key 'data' nếu tồn tại
                            } else if (Array.isArray(json)) {
                                return json; // Nếu là mảng trực tiếp, trả về luôn
                            } else {
                                console.error('Dữ liệu không đúng định dạng:', json);
                                return [];
                            }
                        },
                        error: function (xhr, error, thrown) {
                            console.error('Lỗi AJAX DataTable:', xhr.status, xhr.responseText, error, thrown);
                            if (xhr.status === 401 || xhr.status === 403) {
                                toastr.error('Bạn cần đăng nhập để xem danh sách nhà cung cấp.');
                                setTimeout(function() {
                                    window.location.href = '/login'; // Chuyển hướng đến trang đăng nhập
                                }, 2000);
                            } else if (xhr.status === 500) {
                                toastr.error('Lỗi server (500). Vui lòng kiểm tra log server để biết chi tiết: ' + (xhr.responseText || 'Không có thông tin chi tiết'));
                            } else {
                                toastr.error('Không thể tải danh sách nhà cung cấp. Mã lỗi: ' + xhr.status);
                            }
                        }
                    },
                    columns: [
                        { data: null, render: function (data, type, row, meta) { return meta.row + 1; } },
                        { 
                            data: 'ten_nha_cung_cap',
                            render: function (data) { return data || 'N/A'; }
                        },
                        { 
                            data: 'dia_chi',
                            render: function (data) { return data || 'N/A'; }
                        },
                        { 
                            data: 'so_dien_thoai',
                            render: function (data) { return data || 'N/A'; }
                        },
                        { 
                            data: 'email',
                            render: function (data) { return data || 'N/A'; }
                        },
                        { 
                            data: 'thiet_bis_count',
                            render: function (data) { return data || 0; }
                        },
                        {
                            data: null,
                            render: function (data) {
                                return `
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary btn-sm btn-edit" data-id="${data.id}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${data.id}" data-name="${data.ten_nha_cung_cap}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                `;
                            }
                        }
                    ],
                    language: {
                        url: '{{ asset("i18n/Vietnamese.json") }}'
                    }
                });

                // Làm mới bảng dữ liệu
                $('#btn-refresh').click(function () {
                    nhaCungCapTable.ajax.reload();
                });

                // Tìm kiếm
                $('#search-nha-cung-cap').keyup(function () {
                    nhaCungCapTable.search($(this).val()).draw();
                });

                // Xử lý thêm nhà cung cấp
                $('#form-nha-cung-cap').submit(function (e) {
                    e.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        url: "{{ route('nha-cung-cap.store') }}",
                        type: "POST",
                        data: formData,
                        beforeSend: function () {
                            $('#modal-them-nha-cung-cap .btn-primary').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                        },
                        success: function (response) {
                            if (response.success) {
                                $('#modal-them-nha-cung-cap').modal('hide');
                                $('#form-nha-cung-cap')[0].reset();
                                nhaCungCapTable.ajax.reload();
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
                        },
                        complete: function () {
                            $('#modal-them-nha-cung-cap .btn-primary').prop('disabled', false).html('Lưu');
                        }
                    });
                });

                // Xử lý sửa nhà cung cấp
                $('#nha-cung-cap-table').on('click', '.btn-edit', function() {
                    var id = $(this).data('id');
                    $.ajax({
                        url: '{{ route("nha-cung-cap.edit", ":id") }}'.replace(':id', id),
                        type: 'GET',
                        success: function(response) {
                            $('#edit_id').val(response.id);
                            $('#edit_ten_nha_cung_cap').val(response.ten_nha_cung_cap);
                            $('#edit_dia_chi').val(response.dia_chi);
                            $('#edit_so_dien_thoai').val(response.so_dien_thoai);
                            $('#edit_email').val(response.email);
                            $('#edit_ghi_chu').val(response.ghi_chu);
                            $('#modal-sua-nha-cung-cap').modal('show');
                        },
                        error: function() {
                            toastr.error('Không thể lấy thông tin nhà cung cấp. Vui lòng thử lại sau.');
                        }
                    });
                });

                $('#form-sua-nha-cung-cap').submit(function (e) {
                    e.preventDefault();
                    var formData = $(this).serialize() + '&_method=PUT';
                    var id = $('#edit_id').val();
                    $.ajax({
                        url: '{{ route("nha-cung-cap.update", ":id") }}'.replace(':id', id),
                        type: 'POST',
                        data: formData,
                        beforeSend: function () {
                            $('#modal-sua-nha-cung-cap .btn-primary').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang cập nhật...');
                        },
                        success: function (response) {
                            if (response.success) {
                                $('#modal-sua-nha-cung-cap').modal('hide');
                                nhaCungCapTable.ajax.reload();
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
                        },
                        complete: function () {
                            $('#modal-sua-nha-cung-cap .btn-primary').prop('disabled', false).html('Cập nhật');
                        }
                    });
                });

                // Xử lý xóa nhà cung cấp
                $('#nha-cung-cap-table').on('click', '.btn-delete', function() {
                    var id = $(this).data('id');
                    var name = $(this).data('name');
                    $('#delete_id').val(id);
                    $('#delete_name').text(name);
                    $('#modal-xoa-nha-cung-cap').modal('show');
                });

                $('#confirm-delete').click(function() {
                    var id = $('#delete_id').val();
                    $.ajax({
                        url: '{{ route("nha-cung-cap.destroy", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#modal-xoa-nha-cung-cap').modal('hide');
                                nhaCungCapTable.ajax.reload();
                                toastr.success(response.message);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 400) {
                                toastr.error(xhr.responseJSON.message);
                            } else {
                                toastr.error('Không thể xóa nhà cung cấp. Vui lòng thử lại sau.');
                            }
                        }
                    });
                });

                // Reset form khi đóng modal
                $('#modal-them-nha-cung-cap').on('hidden.bs.modal', function () {
                    $('#form-nha-cung-cap')[0].reset();
                });

                $('#modal-sua-nha-cung-cap').on('hidden.bs.modal', function () {
                    $('#form-sua-nha-cung-cap')[0].reset();
                });
            }
        });
    </script>
@endsection