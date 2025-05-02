<?php

namespace App\Http\Controllers\ThuQuy;

use App\Models\BaoCaoTaiChinh;
use App\Models\ChiDinhKy;
use App\Models\GiaoDichTaiChinh;
use App\Models\QuyTaiChinh;
use App\Models\ThongBaoTaiChinh;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends ThuQuyController
{
    /**
     * Hiển thị trang dashboard
     */
    public function index()
    {
        // Dữ liệu tổng quan
        $tongQuy = QuyTaiChinh::where('trang_thai', 'hoat_dong')->count();
        $tongSoDu = QuyTaiChinh::where('trang_thai', 'hoat_dong')->sum('so_du_hien_tai');

        // Thống kê giao dịch trong 30 ngày
        $tuNgay = Carbon::now()->subDays(30);
        $denNgay = Carbon::now();

        $tongThu30Ngay = GiaoDichTaiChinh::where('trang_thai', 'hoan_thanh')
            ->where('loai', 'thu')
            ->whereBetween('ngay_giao_dich', [$tuNgay, $denNgay])
            ->sum('so_tien');

        $tongChi30Ngay = GiaoDichTaiChinh::where('trang_thai', 'hoan_thanh')
            ->where('loai', 'chi')
            ->whereBetween('ngay_giao_dich', [$tuNgay, $denNgay])
            ->sum('so_tien');

        // Thống kê giao dịch 7 ngày
        $ngay7Ngay = Carbon::now()->subDays(7);
        $thongKeGiaoDich7Ngay = GiaoDichTaiChinh::where('trang_thai', 'hoan_thanh')
            ->where('ngay_giao_dich', '>=', $ngay7Ngay)
            ->select('loai', DB::raw('SUM(so_tien) as tong_tien'), DB::raw('COUNT(id) as so_luong'))
            ->groupBy('loai')
            ->get()
            ->keyBy('loai');

        // Giao dịch chờ duyệt
        $choDuyet = GiaoDichTaiChinh::where('trang_thai', 'cho_duyet')->count();

        // Chi định kỳ trong 7 ngày tới
        $sapThanhToan = ChiDinhKy::where('trang_thai', 'hoat_dong')
            ->where(function ($query) {
                $today = Carbon::now();
                $endDate = Carbon::now()->addDays(7);

                $query->orWhere(function ($q) use ($today, $endDate) {
                    $q->where('tan_suat', 'hang_thang')
                        ->where('ngay_thanh_toan', '>=', $today->day)
                        ->where('ngay_thanh_toan', '<=', $endDate->day);
                })->orWhere(function ($q) use ($today) {
                    $q->where('tan_suat', 'hang_quy')
                        ->where('ngay_thanh_toan', $today->day)
                        ->whereRaw('MOD(?, 3) = 0', [$today->month]);
                })->orWhere(function ($q) use ($today) {
                    $q->where('tan_suat', 'nua_nam')
                        ->where('ngay_thanh_toan', $today->day)
                        ->whereIn('thang_thanh_toan', [6, 12]);
                })->orWhere(function ($q) use ($today) {
                    $q->where('tan_suat', 'hang_nam')
                        ->where('thang_thanh_toan', $today->month);
                });
            })->count();

        // Giao dịch mới nhất
        $giaoDichMoiNhat = GiaoDichTaiChinh::with(['quyTaiChinh', 'banNganh'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Báo cáo gần đây
        $baoCaoGanDay = BaoCaoTaiChinh::with(['quyTaiChinh', 'nguoiTao'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Thông báo chưa đọc
        $thongBaoMoi = ThongBaoTaiChinh::where('nguoi_nhan_id', $this->user->id)
            ->where('da_doc', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Dữ liệu biểu đồ
        $dataChart = $this->layDataBieuDoThuChi();
        $dataPieChart = $this->layDataBieuDoPhanBo();

        return view('_thu_quy.dashboard.index', compact(
            'tongQuy',
            'tongSoDu',
            'tongThu30Ngay',
            'tongChi30Ngay',
            'thongKeGiaoDich7Ngay',
            'choDuyet',
            'sapThanhToan',
            'giaoDichMoiNhat',
            'baoCaoGanDay',
            'thongBaoMoi',
            'dataChart',
            'dataPieChart'
        ));
    }

    /**
     * Lấy dữ liệu biểu đồ thu chi 12 tháng
     */
    private function layDataBieuDoThuChi()
    {
        $result = [
            'labels' => [],
            'thu' => [],
            'chi' => []
        ];

        $thang12 = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $thang12[] = [
                'thang' => $date->month,
                'nam' => $date->year,
                'label' => 'T' . $date->month . '/' . $date->year
            ];
        }

        $thongKe = GiaoDichTaiChinh::where('trang_thai', 'hoan_thanh')
            ->where('ngay_giao_dich', '>=', Carbon::now()->subMonths(12))
            ->select(
                DB::raw('MONTH(ngay_giao_dich) as thang'),
                DB::raw('YEAR(ngay_giao_dich) as nam'),
                'loai',
                DB::raw('SUM(so_tien) as tong_tien')
            )
            ->groupBy('thang', 'nam', 'loai')
            ->get();

        foreach ($thang12 as $t) {
            $result['labels'][] = $t['label'];
            $dataThu = $thongKe->firstWhere(fn($item) => $item->thang == $t['thang'] && $item->nam == $t['nam'] && $item->loai == 'thu');
            $dataChi = $thongKe->firstWhere(fn($item) => $item->thang == $t['thang'] && $item->nam == $t['nam'] && $item->loai == 'chi');
            $result['thu'][] = $dataThu ? $dataThu->tong_tien : 0;
            $result['chi'][] = $dataChi ? $dataChi->tong_tien : 0;
        }

        return $result;
    }

    /**
     * Lấy dữ liệu biểu đồ phân bổ theo quỹ
     */
    private function layDataBieuDoPhanBo()
    {
        return QuyTaiChinh::where('trang_thai', 'hoat_dong')
            ->where('so_du_hien_tai', '>', 0)
            ->get()
            ->map(fn($quy) => [
                'name' => $quy->ten_quy,
                'y' => $quy->so_du_hien_tai
            ]);
    }

    /**
     * Đánh dấu thông báo đã đọc
     */
    public function danhDauThongBaoDaDoc($id)
    {
        $thongBao = ThongBaoTaiChinh::where('nguoi_nhan_id', $this->user->id)
            ->findOrFail($id);

        $thongBao->update([
            'da_doc' => true,
            'ngay_doc' => Carbon::now()
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Đánh dấu tất cả thông báo đã đọc
     */
    public function danhDauTatCaDaDoc()
    {
        ThongBaoTaiChinh::where('nguoi_nhan_id', $this->user->id)
            ->where('da_doc', false)
            ->update([
                'da_doc' => true,
                'ngay_doc' => Carbon::now()
            ]);

        return response()->json(['success' => true]);
    }

    /**
     * Hiển thị danh sách tất cả thông báo
     */
    public function tatCaThongBao()
    {
        $thongBao = ThongBaoTaiChinh::where('nguoi_nhan_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('_thu_quy.dashboard.thong_bao', compact('thongBao'));
    }

    /**
     * Lấy số lượng thông báo chưa đọc
     */
    public function soLuongThongBaoChuaDoc()
    {
        $count = ThongBaoTaiChinh::where('nguoi_nhan_id', $this->user->id)
            ->where('da_doc', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}