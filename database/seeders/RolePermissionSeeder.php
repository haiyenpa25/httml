<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\NguoiDung;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Danh sách tất cả quyền
        $permissions = [
            // Quản lý vai trò và quyền
            'manage-roles',
            'manage-permissions',
            // Trang chủ
            'view-dashboard',
            // Tín hữu
            'view-tin-huu',
            'create-tin-huu',
            'update-tin-huu',
            'delete-tin-huu',
            'view-nhan-su',
            // Lớp học
            'view-lop-hoc',
            'create-lop-hoc',
            'edit-lop-hoc',
            'delete-lop-hoc',
            'manage-hoc-vien',
            // Phân quyền
            'manage-phan-quyen',
            // Người dùng
            'view-nguoi-dung',
            'create-nguoi-dung',
            'update-nguoi-dung',
            'delete-nguoi-dung',
            // Hộ gia đình
            'view-ho-gia-dinh',
            'create-ho-gia-dinh',
            'update-ho-gia-dinh',
            'delete-ho-gia-dinh',
            // Thân hữu
            'view-than-huu',
            'manage-than-huu',
            // Thiết bị
            'view-thiet-bi',
            'manage-thiet-bi',
            'view-thiet-bi-bao-cao',
            'view-thiet-bi-canh-bao',
            'export-thiet-bi',
            'view-nha-cung-cap',
            'manage-nha-cung-cap',
            'view-lich-su-bao-tri',
            'manage-lich-su-bao-tri',
            // Tài chính
            'view-thu-quy-dashboard',
            'view-thu-quy-thong-bao',
            'view-thu-quy-quy',
            'manage-thu-quy-quy',
            'view-thu-quy-giao-dich',
            'manage-thu-quy-giao-dich',
            'duyet-thu-quy-giao-dich',
            'search-thu-quy-giao-dich',
            'export-thu-quy-giao-dich',
            'view-thu-quy-chi-dinh-ky',
            'manage-thu-quy-chi-dinh-ky',
            'view-thu-quy-bao-cao',
            'manage-thu-quy-bao-cao',
            'view-thu-quy-lich-su',
            'view-bao-cao-tai-chinh',
            // Thờ phượng
            'view-tho-phuong',
            'manage-tho-phuong',
            // Tài liệu
            'view-tai-lieu',
            'manage-tai-lieu',
            // Thông báo
            'view-thong-bao',
            'view-thong-bao-inbox',
            'view-thong-bao-archived',
            'view-thong-bao-sent',
            'manage-thong-bao',
            'delete-thong-bao',
            'send-thong-bao',
            // Cài đặt
            'view-cai-dat',
            // Buổi nhóm
            'view-buoi-nhom',
            'manage-buoi-nhom',
            // Báo cáo
            'view-bao-cao-thiet-bi',
            'view-bao-cao-hoi-thanh',
            // Diễn giả
            'view-dien-gia',
            'manage-dien-gia',
            // Ban ngành (chung)
            'view-ban-nganh',
            // Ban Trung Lão
            'view-ban-nganh-trung-lao',
            'view-thanh-vien-ban-nganh-trung-lao',
            'manage-thanh-vien-ban-nganh-trung-lao',
            'diem-danh-ban-nganh-trung-lao',
            'manage-buoi-nhom-ban-nganh-trung-lao',
            'tham-vieng-ban-nganh-trung-lao',
            'manage-tham-vieng-ban-nganh-trung-lao',
            'phan-cong-ban-nganh-trung-lao',
            'phan-cong-chi-tiet-ban-nganh-trung-lao',
            'manage-phan-cong-ban-nganh-trung-lao',
            'nhap-lieu-bao-cao-ban-nganh-trung-lao',
            'bao-cao-ban-nganh-trung-lao',
            'manage-bao-cao-ban-nganh-trung-lao',
            // Ban Thanh Tráng
            'view-ban-nganh-thanh-trang',
            'view-thanh-vien-ban-nganh-thanh-trang',
            'manage-thanh-vien-ban-nganh-thanh-trang',
            'diem-danh-ban-nganh-thanh-trang',
            'manage-buoi-nhom-ban-nganh-thanh-trang',
            'tham-vieng-ban-nganh-thanh-trang',
            'manage-tham-vieng-ban-nganh-thanh-trang',
            'phan-cong-ban-nganh-thanh-trang',
            'phan-cong-chi-tiet-ban-nganh-thanh-trang',
            'manage-phan-cong-ban-nganh-thanh-trang',
            'nhap-lieu-bao-cao-ban-nganh-thanh-trang',
            'bao-cao-ban-nganh-thanh-trang',
            'manage-bao-cao-ban-nganh-thanh-trang',
            // Ban Thanh Niên
            'view-ban-nganh-thanh-nien',
            'view-thanh-vien-ban-nganh-thanh-nien',
            'manage-thanh-vien-ban-nganh-thanh-nien',
            'diem-danh-ban-nganh-thanh-nien',
            'manage-buoi-nhom-ban-nganh-thanh-nien',
            'tham-vieng-ban-nganh-thanh-nien',
            'manage-tham-vieng-ban-nganh-thanh-nien',
            'phan-cong-ban-nganh-thanh-nien',
            'phan-cong-chi-tiet-ban-nganh-thanh-nien',
            'manage-phan-cong-ban-nganh-thanh-nien',
            'nhap-lieu-bao-cao-ban-nganh-thanh-nien',
            'bao-cao-ban-nganh-thanh-nien',
            'manage-bao-cao-ban-nganh-thanh-nien',
            // Ban Thiếu Nhi
            'view-ban-nganh-thieu-nhi',
            'view-thanh-vien-ban-nganh-thieu-nhi',
            'manage-thanh-vien-ban-nganh-thieu-nhi',
            'diem-danh-ban-nganh-thieu-nhi',
            'manage-buoi-nhom-ban-nganh-thieu-nhi',
            'tham-vieng-ban-nganh-thieu-nhi',
            'manage-tham-vieng-ban-nganh-thieu-nhi',
            'phan-cong-ban-nganh-thieu-nhi',
            'phan-cong-chi-tiet-ban-nganh-thieu-nhi',
            'manage-phan-cong-ban-nganh-thieu-nhi',
            'nhap-lieu-bao-cao-ban-nganh-thieu-nhi',
            'bao-cao-ban-nganh-thieu-nhi',
            'manage-bao-cao-ban-nganh-thieu-nhi',
            // Ban Cơ Đốc Giáo Dục
            'view-ban-co-doc-giao-duc',
            'view-thanh-vien-ban-co-doc-giao-duc',
            'manage-thanh-vien-ban-co-doc-giao-duc',
            'diem-danh-ban-co-doc-giao-duc',
            'manage-buoi-nhom-ban-co-doc-giao-duc',
            'phan-cong-ban-co-doc-giao-duc',
            'phan-cong-chi-tiet-ban-co-doc-giao-duc',
            'manage-phan-cong-ban-co-doc-giao-duc',
            'nhap-lieu-bao-cao-ban-co-doc-giao-duc',
            'bao-cao-ban-co-doc-giao-duc',
            'manage-bao-cao-ban-co-doc-giao-duc',
            'manage-diem-danh-ban-co-doc-giao-duc',
        ];

        // Tạo hoặc lấy quyền nếu đã tồn tại
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Tạo hoặc lấy vai trò
        $quanTri = Role::firstOrCreate(['name' => 'quan_tri', 'guard_name' => 'web']);
        $truongBan = Role::firstOrCreate(['name' => 'truong_ban', 'guard_name' => 'web']);
        $thanhVien = Role::firstOrCreate(['name' => 'thanh_vien', 'guard_name' => 'web']);

        // Gán quyền cho vai trò
        // Quản trị: Có tất cả quyền
        $quanTri->syncPermissions($permissions);

        // Trưởng ban: Có quyền quản lý ban ngành, tài chính, buổi nhóm, v.v.
        $truongBanPermissions = [
            'view-dashboard',
            'view-tin-huu',
            'view-nhan-su',
            'view-lop-hoc',
            'manage-hoc-vien',
            'view-nguoi-dung',
            'view-ho-gia-dinh',
            'view-than-huu',
            'view-thiet-bi',
            'view-thiet-bi-bao-cao',
            'view-nha-cung-cap',
            'view-lich-su-bao-tri',
            'view-thu-quy-dashboard',
            'view-thu-quy-thong-bao',
            'view-thu-quy-quy',
            'view-thu-quy-giao-dich',
            'view-thu-quy-chi-dinh-ky',
            'view-thu-quy-bao-cao',
            'view-thu-quy-lich-su',
            'view-bao-cao-tai-chinh',
            'view-tho-phuong',
            'view-tai-lieu',
            'view-thong-bao',
            'view-thong-bao-inbox',
            'view-cai-dat',
            'view-buoi-nhom',
            'manage-buoi-nhom',
            'view-bao-cao-thiet-bi',
            'view-bao-cao-hoi-thanh',
            'view-dien-gia',
            'view-ban-nganh',
            // Ban Trung Lão
            'view-ban-nganh-trung-lao',
            'view-thanh-vien-ban-nganh-trung-lao',
            'manage-thanh-vien-ban-nganh-trung-lao',
            'diem-danh-ban-nganh-trung-lao',
            'manage-buoi-nhom-ban-nganh-trung-lao',
            'tham-vieng-ban-nganh-trung-lao',
            'manage-tham-vieng-ban-nganh-trung-lao',
            'phan-cong-ban-nganh-trung-lao',
            'manage-phan-cong-ban-nganh-trung-lao',
            'nhap-lieu-bao-cao-ban-nganh-trung-lao',
            'bao-cao-ban-nganh-trung-lao',
            'manage-bao-cao-ban-nganh-trung-lao',
            // Ban Thanh Tráng
            'view-ban-nganh-thanh-trang',
            'view-thanh-vien-ban-nganh-thanh-trang',
            'manage-thanh-vien-ban-nganh-thanh-trang',
            'diem-danh-ban-nganh-thanh-trang',
            'manage-buoi-nhom-ban-nganh-thanh-trang',
            'tham-vieng-ban-nganh-thanh-trang',
            'manage-tham-vieng-ban-nganh-thanh-trang',
            'phan-cong-ban-nganh-thanh-trang',
            'manage-phan-cong-ban-nganh-thanh-trang',
            'nhap-lieu-bao-cao-ban-nganh-thanh-trang',
            'bao-cao-ban-nganh-thanh-trang',
            'manage-bao-cao-ban-nganh-thanh-trang',
            // Ban Thanh Niên
            'view-ban-nganh-thanh-nien',
            'view-thanh-vien-ban-nganh-thanh-nien',
            'manage-thanh-vien-ban-nganh-thanh-nien',
            'diem-danh-ban-nganh-thanh-nien',
            'manage-buoi-nhom-ban-nganh-thanh-nien',
            'tham-vieng-ban-nganh-thanh-nien',
            'manage-tham-vieng-ban-nganh-thanh-nien',
            'phan-cong-ban-nganh-thanh-nien',
            'manage-phan-cong-ban-nganh-thanh-nien',
            'nhap-lieu-bao-cao-ban-nganh-thanh-nien',
            'bao-cao-ban-nganh-thanh-nien',
            'manage-bao-cao-ban-nganh-thanh-nien',
            // Ban Thiếu Nhi
            'view-ban-nganh-thieu-nhi',
            'view-thanh-vien-ban-nganh-thieu-nhi',
            'manage-thanh-vien-ban-nganh-thieu-nhi',
            'diem-danh-ban-nganh-thieu-nhi',
            'manage-buoi-nhom-ban-nganh-thieu-nhi',
            'tham-vieng-ban-nganh-thieu-nhi',
            'manage-tham-vieng-ban-nganh-thieu-nhi',
            'phan-cong-ban-nganh-thieu-nhi',
            'manage-phan-cong-ban-nganh-thieu-nhi',
            'nhap-lieu-bao-cao-ban-nganh-thieu-nhi',
            'bao-cao-ban-nganh-thieu-nhi',
            'manage-bao-cao-ban-nganh-thieu-nhi',
            // Ban Cơ Đốc Giáo Dục
            'view-ban-co-doc-giao-duc',
            'view-thanh-vien-ban-co-doc-giao-duc',
            'manage-thanh-vien-ban-co-doc-giao-duc',
            'diem-danh-ban-co-doc-giao-duc',
            'manage-buoi-nhom-ban-co-doc-giao-duc',
            'phan-cong-ban-co-doc-giao-duc',
            'manage-phan-cong-ban-co-doc-giao-duc',
            'nhap-lieu-bao-cao-ban-co-doc-giao-duc',
            'bao-cao-ban-co-doc-giao-duc',
            'manage-bao-cao-ban-co-doc-giao-duc',
            'manage-diem-danh-ban-co-doc-giao-duc',
        ];
        $truongBan->syncPermissions($truongBanPermissions);

        // Thành viên: Chỉ có quyền xem cơ bản
        $thanhVienPermissions = [
            'view-dashboard',
            'view-tin-huu',
            'view-lop-hoc',
            'view-ho-gia-dinh',
            'view-than-huu',
            'view-thiet-bi',
            'view-thu-quy-thong-bao',
            'view-tho-phuong',
            'view-tai-lieu',
            'view-thong-bao',
            'view-thong-bao-inbox',
            'view-buoi-nhom',
            'view-dien-gia',
            'view-ban-nganh',
            'view-ban-nganh-trung-lao',
            'view-ban-nganh-thanh-trang',
            'view-ban-nganh-thanh-nien',
            'view-ban-nganh-thieu-nhi',
            'view-ban-co-doc-giao-duc',
        ];
        $thanhVien->syncPermissions($thanhVienPermissions);

        // Gán vai trò cho người dùng
        $admin = NguoiDung::find(1);
        if (!$admin) {
            throw new \Exception('Người dùng ID=1 không tồn tại. Vui lòng kiểm tra bảng nguoi_dung.');
        }
        $admin->syncRoles('quan_tri');

        // Gán vai trò trưởng ban cho các người dùng là trưởng ban trong ban_nganh
        $truongBanIds = [18, 40, 46, 1]; // Từ bảng ban_nganh
        $truongBanUsers = NguoiDung::whereIn('tin_huu_id', $truongBanIds)->get();
        foreach ($truongBanUsers as $user) {
            $user->syncRoles('truong_ban');
        }
    }
}
