@section('page-scripts')
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

    // Cấu hình Toastr
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: 'toast-top-right',
        timeOut: 5000
    };

    // Khởi tạo Select2 cho tất cả các trang
    $('.select2bs4').select2({
        theme: 'bootstrap4',
        placeholder: '-- Chọn một mục --',
        allowClear: true,
        minimumResultsForSearch: 5,
        width: '100%'
    });

    // Logic cho trang danh sách lớp học
    if ($('#lop-hoc-table').length) {
        // Hàm format chi tiết mở rộng
        function formatChildRow(data) {
            if (!data) {
                console.error('Dữ liệu child row không hợp lệ:', data);
                return '<div class="child-row-info"><p class="text-danger">Không có dữ liệu để hiển thị</p></div>';
            }

            return '<div class="child-row-info">' +
                '<table class="child-row-table">' +
                '<tr>' +
                '<td><i class="fas fa-book text-primary mr-1"></i> Mô tả:</td>' +
                '<td>' + (data.mo_ta || 'Chưa cập nhật') + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><i class="fas fa-clock text-success mr-1"></i> Tần suất:</td>' +
                '<td>' + (data.tan_suat === 'co_dinh' ? 'Cố định' : 'Linh hoạt') + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><i class="fas fa-map-marker-alt text-info mr-1"></i> Địa điểm:</td>' +
                '<td>' + (data.dia_diem || 'Chưa cập nhật') + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><i class="fas fa-calendar-alt text-warning mr-1"></i> Thời gian bắt đầu:</td>' +
                '<td>' + (data.thoi_gian_bat_dau ? moment(data.thoi_gian_bat_dau).format('DD/MM/YYYY HH:mm') : 'Chưa cập nhật') + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td><i class="fas fa-calendar-check text-danger mr-1"></i> Thời gian kết thúc:</td>' +
                '<td>' + (data.thoi_gian_ket_thuc ? moment(data.thoi_gian_ket_thuc).format('DD/MM/YYYY HH:mm') : 'Chưa cập nhật') + '</td>' +
                '</tr>' +
                '</table>' +
                '</div>';
        }

        // Khởi tạo DataTable
        let lopHocTable;
        try {
            lopHocTable = $('#lop-hoc-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route("lop-hoc.index") }}',
                    type: 'GET',
                    data: function (d) {
                        d.ten_lop = $('#filter-ten-lop').val();
                        d.loai_lop = $('#filter-loai-lop').val();
                        d.tan_suat = $('#filter-tan-suat').val();
                        d.dia_diem = $('#filter-dia-diem').val();
                    },
                    error: function (xhr, error, thrown) {
                        console.error('Lỗi khi tải dữ liệu Lớp học:', {
                            status: xhr.status,
                            response: xhr.responseJSON,
                            error: error,
                            thrown: thrown
                        });
                        toastr.error(xhr.responseJSON?.message || 'Không thể tải dữ liệu Lớp học.');
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
                    { data: 'ten_lop', name: 'ten_lop' },
                    {
                        data: 'loai_lop',
                        name: 'loai_lop',
                        render: function(data) {
                            return {
                                'bap_tem': 'Lớp Báp-têm',
                                'thanh_nien': 'Thanh niên',
                                'trung_lao': 'Trung lão',
                                'khac': 'Khác'
                            }[data] || data;
                        }
                    },
                    {
                        data: 'thoi_gian_bat_dau',
                        name: 'thoi_gian_bat_dau',
                        render: function(data) {
                            return data ? moment(data).format('DD/MM/YYYY HH:mm') : 'N/A';
                        }
                    },
                    { data: 'dia_diem', name: 'dia_diem' },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <div class="action-btns">
                                    @can('sua-lop-hoc')
                                        <a href="{{ url('/lop-hoc') }}/${row.id}/edit" class="btn btn-warning btn-icon" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('xoa-lop-hoc')
                                        <button class="btn btn-danger btn-icon btn-xoa-lop-hoc" data-lop-hoc-id="${row.id}" data-ten-lop="${row.ten_lop}" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endcan
                                    @can('quan-ly-hoc-vien')
                                        <button class="btn btn-primary btn-icon btn-them-hoc-vien" data-lop-hoc-id="${row.id}" title="Thêm học viên" data-toggle="modal" data-target="#themHocVienModal">
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    @endcan
                                </div>
                            `;
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    url: '{{ asset("dist/js/Vietnamese.json") }}'
                },
                columnDefs: [
                    { targets: [0, 1, 6], responsivePriority: 1 },
                    { targets: [2, 3, 4, 5], responsivePriority: 100 }
                ],
                order: [],
                pageLength: 10,
                drawCallback: function (settings) {
                    console.log('DataTables Lớp học loaded:', settings.oInstance.api().data().count());
                }
            });
        } catch (e) {
            console.error('Lỗi khởi tạo DataTables (lop-hoc-table):', e);
            toastr.error('Không thể khởi tạo bảng Lớp học.');
        }

        // Xử lý mở rộng hàng trong DataTable
        $('#lop-hoc-table').off('click', 'td.dt-control').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = lopHocTable.row(tr);

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
        $('#filter-ten-lop, #filter-loai-lop, #filter-tan-suat, #filter-dia-diem').on('keyup change input', function () {
            console.log('Lọc:', $(this).attr('id'), $(this).val());
            lopHocTable.ajax.reload();
        });

        // Xử lý modal thêm học viên
        $('#lop-hoc-table').on('click', '.btn-them-hoc-vien', function () {
            var lopHocId = $(this).data('lop-hoc-id');
            $('#form-them-hoc-vien').attr('action', '/lop-hoc/' + lopHocId + '/hoc-vien');
        });

        $('#form-them-hoc-vien').on('submit', function (e) {
            e.preventDefault();
            const formData = $(this).serialize();
            console.log('Gửi yêu cầu thêm học viên:', formData);

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                dataType: 'json',
                beforeSend: function () {
                    $('#form-them-hoc-vien button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                },
                success: function (response) {
                    console.log('Phản hồi từ server (thêm học viên):', response);
                    if (response.success) {
                        toastr.success(response.message);
                        $('#themHocVienModal').modal('hide');
                        lopHocTable.ajax.reload();
                    } else {
                        toastr.error(response.message || 'Có lỗi khi thêm học viên!');
                    }
                },
                error: function (xhr) {
                    console.error('Lỗi AJAX (thêm học viên):', xhr.responseJSON);
                    let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                    if (xhr.responseJSON?.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }
                    toastr.error(errorMessage);
                },
                complete: function () {
                    $('#form-them-hoc-vien button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save"></i> Lưu');
                }
            });
        });
    }
});

@endsection