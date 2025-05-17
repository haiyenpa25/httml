<?php

namespace App\Http\Controllers;

use App\Models\BanNganh;
use App\Models\BuoiNhom;
use App\Models\GiaoDichTaiChinh;
use App\Models\TinHuu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrangChuController extends Controller
{
    public function index(Request $request)
    {
        // Lấy tháng và năm từ request hoặc sử dụng tháng và năm hiện tại
        $thang = $request->input('thang', Carbon::now()->month);
        $nam = $request->input('nam', Carbon::now()->year);

        // Lấy ban ngành từ request hoặc sử dụng tất cả
        $banNganhId = $request->input('ban_nganh_id');
        $thamGiaBanNganhId = $request->input('tham_gia_ban_nganh_id');
        $thoiGian = $request->input('thoi_gian', 'tuan');

        // Danh sách ban ngành cho dropdown
        $danhSachBanNganh = BanNganh::orderBy('ten')->get();

        // 1. Danh sách tín hữu có sinh nhật trong tháng/năm đã chọn
        $tinHuuSinhNhat = TinHuu::whereMonth('ngay_sinh', $thang)
            ->orderBy(DB::raw('DAY(ngay_sinh)'))
            ->get();

        // 2. Danh sách buổi nhóm trong tháng/năm đã chọn, lọc theo ban ngành nếu có
        $buoiNhomQuery = BuoiNhom::with(['lichBuoiNhom', 'banNganh', 'dienGia'])
            ->whereMonth('ngay_dien_ra', $thang)
            ->whereYear('ngay_dien_ra', $nam)
            ->where('trang_thai', '!=', 'huy')
            ->orderBy('ngay_dien_ra')
            ->orderBy('gio_bat_dau');

        if ($banNganhId) {
            $buoiNhomQuery->where('ban_nganh_id', $banNganhId);
        }

        $buoiNhomSapToi = $buoiNhomQuery->take(10)->get();




        // 3. Dữ liệu cho biểu đồ 1: Thống kê số lượng tín hữu theo ban ngành
        $thongKeBanNganh = BanNganh::withCount('tinHuu')
            ->orderBy('tin_huu_count', 'desc')
            ->take(5)
            ->get();

        // 4. Dữ liệu cho biểu đồ 2: Thống kê thu chi tài chính trong 6 tháng gần nhất
        $thongKeTaiChinh = $this->getThongKeTaiChinh();

        // 5. Thống kê số lượng tham gia buổi nhóm theo ban ngành
        $thongKeThamGia = $this->getThongKeThamGiaBuoiNhom($thamGiaBanNganhId, $thoiGian) ?? [
            'labels' => [],
            'datasets' => [],
            'so_buoi_nhom' => []
        ];

        return view('trang-chu.index', compact(
            'tinHuuSinhNhat',
            'buoiNhomSapToi',
            'thongKeBanNganh',
            'thongKeTaiChinh',
            'thongKeThamGia',
            'danhSachBanNganh',
            'thang',
            'nam',
            'banNganhId',
            'thamGiaBanNganhId',
            'thoiGian'
        ));
    }

    /**
     * Lấy dữ liệu thống kê thu chi tài chính trong 6 tháng gần nhất
     */
    private function getThongKeTaiChinh()
    {
        $result = [];
        $now = Carbon::now();

        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $monthName = $month->translatedFormat('m/Y');

            $totalThu = GiaoDichTaiChinh::whereMonth('ngay_giao_dich', $month->month)
                ->whereYear('ngay_giao_dich', $month->year)
                ->where('loai', 'thu')
                ->sum('so_tien');

            $totalChi = GiaoDichTaiChinh::whereMonth('ngay_giao_dich', $month->month)
                ->whereYear('ngay_giao_dich', $month->year)
                ->where('loai', 'chi')
                ->sum('so_tien');

            $result[] = [
                'thang' => $monthName,
                'thu' => $totalThu,
                'chi' => $totalChi,
            ];
        }

        return $result;
    }

    /**
     * Lấy dữ liệu thống kê số lượng tín hữu tham gia buổi nhóm theo ban ngành và thời gian
     * @param int|null $banNganhId
     * @param string $thoiGian (tuan, thang, quy)
     * @return array
     */
    private function getThongKeThamGiaBuoiNhom($banNganhId = null, $thoiGian = 'tuan')
    {
        $result = [
            'labels' => [],
            'datasets' => [],
            'so_buoi_nhom' => []
        ];
        $now = Carbon::now();
        $danhSachBanNganh = BanNganh::pluck('ten', 'id')->toArray();

        $soKhoangThoiGian = ($thoiGian == 'quy') ? 4 : 5;

        // Xác định khoảng thời gian
        $thoiGianFunc = match ($thoiGian) {
            'tuan' => function ($i) use ($now) {
                    return [
                    'start' => $now->copy()->subWeeks($i)->startOfWeek(),
                    'end' => $now->copy()->subWeeks($i)->endOfWeek(),
                    'label' => $now->copy()->subWeeks($i)->startOfWeek()->format('d/m') . ' - ' .
                        $now->copy()->subWeeks($i)->endOfWeek()->format('d/m')
                    ];
                },
            'thang' => function ($i) use ($now) {
                    return [
                    'start' => $now->copy()->subMonths($i)->startOfMonth(),
                    'end' => $now->copy()->subMonths($i)->endOfMonth(),
                    'label' => $now->copy()->subMonths($i)->format('m/Y')
                    ];
                },
            'quy' => function ($i) use ($now) {
                    $quarter = $now->copy()->subQuarters($i);
                    return [
                    'start' => $quarter->copy()->startOfQuarter(),
                    'end' => $quarter->copy()->endOfQuarter(),
                    'label' => 'Q' . $quarter->quarter . '/' . $quarter->year
                    ];
                },
            default => function ($i) use ($now) {
                    return [
                    'start' => $now->copy()->subWeeks($i)->startOfWeek(),
                    'end' => $now->copy()->subWeeks($i)->endOfWeek(),
                    'label' => $now->copy()->subWeeks($i)->startOfWeek()->format('d/m') . ' - ' .
                        $now->copy()->subWeeks($i)->endOfWeek()->format('d/m')
                    ];
                }
        };

        // Khởi tạo mảng ban ngành
        $banNganhData = [];

        if ($banNganhId) {
            $banNganhData[$banNganhId] = [
                'ten' => $danhSachBanNganh[$banNganhId] ?? "Ban ngành #$banNganhId",
                'data' => array_fill(0, $soKhoangThoiGian, 0)
            ];
        } else {
            foreach (BanNganh::take(5)->orderBy('ten')->get() as $bn) {
                $banNganhData[$bn->id] = [
                    'ten' => $bn->ten,
                    'data' => array_fill(0, $soKhoangThoiGian, 0)
                ];
            }
        }

        // Nếu không có ban ngành nào, trả về dữ liệu rỗng
        if (empty($banNganhData)) {
            for ($i = $soKhoangThoiGian - 1; $i >= 0; $i--) {
                $period = $thoiGianFunc($i);
                $result['labels'][] = $period['label'];
                $result['so_buoi_nhom'][] = 0;
            }
            return $result;
        }

        // Tạo cấu trúc kết quả
        for ($i = $soKhoangThoiGian - 1; $i >= 0; $i--) {
            $period = $thoiGianFunc($i);

            $buoiNhomQuery = BuoiNhom::with('chiTietThamGia')
                ->whereBetween('ngay_dien_ra', [$period['start'], $period['end']])
                ->where('trang_thai', 'da_dien_ra');

            if ($banNganhId) {
                $buoiNhomQuery->where('ban_nganh_id', $banNganhId);
            }

            $buoiNhom = $buoiNhomQuery->get();

            foreach ($buoiNhom as $bn) {
                if (isset($banNganhData[$bn->ban_nganh_id])) {
                    $banNganhData[$bn->ban_nganh_id]['data'][$soKhoangThoiGian - 1 - $i] += ($bn->so_luong_tin_huu + $bn->so_luong_than_huu);
                }
            }

            $result['labels'][] = $period['label'];
            $result['so_buoi_nhom'][] = count($buoiNhom);
        }

        // Chuyển đổi dữ liệu ban ngành thành định dạng datasets
        $colors = [
            'rgba(60, 141, 188, 0.7)',
            'rgba(40, 167, 69, 0.7)',
            'rgba(220, 53, 69, 0.7)',
            'rgba(255, 193, 7, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(23, 162, 184, 0.7)',
            'rgba(108, 117, 125, 0.7)',
        ];

        foreach ($banNganhData as $id => $bnData) {
            $colorIndex = array_key_first($banNganhData) == $id ? 0 : (count($result['datasets']) % count($colors));
            $result['datasets'][] = [
                'label' => $bnData['ten'],
                'data' => $bnData['data'],
                'backgroundColor' => $colors[$colorIndex],
                'borderColor' => str_replace('0.7', '1', $colors[$colorIndex]),
                'borderWidth' => 1
            ];
        }

        return $result;
    }
}
