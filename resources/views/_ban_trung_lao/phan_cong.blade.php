@extends('layouts.app')

@section('title', 'Phân Công Buổi Nhóm - Ban Trung Lão')

@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Thông báo thành công hoặc lỗi -->
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
    
            <!-- Các nút chức năng -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between">
                            <div class="btn-group">
                                <a href="{{ route('_ban_trung_lao.index') }}" class="btn btn-primary">
                                    <i class="fas fa-home"></i> Trang chính
                                </a>
                                <a href="{{ route('_ban_trung_lao.diem_danh') }}" class="btn btn-success">
                                    <i class="fas fa-clipboard-check"></i> Điểm danh
                                </a>
                                <a href="{{ route('_ban_trung_lao.tham_vieng') }}" class="btn btn-info">
                                    <i class="fas fa-user-friends"></i> Thăm viếng
                                </a>
                                <a href="{{ route('_ban_trung_lao.phan_cong') }}" class="btn btn-warning">
                                    <i class="fas fa-tasks"></i> Phân công
                                </a>
                                <a href="{{ route('_ban_trung_lao.phan_cong_chi_tiet') }}" class="btn btn-warning">
                                    <i class="fas fa-tasks"></i> Phân công chi tiết
                                </a>
                            </div>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-them-thanh-vien">
                                <i class="fas fa-user-plus"></i> Thêm thành viên
                            </button>
                        </div>
                    </div>
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
            <form id="buoi-nhom-form" action="{{ route('api.ban_trung_lao.update_buoi_nhom', ['buoiNhom' => ':id']) }}" method="POST">
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

@push('scripts')
<script>
$(function() {
    // Filter functionality
    $('form').on('submit', function(e) {
        e.preventDefault();
        const month = $('#month-select').val();
        const year = $('#year-select').val();
        
        // Reload the page with selected month and year
        window.location.href = `{{ route('_ban_trung_lao.phan_cong') }}?month=${month}&year=${year}`;
    });

    // Edit button handler
    $('.edit-btn').on('click', function() {
        const id = $(this).data('id');
        const row = $(this).closest('tr');
        
        // Populate form with row data
        $('#buoi-nhom-id').val(id);
        
        // Date conversion from dd/mm/yyyy to yyyy-mm-dd for date input
        const dateParts = row.find('td:nth-child(2)').text().split('/');
        const formattedDate = `${dateParts[2]}-${dateParts[1].padStart(2, '0')}-${dateParts[0].padStart(2, '0')}`;
        $('input[name="ngay_dien_ra"]').val(formattedDate);
        
        $('input[name="chu_de"]').val(row.find('td:nth-child(3)').text());
        
        // Diễn Giả
        const dienGiaTen = row.find('td:nth-child(4)').text();
        $('select[name="dien_gia_id"]').val(
            $('select[name="dien_gia_id"] option')
                .filter(function() { 
                    return $(this).text().includes(dienGiaTen);
                }).val()
        );
        
        // Người Hướng Dẫn
        const hdctTen = row.find('td:nth-child(5)').text();
        $('select[name="id_tin_huu_hdct"]').val(
            $('select[name="id_tin_huu_hdct"] option')
                .filter(function() { 
                    return $(this).text() === hdctTen;
                }).val()
        );
        
        // Người Đọc Kinh Thánh
        const ktTen = row.find('td:nth-child(6)').text();
        $('select[name="id_tin_huu_do_kt"]').val(
            $('select[name="id_tin_huu_do_kt"] option')
                .filter(function() { 
                    return $(this).text() === ktTen;
                }).val()
        );
        
        // Ghi Chú
        $('textarea[name="ghi_chu"]').val(row.find('td:nth-child(7)').text());
        
        // Trigger Select2 update
        $('.select2').trigger('change');
    });

    // Form submission
    $('#buoi-nhom-form').on('submit', function(e) {
        e.preventDefault();
        
        const id = $('#buoi-nhom-id').val();
        const form = $(this);
        const url = form.attr('action').replace(':id', id);
        
        $.ajax({
            url: url,
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload(); // Reload page to see updated data
                } else {
                    alert('Lỗi: ' + response.message);
                }
            },
            error: function(xhr) {
                const errors = xhr.responseJSON.errors;
                let errorMsg = 'Lỗi:\n';
                Object.values(errors).forEach(error => {
                    errorMsg += error.join('\n') + '\n';
                });
                alert(errorMsg);
            }
        });
    });

    // Reset form
    $('#reset-form').on('click', function() {
        $('#buoi-nhom-form')[0].reset();
        $('#buoi-nhom-id').val('');
        $('.select2').val(null).trigger('change');
    });

    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4'
    });

    // Delete button handler
    $('.delete-btn').on('click', function() {
        const id = $(this).data('id');
        const row = $(this).closest('tr');
        
        if(confirm('Bạn có chắc chắn muốn xóa buổi nhóm này?')) {
            $.ajax({
                url: `{{ route('api.ban_trung_lao.delete_buoi_nhom', ['buoiNhom' => ':id']) }}`.replace(':id', id),
                method: 'DELETE',
                success: function(response) {
                    if (response.success) {
                        // Remove the row from the table
                        row.remove();
                        alert(response.message);
                    } else {
                        alert('Lỗi: ' + response.message);
                    }
                },
                error: function(xhr) {
                    const errorMsg = xhr.responseJSON 
                        ? xhr.responseJSON.message 
                        : 'Đã xảy ra lỗi khi xóa buổi nhóm';
                    alert(errorMsg);
                }
            });
        }
    });
});
</script>
@endpush