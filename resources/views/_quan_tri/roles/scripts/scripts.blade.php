<script>
    $(document).ready(function () {
        // Khởi tạo DataTables
        var table = $('#rolesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('roles.index') }}",
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
    
        // Mở modal tạo vai trò
        $('#createRole').click(function () {
            $('#roleForm')[0].reset();
            $('#role_id').val('');
            $('#roleModalLabel').text('Thêm vai trò');
            $('#roleModal').modal('show');
        });
    
        // Lấy dữ liệu vai trò để sửa
        $(document).on('click', '.edit-role', function () {
            var id = $(this).data('id');
            $.ajax({
                url: "{{ url('quan-tri/roles') }}/" + id + "/edit",
                method: 'GET',
                success: function (data) {
                    $('#role_id').val(data.id);
                    $('#name').val(data.name);
                    $('#guard_name').val(data.guard_name);
                    $('#roleModalLabel').text('Sửa vai trò');
                    $('#roleModal').modal('show');
                }
            });
        });
    
        // Gửi form tạo/sửa vai trò
        $('#roleForm').submit(function (e) {
            e.preventDefault();
            var id = $('#role_id').val();
            var url = id ? "{{ url('quan-tri/roles') }}/" + id : "{{ route('roles.store') }}";
            var method = id ? 'PUT' : 'POST';
    
            $.ajax({
                url: url,
                method: method,
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#roleModal').modal('hide');
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
    
        // Xóa vai trò
        $(document).on('click', '.delete-role', function () {
            var id = $(this).data('id');
            if (confirm('Bạn có chắc muốn xóa vai trò này?')) {
                $.ajax({
                    url: "{{ url('quan-tri/roles') }}/" + id,
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