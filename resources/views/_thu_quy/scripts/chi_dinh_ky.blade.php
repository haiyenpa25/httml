<script>
    $(document).ready(function () {
        const table = $('#chiDinhKyTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("thu_quy.chi_dinh_ky.data") }}',
            columns: [
                { data: 'ten_chi', name: 'ten_chi' },
                { data: 'quy_tai_chinh', name: 'quy_tai_chinh' },
                { data: 'so_tien', name: 'so_tien' },
                { data: 'tan_suat', name: 'tan_suat' },
                { data: 'trang_thai', name: 'trang_thai' },
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
                    url: '{{ route("thu_quy.chi_dinh_ky.destroy", ":id") }}'.replace(':id', id),
                    method: 'DELETE',
                    success: function (response) {
                        if (response.success) {
                            table.ajax.reload();
                            $('#deleteModal').modal('hide');
                            toastr.success('Xóa chi định kỳ thành công.');
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Đã xảy ra lỗi khi xóa chi định kỳ.');
                    }
                });
            });
        });
    });
</script>