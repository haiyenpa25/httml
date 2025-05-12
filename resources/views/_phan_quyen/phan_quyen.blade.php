@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Quản Lý Phân Quyền Người Dùng</h3>
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
                                    <th>Default URL</th>
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
                                        </td>
                                        <td>
                                            @php
                                                $urls = $user->quyen()->whereNotNull('default_url')->distinct()->pluck('default_url')->toArray();
                                                \Log::info('Default URLs for user ' . $user->id . ' (initial load): ', $urls);
                                            @endphp
                                            <select class="form-control select2bs4 default-url-select" data-user-id="{{ $user->id }}" {{ $user->email === 'admin1@example.com' ? 'disabled' : '' }}>
                                                <option value="">-- Chọn URL --</option>
                                                @if (empty($urls))
                                                    <option value="" disabled>Không có URL khả dụng</option>
                                                @else
                                                    @foreach ($urls as $url)
                                                        <option value="{{ $url }}" {{ $user->default_url == $url ? 'selected' : '' }}>{{ $url }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
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

            $('.role-select').on('change', function () {
                const userId = $(this).data('user-id');
                const role = $(this).val();
                const managePermissionsBtn = $(this).closest('tr').find('.btn');

                if (role === 'quan_tri') {
                    managePermissionsBtn.addClass('disabled');
                } else {
                    managePermissionsBtn.removeClass('disabled');
                }

                $.ajax({
                    url: '{{ route("_phan_quyen.update_role", ":userId") }}'.replace(':userId', userId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        role: role,
                        ban_nganh: null,
                        ban_nganh_id: null
                    },
                    success: function (response) {
                        toastr.success(response.success || 'Đã cập nhật vai trò thành công.');
                        // Cập nhật lại danh sách default_url
                        updateDefaultUrlSelect(userId);
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON.error || 'Đã xảy ra lỗi khi cập nhật vai trò.');
                        console.error('Error updating role:', xhr.responseJSON);
                    }
                });
            });

            $('.default-url-select').on('change', function () {
                const userId = $(this).data('user-id');
                const defaultUrl = $(this).val();

                console.log('Updating default URL for user ' + userId + ':', defaultUrl);

                $.ajax({
                    url: '{{ route("_phan_quyen.update_default_url", ":userId") }}'.replace(':userId', userId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        default_url: defaultUrl
                    },
                    success: function (response) {
                        toastr.success(response.success || 'Đã cập nhật URL mặc định thành công.');
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON.error || 'Đã xảy ra lỗi khi cập nhật URL mặc định.');
                        console.error('Error updating default URL:', xhr.responseJSON);
                    }
                });
            });

            // Hàm cập nhật danh sách default_url sau khi thay đổi vai trò
            function updateDefaultUrlSelect(userId) {
                $.ajax({
                    url: '{{ route("_phan_quyen.get_user_default_urls", ":userId") }}'.replace(':userId', userId),
                    method: 'GET',
                    success: function (urls) {
                        console.log('Default URLs for user ' + userId + ' (AJAX):', urls);
                        const select = $(`.default-url-select[data-user-id="${userId}"]`);
                        select.empty().append('<option value="">-- Chọn URL --</option>');
                        if (urls.length === 0) {
                            console.warn('No default URLs available for user ' + userId);
                            select.append('<option value="" disabled>Không có URL khả dụng</option>');
                            toastr.warning('Không có URL mặc định nào cho người dùng này.');
                        } else {
                            urls.forEach(url => {
                                select.append(`<option value="${url}">${url}</option>`);
                            });
                        }
                        select.val('').trigger('change.select2');
                        console.log('Select2 updated for user ' + userId + ', options count:', select.find('option').length);
                    },
                    error: function (xhr) {
                        console.error('Error fetching default URLs:', xhr.responseJSON);
                        toastr.error('Không thể tải danh sách URL mặc định.');
                    }
                });
            }
        });
    </script>
    <style>
        .card {
            border-radius: 0.5rem;
        }
        .card-header {
            border-radius: 0.5rem 0.5rem 0 0;
        }
        .table th, .table td {
            vertical-align: middle;
            padding: 12px;
        }
        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection