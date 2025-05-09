@section('page-styles')
    <style>
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
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
        .action-btns .btn {
            margin: 0 4px;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }
        .btn-icon {
            width: 30px;
            height: 30px;
            padding: 0;
            line-height: 30px;
            text-align: center;
            border-radius: 50%;
        }
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
        .child-row-info {
            padding: 12px;
            background-color: #f8f9fa;
            border-radius: 4px;
            margin: 8px 0;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }
        .child-row-table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        .child-row-table td {
            padding: 5px 10px;
            word-break: break-word;
        }
        .child-row-table td:first-child {
            font-weight: 600;
            width: 180px;
            white-space: nowrap;
        }
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
        .badge-tin-huu-du-le {
            background-color: #ffc107;
            color: white;
        }
        .badge-tin-huu-ht-khac {
            background-color: #6c757d;
            color: white;
        }
        @media (max-width: 768px) {
            .card-title {
                font-size: 1.1rem;
            }
            .btn {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
            }
            .child-row-table td:first-child {
                width: 120px;
            }
            table.dataTable {
                width: 100% !important;
                min-width: 0 !important;
            }
        }
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
                console.error('SweetAlert2 chưa được tải!');
                toastr.error('Không thể hiển thị chi tiết tín hữu do thiếu thư viện SweetAlert2.');
                return;
            }

            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 5000
            };

            $('.select2bs4').select2({
                theme: 'bootstrap4',
                placeholder: '-- Chọn một mục --',
                allowClear: true,
                minimumResultsForSearch: 5,
                width: '100%'
            });

            function formatChildRow(data) {
                if (!data) {
                    console.error('Dữ liệu child row không hợp lệ:', data);
                    return '<div class="child-row-info"><p class="text-danger">Không có dữ liệu để hiển thị</p></div>';
                }

                return '<div class="child-row-info">' +
                    '<table class="child-row-table">' +
                    '<tr>' +
                    '<td><i class="fas fa-map-marker-alt text-primary mr-1"></i> Địa chỉ:</td>' +
                    '<td>' + (data.dia_chi || 'Chưa cập nhật') + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><i class="fas fa-calendar-check text-success mr-1"></i> Ngày sinh hoạt:</td>' +
                    '<td>' + (data.ngay_sinh_hoat_voi_hoi_thanh ? moment(data.ngay_sinh_hoat_voi_hoi_thanh).format('DD/MM/YYYY') : 'Chưa cập nhật') + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><i class="fas fa-pray text-info mr-1"></i> Ngày tin Chúa:</td>' +
                    '<td>' + (data.ngay_tin_chua ? moment(data.ngay_tin_chua).format('DD/MM/YYYY') : 'Chưa cập nhật') + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><i class="fas fa-water text-primary mr-1"></i> Hoàn thành báp têm:</td>' +
                    '<td>' + (data.hoan_thanh_bap_tem ? '<span class="badge badge-success">Có</span>' : '<span class="badge badge-secondary">Không</span>') + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><i class="fas fa-venus-mars text-warning mr-1"></i> Giới tính:</td>' +
                    '<td>' + (data.gioi_tinh === 'nam' ? '<i class="fas fa-male text-primary mr-1"></i> Nam' : data.gioi_tinh === 'nu' ? '<i class="fas fa-female text-danger mr-1"></i> Nữ' : 'Chưa cập nhật') + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td><i class="fas fa-heart text-danger mr-1"></i> Tình trạng hôn nhân:</td>' +
                    '<td>' + (data.tinh_trang_hon_nhan === 'doc_than' ? 'Độc thân' : data.tinh_trang_hon_nhan === 'ket_hon' ? 'Kết hôn' : 'Chưa cập nhật') + '</td>' +
                    '</tr>' +
                    '</table>' +
                    '</div>';
            }

            let tinHuuTable;
            try {
                tinHuuTable = $('#tin-huu-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: '{{ route("api.tin_huu.list") }}',
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
                            d.ban_nganh_id = $('#filter-ban-nganh').val();
                        },
                        error: function (xhr, error, thrown) {
                            console.error('Lỗi khi tải dữ liệu Tín Hữu:', {
                                status: xhr.status,
                                response: xhr.responseJSON,
                                error: error,
                                thrown: thrown
                            });
                            toastr.error(xhr.responseJSON?.message || 'Không thể tải dữ liệu Tín Hữu.');
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
                        {
                            data: 'ban_nganhs',
                            name: 'ban_nganhs',
                            render: function(data) {
                                return data.length ? data.map(b => b.ten).join(', ') : 'N/A';
                            }
                        },
                        {
                            data: 'loai_tin_huu',
                            name: 'loai_tin_huu',
                            render: function(data) {
                                return {
                                    'tin_huu_chinh_thuc': 'Tín hữu chính thức',
                                    'tan_tin_huu': 'Tân tín hữu',
                                    'tin_huu_du_le': 'Tín hữu dự lễ',
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
                    pageLength: 10,
                    drawCallback: function (settings) {
                        console.log('DataTables Tín Hữu loaded:', settings.oInstance.api().data().count());
                    }
                });
            } catch (e) {
                console.error('Lỗi khởi tạo DataTables (tin-huu-table):', e);
                toastr.error('Không thể khởi tạo bảng Tín Hữu.');
            }

            $('#tin-huu-table').on('click', 'td.dt-control', function () {
                var tr = $(this).closest('tr');
                var row = tinHuuTable.row(tr);

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

            $('#filter-ho-ten, #filter-so-dien-thoai, #filter-ngay-sinh, #filter-loai-tin-huu, #filter-gioi-tinh, #filter-tinh-trang-hon-nhan, #filter-hoan-thanh-bap-tem, #filter-tuoi, #filter-thoi-gian-sinh-hoat, #filter-ban-nganh').on('keyup change input', function () {
                console.log('Lọc:', $(this).attr('id'), $(this).val());
                tinHuuTable.ajax.reload();
            });

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
                $('#filter-ban-nganh').val('').trigger('change.select2');
                toastr.info('Đã đặt lại bộ lọc');
                tinHuuTable.ajax.reload();
            });

            $('#form-tin-huu').on('submit', function (e) {
                e.preventDefault();
                const formData = $(this).serialize();
                console.log('Gửi yêu cầu thêm tín hữu:', formData);

                $.ajax({
                    url: '{{ route("_tin_huu.store") }}',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    beforeSend: function () {
                        $('#form-tin-huu button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (thêm tín hữu):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            $('#modal-them-tin-huu').modal('hide');
                            $('#form-tin-huu')[0].reset();
                            $('.select2bs4').val(null).trigger('change');
                            tinHuuTable.ajax.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi khi thêm tín hữu!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (thêm tín hữu):', xhr.responseJSON);
                        let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                        if (xhr.responseJSON?.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        $('#form-tin-huu button[type="submit"]').prop('disabled', false).html('Lưu');
                    }
                });
            });

            $('#tin-huu-table').on('click', '.btn-edit', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ url("quan-ly-tin-huu/tin-huu") }}/' + id + '/edit',
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            var data = response.data;
                            $('#edit_id').val(data.id);
                            $('#edit_ho_ten').val(data.ho_ten);
                            $('#edit_ngay_sinh').val(data.ngay_sinh);
                            $('#edit_so_dien_thoai').val(data.so_dien_thoai);
                            $('#edit_dia_chi').val(data.dia_chi);
                            $('#edit_loai_tin_huu').val(data.loai_tin_huu).trigger('change');
                            $('#edit_gioi_tinh').val(data.gioi_tinh).trigger('change');
                            $('#edit_tinh_trang_hon_nhan').val(data.tinh_trang_hon_nhan).trigger('change');
                            $('#edit_ngay_tin_chua').val(data.ngay_tin_chua);
                            $('#edit_ngay_sinh_hoat_voi_hoi_thanh').val(data.ngay_sinh_hoat_voi_hoi_thanh);
                            $('#edit_ngay_nhan_bap_tem').val(data.ngay_nhan_bap_tem);
                            $('#edit_hoan_thanh_bap_tem').val(data.hoan_thanh_bap_tem ? '1' : '0').trigger('change');
                            $('#edit_noi_xuat_than').val(data.noi_xuat_than);
                            $('#edit_vi_do').val(data.vi_do);
                            $('#edit_kinh_do').val(data.kinh_do);
                            $('#edit_cccd').val(data.cccd);
                            $('#edit_ma_dinh_danh_tinh').val(data.ma_dinh_danh_tinh);
                            $('#edit_ngay_tham_vieng_gan_nhat').val(data.ngay_tham_vieng_gan_nhat);
                            $('#edit_so_lan_vang_lien_tiep').val(data.so_lan_vang_lien_tiep);
                            $('#edit_moi_quan_he').val(data.moi_quan_he).trigger('change');
                            $('#edit_anh_dai_dien').val(data.anh_dai_dien);
                            $('#edit_ban_nganh_id').val(data.ban_nganh_id).trigger('change');
                            $('#edit_chuc_vu').val(data.chuc_vu).trigger('change');
                            $('#modal-sua-tin-huu').modal('show');
                        } else {
                            toastr.error(response.message || 'Không thể lấy thông tin tín hữu!');
                        }
                    },
                    error: function (xhr) {
                        toastr.error(xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!');
                    }
                });
            });

            $('#form-sua-tin-huu').on('submit', function (e) {
                e.preventDefault();
                var id = $('#edit_id').val();
                $.ajax({
                    url: '{{ url("quan-ly-tin-huu/tin-huu") }}/' + id,
                    method: 'PUT',
                    data: $(this).serialize(),
                    dataType: 'json',
                    beforeSend: function () {
                        $('#form-sua-tin-huu button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                    },
                    success: function (response) {
                        console.log('Phản hồi từ server (cập nhật tín hữu):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            $('#modal-sua-tin-huu').modal('hide');
                            tinHuuTable.ajax.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi khi cập nhật tín hữu!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (cập nhật tín hữu):', xhr.responseJSON);
                        let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                        if (xhr.responseJSON?.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                        }
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        $('#form-sua-tin-huu button[type="submit"]').prop('disabled', false).html('Lưu');
                    }
                });
            });

            $('#tin-huu-table').on('click', '.btn-delete', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                $('#delete_id').val(id);
                $('#delete_name').text(name);
                $('#modal-xoa-tin-huu').modal('show');
            });

            $('#confirm-delete').on('click', function () {
                var id = $('#delete_id').val();
                $.ajax({
                    url: '{{ url("quan-ly-tin-huu/tin-huu") }}/' + id,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function (response) {
                        console.log('Phản hồi từ server (xóa tín hữu):', response);
                        if (response.success) {
                            toastr.success(response.message);
                            $('#modal-xoa-tin-huu').modal('hide');
                            tinHuuTable.ajax.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi khi xóa tín hữu!');
                        }
                    },
                    error: function (xhr) {
                        console.error('Lỗi AJAX (xóa tín hữu):', xhr.responseJSON);
                        toastr.error(xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!');
                    }
                });
            });

            $('#tin-huu-table').on('click', '.btn-view', function () {
                var id = $(this).data('id');
                console.log('Yêu cầu xem chi tiết tín hữu:', id);

                if (typeof Swal === 'undefined') {
                    console.error('SweetAlert2 chưa được tải!');
                    toastr.error('Không thể hiển thị chi tiết tín hữu do thiếu SweetAlert2.');
                    return;
                }
                if (typeof moment === 'undefined') {
                    console.error('Moment.js chưa được tải!');
                    toastr.error('Không thể định dạng ngày tháng do thiếu Moment.js.');
                    return;
                }
                if (typeof $().tab === 'undefined') {
                    console.error('Bootstrap tabs chưa được tải!');
                    toastr.error('Không thể khởi tạo tabs chi tiết.');
                    return;
                }

                $.ajax({
                    url: '{{ url("quan-ly-tin-huu/tin-huu") }}/' + id,
                    method: 'GET',
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
                                <div class="modal-detail-content">
                                    <div class="member-profile mb-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-4 col-12 text-center mb-3 mb-md-0">
                                                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" alt="Ảnh đại diện" class="img-fluid rounded-circle shadow" style="width: 100px; height: 100px; object-fit: cover;">
                                                <h5 class="mt-2 mb-1">${data.ho_ten || 'N/A'}</h5>
                                                <p class="text-muted small">${data.ma_dinh_danh_tinh || 'Chưa có mã'}</p>
                                                <div class="member-status">
                                                    <span class="badge badge-${
                                                        data.loai_tin_huu === 'tin_huu_chinh_thuc' ? 'success' :
                                                        data.loai_tin_huu === 'tan_tin_huu' ? 'info' :
                                                        data.loai_tin_huu === 'tin_huu_du_le' ? 'warning' : 'secondary'
                                                    } p-2 mb-2">
                                                        ${
                                                            {
                                                                'tin_huu_chinh_thuc': 'Tín hữu chính thức',
                                                                'tan_tin_huu': 'Tân tín hữu',
                                                                'tin_huu_du_le': 'Tín hữu dự lễ',
                                                                'tin_huu_ht_khac': 'Tín hữu Hội Thánh khác'
                                                            }[data.loai_tin_huu] || data.loai_tin_huu || 'N/A'
                                                        }
                                                    </span>
                                                    ${
                                                        data.ban_nganhs && data.ban_nganhs.length && data.ban_nganhs[0].chuc_vu ? `<span class="badge badge-primary p-2">${data.ban_nganhs[0].chuc_vu}</span>` : ''
                                                    }
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-12">
                                                <div class="quick-info bg-light p-2 rounded shadow-sm">
                                                    <div class="row">
                                                        <div class="col-6 mb-2">
                                                            <i class="fas fa-phone text-primary mr-1"></i>
                                                            <small class="text-muted d-block">Số điện thoại</small>
                                                            ${
                                                                data.so_dien_thoai ?
                                                                `<a href="tel:${data.so_dien_thoai}">${data.so_dien_thoai}</a>` :
                                                                '<span class="text-muted">Chưa cập nhật</span>'
                                                            }
                                                        </div>
                                                        <div class="col-6 mb-2">
                                                            <i class="fas fa-birthday-cake text-danger mr-1"></i>
                                                            <small class="text-muted d-block">Ngày sinh</small>
                                                            ${
                                                                data.ngay_sinh ?
                                                                moment(data.ngay_sinh).format('DD/MM/YYYY') + (data.tuoi ? ` (${data.tuoi} tuổi)` : '') :
                                                                '<span class="text-muted">Chưa cập nhật</span>'
                                                            }
                                                        </div>
                                                        <div class="col-6 mb-2">
                                                            <i class="fas fa-venus-mars text-info mr-1"></i>
                                                            <small class="text-muted d-block">Giới tính</small>
                                                            ${
                                                                data.gioi_tinh === 'nam' ? '<i class="fas fa-male text-primary mr-1"></i> Nam' :
                                                                data.gioi_tinh === 'nu' ? '<i class="fas fa-female text-danger mr-1"></i> Nữ' :
                                                                '<span class="text-muted">Chưa cập nhật</span>'
                                                            }
                                                        </div>
                                                        <div class="col-6 mb-2">
                                                            <i class="fas fa-home text-warning mr-1"></i>
                                                            <small class="text-muted d-block">Hộ gia đình</small>
                                                            ${
                                                                data.ho_gia_dinh ? data.ho_gia_dinh.so_ho : '<span class="text-muted">Chưa cập nhật</span>'
                                                            }
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <ul class="nav nav-tabs nav-tabs-custom" id="member-detail-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info-content" role="tab" aria-controls="info-content" aria-selected="true">
                                                <i class="fas fa-user-circle mr-1"></i> Cá nhân
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="church-tab" data-toggle="tab" href="#church-content" role="tab" aria-controls="church-content" aria-selected="false">
                                                <i class="fas fa-church mr-1"></i> Hội Thánh
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="family-tab" data-toggle="tab" href="#family-content" role="tab" aria-controls="family-content" aria-selected="false">
                                                <i class="fas fa-users mr-1"></i> Gia đình
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content p-3 border border-top-0 rounded-bottom" id="member-detail-tab-content">
                                        <div class="tab-pane fade show active" id="info-content" role="tabpanel" aria-labelledby="info-tab">
                                            <table class="table table-sm table-hover mb-0">
                                                <tr>
                                                    <th style="width: 40%"><i class="fas fa-map-marker-alt text-danger mr-1"></i> Địa chỉ</th>
                                                    <td>${data.dia_chi || '<span class="text-muted">Chưa cập nhật</span>'}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-heart text-danger mr-1"></i> Tình trạng hôn nhân</th>
                                                    <td>${
                                                        data.tinh_trang_hon_nhan === 'doc_than' ? 'Độc thân' :
                                                        data.tinh_trang_hon_nhan === 'ket_hon' ? 'Kết hôn' :
                                                        '<span class="text-muted">Chưa cập nhật</span>'
                                                    }</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-globe text-primary mr-1"></i> Nơi xuất thân</th>
                                                    <td>${data.noi_xuat_than || '<span class="text-muted">Chưa cập nhật</span>'}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="church-content" role="tabpanel" aria-labelledby="church-tab">
                                            <table class="table table-sm table-hover mb-0">
                                                <tr>
                                                    <th style="width: 40%"><i class="fas fa-pray text-success mr-1"></i> Ngày tin Chúa</th>
                                                    <td>${
                                                        data.ngay_tin_chua ?
                                                        moment(data.ngay_tin_chua).format('DD/MM/YYYY') :
                                                        '<span class="text-muted">Chưa cập nhật</span>'
                                                    }</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-water text-primary mr-1"></i> Ngày báp têm</th>
                                                    <td>${
                                                        data.ngay_nhan_bap_tem ?
                                                        moment(data.ngay_nhan_bap_tem).format('DD/MM/YYYY') :
                                                        '<span class="text-muted">Chưa cập nhật</span>'
                                                    }</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-check-circle text-success mr-1"></i> Hoàn thành báp têm</th>
                                                    <td>${
                                                        data.hoan_thanh_bap_tem ?
                                                        '<span class="badge badge-success">Có</span>' :
                                                        '<span class="badge badge-secondary">Không</span>'
                                                    }</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-calendar-check text-info mr-1"></i> Ngày sinh hoạt</th>
                                                    <td>${
                                                        data.ngay_sinh_hoat_voi_hoi_thanh ?
                                                        moment(data.ngay_sinh_hoat_voi_hoi_thanh).format('DD/MM/YYYY') :
                                                        '<span class="text-muted">Chưa cập nhật</span>'
                                                    }</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-users-cog text-warning mr-1"></i> Ban ngành</th>
                                                    <td>${
                                                        data.ban_nganhs && data.ban_nganhs.length ?
                                                        data.ban_nganhs.map(b => `<span class="badge badge-info p-2">${b.ten}</span>`).join(' ') :
                                                        '<span class="text-muted">Chưa tham gia ban ngành</span>'
                                                    }</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-user-tie text-primary mr-1"></i> Chức vụ</th>
                                                    <td>${
                                                        data.ban_nganhs && data.ban_nganhs.length && data.ban_nganhs[0].chuc_vu ?
                                                        `<span class="badge badge-primary p-2">${data.ban_nganhs[0].chuc_vu}</span>` :
                                                        '<span class="text-muted">Không có chức vụ</span>'
                                                    }</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="family-content" role="tabpanel" aria-labelledby="family-tab">
                                            <table class="table table-sm table-hover mb-0">
                                                <tr>
                                                    <th style="width: 40%"><i class="fas fa-home text-info mr-1"></i> Hộ gia đình</th>
                                                    <td>${data.ho_gia_dinh ? data.ho_gia_dinh.so_ho : '<span class="text-muted">Chưa cập nhật</span>'}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-link text-warning mr-1"></i> Mối quan hệ</th>
                                                    <td>${data.moi_quan_he || '<span class="text-muted">Chưa cập nhật</span>'}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            `;

                            var modalStyle = `
                                <style>
                                    .swal2-popup.detail-modal {
                                        padding: 0;
                                        max-width: 90%;
                                        width: 700px;
                                    }
                                    .swal2-title {
                                        margin: 0;
                                        padding: 10px 15px;
                                        background-color: #f8f9fa;
                                        border-bottom: 1px solid #dee2e6;
                                        font-size: 1.1rem;
                                        color: #495057;
                                    }
                                    .swal2-html-container {
                                        margin: 0;
                                        padding: 0;
                                        overflow-y: auto;
                                        max-height: 60vh;
                                    }
                                    .modal-detail-content {
                                        padding: 15px;
                                        font-size: 0.9rem;
                                    }
                                    .member-profile img {
                                        transition: transform 0.2s;
                                    }
                                    .member-profile img:hover {
                                        transform: scale(1.05);
                                    }
                                    .quick-info {
                                        border: 1px solid #e9ecef;
                                    }
                                    .nav-tabs-custom {
                                        border-bottom: 1px solid #dee2e6;
                                        margin-bottom: 10px;
                                    }
                                    .nav-tabs-custom .nav-link {
                                        color: #495057;
                                        border: 1px solid transparent;
                                        border-radius: 0.25rem 0.25rem 0 0;
                                        padding: 0.5rem 0.75rem;
                                        font-size: 0.85rem;
                                    }
                                    .nav-tabs-custom .nav-link:hover {
                                        border-color: #e9ecef #e9ecef #dee2e6;
                                    }
                                    .nav-tabs-custom .nav-link.active {
                                        color: #007bff;
                                        background-color: #fff;
                                        border-color: #dee2e6 #dee2e6 #fff;
                                        font-weight: 600;
                                    }
                                    .table th {
                                        background-color: rgba(0,0,0,.03);
                                        font-weight: 600;
                                        color: #495057;
                                        vertical-align: middle;
                                    }
                                    .table td {
                                        vertical-align: middle;
                                    }
                                    @media (max-width: 576px) {
                                        .swal2-popup.detail-modal {
                                            width: 95%;
                                        }
                                        .swal2-title {
                                            font-size: 1rem;
                                        }
                                        .modal-detail-content {
                                            font-size: 0.8rem;
                                            padding: 10px;
                                        }
                                        .member-profile img {
                                            width: 80px;
                                            height: 80px;
                                        }
                                        .quick-info .col-6 {
                                            width: 100%;
                                        }
                                        .table th {
                                            font-size: 0.8rem;
                                            width: 50% !important;
                                        }
                                        .table td {
                                            font-size: 0.8rem;
                                        }
                                    }
                                </style>
                            `;

                            Swal.fire({
                                title: 'Thông tin chi tiết tín hữu',
                                html: modalStyle + content,
                                showConfirmButton: false,
                                showCloseButton: true,
                                allowEscapeKey: true,
                                customClass: {
                                    popup: 'detail-modal'
                                },
                                didOpen: () => {
                                    try {
                                        $('#member-detail-tabs a').on('click', function(e) {
                                            e.preventDefault();
                                            $(this).tab('show');
                                        });
                                    } catch (e) {
                                        console.error('Lỗi khởi tạo tabs:', e);
                                        toastr.error('Không thể khởi tạo tabs chi tiết.');
                                    }
                                },
                                willClose: () => {
                                    $('#member-detail-tabs a').off('click');
                                }
                            });
                        } else {
                            toastr.error(response.message || 'Không thể tải chi tiết tín hữu!');
                        }
                    },
                    error: function (xhr) {
                        Swal.close();
                        console.error('Lỗi AJAX (xem chi tiết):', xhr.responseJSON);
                        toastr.error(xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!');
                    }
                });
            });

            $('#btn-export').click(function () {
                toastr.info('Chức năng xuất Excel sẽ được phát triển sau.');
            });
        });
    </script>
@endsection