<div class="modal fade" id="modal-xoa-tin-huu" tabindex="-1" aria-labelledby="modal-xoa-tin-huu-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title" id="modal-xoa-tin-huu-label">
                    <i class="fas fa-trash-alt mr-2"></i>Xác nhận xóa
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle text-danger" style="font-size: 5rem;"></i>
                </div>
                <p class="text-center">Bạn có chắc chắn muốn xóa tín hữu <strong id="delete_name"></strong>?</p>
                <input type="hidden" id="delete_id">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>Đóng
                </button>
                <button type="button" class="btn btn-danger" id="confirm-delete">
                    <i class="fas fa-trash-alt mr-1"></i>Xóa
                </button>
            </div>
        </div>
    </div>
</div>