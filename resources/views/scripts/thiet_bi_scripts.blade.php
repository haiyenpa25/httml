@section('page-scripts')
    <!-- resources/views/_thiet_bi/partials/thiet_bi_scripts.blade.php -->

    <script>
        /**
         * File JavaScript chính cho module quản lý thiết bị
         * Chứa logic cho trang danh sách thiết bị
         */

        /**
         * Hàm định dạng tình trạng thiết bị thành badge
         * @param {string} tinhTrang - Mã tình trạng thiết bị (tot, hong, dang_sua)
         * @return {string} HTML badge hiển thị tình trạng
         */
        function formatTinhTrang(tinhTrang) {
            const tinhTrangMap = {
                'tot': '<span class="badge badge-success">Tốt</span>',
                'hong': '<span class="badge badge-danger">Hỏng</span>',
                'dang_sua': '<span class="badge badge-warning">Đang sửa</span>'
            };
            return tinhTrangMap[tinhTrang] || tinhTrang;
        }

        /**
         * Hàm định dạng loại thiết bị từ mã sang văn bản hiển thị
         * @param {string} loai - Mã loại thiết bị
         * @return {string} Tên hiển thị của loại thiết bị
         */
        function formatLoaiThietBi(loai) {
            const loaiMap = {
                'nhac_cu': 'Nhạc cụ',
                'anh_sang': 'Ánh sáng',
                'am_thanh': 'Âm thanh',
                'hinh_anh': 'Hình ảnh',
                'khac': 'Khác'
            };
            return loaiMap[loai] || loai;
        }

        /**
         * Hàm định dạng số tiền sang định dạng tiền tệ Việt Nam
         * @param {number} amount - Số tiền cần định dạng
         * @return {string} Chuỗi đã định dạng thành tiền tệ
         */
        function formatCurrency(amount) {
            return amount ? new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
                maximumFractionDigits: 0
            }).format(amount) : 'N/A';
        }

        /**
         * Hàm định dạng ngày tháng
         * @param {string} date - Chuỗi ngày tháng (YYYY-MM-DD)
         * @return {string} Ngày tháng đã định dạng (DD/MM/YYYY)
         */
        function formatDate(date) {
            if (!date) return 'N/A';
            const d = new Date(date);
            return d.getDate().toString().padStart(2, '0') + '/' +
                   (d.getMonth() + 1).toString().padStart(2, '0') + '/' +
                   d.getFullYear();
        }

        /**
         * Hàm debounce để giới hạn tần suất gọi hàm
         * @param {Function} func - Hàm cần debounce
         * @param {number} wait - Thời gian chờ (ms)
         * @return {Function} Hàm đã được debounce
         */
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        /**
         * Hàm tải danh sách người quản lý (tín hữu)
         * @param {string} selectSelector - CSS selector cho thẻ select cần populate
         */
        function loadTinHuuList(selectSelector) {
            $(selectSelector).select2({
                ajax: {
                    url: getBaseUrl() + "/tin-huu/get-tin-huus",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { search: params.term };
                    },
                    processResults: function (data) {
                        console.log('Dữ liệu tín hữu trả về:', data);
                        return {
                            results: data.map(function (item) {
                                return { id: item.id, text: item.ho_ten };
                            })
                        };
                    },
                    cache: true,
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi tải danh sách tín hữu:', xhr.status, xhr.responseText);
                        toastr.error('Không thể tải danh sách tín hữu. Mã lỗi: ' + xhr.status);
                    }
                },
                placeholder: '-- Chọn Người Quản Lý --',
                minimumInputLength: 0,
                allowClear: true
            });
        }

        /**
         * Hàm tải danh sách nhà cung cấp
         * @param {string} selectSelector - CSS selector cho thẻ select cần populate
         */
        function loadNhaCungCapList(selectSelector) {
            $(selectSelector).select2({
                ajax: {
                    url: getBaseUrl() + "/nha-cung-cap/get-nha-cung-caps",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { search: params.term };
                    },
                    processResults: function (data) {
                        console.log('Dữ liệu nhà cung cấp trả về:', data);
                        if (data && data.data) {
                            return {
                                results: data.data.map(function (item) {
                                    return { id: item.id, text: item.ten_nha_cung_cap };
                                })
                            };
                        } else if (Array.isArray(data)) {
                            return {
                                results: data.map(function (item) {
                                    return { id: item.id, text: item.ten_nha_cung_cap };
                                })
                            };
                        } else {
                            console.error('Dữ liệu nhà cung cấp không đúng định dạng:', data);
                            return { results: [] };
                        }
                    },
                    cache: true,
                    error: function (xhr, status, error) {
                        console.error('Lỗi khi tải danh sách nhà cung cấp:', xhr.status, xhr.responseText);
                        toastr.error('Không thể tải danh sách nhà cung cấp. Mã lỗi: ' + xhr.status);
                    }
                },
                placeholder: '-- Chọn Nhà Cung Cấp --',
                minimumInputLength: 0,
                allowClear: true
            });
        }

        /**
         * Hàm tải lịch sử bảo trì của một thiết bị
         * @param {number} thietBiId - ID của thiết bị cần lấy lịch sử
         * @param {string} listSelector - CSS selector cho phần tử cần hiển thị danh sách
         */
        function loadLichSuBaoTri(thietBiId, listSelector) {
            $.ajax({
                url: getBaseUrl() + "/lich-su-bao-tri/thiet-bi/" + thietBiId,
                type: "GET",
                success: function (response) {
                    var html = '';
                    if (response.length > 0) {
                        $.each(response, function (index, item) {
                            html += '<tr>';
                            html += '<td>' + formatDate(item.ngay_bao_tri) + '</td>';
                            html += '<td>' + formatCurrency(item.chi_phi) + '</td>';
                            html += '<td>' + item.nguoi_thuc_hien + '</td>';
                            html += '<td>' + (item.mo_ta || 'N/A') + '</td>';
                            html += '<td>';
                            html += '<div class="btn-group">';
                            html += '<button type="button" class="btn btn-primary btn-sm btn-edit-bao-tri" data-id="' + item.id + '">';
                            html += '<i class="fas fa-edit"></i>';
                            html += '</button>';
                            html += '<button type="button" class="btn btn-danger btn-sm btn-delete-bao-tri" data-id="' + item.id + '">';
                            html += '<i class="fas fa-trash"></i>';
                            html += '</button>';
                            html += '</div>';
                            html += '</td>';
                            html += '</tr>';
                        });
                    } else {
                        html = '<tr><td colspan="5" class="text-center">Không có dữ liệu</td></tr>';
                    }
                    $(listSelector).html(html);
                },
                error: function (xhr) {
                    console.error("Không thể tải lịch sử bảo trì:", xhr.responseText);
                    $(listSelector).html('<tr><td colspan="5" class="text-center text-danger">Lỗi khi tải dữ liệu</td></tr>');
                }
            });
        }

        /**
         * Hàm lấy URL gốc của ứng dụng
         * @return {string} URL gốc
         */
        function getBaseUrl() {
            return window.location.protocol + "//" + window.location.host + (window.location.pathname.split('/')[1] ? '/' + window.location.pathname.split('/')[1] : '');
        }

        /**
         * Logic chính cho trang quản lý thiết bị
         */
        $(document).ready(function () {
            // Khởi tạo Select2 cho các trang nếu cần
            $('.select2').select2();

            // Tải danh sách người quản lý và nhà cung cấp cho trang thiết bị
            if ($('#nguoi_quan_ly_id, #edit_nguoi_quan_ly_id').length) {
                loadTinHuuList('#nguoi_quan_ly_id, #edit_nguoi_quan_ly_id');
            }
            if ($('#nha_cung_cap_id, #edit_nha_cung_cap_id').length) {
                loadNhaCungCapList('#nha_cung_cap_id, #edit_nha_cung_cap_id');
            }

            // Logic cho trang danh sách thiết bị
            if ($('#thiet-bi-table').length) {
                var thietBiTable = $('#thiet-bi-table').DataTable({
                    processing: true,
                    serverSide: false,
                    responsive: true, // Bật responsive cho DataTable
                    ajax: {
                        url: "{{ route('thiet-bi.get-thiet-bis') }}",
                        data: function (d) {
                            d.loai = $('#filter-loai-thiet-bi').val();
                            d.tinh_trang = $('#filter-tinh-trang').val();
                            d.ban_nganh_id = $('#filter-ban-nganh').val();
                            d.vi_tri = $('#filter-vi-tri').val();
                        },
                        dataSrc: function (json) {
                            console.log('Dữ liệu thiết bị trả về từ server:', json);
                            if (json && json.data) {
                                return json.data; // Lấy dữ liệu từ key 'data' nếu tồn tại
                            } else if (Array.isArray(json)) {
                                return json; // Nếu là mảng trực tiếp, trả về luôn
                            } else {
                                console.error('Dữ liệu thiết bị không đúng định dạng:', json);
                                return [];
                            }
                        },
                        error: function (xhr, error, thrown) {
                            console.error('Lỗi AJAX DataTable:', xhr.status, xhr.responseText, error, thrown);
                            if (xhr.status === 401 || xhr.status === 403) {
                                toastr.error('Bạn cần đăng nhập để xem danh sách thiết bị.');
                                setTimeout(function() {
                                    window.location.href = '/login'; // Chuyển hướng đến trang đăng nhập
                                }, 2000);
                            } else if (xhr.status === 500) {
                                toastr.error('Lỗi server (500). Vui lòng kiểm tra log server để biết chi tiết: ' + (xhr.responseText || 'Không có thông tin chi tiết'));
                            } else {
                                toastr.error('Không thể tải danh sách thiết bị. Mã lỗi: ' + xhr.status);
                            }
                        }
                    },
                    columns: [
                        { data: null, render: function (data, type, row, meta) { return meta.row + 1; } },
                        { data: 'ten' },
                        {
                            data: 'loai',
                            render: function (data) {
                                return formatLoaiThietBi(data);
                            }
                        },
                        {
                            data: 'tinh_trang',
                            render: function (data) {
                                return formatTinhTrang(data);
                            }
                        },
                        {
                            data: 'ban_nganh',
                            render: function (data) {
                                return data ? data.ten : 'N/A';
                            }
                        },
                        { data: 'vi_tri_hien_tai' },
                        { data: 'ma_tai_san' },
                        {
                            data: null,
                            render: function (data) {
                                return `
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-sm btn-detail" data-id="${data.id}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm btn-edit" data-id="${data.id}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${data.id}" data-name="${data.ten}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                `;
                            }
                        }
                    ],
                    language: {
                        url: '{{ asset("i18n/Vietnamese.json") }}'
                    }
                });

                // Làm mới bảng dữ liệu
                $('#btn-refresh').click(function () {
                    thietBiTable.ajax.reload();
                });

                // Lọc dữ liệu
                $('#filter-loai-thiet-bi, #filter-tinh-trang, #filter-ban-nganh').change(function () {
                    thietBiTable.ajax.reload();
                });

                $('#filter-vi-tri').on('keyup', debounce(function () {
                    thietBiTable.ajax.reload();
                }, 500));

                // Xử lý thêm thiết bị
                $('#form-thiet-bi').submit(function (e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        url: "{{ route('thiet-bi.store') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $('#modal-them-thiet-bi .btn-primary').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                        },
                        success: function (response) {
                            if (response.success) {
                                $('#modal-them-thiet-bi').modal('hide');
                                $('#form-thiet-bi')[0].reset();
                                thietBiTable.ajax.reload();
                                toastr.success(response.message);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function (xhr) {
                            console.error('Lỗi khi thêm thiết bị:', xhr.status, xhr.responseText);
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                $.each(errors, function (key, value) {
                                    toastr.error(value[0]);
                                });
                            } else if (xhr.status === 401 || xhr.status === 403) {
                                toastr.error('Bạn cần đăng nhập để thêm thiết bị.');
                                setTimeout(function() {
                                    window.location.href = '/login';
                                }, 2000);
                            } else {
                                toastr.error('Không thể thêm thiết bị. Mã lỗi: ' + xhr.status);
                            }
                        },
                        complete: function () {
                            $('#modal-them-thiet-bi .btn-primary').prop('disabled', false).html('Lưu');
                        }
                    });
                });

                // Xử lý sửa thiết bị
                $('#thiet-bi-table').on('click', '.btn-edit', function () {
                    var id = $(this).data('id');
                    $.ajax({
                        url: '{{ route("thiet-bi.edit", ":id") }}'.replace(':id', id),
                        type: 'GET',
                        success: function (response) {
                            $('#edit_id').val(response.id);
                            $('#edit_ten').val(response.ten);
                            $('#edit_ma_tai_san').val(response.ma_tai_san);
                            $('#edit_loai').val(response.loai);
                            $('#edit_tinh_trang').val(response.tinh_trang);
                            $('#edit_vi_tri_hien_tai').val(response.vi_tri_hien_tai);
                            $('#edit_id_ban').val(response.id_ban).trigger('change');
                            $('#edit_nguoi_quan_ly_id').val(response.nguoi_quan_ly_id).trigger('change');
                            $('#edit_nha_cung_cap_id').val(response.nha_cung_cap_id).trigger('change');
                            $('#edit_ngay_mua').val(response.ngay_mua);
                            $('#edit_gia_tri').val(response.gia_tri);
                            $('#edit_thoi_gian_bao_hanh').val(response.thoi_gian_bao_hanh);
                            $('#edit_chu_ky_bao_tri').val(response.chu_ky_bao_tri);
                            $('#edit_ngay_het_han_su_dung').val(response.ngay_het_han_su_dung);
                            $('#edit_mo_ta').val(response.mo_ta);
                            if (response.hinh_anh) {
                                $('#preview-hinh-anh').html('<img src="{{ asset('storage') }}/' + response.hinh_anh + '" class="img-fluid mt-2" style="max-height: 100px;">');
                            } else {
                                $('#preview-hinh-anh').html('');
                            }
                            $('#modal-sua-thiet-bi').modal('show');
                        },
                        error: function () {
                            toastr.error('Không thể lấy thông tin thiết bị. Vui lòng thử lại sau.');
                        }
                    });
                });

                $('#form-sua-thiet-bi').submit(function (e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    var id = $('#edit_id').val();
                    $.ajax({
                        url: '{{ route("thiet-bi.update", ":id") }}'.replace(':id', id),
                        type: 'POST',
                        data: formData + '&_method=PUT',
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $('#modal-sua-thiet-bi .btn-primary').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang cập nhật...');
                        },
                        success: function (response) {
                            if (response.success) {
                                $('#modal-sua-thiet-bi').modal('hide');
                                thietBiTable.ajax.reload();
                                toastr.success(response.message);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function (xhr) {
                            console.error('Lỗi khi cập nhật thiết bị:', xhr.status, xhr.responseText);
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                $.each(errors, function (key, value) {
                                    toastr.error(value[0]);
                                });
                            } else if (xhr.status === 401 || xhr.status === 403) {
                                toastr.error('Bạn cần đăng nhập để cập nhật thiết bị.');
                                setTimeout(function() {
                                    window.location.href = '/login';
                                }, 2000);
                            } else {
                                toastr.error('Không thể cập nhật thiết bị. Mã lỗi: ' + xhr.status);
                            }
                        },
                        complete: function () {
                            $('#modal-sua-thiet-bi .btn-primary').prop('disabled', false).html('Cập nhật');
                        }
                    });
                });

                // Xem chi tiết thiết bị
                $('#thiet-bi-table').on('click', '.btn-detail', function () {
                    var id = $(this).data('id');
                    $.ajax({
                        url: '{{ route("thiet-bi.show", ":id") }}'.replace(':id', id),
                        type: 'GET',
                        success: function (response) {
                            $('#detail_ten').text(response.ten);
                            $('#detail_ma_tai_san').text(response.ma_tai_san || 'N/A');
                            $('#detail_loai').text(formatLoaiThietBi(response.loai));
                            $('#detail_tinh_trang').text(response.tinh_trang === 'tot' ? 'Tốt' : (response.tinh_trang === 'hong' ? 'Hỏng' : 'Đang sửa'));
                            $('#detail_ban_nganh').text(response.ban_nganh ? response.ban_nganh.ten : 'N/A');
                            $('#detail_nguoi_quan_ly').text(response.nguoi_quan_ly ? response.nguoi_quan_ly.ho_ten : 'N/A');
                            $('#detail_vi_tri').text(response.vi_tri_hien_tai || 'N/A');
                            $('#detail_ngay_mua').text(response.ngay_mua ? formatDate(response.ngay_mua) : 'N/A');
                            $('#detail_gia_tri').text(response.gia_tri ? formatCurrency(response.gia_tri) : 'N/A');
                            $('#detail_nha_cung_cap').text(response.nha_cung_cap ? response.nha_cung_cap.ten_nha_cung_cap : 'N/A');
                            $('#detail_bao_hanh').text(response.thoi_gian_bao_hanh ? formatDate(response.thoi_gian_bao_hanh) : 'N/A');
                            $('#detail_chu_ky_bao_tri').text(response.chu_ky_bao_tri ? response.chu_ky_bao_tri + ' ngày' : 'N/A');
                            $('#detail_ngay_het_han').text(response.ngay_het_han_su_dung ? formatDate(response.ngay_het_han_su_dung) : 'N/A');
                            $('#detail_mo_ta').text(response.mo_ta || 'N/A');
                            if (response.hinh_anh) {
                                $('#detail_image').attr('src', '{{ asset('storage') }}/' + response.hinh_anh);
                            } else {
                                $('#detail_image').attr('src', '{{ asset('img/no-image.png') }}');
                            }
                            $('#bao_tri_thiet_bi_id').val(response.id);
                            $('#btn-edit-thiet-bi').data('id', response.id);
                            loadLichSuBaoTri(response.id, '#detail_bao_tri_list');
                            $('#modal-chi-tiet-thiet-bi').modal('show');
                        },
                        error: function () {
                            toastr.error('Không thể lấy thông tin thiết bị. Vui lòng thử lại sau.');
                        }
                    });
                });

                // Nút chỉnh sửa từ chi tiết
                $('#btn-edit-thiet-bi').click(function () {
                    var id = $(this).data('id');
                    $('#modal-chi-tiet-thiet-bi').modal('hide');
                    $('.btn-edit[data-id="' + id + '"]').click();
                });

                // Xử lý xóa thiết bị
                $('#thiet-bi-table').on('click', '.btn-delete', function () {
                    var id = $(this).data('id');
                    var name = $(this).data('name');
                    $('#delete_id').val(id);
                    $('#delete_name').text(name);
                    $('#modal-xoa-thiet-bi').modal('show');
                });

                $('#confirm-delete').click(function () {
                    var id = $('#delete_id').val();
                    $.ajax({
                        url: '{{ route("thiet-bi.destroy", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            if (response.success) {
                                $('#modal-xoa-thiet-bi').modal('hide');
                                thietBiTable.ajax.reload();
                                toastr.success(response.message);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function () {
                            toastr.error('Không thể xóa thiết bị. Vui lòng thử lại sau.');
                        }
                    });
                });

                // Thêm lịch sử bảo trì
                $('#btn-add-bao-tri').click(function () {
                    $('#bao-tri-title').text('Thêm Lịch Sử Bảo Trì');
                    $('#bao_tri_id').val('');
                    $('#form-bao-tri')[0].reset();
                    $('#modal-bao-tri').modal('show');
                });

                // Chỉnh sửa lịch sử bảo trì
                $('#detail_bao_tri_list').on('click', '.btn-edit-bao-tri', function () {
                    var id = $(this).data('id');
                    $.ajax({
                        url: '{{ route("lich-su-bao-tri.edit", ":id") }}'.replace(':id', id),
                        type: 'GET',
                        success: function (response) {
                            $('#bao-tri-title').text('Sửa Lịch Sử Bảo Trì');
                            $('#bao_tri_id').val(response.id);
                            $('#ngay_bao_tri').val(response.ngay_bao_tri);
                            $('#chi_phi').val(response.chi_phi);
                            $('#nguoi_thuc_hien').val(response.nguoi_thuc_hien);
                            $('#mo_ta_bao_tri').val(response.mo_ta);
                            $('#modal-bao-tri').modal('show');
                        }
                    });
                });

                // Xử lý form thêm/sửa lịch sử bảo trì
                $('#form-bao-tri').submit(function (e) {
                    e.preventDefault();
                    var formData = $(this).serialize();
                    var id = $('#bao_tri_id').val();
                    var url = id ? '{{ route("lich-su-bao-tri.update", ":id") }}'.replace(':id', id) : "{{ route('lich-su-bao-tri.store') }}";
                    var method = id ? 'PUT' : 'POST';
                    $.ajax({
                        url: url,
                        type: method,
                        data: formData + (id ? '&_method=PUT' : ''),
                        success: function (response) {
                            if (response.success) {
                                $('#modal-bao-tri').modal('hide');
                                toastr.success(response.message);
                                loadLichSuBaoTri($('#bao_tri_thiet_bi_id').val(), '#detail_bao_tri_list');
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function (xhr) {
                            console.error('Lỗi khi lưu lịch sử bảo trì:', xhr.status, xhr.responseText);
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                $.each(errors, function (key, value) {
                                    toastr.error(value[0]);
                                });
                            } else if (xhr.status === 401 || xhr.status === 403) {
                                toastr.error('Bạn cần đăng nhập để lưu lịch sử bảo trì.');
                                setTimeout(function() {
                                    window.location.href = '/login';
                                }, 2000);
                            } else {
                                toastr.error('Không thể lưu lịch sử bảo trì. Mã lỗi: ' + xhr.status);
                            }
                        }
                    });
                });

                // Xóa lịch sử bảo trì
                $('#detail_bao_tri_list').on('click', '.btn-delete-bao-tri', function () {
                    var id = $(this).data('id');
                    $('#delete_bao_tri_id').val(id);
                    $('#modal-xoa-bao-tri').modal('show');
                });

                $('#confirm-delete-bao-tri').click(function () {
                    var id = $('#delete_bao_tri_id').val();
                    $.ajax({
                        url: '{{ route("lich-su-bao-tri.destroy", ":id") }}'.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            if (response.success) {
                                $('#modal-xoa-bao-tri').modal('hide');
                                toastr.success(response.message);
                                loadLichSuBaoTri($('#bao_tri_thiet_bi_id').val(), '#detail_bao_tri_list');
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function () {
                            toastr.error('Không thể xóa lịch sử bảo trì. Vui lòng thử lại sau.');
                        }
                    });
                });

                // Reset form khi đóng modal
                $('#modal-them-thiet-bi').on('hidden.bs.modal', function () {
                    $('#form-thiet-bi')[0].reset();
                });

                $('#modal-sua-thiet-bi').on('hidden.bs.modal', function () {
                    $('#form-sua-thiet-bi')[0].reset();
                    $('#preview-hinh-anh').html('');
                });

                // Hiển thị tên file khi chọn hình ảnh
                $('.custom-file-input').on('change', function () {
                    var fileName = $(this).val().split('\\').pop();
                    $(this).next('.custom-file-label').addClass("selected").html(fileName);
                });
            }
        });
    </script>
@endsection