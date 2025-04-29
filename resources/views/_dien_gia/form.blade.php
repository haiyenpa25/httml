<div class="form-group">
    <label>Họ Tên</label>
    <input type="text" name="ho_ten" class="form-control" value="{{ old('ho_ten', $dienGia->ho_ten ?? '') }}" required>
</div>
<div class="form-group">
    <label>Chức Danh</label>
    <select name="chuc_danh" class="form-control" required>
        @foreach(['Thầy', 'Cô', 'Mục sư', 'Mục sư nhiệm chức', 'Truyền Đạo', 'Chấp Sự'] as $cd)
            <option value="{{ $cd }}" {{ (old('chuc_danh', $dienGia->chuc_danh ?? '') == $cd) ? 'selected' : '' }}>{{ $cd }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label>Hội Thánh</label>
    <input type="text" name="hoi_thanh" class="form-control" value="{{ old('hoi_thanh', $dienGia->hoi_thanh ?? '') }}">
</div>
<div class="form-group">
    <label>Địa Chỉ</label>
    <input type="text" name="dia_chi" class="form-control" value="{{ old('dia_chi', $dienGia->dia_chi ?? '') }}">
</div>
<div class="form-group">
    <label>Số Điện Thoại</label>
    <input type="text" name="so_dien_thoai" class="form-control" value="{{ old('so_dien_thoai', $dienGia->so_dien_thoai ?? '') }}">
</div>
