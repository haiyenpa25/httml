<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('dist/img/TMLlogo.png') }}" alt="Hội Thánh Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">HTTML</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name ?? 'Quản trị viên' }}</a>
            </div>
        </div>

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Tìm kiếm..."
                       aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            @php
                $userPermissions = Auth::check() ? Auth::user()->quyen->pluck('quyen')->toArray() : [];
                $isAdmin = Auth::check() && (Auth::user()->vai_tro === 'quan_tri' || in_array('admin-access', $userPermissions));
            @endphp
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Trang Chủ -->
                @if($isAdmin || in_array('view-dashboard', $userPermissions))
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Trang Chủ</p>
                        </a>
                    </li>
                @endif

                <!-- Quản lý Tín Hữu -->
                @if($isAdmin || in_array('view-tin-huu', $userPermissions) || in_array('view-ho-gia-dinh', $userPermissions) || in_array('view-than-huu', $userPermissions))
                    <li class="nav-item {{ request()->routeIs('_tin_huu.*', '_ho_gia_dinh.*', '_than_huu.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Quản lý Tín Hữu
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Tín Hữu -->
                            @if($isAdmin || in_array('view-tin-huu', $userPermissions))
                                <li class="nav-item {{ request()->routeIs('_tin_huu.*') ? 'menu-open' : '' }}">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Tín Hữu
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('_tin_huu.index') }}"
                                               class="nav-link {{ request()->routeIs('_tin_huu.index') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Danh sách Tín Hữu</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('_tin_huu.create') }}"
                                               class="nav-link {{ request()->routeIs('_tin_huu.create') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Thêm Tín Hữu mới</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('_tin_huu.nhan_su') }}"
                                               class="nav-link {{ request()->routeIs('_tin_huu.nhan_su') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Nhân sự</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            <!-- Hộ Gia Đình -->
                            @if($isAdmin || in_array('view-ho-gia-dinh', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('_ho_gia_dinh.index') }}"
                                       class="nav-link {{ request()->routeIs('_ho_gia_dinh.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Hộ Gia Đình</p>
                                    </a>
                                </li>
                            @endif
                            <!-- Thân Hữu -->
                            @if($isAdmin || in_array('view-than-huu', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('_than_huu.index') }}"
                                       class="nav-link {{ request()->routeIs('_than_huu.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Thân Hữu</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Diễn Giả -->
                @if($isAdmin || in_array('view-dien-gia', $userPermissions))
                    <li class="nav-item">
                        <a href="{{ route('_dien_gia.index') }}"
                           class="nav-link {{ request()->routeIs('_dien_gia.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-microphone"></i>
                            <p>Diễn Giả</p>
                        </a>
                    </li>
                @endif

                <!-- Quản lý Ban Ngành -->
                @if($isAdmin || in_array('view-ban-nganh', $userPermissions))
                    <li class="nav-item {{ request()->routeIs('_ban_nganh.*', '_ban_*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>
                                Quản lý Ban Ngành
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        @include('partials.sidebar_ban_nganh', ['userPermissions' => $userPermissions, 'isAdmin' => $isAdmin])
                    </li>
                @endif

                <!-- Quản lý Thủ Quỹ -->
                @if($isAdmin || in_array('view-thu-quy-dashboard', $userPermissions))
                    <li class="nav-item {{ request()->routeIs('_thu_quy.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>
                                Quản lý Thủ Quỹ
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Tổng quan -->
                            <li class="nav-item">
                                <a href="{{ route('_thu_quy.dashboard') }}"
                                   class="nav-link {{ request()->routeIs('_thu_quy.dashboard') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tổng quan</p>
                                </a>
                            </li>
                            <!-- Quản lý Quỹ -->
                            @if($isAdmin || in_array('view-thu-quy-quy', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.quy.index') }}"
                                       class="nav-link {{ request()->routeIs('_thu_quy.quy.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Quản lý Quỹ</p>
                                    </a>
                                </li>
                            @endif
                            <!-- Giao dịch -->
                            @if($isAdmin || in_array('view-thu-quy-giao-dich', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.giao_dich.index') }}"
                                       class="nav-link {{ request()->routeIs('_thu_quy.giao_dich.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Giao dịch</p>
                                    </a>
                                </li>
                            @endif
                            <!-- Chi định kỳ -->
                            @if($isAdmin || in_array('view-thu-quy-chi-dinh-ky', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.chi_dinh_ky.index') }}"
                                       class="nav-link {{ request()->routeIs('_thu_quy.chi_dinh_ky.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Chi định kỳ</p>
                                    </a>
                                </li>
                            @endif
                            <!-- Báo cáo -->
                            @if($isAdmin || in_array('view-thu-quy-bao-cao', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.bao_cao.index') }}"
                                       class="nav-link {{ request()->routeIs('_thu_quy.bao_cao.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Báo cáo</p>
                                    </a>
                                </li>
                            @endif
                            <!-- Lịch sử thao tác -->
                            @if($isAdmin || in_array('view-thu-quy-lich-su', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.lich_su.index') }}"
                                       class="nav-link {{ request()->routeIs('_thu_quy.lich_su.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lịch sử thao tác</p>
                                    </a>
                                </li>
                            @endif
                            <!-- Thông báo -->
                            @if($isAdmin || in_array('view-thu-quy-thong-bao', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.thong_bao.index') }}"
                                       class="nav-link {{ request()->routeIs('_thu_quy.thong_bao.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Thông báo
                                            @php
                                                $thongBaoChuaDoc = Auth::check() ?
                                                    \App\Models\ThongBaoTaiChinh::where('nguoi_nhan_id', Auth::id())
                                                        ->where('da_doc', false)
                                                        ->count() : 0;
                                            @endphp
                                            @if($thongBaoChuaDoc > 0)
                                                <span class="badge badge-warning right">{{ $thongBaoChuaDoc }}</span>
                                            @endif
                                        </p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Quản lý Thiết Bị -->
                @if($isAdmin || in_array('view-thiet-bi', $userPermissions) || in_array('view-nha-cung-cap', $userPermissions) || in_array('view-lich-su-bao-tri', $userPermissions))
                    <li class="nav-item {{ request()->routeIs('thiet-bi.*', 'nha-cung-cap.*', 'lich-su-bao-tri.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-desktop"></i>
                            <p>
                                Quản lý Thiết Bị
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Danh sách Thiết Bị -->
                            @if($isAdmin || in_array('view-thiet-bi', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('thiet-bi.index') }}"
                                       class="nav-link {{ request()->routeIs('thiet-bi.index') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Danh sách Thiết Bị</p>
                                    </a>
                                </li>
                            @endif
                            <!-- Cảnh Báo -->
                            @if($isAdmin || in_array('view-thiet-bi-canh-bao', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('thiet-bi.canh-bao') }}"
                                       class="nav-link {{ request()->routeIs('thiet-bi.canh-bao') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cảnh Báo</p>
                                    </a>
                                </li>
                            @endif
                            <!-- Báo Cáo Thống Kê -->
                            @if($isAdmin || in_array('view-thiet-bi-bao-cao', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('thiet-bi.bao-cao') }}"
                                       class="nav-link {{ request()->routeIs('thiet-bi.bao-cao') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Báo Cáo Thống Kê</p>
                                    </a>
                                </li>
                            @endif
                            <!-- Lịch Sử Bảo Trì -->
                            @if($isAdmin || in_array('view-lich-su-bao-tri', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('thiet-bi.index') }}"
                                       class="nav-link {{ request()->routeIs('lich-su-bao-tri.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lịch Sử Bảo Trì</p>
                                    </a>
                                </li>
                            @endif
                            <!-- Export -->
                            @if($isAdmin || in_array('export-thiet-bi', $userPermissions))
                                <li class="nav-item {{ request()->routeIs('thiet-bi.export-excel', 'thiet-bi.export-pdf') ? 'menu-open' : '' }}">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Xuất Báo Cáo
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('thiet-bi.export-excel') }}"
                                               class="nav-link {{ request()->routeIs('thiet-bi.export-excel') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Xuất Excel</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('thiet-bi.export-pdf') }}"
                                               class="nav-link {{ request()->routeIs('thiet-bi.export-pdf') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Xuất PDF</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            <!-- Nhà Cung Cấp -->
                            @if($isAdmin || in_array('view-nha-cung-cap', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('nha-cung-cap.index') }}"
                                       class="nav-link {{ request()->routeIs('nha-cung-cap.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Nhà Cung Cấp</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Quản lý Thông Báo -->
                @if($isAdmin || in_array('view-thong-bao', $userPermissions))
                    <li class="nav-item {{ request()->routeIs('thong-bao.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-envelope"></i>
                            <p>
                                Quản lý Thông Báo
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Tổng quan -->
                            <li class="nav-item">
                                <a href="{{ route('thong-bao.index') }}"
                                   class="nav-link {{ Request::is('thong-bao') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tổng quan</p>
                                </a>
                            </li>
                            <!-- Hộp thư đến -->
                            @if($isAdmin || in_array('view-thong-bao-inbox', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('thong-bao.inbox') }}"
                                       class="nav-link {{ Request::is('thong-bao/inbox') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Hộp thư đến
                                            @php
                                                $thongBaoChuaDoc = Auth::check() ?
                                                    \App\Models\ThongBao::where('nguoi_nhan_id', Auth::id())
                                                        ->where('da_doc', false)
                                                        ->count() : 0;
                                            @endphp
                                            @if($thongBaoChuaDoc > 0)
                                                <span class="badge badge-warning right">{{ $thongBaoChuaDoc }}</span>
                                            @endif
                                        </p>
                                    </a>
                                </li>
                            @endif
                            <!-- Đã gửi -->
                            @if($isAdmin || in_array('view-thong-bao-sent', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('thong-bao.sent') }}"
                                       class="nav-link {{ Request::is('thong-bao/sent') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Đã gửi</p>
                                    </a>
                                </li>
                            @endif
                            <!-- Lưu trữ -->
                            @if($isAdmin || in_array('view-thong-bao-archived', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('thong-bao.archived') }}"
                                       class="nav-link {{ Request::is('thong-bao/archived') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lưu trữ</p>
                                    </a>
                                </li>
                            @endif
                            <!-- Soạn thông báo -->
                            @if($isAdmin || in_array('send-thong-bao', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('thong-bao.create') }}"
                                       class="nav-link {{ Request::is('thong-bao/create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Soạn thông báo</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Quản lý Báo Cáo -->
                @if($isAdmin || in_array('view-bao-cao-thiet-bi', $userPermissions) || in_array('view-bao-cao-tai-chinh', $userPermissions) || in_array('view-bao-cao-hoi-thanh', $userPermissions))
                    <li class="nav-item {{ request()->routeIs('_bao_cao.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>
                                Quản lý Báo Cáo
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Báo Cáo Thiết Bị -->
                            @if($isAdmin || in_array('view-bao-cao-thiet-bi', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('_bao_cao.thiet_bi') }}"
                                       class="nav-link {{ request()->routeIs('_bao_cao.thiet_bi') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Báo Cáo Thiết Bị</p>
                                    </a>
                                </li>
                            @endif
                            <!-- Báo Cáo Tài Chính -->
                            @if($isAdmin || in_array('view-bao-cao-tai-chinh', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('_bao_cao.tai_chinh') }}"
                                       class="nav-link {{ request()->routeIs('_bao_cao.tai_chinh') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Báo Cáo Tài Chính</p>
                                    </a>
                                </li>
                            @endif
                            <!-- Báo Cáo Hội Thánh -->
                            @if($isAdmin || in_array('view-bao-cao-hoi-thanh', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('_bao_cao.hoi_thanh') }}"
                                       class="nav-link {{ request()->routeIs('_bao_cao.hoi_thanh') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Báo Cáo Hội Thánh</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Quản Lý Phân Quyền -->
                @if($isAdmin || in_array('manage-phan-quyen', $userPermissions))
                    <li class="nav-item">
                        <a href="{{ route('_phan_quyen.index') }}"
                           class="nav-link {{ request()->routeIs('_phan_quyen.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Quản Lý Phân Quyền</p>
                        </a>
                    </li>
                @endif

                <!-- Thờ Phượng -->
                @if($isAdmin || in_array('view-tho-phuong', $userPermissions))
                    <li class="nav-item {{ request()->routeIs('_tho_phuong.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-church"></i>
                            <p>
                                Thờ Phượng
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('_tho_phuong.buoi_nhom') }}"
                                   class="nav-link {{ request()->routeIs('_tho_phuong.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Thờ Phượng</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Tài Liệu -->
                @if($isAdmin || in_array('view-tai-lieu', $userPermissions))
                    <li class="nav-item {{ request()->routeIs('_tai_lieu.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>
                                Tài Liệu
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('_tai_lieu.index') }}"
                                   class="nav-link {{ request()->routeIs('_tai_lieu.*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tài Liệu</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                <!-- Cài đặt Hệ thống -->
                @if($isAdmin || in_array('view-cai-dat', $userPermissions) || in_array('view-nguoi-dung', $userPermissions))
                    <li class="nav-item {{ request()->routeIs('_cai_dat.*', 'nguoi_dung.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Cài đặt Hệ thống
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Người Dùng -->
                            @if($isAdmin || in_array('view-nguoi-dung', $userPermissions))
                                <li class="nav-item">
                                    <a href="{{ route('nguoi_dung.index') }}"
                                       class="nav-link {{ request()->routeIs('nguoi_dung.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Người Dùng</p>
                                    </a>
                                </li>
                            @endif
                            <!-- Cài đặt -->
                            @if($isAdmin || in_array('view-cai-dat', $userPermissions))
                                <li class="nav-item {{ request()->routeIs('_cai_dat.*') ? 'menu-open' : '' }}">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Cài đặt
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('_cai_dat.he_thong') }}"
                                               class="nav-link {{ request()->routeIs('_cai_dat.*') ? 'active' : '' }}">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Cài đặt Hệ thống</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>