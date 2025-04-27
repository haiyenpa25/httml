@section('page-scripts')
    <!-- resources/views/scripts/thiet-bi.blade.php -->

    <script>
        /**
         * File JavaScript chung cho module quản lý thiết bị
         * Sử dụng cho tất cả các trang liên quan đến quản lý thiết bị
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
         * Hàm tải danh sách người quản lý (tín hữu)
         * @param {string} selectSelector - CSS selector cho thẻ select cần populate
         */
        function loadTinHuuList(selectSelector) {
            $.ajax({
                url: getBaseUrl() + "/tin-huu/get-tin-huus",
                type: "GET",
                success: function (data) {
                    var options = '<option value="">-- Chọn Người Quản Lý --</option>';
                    $.each(data, function (index, tinHuu) {
                        options += '<option value="' + tinHuu.id + '">' + tinHuu.ho_ten + '</option>';
                    });
                    $(selectSelector).html(options);
                },
                error: function (xhr) {
                    console.error("Không thể tải danh sách tín hữu:", xhr.responseText);
                }
            });
        }

        /**
         * Hàm tải danh sách nhà cung cấp
         * @param {string} selectSelector - CSS selector cho thẻ select cần populate
         */
        function loadNhaCungCapList(selectSelector) {
            $.ajax({
                url: getBaseUrl() + "/nha-cung-cap/get-nha-cung-caps",
                type: "GET",
                success: function (data) {
                    var options = '<option value="">-- Chọn Nhà Cung Cấp --</option>';
                    $.each(data, function (index, nhaCungCap) {
                        options += '<option value="' + nhaCungCap.id + '">' + nhaCungCap.ten_nha_cung_cap + '</option>';
                    });
                    $(selectSelector).html(options);
                },
                error: function (xhr) {
                    console.error("Không thể tải danh sách nhà cung cấp:", xhr.responseText);
                }
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
         * Hàm thêm lịch sử bảo trì mới
         * @param {Object} formData - Dữ liệu form cần gửi
         * @param {Function} onSuccess - Callback khi thành công
         * @param {Function} onError - Callback khi có lỗi
         */
        function addLichSuBaoTri(formData, onSuccess, onError) {
            $.ajax({
                url: getBaseUrl() + "/lich-su-bao-tri",
                type: "POST",
                data: formData,
                success: function (response) {
                    if (response.success) {
                        if (onSuccess) onSuccess(response);
                    } else {
                        if (onError) onError(response.message);
                    }
                },
                error: function (xhr) {
                    var errorMsg = 'Có lỗi xảy ra khi thêm lịch sử bảo trì';
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors)[0][0];
                    }
                    if (onError) onError(errorMsg);
                }
            });
        }

        /**
         * Hàm cập nhật lịch sử bảo trì
         * @param {number} id - ID lịch sử bảo trì cần cập nhật
         * @param {Object} formData - Dữ liệu form cần gửi
         * @param {Function} onSuccess - Callback khi thành công
         * @param {Function} onError - Callback khi có lỗi
         */
        function updateLichSuBaoTri(id, formData, onSuccess, onError) {
            $.ajax({
                url: getBaseUrl() + "/lich-su-bao-tri/" + id,
                type: "PUT",
                data: formData,
                success: function (response) {
                    if (response.success) {
                        if (onSuccess) onSuccess(response);
                    } else {
                        if (onError) onError(response.message);
                    }
                },
                error: function (xhr) {
                    var errorMsg = 'Có lỗi xảy ra khi cập nhật lịch sử bảo trì';
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors)[0][0];
                    }
                    if (onError) onError(errorMsg);
                }
            });
        }

        /**
         * Hàm xóa lịch sử bảo trì
         * @param {number} id - ID lịch sử bảo trì cần xóa
         * @param {Function} onSuccess - Callback khi thành công
         * @param {Function} onError - Callback khi có lỗi
         */
        function deleteLichSuBaoTri(id, onSuccess, onError) {
            $.ajax({
                url: getBaseUrl() + "/lich-su-bao-tri/" + id,
                type: "DELETE",
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        if (onSuccess) onSuccess(response);
                    } else {
                        if (onError) onError(response.message);
                    }
                },
                error: function (xhr) {
                    if (onError) onError('Không thể xóa lịch sử bảo trì. Vui lòng thử lại sau.');
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
    </script>
@endsection