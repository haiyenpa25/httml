<ul class="nav nav-treeview">
    @php
        $banIcons = [
            'trung_lao' => 'fas fa-user-friends',
            'thanh_trang' => 'fas fa-user-tie',
            'thanh_nien' => 'fas fa-user-graduate',
            'thieu_nhi' => 'fas fa-child',
            'co_doc_giao_duc' => 'fas fa-book-reader',
        ];
        
        $banNames = [
            'trung_lao' => 'Ban Trung Lão',
            'thanh_trang' => 'Ban Thanh Tráng',
            'thanh_nien' => 'Ban Thanh Niên',
            'thieu_nhi' => 'Ban Thiếu Nhi Ấu',
            'co_doc_giao_duc' => 'Ban Cơ Đốc Giáo Dục',
        ];
        
        $banColors = [
            'trung_lao' => 'text-info',
            'thanh_trang' => 'text-success',
            'thanh_nien' => 'text-primary',
            'thieu_nhi' => 'text-warning',
            'co_doc_giao_duc' => 'text-purple',
        ];
    @endphp
    
    @foreach(['trung_lao', 'thanh_trang', 'thanh_nien', 'thieu_nhi', 'co_doc_giao_duc'] as $ban)
        @if($isAdmin || in_array('view-ban-nganh-' . $ban, $userPermissions))
            <li class="nav-item {{ request()->routeIs($ban == 'co_doc_giao_duc' ? '_ban_co_doc_giao_duc.*' : '_ban_nganh.' . $ban . '.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs($ban == 'co_doc_giao_duc' ? '_ban_co_doc_giao_duc.*' : '_ban_nganh.' . $ban . '.*') ? 'active' : '' }}">
                    <i class="{{ $banIcons[$ban] ?? 'far fa-circle' }} nav-icon {{ $banColors[$ban] ?? '' }}"></i>
                    <p>
                        {{ $banNames[$ban] }}
                        <i class="fas fa-angle-left right"></i>
                        @if(request()->routeIs($ban == 'co_doc_giao_duc' ? '_ban_co_doc_giao_duc.*' : '_ban_nganh.' . $ban . '.*'))
                            <span class="badge badge-primary right">
                                {{ count(array_filter([
                                    in_array('diem-danh-ban-' . ($ban == 'co_doc_giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban), $userPermissions),
                                    in_array('phan-cong-ban-' . ($ban == 'co_doc_giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban), $userPermissions),
                                    in_array('phan-cong-chi-tiet-ban-' . ($ban == 'co_doc_giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban), $userPermissions),
                                    in_array('nhap-lieu-bao-cao-ban-' . ($ban == 'co_doc_giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban), $userPermissions),
                                    in_array('bao-cao-ban-' . ($ban == 'co_doc_giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban), $userPermissions),
                                ])) }}
                            </span>
                        @endif
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <!-- Tổng quan -->
                    <li class="nav-item">
                        <a href="{{ route($ban == 'co_doc_giao_duc' ? '_ban_co_doc_giao_duc.index' : '_ban_nganh.' . $ban . '.index', $ban == 'co_doc_giao_duc' ? ['banType' => 'ban-co-doc-giao-duc'] : []) }}"
                           class="nav-link {{ request()->routeIs($ban == 'co_doc_giao_duc' ? '_ban_co_doc_giao_duc.index' : '_ban_nganh.' . $ban . '.index') ? 'active' : '' }}">
                            <i class="fas fa-th-large nav-icon"></i>
                            <p>Tổng quan</p>
                        </a>
                    </li>
                    
                    <!-- Tính năng -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-puzzle-piece nav-icon"></i>
                            <p>Tính năng</p>
                        </a>
                    </li>
                    
                    <!-- Điểm danh -->
                    @if($isAdmin || in_array('diem-danh-ban-' . ($ban == 'co_doc_giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban), $userPermissions))
                        <li class="nav-item">
                            <a href="{{ route($ban == 'co_doc_giao_duc' ? '_ban_co_doc_giao_duc.diem_danh' : '_ban_nganh.' . $ban . '.diem_danh', $ban == 'co_doc_giao_duc' ? ['banType' => 'ban-co-doc-giao-duc'] : []) }}"
                               class="nav-link {{ request()->routeIs($ban == 'co_doc_giao_duc' ? '_ban_co_doc_giao_duc.diem_danh' : '_ban_nganh.' . $ban . '.diem_danh') ? 'active' : '' }}">
                                <i class="fas fa-clipboard-check nav-icon"></i>
                                <p>Điểm danh</p>
                            </a>
                        </li>
                    @endif
                    
                    <!-- Phân công -->
                    @if($isAdmin || in_array('phan-cong-ban-' . ($ban == 'co_doc_giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban), $userPermissions))
                        <li class="nav-item">
                            <a href="{{ route($ban == 'co_doc_giao_duc' ? '_ban_co_doc_giao_duc.phan_cong' : '_ban_nganh.' . $ban . '.phan_cong', $ban == 'co_doc_giao_duc' ? ['banType' => 'ban-co-doc-giao-duc'] : []) }}"
                               class="nav-link {{ request()->routeIs($ban == 'co_doc_giao_duc' ? '_ban_co_doc_giao_duc.phan_cong' : '_ban_nganh.' . $ban . '.phan_cong') ? 'active' : '' }}">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p>Phân công</p>
                            </a>
                        </li>
                    @endif
                    
                    <!-- Phân công chi tiết -->
                    @if($isAdmin || in_array('phan-cong-chi-tiet-ban-' . ($ban == 'co_doc_giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban), $userPermissions))
                        <li class="nav-item">
                            <a href="{{ route($ban == 'co_doc_giao_duc' ? '_ban_co_doc_giao_duc.phan_cong_chi_tiet' : '_ban_nganh.' . $ban . '.phan_cong_chi_tiet', $ban == 'co_doc_giao_duc' ? ['banType' => 'ban-co-doc-giao-duc'] : []) }}"
                               class="nav-link {{ request()->routeIs($ban == 'co_doc_giao_duc' ? '_ban_co_doc_giao_duc.phan_cong_chi_tiet' : '_ban_nganh.' . $ban . '.phan_cong_chi_tiet') ? 'active' : '' }}">
                                <i class="fas fa-list-check nav-icon"></i>
                                <p>Phân công chi tiết</p>
                            </a>
                        </li>
                    @endif
                    
                    <!-- Báo Cáo -->
                    @if($isAdmin || in_array('nhap-lieu-bao-cao-ban-' . ($ban == 'co_doc_giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban), $userPermissions) || in_array('bao-cao-ban-' . ($ban == 'co_doc_giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban), $userPermissions))
                        <li class="nav-item {{ request()->routeIs($ban == 'co_doc_giao_duc' ? ['_ban_co_doc_giao_duc.nhap_lieu_bao_cao', '_ban_co_doc_giao_duc.bao_cao'] : ['_ban_nganh.' . $ban . '.nhap_lieu_bao_cao', '_ban_nganh.' . $ban . '.bao_cao']) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs($ban == 'co_doc_giao_duc' ? ['_ban_co_doc_giao_duc.nhap_lieu_bao_cao', '_ban_co_doc_giao_duc.bao_cao'] : ['_ban_nganh.' . $ban . '.nhap_lieu_bao_cao', '_ban_nganh.' . $ban . '.bao_cao']) ? 'active' : '' }}">
                                <i class="fas fa-chart-line nav-icon"></i>
                                <p>
                                    Báo Cáo
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if($isAdmin || in_array('nhap-lieu-bao-cao-ban-' . ($ban == 'co_doc_giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban), $userPermissions))
                                    <li class="nav-item">
                                        <a href="{{ route($ban == 'co_doc_giao_duc' ? '_ban_co_doc_giao_duc.nhap_lieu_bao_cao' : '_ban_nganh.' . $ban . '.nhap_lieu_bao_cao', $ban == 'co_doc_giao_duc' ? ['banType' => 'ban-co-doc-giao-duc'] : []) }}"
                                           class="nav-link {{ request()->routeIs($ban == 'co_doc_giao_duc' ? '_ban_co_doc_giao_duc.nhap_lieu_bao_cao' : '_ban_nganh.' . $ban . '.nhap_lieu_bao_cao') ? 'active' : '' }}">
                                            <i class="fas fa-keyboard nav-icon"></i>
                                            <p>Nhập liệu báo cáo</p>
                                        </a>
                                    </li>
                                @endif
                                @if($isAdmin || in_array('bao-cao-ban-' . ($ban == 'co_doc_giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban), $userPermissions))
                                    <li class="nav-item">
                                        <a href="{{ route($ban == 'co_doc_giao_duc' ? '_ban_co_doc_giao_duc.bao_cao' : '_ban_nganh.' . $ban . '.bao_cao', $ban == 'co_doc_giao_duc' ? ['banType' => 'ban-co-doc-giao-duc'] : []) }}"
                                           class="nav-link {{ request()->routeIs($ban == 'co_doc_giao_duc' ? '_ban_co_doc_giao_duc.bao_cao' : '_ban_nganh.' . $ban . '.bao_cao') ? 'active' : '' }}">
                                            <i class="fas fa-file-alt nav-icon"></i>
                                            <p>Xem báo cáo</p>
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

    <!-- Các Ban Khác -->
    @if($isAdmin || in_array('view-ban-nganh', $userPermissions))
        <li class="nav-item {{ request()->routeIs('_ban_*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('_ban_*') ? 'active' : '' }}">
                <i class="fas fa-sitemap nav-icon"></i>
                <p>
                    Các Ban Khác
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-circle-notch nav-icon text-muted"></i>
                        <p>Đang cập nhật...</p>
                    </a>
                </li>
            </ul>
        </li>
    @endif
</ul>