<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('dashboard') }}" class="brand-link">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Hội Thánh Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
                        <p>Bảng thông báo</p>
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
            </ul>
        </nav>
    </div>
</aside>