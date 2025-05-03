<script>
    $(document).ready(function () {
        const table = $('#giaoDichTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("thu_quy.giao_dich.data") }}',
            columns: [
                { data: 'ma_giao_dich', name: 'ma_giao_dich' },
                { data: 'quy_tai_chinh', name: 'quy_tai_chinh' },
                { data: 'so_tien', name: 'so_tien' },
                { data: 'loai', name: 'loai' },
                { data: 'trang_thai', name: 'trang_thai' },
                { data: 'ngay_giao_dich', name: 'ngay_giao_dich' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                url: 'dist/js/Vietnamese.json'
            }
        });

        // Handle delete
        $(document).on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            $('#deleteModal').modal('show');
            $('#confirmDelete').off('click').on('click', function () {
                $.ajax({
                    url: '{{ route("thu_quy.giao_dich.destroy", ":id") }}'.replace(':id', id),
                    method: 'DELETE',
                    success: function (response) {
                        if (response.success) {
                            table.ajax.reload();
                            $('#deleteModal').modal('hide');
                            toastr.success('Xóa giao dịch thành công.');
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Đã xảy ra lỗi khi xóa giao dịch.');
                    }
                });
            });
        });
    });
</script>