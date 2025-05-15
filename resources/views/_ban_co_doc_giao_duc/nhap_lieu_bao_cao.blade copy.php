@extends('layouts.app')

@section('title', 'Nhập Liệu Báo Cáo - ' . ($banNganh->ten ?? $config['name']))

@section('content')
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background: linear-gradient(to right, #007bff, #0056b3);
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .card-title {
            font-weight: 600;
            margin-bottom: 0;
        }
        .nav-tabs .nav-link {
            border-radius: 8px 8px 0 0;
            margin-right: 5px;
            transition: background-color 0.3s ease;
        }
        .nav-tabs .nav-link.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        .table {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            vertical-align: middle;
        }
        .table td {
            vertical-align: middle;
        }
        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }
        .form-control, .select2-container--bootstrap4 .select2-selection {
            border-radius: 5px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
        }
        .btn-primary, .btn-success, .btn-danger, .btn-info {
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .modal-content {
            border-radius: 10px;
        }
        .modal-header {
            background: linear-gradient(to right, #007bff, #0056b3);
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .kiennghi-card {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        @media (max-width: 768px) {
            .card-header {
                font-size: 1rem;
            }
            .table th, .table td {
                font-size: 0.9rem;
            }
            .nav-tabs .nav-link {
                font-size: 0.9rem;
                padding: 8px 12px;
            }
        }
    </style>

    <section class="content-header">
        <div class="container-fluid">
            <div id="alert-container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Thành công!</h5>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-ban"></i> Lỗi!</h5>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Nhập Liệu Báo Cáo Ban Cơ Đốc Giáo Dục</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('_ban_co_doc_giao_duc.index', ['banType' => 'ban-co-doc-giao-duc']) }}">Ban Cơ Đốc Giáo Dục</a></li>
                        <li class="breadcrumb-item active">Nhập Liệu Báo Cáo</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <!-- Thanh điều hướng nhanh -->
            @include('_ban_co_doc_giao_duc.partials._navigation', ['banType' => 'ban-co-doc-giao-duc'])

            <!-- Form lọc và chọn buổi nhóm -->
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <h5 class="card-title">Thông Tin Báo Cáo</h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="filter-form" method="GET" action="{{ route('_ban_co_doc_giao_duc.nhap_lieu_bao_cao', ['banType' => 'ban-co-doc-giao-duc']) }}">
                        <div class="row mb-3">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="month">Tháng</label>
                                    <select id="month" name="month" class="form-control select2bs4">
                                        @for ($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                                Tháng {{ $m }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="year">Năm</label>
                                    <select id="year" name="year" class="form-control select2bs4">
                                        @for ($y = date('Y') + 1; $y >= date('Y') - 5; $y--)
                                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="ban_nganh">Ban ngành</label>
                                    <select id="ban_nganh" name="ban_nganh" class="form-control select2bs4">
                                        <option value="trung_lao" {{ $selectedBanNganh == 'trung_lao' ? 'selected' : '' }}>Ban Trung Lão</option>
                                        <option value="thanh_trang" {{ $selectedBanNganh == 'thanh_trang' ? 'selected' : '' }}>Ban Thanh Tráng</option>
                                        <option value="thanh_nien" {{ $selectedBanNganh == 'thanh_nien' ? 'selected' : '' }}>Ban Thanh Niên</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-filter"></i> Lọc dữ liệu
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Nav Tabs -->
            <div class="card">
                <div class="card-header p-0">
                    <ul class="nav nav-tabs" id="baocao-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="buoinhom-tab" data-toggle="pill" href="#buoinhom" role="tab">
                                <i class="fas fa-users"></i> Số Lượng Tham Dự & Dâng Hiến
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="danhgia-tab" data-toggle="pill" href="#danhgia" role="tab">
                                <i class="fas fa-chart-line"></i> Đánh Giá & Nhận Xét
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="kehoach-tab" data-toggle="pill" href="#kehoach" role="tab">
                                <i class="fas fa-calendar-alt"></i> Kế Hoạch Tháng Tới
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="kiennghi-tab" data-toggle="pill" href="#kiennghi" role="tab">
                                <i class="fas fa-comment-alt"></i> Ý Kiến & Kiến Nghị
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="baocao-tabContent">
                        <!-- Tab: Số lượng tham dự & Dâng hiến -->
                        <div class="tab-pane fade show active" id="buoinhom" role="tabpanel">
                            <form id="thamdu-form" method="POST" action="{{ route('api._ban_co_doc_giao_duc.save_tham_du', ['banType' => 'ban-co-doc-giao-duc']) }}">
                                @csrf
                                <input type="hidden" name="month" value="{{ $month }}">
                                <input type="hidden" name="year" value="{{ $year }}">
                                <input type="hidden" name="ban_nganh_id" value="{{ $config['id'] }}">
                                <input type="hidden" name="ban_nganh" value="{{ $selectedBanNganh }}">

                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-users"></i> Nhập Liệu Tham Dự & Dâng Hiến - 
                                            {{ $selectedBanNganh == 'trung_lao' ? 'Ban Trung Lão' : ($selectedBanNganh == 'thanh_trang' ? 'Ban Thanh Tráng' : 'Ban Thanh Niên') }}
                                        </h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @if($buoiNhomBN->isNotEmpty())
                                            <div class="table-responsive">
                                                <table id="buoi-nhom-btl-table" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 50px">STT</th>
                                                            <th>Ngày</th>
                                                            <th>Đề tài</th>
                                                            <th>Diễn giả</th>
                                                            <th style="width: 120px">Số lượng</th>
                                                            <th style="width: 150px">Dâng hiến (VNĐ)</th>
                                                            <th style="width: 120px">Thao tác</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($buoiNhomBN as $index => $buoiNhom)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y') }}</td>
                                                                <td>{{ $buoiNhom->chu_de ?? 'N/A' }}</td>
                                                                <td>{{ $buoiNhom->dienGia->ho_ten ?? 'N/A' }}</td>
                                                                <td>
                                                                    <input type="number" class="form-control"
                                                                           name="buoi_nhom[{{ $buoiNhom->id }}][so_luong]"
                                                                           min="0" value="{{ $selectedBanNganh == 'trung_lao' ? ($buoiNhom->so_luong_trung_lao ?? 0) : ($selectedBanNganh == 'thanh_trang' ? ($buoiNhom->so_luong_thanh_trang ?? 0) : ($buoiNhom->so_luong_thanh_nien ?? 0)) }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control money-format"
                                                                           name="buoi_nhom[{{ $buoiNhom->id }}][dang_hien]"
                                                                           value="{{ number_format($buoiNhom->giaoDichTaiChinh->so_tien ?? 0, 0, ',', '.') }}">
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" name="buoi_nhom[{{ $buoiNhom->id }}][id]" value="{{ $buoiNhom->id }}">
                                                                    <button type="button" class="btn btn-success btn-sm update-count"
                                                                            data-id="{{ $buoiNhom->id }}"
                                                                            data-type="bn">
                                                                        <i class="fas fa-save"></i> Lưu
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="7" class="text-center">Không có dữ liệu buổi nhóm trong tháng này</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                <h5><i class="icon fas fa-info"></i> Chưa có buổi nhóm!</h5>
                                                <p>Vui lòng tạo buổi nhóm để nhập liệu tham dự và dâng hiến.</p>
                                            </div>
                                        @endif
                                    </div>
                                    @if($buoiNhomBN->isNotEmpty())
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Lưu tất cả thay đổi
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <!-- Tab: Đánh giá & Nhận xét -->
                        <div class="tab-pane fade" id="danhgia" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="card card-outline card-success">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-thumbs-up"></i> Điểm Mạnh</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-add-diem-manh">
                                                    <i class="fas fa-plus"></i> Thêm điểm mạnh
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table id="diem-manh-table" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px">STT</th>
                                                        <th>Nội dung</th>
                                                        <th>Người đánh giá</th>
                                                        <th style="width: 120px">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Dữ liệu sẽ được tải bằng DataTable qua API danh-gia-list -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card card-outline card-danger">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fas fa-thumbs-down"></i> Điểm Cần Cải Thiện</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-add-diem-yeu">
                                                    <i class="fas fa-plus"></i> Thêm điểm yếu
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table id="diem-yeu-table" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px">STT</th>
                                                        <th>Nội dung</th>
                                                        <th>Người đánh giá</th>
                                                        <th style="width: 120px">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Dữ liệu sẽ được tải bằng DataTable qua API danh-gia-list -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Thêm điểm mạnh -->
                            <div class="modal fade" id="modal-add-diem-manh">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Thêm Điểm Mạnh</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form id="add-diem-manh-form" action="{{ route('api._ban_co_doc_giao_duc.save_danh_gia', ['banType' => 'ban-co-doc-giao-duc']) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" name="month" value="{{ $month }}">
                                                <input type="hidden" name="year" value="{{ $year }}">
                                                <input type="hidden" name="ban_nganh_id" value="{{ $config['id'] }}">
                                                <input type="hidden" name="loai" value="diem_manh">
                                                <div class="form-group">
                                                    <label>Nội dung</label>
                                                    <textarea class="form-control" name="noi_dung" rows="4" required placeholder="Nhập điểm mạnh"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                <button type="submit" class="btn btn-primary">Lưu</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Thêm điểm yếu -->
                            <div class="modal fade" id="modal-add-diem-yeu">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Thêm Điểm Cần Cải Thiện</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <form id="add-diem-yeu-form" action="{{ route('api._ban_co_doc_giao_duc.save_danh_gia', ['banType' => 'ban-co-doc-giao-duc']) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="hidden" name="month" value="{{ $month }}">
                                                <input type="hidden" name="year" value="{{ $year }}">
                                                <input type="hidden" name="ban_nganh_id" value="{{ $config['id'] }}">
                                                <input type="hidden" name="loai" value="diem_yeu">
                                                <div class="form-group">
                                                    <label>Nội dung</label>
                                                    <textarea class="form-control" name="noi_dung" rows="4" required placeholder="Nhập điểm cần cải thiện"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                <button type="submit" class="btn btn-primary">Lưu</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab: Kế hoạch tháng tới -->
                        <div class="tab-pane fade" id="kehoach" role="tabpanel">
                            <form id="kehoach-form" method="POST" action="{{ route('api._ban_co_doc_giao_duc.save_ke_hoach', ['banType' => 'ban-co-doc-giao-duc']) }}">
                                @csrf
                                <input type="hidden" name="month" value="{{ $nextMonth }}">
                                <input type="hidden" name="year" value="{{ $nextYear }}">
                                <input type="hidden" name="ban_nganh_id" value="{{ $config['id'] }}">

                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-calendar-alt"></i> Kế Hoạch Tháng {{ $nextMonth }}/{{ $nextYear }}
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 50px">STT</th>
                                                        <th>Hoạt động</th>
                                                        <th style="width: 150px">Thời gian</th>
                                                        <th style="width: 200px">Người phụ trách</th>
                                                        <th>Ghi chú</th>
                                                        <th style="width: 120px">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="kehoach-tbody">
                                                    @forelse ($keHoach as $index => $item)
                                                        <tr class="kehoach-row">
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>
                                                                <input type="text" class="form-control" name="kehoach[{{ $index }}][hoat_dong]"
                                                                       value="{{ $item->hoat_dong }}" required>
                                                                <input type="hidden" name="kehoach[{{ $index }}][id]" value="{{ $item->id }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="kehoach[{{ $index }}][thoi_gian]"
                                                                       value="{{ $item->thoi_gian }}">
                                                            </td>
                                                            <td>
                                                                <select class="form-control select2bs4" name="kehoach[{{ $index }}][nguoi_phu_trach_id]">
                                                                    <option value="">-- Chọn người phụ trách --</option>
                                                                    @foreach ($tinHuu as $tinHuu)
                                                                        <option value="{{ $tinHuu->id }}"
                                                                                {{ $item->nguoi_phu_trach_id == $tinHuu->id ? 'selected' : '' }}>
                                                                            {{ $tinHuu->ho_ten }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" name="kehoach[{{ $index }}][ghi_chu]">{{ $item->ghi_chu }}</textarea>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger btn-sm remove-kehoach">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr class="kehoach-row">
                                                            <td>1</td>
                                                            <td>
                                                                <input type="text" class="form-control" name="kehoach[0][hoat_dong]"
                                                                       value="" required>
                                                                <input type="hidden" name="kehoach[0][id]" value="0">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="kehoach[0][thoi_gian]"
                                                                       value="">
                                                            </td>
                                                            <td>
                                                                <select class="form-control select2bs4" name="kehoach[0][nguoi_phu_trach_id]">
                                                                    <option value="">-- Chọn người phụ trách --</option>
                                                                    @foreach ($tinHuu as $tinHuu)
                                                                        <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" name="kehoach[0][ghi_chu]"></textarea>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger btn-sm remove-kehoach">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="button" class="btn btn-info mt-3" id="add-kehoach">
                                            <i class="fas fa-plus-circle"></i> Thêm kế hoạch mới
                                        </button>
                                        <button type="submit" class="btn btn-primary mt-3 float-right">
                                            <i class="fas fa-save"></i> Lưu kế hoạch
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Tab: Ý kiến & Kiến nghị -->
                        <div class="tab-pane fade" id="kiennghi" role="tabpanel">
                            <form id="kiennghi-form" method="POST" action="{{ route('api._ban_co_doc_giao_duc.save_kien_nghi', ['banType' => 'ban-co-doc-giao-duc']) }}">
                                @csrf
                                <input type="hidden" name="month" value="{{ $month }}">
                                <input type="hidden" name="year" value="{{ $year }}">
                                <input type="hidden" name="ban_nganh_id" value="{{ $config['id'] }}">

                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-comment-alt"></i> Ý Kiến & Kiến Nghị
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div id="kiennghi-container">
                                            @forelse ($kienNghi as $index => $item)
                                                <div class="card mb-3 kiennghi-card">
                                                    <div class="card-header bg-light">
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6 class="m-0">Kiến nghị #{{ $index + 1 }}</h6>
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
                                                            <label>Tiêu đề</label>
                                                            <input type="text" class="form-control" name="kiennghi[{{ $index }}][tieu_de]"
                                                                   value="{{ $item->tieu_de }}" required>
                                                            <input type="hidden" name="kiennghi[{{ $index }}][id]" value="{{ $item->id }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nội dung</label>
                                                            <textarea class="form-control" name="kiennghi[{{ $index }}][noi_dung]"
                                                                      rows="3" required>{{ $item->noi_dung }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Người đề xuất</label>
                                                            <select class="form-control select2bs4" name="kiennghi[{{ $index }}][nguoi_de_xuat_id]">
                                                                <option value="">-- Chọn người đề xuất --</option>
                                                                @foreach ($tinHuu as $tinHuu)
                                                                    <option value="{{ $tinHuu->id }}"
                                                                            {{ $item->nguoi_de_xuat_id == $tinHuu->id ? 'selected' : '' }}>
                                                                        {{ $tinHuu->ho_ten }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="card mb-3 kiennghi-card">
                                                    <div class="card-header bg-light">
                                                        <div class="row">
                                                            <div class="col">
                                                                <h6 class="m-0">Kiến nghị #1</h6>
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
                                                            <label>Tiêu đề</label>
                                                            <input type="text" class="form-control" name="kiennghi[0][tieu_de]"
                                                                   value="" required>
                                                            <input type="hidden" name="kiennghi[0][id]" value="0">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Nội dung</label>
                                                            <textarea class="form-control" name="kiennghi[0][noi_dung]"
                                                                      rows="3" required></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Người đề xuất</label>
                                                            <select class="form-control select2bs4" name="kiennghi[0][nguoi_de_xuat_id]">
                                                                <option value="">-- Chọn người đề xuất --</option>
                                                                @foreach ($tinHuu as $tinHuu)
                                                                    <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>

                                        <button type="button" class="btn btn-info mt-3" id="add-kiennghi">
                                            <i class="fas fa-plus-circle"></i> Thêm kiến nghị mới
                                        </button>
                                        <button type="submit" class="btn btn-primary mt-3 float-right">
                                            <i class="fas fa-save"></i> Lưu kiến nghị
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('_ban_co_doc_giao_duc.scripts._scripts_nhap_lieu_bao_cao')