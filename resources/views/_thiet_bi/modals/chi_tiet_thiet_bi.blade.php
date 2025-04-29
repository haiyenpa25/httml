<!-- Modal Chi Tiết Thiết Bị -->
<div class="modal fade" id="modal-chi-tiet-thiet-bi">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Chi Tiết Thiết Bị</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 text-center mb-3">
                        <img id="detail_image" src="{{ asset('img/no-image.png') }}" alt="Hình ảnh thiết bị"
                            class="img-fluid" style="max-height: 200px;">
                    </div>
                    <div class="col-md-7">
                        <h4 id="detail_ten" class="mb-3"></h4>
                        <p><strong>Mã tài sản:</strong> <span id="detail_ma_tai_san">N/A</span></p>
                        <p><strong>Loại thiết bị:</strong> <span id="detail_loai"></span></p>
                        <p><strong>Tình trạng:</strong> <span id="detail_tinh_trang"></span></p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <p><strong>Ban ngành quản lý:</strong> <span id="detail_ban_nganh">N/A</span></p>
                        <p><strong>Người quản lý:</strong> <span id="detail_nguoi_quan_ly">N/A</span></p>
                        <p><strong>Vị trí hiện tại:</strong> <span id="detail_vi_tri">N/A</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Ngày mua:</strong> <span id="detail_ngay_mua">N/A</span></p>
                        <p><strong>Giá trị:</strong> <span id="detail_gia_tri">N/A</span></p>
                        <p><strong>Nhà cung cấp:</strong> <span id="detail_nha_cung_cap">N/A</span></p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <p><strong>Thời gian bảo hành:</strong> <span id="detail_bao_hanh">N/A</span></p>
                        <p><strong>Chu kỳ bảo trì:</strong> <span id="detail_chu_ky_bao_tri">N/A</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Ngày hết hạn sử dụng:</strong> <span id="detail_ngay_het_han">N/A</span></p>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <strong>Mô tả:</strong>
                        <p id="detail_mo_ta" class="mt-2">N/A</p>
                    </div>
                </div>

                <!-- Tab Lịch sử bảo trì -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="detail-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="detail-bao-tri-tab" data-toggle="pill"
                                            href="#detail-bao-tri" role="tab" aria-controls="detail-bao-tri"
                                            aria-selected="true">Lịch sử bảo trì</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="detail-tabContent">
                                    <div class="tab-pane fade show active" id="detail-bao-tri" role="tabpanel"
                                        aria-labelledby="detail-bao-tri-tab">
                                        <div class="d-flex justify-content-end mb-3">
                                            <button class="btn btn-sm btn-primary" id="btn-add-bao-tri">
                                                <i class="fas fa-plus"></i> Thêm lịch sử bảo trì
                                            </button>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped"
                                                id="table-lich-su-bao-tri">
                                                <thead>
                                                    <tr>
                                                        <th>Ngày bảo trì</th>
                                                        <th>Chi phí</th>
                                                        <th>Người thực hiện</th>
                                                        <th>Mô tả</th>
                                                        <th style="width: 100px">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detail_bao_tri_list">
                                                    <!-- Dữ liệu sẽ được nạp bằng JavaScript -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="btn-edit-thiet-bi">Chỉnh sửa</button>
            </div>
        </div>
    </div>
</div>