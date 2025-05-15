@section('page-scripts')
    <script>
        $(function () {
            // Thiết lập CSRF token cho AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Khởi tạo Select2
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            // Xử lý chọn buổi nhóm
            $('#buoi-nhom-select').on('change', function () {
                $('#filter-form').submit();
            });

            // Xử lý click nút chỉnh sửa phân công
            $(document).on('click', '.btn-edit-phan-cong', function () {
                const id = $(this).data('id');
                const nhiemVuId = $(this).data('nhiem-vu-id');
                const tinHuuId = $(this).data('tin-huu-id');
                const ghiChu = $(this).data('ghi-chu');

                // Cập nhật form
                $('#phan-cong-id').val(id);
                $('#nhiem-vu-id').val(nhiemVuId).trigger('change');
                $('#tin-huu-id').val(tinHuuId).trigger('change');
                $('#ghi-chu').val(ghiChu);

                // Cập nhật tiêu đề modal
                $('.modal-title').text('Cập nhật phân công nhiệm vụ');
            });

            // Xử lý mở modal thêm mới
            $('#modal-phan-cong').on('show.bs.modal', function (e) {
                // Nếu không phải từ nút edit thì là thêm mới
                if (!$(e.relatedTarget).hasClass('btn-edit-phan-cong')) {
                    // Reset form
                    $('#phan-cong-id').val('');
                    $('#form-phan-cong').trigger('reset');
                    $('#nhiem-vu-id').val('').trigger('change');
                    $('#tin-huu-id').val('').trigger('change');

                    // Cập nhật tiêu đề modal
                    $('.modal-title').text('Thêm phân công nhiệm vụ');
                }
            });

            // Xử lý submit form phân công
            $('#form-phan-cong').on('submit', function (e) {
                e.preventDefault();

                const formData = $(this).serialize();
                const isEdit = $('#phan-cong-id').val() !== '';

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message || 'Phân công nhiệm vụ thành công!');
                            location.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra');
                        }
                    },
                    error: function (xhr) {
                        let errorMsg = 'Đã xảy ra lỗi!';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMsg = '';
                            $.each(xhr.responseJSON.errors, function (key, value) {
                                errorMsg += value[0] + '\n';
                            });
                        } else {
                            errorMsg = xhr.responseJSON?.message || 'Lỗi khi thực hiện phân công';
                        }
                        toastr.error(errorMsg);
                    }
                });
            });

            // Xử lý xóa phân công
            $(document).on('click', '.btn-delete-phan-cong', function () {
                const id = $(this).data('id');

                if (confirm('Bạn có chắc chắn muốn xóa phân công này?')) {
                    $.ajax({
                        url: '{{ route("api._ban_co_doc_giao_duc.xoa_phan_cong", ["banType" => "ban-co-doc-giao-duc", "id" => "__ID__"]) }}'.replace('__ID__', id),
                        method: 'DELETE',
                        success: function (response) {
                            if (response.success) {
                                toastr.success(response.message || 'Xóa phân công thành công!');
                                location.reload();
                            } else {
                                toastr.error(response.message || 'Có lỗi xảy ra');
                            }
                        },
                        error: function (xhr) {
                            const errorMsg = xhr.responseJSON?.message || 'Đã xảy ra lỗi khi xóa phân công!';
                            toastr.error(errorMsg);
                        }
                    });
                }
            });
        });
    </script>
@endsection