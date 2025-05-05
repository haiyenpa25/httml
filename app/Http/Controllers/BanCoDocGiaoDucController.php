<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BanCoDocGiaoDuc\BanCoDocGiaoDucThanhVienController;
use App\Http\Controllers\BanCoDocGiaoDuc\BanCoDocGiaoDucThamViengController;
use App\Http\Controllers\BanCoDocGiaoDuc\BanCoDocGiaoDucBaoCaoController;
use App\Models\BuoiNhom;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Cache;

class BanCoDocGiaoDucController extends Controller
{

    // Trait để chuẩn hóa các phản hồi API
    use ApiResponseTrait;

    // Các ID cố định để tránh magic numbers
    public const BAN_THANH_TRANG_ID = 1;
    public const HOI_THANH_ID = 20;

    protected $thanhVienController;
    protected $thamViengController;
    protected $baoCaoController;

    /**
     * Khởi tạo controller với dependency injection
     */
    public function __construct(
        BanCoDocGiaoDucThanhVienController $thanhVienController,
        BanCoDocGiaoDucThamViengController $thamViengController,
        BanCoDocGiaoDucBaoCaoController $baoCaoController
    ) {
        $this->thanhVienController = $thanhVienController;
        $this->thamViengController = $thamViengController;
        $this->baoCaoController = $baoCaoController;
    }

    /**
     * Hiển thị trang chính của Ban Trung Lão
     * 
     * @return View
     */
    public function index(): View
    {
        return $this->thanhVienController->index();
    }

    /**
     * Thêm thành viên vào Ban Trung Lão
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function themThanhVien(Request $request): JsonResponse
    {
        return $this->thanhVienController->themThanhVien($request);
    }

    /**
     * Xóa thành viên khỏi Ban Trung Lão
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function xoaThanhVien(Request $request): JsonResponse
    {
        $response = $this->thanhVienController->xoaThanhVien($request);
        // Xóa cache liên quan khi có thay đổi thành viên
        Cache::forget('ban_thanh_trang_thanh_vien');
        return $response;
    }

    /**
     * Cập nhật chức vụ thành viên trong Ban Trung Lão
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function capNhatChucVu(Request $request): JsonResponse
    {
        $response = $this->thanhVienController->capNhatChucVu($request);
        // Xóa cache liên quan khi có thay đổi chức vụ
        Cache::forget('ban_thanh_trang_thanh_vien');
        return $response;
    }

    /**
     * Hiển thị trang điểm danh của Ban Trung Lão
     * 
     * @param Request $request
     * @return View
     */
    public function diemDanh(Request $request): View
    {
        return $this->thanhVienController->diemDanh($request);
    }

    /**
     * Xử lý lưu điểm danh
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function luuDiemDanh(Request $request): JsonResponse
    {
        return $this->thanhVienController->luuDiemDanh($request);
    }

    /**
     * Thêm buổi nhóm mới
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function themBuoiNhom(Request $request): JsonResponse
    {
        return $this->thanhVienController->themBuoiNhom($request);
    }

    /**
     * API nhận danh sách Ban Điều Hành
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function dieuHanhList(Request $request): JsonResponse
    {
        // Sử dụng cache để tối ưu hiệu suất
        $cacheKey = 'ban_dieu_hanh_list_' . md5(json_encode($request->all()));
        $cacheDuration = now()->addMinutes(30);

        return Cache::remember($cacheKey, $cacheDuration, function () use ($request) {
            return $this->thanhVienController->dieuHanhList($request);
        });
    }

    /**
     * API nhận danh sách Ban Viên
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function banVienList(Request $request): JsonResponse
    {
        // Sử dụng cache để tối ưu hiệu suất
        $cacheKey = 'ban_vien_list_' . md5(json_encode($request->all()));
        $cacheDuration = now()->addMinutes(30);

        return Cache::remember($cacheKey, $cacheDuration, function () use ($request) {
            return $this->thanhVienController->banVienList($request);
        });
    }


    /**
     * Hiển thị trang phân công của Ban Trung Lão
     */
    public function phanCong(Request $request): View
    {
        return $this->thanhVienController->phanCong($request);
    }

    /**
     * Cập nhật thông tin buổi nhóm
     */
    public function updateBuoiNhom(Request $request, BuoiNhom $buoiNhom): JsonResponse
    {
        return $this->thanhVienController->updateBuoiNhom($request, $buoiNhom);
    }

