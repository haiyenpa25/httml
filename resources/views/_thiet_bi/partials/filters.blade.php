<!-- resources/views/_thiet_bi/partials/filters.blade.php -->
<div class="card card-secondary card-outline collapsed-card mb-3">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-filter"></i>
            Bộ lọc nâng cao
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="filter-loai-thiet-bi">Loại Thiết Bị</label>
                    <select class="form-control" id="filter-loai-thiet-bi">
                        <option value="">-- Tất cả --</option>
                        <option value="nhac_cu">Nhạc cụ</option>
                        <option value="anh_sang">Ánh sáng</option>
                        <option value="am_thanh">Âm thanh</option>
                        <option value="hinh_anh">Hình ảnh</option>
                        <option value="khac">Khác</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="filter-tinh-trang">Tình Trạng</label>
                    <select class="form-control" id="filter-tinh-trang">
                        <option value="">-- Tất cả --</option>
                        <option value="tot">Tốt</option>
                        <option value="hong">Hỏng</option>
                        <option value="dang_sua">Đang sửa</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="filter-ban-nganh">Ban Ngành</label>
                    <select class="form-control" id="filter-ban-nganh">
                        <option value="">-- Tất cả --</option>
                        @foreach($banNganhs as $banNganh)
                            <option value="{{ $banNganh->id }}">{{ $banNganh->ten }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="filter-vi-tri">Vị Trí</label>
                    <input type="text" class="form-control" id="filter-vi-tri" placeholder="Nhập vị trí">
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>