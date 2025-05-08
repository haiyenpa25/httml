@section('page-styles')
    {{-- <style>
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        .btn-group .btn {
            margin: 0 2px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .child-row-table {
            width: 100%;
            border-collapse: collapse;
        }
        .child-row-table td {
            padding: 5px;
            vertical-align: top;
        }
        .child-row-table td:first-child {
            font-weight: bold;
            width: 150px;
        }
        .swal2-content table {
            width: 100%;
            margin-bottom: 0;
        }
        .swal2-content table td {
            padding: 8px;
            border: 1px solid #dee2e6;
        }
        .swal2-content table td:first-child {
            font-weight: bold;
            width: 200px;
            background-color: #f8f9fa;
        }
    </style> --}}

    <style>
        /* CSS cho bảng dữ liệu */
        .table-responsive {
            overflow-x: auto;
        }
    
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            vertical-align: middle;
        }
    
        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
            border-color: #dee2e6;
            vertical-align: middle;
            white-space: nowrap;
        }
    
        .table td {
            vertical-align: middle;
            padding: 0.75rem;
        }
    
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.03);
        }
    
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.075);
            transition: all 0.3s ease;
        }
    
        /* Tùy chỉnh nút thao tác */
        .action-btns .btn {
            margin: 0 2px;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    
        .btn-icon {
            width: 30px;
            height: 30px;
            padding: 0;
            line-height: 30px;
            text-align: center;
            border-radius: 50%;
        }
    
        /* Hiệu ứng hiển thị card */
        .card {
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
    
        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    
        .card-header {
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            padding: 0.75rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    
        /* Tùy chỉnh bộ lọc */
        .filter-card {
            margin-bottom: 1.5rem;
        }
    
        .filter-card .card-body {
            padding: 1rem;
        }
    
        .filter-group {
            margin-bottom: 1rem;
        }
    
        .filter-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
    
        /* CSS cho DataTables Responsive */
        /* Luôn hiển thị nút mở rộng, ngay cả khi không có cột bị ẩn */
        table.dataTable > tbody > tr > td.dtr-control:before,
        table.dataTable > tbody > tr > th.dtr-control:before {
            content: '\f0d7'; /* Font Awesome caret-down icon */
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            background-color: #007bff;
            border: 1.5px solid #fff;
            box-shadow: 0 0 0.2rem rgba(0, 0, 0, 0.5);
            display: inline-block;
            margin-right: 5px;
            color: #fff;
            width: 1em;
            height: 1em;
            text-align: center;
            line-height: 1em;
            border-radius: 50%;
        }
    
        table.dataTable > tbody > tr.parent > td.dtr-control:before,
        table.dataTable > tbody > tr.parent > th.dtr-control:before {
            content: '\f0d8'; /* Font Awesome caret-up icon */
            background-color: #dc3545;
        }
    
        /* Chi tiết mở rộng */
        .child-row-info {
            padding: 12px;
            background-color: #f8f9fa;
            border-radius: 4px;
            margin: 8px 0;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05);
            overflow-x: auto; /* Xử lý tràn nội dung trên mobile */
        }
    
        .child-row-table {
            width: 100%;
            border-collapse: collapse; /* Đảm bảo nội dung nằm gọn */
            border-spacing: 0;
        }
    
        .child-row-table td {
            padding: 5px 10px;
            word-break: break-word; /* Ngắt từ để tránh tràn nội dung */
        }
    
        .child-row-table td:first-child {
            font-weight: 600;
            width: 180px;
            white-space: nowrap; /* Giữ tiêu đề không ngắt dòng */
        }
    
        /* Badges và status indicators */
        .badge {
            padding: 0.4em 0.6em;
            font-size: 75%;
            font-weight: 600;
            border-radius: 0.25rem;
        }
    
        .badge-tin-huu-chinh-thuc {
            background-color: #28a745;
            color: white;
        }
    
        .badge-tan-tin-huu {
            background-color: #17a2b8;
            color: white;
        }
    
        .badge-tin-huu-ht-khac {
            background-color: #6c757d;
            color: white;
        }
    
        /* Responsive tweaking */
        @media (max-width: 768px) {
            .card-title {
                font-size: 1.1rem;
            }
    
            .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.875rem;
            }
    
            .child-row-table td:first-child {
                width: 120px;
            }
    
            /* Ẩn các cột không ưu tiên trên mobile */
            table.dataTable.dtr-column > tbody > tr > td:not(.dtr-control):not([data-dt-column="2"]):not([data-dt-column="5"]) {
                display: none !important;
            }
    
            table.dataTable.dtr-column > thead > tr > th:not(.dtr-control):not([data-dt-column="2"]):not([data-dt-column="5"]) {
                display: none !important;
            }
        }
    
        /* Loader styles */
        .dataTables_processing {
            background: rgba(255, 255, 255, 0.9) !important;
            border-radius: 4px !important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1) !important;
            color: #007bff !important;
            font-weight: 600 !important;
            padding: 10px 20px !important;
        }
    </style>
