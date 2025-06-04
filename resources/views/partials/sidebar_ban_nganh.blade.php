<ul class="nav nav-treeview">
    @php
        $banIcons = [
            'trung-lao' => 'fas fa-user-friends',
            'thanh-trang' => 'fas fa-user-tie',
            'thanh-nien' => 'fas fa-user-graduate',
            'thieu-nhi' => 'fas fa-child',
            'co_doc-giao_duc' => 'fas fa-book-reader',
        ];
        
        $banNames = [
            'trung-lao' => 'Ban Trung Lão',
            'thanh-trang' => 'Ban Thanh Tráng',
            'thanh-nien' => 'Ban Thanh Niên',
            'thieu-nhi' => 'Ban Thiếu Nhi Ấu',
            'co_doc-giao_duc' => 'Ban Cơ Đốc Giáo Dục',
        ];
        
        $banColors = [
            'trung-lao' => 'text-info',
            'thanh-trang' => 'text-success',
            'thanh-nien' => 'text-primary',
            'thieu-nhi' => 'text-warning',
            'co_doc-giao_duc' => 'text-purple',
        ];
    @endphp
    
    @foreach(['trung-lao', 'thanh-trang', 'thanh-nien', 'thieu-nhi', 'co_doc-giao_duc'] as $ban)
        @can('view-ban-nganh-' . $ban)
            <li class="nav-item {{ request()->routeIs($ban == 'co_doc-giao_duc' ? '_ban_co_doc_giao_duc.*' : '_ban_nganh.' . str_replace('-', '_', $ban) . '.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ request()->routeIs($ban == 'co_doc-giao_duc' ? '_ban_co_doc_giao_duc.*' : '_ban_nganh.' . str_replace('-', '_', $ban) . '.*') ? 'active' : '' }}">
                    <i class="{{ $banIcons[$ban] ?? 'far fa-circle' }} nav-icon {{ $banColors[$ban] ?? '' }}"></i>
                    <p>
                        {{ $banNames[$ban] }}
                        <i class="fas fa-angle-left right"></i>
                        @if(request()->routeIs($ban == 'co_doc-giao_duc' ? '_ban_co_doc_giao_duc.*' : '_ban_nganh.' . str_replace('-', '_', $ban) . '.*'))
                            <span class="badge badge-primary right">
                                {{ count(array_filter([
                                    Auth::user()->hasPermissionTo('diem-danh-ban-' . ($ban == 'co_doc-giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban)),
                                    Auth::user()->hasPermissionTo('phan-cong-ban-' . ($ban == 'co_doc-giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban)),
                                    Auth::user()->hasPermissionTo('phan-cong-chi-tiet-ban-' . ($ban == 'co_doc-giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban)),
                                    Auth::user()->hasPermissionTo('nhap-lieu-bao-cao-ban-' . ($ban == 'co_doc-giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban)),
                                    Auth::user()->hasPermissionTo('bao-cao-ban-' . ($ban == 'co_doc-giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban)),
                                ])) }}
                            </span>
                        @endif
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <!-- Tổng quan -->
                    <li class="nav-item">
                        <a href="{{ route($ban == 'co_doc-giao_duc' ? '_ban_co_doc_giao_duc.index' : '_ban_nganh.' . str_replace('-', '_', $ban) . '.index', $ban == 'co_doc-giao_duc' ? ['banType' => 'ban-co-doc-giao-duc'] : []) }}"
                           class="nav-link {{ request()->routeIs($ban == 'co_doc-giao_duc' ? '_ban_co_doc_giao_duc.index' : '_ban_nganh.' . str_replace('-', '_', $ban) . '.index') ? 'active' : '' }}">
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
                    @can('diem-danh-ban-' . ($ban == 'co_doc-giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban))
                        <li class="nav-item">
                            <a href="{{ route($ban == 'co_doc-giao_duc' ? '_ban_co_doc_giao_duc.diem_danh' : '_ban_nganh.' . str_replace('-', '_', $ban) . '.diem_danh', $ban == 'co_doc-giao_duc' ? ['banType' => 'ban-co-doc-giao-duc'] : []) }}"
                               class="nav-link {{ request()->routeIs($ban == 'co_doc-giao_duc' ? '_ban_co_doc_giao_duc.diem_danh' : '_ban_nganh.' . str_replace('-', '_', $ban) . '.diem_danh') ? 'active' : '' }}">
                                <i class="fas fa-clipboard-check nav-icon"></i>
                                <p>Điểm danh</p>
                            </a>
                        </li>
                    @endcan
                    
                    <!-- Phân công -->
                    @can('phan-cong-ban-' . ($ban == 'co_doc-giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban))
                        <li class="nav-item">
                            <a href="{{ route($ban == 'co_doc-giao_duc' ? '_ban_co_doc_giao_duc.phan_cong' : '_ban_nganh.' . str_replace('-', '_', $ban) . '.phan_cong', $ban == 'co_doc-giao_duc' ? ['banType' => 'ban-co-doc-giao-duc'] : []) }}"
                               class="nav-link {{ request()->routeIs($ban == 'co_doc-giao_duc' ? '_ban_co_doc_giao_duc.phan_cong' : '_ban_nganh.' . str_replace('-', '_', $ban) . '.phan_cong') ? 'active' : '' }}">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p>Phân công</p>
                            </a>
                        </li>
                    @endcan
                    
                    <!-- Phân công chi tiết -->
                    @can('phan-cong-chi-tiet-ban-' . ($ban == 'co_doc-giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban))
                        <li class="nav-item">
                            <a href="{{ route($ban == 'co_doc-giao_duc' ? '_ban_co_doc_giao_duc.phan_cong_chi_tiet' : '_ban_nganh.' . str_replace('-', '_', $ban) . '.phan_cong_chi_tiet', $ban == 'co_doc-giao_duc' ? ['banType' => 'ban-co-doc-giao-duc'] : []) }}"
                               class="nav-link {{ request()->routeIs($ban == 'co_doc-giao_duc' ? '_ban_co_doc_giao_duc.phan_cong_chi_tiet' : '_ban_nganh.' . str_replace('-', '_', $ban) . '.phan_cong_chi_tiet') ? 'active' : '' }}">
                                <i class="fas fa-list-check nav-icon"></i>
                                <p>Phân công chi tiết</p>
                            </a>
                        </li>
                    @endcan
                    
                    <!-- Báo Cáo -->
                    @if(Auth::user()->hasAnyPermission(['nhap-lieu-bao-cao-ban-' . ($ban == 'co_doc-giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban), 'bao-cao-ban-' . ($ban == 'co_doc-giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban)]))
                        <li class="nav-item {{ request()->routeIs($ban == 'co_doc-giao_duc' ? ['_ban_co_doc_giao_duc.nhap_lieu_bao_cao', '_ban_co_doc_giao_duc.bao_cao'] : ['_ban_nganh.' . str_replace('-', '_', $ban) . '.nhap_lieu_bao_cao', '_ban_nganh.' . str_replace('-', '_', $ban) . '.bao_cao']) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs($ban == 'co_doc-giao_duc' ? ['_ban_co_doc_giao_duc.nhap_lieu_bao_cao', '_ban_co_doc_giao_duc.bao_cao'] : ['_ban_nganh.' . str_replace('-', '_', $ban) . '.nhap_lieu_bao_cao', '_ban_nganh.' . str_replace('-', '_', $ban) . '.bao_cao']) ? 'active' : '' }}">
                                <i class="fas fa-chart-line nav-icon"></i>
                                <p>
                                    Báo Cáo
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('nhap-lieu-bao-cao-ban-' . ($ban == 'co_doc-giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban))
                                    <li class="nav-item">
                                        <a href="{{ route($ban == 'co_doc-giao_duc' ? '_ban_co_doc_giao_duc.nhap_lieu_bao_cao' : '_ban_nganh.' . str_replace('-', '_', $ban) . '.nhap_lieu_bao_cao', $ban == 'co_doc-giao_duc' ? ['banType' => 'ban-co-doc-giao-duc'] : []) }}"
                                           class="nav-link {{ request()->routeIs($ban == 'co_doc-giao_duc' ? '_ban_co_doc_giao_duc.nhap_lieu_bao_cao' : '_ban_nganh.' . str_replace('-', '_', $ban) . '.nhap_lieu_bao_cao') ? 'active' : '' }}">
                                            <i class="fas fa-keyboard nav-icon"></i>
                                            <p>Nhập liệu báo cáo</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('bao-cao-ban-' . ($ban == 'co_doc-giao_duc' ? 'co-doc-giao-duc' : 'nganh-' . $ban))
                                    <li class="nav-item">
                                        <a href="{{ route($ban == 'co_doc-giao_duc' ? '_ban_co_doc_giao_duc.bao_cao' : '_ban_nganh.' . str_replace('-', '_', $ban) . '.bao_cao', $ban == 'co_doc-giao_duc' ? ['banType' => 'ban-co-doc-giao-duc'] : []) }}"
                                           class="nav-link {{ request()->routeIs($ban == 'co_doc-giao_duc' ? '_ban_co_doc_giao_duc.bao_cao' : '_ban_nganh.' . str_replace('-', '_', $ban) . '.bao_cao') ? 'active' : '' }}">
                                            <i class="fas fa-file-alt nav-icon"></i>
                                            <p>Xem báo cáo</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endif
                </ul>
            </li>
        @endcan
    @endforeach

    <!-- Các Ban Khác -->
    @can('view-ban-nganh')
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
    @endcan
</ul>