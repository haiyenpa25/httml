<div class="modal fade" id="modal-them-tin-huu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm Tín Hữu Mới</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-tin-huu">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ho_ten">Họ tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ho_ten" name="ho_ten" placeholder="Nhập họ tên" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ngay_sinh">Ngày Sinh <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="ngay_sinh" name="ngay_sinh" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="so_dien_thoai">Số Điện Thoại <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dia_chi">Địa Chỉ <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="dia_chi" name="dia_chi" placeholder="Nhập địa chỉ" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="loai_tin_huu">Loại Tín Hữu <span class="text-danger">*</span></label>
                                <select class="form-control select2bs4" id="loai_tin_huu" name="loai_tin_huu" required>
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
                                <label for="gioi_tinh">Giới Tính <span class="text-danger">*</span></label>
                                <select class="form-control select2bs4" id="gioi_tinh" name="gioi_tinh" required>
                                    <option value="">-- Chọn Giới Tính --</option>
                                    <option value="nam">Nam</option>
                                    <option value="nu">Nữ</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tinh_trang_hon_nhan">Tình Trạng Hôn Nhân <span class="text-danger">*</span></label>
                                <select class="form-control select2bs4" id="tinh_trang_hon_nhan" name="tinh_trang_hon_nhan" required>
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
                                <label for="ho_gia_dinh_id">Hộ Gia Đình</label>
                                <select class="form-control select2bs4" id="ho_gia_dinh_id" name="ho_gia_dinh_id">
                                    <option value="">-- Chọn Hộ Gia Đình --</option>
                                    @foreach($hoGiaDinhs as $hoGiaDinh)
                                        <option value="{{ $hoGiaDinh->id }}">{{ $hoGiaDinh->so_ho }} - {{ $hoGiaDinh->dia_chi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ngay_tin_chua">Ngày Tin Chúa</label>
                                <input type="date" class="form-control" id="ngay_tin_chua" name="ngay_tin_chua">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ngay_sinh_hoat_voi_hoi_thanh">Ngày Sinh Hoạt Với Hội Thánh</label>
                                <input type="date" class="form-control" id="ngay_sinh_hoat_voi_hoi_thanh" name="ngay_sinh_hoat_voi_hoi_thanh" value="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ngay_nhan_bap_tem">Ngày Nhận Báp Têm</label>
                                <input type="date" class="form-control" id="ngay_nhan_bap_tem" name="ngay_nhan_bap_tem">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hoan_thanh_bap_tem">Hoàn Thành Báp Têm</label>
                                <select class="form-control select2bs4" id="hoan_thanh_bap_tem" name="hoan_thanh_bap_tem">
                                    <option value="0">Không</option>
                                    <option value="1">Có</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="noi_xuat_than">Nơi Xuất Thân</label>
                                <input type="text" class="form-control" id="noi_xuat_than" name="noi_xuat_than" placeholder="Nhập nơi xuất thân">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ban_nganh_id">Ban Ngành</label>
                                <select class="form-control select2bs4" id="ban_nganh_id" name="ban_nganh_id">
                                    <option value="">-- Chọn Ban Ngành --</option>
                                    @foreach($banNganhs as $banNganh)
                                        <option value="{{ $banNganh->id }}">{{ $banNganh->ten }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="chuc_vu">Chức Vụ</label>
                                <select class="form-control select2bs4" id="chuc_vu" name="chuc_vu">
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