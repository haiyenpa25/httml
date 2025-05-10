@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-user-shield mr-2"></i>Phân Quyền Người Dùng: <span class="font-weight-bold">{{ $user->email }}</span>
                    </h3>
                    <a href="{{ route('_phan_quyen.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i>Quay Lại
                    </a>
                </div>
                <div class="card-body pb-0">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Thành công!</h5>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Lỗi!</h5>
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="user-info-card mb-4">
                        <div class="row">
                            <div class="col-md-1 text-center">
                                <div class="avatar-circle">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="col-md-11">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">{{ $user->name ?? $user->email }}</h5>
                                        <p class="text-muted mb-0"><i class="fas fa-envelope mr-1"></i>{{ $user->email }}</p>
                                    </div>
                                    <div class="permission-summary">
                                        <span class="badge badge-primary"><i class="fas fa-shield-alt mr-1"></i>{{ count($userPermissions) }} quyền</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="search-container mb-4">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-primary"></i></span>
                            </div>
                            <input type="text" id="permission-search" class="form-control border-left-0" placeholder="Tìm kiếm quyền hoặc URL...">
                        </div>
                    </div>

                    <form id="permissions-form" method="POST" action="{{ route('_phan_quyen.update_permissions', $user->id) }}">
                        @csrf
                        <div class="accordion permissions-accordion" id="permissions-accordion">
                            @foreach ($permissions as $group => $groupPermissions)
                                <div class="card permission-card mb-3">
                                    <div class="card-header permission-header" id="heading-{{ Str::slug($group) }}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-{{ Str::slug($group) }}" aria-expanded="false" aria-controls="collapse-{{ Str::slug($group) }}">
                                                    <i class="fas fa-folder mr-2"></i>{{ $group }}
                                                </button>
                                            </h2>
                                            <div>
                                                <span class="badge badge-info permission-count">{{ count($groupPermissions) }} quyền</span>
                                                <button class="btn btn-sm btn-outline-primary select-all-btn ml-2" type="button" data-group="{{ Str::slug($group) }}">
                                                    <i class="fas fa-check-square mr-1"></i>Chọn tất cả
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary deselect-all-btn ml-1" type="button" data-group="{{ Str::slug($group) }}">
                                                    <i class="fas fa-square mr-1"></i>Bỏ chọn tất cả
                                                </button>
                                                <button class="btn btn-collapse-toggle" type="button" data-toggle="collapse" data-target="#collapse-{{ Str::slug($group) }}" aria-expanded="false" aria-controls="collapse-{{ Str::slug($group) }}">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapse-{{ Str::slug($group) }}" class="collapse" aria-labelledby="heading-{{ Str::slug($group) }}" data-parent="#permissions-accordion">
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover permissions-table mb-0" data-group="{{ Str::slug($group) }}">
                                                    <thead>
                                                        <tr>
                                                            <th width="40%">Quyền</th>
                                                            <th class="text-center" width="20%">Mã</th>
                                                            <th class="text-center" width="20%">Default URL</th>
                                                            <th class="text-center" width="20%">Trạng thái</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($groupPermissions as $permission => $data)
                                                            <tr class="permission-row">
                                                                <td class="permission-name">
                                                                    <label for="perm-{{ $permission }}" class="mb-0 d-flex align-items-center">
                                                                        <span class="permission-icon mr-2">
                                                                            @if (Str::contains($permission, 'create'))
                                                                                <i class="fas fa-plus-circle text-success"></i>
                                                                            @elseif (Str::contains($permission, 'view'))
                                                                                <i class="fas fa-eye text-info"></i>
                                                                            @elseif (Str::contains($permission, 'edit'))
                                                                                <i class="fas fa-edit text-primary"></i>
                                                                            @elseif (Str::contains($permission, 'delete'))
                                                                                <i class="fas fa-trash-alt text-danger"></i>
                                                                            @elseif (Str::contains($permission, 'manage'))
                                                                                <i class="fas fa-cogs text-warning"></i>
                                                                            @else
                                                                                <i class="fas fa-lock text-secondary"></i>
                                                                            @endif
                                                                        </span>
                                                                        {{ $data['description'] }}
                                                                    </label>
                                                                </td>
                                                                <td class="text-center permission-code">
                                                                    <code>{{ $permission }}</code>
                                                                </td>
                                                                <td class="text-center permission-url">
                                                                    <span class="badge badge-light">{{ $data['default_url'] ?? 'N/A' }}</span>
                                                                </td>
                                                                <td class="text-center">
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" class="custom-control-input permission-checkbox" id="perm-{{ $permission }}" name="permissions[]" value="{{ $permission }}" data-permission="{{ $permission }}" {{ in_array($permission, $userPermissions) ? 'checked' : '' }}>
                                                                        <label class="custom-control-label" for="perm-{{ $permission }}"></label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="form-actions py-3 text-right sticky-actions">
                            <button type="button" class="btn btn-outline-secondary mr-2" onclick="window.location.href='{{ route('_phan_quyen.index') }}'">
                                <i class="fas fa-times mr-1"></i>Hủy
                            </button>
                            <button type="submit" class="btn btn-primary save-button">
                                <i class="fas fa-save mr-1"></i>Lưu Quyền
                            </button>
                        </div>
                    </form>
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

            // Khởi tạo DataTables cho từng bảng quyền
            $('.permissions-table').each(function () {
                const group = $(this).data('group');
                $(this).DataTable({
                    paging: false,
                    lengthChange: false,
                    searching: true,
                    ordering: true,
                    info: false,
                    autoWidth: false,
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json'
                    },
                    columnDefs: [
                        { orderable: false, targets: [2, 3] }
                    ]
                });
            });

            // Animation when toggling accordion panels
            $('.btn-collapse-toggle').on('click', function() {
                $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
            });

            // Xử lý nút chọn tất cả
            $(document).on('click', '.select-all-btn', function (e) {
                e.preventDefault();
                const group = $(this).data('group');
                $(`.permissions-table[data-group="${group}"] .permission-checkbox`).prop('checked', true).trigger('change');
                console.log('Selected all permissions in group:', group);
                toastr.info(`Đã chọn tất cả quyền trong nhóm "${group}"`);
            });

            // Xử lý nút bỏ chọn tất cả
            $(document).on('click', '.deselect-all-btn', function (e) {
                e.preventDefault();
                const group = $(this).data('group');
                $(`.permissions-table[data-group="${group}"] .permission-checkbox`).prop('checked', false).trigger('change');
                console.log('Deselected all permissions in group:', group);
                toastr.info(`Đã bỏ chọn tất cả quyền trong nhóm "${group}"`);
            });

            // Theo dõi thay đổi checkbox
            $(document).on('change', '.permission-checkbox', function () {
                const permission = $(this).val();
                const isChecked = $(this).is(':checked');
                console.log('Checkbox Changed:', {
                    permission: permission,
                    checked: isChecked
                });
                
                // Update the counter
                updatePermissionCounter();
            });
            
            // Function to update the permission counter
            function updatePermissionCounter() {
                const totalChecked = $('.permission-checkbox:checked').length;
                $('.permission-summary .badge').html(`<i class="fas fa-shield-alt mr-1"></i>${totalChecked} quyền`);
            }
            
            // Initialize the counter
            updatePermissionCounter();
            
            // Search function
            $('#permission-search').on('keyup', function() {
                const searchText = $(this).val().toLowerCase();
                
                $('.permission-row').each(function() {
                    const permissionName = $(this).find('.permission-name').text().toLowerCase();
                    const permissionCode = $(this).find('.permission-code').text().toLowerCase();
                    const permissionUrl = $(this).find('.permission-url').text().toLowerCase();
                    
                    if (permissionName.includes(searchText) || permissionCode.includes(searchText) || permissionUrl.includes(searchText)) {
                        $(this).show();
                        // Expand the parent accordion if it contains matching items
                        const accordionId = $(this).closest('.collapse').attr('id');
                        $(`[data-target="#${accordionId}"]`).removeClass('collapsed');
                        $(`#${accordionId}`).addClass('show');
                        $(`[data-target="#${accordionId}"]`).find('i.fa-chevron-down').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                    } else {
                        $(this).hide();
                    }
                });
                
                // Check if any rows are visible in each group
                $('.permissions-table').each(function() {
                    const visibleRows = $(this).find('tbody tr:visible').length;
                    if (visibleRows === 0) {
                        $(this).closest('.permission-card').hide();
                    } else {
                        $(this).closest('.permission-card').show();
                    }
                });
                
                if (searchText === '') {
                    $('.permission-card').show();
                    $('.permission-row').show();
                    $('.collapse').removeClass('show');
                    $('.btn-collapse-toggle i.fa-chevron-up').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                }
            });

            // Scroll effect
            $(window).scroll(function() {
                if ($(window).scrollTop() > 300) {
                    $('.sticky-actions').addClass('fixed-bottom bg-white shadow-lg py-3 px-3');
                } else {
                    $('.sticky-actions').removeClass('fixed-bottom bg-white shadow-lg py-3 px-3');
                }
            });

            // Xử lý submit form
            $('#permissions-form').on('submit', function (e) {
                e.preventDefault();
                
                // Add animation to save button
                $('.save-button').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Đang lưu...');
                
                const userId = {{ $user->id }};
                const selectedPermissions = $('.permission-checkbox:checked').map(function () {
                    return $(this).val();
                }).get();

                console.log('Saving Permissions:', {
                    userId: userId,
                    selectedPermissions: selectedPermissions
                });

                $.ajax({
                    url: '{{ route("_phan_quyen.update_permissions", $user->id) }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        permissions: selectedPermissions
                    },
                    success: function (response) {
                        toastr.success(response.success || 'Đã cập nhật quyền thành công.');
                        setTimeout(function() {
                            window.location.href = '{{ route("_phan_quyen.index") }}';
                        }, 1000);
                    },
                    error: function (xhr) {
                        $('.save-button').prop('disabled', false).html('<i class="fas fa-save mr-1"></i>Lưu Quyền');
                        toastr.error(xhr.responseJSON.error || 'Đã xảy ra lỗi khi cập nhật quyền.');
                        console.error('Error saving permissions:', xhr.responseJSON);
                    }
                });
            });
        });
    </script>
    <style>
        /* Card styling */
        .card {
            border: none;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: all 0.3s ease;
        }
        
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            padding: 0.75rem 1.25rem;
        }
        
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }
        
        /* User info card */
        .user-info-card {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
            border-left: 4px solid #007bff;
        }
        
        .avatar-circle {
            width: 50px;
            height: 50px;
            background-color: #007bff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto;
        }
        
        /* Permission accordion styling */
        .permissions-accordion .card {
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .permissions-accordion .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        .permission-header {
            background-color: #f8f9fa;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem !important;
        }
        
        .permissions-accordion .btn-link {
            color: #212529;
            font-weight: 600;
            text-decoration: none;
            font-size: 1rem;
            padding: 0;
        }
        
        .permissions-accordion .btn-link:hover,
        .permissions-accordion .btn-link:focus {
            color: #007bff;
            text-decoration: none;
        }
        
        .permissions-accordion .btn-collapse-toggle {
            background: none;
            border: none;
            color: #6c757d;
            transition: transform 0.3s ease;
        }
        
        .permissions-accordion .btn-collapse-toggle:focus {
            outline: none;
        }
        
        /* Table styling */
        .permissions-table {
            margin-bottom: 0;
        }
        
        .permissions-table thead {
            background-color: #f8f9fa;
        }
        
        .permissions-table thead th {
            border-top: none;
            font-weight: 600;
            color: #495057;
        }
        
        .permissions-table tbody tr {
            transition: background-color 0.2s;
        }
        
        .permissions-table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }
        
        .permissions-table td {
            vertical-align: middle;
            padding: 0.75rem 1rem;
            border-color: #e9ecef;
        }
        
        /* Permission code and URL */
        .permission-code code, .permission-url .badge {
            background-color: #f8f9fa;
            padding: 0.2rem 0.4rem;
            font-size: 0.85rem;
            color: #6c757d;
            border-radius: 0.25rem;
        }
        
        .permission-url .badge {
            background-color: #e9ecef;
        }
        
        /* Search bar */
        .search-container {
            position: relative;
        }
        
        #permission-search {
            border-radius: 50px;
            padding-left: 2.5rem;
            height: 45px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .search-container .input-group-text {
            border-radius: 50px 0 0 50px;
            background-color: transparent;
        }
        
        /* Custom switch */
        .custom-switch .custom-control-label::before {
            width: 2rem;
            height: 1rem;
        }
        
        .custom-switch .custom-control-label::after {
            width: calc(1rem - 4px);
            height: calc(1rem - 4px);
        }
        
        .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #28a745;
            border-color: #28a745;
        }
        
        /* Sticky actions */
        .sticky-actions {
            transition: all 0.3s ease;
            z-index: 100;
        }
        
        .fixed-bottom {
            border-top: 1px solid #dee2e6;
        }
        
        /* Buttons */
        .btn {
            border-radius: 0.25rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        
        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn-outline-primary {
            color: #007bff;
            border-color: #007bff;
        }
        
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }
        
        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
        }
        
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #fff;
        }
        
        /* Badge styling */
        .badge-info {
            background-color: #17a2b8;
            font-weight: 500;
            padding: 0.4em 0.6em;
        }
        
        .badge-primary {
            background-color: #007bff;
            font-weight: 500;
            padding: 0.4em 0.6em;
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.3s ease forwards;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .permission-header .d-flex {
                flex-direction: column;
                align-items: flex-start !important;
            }
            
            .permission-header .d-flex > div {
                margin-top: 10px;
                display: flex;
                flex-wrap: wrap;
            }
            
            .btn-sm {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
            
            .permissions-table th, .permissions-table td {
                font-size: 0.85rem;
                padding: 0.5rem;
            }
        }
    </style>
@endsection