{{--
Partial Modal Cập Nhật Chức Vụ cho Ban Thanh Tráng
File lưu tại: resources/views/_ban_thanh_trang/partials/_modal_cap_nhat_chuc_vu.blade.php
--}}

<div class="modal fade" id="modal-edit-chuc-vu">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cập Nhật Chức Vụ</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-sua-chuc-vu" action="{{ route('api.ban_thanh_trang.cap_nhat_chuc_vu') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="tin_huu_id" id="edit_tin_huu_id">
                    <input type="hidden" name="ban_nganh_id" id="edit_ban_nganh_id">
                    <div class="form-group">
                        <label>Tín Hữu</label>
                        <p id="edit_ten_tin_huu" class="form-control-static font-weight-bold"></p>
                    </div>
                    <div class="form-group">
                        <label for="edit_chuc_vu">Chức Vụ</label>
                        <select class="form-control" name="chuc_vu" id="edit_chuc_vu" style="width: 100%">
                            <option value="">-- Thành viên --</option>
                            <option value="Cố Vấn Linh Vụ">Cố Vấn Linh Vụ</option>
                            <option value="Trưởng Ban">Trưởng Ban</option>
                            <option value="Thư Ký">Thư Ký</option>
                            <option value="Thủ Quỹ">Thủ Quỹ</option>
                            <option value="Ủy Viên">Ủy Viên</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->