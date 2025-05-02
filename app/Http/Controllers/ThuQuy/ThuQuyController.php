<?php

namespace App\Http\Controllers\ThuQuy;

use App\Http\Controllers\Controller;
use App\Models\LichSuThaoTac;
use App\Models\NguoiDung;
use App\Models\ThongBaoTaiChinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThuQuyController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            // Kiểm tra quyền truy cập vào phân hệ Thủ quỹ
            if (!$this->kiemTraQuyenThuQuy()) {
                return redirect()->route('dashboard')->with('error', 'Bạn không có quyền truy cập vào phân hệ Thủ quỹ');
            }

            return $next($request);
        });
    }

    /**
     * Kiểm tra quyền người dùng có phải là Thủ quỹ
     * Vai trò 'quan_tri' hoặc quản lý một quỹ tài chính
     */
    protected function kiemTraQuyenThuQuy()
    {
        if ($this->user->vai_tro === 'quan_tri') {
            return true;
        }

        $tinHuu = $this->user->tinHuu;
        return $tinHuu && $tinHuu->quanLyQuy()->count() > 0;
    }

    /**
     * Kiểm tra quyền duyệt giao dịch
     * Vai trò 'quan_tri' hoặc 'truong_ban'
     */
    protected function kiemTraQuyenDuyet()
    {
        return in_array($this->user->vai_tro, ['quan_tri', 'truong_ban']);
    }

    /**
     * Ghi log thao tác người dùng
     */
    protected function ghiLogThaoTac($hanhDong, $bangTacDong, $idTacDong, $duLieuCu = null, $duLieuMoi = null)
    {
        LichSuThaoTac::create([
            'nguoi_dung_id' => $this->user->id,
            'hanh_dong' => $hanhDong,
            'bang_tac_dong' => $bangTacDong,
            'id_tac_dong' => $idTacDong,
            'du_lieu_cu' => json_encode($duLieuCu),
            'du_lieu_moi' => json_encode($duLieuMoi),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    /**
     * Gửi thông báo cho người dùng
     */
    protected function guiThongBao($tieuDe, $noiDung, $loai, $nguoiNhanId, $referenceType = null, $referenceId = null)
    {
        ThongBaoTaiChinh::create([
            'tieu_de' => $tieuDe,
            'noi_dung' => $noiDung,
            'loai' => $loai,
            'nguoi_nhan_id' => $nguoiNhanId,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId
        ]);
    }

    /**
     * Cập nhật số dư quỹ tài chính
     */
    protected function capNhatSoDuQuy($quyId, $soTien, $loai)
    {
        $quy = \App\Models\QuyTaiChinh::findOrFail($quyId);

        if ($loai === 'thu') {
            $quy->so_du_hien_tai += $soTien;
        } else {
            $quy->so_du_hien_tai -= $soTien;
        }

        $quy->save();

        return $quy;
    }

    /**
     * Format số tiền hiển thị
     */
    protected function formatTien($soTien)
    {
        return number_format($soTien, 0, ',', '.') . ' VNĐ';
    }

    /**
     * Tạo mã giao dịch tự động
     * Format: [THU/CHI]_[Năm][Tháng][Ngày]_[ID tự tăng]
     */
    protected function taoMaGiaoDich($loai, $id)
    {
        $prefix = ($loai === 'thu') ? 'THU' : 'CHI';
        $ngay = now()->format('Ymd');
        return $prefix . '_' . $ngay . '_' . str_pad($id, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Lấy danh sách admin và trưởng ban để duyệt giao dịch
     */
    protected function layDanhSachNguoiDuyet()
    {
        return NguoiDung::whereIn('vai_tro', ['quan_tri', 'truong_ban'])->get();
    }

    /**
     * Kiểm tra quyền tạo báo cáo
     */
    protected function kiemTraQuyenTaoBaoCao()
    {
        return in_array($this->user->vai_tro, ['quan_tri', 'truong_ban']);
    }
}