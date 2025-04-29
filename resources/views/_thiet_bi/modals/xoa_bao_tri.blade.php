<!-- Modal Xóa Lịch Sử Bảo Trì -->
<div class="modal fade" id="modal-xoa-bao-tri">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Xác nhận xóa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa lịch sử bảo trì này?</p>
                <input type="hidden" id="delete_bao_tri_id">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-bao-tri">Xóa</button>
            </div>
        </div>
    </div>
</div>