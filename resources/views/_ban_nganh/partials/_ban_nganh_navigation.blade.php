@php
    // Ánh xạ URL segment sang banType
    $urlSegment = request()->segment(2);
    $banTypeMap = [
        'ban-trung-lao' => 'trung_lao',
        'ban-thanh-trang' => 'thanh_trang',
        'ban-thanh-nien' => 'thanh_nien',
        'ban-thieu-nhi' => 'thieu_nhi',
        'ban-thieu-nhi-au' => 'thieu_nhi_au',
    ];
    $banType = $banTypeMap[$urlSegment] ?? 'trung_lao'; // Mặc định là trung_lao nếu không tìm thấy
@endphp

@section('page-scripts')
    <script>
        $(document).ready(function () {
            // Xử lý nút active dựa trên URL hiện tại
            $('.action-btn').each(function () {
                var href = $(this).attr('href');
                var currentPath = window.location.pathname;
                if (href === currentPath) {
                    $(this).addClass('active');
                }
            });
        });
    </script>
@endsection

<div class="action-buttons-container">
    <!-- Hàng 1: Chức năng điều hướng chính -->
    <div class="button-row">
        <a href="{{ route('_ban_nganh.index', ['ban' => $urlSegment]) }}" class="action-btn btn-primary-custom">
            <i class="fas fa-home"></i> Trang chính
        </a>
        <a href="{{ route('_ban_nganh.' . $banType . '.diem_danh') }}" class="action-btn btn-success-custom">
            <i class="fas fa-clipboard-check"></i> Điểm danh
        </a>
        <a href="{{ route('_ban_nganh.' . $banType . '.tham_vieng') }}" class="action-btn btn-info-custom">
            <i class="fas fa-user-friends"></i> Thăm viếng
        </a>
        <a href="{{ route('_ban_nganh.' . $banType . '.phan_cong') }}" class="action-btn btn-warning-custom">
            <i class="fas fa-tasks"></i> Phân công
        </a>
    </div>

    <!-- Hàng 2: Chức năng phân công và báo cáo -->
    <div class="button-row">
        <a href="{{ route('_ban_nganh.' . $banType . '.phan_cong_chi_tiet') }}" class="action-btn btn-info-custom">
            <i class="fas fa-clipboard-list"></i> Chi tiết PC
        </a>
        <a href="{{ route('_ban_nganh.' . $banType . '.nhap_lieu_bao_cao') }}" class="action-btn btn-success-custom">
            <i class="fas fa-file-alt"></i> Nhập báo cáo
        </a>
        <a href="{{ route('_bao_cao.ban_nganh.' . $banType) }}" class="action-btn btn-success-custom">
            <i class="fas fa-file-alt"></i> Báo cáo
        </a>
        <button type="button" class="action-btn btn-success-custom" data-toggle="modal" data-target="#modal-them-thanh-vien">
            <i class="fas fa-user-plus"></i> Thêm thành viên
        </button>
    </div>

    <!-- Hàng 3: Chức năng quản lý -->
    <div class="button-row">
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