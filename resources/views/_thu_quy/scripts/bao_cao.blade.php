<script>
    $(document).ready(function () {
        const table = $('#baoCaoTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("thu_quy.bao_cao.data") }}',
            columns: [
                { data: 'tieu_de', name: 'tieu_de' },
                { data: 'quy_tai_chinh', name: 'quy_tai_chinh' },
                { data: 'loai_bao_cao', name: 'loai_bao_cao' },
                { data: 'tu_ngay', name: 'tu_ngay' },
                { data: 'den_ngay', name: 'den_ngay' },
                { data: 'tong_thu', name: 'tong_thu' },
                { data: 'tong_chi', name: 'tong_chi' },
                { data: 'cong_khai', name: 'cong_khai' },
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
                    url: '{{ route("thu_quy.bao_cao.destroy", ":id") }}'.replace(':id', id),
                    method: 'DELETE',
                    success: function (response) {
                        if (response.success) {
                            table.ajax.reload();
                            $('#deleteModal').modal('hide');
                            toastr.success('Xóa báo cáo thành công.');
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Đã xảy ra lỗi khi xóa báo cáo.');
                    }
                });
            });
        });
    });
</script>