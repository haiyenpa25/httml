@section('page-styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Select2 CSS -->
    <style>
        /* Select2 adjustments for better mobile compatibility */
        .select2-container--bootstrap4 .select2-selection__rendered {
            color: #333 !important;
            line-height: 34px !important;
            padding-left: 10px !important;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            max-width: 100%;
        }

        .select2-container--bootstrap4 .select2-selection--single {
            height: 38px !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem !important;
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__placeholder {
            color: #6c757d !important;
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
            top: 0 !important;
        }

        /* Ensure select2 is fully responsive */
        .select2 {
            width: 100% !important;
        }

        /* Make dropdowns stay within viewport on mobile */
        .select2-dropdown {
            max-width: 100vw !important;
        }

        /* General styling */
        .content-header {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7ea 100%);
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 10px;
        }

        .content-header h1 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #343a40;
        }

        /* Alert styling */
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        /* Enhanced Button grid with better mobile layout */
        .action-buttons-container {
            margin-bottom: 1rem;
        }

        .button-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 10px;
        }

        .action-btn {
            flex: 1 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            color: #fff;
            text-decoration: none;
            white-space: nowrap;
            text-align: center;
            min-width: 120px;
        }

        .action-btn i {
            margin-right: 8px;
            font-size: 1rem;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            color: #fff;
            text-decoration: none;
        }

        /* Button colors */
        .btn-primary-custom {
            background-color: #007bff;
        }

        .btn-success-custom {
            background-color: #28a745;
        }

        .btn-info-custom {
            background-color: #17a2b8;
        }

        .btn-warning-custom {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-danger-custom {
            background-color: #dc3545;
        }

        /* Filter card */
        .card-secondary {
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 15px 20px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #343a40;
        }

        .card-body {
            padding: 20px;
        }

        /* DataTables */
        .card-primary,
        .card-success {
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }

        .table {
            margin-bottom: 0;
            width: 100%;
            /* Đảm bảo bảng chiếm toàn bộ chiều rộng */
        }

        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #343a40;
            padding: 12px;
            font-size: 1rem;
            /* Tăng kích thước font chữ cho tiêu đề cột */
        }

        /* Tùy chỉnh bảng điểm mạnh và điểm yếu */
        #diem-manh-table,
        #diem-yeu-table {
            width: 100% !important;
            /* Đảm bảo bảng chiếm toàn bộ chiều rộng */
            table-layout: auto;
            /* Cho phép cột tự điều chỉnh theo nội dung */
        }

        #diem-manh-table th,
        #diem-manh-table td,
        #diem-yeu-table th,
        #diem-yeu-table td {
            padding: 12px 15px;
            /* Tăng padding cho các ô */
            font-size: 1rem;
            /* Tăng kích thước font chữ */
            vertical-align: middle;
            /* Căn giữa nội dung theo chiều dọc */
        }

        #diem-manh-table th:nth-child(1),
        #diem-yeu-table th:nth-child(1) {
            width: 8%;
            /* Cột STT */
            min-width: 60px;
            /* Chiều rộng tối thiểu */
        }

        #diem-manh-table th:nth-child(2),
        #diem-yeu-table th:nth-child(2) {
            width: 50%;
            /* Cột Nội dung */
            min-width: 300px;
            /* Chiều rộng tối thiểu */
        }

        #diem-manh-table th:nth-child(3),
        #diem-yeu-table th:nth-child(3) {
            width: 30%;
            /* Cột Người đánh giá */
            min-width: 200px;
            /* Chiều rộng tối thiểu */
        }

        #diem-manh-table th:nth-child(4),
        #diem-yeu-table th:nth-child(4) {
            width: 12%;
            /* Cột Thao tác */
            min-width: 100px;
            /* Chiều rộng tối thiểu */
        }

        /* Thêm cuộn ngang nếu nội dung dài */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            /* Hỗ trợ cuộn mượt trên thiết bị di động */
        }

        /* DataTables Responsive */
        table.dataTable.dtr-column>tbody>tr>td.dtr-control:before,
        table.dataTable.dtr-column>tbody>tr>th.dtr-control:before {
            content: '+';
            display: inline-block;
            width: 20px;
            height: 20px;
            line-height: 20px;
            text-align: center;
            background-color: #007bff;
            color: white;
            border-radius: 3px;
            cursor: pointer;
        }

        table.dataTable.dtr-column>tbody>tr.parent>td.dtr-control:before {
            content: '-';
        }

        /* Modal adjustments for better mobile experience */
        .modal-content {
            border-radius: 10px;
        }

        .modal-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 15px 20px;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #343a40;
        }

        .modal-body {
            padding: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .content-header h1 {
                font-size: 1.5rem;
            }

            .breadcrumb {
                font-size: 0.875rem;
            }

            .action-btn {
                font-size: 0.875rem;
                padding: 10px 12px;
                width: 100%;
                min-width: unset;
            }

            .action-btn i {
                font-size: 1rem;
            }

            .button-row {
                flex-direction: column;
                gap: 8px;
            }

            .card-header {
                padding: 12px 15px;
            }

            .card-title {
                font-size: 1.1rem;
            }

            .card-body {
                padding: 15px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .form-control,
            .select2-container .select2-selection {
                font-size: 16px !important;
            }

            .modal-title {
                font-size: 1.1rem;
            }

            .table td,
            .table th {
                padding: 0.5rem;
                font-size: 0.875rem;
            }

            .btn-sm {
                padding: 4px 8px;
                font-size: 0.75rem;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .action-btn {
                font-size: 0.9rem;
                padding: 10px;
            }

            .button-row {
                gap: 8px;
            }
        }

        @media (min-width: 992px) {
            .button-row {
                gap: 10px;
            }

            .action-btn {
                min-width: 150px;
            }
        }
    </style>
@endsection

@section('page-scripts')
    <script>
        $(function () {
            // Hàm chuẩn hóa giá trị tiền tệ
            function cleanMoneyFormat(value) {
                if (!value) return '0';
                return value.replace(/[^0-9]/g, '');
            }

            // Hàm định dạng giá trị tiền tệ
            function formatMoney(value) {
                return new Intl.NumberFormat('vi-VN').format(value);
            }

            // Định dạng giá trị ban đầu cho tất cả input có class money-format
            $('.money-format').each(function () {
                let value = $(this).val();
                let cleanedValue = cleanMoneyFormat(value);
                $(this).val(formatMoney(cleanedValue));
            });

            // Xử lý định dạng tiền tệ khi nhập
            $('.money-format').on('input', function () {
                let value = $(this).val().replace(/\D/g, '');
                $(this).val(formatMoney(value));
            });

            // Tự động gửi form khi thay đổi buoi_nhom_type
            $('#buoi_nhom_type').on('change', function () {
                console.log('Đã thay đổi buoi_nhom_type:', $(this).val());
                $('#filter-form').submit();
            });

            // Xử lý cập nhật số lượng tham dự riêng lẻ
            $('.update-count').on('click', function (e) {
                e.stopPropagation();
                const buoiNhomId = $(this).data('id');
                const type = $(this).data('type');
                const row = $(this).closest('tr');

                let soLuongBanNganh = row.find(`input[name="buoi_nhom[${buoiNhomId}][so_luong_trung_lao]"]`).val();
                let data = {
                    _token: '{{ csrf_token() }}',
                    id: buoiNhomId,
                    so_luong_trung_lao: soLuongBanNganh ? parseInt(soLuongBanNganh) : 0
                };

                if (type === 'bn') {
                    let dangHien = row.find(`input[name="buoi_nhom[${buoiNhomId}][dang_hien]"]`).val();
                    let cleanedDangHien = cleanMoneyFormat(dangHien);
                    data.dang_hien = cleanedDangHien;
                }

                console.log('Gửi yêu cầu cập nhật số lượng tham dự:', data);

                $.ajax({
                    url: '{{ route("_ban_nganh.trung_lao.update_tham_du") }}',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    beforeSend: function () {
                        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (cập nhật số lượng tham dự):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra khi lưu!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (cập nhật số lượng tham dự):', xhr.responseJSON);
                        toastr.error(xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!');
                    },
                    complete: function () {
                        $(this).prop('disabled', false).html('<i class="fas fa-save"></i> Lưu');
                    }
                });
            });

            // Xử lý form điểm danh
            $('#thamdu-form').on('submit', function (e) {
                e.preventDefault();
                let formData = $(this).serializeArray();
                let cleanedData = {};

                formData.forEach(item => {
                    if (item.name.includes('dang_hien')) {
                        let cleanedValue = cleanMoneyFormat(item.value);
                        cleanedData[item.name] = cleanedValue;
                    } else if (item.name === 'month') {
                        cleanedData[item.name] = parseInt(item.value);
                    } else {
                        cleanedData[item.name] = item.value;
                    }
                });

                console.log('Gửi yêu cầu lưu điểm danh:', cleanedData);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: cleanedData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (lưu điểm danh):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (lưu điểm danh):', xhr.responseJSON);
                        toastr.error(xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!');
                    },
                    complete: function () {
                        $('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save"></i> Lưu tất cả thay đổi');
                    }
                });
            });

            // Khởi tạo DataTable cho bảng Nhóm Chúa Nhật (Hội Thánh)
            try {
                $('#buoi-nhom-ht-table').DataTable({
                    processing: true,
                    serverSide: false,
                    responsive: {
                        details: {
                            type: 'column',
                            target: 0,
                            renderer: function (api, rowIdx, columns) {
                                var data = $.map(columns, function (col, i) {
                                    if (!col.hidden) return '';
                                    var content = col.data;
                                    if (i === 4) {
                                        var rowData = api.row(rowIdx).data();
                                        var buoiNhomId = $(rowData[4]).filter('input[name$="[id]"]').val();
                                        content = '<input type="number" class="form-control" ' +
                                            'name="buoi_nhom[' + buoiNhomId + '][so_luong_trung_lao]" ' +
                                            'min="0" value="' + $(rowData[4]).filter('input[name$="[so_luong_trung_lao]"]').val() + '">';
                                    }
                                    return '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                        '<td>' + col.title + ':</td>' +
                                        '<td>' + content + '</td>' +
                                        '</tr>';
                                }).join('');
                                return data ? $('<table class="table"/>').append(data) : false;
                            }
                        }
                    },
                    language: {
                        url: '{{ asset("dist/js/Vietnamese.json") }}'
                    },
                    columnDefs: [
                        {
                            className: 'dt-control',
                            orderable: false,
                            searchable: false,
                            targets: 0
                        },
                        { targets: [0, 1, 4, 5], responsivePriority: 1 },
                        { targets: [2, 3], responsivePriority: 100 },
                        { targets: [4, 5], searchable: false, orderable: false }
                    ],
                    order: [],
                    drawCallback: function (settings) {
                        console.log('DataTables Responsive state (HT):', settings.oInstance.api().responsive.hasHidden());
                    }
                });
            } catch (e) {
                console.error('Lỗi khởi tạo DataTables (buoi-nhom-ht-table):', e);
            }

            // Khởi tạo DataTable cho bảng Nhóm tối thứ 7 (Ban Ngành)
            try {
                $('#buoi-nhom-bn-table').DataTable({
                    processing: true,
                    serverSide: false,
                    responsive: {
                        details: {
                            type: 'column',
                            target: 0,
                            renderer: function (api, rowIdx, columns) {
                                var data = $.map(columns, function (col, i) {
                                    if (!col.hidden) return '';
                                    var content = col.data;
                                    if (i === 4 || i === 5) {
                                        var rowData = api.row(rowIdx).data();
                                        var buoiNhomId = $(rowData[6]).filter('input[name$="[id]"]').val();
                                        if (i === 4) {
                                            content = '<input type="number" class="form-control" ' +
                                                'name="buoi_nhom[' + buoiNhomId + '][so_luong_trung_lao]" ' +
                                                'min="0" value="' + $(rowData[4]).filter('input[name$="[so_luong_trung_lao]"]').val() + '">';
                                        } else if (i === 5) {
                                            content = '<input type="text" class="form-control money-format" ' +
                                                'name="buoi_nhom[' + buoiNhomId + '][dang_hien]" ' +
                                                'value="' + $(rowData[5]).filter('input[name$="[dang_hien]"]').val() + '">';
                                        }
                                    }
                                    return '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                        '<td>' + col.title + ':</td>' +
                                        '<td>' + content + '</td>' +
                                        '</tr>';
                                }).join('');
                                return data ? $('<table class="table"/>').append(data) : false;
                            }
                        }
                    },
                    language: {
                        url: '{{ asset("dist/js/Vietnamese.json") }}'
                    },
                    columnDefs: [
                        {
                            className: 'dt-control',
                            orderable: false,
                            searchable: false,
                            targets: 0
                        },
                        { targets: [0, 1, 4, 5, 6], responsivePriority: 1 },
                        { targets: [2, 3], responsivePriority: 100 },
                        { targets: [4, 5, 6], searchable: false, orderable: false }
                    ],
                    order: [],
                    drawCallback: function (settings) {
                        console.log('DataTables Responsive state (BN):', settings.oInstance.api().responsive.hasHidden());
                        $('.money-format').each(function () {
                            let value = $(this).val();
                            let cleanedValue = cleanMoneyFormat(value);
                            $(this).val(formatMoney(cleanedValue));
                        });
                    }
                });
            } catch (e) {
                console.error('Lỗi khởi tạo DataTables (buoi-nhom-bn-table):', e);
            }

            // Chuẩn bị dữ liệu cho DataTable điểm mạnh
            const diemManhData = @json($diemManhData);
            console.log('Dữ liệu điểm mạnh:', diemManhData);

            // Khởi tạo DataTable cho điểm mạnh
            $('#diem-manh-table').DataTable({
                processing: true,
                serverSide: false,
                responsive: true,
                data: diemManhData,
                columns: [
                    { data: 'stt', title: 'STT', searchable: false, orderable: false },
                    { data: 'noi_dung', title: 'Nội dung' },
                    { data: 'nguoi_danh_gia', title: 'Người đánh giá' },
                    { data: 'thao_tac', title: 'Thao tác', searchable: false, orderable: false }
                ],
                language: {
                    url: '{{ asset("dist/js/Vietnamese.json") }}',
                    emptyTable: 'Không có điểm mạnh nào được ghi nhận trong tháng này.'
                }
            });

            // Chuẩn bị dữ liệu cho DataTable điểm yếu
            const diemYeuData = @json($diemYeuData);
            console.log('Dữ liệu điểm yếu:', diemYeuData);

            // Khởi tạo DataTable cho điểm yếu
            $('#diem-yeu-table').DataTable({
                processing: true,
                serverSide: false,
                responsive: true,
                data: diemYeuData,
                columns: [
                    { data: 'stt', title: 'STT', searchable: false, orderable: false },
                    { data: 'noi_dung', title: 'Nội dung' },
                    { data: 'nguoi_danh_gia', title: 'Người đánh giá' },
                    { data: 'thao_tac', title: 'Thao tác', searchable: false, orderable: false }
                ],
                language: {
                    url: '{{ asset("dist/js/Vietnamese.json") }}',
                    emptyTable: 'Không có điểm yếu nào được ghi nhận trong tháng này.'
                }
            });

            // Xử lý form thêm điểm mạnh
            $('#add-diem-manh-form').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                console.log('Gửi yêu cầu thêm điểm mạnh:', formData);

                $.ajax({
                    url: '{{ route("_ban_nganh.trung_lao.save_danh_gia") }}',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (thêm điểm mạnh):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            $('#modal-add-diem-manh').modal('hide');
                            location.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra khi lưu điểm mạnh!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (thêm điểm mạnh):', xhr.responseJSON);
                        let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                        if (xhr.responseJSON?.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        $('button[type="submit"]').prop('disabled', false).html('Lưu');
                    }
                });
            });

            // Xử lý form thêm điểm yếu
            $('#add-diem-yeu-form').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                console.log('Gửi yêu cầu thêm điểm yếu:', formData);

                $.ajax({
                    url: '{{ route("_ban_nganh.trung_lao.save_danh_gia") }}',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (thêm điểm yếu):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            $('#modal-add-diem-yeu').modal('hide');
                            location.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra khi lưu điểm yếu!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (thêm điểm yếu):', xhr.responseJSON);
                        let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                        if (xhr.responseJSON?.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        $('button[type="submit"]').prop('disabled', false).html('Lưu');
                    }
                });
            });

            // Xử lý xóa điểm mạnh/điểm yếu
            $(document).on('click', '.remove-danh-gia', function () {
                const id = $(this).data('id');
                if (!confirm('Bạn có chắc chắn muốn xóa mục này?')) {
                    return;
                }

                console.log('Gửi yêu cầu xóa đánh giá:', { id: id });

                $.ajax({
                    url: '{{ route("api.ban_nganh.trung_lao.xoa_danh_gia", ["id" => "__ID__"]) }}'.replace('__ID__', id),
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (xóa đánh giá):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            const table = $('#diem-manh-table').DataTable();
                            const row = $(`button[data-id="${id}"]`).closest('tr');
                            table.row(row).remove().draw();
                            // Cập nhật cả diem-yeu-table nếu cần
                            const tableYeu = $('#diem-yeu-table').DataTable();
                            const rowYeu = $(`button[data-id="${id}"]`).closest('tr');
                            tableYeu.row(rowYeu).remove().draw();
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra khi xóa đánh giá!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (xóa đánh giá):', xhr.responseJSON);
                        toastr.error(xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!');
                    }
                });
            });

            // Thêm/xóa kế hoạch
            $('#add-kehoach').on('click', function () {
                let count = $('.kehoach-row').length;
                let html = `
                            <tr class="kehoach-row">
                                <td>${count + 1}</td>
                                <td>
                                    <input type="text" class="form-control" name="kehoach[${count}][hoat_dong]" 
                                           value="" required>
                                    <input type="hidden" name="kehoach[${count}][id]" value="0">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="kehoach[${count}][thoi_gian]" 
                                           value="">
                                </td>
                                <td>
                                    <select class="form-control" name="kehoach[${count}][nguoi_phu_trach_id]">
                                        <option value="">-- Chọn người phụ trách --</option>
                                        @if ($tinHuuBan->isEmpty())
                                            <option value="">Không có tín hữu nào trong {{ $banNganh->ten ?? 'Ban Ngành' }}</option>
                                        @else
                                            @foreach($tinHuuBan as $tinHuu)
                                                @if ($tinHuu)
                                                    <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </td>
                                <td>
                                    <textarea class="form-control" name="kehoach[${count}][ghi_chu]"></textarea>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-kehoach">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                $('#kehoach-tbody').append(html);
                reindexKehoach();
            });

            $(document).on('click', '.remove-kehoach', function () {
                console.log('Nút remove-kehoach được click');
                const $row = $(this).closest('tr');
                if ($('.kehoach-row').length > 1) {
                    $row.remove();
                    reindexKehoach();
                } else {
                    toastr.warning('Không thể xóa hàng cuối cùng. Nội dung đã được xóa.');
                    $row.find('input[type="text"], textarea').val('');
                    $row.find('select').val('');
                }
            });

            function reindexKehoach() {
                $('.kehoach-row').each(function (index) {
                    $(this).find('td:first').text(index + 1);
                    $(this).find('input[name$="[hoat_dong]"]').attr('name', `kehoach[${index}][hoat_dong]`);
                    $(this).find('input[name$="[id]"]').attr('name', `kehoach[${index}][id]`);
                    $(this).find('input[name$="[thoi_gian]"]').attr('name', `kehoach[${index}][thoi_gian]`);
                    $(this).find('select[name$="[nguoi_phu_trach_id]"]').attr('name', `kehoach[${index}][nguoi_phu_trach_id]`);
                    $(this).find('textarea[name$="[ghi_chu]"]').attr('name', `kehoach[${index}][ghi_chu]`);
                });
            }

            // Xử lý form kế hoạch
            $('#kehoach-form').on('submit', function (e) {
                e.preventDefault();

                $('.kehoach-row').each(function () {
                    const hoatDong = $(this).find('input[name$="[hoat_dong]"]').val().trim();
                    if (!hoatDong) {
                        $(this).remove();
                    }
                });

                if ($('.kehoach-row').length === 0) {
                    toastr.error('Vui lòng nhập ít nhất một kế hoạch!');
                    return;
                }

                const formData = $(this).serialize();
                console.log('Gửi yêu cầu lưu kế hoạch:', formData);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (lưu kế hoạch):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra khi lưu kế hoạch!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (lưu kế hoạch):', xhr.responseJSON);
                        let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                        if (xhr.responseJSON?.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        $('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save"></i> Lưu kế hoạch');
                    }
                });
            });

            // Thêm/xóa kiến nghị
            $('#add-kiennghi').on('click', function () {
                let count = $('.kiennghi-card').length;
                let html = `
                            <div class="card mb-3 kiennghi-card">
                                <div class="card-header bg-light">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="m-0">Kiến nghị #${count + 1}</h6>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-danger btn-sm remove-kiennghi">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Tiêu đề:</label>
                                        <input type="text" class="form-control" name="kiennghi[${count}][tieu_de]" 
                                               value="" required>
                                        <input type="hidden" name="kiennghi[${count}][id]" value="0">
                                    </div>
                                    <div class="form-group">
                                        <label>Nội dung:</label>
                                        <textarea class="form-control" name="kiennghi[${count}][noi_dung]" 
                                                  rows="3" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Người đề xuất:</label>
                                        <select class="form-control" name="kiennghi[${count}][nguoi_de_xuat_id]">
                                            <option value="">-- Chọn người đề xuất --</option>
                                            @if ($tinHuuBan->isEmpty())
                                                <option value="">Không có tín hữu nào trong {{ $banNganh->ten ?? 'Ban Ngành' }}</option>
                                            @else
                                                @foreach($tinHuuBan as $tinHuu)
                                                    @if ($tinHuu)
                                                        <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        `;
                $('#kiennghi-container').append(html);
                reindexKiennghi();
            });

            $(document).on('click', '.remove-kiennghi', function () {
                const card = $(this).closest('.kiennghi-card');
                const id = card.find('input[name$="[id]"]').val();

                if (id != '0' && !confirm('Bạn có chắc chắn muốn xóa kiến nghị này?')) {
                    return;
                }

                if (id != '0') {
                    console.log('Gửi yêu cầu xóa kiến nghị:', { id: id });

                    $.ajax({
                        url: '{{ route("api.ban_nganh.trung_lao.xoa_kien_nghi", ["id" => "__ID__"]) }}'.replace('__ID__', id),
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            console.log('Phản hồi từ server (xóa kiến nghị):', response);
                            if (response.success) {
                                toastr.success(response.message);
                                card.remove();
                                reindexKiennghi();
                            } else {
                                toastr.error(response.message || 'Có lỗi xảy ra khi xóa kiến nghị!');
                            }
                        },
                        error: function (xhr) {
                            console.error('Lỗi AJAX (xóa kiến nghị):', xhr.responseJSON);
                            let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                            if (xhr.responseJSON?.errors) {
                                errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                            }
                            toastr.error(errorMessage);
                        }
                    });
                } else if ($('.kiennghi-card').length > 1) {
                    card.remove();
                    reindexKiennghi();
                } else {
                    card.find('input[type="text"], textarea').val('');
                    card.find('select').val('');
                }
            });

            function reindexKiennghi() {
                $('.kiennghi-card').each(function (index) {
                    $(this).find('.card-header h6').text('Kiến nghị #' + (index + 1));
                    $(this).find('input[name$="[tieu_de]"]').attr('name', `kiennghi[${index}][tieu_de]`);
                    $(this).find('input[name$="[id]"]').attr('name', `kiennghi[${index}][id]`);
                    $(this).find('textarea[name$="[noi_dung]"]').attr('name', `kiennghi[${index}][noi_dung]`);
                    $(this).find('select[name$="[nguoi_de_xuat_id]"]').attr('name', `kiennghi[${index}][nguoi_de_xuat_id]`);
                });
            }

            // Xử lý form kiến nghị
            $('#kiennghi-form').on('submit', function (e) {
                e.preventDefault();

                $('.kiennghi-card').each(function () {
                    const tieuDe = $(this).find('input[name$="[tieu_de]"]').val().trim();
                    const noiDung = $(this).find('textarea[name$="[noi_dung]"]').val().trim();
                    if (!tieuDe || !noiDung) {
                        $(this).remove();
                    }
                });

                if ($('.kiennghi-card').length === 0) {
                    toastr.error('Vui lòng nhập ít nhất một kiến nghị!');
                    return;
                }

                const formData = $(this).serialize();
                console.log('Gửi yêu cầu lưu kiến nghị:', formData);

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (lưu kiến nghị):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra khi lưu kiến nghị!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (lưu kiến nghị):', xhr.responseJSON);
                        let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                        if (xhr.responseJSON?.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        $('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save"></i> Lưu kiến nghị');
                    }
                });
            });
        });
    </script>
@endsection