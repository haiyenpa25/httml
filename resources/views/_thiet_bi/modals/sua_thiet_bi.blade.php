<!-- Modal Sửa Thiết Bị -->
<div class="modal fade" id="modal-sua-thiet-bi">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa Thiết Bị</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-sua-thiet-bi" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ten">Tên thiết bị <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_ten" name="ten"
                                    placeholder="Nhập tên thiết bị" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ma_tai_san">Mã tài sản</label>
                                <input type="text" class="form-control" id="edit_ma_tai_san" name="ma_tai_san"
                                    placeholder="Nhập mã tài sản">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_loai">Loại Thiết Bị <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_loai" name="loai" required>
                                    <option value="">-- Chọn Loại Thiết Bị --</option>
                                    <option value="nhac_cu">Nhạc cụ</option>
                                    <option value="anh_sang">Ánh sáng</option>
                                    <option value="am_thanh">Âm thanh</option>
                                    <option value="hinh_anh">Hình ảnh</option>
                                    <option value="khac">Khác</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_tinh_trang">Tình Trạng <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_tinh_trang" name="tinh_trang" required>
                                    <option value="">-- Chọn Tình Trạng --</option>
                                    <option value="tot">Tốt</option>
                                    <option value="hong">Hỏng</option>
                                    <option value="dang_sua">Đang sửa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_vi_tri_hien_tai">Vị Trí Hiện Tại</label>
                                <input type="text" class="form-control" id="edit_vi_tri_hien_tai" name="vi_tri_hien_tai"
                                    placeholder="Nhập vị trí hiện tại">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_id_ban">Ban Ngành</label>
                                <select class="form-control select2" id="edit_id_ban" name="id_ban">
                                    <option value="">-- Chọn Ban Ngành --</option>
                                    @foreach($banNganhs as $banNganh)
                                        <option value="{{ $banNganh->id }}">{{ $banNganh->ten }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_nguoi_quan_ly_id">Người Quản Lý</label>
                                <select class="form-control select2" id="edit_nguoi_quan_ly_id" name="nguoi_quan_ly_id">
                                    <option value="">-- Chọn Người Quản Lý --</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_nha_cung_cap_id">Nhà Cung Cấp</label>
                                <select class="form-control select2" id="edit_nha_cung_cap_id" name="nha_cung_cap_id">
                                    <option value="">-- Chọn Nhà Cung Cấp --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ngay_mua">Ngày Mua</label>
                                <input type="date" class="form-control" id="edit_ngay_mua" name="ngay_mua">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_gia_tri">Giá Trị (VNĐ)</label>
                                <input type="number" class="form-control" id="edit_gia_tri" name="gia_tri" min="0"
                                    step="1000">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_thoi_gian_bao_hanh">Thời Gian Bảo Hành</label>
                                <input type="date" class="form-control" id="edit_thoi_gian_bao_hanh"
                                    name="thoi_gian_bao_hanh">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_ngay_het_han_su_dung">Ngày Hết Hạn Sử Dụng</label>
                                <input type="date" class="form-control" id="edit_ngay_het_han_su_dung"
                                    name="ngay_het_han_su_dung">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_chu_ky_bao_tri">Chu Kỳ Bảo Trì (Ngày)</label>
                                <input type="number" class="form-control" id="edit_chu_ky_bao_tri" name="chu_ky_bao_tri"
                                    min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_hinh_anh">Hình Ảnh</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="edit_hinh_anh" name="hinh_anh"
                                            accept="image/*">
                                        <label class="custom-file-label" for="edit_hinh_anh">Chọn file</label>
                                    </div>
                                </div>
                                <div id="preview-hinh-anh" class="mt-2"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edit_mo_ta">Mô Tả</label>
                                <textarea class="form-control" id="edit_mo_ta" name="mo_ta" rows="3"
                                    placeholder="Nhập mô tả chi tiết"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>