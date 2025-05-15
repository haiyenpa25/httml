<form id="form-filter">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="filter_ho_ten">Họ Tên</label>
                <input type="text" class="form-control" id="filter_ho_ten" name="ho_ten" placeholder="Nhập họ tên">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="filter_chuc_danh">Chức Danh</label>
                <select class="form-control" id="filter_chuc_danh" name="chuc_danh">
                    <option value="">Tất cả</option>
                    @foreach(['Thầy', 'Cô', 'Mục sư', 'Mục sư nhiệm chức', 'Truyền Đạo', 'Chấp Sự'] as $cd)
                    <option value="{{ $cd }}">{{ $cd }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="filter_hoi_thanh">Hội Thánh</label>
                <input type="text" class="form-control" id="filter_hoi_thanh" name="hoi_thanh" placeholder="Nhập hội thánh">
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Lọc</button>
        <button type="button" class="btn btn-secondary" id="btn-reset-filter"><i class="fas fa-undo"></i> Đặt lại</button>
    </div>
</form>