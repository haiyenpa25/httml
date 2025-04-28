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
        }

        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #343a40;
            padding: 12px;
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
    @push('scripts')
        <script>
            $(function () {
                // Xử lý định dạng tiền tệ
                $('.money-format').on('input', function () {
                    let value = $(this).val().replace(/\D/g, '');
                    $(this).val(new Intl.NumberFormat('vi-VN').format(value));
                });

                // Tự động gửi form khi thay đổi buoi_nhom_type
                $('#buoi_nhom_type').on('change', function () {
                    console.log('Đã thay đổi buoi_nhom_type:', $(this).val());
                    $('#filter-form').submit();
                });

                // Xử lý cập nhật số lượng tham dự riêng lẻ
                $('.update-count').on('click', function () {
                    const buoiNhomId = $(this).data('id');
                    const type = $(this).data('type');
                    const row = $(this).closest('tr');

                    let data = {
                        _token: '{{ csrf_token() }}',
                        id: buoiNhomId, // Thay buoi_nhom_id thành id để khớp với validation
                        so_luong_trung_lao: row.find(`input[name="buoi_nhom[${buoiNhomId}][so_luong_trung_lao]"]`).val()
                    };

                    if (type === 'bn') {
                        let dangHien = row.find(`input[name="buoi_nhom[${buoiNhomId}][dang_hien]"]`).val();
                        dangHien = dangHien.replace(/\./g, '');
                        data.dang_hien = dangHien;
                    }

                    $.ajax({
                        url: '{{ route("_ban_trung_lao.update_thamdu_trung_lao") }}',
                        type: 'POST',
                        data: data,
                        dataType: 'json',
                        beforeSend: function () {
                            console.log('Đang gửi AJAX cập nhật số lượng:', data);
                        },
                        success: function (response) {
                            console.log('Phản hồi:', response);
                            if (response.success) {
                                toastr.success('Cập nhật thành công!');
                            } else {
                                toastr.error(response.message || 'Có lỗi xảy ra!');
                            }
                        },
                        error: function (xhr) {
                            window.handleAjaxError(xhr);
                        }
                    });
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
                            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                        },
                        success: function (response) {
                            if (response.success) {
                                toastr.success('Đã lưu số lượng tham dự thành công!');
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                toastr.error(response.message || 'Có lỗi xảy ra!');
                            }
                        },
                        error: function (xhr) {
                            window.handleAjaxError(xhr);
                        },
                        complete: function () {
                            $('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save"></i> Lưu tất cả thay đổi');
                        }
                    });
                });

                // Thêm/xóa điểm mạnh
                $('#add-diem-manh').on('click', function () {
                    let count = $('.diem-manh-item').length;
                    let html = `
                                        <div class="form-group diem-manh-item">
                                            <div class="input-group">
                                                <textarea class="form-control" name="diem_manh[]" rows="2" 
                                                          placeholder="Nhập điểm mạnh..."></textarea>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-danger remove-diem-manh">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="diem_manh_id[]" value="0">
                                        </div>
                                    `;
                    $('#diem-manh-container').append(html);
                });

                $(document).on('click', '.remove-diem-manh', function () {
                    const item = $(this).closest('.diem-manh-item');
                    const id = item.find('input[name$="[id]"]').val();

                    if (id != '0' && !confirm('Bạn có chắc chắn muốn xóa điểm mạnh này?')) {
                        return;
                    }

                    if (id != '0') {
                        $.ajax({
                            url: '{{ route("api.ban_trung_lao.xoa_danh_gia", ["id" => "__ID__"]) }}'.replace('__ID__', id),
                            method: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function (response) {
                                if (response.success) {
                                    toastr.success(response.message);
                                    item.remove();
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function (xhr) {
                                window.handleAjaxError(xhr);
                            }
                        });
                    } else if ($('.diem-manh-item').length > 1) {
                        item.remove();
                    } else {
                        item.find('textarea').val('');
                    }
                });

                // Thêm/xóa điểm yếu
                $('#add-diem-yeu').on('click', function () {
                    let count = $('.diem-yeu-item').length;
                    let html = `
                                        <div class="form-group diem-yeu-item">
                                            <div class="input-group">
                                                <textarea class="form-control" name="diem_yeu[]" rows="2" 
                                                          placeholder="Nhập điểm cần cải thiện..."></textarea>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-danger remove-diem-yeu">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <input type="hidden" name="diem_yeu_id[]" value="0">
                                        </div>
                                    `;
                    $('#diem-yeu-container').append(html);
                });

                $(document).on('click', '.remove-diem-yeu', function () {
                    const item = $(this).closest('.diem-yeu-item');
                    const id = item.find('input[name$="[id]"]').val();

                    if (id != '0' && !confirm('Bạn có chắc chắn muốn xóa điểm yếu này?')) {
                        return;
                    }

                    if (id != '0') {
                        $.ajax({
                            url: '{{ route("api.ban_trung_lao.xoa_danh_gia", ["id" => "__ID__"]) }}'.replace('__ID__', id),
                            method: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function (response) {
                                if (response.success) {
                                    toastr.success(response.message);
                                    item.remove();
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function (xhr) {
                                window.handleAjaxError(xhr);
                            }
                        });
                    } else if ($('.diem-yeu-item').length > 1) {
                        item.remove();
                    } else {
                        item.find('textarea').val('');
                    }
                });

                // Xử lý form đánh giá
                $('#danhgia-form').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        beforeSend: function () {
                            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                        },
                        success: function (response) {
                            if (response.success) {
                                toastr.success('Đã lưu đánh giá thành công!');
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                toastr.error(response.message || 'Có lỗi xảy ra!');
                            }
                        },
                        error: function (xhr) {
                            window.handleAjaxError(xhr);
                        },
                        complete: function () {
                            $('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save"></i> Lưu đánh giá');
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
                                                    @if ($tinHuuTrungLao->isEmpty())
                                                        <option value="">Không có tín hữu nào trong Ban Trung Lão</option>
                                                    @else
                                                        @foreach($tinHuuTrungLao as $tinHuu)
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
                    if ($('.kehoach-row').length > 1) {
                        $(this).closest('tr').remove();
                        reindexKehoach();
                    } else {
                        $(this).closest('tr').find('input[type="text"], textarea').val('');
                        $(this).closest('tr').find('select').val('');
                    }
                });

                function reindexKehoach() {
                    $('.kehoach-row').each(function (index) {
                        $(this).find('td:first').text(index + 1);
                    });
                }

                // Xử lý form kế hoạch
                $('#kehoach-form').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        beforeSend: function () {
                            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                        },
                        success: function (response) {
                            if (response.success) {
                                toastr.success('Đã lưu kế hoạch thành công!');
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                toastr.error(response.message || 'Có lỗi xảy ra!');
                            }
                        },
                        error: function (xhr) {
                            window.handleAjaxError(xhr);
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
                                                        @if ($tinHuuTrungLao->isEmpty())
                                                            <option value="">Không có tín hữu nào trong Ban Trung Lão</option>
                                                        @else
                                                            @foreach($tinHuuTrungLao as $tinHuu)
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
                        $.ajax({
                            url: '{{ route("api.ban_trung_lao.xoa_kien_nghi", ["id" => "__ID__"]) }}'.replace('__ID__', id),
                            method: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function (response) {
                                if (response.success) {
                                    toastr.success(response.message);
                                    card.remove();
                                    reindexKiennghi();
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function (xhr) {
                                window.handleAjaxError(xhr);
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
                    });
                }

                // Xử lý form kiến nghị
                $('#kiennghi-form').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: $(this).attr('action'),
                        method: 'POST',
                        data: $(this).serialize(),
                        dataType: 'json',
                        beforeSend: function () {
                            $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');
                        },
                        success: function (response) {
                            if (response.success) {
                                toastr.success('Đã lưu kiến nghị thành công!');
                                setTimeout(() => location.reload(), 1000);
                            } else {
                                toastr.error(response.message || 'Có lỗi xảy ra!');
                            }
                        },
                        error: function (xhr) {
                            window.handleAjaxError(xhr);
                        },
                        complete: function () {
                            $('button[type="submit"]').prop('disabled', false).html('<i class="fas fa-save"></i> Lưu kiến nghị');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection