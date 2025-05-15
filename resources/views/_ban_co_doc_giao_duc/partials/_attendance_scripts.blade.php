<script>
    $(function () {
        // Khởi tạo Select2
        $('.select2bs4').select2({
            theme: 'bootstrap4',
            placeholder: '-- Chọn một mục --',
            allowClear: true,
            width: '100%'
        });

        // Cập nhật thống kê điểm danh khi thay đổi checkbox
        function updateStats() {
            const totalMembers = $('.attendance-checkbox').length;
            const coMat = $('.attendance-checkbox:checked').length;
            const vang = totalMembers - coMat;
            const tiLeThamDu = totalMembers > 0 ? Math.round((coMat / totalMembers) * 100) : 0;

            $('#stats-co-mat').text(coMat);
            $('#stats-vang').text(vang);
            $('#stats-ti-le').text(tiLeThamDu + '%');

            // Thêm hiệu ứng đổi màu khi thay đổi
            $('#stats-co-mat, #stats-vang, #stats-ti-le').addClass('text-highlight');
            setTimeout(function () {
                $('#stats-co-mat, #stats-vang, #stats-ti-le').removeClass('text-highlight');
            }, 500);
        }

        // Gắn sự kiện change cho checkbox
        $('.attendance-checkbox').on('change', updateStats);

        // Gọi updateStats khi tải trang
        updateStats();

        // Xử lý form điểm danh
        $('#form-diem-danh').on('submit', function (e) {
            e.preventDefault();
            const formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                dataType: 'json',
                beforeSend: function () {
                    $('#form-diem-danh button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Đang lưu...');
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message, 'Thành công!', {
                            progressBar: true,
                            timeOut: 3000
                        });
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    } else {
                        toastr.error(response.message || 'Có lỗi khi lưu điểm danh!', 'Lỗi!');
                    }
                },
                error: function (xhr) {
                    let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                    if (xhr.responseJSON?.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }
                    toastr.error(errorMessage, 'Lỗi!', {
                        closeButton: true,
                        timeOut: 0,
                        extendedTimeOut: 0
                    });
                },
                complete: function () {
                    $('#form-diem-danh button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save mr-2"></i> Lưu điểm danh');
                }
            });
        });

        // Xử lý form thêm buổi nhóm
        $('#form-them-buoi-nhom').on('submit', function (e) {
            e.preventDefault();
            const formData = $(this).serialize();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                dataType: 'json',
                beforeSend: function () {
                    $('#form-them-buoi-nhom button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Đang lưu...');
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message, 'Thành công!', {
                            progressBar: true,
                            timeOut: 3000
                        });
                        $('#modal-them-buoi-nhom').modal('hide');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    } else {
                        toastr.error(response.message || 'Có lỗi khi thêm buổi nhóm!', 'Lỗi!');
                    }
                },
                error: function (xhr) {
                    let errorMessage = xhr.responseJSON?.message || 'Lỗi hệ thống, vui lòng thử lại!';
                    if (xhr.responseJSON?.errors) {
                        errorMessage = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }
                    toastr.error(errorMessage, 'Lỗi!', {
                        closeButton: true,
                        timeOut: 0,
                        extendedTimeOut: 0
                    });
                },
                complete: function () {
                    $('#form-them-buoi-nhom button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Lưu buổi nhóm');
                }
            });
        });

        // Nút mở modal thêm buổi nhóm
        $('#btn-them-buoi-nhom').on('click', function () {
            // Đặt ngày mặc định là hôm nay
            const today = new Date().toISOString().split('T')[0];
            $('#ngay_dien_ra').val(today);

            $('#modal-them-buoi-nhom').modal('show');
        });

        // Cấu hình toastr
        toastr.options = {
            closeButton: true,
            newestOnTop: true,
            progressBar: true,
            positionClass: "toast-top-right",
            preventDuplicates: false,
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            timeOut: 5000,
            extendedTimeOut: 1000
        };

        // Animate số liệu thống kê
        $('.stat-value').each(function () {
            $(this).prop('Counter', 0).animate({
                Counter: $(this).text().replace('%', '')
            }, {
                duration: 1000,
                easing: 'swing',
                step: function (now) {
                    if ($(this).closest('.card').find('.stat-label').text() === 'Tỷ lệ tham dự') {
                        $(this).text(Math.ceil(now) + '%');
                    } else {
                        $(this).text(Math.ceil(now));
                    }
                }
            });
        });
    });
</script>