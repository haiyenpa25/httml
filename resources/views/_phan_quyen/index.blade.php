@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quản Lý Phân Quyền Người Dùng</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Thành công!</h5>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Lỗi!</h5>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($users->isEmpty())
                        <div class="alert alert-warning">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Chưa có người dùng!</h5>
                            Vui lòng thêm người dùng trước khi gán quyền.
                        </div>
                    @else
                        <table id="users-table" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Tên Tín Hữu</th>
                                    <th>Vai Trò</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->tinHuu->ho_ten ?? 'N/A' }}</td>
                                        <td>
                                            <select class="form-control select2bs4 role-select" data-user-id="{{ $user->id }}" {{ $user->email === 'admin1@example.com' ? 'disabled' : '' }}>
                                                <option value="">-- Chọn Vai Trò --</option>
                                                <option value="quan_tri" {{ $user->vai_tro === 'quan_tri' ? 'selected' : '' }}>Quản Trị</option>
                                                <option value="truong_ban" {{ $user->vai_tro === 'truong_ban' ? 'selected' : '' }}>Trưởng Ban</option>
                                                <option value="thanh_vien" {{ $user->vai_tro === 'thanh_vien' ? 'selected' : '' }}>Thành Viên</option>
                                            </select>
                                            @if ($user->vai_tro === 'truong_ban')
                                                <select class="form-control select2bs4 ban-nganh-select mt-2" data-user-id="{{ $user->id }}" {{ $user->email === 'admin1@example.com' ? 'disabled' : '' }}>
                                                    <option value="">-- Chọn Ban Ngành --</option>
                                                    @foreach ($banNganhs as $banNganh)
                                                        <option value="{{ $banNganh->id }}" {{ $user->id_ban_nganh == $banNganh->id ? 'selected' : '' }}>{{ $banNganh->ten }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm manage-permissions-btn" data-user-id="{{ $user->id }}" {{ $user->vai_tro === 'quan_tri' ? 'disabled' : '' }}>
                                                Quản Lý Quyền
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Quản Lý Quyền -->
<div class="modal fade" id="manage-permissions-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Quản Lý Quyền Người Dùng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="modal-ban-nganh">Ban Ngành</label>
                    <select class="form-control select2bs4" id="modal-ban-nganh">
                        <option value="">-- Toàn Hệ Thống --</option>
                        @foreach ($banNganhs as $banNganh)
                            <option value="{{ $banNganh->id }}">{{ $banNganh->ten }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="accordion" id="permissions-accordion">
                    @foreach ($permissions as $group => $groupPermissions)
                        <div class="card">
                            <div class="card-header" id="heading-{{ Str::slug($group) }}">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse-{{ Str::slug($group) }}" aria-expanded="true" aria-controls="collapse-{{ Str::slug($group) }}">
                                        {{ $group }}
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse-{{ Str::slug($group) }}" class="collapse" aria-labelledby="heading-{{ Str::slug($group) }}" data-parent="#permissions-accordion">
                                <div class="card-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Quyền</th>
                                                <th>Chọn</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($groupPermissions as $permission => $description)
                                                <tr>
                                                    <td>{{ $description }}</td>
                                                    <td>
                                                        <input type="checkbox" class="permission-checkbox" value="{{ $permission }}" data-permission="{{ $permission }}">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="save-permissions-btn">Lưu</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-scripts')
    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                placeholder: '-- Chọn một mục --',
                allowClear: true,
                minimumResultsForSearch: 5,
                width: '100%'
            });

            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 5000
            };

            // Khởi tạo DataTables cho bảng người dùng
            $('#users-table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json"
                }
            });

            // Xử lý khi thay đổi vai trò
            $('.role-select').on('change', function () {
                const userId = $(this).data('user-id');
                const role = $(this).val();
                const banNganhSelect = $(this).closest('tr').find('.ban-nganh-select');
                const managePermissionsBtn = $(this).closest('tr').find('.manage-permissions-btn');

                // Hiển thị hoặc ẩn dropdown ban ngành
                if (role === 'truong_ban') {
                    banNganhSelect.closest('.mt-2').show();
                    managePermissionsBtn.prop('disabled', false);
                } else {
                    banNganhSelect.closest('.mt-2').hide();
                    banNganhSelect.val('');
                    if (role === 'quan_tri') {
                        managePermissionsBtn.prop('disabled', true);
                    } else {
                        managePermissionsBtn.prop('disabled', false);
                    }
                }

                // Gửi yêu cầu cập nhật vai trò
                $.ajax({
                    url: '{{ route("_phan_quyen.update_role", ":userId") }}'.replace(':userId', userId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        role: role,
                        ban_nganh: role === 'truong_ban' ? banNganhSelect.val() : null,
                        ban_nganh_id: role === 'truong_ban' ? banNganhSelect.val() : null
                    },
                    success: function (response) {
                        toastr.success(response.success || 'Đã cập nhật vai trò thành công.');
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON.error || 'Đã xảy ra lỗi khi cập nhật vai trò.');
                        console.error('Error updating role:', xhr.responseJSON);
                    }
                });
            });

            // Xử lý khi thay đổi ban ngành
            $('.ban-nganh-select').on('change', function () {
                const userId = $(this).data('user-id');
                const role = $(this).closest('tr').find('.role-select').val();
                const banNganh = $(this).val();

                // Gửi yêu cầu cập nhật vai trò với ban ngành
                $.ajax({
                    url: '{{ route("_phan_quyen.update_role", ":userId") }}'.replace(':userId', userId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        role: role,
                        ban_nganh: banNganh,
                        ban_nganh_id: banNganh
                    },
                    success: function (response) {
                        toastr.success(response.success || 'Đã cập nhật ban ngành thành công.');
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON.error || 'Đã xảy ra lỗi khi cập nhật ban ngành.');
                        console.error('Error updating ban nganh:', xhr.responseJSON);
                    }
                });
            });

            // Xử lý khi mở modal quản lý quyền
            $('.manage-permissions-btn').on('click', function () {
                const userId = $(this).data('user-id');
                $('#manage-permissions-modal').data('user-id', userId);

                // Lấy danh sách quyền hiện tại của người dùng
                $.ajax({
                    url: '{{ route("_phan_quyen.user_permissions", ":userId") }}'.replace(':userId', userId),
                    method: 'GET',
                    success: function (response) {
                        const userPermissions = response.permissions;
                        const isAdmin = response.isAdmin;

                        console.log('User Permissions Loaded:', userPermissions);

                        // Cập nhật trạng thái checkbox dựa trên quyền hiện tại
                        $('.permission-checkbox').prop('checked', false);
                        userPermissions.forEach(permission => {
                            $(`.permission-checkbox[value="${permission}"]`).prop('checked', true);
                        });

                        // Nếu là quản trị, vô hiệu hóa checkbox và nút lưu
                        if (isAdmin) {
                            $('.permission-checkbox').prop('disabled', true);
                            $('#save-permissions-btn').prop('disabled', true);
                        } else {
                            $('.permission-checkbox').prop('disabled', false);
                            $('#save-permissions-btn').prop('disabled', false);
                        }
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON.error || 'Không thể tải danh sách quyền.');
                        console.error('Error loading permissions:', xhr.responseJSON);
                    }
                });

                $('#manage-permissions-modal').modal('show');
            });

            // Theo dõi thay đổi checkbox
            $('.permission-checkbox').on('change', function () {
                const permission = $(this).val();
                const isChecked = $(this).is(':checked');
                console.log('Checkbox Changed:', {
                    permission: permission,
                    checked: isChecked
                });
            });

            // Xử lý lưu quyền
            $('#save-permissions-btn').on('click', function () {
                const userId = $('#manage-permissions-modal').data('user-id');
                const selectedPermissions = $('.permission-checkbox:checked').map(function () {
                    return $(this).val();
                }).get();
                const banNganhId = $('#modal-ban-nganh').val() || null;

                // Log để kiểm tra danh sách quyền được gửi
                console.log('Saving Permissions:', {
                    userId: userId,
                    selectedPermissions: selectedPermissions,
                    banNganhId: banNganhId
                });

                $.ajax({
                    url: '{{ route("_phan_quyen.update_permissions", ":userId") }}'.replace(':userId', userId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        permissions: selectedPermissions,
                        ban_nganh_id: banNganhId
                    },
                    success: function (response) {
                        toastr.success(response.success || 'Đã cập nhật quyền thành công.');
                        $('#manage-permissions-modal').modal('hide');
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON.error || 'Đã xảy ra lỗi khi cập nhật quyền.');
                        console.error('Error saving permissions:', xhr.responseJSON);
                    }
                });
            });
        });
    </script>
    <style>
        .permission-checkbox:disabled {
            opacity: 0.5;
        }
        .ban-nganh-select {
            display: none;
        }
        .accordion .card-header button {
            color: #007bff;
            text-decoration: none;
        }
        .accordion .card-header button:hover {
            text-decoration: underline;
        }
    </style>
@endsection