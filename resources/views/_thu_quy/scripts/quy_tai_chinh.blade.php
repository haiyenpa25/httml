<script>
    $(document).ready(function () {
        const table = $('#quyTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("_thu_quy.quy.data") }}',
            columns: [
                { data: 'ten_quy', name: 'ten_quy' },
                { data: 'so_du_hien_tai', name: 'so_du_hien_tai' },
                { data: 'nguoi_quan_ly', name: 'nguoi_quan_ly' },
                { data: 'trang_thai', name: 'trang_thai' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                url: 'dist/js/Vietnamese.json'
            }
        });

        // Xử lý sự kiện xóa quỹ
        $(document).on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            if (confirm('Bạn có chắc chắn muốn xóa quỹ này?')) {
                $.ajax({
                    url: '{{ url("thu-quy/quy") }}/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            table.ajax.reload();
                            toastr.success('Xóa quỹ thành công.');
                        } else {
                            toastr.error(response.message || 'Không thể xóa quỹ.');
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Đã xảy ra lỗi khi xóa quỹ: ' + (xhr.responseJSON?.message || 'Lỗi không xác định'));
                    }
                });
            }
        });
    });
</script>