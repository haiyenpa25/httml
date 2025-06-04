<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="roleForm" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="roleModalLabel">Thêm vai trò</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="role_id" name="id">
                    <div class="form-group">
                        <label for="name">Tên vai trò</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="guard_name">Guard</label>
                        <select class="form-control" id="guard_name" name="guard_name">
                            <option value="web">web</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" id="saveRole">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>