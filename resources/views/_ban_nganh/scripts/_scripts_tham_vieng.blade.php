@section('page-styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Custom styles -->
    <style>
        .badge {
            font-size: 90%;
        }

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

        .select2 {
            width: 100% !important;
        }

        .select2-dropdown {
            max-width: 100vw !important;
        }

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

        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

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

        /* Pagination styles */
        .pagination {
            margin-bottom: 0;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }

        .pagination .page-link {
            color: #007bff;
        }

        .pagination .page-link:hover {
            color: #0056b3;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        /* Loading state */
        .loading-overlay {
            position: relative;
            min-height: 100px;
        }

        .loading-overlay::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
        }

        .loading-overlay::after {
            content: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 50 50"><circle cx="25" cy="25" r="20" fill="none" stroke="#007bff" stroke-width="4" stroke-dasharray="90, 150" stroke-dashoffset="0"><animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite"/></circle></svg>');
        }

        /* Chart container */
        .chart-container {
            position: relative;
            min-height: 250px;
        }

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
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script>
        $(function () {
            // Khởi tạo Select2 trong modal
            $('#modal-them-tham-vieng, #modal-chi-tiet-tham-vieng').on('shown.bs.modal', function () {
                $(this).find('.select2bs4').select2({
                    theme: 'bootstrap4',
                    dropdownParent: $(this),
                    width: '100%'
                });
            });

            // Hủy Select2 khi modal đóng để tránh lỗi
            $('#modal-them-tham-vieng, #modal-chi-tiet-tham-vieng').on('hidden.bs.modal', function () {
                $(this).find('.select2bs4').select2('destroy');
            });

            // Khởi tạo biểu đồ thống kê
            function initializeChart() {
                if ($('#visitChart').length) {
                    var labels = {!! json_encode($thongKe['months']) !!};
                    var data = {!! json_encode($thongKe['counts']) !!};

                    // Kiểm tra dữ liệu
                    if (!Array.isArray(labels) || !Array.isArray(data) || labels.length !== data.length || labels.length === 0) {
                        console.error('Dữ liệu thống kê không hợp lệ:', { labels: labels, data: data });
                        document.getElementById('visitChart').parentElement.innerHTML = '<div class="text-center p-3"><i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i><p class="text-muted">Không có dữ liệu để hiển thị biểu đồ.</p></div>';
                        return;
                    }

                    try {
                        var ctx = document.getElementById('visitChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Số lần thăm',
                                    data: data,
                                    backgroundColor: 'rgba(60, 141, 188, 0.8)',
                                    borderColor: 'rgba(60, 141, 188, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            stepSize: 1
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true
                                    }
                                }
                            }
                        });
                    } catch (e) {
                        console.error('Lỗi khởi tạo biểu đồ:', e);
                        document.getElementById('visitChart').parentElement.innerHTML = '<div class="text-center p-3"><i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i><p class="text-muted">Không thể hiển thị biểu đồ. Vui lòng kiểm tra dữ liệu hoặc thư viện Chart.js.</p></div>';
                    }
                }
            }

            // Gọi hàm khởi tạo biểu đồ
            initializeChart();

            // Xử lý click nút thêm thăm viếng
            $(document).on('click', '.btn-them-tham-vieng', function () {
                var id = $(this).data('id');
                var ten = $(this).data('ten');
                console.log('Mở modal thêm thăm viếng cho tín hữu ID:', id, 'Tên:', ten);
                $('#tin_huu_id').val(id).trigger('change.select2');
            });

            // Xử lý submit form thêm thăm viếng
            if ($('#form-them-tham-vieng').length) {
                $('#form-them-tham-vieng').on('submit', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Form thêm thăm viếng submitted via AJAX');

                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        beforeSend: function () {
                            console.log('Sending AJAX request for thêm thăm viếng...');
                            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                        },
                        success: function (response) {
                            console.log('Success response:', response);
                            if (response.success) {
                                toastr.success('Đã thêm lần thăm thành công!');
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                toastr.error('Lỗi: ' + response.message);
                            }
                        },
                        error: function (xhr) {
                            console.log('Error response:', xhr.responseText, xhr.status);
                            var errorMsg = 'Đã xảy ra lỗi!';
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            toastr.error(errorMsg);
                        },
                        complete: function () {
                            console.log('AJAX request completed');
                            $('button[type="submit"]').prop('disabled', false).html('Lưu');
                        }
                    });
                });
            }

            // Xử lý lọc đề xuất thăm viếng
            if ($('#filter-time').length) {
                $('#filter-time').on('change', function () {
                    var days = $(this).val();
                    console.log('Filtering đề xuất thăm viếng:', { days: days });
                    loadDeXuatThamVieng(days, 1);
                });
            }

            // Sử dụng delegate event để xử lý click phân trang
            $(document).off('click', '.page-link').on('click', '.page-link', function(e) {
                e.preventDefault();
                var page = $(this).data('page');
                var days = $('#filter-time').val();
                loadDeXuatThamVieng(days, page);
            });

            // Hàm tải danh sách đề xuất thăm viếng với phân trang
            function loadDeXuatThamVieng(days, page) {
                // Thêm trạng thái loading
                var $tableContainer = $('#table-de-xuat').parent();
                $tableContainer.addClass('loading-overlay');

                $.ajax({
                    url: '{{ route("api.ban_nganh.trung_lao.filter_de_xuat_tham_vieng") }}',
                    method: 'GET',
                    data: { days: days, page: page },
                    dataType: 'json',
                    success: function (response) {
                        console.log('Success response:', response);
                        if (response.success) {
                            $('#de-xuat-table-body').empty();
                            if (response.data.length > 0) {
                                $.each(response.data, function (index, item) {
                                    var lastVisit = item.ngay_tham_vieng_gan_nhat
                                        ? `${item.ngay_tham_vieng_gan_nhat_formatted} <span class="badge badge-${item.so_ngay_chua_tham > 60 ? 'danger' : 'warning'}">${item.so_ngay_chua_tham} ngày</span>`
                                        : '<span class="badge badge-danger">Chưa thăm bao giờ</span>';
                                    var hasCoordinates = item.vi_do && item.kinh_do;

                                    $('#de-xuat-table-body').append(`
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle bg-primary">
                                                        <span>${item.ho_ten.charAt(0)}</span>
                                                    </div>
                                                    <div class="ml-2">${item.ho_ten}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="tel:${item.so_dien_thoai || 'N/A'}" class="text-decoration-none">
                                                    <i class="fas fa-phone-alt text-success mr-1"></i>
                                                    ${item.so_dien_thoai || 'N/A'}
                                                </a>
                                            </td>
                                            <td>${lastVisit}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary btn-them-tham-vieng" 
                                                        data-id="${item.id}" data-ten="${item.ho_ten}"
                                                        data-toggle="modal" data-target="#modal-them-tham-vieng">
                                                        <i class="fas fa-plus"></i> Thăm
                                                    </button>
                                                    <a href="https://www.google.com/maps/dir/?api=1&destination=${item.vi_do || ''},${item.kinh_do || ''}" 
                                                        class="btn btn-sm btn-success ${!hasCoordinates ? 'disabled' : ''}" 
                                                        target="_blank">
                                                        <i class="fas fa-map-marker-alt"></i> Chỉ đường
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    `);
                                });
                            } else {
                                $('#de-xuat-table-body').append('<tr><td colspan="4" class="text-center">Không có dữ liệu</td></tr>');
                            }

                            // Cập nhật phân trang với cấu trúc Bootstrap
                            var pagination = response.pagination;
                            var paginationHtml = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
                            if (pagination.last_page > 1) {
                                if (pagination.current_page > 1) {
                                    paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${pagination.current_page - 1}" aria-label="Previous"><span aria-hidden="true">«</span></a></li>`;
                                } else {
                                    paginationHtml += `<li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>`;
                                }

                                for (var i = 1; i <= pagination.last_page; i++) {
                                    paginationHtml += `<li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                                    </li>`;
                                }

                                if (pagination.current_page < pagination.last_page) {
                                    paginationHtml += `<li class="page-item"><a class="page-link" href="#" data-page="${pagination.current_page + 1}" aria-label="Next"><span aria-hidden="true">»</span></a></li>`;
                                } else {
                                    paginationHtml += `<li class="page-item disabled"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>`;
                                }
                            }
                            paginationHtml += '</ul></nav>';
                            $('.pagination').parent().html(paginationHtml);
                        } else {
                            toastr.error('Lỗi: ' + response.message);
                        }
                    },
                    error: function (xhr) {
                        console.log('Error response:', xhr.responseText, xhr.status);
                        toastr.error('Đã xảy ra lỗi khi lọc dữ liệu!');
                    },
                    complete: function () {
                        // Xóa trạng thái loading
                        $tableContainer.removeClass('loading-overlay');
                    }
                });
            }

            // Khởi tạo bản đồ Leaflet
            function initializeMap() {
                if ($('#map').length) {
                    @if($tinHuuWithLocations->isNotEmpty())
                        try {
                            var map = L.map('map').setView([{{ $tinHuuWithLocations[0]->vi_do }}, {{ $tinHuuWithLocations[0]->kinh_do }}], 13);

                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            }).addTo(map);

                            @foreach($tinHuuWithLocations as $tinHuu)
                                L.marker([{{ $tinHuu->vi_do }}, {{ $tinHuu->kinh_do }}])
                                    .addTo(map)
                                    .bindPopup("<b>{{ $tinHuu->ho_ten }}</b><br>{{ $tinHuu->dia_chi }}<br><a href='https://www.google.com/maps/dir/?api=1&destination={{ $tinHuu->vi_do }},{{ $tinHuu->kinh_do }}' target='_blank'>Chỉ đường</a>");
                            @endforeach

                            // Cập nhật bản đồ khi kích thước thay đổi
                            $('#map-section').on('shown.bs.collapse', function () {
                                map.invalidateSize();
                            });
                        } catch (e) {
                            console.error('Lỗi khởi tạo bản đồ:', e);
                            document.getElementById('map').innerHTML = '<div class="text-center p-3"><i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i><p class="text-muted">Không thể hiển thị bản đồ. Vui lòng kiểm tra dữ liệu hoặc kết nối mạng.</p></div>';
                        }
                    @else
                        document.getElementById('map').innerHTML = '<div class="text-center p-3"><i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i><p>Không có dữ liệu tọa độ của tín hữu.</p></div>';
                    @endif
                }
            }

            // Gọi hàm khởi tạo bản đồ
            initializeMap();

            // Locate me button for map
            $('#btn-locate-me').on('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const currentPos = [position.coords.latitude, position.coords.longitude];
                        if (typeof map !== 'undefined') {
                            map.setView(currentPos, 15);
                            L.marker(currentPos)
                                .addTo(map)
                                .bindPopup("Vị trí của bạn")
                                .openPopup();
                        }
                    }, function(error) {
                        toastr.error('Không thể lấy vị trí của bạn: ' + error.message);
                    });
                } else {
                    toastr.error('Trình duyệt của bạn không hỗ trợ định vị.');
                }
            });

            // Xử lý nút preset cho ngày
            $('.date-preset').on('click', function() {
                const days = $(this).data('days');
                const toDate = new Date();
                const fromDate = new Date();
                fromDate.setDate(fromDate.getDate() - days);

                $('#date-to').val(formatDate(toDate));
                $('#date-from').val(formatDate(fromDate));

                // Kích hoạt nút tìm kiếm
                $('#btn-filter-history').click();
            });

            // Format date helper function
            function formatDate(date) {
                const d = new Date(date);
                let month = '' + (d.getMonth() + 1);
                let day = '' + d.getDate();
                const year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [year, month, day].join('-');
            }

            // Xử lý lọc lịch sử thăm viếng
            if ($('#btn-filter-history').length) {
                $('#btn-filter-history').on('click', function () {
                    var fromDate = $('#date-from').val();
                    var toDate = $('#date-to').val();
                    console.log('Filtering lịch sử thăm viếng:', { from_date: fromDate, to_date: toDate });

                    if (!fromDate || !toDate || !moment(fromDate, 'YYYY-MM-DD', true).isValid() || !moment(toDate, 'YYYY-MM-DD', true).isValid()) {
                        toastr.error('Vui lòng chọn khoảng thời gian hợp lệ');
                        return;
                    }

                    $.ajax({
                        url: '{{ route("api.ban_nganh.trung_lao.filter_tham_vieng") }}',
                        method: 'GET',
                        data: {
                            from_date: fromDate,
                            to_date: toDate
                        },
                        dataType: 'json',
                        success: function (response) {
                            console.log('Success response:', response);
                            if (response.success) {
                                $('#lich-su-table-body').empty();
                                if (response.data.length > 0) {
                                    $.each(response.data, function (index, item) {
                                        var date = new Date(item.ngay_tham);
                                        var month = date.toLocaleString('default', { month: 'short' });
                                        var day = date.getDate();
                                        $('#lich-su-table-body').append(`
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="event-date-badge">
                                                            <div class="event-date-month">${month}</div>
                                                            <div class="event-date-day">${day}</div>
                                                        </div>
                                                        <div class="ml-2">${item.ngay_tham_formatted}</div>
                                                    </div>
                                                </td>
                                                <td>${item.tin_huu_name || 'N/A'}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span class="visitor-icon">
                                                            <i class="fas fa-user-circle"></i>
                                                        </span>
                                                        <span>${item.nguoi_tham_name || 'N/A'}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info btn-xem-chi-tiet" 
                                                        data-id="${item.id}"
                                                        data-toggle="modal" 
                                                        data-target="#modal-chi-tiet-tham-vieng">
                                                        <i class="fas fa-eye"></i> Chi tiết
                                                    </button>
                                                </td>
                                            </tr>
                                        `);
                                    });
                                } else {
                                    $('#lich-su-table-body').append('<tr><td colspan="4" class="text-center">Không có dữ liệu</td></tr>');
                                }
                            } else {
                                toastr.error('Lỗi: ' + response.message);
                            }
                        },
                        error: function (xhr) {
                            console.log('Error response:', xhr.responseText, xhr.status);
                            toastr.error('Đã xảy ra lỗi khi lọc dữ liệu!');
                        }
                    });
                });
            }

            // Xử lý xem chi tiết thăm viếng
            $(document).on('click', '.btn-xem-chi-tiet', function () {
                var id = $(this).data('id');
                console.log('Xem chi tiết thăm viếng ID:', id);

                $('#chi-tiet-content').hide();
                $('.spinner-border').parent().show();

                $.ajax({
                    url: '{{ route("api.ban_nganh.trung_lao.chi_tiet_tham_vieng", ["id" => "__ID__"]) }}'.replace('__ID__', id),
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        console.log('Success response:', response);
                        if (response.success) {
                            $('.spinner-border').parent().hide();
                            $('#chi-tiet-content').show();

                            var data = response.data;
                            $('#detail-tin-huu').text(data.tin_huu_name || 'N/A');
                            $('#detail-nguoi-tham').text(data.nguoi_tham_name || 'N/A');
                            $('#detail-ngay-tham').text(data.ngay_tham_formatted);
                            $('#detail-trang-thai').html(data.trang_thai === 'da_tham'
                                ? '<span class="badge badge-success">Đã thăm</span>'
                                : '<span class="badge badge-warning">Kế hoạch</span>');
                            $('#detail-noi-dung').text(data.noi_dung || 'Không có nội dung');
                            $('#detail-ket-qua').text(data.ket_qua || 'Không có kết quả');
                        } else {
                            toastr.error('Lỗi: ' + response.message);
                            $('#modal-chi-tiet-tham-vieng').modal('hide');
                        }
                    },
                    error: function (xhr) {
                        console.log('Error response:', xhr.responseText, xhr.status);
                        toastr.error('Đã xảy ra lỗi khi tải chi tiết!');
                        $('#modal-chi-tiet-tham-vieng').modal('hide');
                    }
                });
            });

            // Print button functionality
            $('#btn-print-detail').on('click', function() {
                const printContents = $('#chi-tiet-content').html();
                const originalContents = document.body.innerHTML;

                const printTemplate = `
                    <html>
                    <head>
                        <title>Chi tiết thăm viếng</title>
                        <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
                        <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
                        <style>
                            body { padding: 2rem; font-family: Arial, sans-serif; }
                            .print-header { text-align: center; margin-bottom: 2rem; }
                            .print-title { font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem; }
                            .print-subtitle { font-size: 1rem; color: #6c757d; }
                            .visit-info-card { margin-bottom: 1rem; padding: 1rem; border: 1px solid #dee2e6; border-radius: 0.5rem; }
                            .content-box { padding: 1rem; border: 1px solid #dee2e6; border-radius: 0.5rem; margin-bottom: 1rem; min-height: 5rem; }
                            @media print {
                                .no-print { display: none; }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="print-header">
                            <div class="print-title">Chi tiết thăm viếng</div>
                            <div class="print-subtitle">Ngày in: ${new Date().toLocaleDateString('vi-VN')}</div>
                        </div>
                        ${printContents}
                        <div class="mt-5 text-center no-print">
                            <button onclick="window.print()" class="btn btn-primary">In ngay</button>
                            <button onclick="window.close()" class="btn btn-secondary ml-2">Đóng</button>
                        </div>
                    </body>
                    </html>
                `;

                const printWindow = window.open('', '_blank');
                printWindow.document.write(printTemplate);
                printWindow.document.close();
            });
        });
    </script>
@endsection