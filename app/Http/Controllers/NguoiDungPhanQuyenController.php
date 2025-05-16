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
            'Ban Ngành - Tổng Quan' => [
                'view-ban-nganh' => ['description' => 'Xem danh sách ban ngành', 'default_url' => '/ban-nganh'],
            ],
            'Ban Ngành - Trung Lão' => [
                'view-ban-nganh-trung-lao' => ['description' => 'Xem tổng quan', 'default_url' => '/ban-nganh/trung-lao'],
                'diem-danh-ban-nganh-trung-lao' => ['description' => 'Điểm danh', 'default_url' => '/ban-nganh/trung-lao/diem-danh'],
                'tham-vieng-ban-nganh-trung-lao' => ['description' => 'Thăm viếng', 'default_url' => '/ban-nganh/trung-lao/tham-vieng'],
                'phan-cong-ban-nganh-trung-lao' => ['description' => 'Phân công', 'default_url' => '/ban-nganh/trung-lao/phan-cong'],
                'phan-cong-chi-tiet-ban-nganh-trung-lao' => ['description' => 'Phân công chi tiết', 'default_url' => '/ban-nganh/trung-lao/phan-cong-chi-tiet'],
                'nhap-lieu-bao-cao-ban-nganh-trung-lao' => ['description' => 'Nhập liệu báo cáo', 'default_url' => '/ban-nganh/trung-lao/nhap-lieu-bao-cao'],
                'bao-cao-ban-nganh-trung-lao' => ['description' => 'Xem báo cáo', 'default_url' => '/ban-nganh/trung-lao/bao-cao'],
                'manage-thanh-vien-ban-nganh-trung-lao' => ['description' => 'Quản lý thành viên', 'default_url' => '/ban-nganh/trung-lao/thanh-vien'],
                'view-thanh-vien-ban-nganh-trung-lao' => ['description' => 'Xem danh sách thành viên', 'default_url' => '/ban-nganh/trung-lao/thanh-vien'],
                'manage-buoi-nhom-ban-nganh-trung-lao' => ['description' => 'Quản lý buổi nhóm', 'default_url' => '/ban-nganh/trung-lao/buoi-nhom'],
                'manage-tham-vieng-ban-nganh-trung-lao' => ['description' => 'Quản lý thăm viếng', 'default_url' => '/ban-nganh/trung-lao/tham-vieng'],
                'manage-phan-cong-ban-nganh-trung-lao' => ['description' => 'Quản lý phân công', 'default_url' => '/ban-nganh/trung-lao/phan-cong'],
                'manage-bao-cao-ban-nganh-trung-lao' => ['description' => 'Quản lý báo cáo', 'default_url' => '/ban-nganh/trung-lao/bao-cao'],
            ],
            'Ban Ngành - Thanh Tráng' => [
                'view-ban-nganh-thanh-trang' => ['description' => 'Xem tổng quan', 'default_url' => '/ban-nganh/thanh-trang'],
                'diem-danh-ban-nganh-thanh-trang' => ['description' => 'Điểm danh', 'default_url' => '/ban-nganh/thanh-trang/diem-danh'],
                'tham-vieng-ban-nganh-thanh-trang' => ['description' => 'Thăm viếng', 'default_url' => '/ban-nganh/thanh-trang/tham-vieng'],
                'phan-cong-ban-nganh-thanh-trang' => ['description' => 'Phân công', 'default_url' => '/ban-nganh/thanh-trang/phan-cong'],
                'phan-cong-chi-tiet-ban-nganh-thanh-trang' => ['description' => 'Phân công chi tiết', 'default_url' => '/ban-nganh/thanh-trang/phan-cong-chi-tiet'],
                'nhap-lieu-bao-cao-ban-nganh-thanh-trang' => ['description' => 'Nhập liệu báo cáo', 'default_url' => '/ban-nganh/thanh-trang/nhap-lieu-bao-cao'],
                'bao-cao-ban-nganh-thanh-trang' => ['description' => 'Xem báo cáo', 'default_url' => '/ban-nganh/thanh-trang/bao-cao'],
                'manage-thanh-vien-ban-nganh-thanh-trang' => ['description' => 'Quản lý thành viên', 'default_url' => '/ban-nganh/thanh-trang/thanh-vien'],
                'view-thanh-vien-ban-nganh-thanh-trang' => ['description' => 'Xem danh sách thành viên', 'default_url' => '/ban-nganh/thanh-trang/thanh-vien'],
                'manage-buoi-nhom-ban-nganh-thanh-trang' => ['description' => 'Quản lý buổi nhóm', 'default_url' => '/ban-nganh/thanh-trang/buoi-nhom'],
                'manage-tham-vieng-ban-nganh-thanh-trang' => ['description' => 'Quản lý thăm viếng', 'default_url' => '/ban-nganh/thanh-trang/tham-vieng'],
                'manage-phan-cong-ban-nganh-thanh-trang' => ['description' => 'Quản lý phân công', 'default_url' => '/ban-nganh/thanh-trang/phan-cong'],
                'manage-bao-cao-ban-nganh-thanh-trang' => ['description' => 'Quản lý báo cáo', 'default_url' => '/ban-nganh/thanh-trang/bao-cao'],
            ],
            'Ban Ngành - Thanh Niên' => [
                'view-ban-nganh-thanh-nien' => ['description' => 'Xem tổng quan', 'default_url' => '/ban-nganh/thanh-nien'],
                'diem-danh-ban-nganh-thanh-nien' => ['description' => 'Điểm danh', 'default_url' => '/ban-nganh/thanh-nien/diem-danh'],
                'tham-vieng-ban-nganh-thanh-nien' => ['description' => 'Thăm viếng', 'default_url' => '/ban-nganh/thanh-nien/tham-vieng'],
                'phan-cong-ban-nganh-thanh-nien' => ['description' => 'Phân công', 'default_url' => '/ban-nganh/thanh-nien/phan-cong'],
                'phan-cong-chi-tiet-ban-nganh-thanh-nien' => ['description' => 'Phân công chi tiết', 'default_url' => '/ban-nganh/thanh-nien/phan-cong-chi-tiet'],
                'nhap-lieu-bao-cao-ban-nganh-thanh-nien' => ['description' => 'Nhập liệu báo cáo', 'default_url' => '/ban-nganh/thanh-nien/nhap-lieu-bao-cao'],
                'bao-cao-ban-nganh-thanh-nien' => ['description' => 'Xem báo cáo', 'default_url' => '/ban-nganh/thanh-nien/bao-cao'],
                'manage-thanh-vien-ban-nganh-thanh-nien' => ['description' => 'Quản lý thành viên', 'default_url' => '/ban-nganh/thanh-nien/thanh-vien'],
                'view-thanh-vien-ban-nganh-thanh-nien' => ['description' => 'Xem danh sách thành viên', 'default_url' => '/ban-nganh/thanh-nien/thanh-vien'],
                'manage-buoi-nhom-ban-nganh-thanh-nien' => ['description' => 'Quản lý buổi nhóm', 'default_url' => '/ban-nganh/thanh-nien/buoi-nhom'],
                'manage-tham-vieng-ban-nganh-thanh-nien' => ['description' => 'Quản lý thăm viếng', 'default_url' => '/ban-nganh/thanh-nien/tham-vieng'],
                'manage-phan-cong-ban-nganh-thanh-nien' => ['description' => 'Quản lý phân công', 'default_url' => '/ban-nganh/thanh-nien/phan-cong'],
                'manage-bao-cao-ban-nganh-thanh-nien' => ['description' => 'Quản lý báo cáo', 'default_url' => '/ban-nganh/thanh-nien/bao-cao'],
            ],
            'Ban Ngành - Thiếu Nhi' => [
                'view-ban-nganh-thieu-nhi' => ['description' => 'Xem tổng quan', 'default_url' => '/ban-nganh/thieu-nhi'],
                'diem-danh-ban-nganh-thieu-nhi' => ['description' => 'Điểm danh', 'default_url' => '/ban-nganh/thieu-nhi/diem-danh'],
                'tham-vieng-ban-nganh-thieu-nhi' => ['description' => 'Thăm viếng', 'default_url' => '/ban-nganh/thieu-nhi/tham-vieng'],
                'phan-cong-ban-nganh-thieu-nhi' => ['description' => 'Phân công', 'default_url' => '/ban-nganh/thieu-nhi/phan-cong'],
                'phan-cong-chi-tiet-ban-nganh-thieu-nhi' => ['description' => 'Phân công chi tiết', 'default_url' => '/ban-nganh/thieu-nhi/phan-cong-chi-tiet'],
                'nhap-lieu-bao-cao-ban-nganh-thieu-nhi' => ['description' => 'Nhập liệu báo cáo', 'default_url' => '/ban-nganh/thieu-nhi/nhap-lieu-bao-cao'],
                'bao-cao-ban-nganh-thieu-nhi' => ['description' => 'Xem báo cáo', 'default_url' => '/ban-nganh/thieu-nhi/bao-cao'],
                'manage-thanh-vien-ban-nganh-thieu-nhi' => ['description' => 'Quản lý thành viên', 'default_url' => '/ban-nganh/thieu-nhi/thanh-vien'],
                'view-thanh-vien-ban-nganh-thieu-nhi' => ['description' => 'Xem danh sách thành viên', 'default_url' => '/ban-nganh/thieu-nhi/thanh-vien'],
                'manage-buoi-nhom-ban-nganh-thieu-nhi' => ['description' => 'Quản lý buổi nhóm', 'default_url' => '/ban-nganh/thieu-nhi/buoi-nhom'],
                'manage-tham-vieng-ban-nganh-thieu-nhi' => ['description' => 'Quản lý thăm viếng', 'default_url' => '/ban-nganh/thieu-nhi/tham-vieng'],
                'manage-phan-cong-ban-nganh-thieu-nhi' => ['description' => 'Quản lý phân công', 'default_url' => '/ban-nganh/thieu-nhi/phan-cong'],
                'manage-bao-cao-ban-nganh-thieu-nhi' => ['description' => 'Quản lý báo cáo', 'default_url' => '/ban-nganh/thieu-nhi/bao-cao'],
            ],
            'Ban Ngành - Cơ Đốc Giáo Dục' => [
                'view-ban-co-doc-giao-duc' => ['description' => 'Xem tổng quan', 'default_url' => '/ban-co-doc-giao-duc'],
                'diem-danh-ban-co-doc-giao-duc' => ['description' => 'Điểm danh', 'default_url' => '/ban-co-doc-giao-duc/diem-danh'],
                'phan-cong-ban-co-doc-giao-duc' => ['description' => 'Phân công', 'default_url' => '/ban-co-doc-giao-duc/phan-cong'],
                'phan-cong-chi-tiet-ban-co-doc-giao-duc' => ['description' => 'Phân công chi tiết', 'default_url' => '/ban-co-doc-giao-duc/phan-cong-chi-tiet'],
                'nhap-lieu-bao-cao-ban-co-doc-giao-duc' => ['description' => 'Nhập liệu báo cáo', 'default_url' => '/ban-co-doc-giao-duc/nhap-lieu-bao-cao'],
                'bao-cao-ban-co-doc-giao-duc' => ['description' => 'Xem báo cáo', 'default_url' => '/ban-co-doc-giao-duc/bao-cao'],
                'manage-thanh-vien-ban-co-doc-giao-duc' => ['description' => 'Quản lý thành viên (thêm, xóa, cập nhật chức vụ)', 'default_url' => '/ban-co-doc-giao-duc'],
                'view-thanh-vien-ban-co-doc-giao-duc' => ['description' => 'Xem danh sách thành viên', 'default_url' => '/ban-co-doc-giao-duc'],
                'manage-buoi-nhom-ban-co-doc-giao-duc' => ['description' => 'Quản lý buổi nhóm (thêm, cập nhật, xóa)', 'default_url' => '/ban-co-doc-giao-duc'],
                'manage-phan-cong-ban-co-doc-giao-duc' => ['description' => 'Quản lý phân công nhiệm vụ', 'default_url' => '/ban-co-doc-giao-duc/phan-cong'],
                'manage-diem-danh-ban-co-doc-giao-duc' => ['description' => 'Quản lý điểm danh và tham dự', 'default_url' => '/ban-co-doc-giao-duc/diem-danh'],
                'manage-bao-cao-ban-co-doc-giao-duc' => ['description' => 'Quản lý báo cáo (đánh giá, kế hoạch, kiến nghị)', 'default_url' => '/ban-co-doc-giao-duc/bao-cao'],
            ],
            'Ban Ngành - Khác' => [
                'view-ban-chap-su' => ['description' => 'Xem Ban Chấp Sự', 'default_url' => '/ban/chap-su'],
                'view-ban-am-thuc' => ['description' => 'Xem Ban Ẩm Thực', 'default_url' => '/ban/am-thuc'],
                'view-ban-cau-nguyen' => ['description' => 'Xem Ban Cầu Nguyện', 'default_url' => '/ban/cau-nguyen'],
                'view-ban-chung-dao' => ['description' => 'Xem Ban Chứng Đạo', 'default_url' => '/ban/chung-dao'],
                'view-ban-dan' => ['description' => 'Xem Ban Đàn', 'default_url' => '/ban/dan'],
                'view-ban-hau-can' => ['description' => 'Xem Ban Hậu Cần', 'default_url' => '/ban/hau-can'],
                'view-ban-hat-tho-phuong' => ['description' => 'Xem Ban Hát Thờ Phượng', 'default_url' => '/ban/hat-tho-phuong'],
                'view-ban-khanh-tiet' => ['description' => 'Xem Ban Khánh Tiết', 'default_url' => '/ban/khanh-tiet'],
                'view-ban-ky-thuat-am-thanh' => ['description' => 'Xem Ban Kỹ Thuật - Âm Thanh', 'default_url' => '/ban/ky-thuat-am-thanh'],
                'view-ban-le-tan' => ['description' => 'Xem Ban Lễ Tân', 'default_url' => '/ban/le-tan'],
                'view-ban-may-chieu' => ['description' => 'Xem Ban Máy Chiếu', 'default_url' => '/ban/may-chieu'],
                'view-ban-tham-vieng' => ['description' => 'Xem Ban Thăm Viếng', 'default_url' => '/ban/tham-vieng'],
                'view-ban-trat-tu' => ['description' => 'Xem Ban Trật Tự', 'default_url' => '/ban/trat-tu'],
                'view-ban-truyen-giang' => ['description' => 'Xem Ban Truyền Giảng', 'default_url' => '/ban/truyen-giang'],
                'view-ban-truyen-thong-may-chieu' => ['description' => 'Xem Ban Truyền Thông - Máy Chiếu', 'default_url' => '/ban/truyen-thong-may-chieu'],
            ],
            'Thủ Quỹ' => [
                'view-thu-quy-dashboard' => ['description' => 'Xem dashboard thủ quỹ', 'default_url' => '/thu-quy'],
                'view-thu-quy-thong-bao' => ['description' => 'Xem thông báo', 'default_url' => '/thu-quy/thong-bao'],
                'view-thu-quy-quy' => ['description' => 'Xem quỹ', 'default_url' => '/thu-quy/quy'],
                'manage-thu-quy-quy' => ['description' => 'Quản lý quỹ', 'default_url' => '/thu-quy/quy'],
                'view-thu-quy-giao-dich' => ['description' => 'Xem giao dịch', 'default_url' => '/thu-quy/giao-dich'],
                'manage-thu-quy-giao-dich' => ['description' => 'Quản lý giao dịch', 'default_url' => '/thu-quy/giao-dich'],
                'duyet-thu-quy-giao-dich' => ['description' => 'Duyệt giao dịch', 'default_url' => '/thu-quy/giao-dich/duyet/danh-sach'],
                'search-thu-quy-giao-dich' => ['description' => 'Tìm kiếm giao dịch', 'default_url' => '/thu-quy/giao-dich/tim-kiem'],
                'export-thu-quy-giao-dich' => ['description' => 'Xuất giao dịch', 'default_url' => '/thu-quy/giao-dich/tim-kiem'],
                'view-thu-quy-chi-dinh-ky' => ['description' => 'Xem chi định kỳ', 'default_url' => '/thu-quy/chi-dinh-ky'],
                'manage-thu-quy-chi-dinh-ky' => ['description' => 'Quản lý chi định kỳ', 'default_url' => '/thu-quy/chi-dinh-ky'],
                'view-thu-quy-bao-cao' => ['description' => 'Xem báo cáo', 'default_url' => '/thu-quy/bao-cao'],
                'manage-thu-quy-bao-cao' => ['description' => 'Quản lý báo cáo', 'default_url' => '/thu-quy/bao-cao'],
                'view-thu-quy-lich-su' => ['description' => 'Xem lịch sử thao tác', 'default_url' => '/thu-quy/lich-su'],
            ],
            'Thiết Bị' => [
                'view-thiet-bi' => ['description' => 'Xem thiết bị', 'default_url' => '/thiet-bi'],
                'manage-thiet-bi' => ['description' => 'Quản lý thiết bị', 'default_url' => '/thiet-bi'],
                'view-nha-cung-cap' => ['description' => 'Xem nhà cung cấp', 'default_url' => '/nha-cung-cap'],
                'manage-nha-cung-cap' => ['description' => 'Quản lý nhà cung cấp', 'default_url' => '/nha-cung-cap'],
                'view-thiet-bi-canh-bao' => ['description' => 'Xem cảnh báo', 'default_url' => '/thiet-bi/canh-bao'],
                'view-thiet-bi-bao-cao' => ['description' => 'Xem báo cáo thống kê', 'default_url' => '/thiet-bi/bao-cao'],
                'export-thiet-bi' => ['description' => 'Xuất dữ liệu thiết bị', 'default_url' => '/thiet-bi/bao-cao'],
                'view-lich-su-bao-tri' => ['description' => 'Xem lịch sử bảo trì', 'default_url' => '/thiet-bi/lich-su-bao-tri'],
                'manage-lich-su-bao-tri' => ['description' => 'Quản lý lịch sử bảo trì', 'default_url' => '/thiet-bi/lich-su-bao-tri'],
            ],
            'Thông Báo' => [
                'view-thong-bao' => ['description' => 'Xem tổng quan', 'default_url' => '/thong-bao'],
                'view-thong-bao-inbox' => ['description' => 'Xem hộp thư đến', 'default_url' => '/thong-bao/inbox'],
                'view-thong-bao-sent' => ['description' => 'Xem đã gửi', 'default_url' => '/thong-bao/sent'],
                'view-thong-bao-archived' => ['description' => 'Xem lưu trữ', 'default_url' => '/thong-bao/archived'],
                'manage-thong-bao' => ['description' => 'Quản lý trạng thái thông báo', 'default_url' => '/thong-bao'],
                'delete-thong-bao' => ['description' => 'Xóa thông báo', 'default_url' => '/thong-bao'],
                'send-thong-bao' => ['description' => 'Gửi thông báo', 'default_url' => '/thong-bao/create'],
            ],
            'Báo Cáo' => [
                'view-bao-cao-thiet-bi' => ['description' => 'Xem báo cáo thiết bị', 'default_url' => '/bao-cao/thiet-bi'],
                'view-bao-cao-tai-chinh' => ['description' => 'Xem báo cáo tài chính', 'default_url' => '/bao-cao/tai-chinh'],
                'view-bao-cao-hoi-thanh' => ['description' => 'Xem báo cáo hội thánh', 'default_url' => '/bao-cao/hoi-thanh'],
            ],
            'Diễn Giả' => [
                'view-dien-gia' => ['description' => 'Xem diễn giả', 'default_url' => '/dien-gia'],
                'manage-dien-gia' => ['description' => 'Quản lý diễn giả', 'default_url' => '/dien-gia'],
            ],
            'Thờ Phượng' => [
                'view-tho-phuong' => ['description' => 'Xem thờ phượng', 'default_url' => '/tho-phuong'],
                'manage-tho-phuong' => ['description' => 'Quản lý thờ phượng', 'default_url' => '/tho-phuong'],
            ],
            'Tài Liệu' => [
                'view-tai-lieu' => ['description' => 'Xem tài liệu', 'default_url' => '/tai-lieu'],
                'manage-tai-lieu' => ['description' => 'Quản lý tài liệu', 'default_url' => '/tai-lieu'],
            ],
            'Cài Đặt' => [
                'view-cai-dat' => ['description' => 'Xem cài đặt', 'default_url' => '/cai-dat'],
            ],
            'Buổi Nhóm' => [
                'view-buoi-nhom' => ['description' => 'Xem buổi nhóm', 'default_url' => '/buoi-nhom'],
                'manage-buoi-nhom' => ['description' => 'Quản lý buổi nhóm', 'default_url' => '/buoi-nhom'],
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
            foreach ($groupPermissions as $perm => $data) {
                $definedPermissions[] = $perm;
            }
        }

        // Kết hợp với $permissions
        $customPermissions = array_diff($allPermissions, $definedPermissions);
        if (!empty($customPermissions)) {
            $permissions['Quyền Tùy Chỉnh'] = array_combine(
                $customPermissions,
                array_map(fn($perm) => ['description' => ucfirst(str_replace('-', ' ', $perm)), 'default_url' => null], $customPermissions)
            );
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
            foreach ($groupPermissions as $perm => $data) {
                $definedPermissions[] = $perm;
            }
        }

        // Kết hợp với $permissions
        $customPermissions = array_diff($allPermissions, $definedPermissions);
        if (!empty($customPermissions)) {
            $permissions['Quyền Tùy Chỉnh'] = array_combine(
                $customPermissions,
                array_map(fn($perm) => ['description' => ucfirst(str_replace('-', ' ', $perm)), 'default_url' => null], $customPermissions)
            );
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
                        foreach ($groupPermissions as $permission => $data) {
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

        // Kiểm tra quyền của người dùng hiện tại
        $currentUser = auth()->user();
        if (!$currentUser || $currentUser->vai_tro !== 'quan_tri') {
            return response()->json(['error' => 'Bạn không có quyền chỉnh sửa vai trò.'], 403);
        }

        $user = NguoiDung::findOrFail($userId);
        $user->vai_tro = $request->role;
        $user->id_ban_nganh = null; // Loại bỏ ban ngành
        $user->save();

        // Xóa quyền cũ
        NguoiDungPhanQuyen::where('nguoi_dung_id', $userId)->delete();

        // Gán quyền mới dựa trên vai trò
        $rolePermissions = $this->getRolePermissions($request)->getData();
        Log::info("Gán quyền cho user {$userId} với vai trò {$request->role}", ['permissions' => $rolePermissions]);

        foreach ($rolePermissions as $permission) {
            $defaultUrl = null;
            foreach ($this->permissions as $group => $groupPermissions) {
                if (isset($groupPermissions[$permission]['default_url'])) {
                    $defaultUrl = $groupPermissions[$permission]['default_url'];
                    break;
                }
            }
            NguoiDungPhanQuyen::create([
                'nguoi_dung_id' => $userId,
                'quyen' => $permission,
                'id_ban_nganh' => null,
                'default_url' => $defaultUrl,
            ]);
        }

        // Đảm bảo quyền admin-access cho quan_tri
        if ($request->role === 'quan_tri') {
            NguoiDungPhanQuyen::create([
                'nguoi_dung_id' => $userId,
                'quyen' => 'admin-access',
                'id_ban_nganh' => null,
                'default_url' => '/dashboard',
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
                foreach ($groupPermissions as $perm => $data) {
                    $definedPermissions[] = $perm;
                }
            }
            $userPermissions = array_unique(array_merge($userPermissions, $definedPermissions));
        }

        return response()->json([
            'permissions' => $userPermissions,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function getUserDefaultUrls($userId)
    {
        $user = NguoiDung::findOrFail($userId);
        return response()->json(
            $user->quyen()->whereNotNull('default_url')->distinct()->pluck('default_url')->toArray()
        );
    }

    public function updateUserPermissions(Request $request, $userId)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'string',
        ]);

        // Kiểm tra quyền của người dùng hiện tại
        $currentUser = auth()->user();
        if (!$currentUser || $currentUser->vai_tro !== 'quan_tri') {
            return response()->json(['error' => 'Bạn không có quyền chỉnh sửa quyền.'], 403);
        }

        $user = NguoiDung::findOrFail($userId);

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
                $query = NguoiDungPhanQuyen::where('nguoi_dung_id', $userId)
                    ->whereIn('quyen', $permissionsToRemove);
                Log::info('Delete query SQL: ' . $query->toSql(), ['bindings' => $query->getBindings()]);
                $deletedRows = $query->delete();
                Log::info('Deleted rows for user ' . $userId . ': ' . $deletedRows);
            } else {
                Log::info('No permissions to remove for user ' . $userId);
            }

            // Xác định quyền cần thêm
            $permissionsToAdd = array_diff($selectedPermissions, $currentPermissions);
            if (!empty($permissionsToAdd)) {
                foreach ($permissionsToAdd as $permission) {
                    $defaultUrl = null;
                    foreach ($this->permissions as $group => $groupPermissions) {
                        if (isset($groupPermissions[$permission]['default_url'])) {
                            $defaultUrl = $groupPermissions[$permission]['default_url'];
                            break;
                        }
                    }
                    Log::info('Adding permission for user ' . $userId . ': ' . $permission . ' with default_url: ' . ($defaultUrl ?? 'null'));
                    NguoiDungPhanQuyen::create([
                        'nguoi_dung_id' => $userId,
                        'quyen' => $permission,
                        'id_ban_nganh' => null,
                        'default_url' => $defaultUrl,
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

    public function updateDefaultUrl(Request $request, $userId)
    {
        $request->validate([
            'default_url' => 'nullable|string|max:255',
        ]);

        // Kiểm tra quyền của người dùng hiện tại
        $currentUser = auth()->user();
        if (!$currentUser || $currentUser->vai_tro !== 'quan_tri') {
            return response()->json(['error' => 'Bạn không có quyền chỉnh sửa URL mặc định.'], 403);
        }

        $user = NguoiDung::findOrFail($userId);
        $user->default_url = $request->default_url ?: null;
        $user->save();

        return response()->json(['success' => 'Đã cập nhật URL mặc định thành công.']);
    }
}
