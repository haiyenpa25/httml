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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Quản lý Người Dùng & Tín Hữu -->
                <li class="nav-item {{ request()->routeIs('nguoi_dung.*', '_tin_huu.*', '_ho_gia_dinh.*', '_than_huu.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Người Dùng & Tín Hữu
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('nguoi_dung.index') }}"
                                class="nav-link {{ request()->routeIs('nguoi_dung.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Người Dùng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('_tin_huu.index') }}"
                                class="nav-link {{ request()->routeIs('_tin_huu.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Tín Hữu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('_tin_huu.create') }}"
                                class="nav-link {{ request()->routeIs('_tin_huu.create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Tín Hữu mới</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('_tin_huu.nhan_su') }}"
                                class="nav-link {{ request()->routeIs('_tin_huu.nhan_su') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nhân sự</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('_ho_gia_dinh.index') }}"
                                class="nav-link {{ request()->routeIs('_ho_gia_dinh.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hộ Gia Đình</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('_than_huu.index') }}"
                                class="nav-link {{ request()->routeIs('_than_huu.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thân Hữu</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Quản lý Ban Ngành -->
                <li class="nav-item {{ request()->routeIs('_ban_nganh.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-sitemap"></i>
                        <p>
                            Ban Ngành
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">                        
                            @php
                                // Map ban identifiers to proper Vietnamese display names
                                $banNames = [
                                    'trung_lao' => 'Ban Trung Lão',
                                    'thanh_trang' => 'Ban Thanh Tráng',
                                    'thanh_nien' => 'Ban Thanh Niên',
                                    'thieu_nhi_au' => 'Ban Thiếu Nhi Ấu',
                                ];
                            @endphp
                            
                            @foreach(['trung_lao', 'thanh_trang', 'thanh_nien', 'thieu_nhi_au'] as $ban)
                                <li class="nav-item">
                                    <a href="{{ route('_ban_nganh.' . $ban . '.index') }}"
                                    class="nav-link {{ request()->routeIs('_ban_nganh.' . $ban . '.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>{{ $banNames[$ban] }}</p>
                                    </a>
                                </li>
                            @endforeach
                       
                        <!-- Các ban khác (từ comment) -->
                        @foreach([
                            'chap_su' => 'Ban Chấp Sự',
                            'am_thuc' => 'Ban Ẩm Thực',
                            'cau_nguyen' => 'Ban Cầu Nguyện',
                            'chung_dao' => 'Ban Chứng Đạo',
                            'dan' => 'Ban Đàn',
                            'hau_can' => 'Ban Hậu Cần',
                            'hat_tho_phuong' => 'Ban Hát Thờ Phượng',
                            'khanh_tiet' => 'Ban Khánh Tiết',
                            'ky_thuat_am_thanh' => 'Ban Kỹ Thuật - Âm Thanh',
                            'le_tan' => 'Ban Lễ Tân',
                            'may_chieu' => 'Ban Máy Chiếu',
                            'tham_vieng' => 'Ban Thăm Viếng',
                            'trat_tu' => 'Ban Trật Tự',
                            'truyen_giang' => 'Ban Truyền Giảng',
                            'truyen_thong_may_chieu' => 'Ban Truyền Thông - Máy Chiếu'
                        ] as $ban => $label)
                            @if(Route::has('_ban_' . $ban . '.index'))
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
                </li>

                <!-- Quản lý Thủ Quỹ -->
                @if (Auth::check() && Auth::user()->vai_tro === 'quan_tri')
                    <li class="nav-item {{ request()->routeIs('_thu_quy.*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-money-bill-wave"></i>
                            <p>
                                Thủ Quỹ
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('_thu_quy.dashboard') }}"
                                    class="nav-link {{ request()->routeIs('_thu_quy.dashboard') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            @if(Route::has('_thu_quy.quy.index'))
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.quy.index') }}"
                                        class="nav-link {{ request()->routeIs('_thu_quy.quy.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Quản lý Quỹ</p>
                                    </a>
                                </li>
                            @endif
                            @if(Route::has('_thu_quy.giao_dich.index'))
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.giao_dich.index') }}"
                                        class="nav-link {{ request()->routeIs('_thu_quy.giao_dich.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Giao dịch</p>
                                    </a>
                                </li>
                            @endif
                            @if(Route::has('_thu_quy.chi_dinh_ky.index'))
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.chi_dinh_ky.index') }}"
                                        class="nav-link {{ request()->routeIs('_thu_quy.chi_dinh_ky.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Chi định kỳ</p>
                                    </a>
                                </li>
                            @endif
                            @if(Route::has('_thu_quy.bao_cao.index'))
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.bao_cao.index') }}"
                                        class="nav-link {{ request()->routeIs('_thu_quy.bao_cao.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Báo cáo</p>
                                    </a>
                                </li>
                            @endif
                            @if(Route::has('_thu_quy.lich_su.index'))
                                <li class="nav-item">
                                    <a href="{{ route('_thu_quy.lich_su.index') }}"
                                        class="nav-link {{ request()->routeIs('_thu_quy.lich_su.*') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lịch sử thao tác</p>
                                    </a>
                                </li>
                            @endif
                            @if(Route::has('_thu_quy.thong_bao.index'))
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
                <li class="nav-item {{ request()->routeIs('thiet-bi.*', 'nha-cung-cap.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-desktop"></i>
                        <p>
                            Thiết Bị
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('thiet-bi.index') }}"
                                class="nav-link {{ request()->routeIs('thiet-bi.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Thiết Bị</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('nha-cung-cap.index') }}"
                                class="nav-link {{ request()->routeIs('nha-cung-cap.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nhà Cung Cấp</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('thiet-bi.canh-bao') }}"
                                class="nav-link {{ request()->routeIs('thiet-bi.canh-bao') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cảnh Báo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('thiet-bi.bao-cao') }}"
                                class="nav-link {{ request()->routeIs('thiet-bi.bao-cao') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Báo Cáo Thống Kê</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Quản lý Thông Báo -->
                <li class="nav-item {{ request()->routeIs('thong-bao.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>
                            Thông Báo
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('thong-bao.index') }}"
                                class="nav-link {{ Request::is('thong-bao') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tổng quan</p>
                            </a>
                        </li>
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
                        <li class="nav-item">
                            <a href="{{ route('thong-bao.sent') }}"
                                class="nav-link {{ Request::is('thong-bao/sent') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Đã gửi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('thong-bao.archived') }}"
                                class="nav-link {{ Request::is('thong-bao/archived') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lưu trữ</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('thong-bao.create') }}"
                                class="nav-link {{ Request::is('thong-bao/create') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Soạn thông báo</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Quản lý Báo Cáo -->
                <li class="nav-item {{ request()->routeIs('_bao_cao.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Báo Cáo
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if(Route::has('_bao_cao.thiet_bi'))
                            <li class="nav-item">
                                <a href="{{ route('_bao_cao.thiet_bi') }}"
                                    class="nav-link {{ request()->routeIs('_bao_cao.thiet_bi') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Báo Cáo Thiết Bị</p>
                                </a>
                            </li>
                        @endif
                        @if(Route::has('_bao_cao.tai_chinh'))
                            <li class="nav-item">
                                <a href="{{ route('_bao_cao.tai_chinh') }}"
                                    class="nav-link {{ request()->routeIs('_bao_cao.tai_chinh') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Báo Cáo Tài Chính</p>
                                </a>
                            </li>
                        @endif
                        @if(Route::has('_bao_cao.hoi_thanh'))
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

                <!-- Diễn Giả -->
                <li class="nav-item">
                    <a href="{{ route('_dien_gia.index') }}"
                        class="nav-link {{ request()->routeIs('_dien_gia.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-microphone"></i>
                        <p>Diễn Giả</p>
                    </a>
                </li>

                <!-- Thờ Phượng -->
                <li class="nav-item">
                    <a href="{{ route('_tho_phuong.buoi_nhom') }}"
                        class="nav-link {{ request()->routeIs('_tho_phuong.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-church"></i>
                        <p>Thờ Phượng</p>
                    </a>
                </li>

                <!-- Tài Liệu -->
                <li class="nav-item">
                    <a href="{{ route('_tai_lieu.index') }}"
                        class="nav-link {{ request()->routeIs('_tai_lieu.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Tài Liệu</p>
                    </a>
                </li>

                <!-- Cài đặt Hệ thống -->
                <li class="nav-item">
                    <a href="{{ route('_cai_dat.he_thong') }}"
                        class="nav-link {{ request()->routeIs('_cai_dat.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Cài đặt Hệ thống</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>