<?php
namespace App\Http\Controllers;

use App\Http\Controllers\BanMucVu\BanMucVuThanhVienController;
use App\Http\Controllers\BanMucVu\BanMucVuThamViengController;
use App\Http\Controllers\BanMucVu\BanMucVuBaoCaoController;
use App\Models\BuoiNhom;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Cache;

class BanMucVuController extends Controller
{
    use ApiResponseTrait;

    protected $thanhVienController;
    protected $thamViengController;
    protected $baoCaoController;

    /**
     * Khởi tạo controller với dependency injection
     */
    public function __construct(
        BanMucVuThanhVienController $thanhVienController,
        BanMucVuThamViengController $thamViengController,
        BanMucVuBaoCaoController $baoCaoController
    ) {
        $this->thanhVienController = $thanhVienController;
        $this->thamViengController = $thamViengController;
        $this->baoCaoController = $baoCaoController;
    }

    /**
     * Hiển thị trang chính của Ban Mục Vụ
     */
    public function index(Request $request): View
    {
        return $this->thanhVienController->index($request);
    }

    /**
     * Hiển thị trang điểm danh của Ban Mục Vụ
     */
    public function diemDanh(Request $request): View
    {
        return $this->thanhVienController->diemDanh($request);
    }

    /**
     * Thêm buổi nhóm mới
     */
    public function themBuoiNhom(Request $request): JsonResponse
    {
        return $this->thanhVienController->themBuoiNhom($request);
    }

    /**
     * Hiển thị trang phân công của Ban Mục Vụ
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
    public function thamVieng(Request $request): View
    {
        return $this->thamViengController->thamVieng($request);
    }

    /**
     * Hiển thị form nhập liệu báo cáo Ban Mục Vụ
     */
    public function formBaoCaoBanMucVu(Request $request): View
    {
        return $this->baoCaoController->formBaoCaoBanMucVu($request);
    }

    /**
     * Hiển thị báo cáo Ban Mục Vụ
     */
    public function baoCaoBanMucVu(Request $request): View
    {
        return $this->baoCaoController->baoCaoBanMucVu($request);
    }
}