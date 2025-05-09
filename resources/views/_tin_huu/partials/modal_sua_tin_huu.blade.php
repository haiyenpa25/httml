<div class="modal fade" id="modal-sua-tin-huu">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa Tín Hữu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-sua-tin-huu">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ho_ten">Họ tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_ho_ten" name="ho_ten" placeholder="Nhập họ tên" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ngay_sinh">Ngày Sinh <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit_ngay_sinh" name="ngay_sinh" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_so_dien_thoai">Số Điện Thoại <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_dia_chi">Địa Chỉ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_dia_chi" name="dia_chi" placeholder="Nhập địa chỉ" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_loai_tin_huu">Loại Tín Hữu <span class="text-danger">*</span></label>
                                <select class="form-control select2bs4" id="edit_loai_tin_huu" name="loai_tin_huu" required>
                                    <option value="">-- Chọn Loại Tín Hữu --</option>
                                    <option value="tin_huu_chinh_thuc">Tín Hữu Chính Thức</option>
                                    <option value="tan_tin_huu">Tân Tín Hữu</option>
                                    <option value="tin_huu_du_le">Tín Hữu Dự Lễ</option>
                                    <option value="tin_huu_ht_khac">Tín Hữu Hội Thánh Khác</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_gioi_tinh">Giới Tính <span class="text-danger">*</span></label>
                                <select class="form-control select2bs4" id="edit_gioi_tinh" name="gioi_tinh" required>
                                    <option value="">-- Chọn Giới Tính --</option>
                                    <option value="nam">Nam</option>
                                    <option value="nu">Nữ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_tinh_trang_hon_nhan">Tình Trạng Hôn Nhân <span class="text-danger">*</span></label>
                                <select class="form-control select2bs4" id="edit_tinh_trang_hon_nhan" name="tinh_trang_hon_nhan" required>
                                    <option value="">-- Chọn Tình Trạng --</option>
                                    <option value="doc_than">Độc Thân</option>
                                    <option value="ket_hon">Kết Hôn</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ngay_tin_chua">Ngày Tin Chúa</label>
                                <input type="date" class="form-control" id="edit_ngay_tin_chua" name="ngay_tin_chua">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ngay_sinh_hoat_voi_hoi_thanh">Ngày Sinh Hoạt Với Hội Thánh</label>
                                <input type="date" class="form-control" id="edit_ngay_sinh_hoat_voi_hoi_thanh" name="ngay_sinh_hoat_voi_hoi_thanh">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ngay_nhan_bap_tem">Ngày Nhận Báp Têm</label>
                                <input type="date" class="form-control" id="edit_ngay_nhan_bap_tem" name="ngay_nhan_bap_tem">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_hoan_thanh_bap_tem">Hoàn Thành Báp Têm</label>
                                <select class="form-control select2bs4" id="edit_hoan_thanh_bap_tem" name="hoan_thanh_bap_tem">
                                    <option value="0">Không</option>
                                    <option value="1">Có</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_noi_xuat_than">Nơi Xuất Thân</label>
                                <input type="text" class="form-control" id="edit_noi_xuat_than" name="noi_xuat_than" placeholder="Nhập nơi xuất thân">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_cccd">CCCD</label>
                                <input type="text" class="form-control" id="edit_cccd" name="cccd" placeholder="Nhập số CCCD">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ma_dinh_danh_tinh">Mã Định Danh Tình</label>
                                <input type="text" class="form-control" id="edit_ma_dinh_danh_tinh" name="ma_dinh_danh_tinh" placeholder="Nhập mã định danh tình">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ngay_tham_vieng_gan_nhat">Ngày Thăm Viếng Gần Nhất</label>
                                <input type="date" class="form-control" id="edit_ngay_tham_vieng_gan_nhat" name="ngay_tham_vieng_gan_nhat">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_so_lan_vang_lien_tiep">Số Lần Vắng Liên Tiếp</label>
                                <input type="number" class="form-control" id="edit_so_lan_vang_lien_tiep" name="so_lan_vang_lien_tiep" placeholder="Nhập số lần vắng liên tiếp">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_moi_quan_he">Mối Quan Hệ Trong Gia Đình</label>
                                <select class="form-control select2bs4" id="edit_moi_quan_he" name="moi_quan_he">
                                    <option value="">-- Chọn Mối Quan Hệ --</option>
                                    <option value="cha">Cha</option>
                                    <option value="me">Mẹ</option>
                                    <option value="con">Con</option>
                                    <option value="anh">Anh</option>
                                    <option value="chi">Chị</option>
                                    <option value="em">Em</option>
                                    <option value="khac">Khác</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_vi_do">Vĩ Độ</label>
                                <input type="number" step="any" class="form-control" id="edit_vi_do" name="vi_do" placeholder="Nhập vĩ độ">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_kinh_do">Kinh Độ</label>
                                <input type="number" step="any" class="form-control" id="edit_kinh_do" name="kinh_do" placeholder="Nhập kinh độ">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_anh_dai_dien">Ảnh Đại Diện</label>
                                <input type="text" class="form-control" id="edit_anh_dai_dien" name="anh_dai_dien" placeholder="Nhập đường dẫn ảnh đại diện">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ban_nganh_id">Ban Ngành</label>
                                <select class="form-control select2bs4" id="edit_ban_nganh_id" name="ban_nganh_id">
                                    <option value="">-- Chọn Ban Ngành --</option>
                                    @foreach($banNganhs as $banNganh)
                                        <option value="{{ $banNganh->id }}">{{ $banNganh->ten }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_chuc_vu">Chức Vụ</label>
                                <select class="form-control select2bs4" id="edit_chuc_vu" name="chuc_vu">
                                    <option value="Thành viên">Thành viên</option>
                                    <option value="Trưởng ban">Trưởng ban</option>
                                    <option value="Phó ban">Phó ban</option>
                                    <option value="Thư ký">Thư ký</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>