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
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('nguoi_dung.index') }}"
                        class="nav-link {{ request()->routeIs('nguoi_dung.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Người Dùng</p>
                    </a>
                </li>

                <!-- Quản lý Tín Hữu -->
                <li
                    class="nav-item has-treeview {{ request()->is('quan-ly-tin-huu*') || request()->routeIs('_tin_huu.*') || request()->routeIs('_ho_gia_dinh.*') || request()->routeIs('_than_huu.*') || request()->routeIs('_dien_gia.*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('quan-ly-tin-huu*') || request()->routeIs('_tin_huu.*') || request()->routeIs('_ho_gia_dinh.*') || request()->routeIs('_than_huu.*') || request()->routeIs('_dien_gia.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Quản lý Tín Hữu
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
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
                    </ul>
                </li>

                <!-- Quản lý Ban Ngành -->
                <li
                    class="nav-item has-treeview {{ request()->routeIs('_ban_nganh.*') || request()->routeIs('_ban_chap_su.*') || request()->routeIs('_ban_am_thuc.*') || request()->routeIs('_ban_cau_nguyen.*') || request()->routeIs('_ban_chung_dao.*') || request()->routeIs('_ban_co_doc_giao_duc.*') || request()->routeIs('_ban_dan.*') || request()->routeIs('_ban_hau_can.*') || request()->routeIs('_ban_hat_tho_phuong.*') || request()->routeIs('_ban_khanh_tiet.*') || request()->routeIs('_ban_ky_thuat_am_thanh.*') || request()->routeIs('_ban_le_tan.*') || request()->routeIs('_ban_may_chieu.*') || request()->routeIs('_ban_tham_vieng.*') || request()->routeIs('_ban_trat_tu.*') || request()->routeIs('_ban_truyen_giang.*') || request()->routeIs('_ban_truyen_thong_may_chieu.*') || request()->routeIs('_ban_thanh_nien.*') || request()->routeIs('_ban_thanh_trang.*') || request()->routeIs('_ban_thieu_nhi_au.*') || request()->routeIs('_ban_trung_lao.*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('_ban_nganh.*') || request()->routeIs('_ban_chap_su.*') || request()->routeIs('_ban_am_thuc.*') || request()->routeIs('_ban_cau_nguyen.*') || request()->routeIs('_ban_chung_dao.*') || request()->routeIs('_ban_co_doc_giao_duc.*') || request()->routeIs('_ban_dan.*') || request()->routeIs('_ban_hau_can.*') || request()->routeIs('_ban_hat_tho_phuong.*') || request()->routeIs('_ban_khanh_tiet.*') || request()->routeIs('_ban_ky_thuat_am_thanh.*') || request()->routeIs('_ban_le_tan.*') || request()->routeIs('_ban_may_chieu.*') || request()->routeIs('_ban_tham_vieng.*') || request()->routeIs('_ban_trat_tu.*') || request()->routeIs('_ban_truyen_giang.*') || request()->routeIs('_ban_truyen_thong_may_chieu.*') || request()->routeIs('_ban_thanh_nien.*') || request()->routeIs('_ban_thanh_trang.*') || request()->routeIs('_ban_thieu_nhi_au.*') || request()->routeIs('_ban_trung_lao.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Quản lý Ban Ngành
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('_ban_nganh.index') }}"
                                class="nav-link {{ request()->routeIs('_ban_nganh.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Ban Ngành</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('_ban_chap_su.index') }}"
                                class="nav-link {{ request()->routeIs('_ban_chap_su.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ban Chấp Sự</p>
                            </a>
                        </li>
                        <li
                            class="nav-item has-treeview {{ request()->routeIs('_ban_am_thuc.*') || request()->routeIs('_ban_cau_nguyen.*') || request()->routeIs('_ban_chung_dao.*') || request()->routeIs('_ban_co_doc_giao_duc.*') || request()->routeIs('_ban_dan.*') || request()->routeIs('_ban_hau_can.*') || request()->routeIs('_ban_hat_tho_phuong.*') || request()->routeIs('_ban_khanh_tiet.*') || request()->routeIs('_ban_ky_thuat_am_thanh.*') || request()->routeIs('_ban_le_tan.*') || request()->routeIs('_ban_may_chieu.*') || request()->routeIs('_ban_tham_vieng.*') || request()->routeIs('_ban_trat_tu.*') || request()->routeIs('_ban_truyen_giang.*') || request()->routeIs('_ban_truyen_thong_may_chieu.*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ request()->routeIs('_ban_am_thuc.*') || request()->routeIs('_ban_cau_nguyen.*') || request()->routeIs('_ban_chung_dao.*') || request()->routeIs('_ban_co_doc_giao_duc.*') || request()->routeIs('_ban_dan.*') || request()->routeIs('_ban_hau_can.*') || request()->routeIs('_ban_hat_tho_phuong.*') || request()->routeIs('_ban_khanh_tiet.*') || request()->routeIs('_ban_ky_thuat_am_thanh.*') || request()->routeIs('_ban_le_tan.*') || request()->routeIs('_ban_may_chieu.*') || request()->routeIs('_ban_tham_vieng.*') || request()->routeIs('_ban_trat_tu.*') || request()->routeIs('_ban_truyen_giang.*') || request()->routeIs('_ban_truyen_thong_may_chieu.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Ban Mục Vụ
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @foreach (['am_thuc' => 'Ẩm Thực', 'cau_nguyen' => 'Cầu Nguyện', 'chung_dao' => 'Chứng Đạo', 'co_doc_giao_duc' => 'Cơ Đốc Giáo Dục', 'dan' => 'Đàn', 'hau_can' => 'Hậu Cần', 'hat_tho_phuong' => 'Hát Thờ Phượng', 'khanh_tiet' => 'Khánh Tiết', 'ky_thuat_am_thanh' => 'Kỹ Thuật - Âm Thanh', 'le_tan' => 'Lễ Tân', 'may_chieu' => 'Máy Chiếu', 'tham_vieng' => 'Thăm Viếng', 'trat_tu' => 'Trật Tự', 'truyen_giang' => 'Truyền Giảng', 'truyen_thong_may_chieu' => 'Truyền Thông - Máy Chiếu'] as $key => $label)
                                    <li class="nav-item">
                                        <a href="{{ route('_ban_' . $key . '.index') }}"
                                            class="nav-link {{ request()->routeIs('_ban_' . $key . '.*') ? 'active' : '' }}">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>Ban {{ $label }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li
                            class="nav-item has-treeview {{ request()->routeIs('_ban_thanh_nien.*') || request()->routeIs('_ban_thanh_trang.*') || request()->routeIs('_ban_thieu_nhi_au.*') || request()->routeIs('_ban_trung_lao.*') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ request()->routeIs('_ban_thanh_nien.*') || request()->routeIs('_ban_thanh_trang.*') || request()->routeIs('_ban_thieu_nhi_au.*') || request()->routeIs('_ban_trung_lao.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Ban Ngành
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @foreach (['thanh_nien' => 'Thanh Niên', 'thanh_trang' => 'Thanh Tráng', 'thieu_nhi_au' => 'Thiếu Nhi Ấu', 'trung_lao' => 'Trung Lão'] as $key => $label)
                                    <li class="nav-item">
                                        <a href="{{ route('_ban_' . $key . '.index') }}"
                                            class="nav-link {{ request()->routeIs('_ban_' . $key . '.*') ? 'active' : '' }}">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>Ban {{ $label }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Quản lý Thân Hữu -->
                <li class="nav-item">
                    <a href="{{ route('_than_huu.index') }}"
                        class="nav-link {{ request()->routeIs('_than_huu.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Thân Hữu</p>
                    </a>
                </li>

                <!-- Quản lý Diễn Giả -->
                <li class="nav-item">
                    <a href="{{ route('_dien_gia.index') }}"
                        class="nav-link {{ request()->routeIs('_dien_gia.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-microphone"></i>
                        <p>Diễn Giả</p>
                    </a>
                </li>

                <!-- Quản lý Thiết Bị -->
                <li
                    class="nav-item has-treeview {{ request()->routeIs('thiet-bi.*') || request()->routeIs('nha-cung-cap.*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('thiet-bi.*') || request()->routeIs('nha-cung-cap.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-desktop"></i>
                        <p>
                            Quản lý Thiết Bị
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

                <!-- Quản lý Tài Chính -->
                <li class="nav-item">
                    <a href="{{ route('_tai_chinh.bao_cao') }}"
                        class="nav-link {{ request()->routeIs('_tai_chinh.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>Tài Chính</p>
                    </a>
                </li>

                <!-- Quản lý Thờ Phượng -->
                <li class="nav-item">
                    <a href="{{ route('_tho_phuong.buoi_nhom') }}"
                        class="nav-link {{ request()->routeIs('_tho_phuong.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-church"></i>
                        <p>Thờ Phượng</p>
                    </a>
                </li>

                <!-- Quản lý Tài Liệu -->
                <li class="nav-item">
                    <a href="{{ route('_tai_lieu.index') }}"
                        class="nav-link {{ request()->routeIs('_tai_lieu.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Tài Liệu</p>
                    </a>
                </li>

                <!-- Quản lý Thông Báo -->
                <li class="nav-item">
                    <a href="{{ route('_thong_bao.index') }}"
                        class="nav-link {{ request()->routeIs('_thong_bao.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>Thông Báo</p>
                    </a>
                </li>

                <!-- Báo Cáo -->
                <li class="nav-item has-treeview {{ request()->routeIs('_bao_cao.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('_bao_cao.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Báo Cáo
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('_bao_cao.hoi_thanh') }}"
                                class="nav-link {{ request()->routeIs('_bao_cao.hoi_thanh') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Báo Cáo Thờ Phượng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('_bao_cao.ban_trung_lao') }}"
                                class="nav-link {{ request()->routeIs('_bao_cao.ban_trung_lao') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Báo Cáo Ban Trung Lão</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('_bao_cao.ban_thanh_nien') }}"
                                class="nav-link {{ request()->routeIs('_bao_cao.ban_thanh_nien') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Báo Cáo Ban Thanh Niên</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('_bao_cao.thiet_bi') }}"
                                class="nav-link {{ request()->routeIs('_bao_cao.thiet_bi') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Báo Cáo Thiết Bị</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('_bao_cao.tai_chinh') }}"
                                class="nav-link {{ request()->routeIs('_bao_cao.tai_chinh') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Báo Cáo Tài Chính</p>
                            </a>
                        </li>
                    </ul>
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