@extends('layouts.app')

@section('title', 'Phân Công Buổi Nhóm - Ban Trung Lão')

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
            <div class="action-buttons-container">
                <!-- Hàng 1: Chức năng điều hướng chính -->
                <div class="button-row">
                    <a href="{{ route('_ban_trung_lao.index') }}" class="action-btn btn-primary-custom">
                        <i class="fas fa-home"></i> Trang chính
                    </a>
                    <a href="{{ route('_ban_trung_lao.diem_danh') }}" class="action-btn btn-success-custom">
                        <i class="fas fa-clipboard-check"></i> Điểm danh
                    </a>
                    <a href="{{ route('_ban_trung_lao.tham_vieng') }}" class="action-btn btn-info-custom">
                        <i class="fas fa-user-friends"></i> Thăm viếng
                    </a>
                </div>

                <!-- Hàng 2: Chức năng phân công và báo cáo -->
                <div class="button-row">
                    <a href="{{ route('_ban_trung_lao.phan_cong') }}" class="action-btn btn-warning-custom">
                        <i class="fas fa-tasks"></i> Phân công
                    </a>
                    <a href="{{ route('_ban_trung_lao.phan_cong_chi_tiet') }}" class="action-btn btn-info-custom">
                        <i class="fas fa-clipboard-list"></i> Chi tiết PC
                    </a>
                    <a href="{{ route('_ban_trung_lao.nhap_lieu_bao_cao') }}" class="action-btn btn-success-custom">
                        <i class="fas fa-file-alt"></i> Nhập báo cáo
                    </a>
                </div>

                <!-- Hàng 3: Chức năng quản lý -->
                <div class="button-row">
                    <button type="button" class="action-btn btn-success-custom" data-toggle="modal"
                        data-target="#modal-them-thanh-vien">
                        <i class="fas fa-user-plus"></i> Thêm thành viên
                    </button>
                    <button type="button" class="action-btn btn-info-custom" id="btn-refresh">
                        <i class="fas fa-sync"></i> Tải lại
                    </button>
                    <button type="button" class="action-btn btn-primary-custom" id="btn-export">
                        <i class="fas fa-file-excel"></i> Xuất Excel
                    </button>
                </div>
            </div>


            <!-- Thêm thành viên modal -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <form action="{{ route('_ban_trung_lao.phan_cong') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
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
                                <button type="submit" class="btn btn-primary" id="filter-btn">
                                    <i class="fas fa-filter"></i> Lọc
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="buoi-nhom-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Ngày</th>
                                    <th>Chủ Đề</th>
                                    <th>Diễn Giả</th>
                                    <th>Người Hướng Dẫn</th>
                                    <th>Người Đọc KT</th>
                                    <th>Ghi Chú</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($buoiNhoms as $buoiNhom)
                                    <tr data-id="{{ $buoiNhom->id }}">
                                        <td>{{ $buoiNhom->id }}</td>
                                        <td>{{ $buoiNhom->ngay_dien_ra->format('d/m/Y') }}</td>
                                        <td>{{ $buoiNhom->chu_de }}</td>
                                        <td>{{ $buoiNhom->dienGia->ho_ten ?? 'Chưa chọn' }}</td>
                                        <td>{{ $buoiNhom->tinHuuHdct->ho_ten ?? 'Chưa chọn' }}</td>
                                        <td>{{ $buoiNhom->tinHuuDoKt->ho_ten ?? 'Chưa chọn' }}</td>
                                        <td>{{ $buoiNhom->ghi_chu ?? 'Không' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-warning edit-btn" data-id="{{ $buoiNhom->id }}">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $buoiNhom->id }}">
                                                    <i class="fas fa-trash"></i> Xóa
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i>
                        Chỉnh sửa Buổi Nhóm
                    </h3>
                </div>
                <form id="buoi-nhom-form" action="{{ route('api.ban_trung_lao.update_buoi_nhom', ['buoiNhom' => ':id']) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="buoi-nhom-id">

                    <div class="card-body">
                        <div class="form-group">
                            <label>Ngày Diễn Ra</label>
                            <input type="date" class="form-control" name="ngay_dien_ra" required>
                        </div>

                        <div class="form-group">
                            <label>Chủ Đề</label>
                            <input type="text" class="form-control" name="chu_de" placeholder="Nhập chủ đề" required>
                        </div>

                        <div class="form-group">
                            <label>Diễn Giả</label>
                            <select class="form-control select2" name="dien_gia_id">
                                <option value="">-- Chọn Diễn Giả --</option>
                                @foreach($dienGias as $dienGia)
                                    <option value="{{ $dienGia->id }}">
                                        {{ $dienGia->ho_ten }} - {{ $dienGia->chuc_danh }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Người Hướng Dẫn</label>
                            <select class="form-control select2" name="id_tin_huu_hdct">
                                <option value="">-- Chọn Người Hướng Dẫn --</option>
                                @foreach($tinHuus as $tinHuu)
                                    <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Người Đọc Kinh Thánh</label>
                            <select class="form-control select2" name="id_tin_huu_do_kt">
                                <option value="">-- Chọn Người Đọc Kinh Thánh --</option>
                                @foreach($tinHuus as $tinHuu)
                                    <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Ghi Chú</label>
                            <textarea class="form-control" name="ghi_chu" rows="3" placeholder="Nhập ghi chú"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Cập Nhật</button>
                        <button type="button" class="btn btn-secondary" id="reset-form">Làm Mới</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@include('_ban_trung_lao.scripts._scripts_phan_cong')