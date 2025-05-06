{{-- 
    Partial Modal Xóa Thành Viên cho Ban Trung Lão 
    File lưu tại: resources/views/_ban_trung_lao/partials/_modal_xoa_thanh_vien.blade.php
--}}

<div class="modal fade" id="modal-xoa-thanh-vien">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Xóa Thành Viên</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa thành viên <strong id="delete_ten_tin_huu"></strong> khỏi Ban Trung Lão?
                </p>
                <input type="hidden" id="delete_tin_huu_id">
                <input type="hidden" id="delete_ban_nganh_id">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Xóa</button>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->