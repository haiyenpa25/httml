@php
    $prefix = isset($prefix) ? $prefix : '';
@endphp

<div class="form-group">
    <label for="{{ $prefix }}ho_ten">Họ Tên <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="{{ $prefix }}ho_ten" name="ho_ten" placeholder="Nhập họ tên" required>
</div>

<div class="form-group">
    <label for="{{ $prefix }}chuc_danh">Chức Danh <span class="text-danger">*</span></label>
    <select class="form-control" id="{{ $prefix }}chuc_danh" name="chuc_danh" required>
        <option value="">-- Chọn chức danh --</option>
        @foreach(['Thầy', 'Cô', 'Mục sư', 'Mục sư nhiệm chức', 'Truyền Đạo', 'Chấp Sự'] as $cd)
            <option value="{{ $cd }}">{{ $cd }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="{{ $prefix }}hoi_thanh">Hội Thánh</label>
    <input type="text" class="form-control" id="{{ $prefix }}hoi_thanh" name="hoi_thanh" placeholder="Nhập hội thánh">
</div>

<div class="form-group">
    <label for="{{ $prefix }}dia_chi">Địa Chỉ</label>
    <input type="text" class="form-control" id="{{ $prefix }}dia_chi" name="dia_chi" placeholder="Nhập địa chỉ">
</div>

<div class="form-group">
    <label for="{{ $prefix }}so_dien_thoai">Số Điện Thoại</label>
    <input type="text" class="form-control" id="{{ $prefix }}so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại">
</div>