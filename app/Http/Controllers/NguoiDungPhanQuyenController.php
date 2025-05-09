<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NguoiDung;
use App\Models\BanNganh;
use App\Models\NguoiDungPhanQuyen;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class NguoiDungPhanQuyenController extends Controller
{
    protected $permissions;

    public function __construct()
    {
        $this->permissions = [
            'Hệ thống' => [
                'view-dashboard' => 'Xem Dashboard',
                'manage-phan-quyen' => 'Quản lý phân quyền',
                'admin-access' => 'Truy cập toàn hệ thống',
            ],
            'Người Dùng & Tín Hữu' => [
                'view-nguoi-dung' => 'Xem người dùng',
                'create-nguoi-dung' => 'Thêm người dùng',
                'update-nguoi-dung' => 'Sửa người dùng',
                'delete-nguoi-dung' => 'Xóa người dùng',
                'view-tin-huu' => 'Xem tín hữu',
                'create-tin-huu' => 'Thêm tín hữu',
                'update-tin-huu' => 'Sửa tín hữu',
                'delete-tin-huu' => 'Xóa tín hữu',
                'view-nhan-su' => 'Xem nhân sự',
                'view-ho-gia-dinh' => 'Xem hộ gia đình',
                'create-ho-gia-dinh' => 'Thêm hộ gia đình',
                'update-ho-gia-dinh' => 'Sửa hộ gia đình',
                'delete-ho-gia-dinh' => 'Xóa hộ gia đình',
                'view-than-huu' => 'Xem thân hữu',
                'manage-than-huu' => 'Quản lý thân hữu',
            ],
            'Ban Ngành - Tổng Quan' => [
                'view-ban-nganh' => 'Xem danh sách ban ngành',
            ],
            'Ban Ngành - Trung Lão' => [
                'view-ban-nganh-trung-lao' => 'Xem tổng quan',
                'diem-danh-ban-nganh-trung-lao' => 'Điểm danh',
                'tham-vieng-ban-nganh-trung-lao' => 'Thăm viếng',
                'phan-cong-ban-nganh-trung-lao' => 'Phân công',
                'phan-cong-chi-tiet-ban-nganh-trung-lao' => 'Phân công chi tiết',
                'nhap-lieu-bao-cao-ban-nganh-trung-lao' => 'Nhập liệu báo cáo',
                'bao-cao-ban-nganh-trung-lao' => 'Xem báo cáo',
                'manage-thanh-vien-ban-nganh-trung-lao' => 'Quản lý thành viên',
                'view-thanh-vien-ban-nganh-trung-lao' => 'Xem danh sách thành viên',
                'manage-buoi-nhom-ban-nganh-trung-lao' => 'Quản lý buổi nhóm',
                'manage-tham-vieng-ban-nganh-trung-lao' => 'Quản lý thăm viếng',
                'manage-phan-cong-ban-nganh-trung-lao' => 'Quản lý phân công',
                'manage-bao-cao-ban-nganh-trung-lao' => 'Quản lý báo cáo',
            ],
            'Ban Ngành - Thanh Tráng' => [
                'view-ban-nganh-thanh-trang' => 'Xem tổng quan',
                'diem-danh-ban-nganh-thanh-trang' => 'Điểm danh',
                'tham-vieng-ban-nganh-thanh-trang' => 'Thăm viếng',
                'phan-cong-ban-nganh-thanh-trang' => 'Phân công',
                'phan-cong-chi-tiet-ban-nganh-thanh-trang' => 'Phân công chi tiết',
                'nhap-lieu-bao-cao-ban-nganh-thanh-trang' => 'Nhập liệu báo cáo',
                'bao-cao-ban-nganh-thanh-trang' => 'Xem báo cáo',
                'manage-thanh-vien-ban-nganh-thanh-trang' => 'Quản lý thành viên',
                'view-thanh-vien-ban-nganh-thanh-trang' => 'Xem danh sách thành viên',
                'manage-buoi-nhom-ban-nganh-thanh-trang' => 'Quản lý buổi nhóm',
                'manage-tham-vieng-ban-nganh-thanh-trang' => 'Quản lý thăm viếng',
                'manage-phan-cong-ban-nganh-thanh-trang' => 'Quản lý phân công',
                'manage-bao-cao-ban-nganh-thanh-trang' => 'Quản lý báo cáo',
            ],
            'Ban Ngành - Thanh Niên' => [
                'view-ban-nganh-thanh-nien' => 'Xem tổng quan',
                'diem-danh-ban-nganh-thanh-nien' => 'Điểm danh',
                'tham-vieng-ban-nganh-thanh-nien' => 'Thăm viếng',
                'phan-cong-ban-nganh-thanh-nien' => 'Phân công',
                'phan-cong-chi-tiet-ban-nganh-thanh-nien' => 'Phân công chi tiết',
                'nhap-lieu-bao-cao-ban-nganh-thanh-nien' => 'Nhập liệu báo cáo',
                'bao-cao-ban-nganh-thanh-nien' => 'Xem báo cáo',
                'manage-thanh-vien-ban-nganh-thanh-nien' => 'Quản lý thành viên',
                'view-thanh-vien-ban-nganh-thanh-nien' => 'Xem danh sách thành viên',
                'manage-buoi-nhom-ban-nganh-thanh-nien' => 'Quản lý buổi nhóm',
                'manage-tham-vieng-ban-nganh-thanh-nien' => 'Quản lý thăm viếng',
                'manage-phan-cong-ban-nganh-thanh-nien' => 'Quản lý phân công',
                'manage-bao-cao-ban-nganh-thanh-nien' => 'Quản lý báo cáo',
            ],
            'Ban Ngành - Thiếu Nhi' => [
                'view-ban-nganh-thieu-nhi' => 'Xem tổng quan',
                'diem-danh-ban-nganh-thieu-nhi' => 'Điểm danh',
                'tham-vieng-ban-nganh-thieu-nhi' => 'Thăm viếng',
                'phan-cong-ban-nganh-thieu-nhi' => 'Phân công',
                'phan-cong-chi-tiet-ban-nganh-thieu-nhi' => 'Phân công chi tiết',
                'nhap-lieu-bao-cao-ban-nganh-thieu-nhi' => 'Nhập liệu báo cáo',
                'bao-cao-ban-nganh-thieu-nhi' => 'Xem báo cáo',
                'manage-thanh-vien-ban-nganh-thieu-nhi' => 'Quản lý thành viên',
                'view-thanh-vien-ban-nganh-thieu-nhi' => 'Xem danh sách thành viên',
                'manage-buoi-nhom-ban-nganh-thieu-nhi' => 'Quản lý buổi nhóm',
                'manage-tham-vieng-ban-nganh-thieu-nhi' => 'Quản lý thăm viếng',
                'manage-phan-cong-ban-nganh-thieu-nhi' => 'Quản lý phân công',
                'manage-bao-cao-ban-nganh-thieu-nhi' => 'Quản lý báo cáo',
            ],
            'Ban Ngành - Cơ Đốc Giáo Dục' => [
                'view-ban-co-doc-giao-duc' => 'Xem tổng quan',
                'diem-danh-ban-co-doc-giao-duc' => 'Điểm danh',
                'tham-vieng-ban-co-doc-giao-duc' => 'Thăm viếng',
                'phan-cong-ban-co-doc-giao-duc' => 'Phân công',
                'phan-cong-chi-tiet-ban-co-doc-giao-duc' => 'Phân công chi tiết',
                'nhap-lieu-bao-cao-ban-co-doc-giao-duc' => 'Nhập liệu báo cáo',
                'bao-cao-ban-co-doc-giao-duc' => 'Xem báo cáo',
                'manage-thanh-vien-ban-co-doc-giao-duc' => 'Quản lý thành viên',
                'view-thanh-vien-ban-co-doc-giao-duc' => 'Xem danh sách thành viên',
                'manage-buoi-nhom-ban-co-doc-giao-duc' => 'Quản lý buổi nhóm',
                'manage-tham-vieng-ban-co-doc-giao-duc' => 'Quản lý thăm viếng',
                'manage-phan-cong-ban-co-doc-giao-duc' => 'Quản lý phân công',
                'manage-bao-cao-ban-co-doc-giao-duc' => 'Quản lý báo cáo',
            ],
            'Ban Ngành - Khác' => [
                'view-ban-chap-su' => 'Xem Ban Chấp Sự',
                'view-ban-am-thuc' => 'Xem Ban Ẩm Thực',
                'view-ban-cau-nguyen' => 'Xem Ban Cầu Nguyện',
                'view-ban-chung-dao' => 'Xem Ban Chứng Đạo',
                'view-ban-dan' => 'Xem Ban Đàn',
                'view-ban-hau-can' => 'Xem Ban Hậu Cần',
                'view-ban-hat-tho-phuong' => 'Xem Ban Hát Thờ Phượng',
                'view-ban-khanh-tiet' => 'Xem Ban Khánh Tiết',
                'view-ban-ky-thuat-am-thanh' => 'Xem Ban Kỹ Thuật - Âm Thanh',
                'view-ban-le-tan' => 'Xem Ban Lễ Tân',
                'view-ban-may-chieu' => 'Xem Ban Máy Chiếu',
                'view-ban-tham-vieng' => 'Xem Ban Thăm Viếng',
                'view-ban-trat-tu' => 'Xem Ban Trật Tự',
                'view-ban-truyen-giang' => 'Xem Ban Truyền Giảng',
                'view-ban-truyen-thong-may-chieu' => 'Xem Ban Truyền Thông - Máy Chiếu',
            ],
            'Thủ Quỹ' => [
                'view-thu-quy-dashboard' => 'Xem dashboard thủ quỹ',
                'view-thu-quy-thong-bao' => 'Xem thông báo',
                'view-thu-quy-quy' => 'Xem quỹ',
                'manage-thu-quy-quy' => 'Quản lý quỹ',
                'view-thu-quy-giao-dich' => 'Xem giao dịch',
                'manage-thu-quy-giao-dich' => 'Quản lý giao dịch',
                'duyet-thu-quy-giao-dich' => 'Duyệt giao dịch',
                'search-thu-quy-giao-dich' => 'Tìm kiếm giao dịch',
                'export-thu-quy-giao-dich' => 'Xuất giao dịch',
                'view-thu-quy-chi-dinh-ky' => 'Xem chi định kỳ',
                'manage-thu-quy-chi-dinh-ky' => 'Quản lý chi định kỳ',
                'view-thu-quy-bao-cao' => 'Xem báo cáo',
                'manage-thu-quy-bao-cao' => 'Quản lý báo cáo',
                'view-thu-quy-lich-su' => 'Xem lịch sử thao tác',
            ],
            'Thiết Bị' => [
                'view-thiet-bi' => 'Xem thiết bị',
                'manage-thiet-bi' => 'Quản lý thiết bị',
                'view-nha-cung-cap' => 'Xem nhà cung cấp',
                'manage-nha-cung-cap' => 'Quản lý nhà cung cấp',
                'view-thiet-bi-canh-bao' => 'Xem cảnh báo',
                'view-thiet-bi-bao-cao' => 'Xem báo cáo thống kê',
                'export-thiet-bi' => 'Xuất dữ liệu thiết bị',
                'view-lich-su-bao-tri' => 'Xem lịch sử bảo trì',
                'manage-lich-su-bao-tri' => 'Quản lý lịch sử bảo trì',
            ],
            'Thông Báo' => [
                'view-thong-bao' => 'Xem tổng quan',
                'view-thong-bao-inbox' => 'Xem hộp thư đến',
                'view-thong-bao-sent' => 'Xem đã gửi',
                'view-thong-bao-archived' => 'Xem lưu trữ',
                'manage-thong-bao' => 'Quản lý trạng thái thông báo',
                'delete-thong-bao' => 'Xóa thông báo',
                'send-thong-bao' => 'Gửi thông báo',
            ],
            'Báo Cáo' => [
                'view-bao-cao-thiet-bi' => 'Xem báo cáo thiết bị',
                'view-bao-cao-tai-chinh' => 'Xem báo cáo tài chính',
                'view-bao-cao-hoi-thanh' => 'Xem báo cáo hội thánh',
            ],
            'Diễn Giả' => [
                'view-dien-gia' => 'Xem diễn giả',
                'manage-dien-gia' => 'Quản lý diễn giả',
            ],
            'Thờ Phượng' => [
                'view-tho-phuong' => 'Xem thờ phượng',
                'manage-tho-phuong' => 'Quản lý thờ phượng',
            ],
            'Tài Liệu' => [
                'view-tai-lieu' => 'Xem tài liệu',
                'manage-tai-lieu' => 'Quản lý tài liệu',
            ],
            'Cài Đặt' => [
                'view-cai-dat' => 'Xem cài đặt',
            ],
            'Buổi Nhóm' => [
                'view-buoi-nhom' => 'Xem buổi nhóm',
                'manage-buoi-nhom' => 'Quản lý buổi nhóm',
            ],
        ];
    }

    public function index()
    {
        $users = NguoiDung::with('quyen.banNganh', 'tinHuu')->get();
        $banNganhs = BanNganh::all();
        $permissions = $this->permissions;

        // Lấy tất cả quyền duy nhất từ bảng nguoi_dung_phan_quyen
        $allPermissions = NguoiDungPhanQuyen::select('quyen')->distinct()->pluck('quyen')->toArray();

        // Lấy danh sách tất cả quyền từ $permissions
        $definedPermissions = [];
        foreach ($this->permissions as $groupPermissions) {
            $definedPermissions = array_merge($definedPermissions, array_keys($groupPermissions));
        }

        // Kết hợp với $permissions
        $customPermissions = array_diff($allPermissions, $definedPermissions);
        if (!empty($customPermissions)) {
            $permissions['Quyền Tùy Chỉnh'] = array_combine($customPermissions, array_map(fn($perm) => ucfirst(str_replace('-', ' ', $perm)), $customPermissions));
        }

        return view('_phan_quyen.phan_quyen', compact('users', 'banNganhs', 'permissions'));
    }

    public function showUserPermissions($userId)
    {
        $user = NguoiDung::with('quyen')->findOrFail($userId);
        $banNganhs = BanNganh::all();
        $permissions = $this->permissions;
        $userPermissions = $user->quyen->pluck('quyen')->toArray();

        // Lấy tất cả quyền duy nhất từ bảng nguoi_dung_phan_quyen
        $allPermissions = NguoiDungPhanQuyen::select('quyen')->distinct()->pluck('quyen')->toArray();

        // Lấy danh sách tất cả quyền từ $permissions
        $definedPermissions = [];
        foreach ($this->permissions as $groupPermissions) {
            $definedPermissions = array_merge($definedPermissions, array_keys($groupPermissions));
        }

        // Kết hợp với $permissions
        $customPermissions = array_diff($allPermissions, $definedPermissions);
        if (!empty($customPermissions)) {
            $permissions['Quyền Tùy Chỉnh'] = array_combine($customPermissions, array_map(fn($perm) => ucfirst(str_replace('-', ' ', $perm)), $customPermissions));
        }

        return view('_phan_quyen.user_permissions', compact('user', 'banNganhs', 'permissions', 'userPermissions'));
    }

    public function getRolePermissions(Request $request)
    {
        $role = $request->input('role');

        $rolePermissions = [];
        switch ($role) {
            case 'quan_tri':
                foreach ($this->permissions as $group => $groupPermissions) {
                    foreach (array_keys($groupPermissions) as $permission) {
                        $rolePermissions[] = $permission;
                    }
                }
                $customPermissions = NguoiDungPhanQuyen::select('quyen')->distinct()->pluck('quyen')->toArray();
                foreach ($customPermissions as $permission) {
                    if (!in_array($permission, $rolePermissions)) {
                        $rolePermissions[] = $permission;
                    }
                }
                break;
            case 'truong_ban':
                foreach ($this->permissions as $group => $groupPermissions) {
                    if (str_contains($group, 'Ban Ngành')) {
                        foreach ($groupPermissions as $permission => $description) {
                            $rolePermissions[] = $permission;
                        }
                    }
                }
                $rolePermissions[] = 'view-thong-bao';
                $rolePermissions[] = 'send-thong-bao';
                $rolePermissions[] = 'view-buoi-nhom';
                break;
            case 'thanh_vien':
                $rolePermissions = [
                    'view-thong-bao',
                    'view-thong-bao-inbox',
                    'view-buoi-nhom',
                ];
                break;
            default:
                $rolePermissions = [];
        }

        return response()->json($rolePermissions);
    }

    public function updateRole(Request $request, $userId)
    {
        $request->validate([
            'role' => 'required|string|in:quan_tri,truong_ban,thanh_vien',
        ]);

        $user = NguoiDung::findOrFail($userId);
        if ($user->vai_tro === 'quan_tri' && $user->email === 'admin1@example.com') {
            return response()->json(['error' => 'Không thể chỉnh sửa vai trò của tài khoản quản trị mặc định.'], 403);
        }

        $user->vai_tro = $request->role;
        $user->id_ban_nganh = null; // Loại bỏ ban ngành
        $user->save();

        // Xóa quyền cũ
        NguoiDungPhanQuyen::where('nguoi_dung_id', $userId)->delete();

        // Gán quyền mới dựa trên vai trò
        $rolePermissions = $this->getRolePermissions($request)->getData();
        foreach ($rolePermissions as $permission) {
            NguoiDungPhanQuyen::create([
                'nguoi_dung_id' => $userId,
                'quyen' => $permission,
                'id_ban_nganh' => null,
            ]);
        }

        // Nếu vai trò là quan_tri, gán thêm quyền admin-access
        if ($request->role === 'quan_tri') {
            NguoiDungPhanQuyen::create([
                'nguoi_dung_id' => $userId,
                'quyen' => 'admin-access',
                'id_ban_nganh' => null,
            ]);
        }

        return response()->json(['success' => 'Đã cập nhật vai trò và quyền thành công.']);
    }

    public function getUserPermissions($userId)
    {
        $user = NguoiDung::with('quyen')->findOrFail($userId);
        $userPermissions = $user->quyen->pluck('quyen')->toArray();
        $isAdmin = $user->vai_tro === 'quan_tri';

        if ($isAdmin) {
            $userPermissions = NguoiDungPhanQuyen::select('quyen')->distinct()->pluck('quyen')->toArray();
            $definedPermissions = [];
            foreach ($this->permissions as $groupPermissions) {
                $definedPermissions = array_merge($definedPermissions, array_keys($groupPermissions));
            }
            $userPermissions = array_unique(array_merge($userPermissions, $definedPermissions));
        }

        return response()->json([
            'permissions' => $userPermissions,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function updateUserPermissions(Request $request, $userId)
    {
        $user = NguoiDung::findOrFail($userId);
        if ($user->vai_tro === 'quan_tri') {
            return response()->json(['error' => 'Không thể chỉnh sửa quyền của tài khoản quản trị.'], 403);
        }

        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'string',
        ]);

        try {
            // Lấy danh sách quyền hiện tại của người dùng
            $currentPermissions = NguoiDungPhanQuyen::where('nguoi_dung_id', $userId)
                ->pluck('quyen')
                ->toArray();

            $selectedPermissions = $request->permissions;

            // Log để debug
            Log::info('Updating permissions for user: ' . $userId, [
                'current_permissions' => $currentPermissions,
                'selected_permissions' => $selectedPermissions,
            ]);

            // Xác định quyền cần xóa
            $permissionsToRemove = array_diff($currentPermissions, $selectedPermissions);
            $permissionsToRemove = array_values($permissionsToRemove);
            if (!empty($permissionsToRemove)) {
                Log::info('Removing permissions for user ' . $userId . ': ', ['permissions' => $permissionsToRemove]);

                // Log truy vấn SQL
                $query = NguoiDungPhanQuyen::where('nguoi_dung_id', $userId)
                    ->whereIn('quyen', $permissionsToRemove);
                Log::info('Delete query SQL: ' . $query->toSql(), ['bindings' => $query->getBindings()]);

                // Thực hiện xóa và kiểm tra số bản ghi bị ảnh hưởng
                $deletedRows = $query->delete();
                Log::info('Deleted rows for user ' . $userId . ': ' . $deletedRows);
            } else {
                Log::info('No permissions to remove for user ' . $userId);
            }

            // Xác định quyền cần thêm
            $permissionsToAdd = array_diff($selectedPermissions, $currentPermissions);
            if (!empty($permissionsToAdd)) {
                foreach ($permissionsToAdd as $permission) {
                    Log::info('Adding permission for user ' . $userId . ': ' . $permission);
                    NguoiDungPhanQuyen::create([
                        'nguoi_dung_id' => $userId,
                        'quyen' => $permission,
                        'id_ban_nganh' => null,
                    ]);
                }
            } else {
                Log::info('No permissions to add for user ' . $userId);
            }

            // Nếu không có quyền nào được chọn, xóa tất cả quyền
            if (empty($selectedPermissions) && !empty($currentPermissions)) {
                Log::info('No permissions selected, removing all permissions for user ' . $userId);
                $deletedRows = NguoiDungPhanQuyen::where('nguoi_dung_id', $userId)
                    ->delete();
                Log::info('Deleted all rows for user ' . $userId . ': ' . $deletedRows);
            }

            return response()->json(['success' => 'Đã cập nhật quyền thành công.']);
        } catch (\Exception $e) {
            Log::error('Error updating permissions for user ' . $userId . ': ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Không thể cập nhật quyền: ' . $e->getMessage()], 500);
        }
    }
}
