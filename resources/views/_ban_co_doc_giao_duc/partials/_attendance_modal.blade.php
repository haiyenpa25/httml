<!-- Modal Thêm Buổi Nhóm -->
<div class="modal fade" id="modal-them-buoi-nhom">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-plus-circle mr-2"></i>Thêm Buổi Nhóm Mới</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-them-buoi-nhom"
                action="{{ route('api._ban_co_doc_giao_duc.them_buoi_nhom', ['banType' => 'ban-co-doc-giao-duc']) }}"
                method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="ban_nganh_id" value="{{ $config['id'] }}">

                    <div class="form-group">
                        <label for="chu_de" class="font-weight-bold">
                            <i class="fas fa-heading mr-1"></i>Chủ đề <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="chu_de" id="chu_de" class="form-control" required
                            placeholder="Nhập chủ đề buổi nhóm">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ngay_dien_ra" class="font-weight-bold">
                                    <i class="far fa-calendar-alt mr-1"></i>Ngày diễn ra <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="date" name="ngay_dien_ra" id="ngay_dien_ra" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dien_gia_id" class="font-weight-bold">
                                    <i class="fas fa-user-tie mr-1"></i>Diễn giả
                                </label>
                                <select name="dien_gia_id" id="dien_gia_id" class="form-control select2bs4">
                                    <option value="">-- Chọn diễn giả --</option>
                                    @foreach($dienGias as $dienGia)
                                        <option value="{{ $dienGia->id }}">{{ $dienGia->ho_ten }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dia_diem" class="font-weight-bold">
                            <i class="fas fa-map-marker-alt mr-1"></i>Địa điểm <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="dia_diem" id="dia_diem" class="form-control" required
                            placeholder="Nhập địa điểm">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gio_bat_dau" class="font-weight-bold">
                                    <i class="far fa-clock mr-1"></i>Giờ bắt đầu <span class="text-danger">*</span>
                                </label>
                                <input type="time" name="gio_bat_dau" id="gio_bat_dau" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gio_ket_thuc" class="font-weight-bold">
                                    <i class="far fa-clock mr-1"></i>Giờ kết thúc <span class="text-danger">*</span>
                                </label>
                                <input type="time" name="gio_ket_thuc" id="gio_ket_thuc" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ghi_chu" class="font-weight-bold">
                            <i class="fas fa-sticky-note mr-1"></i>Ghi chú
                        </label>
                        <textarea name="ghi_chu" id="ghi_chu" class="form-control" rows="3"
                            placeholder="Nhập ghi chú (nếu có)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Đóng
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Lưu buổi nhóm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>