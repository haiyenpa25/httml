<!-- Modal Thêm/Sửa Lịch Sử Bảo Trì -->
<div class="modal fade" id="modal-bao-tri">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="bao-tri-title">Thêm Lịch Sử Bảo Trì</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-bao-tri">
                @csrf
                <input type="hidden" id="bao_tri_id" name="id">
                <input type="hidden" id="bao_tri_thiet_bi_id" name="thiet_bi_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ngay_bao_tri">Ngày Bảo Trì <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="ngay_bao_tri" name="ngay_bao_tri" required>
                    </div>
                    <div class="form-group">
                        <label for="chi_phi">Chi Phí (VNĐ)</label>
                        <input type="number" class="form-control" id="chi_phi" name="chi_phi" min="0" step="1000">
                    </div>
                    <div class="form-group">
                        <label for="nguoi_thuc_hien">Người Thực Hiện <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nguoi_thuc_hien" name="nguoi_thuc_hien" required>
                    </div>
                    <div class="form-group">
                        <label for="mo_ta_bao_tri">Mô Tả</label>
                        <textarea class="form-control" id="mo_ta_bao_tri" name="mo_ta" rows="3"></textarea>
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