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
                                            <a href="{{ route('_phan_quyen.user', $user->id) }}" class="btn btn-primary btn-sm {{ $user->vai_tro === 'quan_tri' ? 'disabled' : '' }}">
                                                Quản Lý Quyền
                                            </a>
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
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json'
                }
            });

            // Xử lý khi thay đổi vai trò
            $('.role-select').on('change', function () {
                const userId = $(this).data('user-id');
                const role = $(this).val();
                const banNganhSelect = $(this).closest('tr').find('.ban-nganh-select');
                const managePermissionsBtn = $(this).closest('tr').find('.manage-permissions-btn');

                if (role === 'truong_ban') {
                    banNganhSelect.closest('.mt-2').show();
                    managePermissionsBtn.removeClass('disabled');
                } else {
                    banNganhSelect.closest('.mt-2').hide();
                    banNganhSelect.val('');
                    if (role === 'quan_tri') {
                        managePermissionsBtn.addClass('disabled');
                    } else {
                        managePermissionsBtn.removeClass('disabled');
                    }
                }

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
        });
    </script>
    <style>
        .ban-nganh-select {
            display: none;
        }
    </style>
@endsection