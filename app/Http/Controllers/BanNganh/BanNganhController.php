<?php

namespace App\Http\Controllers\BanNganh;

use App\Http\Controllers\Controller;
use App\Models\BuoiNhom;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use App\Http\Controllers\BanNganh\BanNganhThamViengController;
use App\Http\Controllers\BanNganh\BanNganhThanhVienController;
use App\Http\Controllers\BanNganh\BanNganhBaoCaoController;

class BanNganhController extends Controller
{
    use ApiResponseTrait;

    protected $thanhVienController;
    protected $thamViengController;
    protected $baoCaoController;
    protected $banConfig;

    /**
     * Khởi tạo controller với dependency injection
     */
    public function __construct(
        BanNganhThanhVienController $thanhVienController,
        BanNganhThamViengController $thamViengController,
        BanNganhBaoCaoController $baoCaoController
    ) {
        $this->thanhVienController = $thanhVienController;
        $this->thamViengController = $thamViengController;
        $this->baoCaoController = $baoCaoController;
        $this->banConfig = config('ban_nganh');

        // Middleware nội tuyến để share $banType tới tất cả view
        $this->middleware(function ($request, $next) {
            // Lấy banType đã defaults trong route
            $banType = $request->route('banType');
            // Share biến cho tất cả view
            view()->share('banType', $banType);
            return $next($request);
        });
    }

    /**
     * Lấy cấu hình ban dựa trên banType
     */
    protected function getBanConfig(string $banType): array
    {
        if (!isset($this->banConfig[$banType])) {
            throw new \Exception("Không tìm thấy cấu hình cho ban: {$banType}");
        }
        return $this->banConfig[$banType];
    }

    /**
     * Hiển thị trang chính của ban
     */
    public function index(string $banType): View
    {
        $config = $this->getBanConfig($banType);
        return $this->thanhVienController->index($banType, $config);
    }

    /**
     * Thêm thành viên vào ban
     */
    public function themThanhVien(Request $request, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->thanhVienController->themThanhVien($request, $config);
    }

    /**
     * Xóa thành viên khỏi ban
     */
    public function xoaThanhVien(Request $request, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        $response = $this->thanhVienController->xoaThanhVien($request, $config);
        Cache::forget("ban_{$banType}_thanh_vien");
        return $response;
    }

    /**
     * Cập nhật chức vụ thành viên trong ban
     */
    public function capNhatChucVu(Request $request, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        $response = $this->thanhVienController->capNhatChucVu($request, $config);
        Cache::forget("ban_{$banType}_thanh_vien");
        return $response;
    }

    /**
     * Hiển thị trang điểm danh của ban
     */
    public function diemDanh(Request $request, string $banType): View
    {
        $config = $this->getBanConfig($banType);
        return $this->thanhVienController->diemDanh($request, $config);
    }

    /**
     * Xử lý lưu điểm danh
     */
    public function luuDiemDanh(Request $request, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->thanhVienController->luuDiemDanh($request, $config);
    }

    /**
     * Thêm buổi nhóm mới
     */
    public function themBuoiNhom(Request $request, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->thanhVienController->themBuoiNhom($request, $config);
    }

    /**
     * API nhận danh sách Ban Điều Hành
     */
    public function dieuHanhList(Request $request, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        $cacheKey = "ban_dieu_hanh_list_{$banType}_" . md5(json_encode($request->all()));
        $cacheDuration = now()->addMinutes(30);

        return Cache::remember($cacheKey, $cacheDuration, function () use ($request, $config) {
            return $this->thanhVienController->dieuHanhList($request, $config);
        });
    }

    /**
     * API nhận danh sách Ban Viên
     */
    public function banVienList(Request $request, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        $cacheKey = "ban_vien_list_{$banType}_" . md5(json_encode($request->all()));
        $cacheDuration = now()->addMinutes(30);

        return Cache::remember($cacheKey, $cacheDuration, function () use ($request, $config) {
            return $this->thanhVienController->banVienList($request, $config);
        });
    }

    /**
     * Hiển thị trang phân công của ban
     */
    public function phanCong(Request $request, string $banType): View
    {
        $config = $this->getBanConfig($banType);
        return $this->thanhVienController->phanCong($request, $config);
    }

    /**
     * Cập nhật thông tin buổi nhóm
     */
    public function updateBuoiNhom(Request $request, BuoiNhom $buoiNhom, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->thanhVienController->updateBuoiNhom($request, $buoiNhom, $config);
    }

