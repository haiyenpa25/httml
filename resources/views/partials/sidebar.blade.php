<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo và tên hệ thống -->
    <a href="{{ route('dashboard') }}" class="brand-link d-flex align-items-center">
        <img src="{{ asset('dist/img/TMLlogo.png') }}" alt="Hội Thánh Logo" class="brand-image img-circle elevation-2" style="opacity: .9">
        <span class="brand-text font-weight-bold">HTTML</span>
    </a>

    <div class="sidebar">
        <!-- Thông tin người dùng -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block text-truncate">
                    <span>{{ Auth::user()->name ?? 'Quản trị viên' }}</span>
                    <small class="d-block text-muted">{{ Auth::user()->email ?? '' }}</small>
                </a>
            </div>
        </div>

        <!-- Tìm kiếm -->
        <div class="form-inline mt-2">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Tìm kiếm menu..."
                       aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu chính -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-flat" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Trang Chủ -->
                @can('view-dashboard')
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Trang Chủ</p>
                        </a>
                    </li>
                @endcan

                <!-- Quản lý Tín Hữu -->
                @if(Auth::user()->hasAnyPermission(['view-tin-huu', 'view-ho-gia-dinh', 'view-than-huu']))
                    <li class="nav-item {{ request()->routeIs('_tin_huu.*', '_ho_gia_dinh.*', '_than_huu.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('_tin_huu.*', '_ho_gia_dinh.*', '_than_huu.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Quản lý Tín Hữu
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Tín Hữu -->
                            @can('view-tin-huu')
                                <li class="nav-item {{ request()->routeIs('_tin_huu.*') ? 'menu-open' : '' }}">
                                    <a href="#" class="nav-link {{ request()->routeIs('_tin_huu.*') ? 'active' : '' }}">
                                        <i class="fas fa-user-friends nav-icon"></i>
                                        <p>
                                            Tín Hữu
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('_tin_huu.index') }}"
                                               class="nav-link {{ request()->routeIs('_tin_huu.index') ? 'active' : '' }}">
                                                <i class="fas fa-list nav-icon"></i>
                                                <p>Danh sách Tín Hữu</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('_tin_huu.create') }}"
                                               class="nav-link {{ request()->routeIs('_tin_huu.create') ? 'active' : '' }}">
                                                <i class="fas fa-user-plus nav-icon"></i>
                                                <p>Thêm Tín Hữu mới</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('_tin_huu.nhan_su') }}"
                                               class="nav-link {{ request()->routeIs('_tin_huu.nhan_su') ? 'active' : '' }}">
                                                <i class="fas fa-user-tie nav-icon"></i>
                                                <p>Nhân sự</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            <!-- Hộ Gia Đình -->
                            @can('view-ho-gia-dinh')
                                <li class="nav-item">
                                    <a href="{{ route('_ho_gia_dinh.index') }}"
                                       class="nav-link {{ request()->routeIs('_ho_gia_dinh.*') ? 'active' : '' }}">
                                        <i class="fas fa-home nav-icon"></i>
                                        <p>Hộ Gia Đình</p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Thân Hữu -->
                            @can('view-than-huu')
                                <li class="nav-item">
                                    <a href="{{ route('_than_huu.index') }}"
                                       class="nav-link {{ request()->routeIs('_than_huu.*') ? 'active' : '' }}">
                                        <i class="fas fa-user-check nav-icon"></i>
                                        <p>Thân Hữu</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                <!-- Diễn Giả -->
                @can('view-dien-gia')
                    <li class="nav-item">
                        <a href="{{ route('_dien_gia.index') }}"
                           class="nav-link {{ request()->routeIs('_dien_gia.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-microphone-alt"></i>
                            <p>Diễn Giả</p>
                        </a>
                    </li>
                @endcan

                <!-- Quản lý Ban Ngành -->
                @can('view-ban-nganh')
                    <li class="nav-item {{ request()->routeIs('_ban_nganh.*', '_ban_*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('_ban_nganh.*', '_ban_*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>
                                Quản lý Ban Ngành
                                <i class="fas fa-angle-left right"></i>
                                @if(request()->routeIs('_ban_nganh.*', '_ban_*'))
                                    <span class="badge badge-info right">
                                        {{ count(array_filter(['trung_lao', 'thanh_trang', 'thanh_nien', 'thieu_nhi', 'co_doc_giao_duc'], function($ban) {
                                            return Auth::user()->hasPermissionTo('view-ban-nganh-' . $ban);
                                        })) }}
                                    </span>
                                @endif
                            </p>
                        </a>
                        @include('partials.sidebar_ban_nganh')
                    </li>
                @endcan

                <!-- Quản lý Thủ Quỹ -->
                @can('view-thu-quy-dashboard')
                    <li class="nav-item {{ request()->routeIs('_thu_quy.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('_thu_quy.*') ? 'active' : '' }}">
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
                                    <i class="fas fa-tachometer-alt nav-icon"></i>
                                    <p>Tổng quan</p>
                                </a>
                            </li>
                            <!-- Quản lý Quỹ -->
                            @can('view-thu-quy-quy')
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.quy.index') }}"
                                       class="nav-link {{ request()->routeIs('_thu_quy.quy.*') ? 'active' : '' }}">
                                        <i class="fas fa-piggy-bank nav-icon"></i>
                                        <p>Quản lý Quỹ</p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Giao dịch -->
                            @can('view-thu-quy-giao-dich')
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.giao_dich.index') }}"
                                       class="nav-link {{ request()->routeIs('_thu_quy.giao_dich.*') ? 'active' : '' }}">
                                        <i class="fas fa-exchange-alt nav-icon"></i>
                                        <p>Giao dịch</p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Chi định kỳ -->
                            @can('view-thu-quy-chi-dinh-ky')
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.chi_dinh_ky.index') }}"
                                       class="nav-link {{ request()->routeIs('_thu_quy.chi_dinh_ky.*') ? 'active' : '' }}">
                                        <i class="fas fa-calendar-alt nav-icon"></i>
                                        <p>Chi định kỳ</p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Báo cáo -->
                            @can('view-thu-quy-bao-cao')
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.bao_cao.index') }}"
                                       class="nav-link {{ request()->routeIs('_thu_quy.bao_cao.*') ? 'active' : '' }}">
                                        <i class="fas fa-chart-line nav-icon"></i>
                                        <p>Báo cáo</p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Lịch sử thao tác -->
                            @can('view-thu-quy-lich-su')
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.lich_su.index') }}"
                                       class="nav-link {{ request()->routeIs('_thu_quy.lich_su.*') ? 'active' : '' }}">
                                        <i class="fas fa-history nav-icon"></i>
                                        <p>Lịch sử thao tác</p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Thông báo -->
                            @can('view-thu-quy-thong-bao')
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.thong_bao.index') }}"
                                       class="nav-link {{ request()->routeIs('_thu_quy.thong_bao.*') ? 'active' : '' }}">
                                        <i class="fas fa-bell nav-icon"></i>
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
                            @endcan
                        </ul>
                    </li>
                @endcan

                <!-- Quản lý Thiết Bị -->
                @if(Auth::user()->hasAnyPermission(['view-thiet-bi', 'view-nha-cung-cap', 'view-lich-su-bao-tri']))
                    <li class="nav-item {{ request()->routeIs('thiet-bi.*', 'nha-cung-cap.*', 'lich-su-bao-tri.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('thiet-bi.*', 'nha-cung-cap.*', 'lich-su-bao-tri.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-laptop"></i>
                            <p>
                                Quản lý Thiết Bị
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Danh sách Thiết Bị -->
                            @can('view-thiet-bi')
                                <li class="nav-item">
                                    <a href="{{ route('thiet-bi.index') }}"
                                       class="nav-link {{ request()->routeIs('thiet-bi.index') ? 'active' : '' }}">
                                        <i class="fas fa-list-ul nav-icon"></i>
                                        <p>Danh sách Thiết Bị</p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Cảnh Báo -->
                            @can('view-thiet-bi-canh-bao')
                                <li class="nav-item">
                                    <a href="{{ route('thiet-bi.canh-bao') }}"
                                       class="nav-link {{ request()->routeIs('thiet-bi.canh-bao') ? 'active' : '' }}">
                                        <i class="fas fa-exclamation-triangle nav-icon"></i>
                                        <p>Cảnh Báo</p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Báo Cáo Thống Kê -->
                            @can('view-thiet-bi-bao-cao')
                                <li class="nav-item">
                                    <a href="{{ route('thiet-bi.bao-cao') }}"
                                       class="nav-link {{ request()->routeIs('thiet-bi.bao-cao') ? 'active' : '' }}">
                                        <i class="fas fa-chart-bar nav-icon"></i>
                                        <p>Báo Cáo Thống Kê</p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Lịch Sử Bảo Trì -->
                            @can('view-lich-su-bao-tri')
                                <li class="nav-item">
                                    <a href="{{ route('thiet-bi.index') }}"
                                       class="nav-link {{ request()->routeIs('lich-su-bao-tri.*') ? 'active' : '' }}">
                                        <i class="fas fa-tools nav-icon"></i>
                                        <p>Lịch Sử Bảo Trì</p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Export -->
                            @can('export-thiet-bi')
                                <li class="nav-item {{ request()->routeIs('thiet-bi.export-excel', 'thiet-bi.export-pdf') ? 'menu-open' : '' }}">
                                    <a href="#" class="nav-link {{ request()->routeIs('thiet-bi.export-excel', 'thiet-bi.export-pdf') ? 'active' : '' }}">
                                        <i class="fas fa-file-export nav-icon"></i>
                                        <p>
                                            Xuất Báo Cáo
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('thiet-bi.export-excel') }}"
                                               class="nav-link {{ request()->routeIs('thiet-bi.export-excel') ? 'active' : '' }}">
                                                <i class="fas fa-file-excel nav-icon"></i>
                                                <p>Xuất Excel</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('thiet-bi.export-pdf') }}"
                                               class="nav-link {{ request()->routeIs('thiet-bi.export-pdf') ? 'active' : '' }}">
                                                <i class="fas fa-file-pdf nav-icon"></i>
                                                <p>Xuất PDF</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            <!-- Nhà Cung Cấp -->
                            @can('view-nha-cung-cap')
                                <li class="nav-item">
                                    <a href="{{ route('nha-cung-cap.index') }}"
                                       class="nav-link {{ request()->routeIs('nha-cung-cap.*') ? 'active' : '' }}">
                                        <i class="fas fa-truck nav-icon"></i>
                                        <p>Nhà Cung Cấp</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                <!-- Quản lý Thông Báo -->
                @can('view-thong-bao')
                    <li class="nav-item {{ request()->routeIs('thong-bao.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('thong-bao.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-envelope"></i>
                            <p>
                                Quản lý Thông Báo
                                <i class="fas fa-angle-left right"></i>
                                @php
                                    $thongBaoChuaDoc = Auth::check() ?
                                        \App\Models\ThongBao::where('nguoi_nhan_id', Auth::id())
                                            ->where('da_doc', false)
                                            ->count() : 0;
                                @endphp
                                @if($thongBaoChuaDoc > 0)
                                    <span class="badge badge-danger right">{{ $thongBaoChuaDoc }}</span>
                                @endif
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Tổng quan -->
                            <li class="nav-item">
                                <a href="{{ route('thong-bao.index') }}"
                                   class="nav-link {{ Request::is('thong-bao') ? 'active' : '' }}">
                                    <i class="fas fa-th-large nav-icon"></i>
                                    <p>Tổng quan</p>
                                </a>
                            </li>
                            <!-- Hộp thư đến -->
                            @can('view-thong-bao-inbox')
                                <li class="nav-item">
                                    <a href="{{ route('thong-bao.inbox') }}"
                                       class="nav-link {{ Request::is('thong-bao/inbox') ? 'active' : '' }}">
                                        <i class="fas fa-inbox nav-icon"></i>
                                        <p>
                                            Hộp thư đến
                                            @if($thongBaoChuaDoc > 0)
                                                <span class="badge badge-danger right">{{ $thongBaoChuaDoc }}</span>
                                            @endif
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Đã gửi -->
                            @can('view-thong-bao-sent')
                                <li class="nav-item">
                                    <a href="{{ route('thong-bao.sent') }}"
                                       class="nav-link {{ Request::is('thong-bao/sent') ? 'active' : '' }}">
                                        <i class="fas fa-paper-plane nav-icon"></i>
                                        <p>Đã gửi</p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Lưu trữ -->
                            @can('view-thong-bao-archived')
                                <li class="nav-item">
                                    <a href="{{ route('thong-bao.archived') }}"
                                       class="nav-link {{ Request::is('thong-bao/archived') ? 'active' : '' }}">
                                        <i class="fas fa-archive nav-icon"></i>
                                        <p>Lưu trữ</p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Soạn thông báo -->
                            @can('send-thong-bao')
                                <li class="nav-item">
                                    <a href="{{ route('thong-bao.create') }}"
                                       class="nav-link {{ Request::is('thong-bao/create') ? 'active' : '' }}">
                                        <i class="fas fa-pen nav-icon"></i>
                                        <p>Soạn thông báo</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                <!-- Phần các menu khác (báo cáo, phân quyền, cài đặt, ...) -->
                @if(Auth::user()->hasAnyPermission(['view-bao-cao-thiet-bi', 'view-bao-cao-tai-chinh', 'view-bao-cao-hoi-thanh']))
                    <li class="nav-header">BÁO CÁO & CÀI ĐẶT</li>
                    
                    <!-- Quản lý Báo Cáo -->
                    <li class="nav-item {{ request()->routeIs('_bao_cao.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('_bao_cao.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>
                                Quản lý Báo Cáo
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Báo Cáo Thiết Bị -->
                            @can('view-bao-cao-thiet-bi')
                                <li class="nav-item">
                                    <a href="{{ route('_bao_cao.thiet_bi') }}"
                                       class="nav-link {{ request()->routeIs('_bao_cao.thiet_bi') ? 'active' : '' }}">
                                        <i class="fas fa-desktop nav-icon"></i>
                                        <p>Báo Cáo Thiết Bị</p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Báo Cáo Tài Chính -->
                            @can('view-bao-cao-tai-chinh')
                                <li class="nav-item">
                                    <a href="{{ route('_bao_cao.tai_chinh') }}"
                                       class="nav-link {{ request()->routeIs('_bao_cao.tai_chinh') ? 'active' : '' }}">
                                        <i class="fas fa-money-bill-alt nav-icon"></i>
                                        <p>Báo Cáo Tài Chính</p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Báo Cáo Hội Thánh -->
                            @can('view-bao-cao-hoi-thanh')
                                <li class="nav-item">
                                    <a href="{{ route('_bao_cao.hoi_thanh') }}"
                                       class="nav-link {{ request()->routeIs('_bao_cao.hoi_thanh') ? 'active' : '' }}">
                                        <i class="fas fa-church nav-icon"></i>
                                        <p>Báo Cáo Hội Thánh</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif

                <!-- Quản Lý Phân Quyền -->
                @can('manage-phan-quyen')
                    <li class="nav-item">
                        <a href="{{ route('_phan_quyen.index') }}"
                           class="nav-link {{ request()->routeIs('_phan_quyen.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Quản Lý Phân Quyền</p>
                        </a>
                    </li>
                @endcan

                <!-- Thờ Phượng & Tài Liệu -->
                @if(Auth::user()->hasAnyPermission(['view-tho-phuong', 'view-tai-lieu']))
                    <li class="nav-header">HOẠT ĐỘNG HỘI THÁNH</li>
                    
                    <!-- Thờ Phượng -->
                    @can('view-tho-phuong')
                        <li class="nav-item {{ request()->routeIs('_tho_phuong.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('_tho_phuong.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-pray"></i>
                                <p>
                                    Thờ Phượng
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('_tho_phuong.buoi_nhom') }}"
                                       class="nav-link {{ request()->routeIs('_tho_phuong.buoi_nhom') ? 'active' : '' }}">
                                        <i class="fas fa-book-open nav-icon"></i>
                                        <p>Buổi Nhóm</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('_tho_phuong.ngay_le') }}"
                                       class="nav-link {{ request()->routeIs('_tho_phuong.ngay_le') ? 'active' : '' }}">
                                        <i class="fas fa-calendar-alt nav-icon"></i>
                                        <p>Ngày Lễ</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan

                    <!-- Tài Liệu -->
                    @can('view-tai-lieu')
                        <li class="nav-item {{ request()->routeIs('_tai_lieu.*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->routeIs('_tai_lieu.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-file-alt"></i>
                                <p>
                                    Tài Liệu
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('_tai_lieu.index') }}"
                                       class="nav-link {{ request()->routeIs('_tai_lieu.index') ? 'active' : '' }}">
                                        <i class="fas fa-folder-open nav-icon"></i>
                                        <p>Danh sách tài liệu</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                @endif

                <!-- Cài đặt Hệ thống -->
                @if(Auth::user()->hasAnyPermission(['view-cai-dat', 'view-nguoi-dung']))
                    <li class="nav-header">HỆ THỐNG</li>
                    
                    <li class="nav-item {{ request()->routeIs('_cai_dat.*', 'nguoi_dung.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->routeIs('_cai_dat.*', 'nguoi_dung.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Cài đặt Hệ thống
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Người Dùng -->
                            @can('view-nguoi-dung')
                                <li class="nav-item">
                                    <a href="{{ route('nguoi_dung.index') }}"
                                       class="nav-link {{ request()->routeIs('nguoi_dung.*') ? 'active' : '' }}">
                                        <i class="fas fa-users-cog nav-icon"></i>
                                        <p>Người Dùng</p>
                                    </a>
                                </li>
                            @endcan
                            <!-- Cài đặt -->
                            @can('view-cai-dat')
                                <li class="nav-item {{ request()->routeIs('_cai_dat.*') ? 'menu-open' : '' }}">
                                    <a href="#" class="nav-link {{ request()->routeIs('_cai_dat.*') ? 'active' : '' }}">
                                        <i class="fas fa-sliders-h nav-icon"></i>
                                        <p>
                                            Cài đặt
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('_cai_dat.he_thong') }}"
                                               class="nav-link {{ request()->routeIs('_cai_dat.he_thong') ? 'active' : '' }}">
                                                <i class="fas fa-server nav-icon"></i>
                                                <p>Cài đặt Hệ thống</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                
                <!-- Tài khoản -->
                <li class="nav-header">TÀI KHOẢN</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>Thông tin cá nhân</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Đăng xuất</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        
        <!-- Phiên bản hệ thống -->
        <div class="sidebar-footer mt-3 mb-3 text-center text-muted">
            <small>Phiên bản: 1.0.0</small>
        </div>
    </div>
</aside>