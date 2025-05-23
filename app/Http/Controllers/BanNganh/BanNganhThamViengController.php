<?php

namespace App\Http\Controllers\BanNganh;

use App\Http\Controllers\Controller;
use App\Models\BuoiNhom;
use App\Models\DanhGia;
use App\Models\GiaoDichTaiChinh;
use App\Models\KeHoach;
use App\Models\KienNghi;
use App\Models\ThamVieng;
use App\Models\TinHuu;
use App\Models\TinHuuBanNganh;
use App\Models\BanNganh;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class BanNganhThamViengController extends Controller
{
    /**
     * Hiển thị trang thăm viếng
     */
    public function thamVieng(array $config): View
    {
        // Kiểm tra cấu hình
        if (!isset($config['id']) || !is_numeric($config['id'])) {
            Log::error("Cấu hình không chứa ID hợp lệ cho {$config['name']}", $config);
            return redirect()->route('_ban_nganh.index', ['banType' => request()->route('banType')])
                ->with('error', "Cấu hình không hợp lệ cho {$config['name']}");
        }

        // Tối ưu truy vấn với cache
        $banNganh = Cache::remember("ban_nganh_{$config['id']}", now()->addDay(), function () use ($config) {
            return BanNganh::where('id', $config['id'])->first();
        });

        if (!$banNganh) {
            $banName = $config['name'] ?? 'Ban Ngành';
            return redirect()->route('_ban_nganh.index', ['banType' => request()->route('banType')])
                ->with('error', "Không tìm thấy {$banName}");
        }

        $thanhVienBan = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banNganh->id)
            ->get();

        $danhSachTinHuu = TinHuu::orderBy('ho_ten')->get();

        $tinHuuWithLocations = TinHuu::whereNotNull('vi_do')
            ->whereNotNull('kinh_do')
            ->get();

        $lichSuThamVieng = collect();
        $lichSuThamViengError = null;

        try {
            $lichSuThamVieng = ThamVieng::with(['tinHuu', 'nguoiTham'])
                ->where('id_ban', $banNganh->id)
                ->where('trang_thai', 'da_tham')
                ->whereDate('ngay_tham', '>=', Carbon::now()->subMonth()->startOfMonth())
                ->whereDate('ngay_tham', '<=', Carbon::now())
                ->orderBy('ngay_tham', 'desc')
                ->limit(50)
                ->get();

            if ($lichSuThamVieng->isEmpty()) {
                throw new \Exception('Không có dữ liệu lịch sử thăm viếng');
            }
        } catch (\Exception $e) {
            $lichSuThamViengError = $e->getMessage();
        }

        // Lấy danh sách đề xuất thăm viếng với phân trang
        $days = 60; // Mặc định 60 ngày
        $cutoffDate = Carbon::now()->subDays($days);
        $now = Carbon::now();

        $deXuatThamVieng = TinHuu::select('tin_huu.*')
            ->selectRaw('DATEDIFF(?, COALESCE(tin_huu.ngay_tham_vieng_gan_nhat, "1900-01-01")) as so_ngay_chua_tham', [$now])
            ->leftJoin('tin_huu_ban_nganh', 'tin_huu.id', '=', 'tin_huu_ban_nganh.tin_huu_id')
            ->where('tin_huu_ban_nganh.ban_nganh_id', $config['id'])
            ->where(function ($query) use ($cutoffDate) {
                $query->where('tin_huu.ngay_tham_vieng_gan_nhat', '<=', $cutoffDate)
                    ->orWhereNull('tin_huu.ngay_tham_vieng_gan_nhat');
            })
            ->orderByRaw('tin_huu.ngay_tham_vieng_gan_nhat IS NULL DESC, tin_huu.ngay_tham_vieng_gan_nhat ASC')
            ->paginate(10); // Phân trang 10 row

        $thongKe = $this->getThongKeThamVieng($banNganh->id);

        return view('_ban_nganh.tham_vieng', compact(
            'banNganh',
            'thanhVienBan',
            'danhSachTinHuu',
            'tinHuuWithLocations',
            'lichSuThamVieng',
            'thongKe',
            'lichSuThamViengError',
            'deXuatThamVieng',
            'config'
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
            'last_month' => 0,
            'months' => [],
            'counts' => []
        ];

        // Tổng số lần thăm
        $thongKe['total_visits'] = ThamVieng::where('id_ban', $banNganhId)
            ->where('trang_thai', 'da_tham')
            ->count();

        // Số lần thăm trong tháng này
        $thongKe['this_month'] = ThamVieng::where('id_ban', $banNganhId)
            ->where('trang_thai', 'da_tham')
            ->whereMonth('ngay_tham', Carbon::now()->month)
            ->whereYear('ngay_tham', Carbon::now()->year)
            ->count();

        // Số lần thăm trong tháng trước
        $thongKe['last_month'] = ThamVieng::where('id_ban', $banNganhId)
            ->where('trang_thai', 'da_tham')
            ->whereMonth('ngay_tham', Carbon::now()->subMonth()->month)
            ->whereYear('ngay_tham', Carbon::now()->subMonth()->year)
            ->count();

        // Dữ liệu biểu đồ (6 tháng gần nhất)
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = ThamVieng::where('id_ban', $banNganhId)
                ->where('trang_thai', 'da_tham')
                ->whereMonth('ngay_tham', $month->month)
                ->whereYear('ngay_tham', $month->year)
                ->count();

            $thongKe['months'][] = $month->format('m/Y');
            $thongKe['counts'][] = $count;
        }

        return $thongKe;
    }

    /**
     * Thêm lần thăm mới
     */
    public function themThamVieng(Request $request, array $config): JsonResponse
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

        if ($request->id_ban != $config['id']) {
            return response()->json([
                'success' => false,
                'message' => 'Ban ngành không hợp lệ!'
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

            // Cập nhật ngay_tham_vieng_gan_nhat nếu trạng thái là "da_tham"
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
            Log::error("Lỗi thêm thăm viếng {$config['name']}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi thêm lần thăm: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lọc đề xuất thăm viếng theo số ngày
     */
    public function filterDeXuatThamVieng(Request $request, array $config): JsonResponse
    {
        $days = $request->input('days', 60);
        $cutoffDate = Carbon::now()->subDays($days);
        $now = Carbon::now();

        $tinHuuList = TinHuu::select('tin_huu.*')
            ->selectRaw('DATEDIFF(?, COALESCE(tin_huu.ngay_tham_vieng_gan_nhat, "1900-01-01")) as so_ngay_chua_tham', [$now])
            ->leftJoin('tin_huu_ban_nganh', 'tin_huu.id', '=', 'tin_huu_ban_nganh.tin_huu_id')
            ->where('tin_huu_ban_nganh.ban_nganh_id', $config['id'])
            ->where(function ($query) use ($cutoffDate) {
                $query->where('tin_huu.ngay_tham_vieng_gan_nhat', '<=', $cutoffDate)
                    ->orWhereNull('tin_huu.ngay_tham_vieng_gan_nhat');
            })
            ->orderByRaw('tin_huu.ngay_tham_vieng_gan_nhat IS NULL DESC, tin_huu.ngay_tham_vieng_gan_nhat ASC')
            ->paginate(10);

        $tinHuuList->getCollection()->transform(function ($tinHuu) {
            $tinHuu->ngay_tham_vieng_gan_nhat_formatted = $tinHuu->ngay_tham_vieng_gan_nhat
                ? Carbon::parse($tinHuu->ngay_tham_vieng_gan_nhat)->format('d/m/Y')
                : null;
            return $tinHuu;
        });

        return response()->json([
            'success' => true,
            'data' => $tinHuuList->items(),
            'pagination' => [
                'current_page' => $tinHuuList->currentPage(),
                'last_page' => $tinHuuList->lastPage(),
                'per_page' => $tinHuuList->perPage(),
                'total' => $tinHuuList->total(),
            ]
        ]);
    }

    /**
     * Lọc lịch sử thăm viếng theo khoảng thời gian
     */
    public function filterThamVieng(Request $request, array $config): JsonResponse
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        if (!$fromDate || !$toDate) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng chọn khoảng thời gian'
            ], 422);
        }

        $thamViengs = ThamVieng::with(['tinHuu', 'nguoiTham'])
            ->where('id_ban', $config['id'])
            ->whereDate('ngay_tham', '>=', $fromDate)
            ->whereDate('ngay_tham', '<=', $toDate)
            ->orderBy('ngay_tham', 'desc')
            ->get();

        $formattedResults = $thamViengs->map(function ($thamVieng) {
            return [
                'id' => $thamVieng->id,
                'ngay_tham' => $thamVieng->ngay_tham,
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
    public function chiTietThamVieng($id, array $config): JsonResponse
    {
        try {
            $thamVieng = ThamVieng::with(['tinHuu', 'nguoiTham', 'banNganh'])
                ->where('id_ban', $config['id'])
                ->findOrFail($id);

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
            Log::error("Lỗi lấy chi tiết thăm viếng ID {$id} cho {$config['name']}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy bản ghi thăm viếng hoặc lỗi hệ thống'
            ], 404);
        }
    }

    /**
     * Cập nhật trạng thái và kết quả thăm viếng
     */
    public function updateThamVieng(Request $request, $id, array $config): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'trang_thai' => 'required|in:da_tham,ke_hoach',
            'ket_qua' => 'nullable|string',
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
            $thamVieng = ThamVieng::where('id_ban', $config['id'])->findOrFail($id);
            $thamVieng->trang_thai = $request->trang_thai;
            $thamVieng->ket_qua = $request->ket_qua;
            $thamVieng->save();

            if ($request->trang_thai == 'da_tham') {
                TinHuu::where('id', $thamVieng->tin_huu_id)->update([
                    'ngay_tham_vieng_gan_nhat' => $thamVieng->ngay_tham
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thăm viếng thành công',
                'data' => $thamVieng
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi cập nhật thăm viếng ID {$id} cho {$config['name']}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Hiển thị form nhập liệu báo cáo ban
     */
    public function formBaoCaoBan(Request $request, array $config): View
    {
        $month = (int) $request->get('month', date('m'));
        $year = (int) $request->get('year', date('Y'));
        $buoiNhomType = $request->get('buoi_nhom_type', 1);

        $nextMonth = $month == 12 ? 1 : $month + 1;
        $nextYear = $month == 12 ? $year + 1 : $year;

        $buoiNhomHT = BuoiNhom::with('dienGia')
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', $config['hoi_thanh_id'])
            ->orderBy('ngay_dien_ra')
            ->get();

        $buoiNhomBN = BuoiNhom::with(['dienGia', 'giaoDichTaiChinh'])
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', $config['id'])
            ->orderBy('ngay_dien_ra')
            ->get();

        $tinHuuBan = TinHuu::select('tin_huu.id', 'tin_huu.ho_ten')
            ->join('tin_huu_ban_nganh', 'tin_huu.id', '=', 'tin_huu_ban_nganh.tin_huu_id')
            ->where('tin_huu_ban_nganh.ban_nganh_id', $config['id'])
            ->orderBy('tin_huu.ho_ten')
            ->get();

        $diemManh = DanhGia::with('nguoiDanhGia')
            ->where('ban_nganh_id', $config['id'])
            ->where('loai', 'diem_manh')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $diemYeu = DanhGia::with('nguoiDanhGia')
            ->where('ban_nganh_id', $config['id'])
            ->where('loai', 'diem_yeu')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $keHoach = KeHoach::with('nguoiPhuTrach')
            ->where('ban_nganh_id', $config['id'])
            ->where('thang', $nextMonth)
            ->where('nam', $nextYear)
            ->get();

        $kienNghi = KienNghi::with('nguoiDeXuat')
            ->where('ban_nganh_id', $config['id'])
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $diemManhData = $diemManh->map(function ($item, $index) {
            return [
                'stt' => $index + 1,
                'noi_dung' => e($item->noi_dung ?? 'N/A'),
                'nguoi_danh_gia' => e($item->nguoiDanhGia ? $item->nguoiDanhGia->ho_ten : 'N/A'),
                'thao_tac' => '<button type="button" class="btn btn-danger btn-sm remove-danh-gia" data-id="' . e($item->id) . '"><i class="fas fa-trash"></i></button>'
            ];
        })->toArray() ?: [];

        $diemYeuData = $diemYeu->map(function ($item, $index) {
            return [
                'stt' => $index + 1,
                'noi_dung' => e($item->noi_dung ?? 'N/A'),
                'nguoi_danh_gia' => e($item->nguoiDanhGia ? $item->nguoiDanhGia->ho_ten : 'N/A'),
                'thao_tac' => '<button type="button" class="btn btn-danger btn-sm remove-danh-gia" data-id="' . e($item->id) . '"><i class="fas fa-trash"></i></button>'
            ];
        })->toArray() ?: [];

        Log::info("Dữ liệu điểm mạnh {$config['name']}:", ['count' => $diemManh->count(), 'data' => $diemManhData]);
        Log::info("Dữ liệu điểm yếu {$config['name']}:", ['count' => $diemYeu->count(), 'data' => $diemYeuData]);

        return view("ban_nganh.nhap_lieu_bao_cao", compact(
            'month',
            'year',
            'nextMonth',
            'nextYear',
            'buoiNhomHT',
            'buoiNhomBN',
            'tinHuuBan',
            'diemManh',
            'diemYeu',
            'keHoach',
            'kienNghi',
            'buoiNhomType',
            'diemManhData',
            'diemYeuData'
        ));
    }

    /**
     * Hiển thị báo cáo hoàn thiện của ban
     */
    // public function baoCaoBan(Request $request, array $config): View
    // {
    //     $month = $request->get('month', date('m'));
    //     $year = $request->get('year', date('Y'));

    //     $banDieuHanh = TinHuuBanNganh::with('tinHuu')
    //         ->where('ban_nganh_id', $config['id'])
    //         ->whereNotNull('chuc_vu')
    //         ->get();

    //     $buoiNhomHT = BuoiNhom::with('dienGia')
    //         ->whereYear('ngay_dien_ra', $year)
    //         ->whereMonth('ngay_dien_ra', $month)
    //         ->where('ban_nganh_id', $config['hoi_thanh_id'])
    //         ->orderBy('ngay_dien_ra')
    //         ->get();

    //     $buoiNhomBN = BuoiNhom::with('dienGia')
    //         ->whereYear('ngay_dien_ra', $year)
    //         ->whereMonth('ngay_dien_ra', $month)
    //         ->where('ban_nganh_id', $config['id'])
    //         ->orderBy('ngay_dien_ra')
    //         ->get();

    //     $giaoDich = GiaoDichTaiChinh::whereYear('ngay_giao_dich', $year)
    //         ->whereMonth('ngay_giao_dich', $month)
    //         ->where('ban_nganh_id', $config['id'])
    //         ->orderBy('ngay_giao_dich')
    //         ->get();

    //     $tongThu = $giaoDich->where('loai', 'thu')->sum('so_tien');
    //     $tongChi = $giaoDich->where('loai', 'chi')->sum('so_tien');
    //     $tongTon = $tongThu - $tongChi;

    //     $taiChinh = [
    //         'tongThu' => $tongThu,
    //         'tongChi' => $tongChi,
    //         'tongTon' => $tongTon,
    //         'giaoDich' => $giaoDich,
    //     ];

    //     $thamVieng = ThamVieng::with(['tinHuu', 'nguoiTham'])
    //         ->whereYear('ngay_tham', $year)
    //         ->whereMonth('ngay_tham', $month)
    //         ->where('id_ban', $config['id'])
    //         ->orderBy('ngay_tham')
    //         ->get();

    //     $nextMonth = $month == 12 ? 1 : $month + 1;
    //     $nextYear = $month == 12 ? $year + 1 : $year;

    //     $keHoach = KeHoach::with('nguoiPhuTrach')
    //         ->where('ban_nganh_id', $config['id'])
    //         ->where('thang', $nextMonth)
    //         ->where('nam', $nextYear)
    //         ->get();

    //     $diemManh = DanhGia::where('ban_nganh_id', $config['id'])
    //         ->where('loai', 'diem_manh')
    //         ->where('thang', $month)
    //         ->where('nam', $year)
    //         ->get();

    //     $diemYeu = DanhGia::where('ban_nganh_id', $config['id'])
    //         ->where('loai', 'diem_yeu')
    //         ->where('thang', $month)
    //         ->where('nam', $year)
    //         ->get();

    //     $kienNghi = KienNghi::where('ban_nganh_id', $config['id'])
    //         ->where('thang', $month)
    //         ->where('nam', $year)
    //         ->get();

    //     $totalMeetings = $buoiNhomBN->count();
    //     $avgAttendance = $totalMeetings > 0 ? round($buoiNhomBN->sum('so_luong_tin_huu') / $totalMeetings) : 0;
    //     $totalOffering = $tongThu;
    //     $totalVisits = $thamVieng->count();

    //     $summary = [
    //         'totalMeetings' => $totalMeetings,
    //         'avgAttendance' => $avgAttendance,
    //         'totalOffering' => $totalOffering,
    //         'totalVisits' => $totalVisits,
    //     ];

    //     return view("{$config['view_prefix']}.bao_cao", compact(
    //         'month',
    //         'year',
    //         'banDieuHanh',
    //         'buoiNhomHT',
    //         'buoiNhomBN',
    //         'taiChinh',
    //         'thamVieng',
    //         'keHoach',
    //         'summary',
    //         'diemManh',
    //         'diemYeu',
    //         'kienNghi'
    //     ));
    // }

    /**
     * Cập nhật số lượng tham dự và dâng hiến cho một buổi nhóm
     */
    public function updateThamDu(Request $request, array $config): JsonResponse
    {
        Log::info("updateThamDu {$config['name']}: Nhận yêu cầu", $request->all());

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:buoi_nhom,id',
            $config['quantity_field'] => 'required|integer|min:0',
            'dang_hien' => 'nullable|string'
        ], [
            'id.required' => 'ID buổi nhóm là bắt buộc.',
            'id.exists' => 'Buổi nhóm không tồn tại.',
            "{$config['quantity_field']}.required" => "Số lượng {$config['name']} là bắt buộc.",
            "{$config['quantity_field']}.integer" => "Số lượng {$config['name']} phải là số nguyên.",
            "{$config['quantity_field']}.min" => "Số lượng {$config['name']} không được nhỏ hơn 0.",
        ]);

        if ($validator->fails()) {
            Log::error("updateThamDu {$config['name']}: Validation thất bại", ['errors' => $validator->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first()
            ], 422);
        }

        try {
            $buoiNhom = BuoiNhom::findOrFail($request->id);
            $buoiNhom->{$config['quantity_field']} = $request->{$config['quantity_field']};
            $buoiNhom->save();

            if ($request->has('dang_hien') && $request->dang_hien !== null) {
                $dangHien = preg_replace('/[^0-9]/', '', $request->dang_hien);
                $dangHien = (int) $dangHien;

                if ($dangHien > 0) {
                    $giaoDich = GiaoDichTaiChinh::firstOrNew([
                        'buoi_nhom_id' => $buoiNhom->id,
                        'ban_nganh_id' => $config['id'],
                    ]);

                    $giaoDich->loai = 'thu';
                    $giaoDich->so_tien = $dangHien;
                    $giaoDich->mo_ta = "Dâng hiến buổi nhóm {$config['name']} ngày " .
                        Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y');
                    $giaoDich->ngay_giao_dich = $buoiNhom->ngay_dien_ra;
                    $giaoDich->save();
                }
            }

            Log::info("updateThamDu {$config['name']}: Cập nhật thành công", ['buoi_nhom_id' => $buoiNhom->id]);
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật số lượng tham dự thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error("updateThamDu {$config['name']}: Lỗi cập nhật số lượng tham dự", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => "Có lỗi xảy ra: {$e->getMessage()}"
            ], 500);
        }
    }

    /**
     * Lưu tất cả số lượng tham dự và dâng hiến
     */
    public function saveThamDu(Request $request, array $config)
    {
        Log::info("saveThamDu {$config['name']}: Nhận yêu cầu", $request->all());

        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'buoi_nhom' => 'required|array',
            "buoi_nhom.*.{$config['quantity_field']}" => 'required|integer|min:0',
            'buoi_nhom.*.dang_hien' => 'nullable|string'
        ], [
            'month.required' => 'Tháng là bắt buộc.',
            'month.integer' => 'Tháng phải là số nguyên.',
            'month.min' => 'Tháng phải từ 1 trở lên.',
            'month.max' => 'Tháng không được lớn hơn 12.',
            "buoi_nhom.*.{$config['quantity_field']}.required" => "Số lượng {$config['name']} là bắt buộc.",
            "buoi_nhom.*.{$config['quantity_field']}.integer" => "Số lượng {$config['name']} phải là số nguyên.",
            "buoi_nhom.*.{$config['quantity_field']}.min" => "Số lượng {$config['name']} không được nhỏ hơn 0."
        ]);

        if ($validator->fails()) {
            Log::error("saveThamDu {$config['name']}: Validation thất bại", ['errors' => $validator->errors()]);
            return redirect()->back()->with('error', 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first());
        }

        if ($request->ban_nganh_id != $config['id']) {
            return redirect()->back()->with('error', 'Ban ngành không hợp lệ!');
        }

        DB::beginTransaction();

        try {
            foreach ($request->buoi_nhom as $id => $data) {
                $buoiNhom = BuoiNhom::findOrFail($id);
                $buoiNhom->{$config['quantity_field']} = $data[$config['quantity_field']] ?? 0;
                $buoiNhom->save();

                if ($buoiNhom->ban_nganh_id == $config['id'] && isset($data['dang_hien']) && $data['dang_hien'] !== null) {
                    $dangHien = preg_replace('/[^0-9]/', '', $data['dang_hien']);
                    $dangHien = (int) $dangHien;

                    if ($dangHien > 0) {
                        $giaoDich = GiaoDichTaiChinh::firstOrNew([
                            'buoi_nhom_id' => $buoiNhom->id,
                            'ban_nganh_id' => $config['id'],
                        ]);

                        $giaoDich->loai = 'thu';
                        $giaoDich->so_tien = $dangHien;
                        $giaoDich->mo_ta = "Dâng hiến buổi nhóm {$config['name']} ngày " .
                            Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y');
                        $giaoDich->ngay_giao_dich = $buoiNhom->ngay_dien_ra;
                        $giaoDich->save();
                    }
                }
            }

            DB::commit();
            Log::info("saveThamDu {$config['name']}: Lưu thành công");
            return redirect()->back()->with('success', 'Đã lưu số lượng tham dự thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("saveThamDu {$config['name']}: Lỗi lưu số lượng tham dự", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', "Lỗi: {$e->getMessage()}");
        }
    }

    /**
     * Lưu đánh giá báo cáo
     */
    public function saveDanhGia(Request $request, array $config): JsonResponse
    {
        Log::info("saveDanhGia {$config['name']}: Nhận yêu cầu", $request->all());

        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'loai' => 'required|in:diem_manh,diem_yeu',
            'noi_dung' => 'required|string'
        ]);

        if ($validator->fails()) {
            Log::error("saveDanhGia {$config['name']}: Validation thất bại", ['errors' => $validator->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first()
            ], 422);
        }

        if ($request->ban_nganh_id != $config['id']) {
            return response()->json([
                'success' => false,
                'message' => 'Ban ngành không hợp lệ!'
            ], 422);
        }

        if (!Auth::check()) {
            Log::error("saveDanhGia {$config['name']}: Người dùng chưa đăng nhập");
            return response()->json([
                'success' => false,
                'message' => 'Người dùng chưa đăng nhập.'
            ], 401);
        }

        $user = Auth::user();
        if (!$user->tin_huu_id) {
            Log::error("saveDanhGia {$config['name']}: Người dùng không có tin_huu_id", ['user_id' => $user->id]);
            return response()->json([
                'success' => false,
                'message' => 'Không thể xác định người đánh giá. Vui lòng kiểm tra thông tin người dùng (tin_huu_id không tồn tại).'
            ], 422);
        }

        DB::beginTransaction();

        try {
            $danhGia = DanhGia::create([
                'ban_nganh_id' => $config['id'],
                'loai' => $request->loai,
                'noi_dung' => $request->noi_dung,
                'thang' => $request->month,
                'nam' => $request->year,
                'nguoi_danh_gia_id' => $user->tin_huu_id
            ]);

            DB::commit();
            Log::info("saveDanhGia {$config['name']}: Lưu thành công", ['danh_gia_id' => $danhGia->id]);
            return response()->json([
                'success' => true,
                'message' => 'Đã lưu đánh giá thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("saveDanhGia {$config['name']}: Lỗi lưu đánh giá", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => "Lỗi: {$e->getMessage()}"
            ], 500);
        }
    }

    /**
     * Lưu kế hoạch báo cáo
     */
    public function saveKeHoach(Request $request, array $config): JsonResponse
    {
        Log::info("saveKeHoach {$config['name']}: Nhận yêu cầu", $request->all());

        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'kehoach' => 'required|array',
            'kehoach.*.hoat_dong' => 'required|string',
            'kehoach.*.thoi_gian' => 'nullable|string',
            'kehoach.*.nguoi_phu_trach_id' => 'nullable|exists:tin_huu,id',
            'kehoach.*.ghi_chu' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            Log::error("saveKeHoach {$config['name']}: Validation thất bại", ['errors' => $validator->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->ban_nganh_id != $config['id']) {
            return response()->json([
                'success' => false,
                'message' => 'Ban ngành không hợp lệ!'
            ], 422);
        }

        DB::beginTransaction();

        try {
            $nextMonth = $request->month == 12 ? 1 : $request->month + 1;
            $nextYear = $request->month == 12 ? $request->year + 1 : $request->year;

            foreach ($request->kehoach as $data) {
                $id = $data['id'] ?? 0;

                if (empty($data['hoat_dong'])) {
                    continue;
                }

                if ($id > 0) {
                    $keHoach = KeHoach::findOrFail($id);
                    $keHoach->update([
                        'hoat_dong' => $data['hoat_dong'],
                        'thoi_gian' => $data['thoi_gian'] ?? '',
                        'nguoi_phu_trach_id' => $data['nguoi_phu_trach_id'] ?? null,
                        'ghi_chu' => $data['ghi_chu'] ?? ''
                    ]);
                } else {
                    $keHoach = KeHoach::create([
                        'ban_nganh_id' => $config['id'],
                        'hoat_dong' => $data['hoat_dong'],
                        'thoi_gian' => $data['thoi_gian'] ?? '',
                        'nguoi_phu_trach_id' => $data['nguoi_phu_trach_id'] ?? null,
                        'ghi_chu' => $data['ghi_chu'] ?? '',
                        'thang' => $nextMonth,
                        'nam' => $nextYear,
                        'trang_thai' => 'chua_thuc_hien'
                    ]);
                }
            }

            DB::commit();
            Log::info("saveKeHoach {$config['name']}: Lưu thành công");
            return response()->json([
                'success' => true,
                'message' => 'Đã lưu kế hoạch thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("saveKeHoach {$config['name']}: Lỗi lưu kế hoạch", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => "Lỗi: {$e->getMessage()}"
            ], 500);
        }
    }

    /**
     * Lưu kiến nghị báo cáo
     */
    public function saveKienNghi(Request $request, array $config): JsonResponse
    {
        Log::info("saveKienNghi {$config['name']}: Nhận yêu cầu", $request->all());

        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'kiennghi' => 'required|array',
            'kiennghi.*.tieu_de' => 'required|string',
            'kiennghi.*.noi_dung' => 'required|string',
            'kiennghi.*.nguoi_de_xuat_id' => 'nullable|exists:tin_huu,id',
            'kiennghi.*.phan_hoi' => 'nullable|string',
            'kiennghi.*.trang_thai' => 'nullable|in:moi,da_xem,da_xu_ly'
        ]);

        if ($validator->fails()) {
            Log::error("saveKienNghi {$config['name']}: Validation thất bại", ['errors' => $validator->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->ban_nganh_id != $config['id']) {
            return response()->json([
                'success' => false,
                'message' => 'Ban ngành không hợp lệ!'
            ], 422);
        }

        DB::beginTransaction();

        try {
            $user = Auth::user();
            if (!$user || !$user->tin_huu_id) {
                Log::error("saveKienNghi {$config['name']}: Người dùng không có tin_huu_id", ['user_id' => $user ? $user->id : null]);
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xác định người đề xuất. Vui lòng kiểm tra thông tin người dùng (tin_huu_id không tồn tại).'
                ], 422);
            }

            foreach ($request->kiennghi as $data) {
                $id = $data['id'] ?? 0;

                if (empty($data['tieu_de']) || empty($data['noi_dung'])) {
                    continue;
                }

                if ($id > 0) {
                    $kienNghi = KienNghi::findOrFail($id);
                    $kienNghi->update([
                        'tieu_de' => $data['tieu_de'],
                        'noi_dung' => $data['noi_dung'],
                        'nguoi_de_xuat_id' => $data['nguoi_de_xuat_id'] ?? $user->tin_huu_id,
                        'trang_thai' => $data['trang_thai'] ?? 'moi',
                        'phan_hoi' => $data['phan_hoi'] ?? null
                    ]);
                } else {
                    $kienNghi = KienNghi::create([
                        'ban_nganh_id' => $config['id'],
                        'tieu_de' => $data['tieu_de'],
                        'noi_dung' => $data['noi_dung'],
                        'nguoi_de_xuat_id' => $data['nguoi_de_xuat_id'] ?? $user->tin_huu_id,
                        'thang' => $request->month,
                        'nam' => $request->year,
                        'trang_thai' => $data['trang_thai'] ?? 'moi',
                        'phan_hoi' => $data['phan_hoi'] ?? null
                    ]);
                }
            }

            DB::commit();
            Log::info("saveKienNghi {$config['name']}: Lưu thành công");
            return response()->json([
                'success' => true,
                'message' => 'Đã lưu kiến nghị thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("saveKienNghi {$config['name']}: Lỗi lưu kiến nghị", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => "Lỗi: {$e->getMessage()}"
            ], 500);
        }
    }

    /**
     * Lưu toàn bộ báo cáo ban
     */
    public function luuBaoCao(Request $request, array $config): JsonResponse
    {
        Log::info("luuBaoCao {$config['name']}: Nhận yêu cầu", $request->all());

        DB::beginTransaction();

        try {
            if ($request->has('buoi_nhom')) {
                $requestForThamDu = new Request($request->only(['month', 'year', 'ban_nganh_id', 'buoi_nhom']));
                $this->saveThamDu($requestForThamDu, $config);
            }

            if ($request->has('diem_manh') || $request->has('diem_yeu')) {
                $requestForDanhGia = new Request($request->only(['month', 'year', 'ban_nganh_id', 'loai', 'noi_dung']));
                $this->saveDanhGia($requestForDanhGia, $config);
            }

            if ($request->has('kehoach')) {
                $requestForKeHoach = new Request($request->only(['month', 'year', 'ban_nganh_id', 'kehoach']));
                $this->saveKeHoach($requestForKeHoach, $config);
            }

            if ($request->has('kiennghi')) {
                $requestForKienNghi = new Request($request->only(['month', 'year', 'ban_nganh_id', 'kiennghi']));
                $this->saveKienNghi($requestForKienNghi, $config);
            }

            DB::commit();
            Log::info("luuBaoCao {$config['name']}: Lưu thành công");
            return response()->json([
                'success' => true,
                'message' => 'Đã lưu báo cáo thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("luuBaoCao {$config['name']}: Lỗi lưu báo cáo tổng hợp", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => "Có lỗi xảy ra khi lưu báo cáo: {$e->getMessage()}"
            ], 500);
        }
    }

    /**
     * Cập nhật số lượng tham dự (alias cho updateThamDu)
     */
    public function capNhatSoLuongThamDu(Request $request, array $config): JsonResponse
    {
        return $this->updateThamDu($request, $config);
    }

    /**
     * Xóa đánh giá (điểm mạnh hoặc điểm yếu)
     */
    public function xoaDanhGia($id, array $config): JsonResponse
    {
        Log::info("xoaDanhGia {$config['name']}: Nhận yêu cầu", ['id' => $id]);

        try {
            $danhGia = DanhGia::where('id', $id)
                ->where('ban_nganh_id', $config['id'])
                ->firstOrFail();
            $danhGia->delete();
            Log::info("xoaDanhGia {$config['name']}: Xóa thành công", ['id' => $id]);
            return response()->json([
                'success' => true,
                'message' => 'Xóa đánh giá thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error("xoaDanhGia {$config['name']}: Lỗi xóa đánh giá", [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => "Đã xảy ra lỗi khi xóa đánh giá: {$e->getMessage()}"
            ], 500);
        }
    }

    /**
     * Xóa kiến nghị
     */
    public function xoaKienNghi($id, array $config): JsonResponse
    {
        Log::info("xoaKienNghi {$config['name']}: Nhận yêu cầu", ['id' => $id]);

        try {
            $kienNghi = KienNghi::where('id', $id)
                ->where('ban_nganh_id', $config['id'])
                ->firstOrFail();

            $user = Auth::user();
            if (!$user || !$user->tin_huu_id) {
                Log::error("xoaKienNghi {$config['name']}: Người dùng không có tin_huu_id", ['user_id' => $user ? $user->id : null]);
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xác định người dùng. Vui lòng kiểm tra thông tin (tin_huu_id không tồn tại).'
                ], 422);
            }

            if ($kienNghi->nguoi_de_xuat_id !== $user->tin_huu_id) {
                Log::warning("xoaKienNghi {$config['name']}: Người dùng không có quyền xóa", [
                    'user_tin_huu_id' => $user->tin_huu_id,
                    'nguoi_de_xuat_id' => $kienNghi->nguoi_de_xuat_id
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền xóa kiến nghị này!'
                ], 403);
            }

            $kienNghi->delete();
            Log::info("xoaKienNghi {$config['name']}: Xóa thành công", ['id' => $id]);
            return response()->json([
                'success' => true,
                'message' => 'Xóa kiến nghị thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error("xoaKienNghi {$config['name']}: Lỗi xóa kiến nghị", [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => "Đã xảy ra lỗi khi xóa kiến nghị: {$e->getMessage()}"
            ], 500);
        }
    }
}
