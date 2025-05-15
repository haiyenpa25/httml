<script>
    $(function () {
        // Khởi tạo Select2
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            placeholder: 'Chọn một mục',
            allowClear: true,
            width: '100%'
        });

        // Định dạng số tiền
        $('.money-format').on('input', function () {
            let value = $(this).val().replace(/\D/g, '');
            $(this).val(formatCurrency(value));
        });

        function formatCurrency(value) {
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Cập nhật số lượng tham dự và dâng hiến
        $('.update-count').on('click', function () {
            const btn = $(this);
            const row = btn.closest('tr');
            const id = btn.data('id');
            const type = btn.data('type');

            let url = '';
            let data = {};

            if (type === 'bn') {
                const soLuong = row.find('input[name="buoi_nhom[' + id + '][so_luong]"]').val();
                let dangHien = row.find('input[name="buoi_nhom[' + id + '][dang_hien]"]').val();
                dangHien = dangHien.replace(/\./g, '');

                url = "{{ route('api._ban_co_doc_giao_duc.update_tham_du', ['banType' => 'ban-co-doc-giao-duc']) }}";
                data = {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    ban_nganh: "{{ $selectedBanNganh }}",
                    so_luong: soLuong,
                    dang_hien: dangHien
                };
            }

            if (url) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                    dataType: 'json',
                    beforeSend: function () {
                        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success('Đã cập nhật thành công', 'Thành công');
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra', 'Lỗi');
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Có lỗi xảy ra khi xử lý yêu cầu', 'Lỗi');
                    },
                    complete: function () {
                        btn.prop('disabled', false).html('<i class="fas fa-save"></i>');
                    }
                });
            }
        });

        // Xử lý form điểm danh
        $('#thamdu-form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $('#thamdu-form button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Đang lưu...');
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message || 'Đã lưu thông tin tham dự và dâng hiến', 'Thành công');
                    } else {
                        toastr.error(response.message || 'Có lỗi xảy ra', 'Lỗi');
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    toastr.error('Có lỗi xảy ra khi xử lý yêu cầu', 'Lỗi');
                },
                complete: function () {
                    $('#thamdu-form button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Lưu tất cả');
                }
            });
        });

        // Xử lý thêm/xóa kế hoạch
        $('#add-kehoach').on('click', function () {
            const count = $('#plans-container .planning-item').length;
            const template = `
            <div class="planning-item">
                <div class="row">
                    <div class="col-md-12 col-lg-4 mb-3 mb-lg-0">
                        <div class="form-group mb-lg-0">
                            <label class="font-weight-medium"><i class="fas fa-tasks mr-1"></i>Hoạt động</label>
                            <input type="text" class="form-control" name="kehoach[${count}][hoat_dong]"
                                value="" required placeholder="Tên hoạt động">
                            <input type="hidden" name="kehoach[${count}][id]" value="0">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 mb-3 mb-lg-0">
                        <div class="form-group mb-lg-0">
                            <label class="font-weight-medium"><i class="fas fa-clock mr-1"></i>Thời gian</label>
                            <input type="text" class="form-control" name="kehoach[${count}][thoi_gian]"
                                value="" placeholder="Ngày/giờ">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
                        <div class="form-group mb-lg-0">
                            <label class="font-weight-medium"><i class="fas fa-user mr-1"></i>Người phụ trách</label>
                            <select class="form-control select2-new" name="kehoach[${count}][nguoi_phu_trach_id]">
                                <option value="">-- Chọn người phụ trách --</option>
                                @foreach ($tinHuu as $tinHuu)
                                    <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-10 col-lg-2 mb-3 mb-md-0">
                        <div class="form-group mb-lg-0">
                            <label class="font-weight-medium"><i class="fas fa-sticky-note mr-1"></i>Ghi chú</label>
                            <textarea class="form-control" name="kehoach[${count}][ghi_chu]" rows="1" placeholder="Ghi chú"></textarea>
                        </div>
                    </div>
                    <div class="col-md-2 col-lg-1 d-flex align-items-end justify-content-end">
                        <button type="button" class="btn btn-danger remove-kehoach">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

            $('#plans-container').append(template);

            // Khởi tạo select2 cho các phần tử mới
            $('.select2-new').select2({
                theme: 'bootstrap4',
                placeholder: 'Chọn một mục',
                allowClear: true,
                width: '100%'
            }).removeClass('select2-new');
        });

        // Xóa một kế hoạch
        $(document).on('click', '.remove-kehoach', function () {
            if ($('#plans-container .planning-item').length > 1) {
                $(this).closest('.planning-item').remove();
            } else {
                toastr.warning('Cần ít nhất một kế hoạch', 'Cảnh báo');
            }
        });

        // Xử lý form kế hoạch
        $('#kehoach-form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $('#kehoach-form button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Đang lưu...');
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message || 'Đã lưu kế hoạch thành công', 'Thành công');
                    } else {
                        toastr.error(response.message || 'Có lỗi xảy ra', 'Lỗi');
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    toastr.error('Có lỗi xảy ra khi xử lý yêu cầu', 'Lỗi');
                },
                complete: function () {
                    $('#kehoach-form button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Lưu kế hoạch');
                }
            });
        });

        // Xử lý thêm/xóa kiến nghị
        $('#add-kiennghi').on('click', function () {
            const count = $('#kiennghi-container .suggestion-card').length;
            const template = `
            <div class="col-md-6 mb-4">
                <div class="suggestion-card h-100">
                    <div class="card-header d-flex align-items-center">
                        <h6 class="m-0 font-weight-bold">Kiến nghị #${count + 1}</h6>
                        <button type="button" class="btn btn-sm btn-outline-danger ml-auto remove-kiennghi">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-medium"><i class="fas fa-heading mr-1"></i>Tiêu đề</label>
                            <input type="text" class="form-control" name="kiennghi[${count}][tieu_de]"
                                    value="" required placeholder="Nhập tiêu đề kiến nghị">
                            <input type="hidden" name="kiennghi[${count}][id]" value="0">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-medium"><i class="fas fa-align-left mr-1"></i>Nội dung</label>
                            <textarea class="form-control" name="kiennghi[${count}][noi_dung]"
                                    rows="3" required placeholder="Mô tả chi tiết kiến nghị..."></textarea>
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-medium"><i class="fas fa-user mr-1"></i>Người đề xuất</label>
                            <select class="form-control select2-new" name="kiennghi[${count}][nguoi_de_xuat_id]">
                                <option value="">-- Chọn người đề xuất --</option>
                                @foreach ($tinHuu as $tinHuu)
                                    <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        `;

            $('#kiennghi-container').append(template);

            // Khởi tạo select2 cho các phần tử mới
            $('.select2-new').select2({
                theme: 'bootstrap4',
                placeholder: 'Chọn một mục',
                allowClear: true,
                width: '100%'
            }).removeClass('select2-new');
        });

        // Xóa một kiến nghị
        $(document).on('click', '.remove-kiennghi', function () {
            if ($('#kiennghi-container .suggestion-card').length > 1) {
                $(this).closest('.col-md-6').remove();
            } else {
                toastr.warning('Cần ít nhất một kiến nghị', 'Cảnh báo');
            }
        });

        // Xử lý form kiến nghị
        $('#kiennghi-form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $('#kiennghi-form button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Đang lưu...');
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message || 'Đã lưu kiến nghị thành công', 'Thành công');
                    } else {
                        toastr.error(response.message || 'Có lỗi xảy ra', 'Lỗi');
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    toastr.error('Có lỗi xảy ra khi xử lý yêu cầu', 'Lỗi');
                },
                complete: function () {
                    $('#kiennghi-form button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Lưu tất cả');
                }
            });
        });

        // Xử lý form đánh giá điểm mạnh
        $('#add-diem-manh-form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $('#add-diem-manh-form button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Đang lưu...');
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message || 'Đã thêm điểm mạnh thành công', 'Thành công');
                        $('#modal-add-diem-manh').modal('hide');
                        $('#add-diem-manh-form')[0].reset();
                        refreshDanhGia();
                    } else {
                        toastr.error(response.message || 'Có lỗi xảy ra', 'Lỗi');
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    toastr.error('Có lỗi xảy ra khi xử lý yêu cầu', 'Lỗi');
                },
                complete: function () {
                    $('#add-diem-manh-form button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Lưu điểm mạnh');
                }
            });
        });

        // Xử lý form đánh giá điểm yếu
        $('#add-diem-yeu-form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $('#add-diem-yeu-form button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Đang lưu...');
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message || 'Đã thêm điểm cần cải thiện thành công', 'Thành công');
                        $('#modal-add-diem-yeu').modal('hide');
                        $('#add-diem-yeu-form')[0].reset();
                        refreshDanhGia();
                    } else {
                        toastr.error(response.message || 'Có lỗi xảy ra', 'Lỗi');
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    toastr.error('Có lỗi xảy ra khi xử lý yêu cầu', 'Lỗi');
                },
                complete: function () {
                    $('#add-diem-yeu-form button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Lưu điểm cần cải thiện');
                }
            });
        });

        // Tải dữ liệu đánh giá
        function loadDanhGia() {
            const manh_url = "{{ route('api._ban_co_doc_giao_duc.danh_gia_list', ['banType' => 'ban-co-doc-giao-duc']) }}?month={{ $month }}&year={{ $year }}&ban_nganh_id={{ $config['id'] }}&loai=diem_manh";
            const yeu_url = "{{ route('api._ban_co_doc_giao_duc.danh_gia_list', ['banType' => 'ban-co-doc-giao-duc']) }}?month={{ $month }}&year={{ $year }}&ban_nganh_id={{ $config['id'] }}&loai=diem_yeu";

            // Tải dữ liệu điểm mạnh
            $('#diem-manh-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: manh_url,
                    type: 'GET'
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    { data: 'noi_dung', name: 'noi_dung' },
                    { data: 'nguoi_danh_gia', name: 'nguoi_danh_gia' },
                    {
                        data: 'id',
                        render: function (data) {
                            return '<button class="btn btn-danger btn-sm delete-danh-gia" data-id="' + data + '"><i class="fas fa-trash"></i></button>';
                        },
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Vietnamese.json'
                },
                responsive: true,
                autoWidth: false
            });

            // Tải dữ liệu điểm yếu
            $('#diem-yeu-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: yeu_url,
                    type: 'GET'
                },
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    { data: 'noi_dung', name: 'noi_dung' },
                    { data: 'nguoi_danh_gia', name: 'nguoi_danh_gia' },
                    {
                        data: 'id',
                        render: function (data) {
                            return '<button class="btn btn-danger btn-sm delete-danh-gia" data-id="' + data + '"><i class="fas fa-trash"></i></button>';
                        },
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Vietnamese.json'
                },
                responsive: true,
                autoWidth: false
            });
        }

        // Cập nhật dữ liệu đánh giá sau khi thêm
        function refreshDanhGia() {
            $('#diem-manh-table').DataTable().ajax.reload();
            $('#diem-yeu-table').DataTable().ajax.reload();
        }

        // Xóa đánh giá
        $(document).on('click', '.delete-danh-gia', function () {
            const id = $(this).data('id');
            const url = "{{ route('api._ban_co_doc_giao_duc.xoa_danh_gia', ['banType' => 'ban-co-doc-giao-duc', 'id' => '']) }}/" + id;

            if (confirm('Bạn có chắc chắn muốn xóa đánh giá này?')) {
                $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message || 'Đã xóa đánh giá thành công', 'Thành công');
                            refreshDanhGia();
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra', 'Lỗi');
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error('Có lỗi xảy ra khi xử lý yêu cầu', 'Lỗi');
                    }
                });
            }
        });

        // Khởi tạo DataTables khi trang tải xong
        loadDanhGia();

        // Cấu hình toastr
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 3000
        };

        // Nhấp vào tab
        $('#baocao-tabs a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

        // Lưu trạng thái tab khi chuyển tab
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            localStorage.setItem('activeReportTab', $(e.target).attr('id'));
        });

        // Khôi phục tab đã chọn trước đó
        var activeTab = localStorage.getItem('activeReportTab');
        if (activeTab) {
            $('#baocao-tabs #' + activeTab).tab('show');
        }
    });
</script>