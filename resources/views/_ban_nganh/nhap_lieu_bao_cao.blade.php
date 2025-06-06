@extends('layouts.app')

@section('title', 'Nhập liệu Báo Cáo ' . ($banNganh->ten ?? 'Ban Ngành'))

@section('content')
<section class="content-header">
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

        <!-- Thanh điều hướng nhanh -->
        @include('_ban_nganh.partials._ban_nganh_navigation')

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Nhập liệu Báo Cáo {{ $banNganh->ten ?? 'Ban Ngành' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="#">Báo Cáo</a></li>
                    <li class="breadcrumb-item active">Nhập liệu {{ $banNganh->ten ?? 'Ban Ngành' }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Form lọc và chọn buổi nhóm -->
        <div class="card mb-4">
            <div class="card-header bg-primary">
                <h5 class="card-title text-white">Thông Tin Báo Cáo</h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form id="filter-form" method="GET" action="{{ route('_ban_nganh.' . $banType . '.nhap_lieu_bao_cao') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="month">Tháng:</label>
                                <select id="month" name="month" class="form-control">
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                        Tháng {{ $m }}
                                        </option>
                                        @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="year">Năm:</label>
                                <select id="year" name="year" class="form-control">
                                    @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="buoi_nhom_type">Buổi nhóm:</label>
                                <select id="buoi_nhom_type" name="buoi_nhom_type" class="form-control">
                                    <option value="1" {{ isset($buoiNhomType) && $buoiNhomType == 1 ? 'selected' : '' }}>
                                        {{ $banNganh->ten ?? 'Ban Ngành' }} (Nhóm tối thứ 7)
                                    </option>
                                    <option value="13" {{ isset($buoiNhomType) && $buoiNhomType == 13 ? 'selected' : '' }}>
                                        Hội Thánh (Nhóm Chúa Nhật)
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
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
                            <i class="fas fa-users"></i> Số lượng tham dự
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="danhgia-tab" data-toggle="pill" href="#danhgia" role="tab">
                            <i class="fas fa-chart-line"></i> Đánh giá & Nhận xét
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="kehoach-tab" data-toggle="pill" href="#kehoach" role="tab">
                            <i class="fas fa-calendar-alt"></i> Kế hoạch tháng tới
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="kiennghi-tab" data-toggle="pill" href="#kiennghi" role="tab">
                            <i class="fas fa-comment-alt"></i> Ý kiến & Kiến nghị
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="baocao-tabContent">
                    <!-- Tab: Số lượng tham dự -->
                    <div class="tab-pane fade show active" id="buoinhom" role="tabpanel">
                        <!-- Form cho số lượng tham dự -->
                        <form id="thamdu-form" method="POST" action="{{ route('_ban_nganh.' . $banType . '.save_tham_du') }}">
                            @csrf
                            <input type="hidden" name="month" value="{{ $month }}">
                            <input type="hidden" name="year" value="{{ $year }}">
                            <input type="hidden" name="buoi_nhom_type" value="{{ $buoiNhomType }}">
                            <input type="hidden" name="ban_nganh_id" value="{{ $banNganh->id }}">

                            <!-- Nhóm Chúa Nhật (nếu đang ở tab Hội Thánh) -->
                            @if ($buoiNhomType == 13)
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-church"></i> Nhóm Chúa Nhật (Hội Thánh)
                                    </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="buoi-nhom-ht-table" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px">STT</th>
                                                    <th>Ngày</th>
                                                    <th>Đề tài</th>
                                                    <th>Diễn giả</th>
                                                    <th>Số lượng {{ $banNganh->ten ?? 'Ban Ngành' }}</th>
                                                    <th style="width: 120px">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($buoiNhomHT as $index => $buoiNhom)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y') }}</td>
                                                    <td>{{ $buoiNhom->chu_de ?? 'N/A' }}</td>
                                                    <td>{{ $buoiNhom->dienGia->ho_ten ?? 'N/A' }}</td>
                                                    <td>
                                                        <input type="number" class="form-control"
                                                            name="buoi_nhom[{{ $buoiNhom->id }}][so_luong_trung_lao]"
                                                            min="0" value="{{ $buoiNhom->so_luong_trung_lao ?? 0 }}">
                                                        <input type="hidden" name="buoi_nhom[{{ $buoiNhom->id }}][id]" value="{{ $buoiNhom->id }}">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-sm update-count"
                                                            data-id="{{ $buoiNhom->id }}"
                                                            data-type="ht">
                                                            <i class="fas fa-save"></i> Lưu
                                                        </button>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td></td>
                                                    <td colspan="5" class="text-center">Không có dữ liệu buổi nhóm trong tháng này</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Lưu tất cả thay đổi
                                    </button>
                                </div>
                            </div>
                            @endif

                            <!-- Nhóm tối thứ 7 (nếu đang ở tab Ban Ngành) -->
                            @if ($buoiNhomType == 1)
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-users"></i> Nhóm tối thứ 7 ({{ $banNganh->ten ?? 'Ban Ngành' }})
                                    </h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="buoi-nhom-bn-table" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px">STT</th>
                                                    <th>Ngày</th>
                                                    <th>Đề tài</th>
                                                    <th>Diễn giả</th>
                                                    <th>Số lượng {{ $banNganh->ten ?? 'Ban Ngành' }}</th>
                                                    <th>Dâng hiến (VNĐ)</th>
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
                                                            name="buoi_nhom[{{ $buoiNhom->id }}][so_luong_trung_lao]"
                                                            min="0" value="{{ $buoiNhom->so_luong_trung_lao ?? 0 }}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control money-format"
                                                            name="buoi_nhom[{{ $buoiNhom->id }}][dang_hien]"
                                                            value="{{ number_format($buoiNhom->giaoDichTaiChinh->so_tien ?? 0, 0, ',', '.') }}">
                                                        <input type="hidden" name="buoi_nhom[{{ $buoiNhom->id }}][id]" value="{{ $buoiNhom->id }}">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-success btn-sm update-count"
                                                            data-id="{{ $buoiNhom->id }}"
                                                            data-type="bn">
                                                            <i class="fas fa-save"></i> Lưu
                                                        </button>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td></td>
                                                    <td colspan="6" class="text-center">Không có dữ liệu buổi nhóm trong tháng này</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Lưu tất cả thay đổi
                                    </button>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>

                    <!-- Tab: Đánh giá & Nhận xét -->
                    <div class="tab-pane fade" id="danhgia" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-thumbs-up"></i> Điểm mạnh</h3>
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
                                                    <th>STT</th>
                                                    <th>Nội dung</th>
                                                    <th>Người đánh giá</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Dữ liệu sẽ được tải bằng DataTable -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card card-outline card-danger">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-thumbs-down"></i> Điểm cần cải thiện</h3>
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
                                                    <th>STT</th>
                                                    <th>Nội dung</th>
                                                    <th>Người đánh giá</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Dữ liệu sẽ được tải bằng DataTable -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Thêm điểm mạnh -->
                        <div class="modal fade" id="modal-add-diem-manh" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Thêm điểm mạnh</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form id="add-diem-manh-form">
                                        <div class="modal-body">
                                            @csrf
                                            <input type="hidden" name="month" value="{{ $month }}">
                                            <input type="hidden" name="year" value="{{ $year }}">
                                            <input type="hidden" name="ban_nganh_id" value="{{ $banNganh->id }}">
                                            <input type="hidden" name="loai" value="diem_manh">
                                            <div class="form-group">
                                                <label>Nội dung:</label>
                                                <textarea class="form-control" name="noi_dung" rows="4" required></textarea>
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
                        <div class="modal fade" id="modal-add-diem-yeu" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Thêm điểm cần cải thiện</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form id="add-diem-yeu-form">
                                        <div class="modal-body">
                                            @csrf
                                            <input type="hidden" name="month" value="{{ $month }}">
                                            <input type="hidden" name="year" value="{{ $year }}">
                                            <input type="hidden" name="ban_nganh_id" value="{{ $banNganh->id }}">
                                            <input type="hidden" name="loai" value="diem_yeu">
                                            <div class="form-group">
                                                <label>Nội dung:</label>
                                                <textarea class="form-control" name="noi_dung" rows="4" required></textarea>
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
                        <form id="kehoach-form" method="POST" action="{{ route('_ban_nganh.' . $banType . '.save_ke_hoach') }}">
                            @csrf
                            <input type="hidden" name="month" value="{{ $nextMonth }}">
                            <input type="hidden" name="year" value="{{ $nextYear }}">
                            <input type="hidden" name="ban_nganh_id" value="{{ $banNganh->id }}">

                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-calendar-alt"></i> Kế hoạch tháng {{ $nextMonth }}/{{ $nextYear }}
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th width="5%">STT</th>
                                                    <th width="30%">Hoạt động</th>
                                                    <th width="15%">Thời gian</th>
                                                    <th width="20%">Người phụ trách</th>
                                                    <th width="20%">Ghi chú</th>
                                                    <th width="10%">Thao tác</th>
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
                                                        <select class="form-control" name="kehoach[{{ $index }}][nguoi_phu_trach_id]">
                                                            <option value="">-- Chọn người phụ trách --</option>
                                                            @if ($tinHuuBan->isEmpty())
                                                            <option value="">Không có tín hữu nào trong {{ $banNganh->ten ?? 'Ban Ngành' }}</option>
                                                            @else
                                                            @foreach ($tinHuuBan as $tinHuu)
                                                            @if ($tinHuu)
                                                            <option value="{{ $tinHuu->id }}"
                                                                {{ $item->nguoi_phu_trach_id == $tinHuu->id ? 'selected' : '' }}>
                                                                {{ $tinHuu->ho_ten }}
                                                            </option>
                                                            @endif
                                                            @endforeach
                                                            @endif
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
                                                        <select class="form-control" name="kehoach[0][nguoi_phu_trach_id]">
                                                            <option value="">-- Chọn người phụ trách --</option>
                                                            @if ($tinHuuBan->isEmpty())
                                                            <option value="">Không có tín hữu nào trong {{ $banNganh->ten ?? 'Ban Ngành' }}</option>
                                                            @else
                                                            @foreach ($tinHuuBan as $tinHuu)
                                                            @if ($tinHuu)
                                                            <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                                            @endif
                                                            @endforeach
                                                            @endif
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
                        <form id="kiennghi-form" method="POST" action="{{ route('_ban_nganh.' . $banType . '.save_kien_nghi') }}">
                            @csrf
                            <input type="hidden" name="month" value="{{ $month }}">
                            <input type="hidden" name="year" value="{{ $year }}">
                            <input type="hidden" name="ban_nganh_id" value="{{ $banNganh->id }}">

                            <div class="card card-outline card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-comment-alt"></i> Ý kiến & Kiến nghị
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
                                                    <label>Tiêu đề:</label>
                                                    <input type="text" class="form-control" name="kiennghi[{{ $index }}][tieu_de]"
                                                        value="{{ $item->tieu_de }}" required>
                                                    <input type="hidden" name="kiennghi[{{ $index }}][id]" value="{{ $item->id }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Nội dung:</label>
                                                    <textarea class="form-control" name="kiennghi[{{ $index }}][noi_dung]"
                                                        rows="3" required>{{ $item->noi_dung }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Người đề xuất:</label>
                                                    <select class="form-control" name="kiennghi[{{ $index }}][nguoi_de_xuat_id]">
                                                        <option value="">-- Chọn người đề xuất --</option>
                                                        @if ($tinHuuBan->isEmpty())
                                                        <option value="">Không có tín hữu nào trong {{ $banNganh->ten ?? 'Ban Ngành' }}</option>
                                                        @else
                                                        @foreach ($tinHuuBan as $tinHuu)
                                                        @if ($tinHuu)
                                                        <option value="{{ $tinHuu->id }}"
                                                            {{ $item->nguoi_de_xuat_id == $tinHuu->id ? 'selected' : '' }}>
                                                            {{ $tinHuu->ho_ten }}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                        @endif
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
                                                    <label>Tiêu đề:</label>
                                                    <input type="text" class="form-control" name="kiennghi[0][tieu_de]"
                                                        value="" required>
                                                    <input type="hidden" name="kiennghi[0][id]" value="0">
                                                </div>
                                                <div class="form-group">
                                                    <label>Nội dung:</label>
                                                    <textarea class="form-control" name="kiennghi[0][noi_dung]"
                                                        rows="3" required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Người đề xuất:</label>
                                                    <select class="form-control" name="kiennghi[0][nguoi_de_xuat_id]">
                                                        <option value="">-- Chọn người đề xuất --</option>
                                                        @if ($tinHuuBan->isEmpty())
                                                        <option value="">Không có tín hữu nào trong {{ $banNganh->ten ?? 'Ban Ngành' }}</option>
                                                        @else
                                                        @foreach ($tinHuuBan as $tinHuu)
                                                        @if ($tinHuu)
                                                        <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                                        @endif
                                                        @endforeach
                                                        @endif
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

@include('_ban_nganh.scripts._scripts_nhap_lieu_bao_cao')