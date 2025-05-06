<li class="nav-item">
    <a href="{{ route('_ban_nganh.index') }}"
        class="nav-link {{ request()->routeIs('_ban_nganh.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Danh sách Ban Ngành</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('_ban_nganh.index', ['ban' => 'ban-thanh-nien']) }}"
        class="nav-link {{ request()->routeIs('_ban_nganh.*') && request()->segment(2) === 'ban-thanh-nien' ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Ban Thanh Niên</p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('_bao_cao.ban_nganh.thanh_nien') }}"
                class="nav-link {{ request()->routeIs('_bao_cao.ban_nganh.thanh_nien') ? 'active' : '' }}">
                <i class="fas fa-file-alt nav-icon"></i>
                <p>Báo cáo</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('_ban_nganh.index', ['ban' => 'ban-thanh-trang']) }}"
        class="nav-link {{ request()->routeIs('_ban_nganh.*') && request()->segment(2) === 'ban-thanh-trang' ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Ban Thanh Tráng</p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('_bao_cao.ban_nganh.thanh_trang') }}"
                class="nav-link {{ request()->routeIs('_bao_cao.ban_nganh.thanh_trang') ? 'active' : '' }}">
                <i class="fas fa-file-alt nav-icon"></i>
                <p>Báo cáo</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('_ban_nganh.index', ['ban' => 'ban-thieu-nhi-au']) }}"
        class="nav-link {{ request()->routeIs('_ban_nganh.*') && request()->segment(2) === 'ban-thieu-nhi-au' ? 'active' : '' }}">
        <i class="nav-icon fas fa-child"></i>
        <p>Ban Thiếu Nhi Ấu</p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('_bao_cao.ban_nganh.thieu_nhi_au') }}"
                class="nav-link {{ request()->routeIs('_bao_cao.ban_nganh.thieu_nhi_au') ? 'active' : '' }}">
                <i class="fas fa-file-alt nav-icon"></i>
                <p>Báo cáo</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('_ban_nganh.index', ['ban' => 'ban-trung-lao']) }}"
        class="nav-link {{ request()->routeIs('_ban_nganh.*') && request()->segment(2) === 'ban-trung-lao' ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Ban Trung Lão</p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('_bao_cao.ban_nganh.trung_lao') }}"
                class="nav-link {{ request()->routeIs('_bao_cao.ban_nganh.trung_lao') ? 'active' : '' }}">
                <i class="fas fa-file-alt nav-icon"></i>
                <p>Báo cáo</p>
            </a>
        </li>
    </ul>
</li>
















{{-- <li class="nav-item">
    <a href="{{ route('_ban_chap_su.index') }}"
        class="nav-link {{ request()->routeIs('_ban_chap_su.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Ban Chấp Sự</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('_ban_am_thuc.index') }}"
        class="nav-link {{ request()->routeIs('_ban_am_thuc.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-utensils"></i>
        <p>Ban Ẩm Thực</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('_ban_cau_nguyen.index') }}"
        class="nav-link {{ request()->routeIs('_ban_cau_nguyen.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-pray"></i>
        <p>Ban Cầu Nguyện</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('_ban_chung_dao.index') }}"
        class="nav-link {{ request()->routeIs('_ban_chung_dao.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-bible"></i>
        <p>Ban Chứng Đạo</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('_ban_dan.index') }}"
        class="nav-link {{ request()->routeIs('_ban_dan.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-guitar"></i>
        <p>Ban Đàn</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('_ban_hau_can.index') }}"
        class="nav-link {{ request()->routeIs('_ban_hau_can.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tools"></i>
        <p>Ban Hậu Cần</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('_ban_hat_tho_phuong.index') }}"
        class="nav-link {{ request()->routeIs('_ban_hat_tho_phuong.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-music"></i>
        <p>Ban Hát Thờ Phượng</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('_ban_khanh_tiet.index') }}"
        class="nav-link {{ request()->routeIs('_ban_khanh_tiet.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-star"></i>
        <p>Ban Khánh Tiết</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('_ban_ky_thuat_am_thanh.index') }}"
        class="nav-link {{ request()->routeIs('_ban_ky_thuat_am_thanh.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-microphone-alt"></i>
        <p>Ban Kỹ Thuật - Âm Thanh</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('_ban_le_tan.index') }}"
        class="nav-link {{ request()->routeIs('_ban_le_tan.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-concierge-bell"></i>
        <p>Ban Lễ Tân</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('_ban_may_chieu.index') }}"
        class="nav-link {{ request()->routeIs('_ban_may_chieu.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-projector"></i>
        <p>Ban Máy Chiếu</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('_ban_tham_vieng.index') }}"
        class="nav-link {{ request()->routeIs('_ban_tham_vieng.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-handshake"></i>
        <p>Ban Thăm Viếng</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('_ban_trat_tu.index') }}"
        class="nav-link {{ request()->routeIs('_ban_trat_tu.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-shield-alt"></i>
        <p>Ban Trật Tự</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('_ban_truyen_giang.index') }}"
        class="nav-link {{ request()->routeIs('_ban_truyen_giang.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-bullhorn"></i>
        <p>Ban Truyền Giảng</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('_ban_truyen_thong_may_chieu.index') }}"
        class="nav-link {{ request()->routeIs('_ban_truyen_thong_may_chieu.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-video"></i>
        <p>Ban Truyền Thông - Máy Chiếu</p>
    </a>
</li> --}}

