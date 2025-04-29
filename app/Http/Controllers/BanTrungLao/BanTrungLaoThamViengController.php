<?php

namespace App\Http\Controllers\BanTrungLao;

use App\Http\Controllers\Controller;
use App\Models\BanNganh;
use App\Models\ThamVieng;
use App\Models\TinHuu;
use App\Models\TinHuuBanNganh;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BanTrungLaoThamViengController extends Controller
{
    private const BAN_TRUNG_LAO_ID = 1;

    /**
     * Hiển thị trang thăm viếng
     */
    public function thamVieng()
    {
        $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
        if (!$banTrungLao) {
            return redirect()->route('_ban_nganh.index')->with('error', 'Không tìm thấy Ban Trung Lão');
        }

        $thanhVienBanTrungLao = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banTrungLao->id)
            ->get();

        $danhSachTinHuu = TinHuu::orderBy('ho_ten')->get();

        $deXuatThamVieng = TinHuu::select('*')
            ->selectRaw('DATEDIFF(?, ngay_tham_vieng_gan_nhat) as so_ngay_chua_tham', [Carbon::now()])
            ->where(function ($query) {
                $query->whereNotNull('ngay_tham_vieng_gan_nhat')
                    ->orWhereNull('ngay_tham_vieng_gan_nhat');
            })
            ->orderByRaw('ngay_tham_vieng_gan_nhat IS NULL DESC, ngay_tham_vieng_gan_nhat ASC')
            ->limit(20)
            ->get();

        $tinHuuWithLocations = TinHuu::whereNotNull('vi_do')
            ->whereNotNull('kinh_do')
            ->get();

        $lichSuThamVieng = ThamVieng::with(['tinHuu', 'nguoiTham'])
            ->where('id_ban', $banTrungLao->id)
            ->where('trang_thai', 'da_tham')
            ->whereDate('ngay_tham', '>=', Carbon::now()->subDays(60))
            ->orderBy('ngay_tham', 'desc')
            ->limit(50)
            ->get();

        $thongKe = $this->getThongKeThamVieng($banTrungLao->id);

        return view('_ban_trung_lao.tham_vieng', compact(
            'banTrungLao',
            'thanhVienBanTrungLao',
            'danhSachTinHuu',
            'deXuatThamVieng',
            'tinHuuWithLocations',
            'lichSuThamVieng',
            'thongKe'
        ));
    }

    /**
     * Tạo thống kê thăm viếng
     */
    private function getThongKeThamVieng($banNganhId)
    {
        $thongKe = [
            'total_visits' => 0,
            'this_month' => 0,
            'months' => [],
            'counts' => []
        ];

        $thongKe['total_visits'] = ThamVieng::where('id_ban', $banNganhId)
            ->where('trang_thai', 'da_tham')
            ->count();

        $monthlyStats = ThamVieng::selectRaw('MONTH(ngay_tham) as month, YEAR(ngay_tham) as year, COUNT(*) as count')
            ->where('id_ban', $banNganhId)
            ->where('trang_thai', 'da_tham')
            ->whereBetween('ngay_tham', [Carbon::now()->subMonths(5), Carbon::now()])
            ->groupBy('month', 'year')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $thongKe['this_month'] = $monthlyStats->firstWhere('month', $currentMonth)
            ?->where('year', $currentYear)->count ?? 0;

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = $monthlyStats->firstWhere('month', $month->month)
                ?->where('year', $month->year)->count ?? 0;
            $thongKe['months'][] = $month->format('m/Y');
            $thongKe['counts'][] = $count;
        }

        return $thongKe;
    }

    /**
     * Thêm lần thăm mới
     */
    public function themThamVieng(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'nguoi_tham_id' => 'required|exists:tin_huu,id',
            'ngay_tham' => 'required|date',
            'noi_dung' => 'required|string',
            'ket_qua' => 'nullable|string',
            'trang_thai' => 'required|in:da_tham,ke_hoach',
            'id_ban' => 'required|exists:ban_nganh,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $thamVieng = ThamVieng::create([
                'tin_huu_id' => $request->tin_huu_id,
                'nguoi_tham_id' => $request->nguoi_tham_id,
                'id_ban' => $request->id_ban,
                'ngay_tham' => $request->ngay_tham,
                'noi_dung' => $request->noi_dung,
                'ket_qua' => $request->ket_qua,
                'trang_thai' => $request->trang_thai,
            ]);

            if ($request->trang_thai == 'da_tham') {
                TinHuu::where('id', $request->tin_huu_id)->update([
                    'ngay_tham_vieng_gan_nhat' => $request->ngay_tham
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm lần thăm thành công',
                'data' => $thamVieng
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi thêm thăm viếng: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi thêm lần thăm: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lọc đề xuất thăm viếng theo số ngày
     */
    public function filterDeXuatThamVieng(Request $request)
    {
        $days = $request->input('days', 60);
        $cutoffDate = Carbon::now()->subDays($days);
        $now = Carbon::now();

        $tinHuuList = TinHuu::select('*')
            ->selectRaw('DATEDIFF(?, ngay_tham_vieng_gan_nhat) as so_ngay_chua_tham', [$now])
            ->where(function ($query) use ($cutoffDate) {
                $query->where('ngay_tham_vieng_gan_nhat', '<=', $cutoffDate)
                    ->orWhereNull('ngay_tham_vieng_gan_nhat');
            })
            ->orderByRaw('ngay_tham_vieng_gan_nhat IS NULL DESC, ngay_tham_vieng_gan_nhat ASC')
            ->limit(20)
            ->get();

        $tinHuuList->transform(function ($tinHuu) {
            $tinHuu->ngay_tham_vieng_gan_nhat_formatted = $tinHuu->ngay_tham_vieng_gan_nhat
                ? Carbon::parse($tinHuu->ngay_tham_vieng_gan_nhat)->format('d/m/Y')
                : null;
            return $tinHuu;
        });

        return response()->json([
            'success' => true,
            'data' => $tinHuuList
        ]);
    }

    /**
     * Lọc lịch sử thăm viếng theo khoảng thời gian
     */
    public function filterThamVieng(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();

        if (!$fromDate || !$toDate) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn khoảng thời gian'
            ], 422);
        }

        $thamViengs = ThamVieng::with(['tinHuu', 'nguoiTham'])
            ->where('id_ban', $banTrungLao->id)
            ->whereDate('ngay_tham', '>=', $fromDate)
            ->whereDate('ngay_tham', '<=', $toDate)
            ->orderBy('ngay_tham', 'desc')
            ->get();

        $formattedResults = $thamViengs->map(function ($thamVieng) {
            return [
                'id' => $thamVieng->id,
                'ngay_tham_formatted' => Carbon::parse($thamVieng->ngay_tham)->format('d/m/Y'),
                'tin_huu_name' => $thamVieng->tinHuu ? $thamVieng->tinHuu->ho_ten : null,
                'nguoi_tham_name' => $thamVieng->nguoiTham ? $thamVieng->nguoiTham->ho_ten : null,
                'trang_thai' => $thamVieng->trang_thai
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedResults
        ]);
    }

    /**
     * Lấy chi tiết một lần thăm viếng
     */
    public function chiTietThamVieng($id)
    {
        try {
            $thamVieng = ThamVieng::with(['tinHuu', 'nguoiTham', 'banNganh'])->findOrFail($id);

            $data = [
                'id' => $thamVieng->id,
                'tin_huu_name' => $thamVieng->tinHuu ? $thamVieng->tinHuu->ho_ten : null,
                'nguoi_tham_name' => $thamVieng->nguoiTham ? $thamVieng->nguoiTham->ho_ten : null,
                'ngay_tham_formatted' => Carbon::parse($thamVieng->ngay_tham)->format('d/m/Y'),
                'noi_dung' => $thamVieng->noi_dung,
                'ket_qua' => $thamVieng->ket_qua,
                'trang_thai' => $thamVieng->trang_thai,
                'ban_name' => $thamVieng->banNganh ? $thamVieng->banNganh->ten : null
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy chi tiết thăm viếng ID ' . $id . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy bản ghi thăm viếng hoặc lỗi hệ thống'
            ], 404);
        }
    }
}