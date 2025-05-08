<!-- Navigation for Ban Ngành management interface -->
<!-- Assumes $banType is passed to the view (e.g., 'trung_lao', 'thanh_trang', 'thanh_nien', 'thieu_nhi_au') -->
<!-- Ensure all route names match those defined in routes/ban_nganh.php -->

<ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
    <!-- Dashboard -->
    <li class="nav-item">
        <a href="{{ route('_ban_nganh.' . $banType . '.index') }}"
            class="nav-link {{ request()->routeIs('_ban_nganh.' . $banType . '.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Tổng quan</p>
        </a>
    </li>

    <!-- Attendance Management -->
    <li class="nav-item">
        <a href="{{ route('_ban_nganh.' . $banType . '.diem_danh') }}"
            class="nav-link {{ request()->routeIs('_ban_nganh.' . $banType . '.diem_danh') ? 'active' : '' }}">
            <i class="nav-icon fas fa-check-square"></i>
            <p>Điểm danh</p>
        </a>
    </li>

    <!-- Visitation Management -->
    <li class="nav-item">
        <a href="{{ route('_ban_nganh.' . $banType . '.tham_vieng') }}"
            class="nav-link {{ request()->routeIs('_ban_nganh.' . $banType . '.tham_vieng') ? 'active' : '' }}">
            <i class="nav-icon fas fa-handshake"></i>
            <p>Thăm viếng</p>
        </a>
    </li>

    <!-- Task Assignment -->
    <li class="nav-item">
        <a href="{{ route('_ban_nganh.' . $banType . '.phan_cong') }}"
            class="nav-link {{ request()->routeIs('_ban_nganh.' . $banType . '.phan_cong') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tasks"></i>
            <p>Phân công</p>
        </a>
    </li>

    <!-- Detailed Task Assignment -->
    <li class="nav-item">
        <a href="{{ route('_ban_nganh.' . $banType . '.phan_cong_chi_tiet') }}"
            class="nav-link {{ request()->routeIs('_ban_nganh.' . $banType . '.phan_cong_chi_tiet') ? 'active' : '' }}">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>Phân công chi tiết</p>
        </a>
    </li>

    <!-- Report Input -->
    <li class="nav-item">
        <a href="{{ route('_ban_nganh.' . $banType . '.nhap_lieu_bao_cao') }}"
            class="nav-link {{ request()->routeIs('_ban_nganh.' . $banType . '.nhap_lieu_bao_cao') ? 'active' : '' }}">
            <i class="nav-icon fas fa-edit"></i>
            <p>Nhập liệu báo cáo</p>
        </a>
    </li>

    <!-- Report Overview -->
    <li class="nav-item">
        <a href="{{ route('_ban_nganh.' . $banType . '.bao_cao') }}"
            class="nav-link {{ request()->routeIs('_ban_nganh.' . $banType . '.bao_cao') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>Báo cáo</p>
        </a>
    </li>
</ul>