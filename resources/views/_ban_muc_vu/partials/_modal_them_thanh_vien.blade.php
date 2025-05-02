<div class="modal fade" id="modal-them-thanh-vien">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm Thành Viên</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="form-them-thanh-vien" action="{{ route('api.ban_muc_vu.them_thanh_vien') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="ban_nganh_id" value="{{ $banNganh->id }}">
                    <div class="form-group">
                        <label for="tin_huu_id">Chọn Tín Hữu <span class="text-danger">*</span></label>
                        <select class="form-control select2bs4" name="tin_huu_id" id="tin_huu_id" required
                            style="width: 100%">
                            <option value="">-- Chọn Tín Hữu --</option>
                            @foreach($tinHuuList as $tinHuu)
                                <option value="{{ $tinHuu->id }}">{{ $tinHuu->ho_ten }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="chuc_vu">Chức Vụ</label>
                        <select class="form-control" name="chuc_vu" id="chuc_vu" style="width: 100%">
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
    </div>
</div>