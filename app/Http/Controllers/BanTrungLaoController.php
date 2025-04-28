<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BanTrungLao\BanTrungLaoThanhVienController;
use App\Http\Controllers\BanTrungLao\BanTrungLaoThamViengController;
use App\Http\Controllers\BanTrungLao\BanTrungLaoBaoCaoController;
use App\Models\BuoiNhom;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class BanTrungLaoController extends Controller
{
    protected $thanhVienController;
    protected $thamViengController;
    protected $baoCaoController;

    public function __construct(
        BanTrungLaoThanhVienController $thanhVienController,
        BanTrungLaoThamViengController $thamViengController,
        BanTrungLaoBaoCaoController $baoCaoController
    ) {
        $this->thanhVienController = $thanhVienController;
        $this->thamViengController = $thamViengController;
        $this->baoCaoController = $baoCaoController;
    }

    /**
     * Hiển thị trang chính của Ban Trung Lão
     */
    public function index(): View
    {
        return $this->thanhVienController->index();
    }

    /**
     * Thêm thành viên vào Ban Trung Lão
     */
    public function themThanhVien(Request $request): JsonResponse
    {
        return $this->thanhVienController->themThanhVien($request);
    }

    /**
     * Xóa thành viên khỏi Ban Trung Lão
     */
    public function xoaThanhVien(Request $request): JsonResponse
    {
        return $this->thanhVienController->xoaThanhVien($request);
    }

    /**
     * Cập nhật chức vụ thành viên trong Ban Trung Lão
     */
    public function capNhatChucVu(Request $request): JsonResponse
    {
        return $this->thanhVienController->capNhatChucVu($request);
    }

    /**
     * Hiển thị trang điểm danh của Ban Trung Lão
     */
    public function diemDanh(Request $request): View
    {
        return $this->thanhVienController->diemDanh($request);
    }

    /**
     * Xử lý lưu điểm danh
     */
    public function luuDiemDanh(Request $request): JsonResponse
    {
        return $this->thanhVienController->luuDiemDanh($request);
    }

    /**
     * Thêm buổi nhóm mới
     */
    public function themBuoiNhom(Request $request): JsonResponse
    {
        return $this->thanhVienController->themBuoiNhom($request);
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
     * Lấy danh sách Ban Điều Hành (JSON cho DataTables)
     */
    public function dieuHanhList(Request $request): JsonResponse
    {
        return $this->thanhVienController->dieuHanhList($request);
    }

    /**
     * Lấy danh sách Ban Viên (JSON cho DataTables)
     */
    public function banVienList(Request $request): JsonResponse
    {
        return $this->thanhVienController->banVienList($request);
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
    public function formBaoCaoBanTrungLao(Request $request): View
    {
        return $this->baoCaoController->formBaoCaoBanTrungLao($request);
    }

    /**
     * Hiển thị báo cáo Ban Trung Lão
     */
    public function baoCaoBanTrungLao(Request $request): View
    {
        return $this->baoCaoController->baoCaoBanTrungLao($request);
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
    public function luuBaoCaoBanTrungLao(Request $request): JsonResponse
    {
        return $this->baoCaoController->luuBaoCaoBanTrungLao($request);
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
