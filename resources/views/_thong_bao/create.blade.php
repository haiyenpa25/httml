@extends('layouts.app')

@section('title', 'Soạn thông báo mới')

@section('page-styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- Summernote -->
<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Soạn thông báo mới</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('thong-bao.index') }}">Thông báo</a></li>
                    <li class="breadcrumb-item active">Soạn thông báo</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Thông báo -->
        <div id="alert-container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-check"></i> Thành công!</h5>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Soạn thông báo</h3>
            </div>
            <!-- /.card-header -->
            <form action="{{ route('thong-bao.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="tieu_de">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tieu_de" name="tieu_de" placeholder="Nhập tiêu đề thông báo" maxlength="255" required value="{{ old('tieu_de') }}">
                    </div>

                    <div class="form-group">
                        <label>Người nhận <span class="text-danger">*</span></label>
                        <div class="card card-default collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Lựa chọn người nhận</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @if($canSendToAll)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tất cả người dùng</label>
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="select-all-users">
                                                <label for="select-all-users" class="custom-control-label">Chọn tất cả</label>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Theo ban ngành</label>
                                            <select class="form-control select2" id="ban-nganh-select">
                                                <option value="">-- Chọn ban ngành --</option>
                                                @foreach($cacBanNganh as $banNganh)
                                                    <option value="{{ $banNganh->id }}">{{ $banNganh->ten }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Trưởng ban</label>
                                            <select class="form-control select2" id="truong-ban-select">
                                                <option value="">-- Chọn ban ngành --</option>
                                                @foreach($cacBanNganh as $banNganh)
                                                    <option value="{{ $banNganh->id }}">{{ $banNganh->ten }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label>Tìm kiếm người nhận</label>
                                    <input type="text" class="form-control" id="search-users" placeholder="Nhập tên để tìm kiếm">
                                </div>

                                <div class="form-group">
                                    <label>Danh sách người dùng</label>
                                    <select class="form-control select2" id="user-select" multiple style="width: 100%;">
                                        <!-- Danh sách người dùng sẽ được nạp bằng AJAX -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Người nhận đã chọn <span class="text-danger">*</span></label>
                            <div class="selected-users-container p-2 border rounded" style="min-height: 100px;">
                                <div id="selected-users" class="d-flex flex-wrap">
                                    <!-- Người nhận đã chọn -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="noi_dung">Nội dung <span class="text-danger">*</span></label>
                        <textarea id="noi_dung" name="noi_dung" class="form-control summernote" style="height: 300px" required>{{ old('noi_dung') }}</textarea>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="float-right">
                        <button type="button" class="btn btn-default" onclick="window.location='{{ route('thong-bao.index') }}'"><i class="fas fa-times"></i> Hủy</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Gửi</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('page-scripts')
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Khởi tạo Select2
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        // Khởi tạo Summernote
        $('.summernote').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        // Biến để lưu trữ danh sách người dùng
        let allUsers = [];
        let selectedUsers = [];

        // Hàm tải danh sách người dùng
        function loadAllUsers() {
            $.ajax({
                url: "{{ route('api.users.all') }}",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    allUsers = response.users;
                    populateUserSelect(allUsers);
                },
                error: function() {
                    toastr.error('Không thể tải danh sách người dùng. Vui lòng thử lại sau.');
                }
            });
        }

        // Hàm tải danh sách người dùng theo ban ngành
        function loadUsersByBanNganh(banNganhId) {
            if (!banNganhId) return;

            $.ajax({
                url: "{{ url('api/users/ban-nganh') }}/" + banNganhId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    const users = response.users;
                    populateUserSelect(users);
                },
                error: function() {
                    toastr.error('Không thể tải danh sách người dùng. Vui lòng thử lại sau.');
                }
            });
        }

        // Hàm tải trưởng ban của ban ngành
        function loadTruongBan(banNganhId) {
            if (!banNganhId) return;

            $.ajax({
                url: "{{ url('api/users/truong-ban') }}/" + banNganhId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.user) {
                        addSelectedUser(response.user.id, response.user.ho_ten);
                    } else {
                        toastr.info('Ban ngành này chưa có trưởng ban.');
                    }
                },
                error: function() {
                    toastr.error('Không thể tải thông tin trưởng ban. Vui lòng thử lại sau.');
                }
            });
        }

        // Hàm điền danh sách người dùng vào select
        function populateUserSelect(users) {
            const $userSelect = $('#user-select');
            $userSelect.empty();

            users.forEach(user => {
                $userSelect.append(new Option(user.ho_ten, user.id, false, false));
            });

            $userSelect.trigger('change');
        }

        // Hàm thêm người dùng đã chọn
        function addSelectedUser(userId, userName) {
            // Kiểm tra xem người dùng đã được chọn chưa
            if (selectedUsers.some(u => u.id === userId)) {
                return;
            }

            // Thêm vào danh sách đã chọn
            selectedUsers.push({ id: userId, ho_ten: userName });
            
            // Hiển thị UI
            const $selectedUser = $(`
                <div class="selected-user badge bg-primary m-1 p-2" data-id="${userId}">
                    ${userName}
                    <input type="hidden" name="nguoi_nhan[]" value="${userId}">
                    <button type="button" class="btn-remove-user btn btn-xs text-white ml-1">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `);
            
            $('#selected-users').append($selectedUser);
        }

        // Hàm xóa người dùng đã chọn
        function removeSelectedUser(userId) {
            selectedUsers = selectedUsers.filter(u => u.id !== userId);
            $(`.selected-user[data-id="${userId}"]`).remove();
        }

        // Tải ban đầu danh sách người dùng
        loadAllUsers();

        // Sự kiện khi chọn ban ngành
        $('#ban-nganh-select').on('change', function() {
            const banNganhId = $(this).val();
            if (banNganhId) {
                loadUsersByBanNganh(banNganhId);
            } else {
                loadAllUsers();
            }
        });

        // Sự kiện khi chọn trưởng ban
        $('#truong-ban-select').on('change', function() {
            const banNganhId = $(this).val();
            if (banNganhId) {
                loadTruongBan(banNganhId);
            }
        });

        // Sự kiện khi chọn người dùng từ danh sách
        $('#user-select').on('change', function() {
            const selectedOptions = $(this).select2('data');
            selectedOptions.forEach(option => {
                if (option.id && option.text) {
                    addSelectedUser(option.id, option.text);
                }
            });
            
            // Reset select
            $(this).val(null).trigger('change');
        });

        // Sự kiện khi xóa người dùng đã chọn
        $(document).on('click', '.btn-remove-user', function() {
            const $selectedUser = $(this).closest('.selected-user');
            const userId = $selectedUser.data('id');
            removeSelectedUser(userId);
        });

        // Sự kiện khi tìm kiếm người dùng
        $('#search-users').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            
            if (searchTerm.length < 2) {
                return;
            }
            
            const filteredUsers = allUsers.filter(user => 
                user.ho_ten.toLowerCase().includes(searchTerm)
            );
            
            populateUserSelect(filteredUsers);
        });

        // Sự kiện khi chọn tất cả người dùng
        $('#select-all-users').on('change', function() {
            if ($(this).is(':checked')) {
                allUsers.forEach(user => {
                    addSelectedUser(user.id, user.ho_ten);
                });
            } else {
                // Xóa tất cả người dùng đã chọn
                selectedUsers = [];
                $('#selected-users').empty();
            }
        });

        // Kiểm tra form trước khi submit
        $('form').on('submit', function(e) {
            if (selectedUsers.length === 0) {
                e.preventDefault();
                toastr.error('Vui lòng chọn ít nhất một người nhận.');
            }
        });
    });
</script>
@endsection