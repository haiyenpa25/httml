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
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            // Xử lý chọn buổi nhóm
            $('#buoi-nhom-select').on('change', function () {
                $('#filter-form').submit();
            });

            // Xử lý click nút chỉnh sửa phân công
            $(document).on('click', '.btn-edit-phan-cong', function () {
                const id = $(this).data('id');
                const nhiemVuId = $(this).data('nhiem-vu-id');
                const tinHuuId = $(this).data('tin-huu-id');
                const ghiChu = $(this).data('ghi-chu');

                // Cập nhật form
                $('#phan-cong-id').val(id);
                $('#nhiem-vu-id').val(nhiemVuId).trigger('change');
                $('#tin-huu-id').val(tinHuuId).trigger('change');
                $('#ghi-chu').val(ghiChu);

                // Cập nhật tiêu đề modal
                $('.modal-title').text('Cập nhật phân công nhiệm vụ');
            });

            // Xử lý mở modal thêm mới
            $('#modal-phan-cong').on('show.bs.modal', function (e) {
                // Nếu không phải từ nút edit thì là thêm mới
                if (!$(e.relatedTarget).hasClass('btn-edit-phan-cong')) {
                    // Reset form
                    $('#phan-cong-id').val('');
                    $('#form-phan-cong').trigger('reset');
                    $('#nhiem-vu-id').val('').trigger('change');
                    $('#tin-huu-id').val('').trigger('change');

                    // Cập nhật tiêu đề modal
                    $('.modal-title').text('Thêm phân công nhiệm vụ');
                }
            });

            // Xử lý submit form phân công
            $('#form-phan-cong').on('submit', function (e) {
                e.preventDefault();

                const formData = $(this).serialize();
                const isEdit = $('#phan-cong-id').val() !== '';

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message || 'Phân công nhiệm vụ thành công!');
                            location.reload();
                        } else {
                            toastr.error(response.message || 'Có lỗi xảy ra');
                        }
                    },
                    error: function (xhr) {
                        let errorMsg = 'Đã xảy ra lỗi!';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMsg = '';
                            $.each(xhr.responseJSON.errors, function (key, value) {
                                errorMsg += value[0] + '\n';
                            });
                        } else {
                            errorMsg = xhr.responseJSON?.message || 'Lỗi khi thực hiện phân công';
                        }
                        toastr.error(errorMsg);
                    }
                });
            });

            // Xử lý xóa phân công
            $(document).on('click', '.btn-delete-phan-cong', function () {
                const id = $(this).data('id');

                if (confirm('Bạn có chắc chắn muốn xóa phân công này?')) {
                    $.ajax({
                        url: '{{ route("api.ban_muc_vu.xoa_phan_cong", ["id" => "__ID__"]) }}'.replace('__ID__', id),
                        method: 'DELETE',
                        success: function (response) {
                            if (response.success) {
                                toastr.success(response.message || 'Xóa phân công thành công!');
                                location.reload();
                            } else {
                                toastr.error(response.message || 'Có lỗi xảy ra');
                            }
                        },
                        error: function (xhr) {
                            const errorMsg = xhr.responseJSON?.message || 'Đã xảy ra lỗi khi xóa phân công!';
                            toastr.error(errorMsg);
                        }
                    });
                }
            });
        });
    </script>
@endsection