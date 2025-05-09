<ul class="nav nav-treeview">
    @php
        $banNames = [
            'trung_lao' => 'Ban Trung Lão',
            'thanh_trang' => 'Ban Thanh Tráng',
            'thanh_nien' => 'Ban Thanh Niên',
            'thieu_nhi' => 'Ban Thiếu Nhi Ấu',
        ];
    @endphp
    @foreach(['trung_lao', 'thanh_trang', 'thanh_nien', 'thieu_nhi'] as $ban)
        @if($isAdmin || in_array('view-ban-nganh-' . $ban, $userPermissions))
            <li class="nav-item {{ request()->routeIs('_ban_nganh.' . $ban . '.*') ? 'menu-open' : '' }}">
                <a href="{{ route('_ban_nganh.' . $ban . '.index') }}"
                   class="nav-link {{ request()->routeIs('_ban_nganh.' . $ban . '.*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ $banNames[$ban] }}</p>
                </a>
                <ul class="nav nav-treeview">
                    <!-- Tổng quan -->
                    <li class="nav-item">
                        <a href="{{ route('_ban_nganh.' . $ban . '.index') }}"
                           class="nav-link {{ request()->routeIs('_ban_nganh.' . $ban . '.index') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Tổng quan</p>
                        </a>
                    </li>
                    <!-- Quản lý Buổi Nhóm -->
                    @if($isAdmin || in_array('diem-danh-ban-nganh-' . $ban, $userPermissions) || in_array('phan-cong-ban-nganh-' . $ban, $userPermissions) || in_array('phan-cong-chi-tiet-ban-nganh-' . $ban, $userPermissions))
                        <li class="nav-item {{ request()->routeIs('_ban_nganh.' . $ban . '.diem_danh', '_ban_nganh.' . $ban . '.phan_cong', '_ban_nganh.' . $ban . '.phan_cong_chi_tiet') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Buổi Nhóm
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if($isAdmin || in_array('diem-danh-ban-nganh-' . $ban, $userPermissions))
                                    <li class="nav-item">
                                        <a href="{{ route('_ban_nganh.' . $ban . '.diem_danh') }}"
                                           class="nav-link {{ request()->routeIs('_ban_nganh.' . $ban . '.diem_danh') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Điểm danh</p>
                                        </a>
                                    </li>
                                @endif
                                @if($isAdmin || in_array('phan-cong-ban-nganh-' . $ban, $userPermissions))
                                    <li class="nav-item">
                                        <a href="{{ route('_ban_nganh.' . $ban . '.phan_cong') }}"
                                           class="nav-link {{ request()->routeIs('_ban_nganh.' . $ban . '.phan_cong') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Phân công</p>
                                        </a>
                                    </li>
                                @endif
                                @if($isAdmin || in_array('phan-cong-chi-tiet-ban-nganh-' . $ban, $userPermissions))
                                    <li class="nav-item">
                                        <a href="{{ route('_ban_nganh.' . $ban . '.phan_cong_chi_tiet') }}"
                                           class="nav-link {{ request()->routeIs('_ban_nganh.' . $ban . '.phan_cong_chi_tiet') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Phân công chi tiết</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    <!-- Thăm viếng -->
                    @if($isAdmin || in_array('tham-vieng-ban-nganh-' . $ban, $userPermissions))
                        <li class="nav-item">
                            <a href="{{ route('_ban_nganh.' . $ban . '.tham_vieng') }}"
                               class="nav-link {{ request()->routeIs('_ban_nganh.' . $ban . '.tham_vieng') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thăm viếng</p>
                            </a>
                        </li>
                    @endif
                    <!-- Báo Cáo -->
                    @if($isAdmin || in_array('nhap-lieu-bao-cao-ban-nganh-' . $ban, $userPermissions) || in_array('bao-cao-ban-nganh-' . $ban, $userPermissions))
                        <li class="nav-item {{ request()->routeIs('_ban_nganh.' . $ban . '.nhap_lieu_bao_cao', '_ban_nganh.' . $ban . '.bao_cao') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Báo Cáo
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if($isAdmin || in_array('nhap-lieu-bao-cao-ban-nganh-' . $ban, $userPermissions))
                                    <li class="nav-item">
                                        <a href="{{ route('_ban_nganh.' . $ban . '.nhap_lieu_bao_cao') }}"
                                           class="nav-link {{ request()->routeIs('_ban_nganh.' . $ban . '.nhap_lieu_bao_cao') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nhập liệu báo cáo</p>
                                        </a>
                                    </li>
                                @endif
                                @if($isAdmin || in_array('bao-cao-ban-nganh-' . $ban, $userPermissions))
                                    <li class="nav-item">
                                        <a href="{{ route('_ban_nganh.' . $ban . '.bao_cao') }}"
                                           class="nav-link {{ request()->routeIs('_ban_nganh.' . $ban . '.bao_cao') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Báo cáo</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
    @endforeach
    <!-- Các ban khác -->
    @foreach([
        // 'chap_su' => 'Ban Chấp Sự',
        // 'am_thuc' => 'Ban Ẩm Thực',
        // 'cau_nguyen' => 'Ban Cầu Nguyện',
        // 'chung_dao' => 'Ban Chứng Đạo',
        // 'dan' => 'Ban Đàn',
        // 'hau_can' => 'Ban Hậu Cần',
        // 'hat_tho_phuong' => 'Ban Hát Thờ Phượng',
        // 'khanh_tiet' => 'Ban Khánh Tiết',
        // 'ky_thuat_am_thanh' => 'Ban Kỹ Thuật - Âm Thanh',
        // 'le_tan' => 'Ban Lễ Tân',
        // 'may_chieu' => 'Ban Máy Chiếu',
        // 'tham_vieng' => 'Ban Thăm Viếng',
        // 'trat_tu' => 'Ban Trật Tự',
        // 'truyen_giang' => 'Ban Truyền Giảng',
        // 'truyen_thong_may_chieu' => 'Ban Truyền Thông - Máy Chiếu'
    ] as $ban => $label)
        @if($isAdmin || (Route::has('_ban_' . $ban . '.index') && in_array('view-ban-' . $ban, $userPermissions)))
            <li class="nav-item">
                <a href="{{ route('_ban_' . $ban . '.index') }}"
                   class="nav-link {{ request()->routeIs('_ban_' . $ban . '.*') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ $label }}</p>
                </a>
            </li>
        @endif
    @endforeach
</ul>