<script>
    $(document).ready(function () {
        // Khởi tạo DataTables
        var table = $('#permissionsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('permissions.index') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'guard_name', name: 'guard_name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/vi.json'
            }
        });
    
        // Mở modal tạo quyền
        $('#createPermission').click(function () {
            $('#permissionForm')[0].reset();
            $('#permission_id').val('');
            $('#permissionModalLabel').text('Thêm quyền');
            $('#permissionModal').modal('show');
        });
    
        // Lấy dữ liệu quyền để sửa
        $(document).on('click', '.edit-permission', function () {
            var id = $(this).data('id');
            $.ajax({
                url: "{{ url('quan-tri/permissions') }}/" + id + "/edit",
                method: 'GET',
                success: function (data) {
                    $('#permission_id').val(data.id);
                    $('#name').val(data.name);
                    $('#guard_name').val(data.guard_name);
                    $('#permissionModalLabel').text('Sửa quyền');
                    $('#permissionModal').modal('show');
                }
            });
        });
    
        // Gửi form tạo/sửa quyền
        $('#permissionForm').submit(function (e) {
            e.preventDefault();
            var id = $('#permission_id').val();
            var url = id ? "{{ url('quan-tri/permissions') }}/" + id : "{{ route('permissions.store') }}";
            var method = id ? 'PUT' : 'POST';
    
            $.ajax({
                url: url,
                method: method,
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#permissionModal').modal('hide');
                    table.ajax.reload();
                    toastr.success(response.message);
                },
                error: function (xhr) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        toastr.error(value[0]);
                    });
                }
            });
        });
    
        // Xóa quyền
        $(document).on('click', '.delete-permission', function () {
            var id = $(this).data('id');
            if (confirm('Bạn có chắc muốn xóa quyền này?')) {
                $.ajax({
                    url: "{{ url('quan-tri/permissions') }}/" + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        table.ajax.reload();
                        toastr.success(response.message);
                    }
                });
            }
        });
    });
    </script>