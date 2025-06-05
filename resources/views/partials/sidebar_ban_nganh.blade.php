<ul class="nav nav-treeview">
    <!-- Ban Trung Lão -->
    @can('view-ban-nganh-trung-lao')
        <li class="nav-item {{ request()->routeIs('_ban_nganh.trung_lao.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('_ban_nganh.trung_lao.*') ? 'active' : '' }}">
                <i class="fas fa-user-friends nav-icon text-info"></i>
                <p>
                    Ban Trung Lão
                    <i class="fas fa-angle-left right"></i>
                    @if(request()->routeIs('_ban_nganh.trung_lao.*'))
                        <span class="badge badge-primary right">
                            {{ count(array_filter([
                                Auth::user()->hasPermissionTo('diem-danh-ban-nganh-trung-lao'),
                                Auth::user()->hasPermissionTo('phan-cong-ban-nganh-trung-lao'),
                                Auth::user()->hasPermissionTo('phan-cong-chi-tiet-ban-nganh-trung-lao'),
                                Auth::user()->hasPermissionTo('nhap-lieu-bao-cao-ban-nganh-trung-lao'),
                                Auth::user()->hasPermissionTo('bao-cao-ban-nganh-trung-lao'),
                            ])) }}
                        </span>
                    @endif
                </p>
            </a>
            <ul class="nav nav-treeview">
                <!-- Tổng quan -->
                <li class="nav-item">
                    <a href="{{ route('_ban_nganh.trung_lao.index') }}"
                       class="nav-link {{ request()->routeIs('_ban_nganh.trung_lao.index') ? 'active' : '' }}">
                        <i class="fas fa-th-large nav-icon"></i>
                        <p>Tổng quan</p>
                    </a>
                </li>
                <!-- Điểm danh -->
                @can('diem-danh-ban-nganh-trung-lao')
                    <li class="nav-item">
                        <a href="{{ route('_ban_nganh.trung_lao.diem_danh') }}"
                           class="nav-link {{ request()->routeIs('_ban_nganh.trung_lao.diem_danh') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-check nav-icon"></i>
                            <p>Điểm danh</p>
                        </a>
                    </li>
                @endcan
                <!-- Phân công -->
                @can('phan-cong-ban-nganh-trung-lao')
                    <li class="nav-item">
                        <a href="{{ route('_ban_nganh.trung_lao.phan_cong') }}"
                           class="nav-link {{ request()->routeIs('_ban_nganh.trung_lao.phan_cong') ? 'active' : '' }}">
                            <i class="fas fa-tasks nav-icon"></i>
                            <p>Phân công</p>
                        </a>
                    </li>
                @endcan
                <!-- Phân công chi tiết -->
                @can('phan-cong-chi-tiet-ban-nganh-trung-lao')
                    <li class="nav-item">
                        <a href="{{ route('_ban_nganh.trung_lao.phan_cong_chi_tiet') }}"
                           class="nav-link {{ request()->routeIs('_ban_nganh.trung_lao.phan_cong_chi_tiet') ? 'active' : '' }}">
                            <i class="fas fa-list-check nav-icon"></i>
                            <p>Phân công chi tiết</p>
                        </a>
                    </li>
                @endcan
                <!-- Báo Cáo -->
                @if(Auth::user()->hasAnyPermission(['nhap-lieu-bao-cao-ban-nganh-trung-lao', 'bao-cao-ban-nganh-trung-lao']))
                    <li class="nav-item {{ request()->routeIs(['_ban_nganh.trung_lao.nhap_lieu_bao_cao', '_ban_nganh.trung_lao.bao_cao']) ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs(['_ban_nganh.trung_lao.nhap_lieu_bao_cao', '_ban_nganh.trung_lao.bao_cao']) ? 'active' : '' }}">
                            <i class="fas fa-chart-line nav-icon"></i>
                            <p>
                                Báo Cáo
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('nhap-lieu-bao-cao-ban-nganh-trung-lao')
                                <li class="nav-item">
                                    <a href="{{ route('_ban_nganh.trung_lao.nhap_lieu_bao_cao') }}"
                                       class="nav-link {{ request()->routeIs('_ban_nganh.trung_lao.nhap_lieu_bao_cao') ? 'active' : '' }}">
                                        <i class="fas fa-keyboard nav-icon"></i>
                                        <p>Nhập liệu báo cáo</p>
                                    </a>
                                </li>
                            @endcan
                            @can('bao-cao-ban-nganh-trung-lao')
                                <li class="nav-item">
                                    <a href="{{ route('_ban_nganh.trung_lao.bao_cao') }}"
                                       class="nav-link {{ request()->routeIs('_ban_nganh.trung_lao.bao_cao') ? 'active' : '' }}">
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

    <!-- Ban Thanh Tráng -->
    @can('view-ban-nganh-thanh-trang')
        <li class="nav-item {{ request()->routeIs('_ban_nganh.thanh_trang.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('_ban_nganh.thanh_trang.*') ? 'active' : '' }}">
                <i class="fas fa-user-tie nav-icon text-success"></i>
                <p>
                    Ban Thanh Tráng
                    <i class="fas fa-angle-left right"></i>
                    @if(request()->routeIs('_ban_nganh.thanh_trang.*'))
                        <span class="badge badge-primary right">
                            {{ count(array_filter([
                                Auth::user()->hasPermissionTo('diem-danh-ban-nganh-thanh-trang'),
                                Auth::user()->hasPermissionTo('phan-cong-ban-nganh-thanh-trang'),
                                Auth::user()->hasPermissionTo('phan-cong-chi-tiet-ban-nganh-thanh-trang'),
                                Auth::user()->hasPermissionTo('nhap-lieu-bao-cao-ban-nganh-thanh-trang'),
                                Auth::user()->hasPermissionTo('bao-cao-ban-nganh-thanh-trang'),
                            ])) }}
                        </span>
                    @endif
                </p>
            </a>
            <ul class="nav nav-treeview">
                <!-- Tổng quan -->
                <li class="nav-item">
                    <a href="{{ route('_ban_nganh.thanh_trang.index') }}"
                       class="nav-link {{ request()->routeIs('_ban_nganh.thanh_trang.index') ? 'active' : '' }}">
                        <i class="fas fa-th-large nav-icon"></i>
                        <p>Tổng quan</p>
                    </a>
                </li>
                <!-- Điểm danh -->
                @can('diem-danh-ban-nganh-thanh-trang')
                    <li class="nav-item">
                        <a href="{{ route('_ban_nganh.thanh_trang.diem_danh') }}"
                           class="nav-link {{ request()->routeIs('_ban_nganh.thanh_trang.diem_danh') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-check nav-icon"></i>
                            <p>Điểm danh</p>
                        </a>
                    </li>
                @endcan
                <!-- Phân công -->
                @can('phan-cong-ban-nganh-thanh-trang')
                    <li class="nav-item">
                        <a href="{{ route('_ban_nganh.thanh_trang.phan_cong') }}"
                           class="nav-link {{ request()->routeIs('_ban_nganh.thanh_trang.phan_cong') ? 'active' : '' }}">
                            <i class="fas fa-tasks nav-icon"></i>
                            <p>Phân công</p>
                        </a>
                    </li>
                @endcan
                <!-- Phân công chi tiết -->
                @can('phan-cong-chi-tiet-ban-nganh-thanh-trang')
                    <li class="nav-item">
                        <a href="{{ route('_ban_nganh.thanh_trang.phan_cong_chi_tiet') }}"
                           class="nav-link {{ request()->routeIs('_ban_nganh.thanh_trang.phan_cong_chi_tiet') ? 'active' : '' }}">
                            <i class="fas fa-list-check nav-icon"></i>
                            <p>Phân công chi tiết</p>
                        </a>
                    </li>
                @endcan
                <!-- Báo Cáo -->
                @if(Auth::user()->hasAnyPermission(['nhap-lieu-bao-cao-ban-nganh-thanh-trang', 'bao-cao-ban-nganh-thanh-trang']))
                    <li class="nav-item {{ request()->routeIs(['_ban_nganh.thanh_trang.nhap_lieu_bao_cao', '_ban_nganh.thanh_trang.bao_cao']) ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs(['_ban_nganh.thanh_trang.nhap_lieu_bao_cao', '_ban_nganh.thanh_trang.bao_cao']) ? 'active' : '' }}">
                            <i class="fas fa-chart-line nav-icon"></i>
                            <p>
                                Báo Cáo
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('nhap-lieu-bao-cao-ban-nganh-thanh-trang')
                                <li class="nav-item">
                                    <a href="{{ route('_ban_nganh.thanh_trang.nhap_lieu_bao_cao') }}"
                                       class="nav-link {{ request()->routeIs('_ban_nganh.thanh_trang.nhap_lieu_bao_cao') ? 'active' : '' }}">
                                        <i class="fas fa-keyboard nav-icon"></i>
                                        <p>Nhập liệu báo cáo</p>
                                    </a>
                                </li>
                            @endcan
                            @can('bao-cao-ban-nganh-thanh-trang')
                                <li class="nav-item">
                                    <a href="{{ route('_ban_nganh.thanh_trang.bao_cao') }}"
                                       class="nav-link {{ request()->routeIs('_ban_nganh.thanh_trang.bao_cao') ? 'active' : '' }}">
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

    <!-- Ban Thanh Niên -->
    @can('view-ban-nganh-thanh-nien')
        <li class="nav-item {{ request()->routeIs('_ban_nganh.thanh_nien.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('_ban_nganh.thanh_nien.*') ? 'active' : '' }}">
                <i class="fas fa-user-graduate nav-icon text-primary"></i>
                <p>
                    Ban Thanh Niên
                    <i class="fas fa-angle-left right"></i>
                    @if(request()->routeIs('_ban_nganh.thanh_nien.*'))
                        <span class="badge badge-primary right">
                            {{ count(array_filter([
                                Auth::user()->hasPermissionTo('diem-danh-ban-nganh-thanh-nien'),
                                Auth::user()->hasPermissionTo('phan-cong-ban-nganh-thanh-nien'),
                                Auth::user()->hasPermissionTo('phan-cong-chi-tiet-ban-nganh-thanh-nien'),
                                Auth::user()->hasPermissionTo('nhap-lieu-bao-cao-ban-nganh-thanh-nien'),
                                Auth::user()->hasPermissionTo('bao-cao-ban-nganh-thanh-nien'),
                            ])) }}
                        </span>
                    @endif
                </p>
            </a>
            <ul class="nav nav-treeview">
                <!-- Tổng quan -->
                <li class="nav-item">
                    <a href="{{ route('_ban_nganh.thanh_nien.index') }}"
                       class="nav-link {{ request()->routeIs('_ban_nganh.thanh_nien.index') ? 'active' : '' }}">
                        <i class="fas fa-th-large nav-icon"></i>
                        <p>Tổng quan</p>
                    </a>
                </li>
                <!-- Điểm danh -->
                @can('diem-danh-ban-nganh-thanh-nien')
                    <li class="nav-item">
                        <a href="{{ route('_ban_nganh.thanh_nien.diem_danh') }}"
                           class="nav-link {{ request()->routeIs('_ban_nganh.thanh_nien.diem_danh') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-check nav-icon"></i>
                            <p>Điểm danh</p>
                        </a>
                    </li>
                @endcan
                <!-- Phân công -->
                @can('phan-cong-ban-nganh-thanh-nien')
                    <li class="nav-item">
                        <a href="{{ route('_ban_nganh.thanh_nien.phan_cong') }}"
                           class="nav-link {{ request()->routeIs('_ban_nganh.thanh_nien.phan_cong') ? 'active' : '' }}">
                            <i class="fas fa-tasks nav-icon"></i>
                            <p>Phân công</p>
                        </a>
                    </li>
                @endcan
                <!-- Phân công chi tiết -->
                @can('phan-cong-chi-tiet-ban-nganh-thanh-nien')
                    <li class="nav-item">
                        <a href="{{ route('_ban_nganh.thanh_nien.phan_cong_chi_tiet') }}"
                           class="nav-link {{ request()->routeIs('_ban_nganh.thanh_nien.phan_cong_chi_tiet') ? 'active' : '' }}">
                            <i class="fas fa-list-check nav-icon"></i>
                            <p>Phân công chi tiết</p>
                        </a>
                    </li>
                @endcan
                <!-- Báo Cáo -->
                @if(Auth::user()->hasAnyPermission(['nhap-lieu-bao-cao-ban-nganh-thanh-nien', 'bao-cao-ban-nganh-thanh-nien']))
                    <li class="nav-item {{ request()->routeIs(['_ban_nganh.thanh_nien.nhap_lieu_bao_cao', '_ban_nganh.thanh_nien.bao_cao']) ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs(['_ban_nganh.thanh_nien.nhap_lieu_bao_cao', '_ban_nganh.thanh_nien.bao_cao']) ? 'active' : '' }}">
                            <i class="fas fa-chart-line nav-icon"></i>
                            <p>
                                Báo Cáo
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('nhap-lieu-bao-cao-ban-nganh-thanh-nien')
                                <li class="nav-item">
                                    <a href="{{ route('_ban_nganh.thanh_nien.nhap_lieu_bao_cao') }}"
                                       class="nav-link {{ request()->routeIs('_ban_nganh.thanh_nien.nhap_lieu_bao_cao') ? 'active' : '' }}">
                                        <i class="fas fa-keyboard nav-icon"></i>
                                        <p>Nhập liệu báo cáo</p>
                                    </a>
                                </li>
                            @endcan
                            @can('bao-cao-ban-nganh-thanh-nien')
                                <li class="nav-item">
                                    <a href="{{ route('_ban_nganh.thanh_nien.bao_cao') }}"
                                       class="nav-link {{ request()->routeIs('_ban_nganh.thanh_nien.bao_cao') ? 'active' : '' }}">
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

    <!-- Ban Cơ Đốc Giáo Dục -->
    @can('view-ban-co-doc-giao-duc')
        <li class="nav-item {{ request()->routeIs('_ban_co_doc_giao_duc.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('_ban_co_doc_giao_duc.*') ? 'active' : '' }}">
                <i class="fas fa-book-reader nav-icon text-purple"></i>
                <p>
                    Ban Cơ Đốc Giáo Dục
                    <i class="fas fa-angle-left right"></i>
                    @if(request()->routeIs('_ban_co_doc_giao_duc.*'))
                        <span class="badge badge-primary right">
                            {{ count(array_filter([
                                Auth::user()->hasPermissionTo('diem-danh-ban-co-doc-giao-duc'),
                                Auth::user()->hasPermissionTo('phan-cong-ban-co-doc-giao-duc'),
                                Auth::user()->hasPermissionTo('phan-cong-chi-tiet-ban-co-doc-giao-duc'),
                                Auth::user()->hasPermissionTo('nhap-lieu-bao-cao-ban-co-doc-giao-duc'),
                                Auth::user()->hasPermissionTo('bao-cao-ban-co-doc-giao-duc'),
                            ])) }}
                        </span>
                    @endif
                </p>
            </a>
            <ul class="nav nav-treeview">
                <!-- Tổng quan -->
                <li class="nav-item">
                    <a href="{{ route('_ban_co_doc_giao_duc.index', ['banType' => 'ban-co-doc-giao-duc']) }}"
                       class="nav-link {{ request()->routeIs('_ban_co_doc_giao_duc.index') ? 'active' : '' }}">
                        <i class="fas fa-th-large nav-icon"></i>
                        <p>Tổng quan</p>
                    </a>
                </li>
                <!-- Điểm danh -->
                @can('diem-danh-ban-co-doc-giao-duc')
                    <li class="nav-item">
                        <a href="{{ route('_ban_co_doc_giao_duc.diem_danh', ['banType' => 'ban-co-doc-giao-duc']) }}"
                           class="nav-link {{ request()->routeIs('_ban_co_doc_giao_duc.diem_danh') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-check nav-icon"></i>
                            <p>Điểm danh</p>
                        </a>
                    </li>
                @endcan
                <!-- Phân công -->
                @can('phan-cong-ban-co-doc-giao-duc')
                    <li class="nav-item">
                        <a href="{{ route('_ban_co_doc_giao_duc.phan_cong', ['banType' => 'ban-co-doc-giao-duc']) }}"
                           class="nav-link {{ request()->routeIs('_ban_co_doc_giao_duc.phan_cong') ? 'active' : '' }}">
                            <i class="fas fa-tasks nav-icon"></i>
                            <p>Phân công</p>
                        </a>
                    </li>
                @endcan
                <!-- Phân công chi tiết -->
                @can('phan-cong-chi-tiet-ban-co-doc-giao-duc')
                    <li class="nav-item">
                        <a href="{{ route('_ban_co_doc_giao_duc.phan_cong_chi_tiet', ['banType' => 'ban-co-doc-giao-duc']) }}"
                           class="nav-link {{ request()->routeIs('_ban_co_doc_giao_duc.phan_cong_chi_tiet') ? 'active' : '' }}">
                            <i class="fas fa-list-check nav-icon"></i>
                            <p>Phân công chi tiết</p>
                        </a>
                    </li>
                @endcan
                <!-- Báo Cáo -->
                @if(Auth::user()->hasAnyPermission(['nhap-lieu-bao-cao-ban-co-doc-giao-duc', 'bao-cao-ban-co-doc-giao-duc']))
                    <li class="nav-item {{ request()->routeIs(['_ban_co_doc_giao_duc.nhap_lieu_bao_cao', '_ban_co_doc_giao_duc.bao_cao']) ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs(['_ban_co_doc_giao_duc.nhap_lieu_bao_cao', '_ban_co_doc_giao_duc.bao_cao']) ? 'active' : '' }}">
                            <i class="fas fa-chart-line nav-icon"></i>
                            <p>
                                Báo Cáo
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('nhap-lieu-bao-cao-ban-co-doc-giao-duc')
                                <li class="nav-item">
                                    <a href="{{ route('_ban_co_doc_giao_duc.nhap_lieu_bao_cao', ['banType' => 'ban-co-doc-giao-duc']) }}"
                                       class="nav-link {{ request()->routeIs('_ban_co_doc_giao_duc.nhap_lieu_bao_cao') ? 'active' : '' }}">
                                        <i class="fas fa-keyboard nav-icon"></i>
                                        <p>Nhập liệu báo cáo</p>
                                    </a>
                                </li>
                            @endcan
                            @can('bao-cao-ban-co-doc-giao-duc')
                                <li class="nav-item">
                                    <a href="{{ route('_ban_co_doc_giao_duc.bao_cao', ['banType' => 'ban-co-doc-giao-duc']) }}"
                                       class="nav-link {{ request()->routeIs('_ban_co_doc_giao_duc.bao_cao') ? 'active' : '' }}">
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