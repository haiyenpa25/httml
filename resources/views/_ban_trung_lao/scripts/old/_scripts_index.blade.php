@section('page-styles')
<<<<<<< HEAD
<<<<<<<< HEAD:resources/views/_ban_trung_lao/scripts/_scripts_index.blade.php
    <!-- CSS tùy chỉnh -->
========
=======
>>>>>>> 8f78b1f135b3ddeb59dbbf12311ffd03c3ace501
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Select2 CSS -->
<<<<<<< HEAD
>>>>>>>> 8f78b1f135b3ddeb59dbbf12311ffd03c3ace501:resources/views/_ban_co_doc_giao_duc/scripts/_scripts_index.blade.php
=======
>>>>>>> 8f78b1f135b3ddeb59dbbf12311ffd03c3ace501
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
        }

        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #343a40;
            padding: 12px;
        }

        /* Tùy chỉnh nút mở rộng của DataTables Responsive */
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

        table.dataTable.dtr-column>tbody>tr.parent>td.dtr-control:before,
        table.dataTable.dtr-column>tbody>tr.parent>th.dtr-control:before {
            content: '-';
            background-color: #dc3545;
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

<<<<<<< HEAD
        /* Tùy chỉnh nút mở rộng của DataTables Responsive */
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dtr-control:before,
        table.dataTable.dtr-inline.collapsed > tbody > tr > th.dtr-control:before {
            content: '+';
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            border: 1px solid #007bff;
            border-radius: 3px;
            width: 20px;
            height: 20px;
            line-height: 18px;
            text-align: center;
            background-color: #fff;
            margin-right: 5px;
        }

        table.dataTable.dtr-inline.collapsed > tbody > tr.parent > td.dtr-control:before,
        table.dataTable.dtr-inline.collapsed > tbody > tr.parent > th.dtr-control:before {
            content: '−';
            color: #dc3545;
            border-color: #dc3545;
        }

=======
>>>>>>> 8f78b1f135b3ddeb59dbbf12311ffd03c3ace501
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
                /* Better mobile input sizing */
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
        // Biến toàn cục để theo dõi trạng thái khởi tạo DataTable
        if (typeof window.isDataTableInitialized === 'undefined') {
            window.isDataTableInitialized = false;
        }

        $(document).ready(function () {
            // Ngăn chặn thực thi script nhiều lần
            if (window.isDataTableInitialized) {
                console.log('Script already initialized, skipping re-execution.');
                return;
            }

            // Đánh dấu rằng script đã được khởi tạo
            window.isDataTableInitialized = true;

            // Khởi tạo Select2
            if ($('.select2bs4').length) {
                $('.select2bs4').each(function () {
                    const $select = $(this);
                    $select.select2({
                        theme: 'bootstrap4',
                        placeholder: $select.find('option[value=""]').text() || '-- Chọn --',
                        width: '100%',
                        dropdownAutoWidth: true,
                        minimumResultsForSearch: 10,
                        allowClear: true
                    }).on('select2:open', function () {
                        $('.select2-container--bootstrap4 .select2-results__option').css('color', '#333');
                    });
                });
            }

            // Hàm khởi tạo DataTable với kiểm tra tồn tại của table
            function initializeDataTable(tableId, ajaxUrl, columns, filterData) {
                // Kiểm tra xem table element có tồn tại trong DOM không
                if (!$(tableId).length) {
                    console.warn(`Table element ${tableId} not found in DOM. Skipping DataTable initialization.`);
                    return null;
                }

                // Kiểm tra và hủy DataTable nếu đã tồn tại
                if ($.fn.DataTable.isDataTable(tableId)) {
                    try {
                        $(tableId).DataTable().destroy();
                        // Xóa nội dung của table để đảm bảo không còn tham chiếu cũ
                        $(tableId).empty();
                    } catch (e) {
                        console.error(`Error destroying DataTable for ${tableId}:`, e);
                    }
                }

                return $(tableId).DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: {
                        url: ajaxUrl,
                        data: filterData,
                        dataSrc: function (json) {
                            console.log(`Dữ liệu ${tableId}:`, json);
                            if (!json || json.success === false) {
                                toastr.error(json.message || `Không thể tải danh sách cho ${tableId}`);
                                return [];
                            }
                            return json.data || json;
                        },
                        error: function (xhr, error, thrown) {
                            toastr.error('Lỗi kết nối đến server: ' + xhr.status + ' ' + thrown);
                        }
                    },
                    columns: columns,
                    language: {
                        url: '{{ asset("dist/js/Vietnamese.json") }}'
                    },
                    responsive: {
                        details: {
                            type: 'column', // Sử dụng kiểu mở rộng dạng cột
                            target: 0, // Cột đầu tiên là cột điều khiển
                            renderer: function (api, rowIdx, columns) {
                                var data = $.map(columns, function (col, i) {
                                    // Lấy giá trị data-priority của cột
                                    var priority = $(api.column(i).header()).attr('data-priority') || '0';
                                    // Bỏ qua cột nếu không bị ẩn hoặc có data-priority="4" (cột Địa chỉ)
                                    if (!col.hidden || priority === '4') return '';
                                    return '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                        '<td><strong>' + col.title + ':</strong></td>' +
                                        '<td>' + col.data + '</td>' +
                                        '</tr>';
                                }).join('');
                                return data ? $('<table class="table table-bordered"/>').append(data) : false;
                            }
                        }
                    },
                    autoWidth: false,
                    columnDefs: [
                        {
                            className: 'dt-control', // Thêm class cho cột điều khiển
                            orderable: false,
                            searchable: false,
                            targets: 0 // Cột đầu tiên là cột điều khiển
                        },
                        { targets: [0, 1, 4], responsivePriority: 1 }, // Ưu tiên hiển thị STT, Họ tên, Thao tác
                        { targets: [2, 3], responsivePriority: 100 } // Ưu tiên thấp hơn cho Số điện thoại/Địa chỉ
                    ],
                    order: [] // Không sắp xếp mặc định
                });
            }

            // Khởi tạo DataTable cho Ban Điều Hành
            let tableDieuHanh = initializeDataTable(
                '#ban-dieu-hanh-table',
                "{{ route('api.ban_trung_lao.dieu_hanh_list') }}",
                [
                    { data: null, defaultContent: '' }, // Cột điều khiển mở rộng
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'chuc_vu' },
                    { data: 'ho_ten' },
                    {
                        data: null,
                        render: function (data, type, row) {
                            const chucVu = row.chuc_vu || '';
                            return `
<<<<<<< HEAD
<<<<<<<< HEAD:resources/views/_ban_trung_lao/scripts/_scripts_index.blade.php
                                <div class="btn-group">
                                    <button type="button" 
                                            class="btn btn-sm btn-info btn-edit-chuc-vu" 
                                            data-toggle="modal" 
                                            data-target="#modal-edit-chuc-vu"
                                            data-id="${row.tin_huu_id}" 
                                            data-ban-id="{{ $banTrungLao->id }}"
                                            data-ten="${row.ho_ten}" 
                                            data-chucvu="${chucVu}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger btn-xoa-thanh-vien" 
                                            data-id="${row.tin_huu_id}" 
                                            data-ban-id="{{ $banTrungLao->id }}"
                                            data-ten="${row.ho_ten}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>`;
========
                                                        <div class="btn-group">
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-info btn-edit-chuc-vu" 
                                                                    data-toggle="modal" 
                                                                    data-target="#modal-edit-chuc-vu"
                                                                    data-id="${row.tin_huu_id}" 
                                                                    data-ban-id="{{ $banThanhTrang->id }}"
                                                                    data-ten="${row.ho_ten}" 
                                                                    data-chucvu="${chucVu}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-danger btn-xoa-thanh-vien" 
                                                                    data-id="${row.tin_huu_id}" 
                                                                    data-ban-id="{{ $banThanhTrang->id }}"
                                                                    data-ten="${row.ho_ten}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>`;
>>>>>>>> 8f78b1f135b3ddeb59dbbf12311ffd03c3ace501:resources/views/_ban_co_doc_giao_duc/scripts/_scripts_index.blade.php
=======
                                            <div class="btn-group">
                                                <button type="button" 
                                                        class="btn btn-sm btn-info btn-edit-chuc-vu" 
                                                        data-toggle="modal" 
                                                        data-target="#modal-edit-chuc-vu"
                                                        data-id="${row.tin_huu_id}" 
                                                        data-ban-id="{{ $banTrungLao->id }}"
                                                        data-ten="${row.ho_ten}" 
                                                        data-chucvu="${chucVu}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger btn-xoa-thanh-vien" 
                                                        data-id="${row.tin_huu_id}" 
                                                        data-ban-id="{{ $banTrungLao->id }}"
                                                        data-ten="${row.ho_ten}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>`;
>>>>>>> 8f78b1f135b3ddeb59dbbf12311ffd03c3ace501
                        }
                    }
                ],
                function (d) {
                    d.ho_ten = $('#filter-ho-ten').val();
                    d.chuc_vu = $('#filter-chuc-vu').val();
                }
            );

            // Khởi tạo DataTable cho Ban Viên
            let tableBanVien = initializeDataTable(
                '#ban-vien-table',
<<<<<<< HEAD
                "{{ route('api.ban_co_doc_giao_duc.ban_vien_list') }}",
=======
                "{{ route('api.ban_trung_lao.ban_vien_list') }}",
>>>>>>> 8f78b1f135b3ddeb59dbbf12311ffd03c3ace501
                [
                    { data: null, defaultContent: '' }, // Cột điều khiển mở rộng
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'ho_ten' },
                    { data: 'so_dien_thoai' },
                    { data: 'dia_chi' },
                    {
                        data: null,
                        render: function (data, type, row) {
                            const chucVu = row.chuc_vu || '';
                            return `
<<<<<<< HEAD
<<<<<<<< HEAD:resources/views/_ban_trung_lao/scripts/_scripts_index.blade.php
                                <div class="btn-group">
                                    <button type="button" 
                                            class="btn btn-sm btn-info btn-edit-chuc-vu" 
                                            data-toggle="modal" 
                                            data-target="#modal-edit-chuc-vu"
                                            data-id="${row.tin_huu_id}" 
                                            data-ban-id="{{ $banTrungLao->id }}"
                                            data-ten="${row.ho_ten}" 
                                            data-chucvu="${chucVu}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger btn-xoa-thanh-vien" 
                                            data-id="${row.tin_huu_id}" 
                                            data-ban-id="{{ $banTrungLao->id }}"
                                            data-ten="${row.ho_ten}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>`;
========
                                                        <div class="btn-group">
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-info btn-edit-chuc-vu" 
                                                                    data-toggle="modal" 
                                                                    data-target="#modal-edit-chuc-vu"
                                                                    data-id="${row.tin_huu_id}" 
                                                                    data-ban-id="{{ $banThanhTrang->id }}"
                                                                    data-ten="${row.ho_ten}" 
                                                                    data-chucvu="${chucVu}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-danger btn-xoa-thanh-vien" 
                                                                    data-id="${row.tin_huu_id}" 
                                                                    data-ban-id="{{ $banThanhTrang->id }}"
                                                                    data-ten="${row.ho_ten}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>`;
>>>>>>>> 8f78b1f135b3ddeb59dbbf12311ffd03c3ace501:resources/views/_ban_co_doc_giao_duc/scripts/_scripts_index.blade.php
=======
                                            <div class="btn-group">
                                                <button type="button" 
                                                        class="btn btn-sm btn-info btn-edit-chuc-vu" 
                                                        data-toggle="modal" 
                                                        data-target="#modal-edit-chuc-vu"
                                                        data-id="${row.tin_huu_id}" 
                                                        data-ban-id="{{ $banTrungLao->id }}"
                                                        data-ten="${row.ho_ten}" 
                                                        data-chucvu="${chucVu}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-sm btn-danger btn-xoa-thanh-vien" 
                                                        data-id="${row.tin_huu_id}" 
                                                        data-ban-id="{{ $banTrungLao->id }}"
                                                        data-ten="${row.ho_ten}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>`;
>>>>>>> 8f78b1f135b3ddeb59dbbf12311ffd03c3ace501
                        }
                    }
                ],
                function (d) {
                    d.ho_ten = $('#filter-ho-ten').val();
                    d.so_dien_thoai = $('#filter-so-dien-thoai').val();
                    d.dia_chi = $('#filter-dia-chi').val();
                }
            );

            // Áp dụng bộ lọc
            $('#filter-ho-ten, #filter-chuc-vu, #filter-so-dien-thoai, #filter-dia-chi').on('change keyup', debounce(function () {
                console.log('Bộ lọc:', {
                    ho_ten: $('#filter-ho-ten').val(),
                    chuc_vu: $('#filter-chuc-vu').val(),
                    so_dien_thoai: $('#filter-so-dien-thoai').val(),
                    dia_chi: $('#filter-dia-chi').val()
                });
                if (tableDieuHanh) tableDieuHanh.ajax.reload();
                if (tableBanVien) tableBanVien.ajax.reload();
            }, 300));

            // Xử lý nút Tải lại
            $('#btn-refresh').click(function () {
                $('#filter-ho-ten').val('');
                $('#filter-chuc-vu').val('').trigger('change');
                $('#filter-so-dien-thoai').val('');
                $('#filter-dia-chi').val('');
                if (tableDieuHanh) tableDieuHanh.ajax.reload();
                if (tableBanVien) tableBanVien.ajax.reload();
            });

            // Xử lý submit form thêm thành viên
            $('#form-them-thanh-vien').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json'
                })
                    .done(response => {
                        if (response.success) {
                            $('#modal-them-thanh-vien').modal('hide');
                            $('#form-them-thanh-vien')[0].reset();
                            $('#tin_huu_id').val(null).trigger('change');
                            toastr.success(response.message);
                            if (tableDieuHanh) tableDieuHanh.ajax.reload();
                            if (tableBanVien) tableBanVien.ajax.reload();
                        } else {
                            toastr.error(response.message || 'Đã xảy ra lỗi.');
                        }
                    })
                    .fail(xhr => {
                        let errorMessage = 'Đã xảy ra lỗi khi thêm thành viên.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    });
            });

            // Xử lý submit form cập nhật chức vụ
            $('#form-sua-chuc-vu').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json'
                })
                    .done(response => {
                        if (response && typeof response === 'object' && response.success) {
                            $('#modal-edit-chuc-vu').modal('hide');
                            toastr.success(response.message || 'Cập nhật chức vụ thành công!');
                            if (tableDieuHanh) tableDieuHanh.ajax.reload();
                            if (tableBanVien) tableBanVien.ajax.reload();
                        } else {
                            toastr.error(response.message || 'Phản hồi từ máy chủ không hợp lệ.');
                        }
                    })
                    .fail(xhr => {
                        let errorMessage = 'Đã xảy ra lỗi khi cập nhật chức vụ.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    });
            });

            // Xử lý xóa thành viên
            $('#confirm-delete').click(function () {
                const data = {
                    tin_huu_id: $('#delete_tin_huu_id').val(),
                    ban_nganh_id: $('#delete_ban_nganh_id').val(),
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    _method: 'DELETE'
                };

                console.log('Dữ liệu gửi đi để xóa:', data);

                $.ajax({
                    url: "{{ route('api.ban_trung_lao.xoa_thanh_vien') }}",
                    url: "{{ route('api.ban_co_doc_giao_duc.xoa_thanh_vien') }}",
                    url: "{{ route('api.ban_trung_lao.xoa_thanh_vien') }}",
                    method: 'POST',
                    data: data,
                    dataType: 'json'
                })
                    .done(response => {
                        console.log('Phản hồi từ máy chủ:', response);
                        if (response.success) {
                            $('#modal-xoa-thanh-vien').modal('hide');
                            toastr.success(response.message);
                            if (tableDieuHanh) tableDieuHanh.ajax.reload();
                            if (tableBanVien) tableBanVien.ajax.reload();
                        } else {
                            toastr.error(response.message || 'Không thể xóa thành viên.');
                        }
                    })
                    .fail(xhr => {
                        console.error('Lỗi từ máy chủ:', xhr.responseJSON);
                        let errorMessage = 'Không thể xóa thành viên. Vui lòng thử lại sau!';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    });
            });

            // Xử lý xuất Excel
            $('#btn-export').click(function () {
                toastr.info('Chức năng xuất Excel sẽ được phát triển sau.');
            });

            // Xử lý dữ liệu cho modal chỉnh sửa chức vụ
            $('#modal-edit-chuc-vu').on('show.bs.modal', function (event) {
                try {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var banId = button.data('ban-id');
                    var ten = button.data('ten');
                    var chucVu = button.data('chucvu') || '';

                    var modal = $(this);
                    modal.find('#edit_tin_huu_id').val(id);
                    modal.find('#edit_ban_nganh_id').val(banId);
                    modal.find('#edit_ten_tin_huu').text(ten);
                    modal.find('#edit_chuc_vu').val(chucVu);
                } catch (e) {
                    console.error('Error in modal show event:', e);
                    toastr.error('Lỗi khi mở modal chỉnh sửa chức vụ.');
                }
            });

            // Xử lý dữ liệu cho modal xóa thành viên
            $('#modal-xoa-thanh-vien').on('show.bs.modal', function (event) {
                try {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var banId = button.data('ban-id');
                    var ten = button.data('ten');

                    var modal = $(this);
                    modal.find('#delete_tin_huu_id').val(id);
                    modal.find('#delete_ban_nganh_id').val(banId);
                    modal.find('#delete_ten_tin_huu').text(ten);
                } catch (e) {
                    console.error('Error in modal show event:', e);
                    toastr.error('Lỗi khi mở modal xóa thành viên.');
                }
            });

            // Xử lý Select2 trong modal
            $('.modal').on('shown.bs.modal', function () {
                $(this).find('.select2bs4').select2({
                    theme: 'bootstrap4',
                    dropdownParent: $(this),
                    width: '100%'
                });
            });

            // Hàm debounce
            function debounce(func, wait) {
                let timeout;
                return function (...args) {
                    const context = this;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }

            // Xử lý TurboLinks nếu có
            document.addEventListener('turbolinks:load', function () {
                window.isDataTableInitialized = false;
                $(document).ready();
            });

            $(document).on('click', '.btn-xoa-thanh-vien', function () {
                const id = $(this).data('id');
                const banId = $(this).data('ban-id');
                const ten = $(this).data('ten');
                $('#delete_tin_huu_id').val(id);
                $('#delete_ban_nganh_id').val(banId);
                $('#delete_ten_tin_huu').text(ten);
                $('#modal-xoa-thanh-vien').modal('show');
            });
        });
    </script>
@endsection