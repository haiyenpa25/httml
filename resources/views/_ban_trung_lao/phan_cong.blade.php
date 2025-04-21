@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Phân Công Buổi Nhóm - Ban Trung Lão</h3>
        </div>
        
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <form action="{{ route('buoi_nhom.filter') }}" method="GET">
                        <div class="input-group">
                            <select name="month" class="form-control mr-2">
                                @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}" 
                                        {{ $month == date('m') ? 'selected' : '' }}>
                                        Tháng {{ $month }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="year" class="form-control mr-2">
                                @foreach(range(date('Y') - 2, date('Y') + 2) as $year)
                                    <option value="{{ $year }}" 
                                        {{ $year == date('Y') ? 'selected' : '' }}>
                                        Năm {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Lọc
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
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
                        @forelse($buoiNhoms as $buoiNhom)
                        <tr>
                            <td>{{ $buoiNhom->id }}</td>
                            <td>{{ $buoiNhom->ngay_dien_ra->format('d/m/Y') }}</td>
                            <td>{{ $buoiNhom->chu_de }}</td>
                            <td>{{ optional($buoiNhom->dienGia)->ho_ten ?? 'Chưa chọn' }}</td>
                            <td>{{ optional($buoiNhom->nguoiHuongDan)->ho_ten ?? 'Chưa chọn' }}</td>
                            <td>{{ optional($buoiNhom->nguoiDocKinhThanh)->ho_ten ?? 'Chưa chọn' }}</td>
                            <td>{{ $buoiNhom->ghi_chu ?? 'Không có' }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('buoi_nhom.edit', $buoiNhom) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $buoiNhom->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Không có dữ liệu buổi nhóm</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        // Mặc định chọn tháng và năm hiện tại
        $('select[name="month"]').val({{ date('m') }});
        $('select[name="year"]').val({{ date('Y') }});
    });
</script>
@endpush