<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('dashboard') }}" class="brand-link">
        <img src="{{ asset('dist/img/TMLlogo.png') }}" alt="Hội Thánh Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">HTTML</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name ?? 'Quản trị viên' }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Tìm kiếm..." aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ url('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Quản lý Ban Ngành -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Quản lý Ban Ngành
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- Ban Chấp Sự -->
                        <li class="nav-item">
                            <a href="{{ route('ban-chap-su.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ban Chấp Sự</p>
                            </a>
                        </li>

                        <!-- Ban Mục Vụ -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Ban Mục Vụ
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('ban-am-thuc.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Ẩm Thực</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-cau-nguyen.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Cầu Nguyện</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-chung-dao.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Chứng Đạo</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-co-doc-giao-duc.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Cơ Đốc Giáo Dục</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-dan.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Đàn</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-hau-can.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Hậu Cần</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-hat-tho-phuong.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Hát Thờ Phượng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-khanh-tiet.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Khánh Tiết</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-ky-thuat-am-thanh.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Kỹ Thuật - Âm Thanh</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-le-tan.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Lễ Tân</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-may-chieu.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Máy Chiếu</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-tham-vieng.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Thăm Viếng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-trat-tu.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Trật Tự</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-truyen-giang.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Truyền Giảng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-truyen-thong-may-chieu.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Truyền Thông - Máy Chiếu</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Ban Ngành -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Ban Ngành
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('ban-thanh-nien.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Thanh Niên</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-thanh-trang.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Thanh Tráng</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-thieu-nhi-au.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Thiếu Nhi Ấu</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ban-trung-lao.index') }}" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Ban Trung Lão</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- Quản lý Tín Hữu -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>
                            Quản lý Tín Hữu
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('tin-huu.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Tín Hữu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tin-huu.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Tín Hữu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tin-huu.nhan_su') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Nhân sự</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tin-huu.show', ['id' => 1]) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thông tin Tín Hữu</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Quản lý Diễn Giả -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-microphone"></i>
                        <p>
                            Quản lý Diễn Giả
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dien-gia.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Diễn Giả</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dien-gia.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Diễn Giả</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Quản lý Thân Hữu -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-handshake"></i>
                        <p>
                            Quản lý Thân Hữu
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('than-huu.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Thân Hữu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('than-huu.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Thân Hữu</p>
                            </a>
                        </li>
                         <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thông tin thân hữu</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Quản lý Thiết bị -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-desktop"></i>
                        <p>
                            Quản lý Thiết bị
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('thiet-bi.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Thiết bị</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('thiet-bi.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Thiết bị</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('thiet-bi.bao_cao') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Báo cáo thiết bị</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('thiet-bi.thanh_ly') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thanh lý thiết bị</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Quản lý Tài Chính -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            Quản lý Tài Chính
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('tai-chinh.bao_cao') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Báo cáo tài chính</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('thu-chi.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thu Chi</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Quản lý Thờ Phượng -->
                 <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-church"></i>
                        <p>
                            Quản lý Thờ Phượng
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('tho-phuong.buoi_nhom') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Buổi nhóm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tho-phuong.ngay_le') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Ngày Lễ</p>
                            </a>
                        </li>
                         <li class="nav-item">
                            <a href="{{ route('tho-phuong.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Buổi nhóm</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Quản lý Tài liệu -->
                <li class="nav-item">
                   <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Quản lý Tài liệu
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('tai-lieu.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Danh sách Tài liệu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tai-lieu.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Thêm Tài liệu</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Quản lý Thông báo -->
                <li class="nav-item">
                    <a href="{{ route('thong-bao.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>Thông báo</p>
                    </a>
                </li>

                <!-- Báo cáo -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Báo cáo
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('bao-cao.tho_phuong') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Báo cáo Thờ Phượng</p>
                            </a>
                        </li>
                          <li class="nav-item">
                            <a href="{{ route('bao-cao.thiet_bi') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Báo cáo thiết bị</p>
                            </a>
                        </li>
                          <li class="nav-item">
                            <a href="{{ route('bao-cao.tai_chinh') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Báo cáo tài chính</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('bao-cao.ban_nganh') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Báo cáo ban ngành</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Cài đặt -->
                <li class="nav-item">
                    <a href="{{ route('cai-dat.he_thong') }}" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Cài đặt Hệ thống</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>