@endsection

@section('page-scripts')
    <script>
        $(function () {
            // Kiểm tra thư viện cần thiết
            if (typeof jQuery === 'undefined') {
                console.error('jQuery chưa được tải!');
                return;
            }
            if (typeof $.fn.DataTable === 'undefined') {
                console.error('DataTables chưa được tải!');
                return;
            }
            if (typeof $.fn.select2 === 'undefined') {
                console.error('Select2 chưa được tải!');
                return;
            }
            if (typeof toastr === 'undefined') {
                console.error('Toastr chưa được tải!');
                return;
            }
            if (typeof moment === 'undefined') {
                console.error('Moment.js chưa được tải!');
                return;
            }
            if (typeof Swal === 'undefined') {
                console.error('SweetAlert2 chưa được tải! Vui lòng kiểm tra file layout hoặc thư mục public/plugins/sweetalert2.');
                toastr.error('Không thể hiển thị chi tiết thành viên do thiếu thư viện SweetAlert2.');
                return;
            }

            // Cấu hình Toastr
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 5000
            };

            // Khởi tạo Select2
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                placeholder: '-- Chọn một mục --',
                allowClear: true,
                minimumResultsForSearch: 5,
                width: '100%'
            });

            // Hàm chuẩn hóa và định dạng giá trị tiền tệ
            function cleanMoneyFormat(value) {
                if (!value) return '0';
                return value.replace(/[^0-9]/g, '');
            }

            function formatMoney(value) {
                return new Intl.NumberFormat('vi-VN').format(value);
            }

            // Định dạng giá trị ban đầu cho input money-format
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

            // Hàm format chi tiết mở rộng
            function formatChildRow(data) {
                return '<table class="child-row-table">' +
                    '<tr><td>Địa chỉ:</td><td>' + (data.dia_chi || 'N/A') + '</td></tr>' +
                    '<tr><td>Ngày sinh hoạt:</td><td>' + (data.ngay_sinh_hoat_voi_hoi_thanh ? moment(data.ngay_sinh_hoat_voi_hoi_thanh).format('DD/MM/YYYY') : 'N/A') + '</td></tr>' +
                    '<tr><td>Ngày tin Chúa:</td><td>' + (data.ngay_tin_chua ? moment(data.ngay_tin_chua).format('DD/MM/YYYY') : 'N/A') + '</td></tr>' +
                    '<tr><td>Hoàn thành báp têm:</td><td>' + (data.hoan_thanh_bap_tem ? 'Có' : 'Không') + '</td></tr>' +
                    '<tr><td>Giới tính:</td><td>' + (data.gioi_tinh === 'nam' ? 'Nam' : data.gioi_tinh === 'nu' ? 'Nữ' : 'N/A') + '</td></tr>' +
                    '<tr><td>Tình trạng hôn nhân:</td><td>' + (data.tinh_trang_hon_nhan === 'doc_than' ? 'Độc thân' : data.tinh_trang_hon_nhan === 'ket_hon' ? 'Kết hôn' : 'N/A') + '</td></tr>' +
                    '</table>';
            }

            // Khởi tạo DataTable cho bảng Ban Điều Hành
            let banDieuHanhTable;
            try {
                banDieuHanhTable = $('#ban-dieu-hanh-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: '{{ route("api.ban_nganh." . $banType . ".dieu_hanh_list") }}',
                        type: 'GET',
                        data: function (d) {
                            d.ho_ten = $('#filter-ho-ten').val();
                        },
                        error: function (xhr, error, thrown) {
                            console.error('Lỗi khi tải dữ liệu Ban Điều Hành:', {
                                status: xhr.status,
                                response: xhr.responseJSON,
                                error: error,
                                thrown: thrown
                            });
                            toastr.error(xhr.responseJSON?.message || 'Không thể tải dữ liệu Ban Điều Hành.');
                        }
                    },
                    columns: [
                        {
                            className: 'dt-control',
                            orderable: false,
                            data: null,
                            defaultContent: '<i class="fas fa-plus-circle"></i>',
                            searchable: false
                        },
                        {
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            },
                            orderable: false,
                            searchable: false
                        },
                        { data: 'ho_ten', name: 'ho_ten' },
                        { data: 'chuc_vu', name: 'chuc_vu' },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ],
                    language: {
                        url: '{{ asset("dist/js/Vietnamese.json") }}'
                    },
                    columnDefs: [
                        { targets: [0, 1, 4], responsivePriority: 1 },
                        { targets: [2, 3], responsivePriority: 100 }
                    ],
                    order: [],
                    drawCallback: function (settings) {
                        console.log('DataTables Ban Điều Hành loaded:', settings.oInstance.api().data().count());
                    }
                });
            } catch (e) {
                console.error('Lỗi khởi tạo DataTables (ban-dieu-hanh-table):', e);
                toastr.error('Không thể khởi tạo bảng Ban Điều Hành.');
            }

            // Khởi tạo DataTable cho bảng Ban Viên
            let banVienTable;
            try {
                banVienTable = $('#ban-vien-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: '{{ route("api.ban_nganh." . $banType . ".ban_vien_list") }}',
                        type: 'GET',
                        data: function (d) {
                            d.ho_ten = $('#filter-ho-ten').val();
                            d.loai_tin_huu = $('#filter-loai-tin-huu').val();
                            d.so_dien_thoai = $('#filter-so-dien-thoai').val();
                            d.ngay_sinh = $('#filter-ngay-sinh').val();
                            d.gioi_tinh = $('#filter-gioi-tinh').val();
                            d.tinh_trang_hon_nhan = $('#filter-tinh-trang-hon-nhan').val();
                            d.hoan_thanh_bap_tem = $('#filter-hoan-thanh-bap-tem').val();
                            d.tuoi = $('#filter-tuoi').val();
                            d.thoi_gian_sinh_hoat = $('#filter-thoi-gian-sinh-hoat').val();
                        },
                        error: function (xhr, error, thrown) {
                            console.error('Lỗi khi tải dữ liệu Ban Viên:', {
                                status: xhr.status,
                                response: xhr.responseJSON,
                                error: error,
                                thrown: thrown
                            });
                            toastr.error(xhr.responseJSON?.message || 'Không thể tải dữ liệu Ban Viên.');
                        }
                    },
                    columns: [
                        {
                            className: 'dt-control',
                            orderable: false,
                            data: null,
                            defaultContent: '<i class="fas fa-plus-circle"></i>',
                            searchable: false
                        },
                        {
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            },
                            orderable: false,
                            searchable: false
                        },
                        { data: 'ho_ten', name: 'ho_ten' },
                        {
                            data: 'ngay_sinh',
                            name: 'ngay_sinh',
                            render: function(data) {
                                return data ? moment(data).format('DD/MM/YYYY') : 'N/A';
                            }
                        },
                        { data: 'so_dien_thoai', name: 'so_dien_thoai' },
                        { data: 'ban_nganh', name: 'ban_nganh' },
                        {
                            data: 'loai_tin_huu',
                            name: 'loai_tin_huu',
                            render: function(data) {
                                return {
                                    'tin_huu_chinh_thuc': 'Tín hữu chính thức',
                                    'tan_tin_huu': 'Tân tín hữu',
                                    'tin_huu_ht_khac': 'Tín hữu Hội Thánh khác'
                                }[data] || data;
                            }
                        },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ],
                    language: {
                        url: '{{ asset("dist/js/Vietnamese.json") }}'
                    },
                    columnDefs: [
                        { targets: [0, 1, 7], responsivePriority: 1 },
                        { targets: [2, 3, 4, 5, 6], responsivePriority: 100 }
                    ],
                    order: [],
                    drawCallback: function (settings) {
                        console.log('DataTables Ban Viên loaded:', settings.oInstance.api().data().count());
                    }
                });
            } catch (e) {
                console.error('Lỗi khởi tạo DataTables (ban-vien-table):', e);
                toastr.error('Không thể khởi tạo bảng Ban Viên.');
            }

            // Xử lý mở rộng hàng trong DataTable
            $('#ban-dieu-hanh-table, #ban-vien-table').off('click', 'td.dt-control').on('click', 'td.dt-control', function () {
                var tr = $(this).closest('tr');
                var table = $(this).closest('table').DataTable();
                var row = table.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                    $(this).html('<i class="fas fa-plus-circle"></i>');
                } else {
                    row.child(formatChildRow(row.data())).show();
                    tr.addClass('shown');
                    $(this).html('<i class="fas fa-minus-circle"></i>');
                }
            });

            // Xử lý lọc khi người dùng thay đổi bộ lọc
            $('#filter-ho-ten, #filter-so-dien-thoai, #filter-ngay-sinh, #filter-loai-tin-huu, #filter-gioi-tinh, #filter-tinh-trang-hon-nhan, #filter-hoan-thanh-bap-tem, #filter-tuoi, #filter-thoi-gian-sinh-hoat').on('keyup change input', function () {
                console.log('Lọc:', $(this).attr('id'), $(this).val());
                banVienTable.ajax.reload();
                banDieuHanhTable.ajax.reload();
            });

            // Xử lý reset bộ lọc
            $('#btn-reset-filter').on('click', function () {
                $('#filter-ho-ten').val('');
                $('#filter-so-dien-thoai').val('');
                $('#filter-ngay-sinh').val('');
                $('#filter-loai-tin-huu').val('').trigger('change.select2');
                $('#filter-gioi-tinh').val('').trigger('change.select2');
                $('#filter-tinh-trang-hon-nhan').val('').trigger('change.select2');
                $('#filter-hoan-thanh-bap-tem').val('').trigger('change.select2');
                $('#filter-tuoi').val('').trigger('change.select2');
                $('#filter-thoi-gian-sinh-hoat').val('').trigger('change.select2');
                toastr.info('Đã đặt lại bộ lọc');
                banVienTable.ajax.reload();
                banDieuHanhTable.ajax.reload();
            });

            // Xử lý modal thêm thành viên
            $('#form-them-thanh-vien').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                console.log('Gửi yêu cầu thêm thành viên:', formData);

                $.ajax({
                    url: '{{ route("api.ban_nganh." . $banType . ".them_thanh_vien") }}',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('#form-them-thanh-vien button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (thêm thành viên):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            $('#modal-them-thanh-vien').modal('hide');
                            banVienTable.ajax.reload();
                            banDieuHanhTable.ajax.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi khi thêm thành viên!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (thêm thành viên):', xhr.responseJSON);
                        let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                        if (xhr.responseJSON?.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        $('#form-them-thanh-vien button[type="submit"]').prop('disabled', false).html('Lưu');
                    }
                });
            });

            // Xử lý modal chỉnh sửa chức vụ
            $('#modal-edit-chuc-vu').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var tinHuuId = button.data('tin-huu-id');
                var banNganhId = button.data('ban-nganh-id');
                var tenTinHuu = button.data('ten-tin-huu');
                var chucVu = button.data('chuc-vu');

                var modal = $(this);
                modal.find('#edit_tin_huu_id').val(tinHuuId);
                modal.find('#edit_ban_nganh_id').val(banNganhId);
                modal.find('#edit_ten_tin_huu').text(tenTinHuu);
                modal.find('#edit_chuc_vu').val(chucVu);
            });

            $('#form-sua-chuc-vu').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                console.log('Gửi yêu cầu cập nhật chức vụ:', formData);

                $.ajax({
                    url: '{{ route("api.ban_nganh." . $banType . ".cap_nhat_chuc_vu") }}',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('#form-sua-chuc-vu button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (cập nhật chức vụ):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            $('#modal-edit-chuc-vu').modal('hide');
                            banDieuHanhTable.ajax.reload();
                            banVienTable.ajax.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi khi cập nhật chức vụ!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (cập nhật chức vụ):', xhr.responseJSON);
                        let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                        if (xhr.responseJSON?.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        $('#form-sua-chuc-vu button[type="submit"]').prop('disabled', false).html('Lưu');
                    }
                });
            });

            // Xử lý modal xóa thành viên
            $('#modal-xoa-thanh-vien').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var tinHuuId = button.data('tin-huu-id');
                var banNganhId = button.data('ban-nganh-id');
                var tenTinHuu = button.data('ten-tin-huu');

                var modal = $(this);
                modal.find('#delete_tin_huu_id').val(tinHuuId);
                modal.find('#delete_ban_nganh_id').val(banNganhId);
                modal.find('#delete_ten_tin_huu').text(tenTinHuu);
            });

            $('#confirm-delete').on('click', function () {
                var tinHuuId = $('#delete_tin_huu_id').val();
                var banNganhId = $('#delete_ban_nganh_id').val();

                $.ajax({
                    url: '{{ route("api.ban_nganh." . $banType . ".xoa_thanh_vien") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                        tin_huu_id: tinHuuId,
                        ban_nganh_id: banNganhId
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log('Phản hồi từ server (xóa thành viên):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            $('#modal-xoa-thanh-vien').modal('hide');
                            banDieuHanhTable.ajax.reload();
                            banVienTable.ajax.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi khi xóa thành viên!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (xóa thành viên):', xhr.responseJSON);
                        toastr.error(xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!');
                    }
                });
            });

            // Xử lý nút xem chi tiết
            $('#ban-dieu-hanh-table, #ban-vien-table').on('click', '.btn-view', function () {
                var tinHuuId = $(this).data('tin-huu-id');
                console.log('Yêu cầu xem chi tiết thành viên:', tinHuuId);

                $.ajax({
                    url: '{{ route("api.ban_nganh." . $banType . ".chi_tiet_thanh_vien") }}',
                    method: 'GET',
                    data: { tin_huu_id: tinHuuId },
                    dataType: 'json',
                    beforeSend: function () {
                        Swal.fire({
                            title: 'Đang tải...',
                            text: 'Vui lòng chờ trong giây lát',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });
                    },
                    success: function (response) {
                        Swal.close();
                        console.log('Phản hồi từ server (xem chi tiết):', response);
                        if (response.success) {
                            var data = response.data;
                            var content = `
                                <table>
                                    <tr><td>Mã tín hữu:</td><td>${data.ma_tin_huu || 'N/A'}</td></tr>
                                    <tr><td>Họ tên:</td><td>${data.ho_ten || 'N/A'}</td></tr>
                                    <tr><td>Ngày sinh:</td><td>${data.ngay_sinh ? moment(data.ngay_sinh).format('DD/MM/YYYY') : 'N/A'}</td></tr>
                                    <tr><td>Tuổi:</td><td>${data.tuoi || 'N/A'}</td></tr>
                                    <tr><td>Số điện thoại:</td><td>${data.so_dien_thoai ? '<a href="tel:' + data.so_dien_thoai + '">' + data.so_dien_thoai + '</a>' : 'N/A'}</td></tr>
                                    <tr><td>Email:</td><td>${data.email || 'N/A'}</td></tr>
                                    <tr><td>Địa chỉ:</td><td>${data.dia_chi || 'N/A'}</td></tr>
                                    <tr><td>Giới tính:</td><td>${data.gioi_tinh === 'nam' ? 'Nam' : data.gioi_tinh === 'nu' ? 'Nữ' : 'N/A'}</td></tr>
                                    <tr><td>Tình trạng hôn nhân:</td><td>${data.tinh_trang_hon_nhan === 'doc_than' ? 'Độc thân' : data.tinh_trang_hon_nhan === 'ket_hon' ? 'Kết hôn' : 'N/A'}</td></tr>
                                    <tr><td>Loại tín hữu:</td><td>${{
                                        'tin_huu_chinh_thuc': 'Tín hữu chính thức',
                                        'tan_tin_huu': 'Tân tín hữu',
                                        'tin_huu_ht_khac': 'Tín hữu Hội Thánh khác'
                                    }[data.loai_tin_huu] || data.loai_tin_huu || 'N/A'}</td></tr>
                                    <tr><td>Ngày tin Chúa:</td><td>${data.ngay_tin_chua ? moment(data.ngay_tin_chua).format('DD/MM/YYYY') : 'N/A'}</td></tr>
                                    <tr><td>Ngày báp têm:</td><td>${data.ngay_bap_tem ? moment(data.ngay_bap_tem).format('DD/MM/YYYY') : 'N/A'}</td></tr>
                                    <tr><td>Hoàn thành báp têm:</td><td>${data.hoan_thanh_bap_tem ? 'Có' : 'Không'}</td></tr>
                                    <tr><td>Ngày sinh hoạt:</td><td>${data.ngay_sinh_hoat_voi_hoi_thanh ? moment(data.ngay_sinh_hoat_voi_hoi_thanh).format('DD/MM/YYYY') : 'N/A'}</td></tr>
                                    <tr><td>Ban ngành:</td><td>${data.ban_nganh || 'N/A'}</td></tr>
                                    <tr><td>Chức vụ:</td><td>${data.chuc_vu || 'N/A'}</td></tr>
                                    <tr><td>Nghề nghiệp:</td><td>${data.nghe_nghiep || 'N/A'}</td></tr>
                                    <tr><td>Nơi làm việc:</td><td>${data.noi_lam_viec || 'N/A'}</td></tr>
                                    <tr><td>Trình độ học vấn:</td><td>${data.trinh_do_hoc_van || 'N/A'}</td></tr>
                                    <tr><td>Chức vụ xã hội:</td><td>${data.chuc_vu_xa_hoi || 'N/A'}</td></tr>
                                    <tr><td>Người thân:</td><td>${data.nguoi_than || 'N/A'}</td></tr>
                                    <tr><td>Quan hệ:</td><td>${data.quan_he || 'N/A'}</td></tr>
                                    <tr><td>SĐT người thân:</td><td>${data.so_dien_thoai_nguoi_than ? '<a href="tel:' + data.so_dien_thoai_nguoi_than + '">' + data.so_dien_thoai_nguoi_than + '</a>' : 'N/A'}</td></tr>
                                </table>
                            `;

                            Swal.fire({
                                title: 'Chi tiết thành viên',
                                html: content,
                                width: '800px',
                                showConfirmButton: false,
                                showCloseButton: true
                            });
                        } else {
                            toastr.error(response.message || 'Không thể tải chi tiết thành viên!');
                        }
                    },
                    error: function (xhr) {
                        Swal.close();
                        console.error('Lỗi AJAX (xem chi tiết):', xhr.responseJSON);
                        toastr.error(xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!');
                    }
                });
            });
        });
    </script>
@endsection