<div class="action-btns">
    {{-- @can('edit-lop-hoc') --}}
        <a href="{{ route('lop-hoc.edit', $lopHoc->id) }}" class="btn btn-warning btn-icon" title="Sửa">
            <i class="fas fa-edit"></i>
        </a>
    {{-- @endcan --}}
    {{-- @can('delete-lop-hoc') --}}
        <button class="btn btn-danger btn-icon btn-xoa-lop-hoc" data-lop-hoc-id="{{ $lopHoc->id }}" data-ten-lop="{{ $lopHoc->ten_lop }}" title="Xóa">
            <i class="fas fa-trash"></i>
        </button>
    {{-- @endcan --}}
    {{-- @can('manage-hoc-vien') --}}
        <button class="btn btn-primary btn-icon btn-them-hoc-vien" data-lop-hoc-id="{{ $lopHoc->id }}" title="Thêm học viên" data-toggle="modal" data-target="#themHocVienModal">
            <i class="fas fa-user-plus"></i>
        </button>
    {{-- @endcan --}}
</div>