    /**
     * Xóa buổi nhóm
     */
    public function deleteBuoiNhom(BuoiNhom $buoiNhom): JsonResponse
    {
        return $this->thanhVienController->deleteBuoiNhom($buoiNhom);
    }

    /**
     * Hiển thị trang phân công chi tiết nhiệm vụ
     */
    public function phanCongChiTiet(Request $request): View
    {
        return $this->thanhVienController->phanCongChiTiet($request);
    }

    /**
     * Lưu phân công nhiệm vụ
     */
    public function phanCongNhiemVu(Request $request): JsonResponse
    {
        return $this->thanhVienController->phanCongNhiemVu($request);
    }

    /**
     * Xóa phân công nhiệm vụ
     */
    public function xoaPhanCong($id): JsonResponse
    {
        return $this->thanhVienController->xoaPhanCong($id);
    }



    /**
     * Hiển thị trang thăm viếng
     */
    public function thamVieng(): View
    {
        return $this->thamViengController->thamVieng();
    }

    /**
     * Thêm lần thăm mới
     */
    public function themThamVieng(Request $request): JsonResponse
    {
        return $this->thamViengController->themThamVieng($request);
    }

    /**
     * Lọc đề xuất thăm viếng theo số ngày
     */
    public function filterDeXuatThamVieng(Request $request): JsonResponse
    {
        return $this->thamViengController->filterDeXuatThamVieng($request);
    }

    /**
     * Lọc lịch sử thăm viếng theo khoảng thời gian
     */
    public function filterThamVieng(Request $request): JsonResponse
    {
        return $this->thamViengController->filterThamVieng($request);
    }

    /**
     * Lấy chi tiết một lần thăm viếng
     */
    public function chiTietThamVieng($id): JsonResponse
    {
        return $this->thamViengController->chiTietThamVieng($id);
    }

    /**
     * Hiển thị form nhập liệu báo cáo Ban Trung Lão
     */
    public function formBaoCaoBanCoDocGiaoDuc(Request $request): View
    {
        return $this->baoCaoController->formBaoCaoBanCoDocGiaoDuc($request);
    }

    /**
     * Hiển thị báo cáo Ban Trung Lão
     */
    public function baoCaoBanCoDocGiaoDuc(Request $request): View
    {
        return $this->baoCaoController->baoCaoBanCoDocGiaoDuc($request);
    }

    /**
     * Cập nhật số lượng tham dự và dâng hiến cho một buổi nhóm
     */
    public function updateThamDuTrungLao(Request $request): JsonResponse
    {
        return $this->baoCaoController->updateThamDuTrungLao($request);
    }

    /**
     * Lưu tất cả số lượng tham dự và dâng hiến
     */
    public function saveThamDuTrungLao(Request $request)
    {
        return $this->baoCaoController->saveThamDuTrungLao($request);
    }

    /**
     * Lưu đánh giá báo cáo
     */
    public function saveDanhGiaTrungLao(Request $request)
    {
        return $this->baoCaoController->saveDanhGiaTrungLao($request);
    }

    /**
     * Lưu kế hoạch báo cáo
     */
    public function saveKeHoachTrungLao(Request $request)
    {
        return $this->baoCaoController->saveKeHoachTrungLao($request);
    }

    /**
     * Lưu kiến nghị báo cáo
     */
    public function saveKienNghiTrungLao(Request $request)
    {
        return $this->baoCaoController->saveKienNghiTrungLao($request);
    }

    /**
     * Lưu toàn bộ báo cáo Ban Trung Lão
     */
    public function luuBaoCaoBanCoDocGiaoDuc(Request $request): JsonResponse
    {
        return $this->baoCaoController->luuBaoCaoBanCoDocGiaoDuc($request);
    }

    /**
     * Cập nhật số lượng tham dự
     */
    public function capNhatSoLuongThamDu(Request $request): JsonResponse
    {
        return $this->baoCaoController->capNhatSoLuongThamDu($request);
    }

    /**
     * Xóa đánh giá (điểm mạnh hoặc điểm yếu)
     */
    public function xoaDanhGia($id): JsonResponse
    {
        return $this->baoCaoController->xoaDanhGia($id);
    }

    /**
     * Xóa kiến nghị
     */
    public function xoaKienNghi($id): JsonResponse
    {
        return $this->baoCaoController->xoaKienNghi($id);
    }
}
