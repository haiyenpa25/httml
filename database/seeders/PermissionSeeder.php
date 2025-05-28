<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    protected $permissions = [
        'Hệ thống' => [
            'view-dashboard' => ['description' => 'Xem Dashboard', 'default_url' => '/dashboard'],
            'manage-phan-quyen' => ['description' => 'Quản lý phân quyền', 'default_url' => '/quan-ly-phan-quyen'],
            'admin-access' => ['description' => 'Truy cập toàn hệ thống', 'default_url' => '/dashboard'],
        ],
        'Người Dùng & Tín Hữu' => [
            'view-nguoi-dung' => ['description' => 'Xem người dùng', 'default_url' => '/nguoi-dung'],
            'create-nguoi-dung' => ['description' => 'Thêm người dùng', 'default_url' => '/nguoi-dung/create'],
            'update-nguoi-dung' => ['description' => 'Sửa người dùng', 'default_url' => null],
            'delete-nguoi-dung' => ['description' => 'Xóa người dùng', 'default_url' => null],
            'view-tin-huu' => ['description' => 'Xem tín hữu', 'default_url' => '/tin-huu'],
            'create-tin-huu' => ['description' => 'Thêm tín hữu', 'default_url' => '/tin-huu/create'],
            'update-tin-huu' => ['description' => 'Sửa tín hữu', 'default_url' => null],
            'delete-tin-huu' => ['description' => 'Xóa tín hữu', 'default_url' => null],
            'view-nhan-su' => ['description' => 'Xem nhân sự', 'default_url' => '/tin-huu/nhan-su'],
            'view-ho-gia-dinh' => ['description' => 'Xem hộ gia đình', 'default_url' => '/ho-gia-dinh'],
            'create-ho-gia-dinh' => ['description' => 'Thêm hộ gia đình', 'default_url' => '/ho-gia-dinh/create'],
            'update-ho-gia-dinh' => ['description' => 'Sửa hộ gia đình', 'default_url' => null],
            'delete-ho-gia-dinh' => ['description' => 'Xóa hộ gia đình', 'default_url' => null],
            'view-than-huu' => ['description' => 'Xem thân hữu', 'default_url' => '/than-huu'],
            'manage-than-huu' => ['description' => 'Quản lý thân hữu', 'default_url' => '/than-huu'],
        ],
        // ... các nhóm quyền khác tương tự (Ban Ngành - Trung Lão, Thanh Tráng, v.v.) ...
        'Buổi Nhóm' => [
            'view-buoi-nhom' => ['description' => 'Xem buổi nhóm', 'default_url' => '/buoi-nhom'],
            'manage-buoi-nhom' => ['description' => 'Quản lý buổi nhóm', 'default_url' => '/buoi-nhom'],
        ],
        // Thêm quyền cho lớp học (dựa trên yêu cầu trước đó)
        'Lớp Học' => [
            'view-lop-hoc' => ['description' => 'Xem lớp học', 'default_url' => '/lop-hoc'],
            'tao-lop-hoc' => ['description' => 'Tạo lớp học', 'default_url' => '/lop-hoc/create'],
            'edit-lop-hoc' => ['description' => 'Sửa lớp học', 'default_url' => null],
            'delete-lop-hoc' => ['description' => 'Xóa lớp học', 'default_url' => null],
            'manage-hoc-vien' => ['description' => 'Quản lý học viên', 'default_url' => null],
        ],
    ];

    public function run()
    {
        // Tạo quyền
        foreach ($this->permissions as $group => $groupPermissions) {
            foreach ($groupPermissions as $name => $data) {
                Permission::firstOrCreate(['name' => $name], [
                    'guard_name' => 'web',
                    'description' => $data['description'],
                    'default_url' => $data['default_url'],
                ]);
            }
        }

        // Tạo vai trò và gán quyền
        // Vai trò admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $allPermissions = Permission::pluck('name')->toArray();
        $adminRole->syncPermissions($allPermissions);

        // Vai trò trưởng ban
        $truongBanRole = Role::firstOrCreate(['name' => 'truong-ban']);
        $truongBanPermissions = [];
        foreach ($this->permissions as $group => $groupPermissions) {
            if (str_contains($group, 'Ban Ngành')) {
                foreach ($groupPermissions as $permission => $data) {
                    $truongBanPermissions[] = $permission;
                }
            }
        }
        $truongBanPermissions[] = 'view-thong-bao';
        $truongBanPermissions[] = 'send-thong-bao';
        $truongBanPermissions[] = 'view-buoi-nhom';
        $truongBanRole->syncPermissions($truongBanPermissions);

        // Vai trò thành viên
        $thanhVienRole = Role::firstOrCreate(['name' => 'thanh-vien']);
        $thanhVienPermissions = [
            'view-thong-bao',
            'view-thong-bao-inbox',
            'view-buoi-nhom',
        ];
        $thanhVienRole->syncPermissions($thanhVienPermissions);
    }
}
