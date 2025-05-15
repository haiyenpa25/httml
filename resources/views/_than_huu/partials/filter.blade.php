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
                <label for="filter_trang_thai">Trạng Thái</label>
                <select class="form-control" id="filter_trang_thai" name="trang_thai">
                    <option value="">Tất cả</option>
                    <option value="chua_tin">Chưa tin</option>
                    <option value="da_tham_gia">Đã tham gia</option>
                    <option value="da_tin_chua">Đã tin Chúa</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="filter_tin_huu_gioi_thieu_id">Tín Hữu Giới Thiệu</label>
                <select class="form-control" id="filter_tin_huu_gioi_thieu_id" name="tin_huu_gioi_thieu_id">
                    <option value="">Tất cả</option>
                    @foreach(\App\Models\TinHuu::orderBy('ho_ten')->get() as $tinHuu)
                    <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Lọc</button>
        <button type="button" class="btn btn-secondary" id="btn-reset-filter"><i class="fas fa-undo"></i> Đặt lại</button>
    </div>
</form>