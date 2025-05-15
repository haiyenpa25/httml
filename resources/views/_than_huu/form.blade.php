@php
    $prefix = isset($prefix) ? $prefix : '';
@endphp

<div class="form-group">
    <label for="{{ $prefix }}ho_ten">Họ Tên <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="{{ $prefix }}ho_ten" name="ho_ten" placeholder="Nhập họ tên" required>
</div>

<div class="form-group">
    <label for="{{ $prefix }}nam_sinh">Năm Sinh <span class="text-danger">*</span></label>
    <input type="number" class="form-control" id="{{ $prefix }}nam_sinh" name="nam_sinh" placeholder="Nhập năm sinh" min="1900" max="{{ date('Y') }}" required>
</div>

<div class="form-group">
    <label for="{{ $prefix }}so_dien_thoai">Số Điện Thoại</label>
    <input type="text" class="form-control" id="{{ $prefix }}so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại">
</div>

<div class="form-group">
    <label for="{{ $prefix }}dia_chi">Địa Chỉ</label>
    <input type="text" class="form-control" id="{{ $prefix }}dia_chi" name="dia_chi" placeholder="Nhập địa chỉ">
</div>

<div class="form-group">
    <label for="{{ $prefix }}tin_huu_gioi_thieu_id">Tín Hữu Giới Thiệu <span class="text-danger">*</span></label>
    <select class="form-control" id="{{ $prefix }}tin_huu_gioi_thieu_id" name="tin_huu_gioi_thieu_id" required>
        <option value="">-- Chọn tín hữu --</option>
        @foreach($tinHuus ?? \App\Models\TinHuu::orderBy('ho_ten')->get() as $tinHuu)
            <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="{{ $prefix }}trang_thai">Trạng Thái <span class="text-danger">*</span></label>
    <select class="form-control" id="{{ $prefix }}trang_thai" name="trang_thai" required>
        <option value="chua_tin">Chưa tin</option>
        <option value="da_tham_gia">Đã tham gia</option>
        <option value="da_tin_chua">Đã tin Chúa</option>
    </select>
</div>

<div class="form-group">
    <label for="{{ $prefix }}ghi_chu">Ghi Chú</label>
    <textarea class="form-control" id="{{ $prefix }}ghi_chu" name="ghi_chu" placeholder="Nhập ghi chú" rows="4"></textarea>
</div>