    /**
     * Xóa buổi nhóm
     */
    public function deleteBuoiNhom(BuoiNhom $buoiNhom, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->thanhVienController->deleteBuoiNhom($buoiNhom, $config);
    }

    /**
     * Hiển thị trang phân công chi tiết nhiệm vụ
     */
    public function phanCongChiTiet(Request $request, string $banType): View
    {
        $config = $this->getBanConfig($banType);
        return $this->thanhVienController->phanCongChiTiet($request, $config);
    }

    /**
     * Lưu phân công nhiệm vụ
     */
    public function phanCongNhiemVu(Request $request, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->thanhVienController->phanCongNhiemVu($request, $config);
    }

    /**
     * Xóa phân công nhiệm vụ
     */
    public function xoaPhanCong($id, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->thanhVienController->xoaPhanCong($id, $config);
    }

    /**
     * Hiển thị trang thăm viếng
     */
    public function thamVieng(string $banType): View
    {
        $config = $this->getBanConfig($banType);
        return $this->thamViengController->thamVieng($config);
    }

    /**
     * Thêm lần thăm mới
     */
    public function themThamVieng(Request $request, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->thamViengController->themThamVieng($request, $config);
    }

    /**
     * Lọc đề xuất thăm viếng theo số ngày
     */
    public function filterDeXuatThamVieng(Request $request, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->thamViengController->filterDeXuatThamVieng($request, $config);
    }

    /**
     * Lọc lịch sử thăm viếng theo khoảng thời gian
     */
    public function filterThamVieng(Request $request, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->thamViengController->filterThamVieng($request, $config);
    }

    /**
     * Lấy chi tiết một lần thăm viếng
     */
    public function chiTietThamVieng($id, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->thamViengController->chiTietThamVieng($id, $config);
    }

    /**
     * Hiển thị form nhập liệu báo cáo ban
     */
    public function formBaoCaoBan(Request $request, string $banType): View
    {
        $config = $this->getBanConfig($banType);
        return $this->baoCaoController->formBaoCaoBan($request, $config);
    }

    /**
     * Hiển thị báo cáo ban
     */
    public function baoCaoBan(Request $request, string $banType): View
    {
        $config = $this->getBanConfig($banType);
        return $this->baoCaoController->baoCaoBan($request, $config);
    }

    /**
     * Cập nhật số lượng tham dự và dâng hiến cho một buổi nhóm
     */
    public function updateThamDu(Request $request, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->baoCaoController->updateThamDu($request, $config);
    }

    /**
     * Lưu tất cả số lượng tham dự và dâng hiến
     */
    public function saveThamDu(Request $request, string $banType)
    {
        $config = $this->getBanConfig($banType);
        return $this->baoCaoController->saveThamDu($request, $config);
    }

    /**
     * Lưu đánh giá báo cáo
     */
    public function saveDanhGia(Request $request, string $banType)
    {
        $config = $this->getBanConfig($banType);
        return $this->baoCaoController->saveDanhGia($request, $config);
    }

    /**
     * Lưu kế hoạch báo cáo
     */
    public function saveKeHoach(Request $request, string $banType)
    {
        $config = $this->getBanConfig($banType);
        return $this->baoCaoController->saveKeHoach($request, $config);
    }

    /**
     * Lưu kiến nghị báo cáo
     */
    public function saveKienNghi(Request $request, string $banType)
    {
        $config = $this->getBanConfig($banType);
        return $this->baoCaoController->saveKienNghi($request, $config);
    }

    /**
     * Lưu toàn bộ báo cáo ban
     */
    public function luuBaoCao(Request $request, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->baoCaoController->luuBaoCao($request, $config);
    }

    /**
     * Cập nhật số lượng tham dự
     */
    public function capNhatSoLuongThamDu(Request $request, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->baoCaoController->capNhatSoLuongThamDu($request, $config);
    }

    /**
     * Xóa đánh giá (điểm mạnh hoặc điểm yếu)
     */
    public function xoaDanhGia($id, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->baoCaoController->xoaDanhGia($id, $config);
    }

    /**
     * Xóa kiến nghị
     */
    public function xoaKienNghi($id, string $banType): JsonResponse
    {
        $config = $this->getBanConfig($banType);
        return $this->baoCaoController->xoaKienNghi($id, $config);
    }
}
