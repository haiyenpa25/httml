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

    <script>
        $(function () {
            // Khởi tạo Select2
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            // Xử lý lọc tháng/năm
            $('form').on('submit', function (e) {
                e.preventDefault();
                const month = $('#month-select').val();
                const year = $('#year-select').val();

                // Reload trang với tháng và năm đã chọn
                window.location.href = `{{ route('_ban_nganh.trung_lao.phan_cong') }}?month=${month}&year=${year}`;
            });

            // Xử lý nút chỉnh sửa
            $('.edit-btn').on('click', function () {
                const id = $(this).data('id');
                const row = $(this).closest('tr');

                // Điền dữ liệu vào form
                $('#buoi-nhom-id').val(id);

                // Chuyển đổi định dạng ngày từ dd/mm/yyyy sang yyyy-mm-dd
                const dateParts = row.find('td:nth-child(2)').text().split('/');
                const formattedDate = `${dateParts[2]}-${dateParts[1].padStart(2, '0')}-${dateParts[0].padStart(2, '0')}`;
                $('input[name="ngay_dien_ra"]').val(formattedDate);

                $('input[name="chu_de"]').val(row.find('td:nth-child(3)').text());

                // Diễn Giả
                const dienGiaTen = row.find('td:nth-child(4)').text();
                $('select[name="dien_gia_id"]').val(
                    $('select[name="dien_gia_id"] option')
                        .filter(function () {
                            return $(this).text().includes(dienGiaTen);
                        }).val()
                );

                // Người Hướng Dẫn
                const hdctTen = row.find('td:nth-child(5)').text();
                $('select[name="id_tin_huu_hdct"]').val(
                    $('select[name="id_tin_huu_hdct"] option')
                        .filter(function () {
                            return $(this).text() === hdctTen;
                        }).val()
                );

                // Người Đọc Kinh Thánh
                const ktTen = row.find('td:nth-child(6)').text();
                $('select[name="id_tin_huu_do_kt"]').val(
                    $('select[name="id_tin_huu_do_kt"] option')
                        .filter(function () {
                            return $(this).text() === ktTen;
                        }).val()
                );

                // Ghi Chú
                $('textarea[name="ghi_chu"]').val(row.find('td:nth-child(7)').text());

                // Cập nhật Select2
                $('.select2').trigger('change');
            });

            // Xử lý submit form
            $('#buoi-nhom-form').on('submit', function (e) {
                e.preventDefault();

                const id = $('#buoi-nhom-id').val();
                const form = $(this);
                const url = form.attr('action').replace(':id', id);

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: form.serialize() + '&_method=PUT', // Thêm _method=PUT để giả lập PUT request
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            location.reload(); // Tải lại trang để cập nhật dữ liệu
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra');
                        }
                    },
                    error: function (xhr) {
                        let errorMsg = 'Lỗi:\n';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            Object.values(xhr.responseJSON.errors).forEach(error => {
                                errorMsg += error.join('\n') + '\n';
                            });
                        } else {
                            errorMsg = xhr.responseJSON?.message || 'Đã xảy ra lỗi khi cập nhật';
                        }
                        toastr.error(errorMsg);
                    }
                });
            });

            // Xử lý nút làm mới form
            $('#reset-form').on('click', function () {
                $('#buoi-nhom-form')[0].reset();
                $('#buoi-nhom-id').val('');
                $('.select2').val(null).trigger('change');
            });

            // Xử lý nút xóa
            $('.delete-btn').on('click', function () {
                const id = $(this).data('id');
                const row = $(this).closest('tr');

                if (confirm('Bạn có chắc chắn muốn xóa buổi nhóm này?')) {
                    $.ajax({
                        url: `{{ route('api.ban_nganh.trung_lao.delete_buoi_nhom', ['buoiNhom' => ':id']) }}`.replace(':id', id),
                        method: 'DELETE',
                        success: function (response) {
                            if (response.success) {
                                row.remove();
                                toastr.success(response.message);
                            } else {
                                toastr.error(response.message || 'Có lỗi xảy ra');
                            }
                        },
                        error: function (xhr) {
                            const errorMsg = xhr.responseJSON?.message || 'Đã xảy ra lỗi khi xóa buổi nhóm';
                            toastr.error(errorMsg);
                        }
                    });
                }
            });
        });
    </script>

@endsection