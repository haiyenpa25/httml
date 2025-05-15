<div class="modal fade" id="modal-them-tin-huu" tabindex="-1" aria-labelledby="modal-them-tin-huu-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title" id="modal-them-tin-huu-label">
                    <i class="fas fa-user-plus mr-2"></i>Thêm Tín Hữu Mới
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-them-tin-huu">
                @csrf
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="true">
                                <i class="fas fa-info-circle mr-1"></i>Thông tin cơ bản
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="hoi-thanh-tab" data-toggle="tab" href="#hoi-thanh" role="tab" aria-controls="hoi-thanh" aria-selected="false">
                                <i class="fas fa-church mr-1"></i>Thông tin Hội Thánh
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="bo-sung-tab" data-toggle="tab" href="#bo-sung" role="tab" aria-controls="bo-sung" aria-selected="false">
                                <i class="fas fa-clipboard-list mr-1"></i>Thông tin bổ sung
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <!-- Tab Thông tin cơ bản -->
                        <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ho_ten" class="required">Họ tên</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="ho_ten" name="ho_ten" placeholder="Nhập họ tên" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="ngay_sinh" class="required">Ngày Sinh</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" id="ngay_sinh" name="ngay_sinh" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="gioi_tinh" class="required">Giới Tính</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                            </div>
                                            <select class="form-control" id="gioi_tinh" name="gioi_tinh" required>
                                                <option value="">-- Chọn Giới Tính --</option>
                                                <option value="nam">Nam</option>
                                                <option value="nu">Nữ</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="so_dien_thoai" class="required">Số Điện Thoại</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="dia_chi" class="required">Địa Chỉ</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="dia_chi" name="dia_chi" placeholder="Nhập địa chỉ" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="tinh_trang_hon_nhan" class="required">Tình Trạng Hôn Nhân</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-ring"></i></span>
                                            </div>
                                            <select class="form-control" id="tinh_trang_hon_nhan" name="tinh_trang_hon_nhan" required>
                                                <option value="">-- Chọn Tình Trạng --</option>
                                                <option value="doc_than">Độc Thân</option>
                                                <option value="ket_hon">Kết Hôn</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Thông tin Hội Thánh -->
                        <div class="tab-pane fade" id="hoi-thanh" role="tabpanel" aria-labelledby="hoi-thanh-tab">
                            <p class="text-muted">Thông tin về hành trình đức tin và tham gia Hội Thánh</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ho_gia_dinh_id">Hộ Gia Đình</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                                            </div>
                                            <select class="form-control select2bs4" id="ho_gia_dinh_id" name="ho_gia_dinh_id">
                                                <option value="">-- Chọn Hộ Gia Đình --</option>
                                                @foreach($hoGiaDinhs as $hoGiaDinh)
                                                    <option value="{{ $hoGiaDinh->id }}">{{ $hoGiaDinh->so_ho }} - {{ $hoGiaDinh->dia_chi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="loai_tin_huu" class="required">Loại Tín Hữu</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                                            </div>
                                            <select class="form-control" id="loai_tin_huu" name="loai_tin_huu" required>
                                                <option value="">-- Chọn Loại Tín Hữu --</option>
                                                <option value="tin_huu_chinh_thuc">Tín Hữu Chính Thức</option>
                                                <option value="tan_tin_huu">Tân Tín Hữu</option>
                                                <option value="tin_huu_du_le">Tín Hữu Dự Lễ</option>
                                                <option value="tin_huu_ht_khac">Tín Hữu Hội Thánh Khác</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="ngay_tin_chua">Ngày Tin Chúa</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-cross"></i></span>
                                            </div>
                                            <input type="date" class="form-control" id="ngay_tin_chua" name="ngay_tin_chua">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ngay_sinh_hoat">Ngày Sinh Hoạt Với Hội Thánh</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-church"></i></span>
                                            </div>
                                            <input type="date" class="form-control" id="ngay_sinh_hoat" name="ngay_sinh_hoat">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="ngay_nhan_bap_tem">Ngày Nhận Báp Têm</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-water"></i></span>
                                            </div>
                                            <input type="date" class="form-control" id="ngay_nhan_bap_tem" name="ngay_nhan_bap_tem">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="hoan_thanh_bap_tem">Hoàn Thành Báp Têm</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                            </div>
                                            <select class="form-control" id="hoan_thanh_bap_tem" name="hoan_thanh_bap_tem">
                                                <option value="0">Không</option>
                                                <option value="1">Có</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ban_nganh_id">Ban Ngành</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-users"></i></span>
                                            </div>
                                            <select class="form-control select2bs4" id="ban_nganh_id" name="ban_nganh_id">
                                                <option value="">-- Chọn Ban Ngành --</option>
                                                @foreach($banNganhs as $banNganh)
                                                    <option value="{{ $banNganh->id }}">{{ $banNganh->ten }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="chuc_vu">Chức Vụ</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                            </div>
                                            <select class="form-control" id="chuc_vu" name="chuc_vu">
                                                <option value="thanh_vien">Thành viên</option>
                                                <option value="truong_ban">Trưởng ban</option>
                                                <option value="pho_ban">Phó ban</option>
                                                <option value="thu_ky">Thư ký</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab Thông tin bổ sung -->
                        <div class="tab-pane fade" id="bo-sung" role="tabpanel" aria-labelledby="bo-sung-tab">
                            <div class="form-group">
                                <label for="noi_xuat_than">Nơi Xuất Thân</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="noi_xuat_than" name="noi_xuat_than" placeholder="Nhập nơi xuất thân">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <small class="text-muted">Các trường có dấu * là bắt buộc</small>
                    <div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i>Đóng
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>Lưu Thông Tin
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>