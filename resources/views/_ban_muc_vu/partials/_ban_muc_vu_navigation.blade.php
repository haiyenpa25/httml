<div class="action-buttons-container">
    <!-- Hàng 1: Chức năng điều hướng chính -->
    <div class="button-row">
        <a href="{{ route('ban_muc_vu.index', ['ban_nganh_id' => $ban_nganh_id]) }}"
            class="action-btn btn-primary-custom">
            <i class="fas fa-home"></i> Trang chính
        </a>
        <a href="{{ route('ban_muc_vu.diem_danh', ['ban_nganh_id' => $ban_nganh_id]) }}"
            class="action-btn btn-success-custom">
            <i class="fas fa-clipboard-check"></i> Điểm danh
        </a>
        <a href="{{ route('ban_muc_vu.tham_vieng', ['ban_nganh_id' => $ban_nganh_id]) }}"
            class="action-btn btn-info-custom">
            <i class="fas fa-user-friends"></i> Thăm viếng
        </a>
    </div>

    <!-- Hàng 2: Chức năng phân công và báo cáo -->
    <div class="button-row">
        <a href="{{ route('ban_muc_vu.phan_cong', ['ban_nganh_id' => $ban_nganh_id]) }}"
            class="action-btn btn-warning-custom">
            <i class="fas fa-tasks"></i> Phân công
        </a>
        <a href="{{ route('ban_muc_vu.phan_cong_chi_tiet', ['ban_nganh_id' => $ban_nganh_id]) }}"
            class="action-btn btn-info-custom">
            <i class="fas fa-clipboard-list"></i> Chi tiết PC
        </a>
        <a href="{{ route('ban_muc_vu.nhap_lieu_bao_cao', ['ban_nganh_id' => $ban_nganh_id]) }}"
            class="action-btn btn-success-custom">
            <i class="fas fa-file-alt"></i> Nhập báo cáo
        </a>
    </div>

    <!-- Hàng 3: Chức năng quản lý -->
    <div class="button-row">
        <button type="button" class="action-btn btn-success-custom" data-toggle="modal"
            data-target="#modal-them-thanh-vien">
            <i class="fas fa-user-plus"></i> Thêm thành viên
        </button>
        <button type="button" class="action-btn btn-info-custom" id="btn-refresh">
            <i class="fas fa-sync"></i> Tải lại
        </button>
        <button type="button" class="action-btn btn-primary-custom" id="btn-export">
            <i class="fas fa-file-excel"></i> Xuất Excel
        </button>
    </div>
</div>

<style>
    /* Kiểu cho nút đang được active */
    .action-btn.active {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .action-btn.active:after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: 40%;
        height: 3px;
        background-color: rgba(255, 255, 255, 0.7);
        border-radius: 3px;
    }

    /* Tối ưu hóa cho thiết bị di động */
    @media (max-width: 767px) {
        .action-btn.active:after {
            bottom: -3px;
            height: 2px;
        }
    }
</style>