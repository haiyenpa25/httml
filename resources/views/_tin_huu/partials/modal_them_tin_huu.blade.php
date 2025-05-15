<div class="modal fade" id="modal-them-tin-huu">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">
                    <i class="fas fa-user-plus mr-2"></i>Thêm Tín Hữu Mới
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-tin-huu">
                @csrf
                <div class="modal-body">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">
                                <i class="fas fa-info-circle mr-1"></i>Thông tin cơ bản
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="church-tab" data-toggle="tab" href="#church" role="tab" aria-controls="church" aria-selected="false">
                                <i class="fas fa-church mr-1"></i>Thông tin Hội Thánh
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="additional-tab" data-toggle="tab" href="#additional" role="tab" aria-controls="additional" aria-selected="false">
                                <i class="fas fa-clipboard-list mr-1"></i>Thông tin bổ sung
                            </a>
                        </li>
                    </ul>
                    
                    <div class="tab-content pt-3" id="myTabContent">
                        <!-- Tab thông tin cơ bản -->
                        <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ho_ten" class="control-label">Họ tên <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="ho_ten" name="ho_ten" placeholder="Nhập họ tên" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="ngay_sinh" class="control-label">Ngày Sinh <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                                            </div>
                                            <input type="date" class="form-control" id="ngay_sinh" name="ngay_sinh" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="gioi_tinh" class="control-label">Giới Tính <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                            </div>
                                            <select class="form-control select2bs4" id="gioi_tinh" name="gioi_tinh" required style="width: 100%;">
                                                <option value="">-- Chọn Giới Tính --</option>
                                                <option value="nam">Nam</option>
                                                <option value="nu">Nữ</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="so_dien_thoai" class="control-label">Số Điện Thoại <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" placeholder="Nhập số điện thoại" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="dia_chi" class="control-label">Địa Chỉ <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="dia_chi" name="dia_chi" placeholder="Nhập địa chỉ" required>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="tinh_trang_hon_nhan" class="control-label">Tình Trạng Hôn Nhân <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-heart"></i></span>
                                            </div>
                                            <select class="form-control select2bs4" id="tinh_trang_hon_nhan" name="tinh_trang_hon_nhan" required style="width: 100%;">
                                                <option value="">-- Chọn Tình Trạng --</option>
                                                <option value="doc_than">Độc Thân</option>
                                                <option value="ket_hon">Kết Hôn</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ho_gia_dinh_id" class="control-label">Hộ Gia Đình</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                                            </div>
                                            <select class="form-control select2bs4" id="ho_gia_dinh_id" name="ho_gia_dinh_id" style="width: 100%;">
                                                <option value="">-- Chọn Hộ Gia Đình --</option>
                                                @foreach($hoGiaDinhs as $hoGiaDinh)
                                                    <option value="{{ $hoGiaDinh->id }}">{{ $hoGiaDinh->so_ho }} - {{ $hoGiaDinh->dia_chi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="loai_tin_huu" class="control-label">Loại Tín Hữu <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-users"></i></span>
                                            </div>
                                            <select class="form-control select2bs4" id="loai_tin_huu" name="loai_tin_huu" required style="width: 100%;">
                                                <option value="">-- Chọn Loại Tín Hữu --</option>
                                                <option value="tin_huu_chinh_thuc">Tín Hữu Chính Thức</option>
                                                <option value="tan_tin_huu">Tân Tín Hữu</option>
                                                <option value="tin_huu_du_le">Tín Hữu Dự Lễ</option>
                                                <option value="tin_huu_ht_khac">Tín Hữu Hội Thánh Khác</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tab thông tin Hội Thánh -->
                        <div class="tab-pane fade" id="church" role="tabpanel" aria-labelledby="church-tab">
                            <div class="alert alert-info mb-3">
                                <i class="fas fa-info-circle mr-1"></i> Thông tin về hành trình đức tin và tham gia Hội Thánh
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ngay_tin_chua" class="control-label">Ngày Tin Chúa</label>
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
                                        <label for="ngay_sinh_hoat_voi_hoi_thanh" class="control-label">Ngày Sinh Hoạt Với Hội Thánh</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" class="form-control" id="ngay_sinh_hoat_voi_hoi_thanh" name="ngay_sinh_hoat_voi_hoi_thanh" value="{{ now()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ngay_nhan_bap_tem" class="control-label">Ngày Nhận Báp Têm</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-water"></i></span>
                                            </div>
                                            <input type="date" class="form-control" id="ngay_nhan_bap_tem" name="ngay_nhan_bap_tem">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hoan_thanh_bap_tem" class="control-label">Hoàn Thành Báp Têm</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                            </div>
                                            <select class="form-control select2bs4" id="hoan_thanh_bap_tem" name="hoan_thanh_bap_tem" style="width: 100%;">
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
                                        <label for="ban_nganh_id" class="control-label">Ban Ngành</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-sitemap"></i></span>
                                            </div>
                                            <select class="form-control select2bs4" id="ban_nganh_id" name="ban_nganh_id" style="width: 100%;">
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
                                        <label for="chuc_vu" class="control-label">Chức Vụ</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                            </div>
                                            <select class="form-control select2bs4" id="chuc_vu" name="chuc_vu" style="width: 100%;">
                                                <option value="Thành viên">Thành viên</option>
                                                <option value="Trưởng ban">Trưởng ban</option>
                                                <option value="Phó ban">Phó ban</option>
                                                <option value="Thư ký">Thư ký</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tab thông tin bổ sung -->
                        <div class="tab-pane fade" id="additional" role="tabpanel" aria-labelledby="additional-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="noi_xuat_than" class="control-label">Nơi Xuất Thân</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-landmark"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="noi_xuat_than" name="noi_xuat_than" placeholder="Nhập nơi xuất thân">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-right">
                        <span class="text-muted mr-2"><i class="fas fa-info-circle"></i> Các trường có dấu <span class="text-danger">*</span> là bắt buộc</span>
                    </div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i>Đóng
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i>Lưu Thông Tin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>