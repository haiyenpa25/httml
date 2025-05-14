@php
    // Mặc định banType là 'co_doc_giao_duc' nếu không được truyền
    $banType = isset($banType) ? $banType : 'co_doc_giao_duc';
@endphp

<!-- Navigation for Ban Ngành management interface -->
<ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
    <!-- Tổng quan -->
    <li class="nav-item">
        <a href="{{ route('_ban_' . $banType . '.index', ['banType' => 'ban-co-doc-giao-duc']) }}"
           class="nav-link {{ request()->routeIs('_ban_' . $banType . '.index') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Tổng quan</p>
        </a>
    </li>

    <!-- Điểm danh -->
    <li class="nav-item">
        <a href="{{ route('_ban_' . $banType . '.diem_danh', ['banType' => 'ban-co-doc-giao-duc']) }}"
           class="nav-link {{ request()->routeIs('_ban_' . $banType . '.diem_danh') ? 'active' : '' }}">
            <i class="nav-icon fas fa-check-square"></i>
            <p>Điểm danh</p>
        </a>
    </li>

    <!-- Phân công -->
    <li class="nav-item">
        <a href="{{ route('_ban_' . $banType . '.phan_cong', ['banType' => 'ban-co-doc-giao-duc']) }}"
           class="nav-link {{ request()->routeIs('_ban_' . $banType . '.phan_cong') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tasks"></i>
            <p>Phân công</p>
        </a>
    </li>

    <!-- Phân công chi tiết -->
    <li class="nav-item">
        <a href="{{ route('_ban_' . $banType . '.phan_cong_chi_tiet', ['banType' => 'ban-co-doc-giao-duc']) }}"
           class="nav-link {{ request()->routeIs('_ban_' . $banType . '.phan_cong_chi_tiet') ? 'active' : '' }}">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>Phân công chi tiết</p>
        </a>
    </li>

    <!-- Nhập liệu báo cáo -->
    <li class="nav-item">
        <a href="{{ route('_ban_' . $banType . '.nhap_lieu_bao_cao', ['banType' => 'ban-co-doc-giao-duc']) }}"
           class="nav-link {{ request()->routeIs('_ban_' . $banType . '.nhap_lieu_bao_cao') ? 'active' : '' }}">
            <i class="nav-icon fas fa-edit"></i>
            <p>Nhập liệu báo cáo</p>
        </a>
    </li>

    <!-- Báo cáo -->
    <li class="nav-item">
        <a href="{{ route('_ban_' . $banType . '.bao_cao', ['banType' => 'ban-co-doc-giao-duc']) }}"
           class="nav-link {{ request()->routeIs('_ban_' . $banType . '.bao_cao') ? 'active' : '' }}">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>Báo cáo</p>
        </a>
    </li>
</ul>