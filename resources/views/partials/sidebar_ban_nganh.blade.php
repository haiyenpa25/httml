<!-- Navigation for Ban Ngành management interface -->
<!-- Assumes $banType is passed to the view (e.g., 'trung_lao', 'thanh_trang', 'thanh_nien', 'thieu_nhi_au') -->
<ul class="nav nav-treeview">
    <!-- Tổng quan -->
    <li class="nav-item">
        <a href="{{ route('_ban_nganh.' . $banType . '.index') }}"
           class="nav-link {{ request()->routeIs('_ban_nganh.' . $banType . '.index') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Tổng quan</p>
        </a>
    </li>

    <!-- Quản lý Buổi Nhóm -->
    <li class="nav-item {{ request()->routeIs('_ban_nganh.' . $banType . '.diem_danh', '_ban_nganh.' . $banType . '.phan_cong', '_ban_nganh.' . $banType . '.phan_cong_chi_tiet') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>
                Buổi Nhóm
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('_ban_nganh.' . $banType . '.diem_danh') }}"
                   class="nav-link {{ request()->routeIs('_ban_nganh.' . $banType . '.diem_danh') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Điểm danh</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('_ban_nganh.' . $banType . '.phan_cong') }}"
                   class="nav-link {{ request()->routeIs('_ban_nganh.' . $banType . '.phan_cong') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Phân công</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('_ban_nganh.' . $banType . '.phan_cong_chi_tiet') }}"
                   class="nav-link {{ request()->routeIs('_ban_nganh.' . $banType . '.phan_cong_chi_tiet') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Phân công chi tiết</p>
                </a>
            </li>
        </ul>
    </li>

    <!-- Thăm viếng -->
    <li class="nav-item">
        <a href="{{ route('_ban_nganh.' . $banType . '.tham_vieng') }}"
           class="nav-link {{ request()->routeIs('_ban_nganh.' . $banType . '.tham_vieng') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Thăm viếng</p>
        </a>
    </li>

    <!-- Báo Cáo -->
    <li class="nav-item {{ request()->routeIs('_ban_nganh.' . $banType . '.nhap_lieu_bao_cao', '_ban_nganh.' . $banType . '.bao_cao') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>
                Báo Cáo
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('_ban_nganh.' . $banType . '.nhap_lieu_bao_cao') }}"
                   class="nav-link {{ request()->routeIs('_ban_nganh.' . $banType . '.nhap_lieu_bao_cao') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Nhập liệu báo cáo</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('_ban_nganh.' . $banType . '.bao_cao') }}"
                   class="nav-link {{ request()->routeIs('_ban_nganh.' . $banType . '.bao_cao') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Báo cáo</p>
                </a>
            </li>
        </ul>
    </li>
</ul>