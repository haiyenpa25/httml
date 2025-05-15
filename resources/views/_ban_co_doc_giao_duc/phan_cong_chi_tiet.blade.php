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
            // Thiết lập CSRF token cho AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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
                        url: '{{ route("api._ban_co_doc_giao_duc.xoa_phan_cong", ["banType" => "ban-co-doc-giao-duc", "id" => "__ID__"]) }}'.replace('__ID__', id),
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

@extends('layouts.app')

@section('title', 'Phân Công Chi Tiết - Ban Cơ Đốc Giáo Dục')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Thông báo thành công hoặc lỗi -->
            <div id="alert-container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Thành công!</h5>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <!-- Các nút chức năng - Bố cục được tối ưu hóa -->
            <!-- Thanh điều hướng nhanh -->
            @include('_ban_co_doc_giao_duc.partials._navigation')

            <!-- Filter Form -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-filter"></i>
                        Lọc dữ liệu
                    </h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('_ban_co_doc_giao_duc.phan_cong_chi_tiet', ['banType' => 'ban-co-doc-giao-duc']) }}" method="GET" id="filter-form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tháng:</label>
                                    <select name="month" class="form-control" id="month-select">
                                        @foreach($months as $monthNum => $monthName)
                                            <option value="{{ $monthNum }}" {{ $month == $monthNum ? 'selected' : '' }}>
                                                {{ $monthName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Năm:</label>
                                    <select name="year" class="form-control" id="year-select">
                                        @foreach($years as $yearNum)
                                            <option value="{{ $yearNum }}" {{ $year == $yearNum ? 'selected' : '' }}>
                                                {{ $yearNum }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Buổi nhóm:</label>
                                    <select name="buoi_nhom_id" class="form-control" id="buoi-nhom-select">
                                        <option value="">-- Chọn buổi nhóm --</option>
                                        @foreach($buoiNhomOptions as $buoiNhom)
                                            <option value="{{ $buoiNhom->id }}" {{ $selectedBuoiNhom == $buoiNhom->id ? 'selected' : '' }}>
                                                {{ $buoiNhom->ngay_dien_ra->format('d/m/Y') }} - {{ $buoiNhom->chu_de }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Tìm kiếm
                                </button>
                                <a href="{{ route('_ban_co_doc_giao_duc.phan_cong_chi_tiet', ['banType' => 'ban-co-doc-giao-duc']) }}" class="btn btn-default">
                                    <i class="fas fa-sync"></i> Làm mới
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Chi tiết buổi nhóm -->
            @if($selectedBuoiNhom)
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle"></i>
                            Thông tin buổi nhóm
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 140px">Ngày:</th>
                                        <td>{{ $currentBuoiNhom->ngay_dien_ra->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Chủ đề:</th>
                                        <td>{{ $currentBuoiNhom->chu_de }}</td>
                                    </tr>
                                    <tr>
                                        <th>Điều hành:</th>
                                        <td>{{ $currentBuoiNhom->tinHuuHdct->ho_ten ?? 'Chưa phân công' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 140px">Diễn giả:</th>
                                        <td>{{ $currentBuoiNhom->dienGia->ho_ten ?? 'Chưa phân công' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Đọc Kinh Thánh:</th>
                                        <td>{{ $currentBuoiNhom->tinHuuDoKt->ho_ten ?? 'Chưa phân công' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Địa điểm:</th>
                                        <td>{{ $currentBuoiNhom->dia_diem ?? 'Chưa cập nhật' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Danh sách phân công nhiệm vụ -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-list-check"></i>
                        Danh sách phân công nhiệm vụ
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    @if($selectedBuoiNhom)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Nhiệm vụ</th>
                                        <th>Người thực hiện</th>
                                        <th>Ghi chú</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($nhiemVuPhanCong as $index => $phanCong)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $phanCong->nhiemVu->ten_nhiem_vu }}</td>
                                            <td>{{ $phanCong->tinHuu->ho_ten ?? 'Chưa phân công' }}</td>
                                            <td>{{ $phanCong->ghi_chu }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-warning btn-edit-phan-cong"
                                                        data-id="{{ $phanCong->id }}"
                                                        data-nhiem-vu-id="{{ $phanCong->nhiem_vu_id }}"
                                                        data-tin-huu-id="{{ $phanCong->tin_huu_id }}"
                                                        data-ghi-chu="{{ $phanCong->ghi_chu }}" data-toggle="modal"
                                                        data-target="#modal-phan-cong">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger btn-delete-phan-cong"
                                                        data-id="{{ $phanCong->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Chưa có phân công nhiệm vụ cho buổi nhóm này</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modal-phan-cong">
                                    <i class="fas fa-plus"></i> Thêm phân công
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i> Chưa chọn buổi nhóm!</h5>
                            <p>Vui lòng chọn một buổi nhóm để xem và phân công nhiệm vụ.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Danh sách thành viên trong ban -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i>
                        Danh sách thành viên Ban Cơ Đốc Giáo Dục
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Họ tên</th>
                                    <th>Chức vụ</th>
                                    <th>Điện thoại</th>
                                    <th>Đã phân công</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($thanhVienBan as $thanhVien)
                                    <tr>
                                        <td>{{ $thanhVien->tinHuu->ho_ten }}</td>
                                        <td>{{ $thanhVien->chuc_vu ?? 'Thành viên' }}</td>
                                        <td>{{ $thanhVien->tinHuu->so_dien_thoai }}</td>
                                        <td>
                                            @if($selectedBuoiNhom && isset($daPhanCong[$thanhVien->tinHuu->id]))
                                                <span class="badge badge-success">{{ $daPhanCong[$thanhVien->tinHuu->id] }}</span>
                                            @else
                                                <span class="badge badge-secondary">Chưa phân công</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Phân công nhiệm vụ -->
    <div class="modal fade" id="modal-phan-cong">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Phân công nhiệm vụ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form id="form-phan-cong" action="{{ route('api._ban_co_doc_giao_duc.phan_cong_nhiem_vu', ['banType' => 'ban-co-doc-giao-duc']) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="phan-cong-id">
                    <input type="hidden" name="buoi_nhom_id" value="{{ $selectedBuoiNhom }}">

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nhiệm vụ <span class="text-danger">*</span></label>
                            <select class="form-control select2bs4" name="nhiem_vu_id" id="nhiem-vu-id" required>
                                <option value="">-- Chọn nhiệm vụ --</option>
                                @foreach($danhSachNhiemVu as $nhiemVu)
                                    <option value="{{ $nhiemVu->id }}">{{ $nhiemVu->ten_nhiem_vu }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Người thực hiện <span class="text-danger">*</span></label>
                            <select class="form-control select2bs4" name="tin_huu_id" id="tin-huu-id" required>
                                <option value="">-- Chọn người thực hiện --</option>
                                @foreach($thanhVienBan as $thanhVien)
                                    <option value="{{ $thanhVien->tinHuu->id }}">{{ $thanhVien->tinHuu->ho_ten }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Ghi chú</label>
                            <textarea class="form-control" name="ghi_chu" id="ghi-chu" rows="3"
                                placeholder="Nhập ghi chú (nếu có)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu phân công</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@include('_ban_co_doc_giao_duc.scripts._scripts_phan_cong_chi_tiet')