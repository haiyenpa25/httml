<?php

namespace App\Http\Controllers\BanTrungLao;

use App\Http\Controllers\Controller;
use App\Models\BanNganh;
use App\Models\BuoiNhom;
use App\Models\DanhGia;
use App\Models\GiaoDichTaiChinh;
use App\Models\KeHoach;
use App\Models\KienNghi;
use App\Models\ThamVieng;
use App\Models\TinHuu;
use App\Models\TinHuuBanNganh;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BanTrungLaoBaoCaoController extends Controller
{
    private const BAN_TRUNG_LAO_ID = 1;
    private const HOI_THANH_ID = 20;

    /**
     * Hiển thị form nhập liệu báo cáo Ban Trung Lão
     */
    /**
     * Hiển thị form nhập liệu báo cáo Ban Trung Lão
     */
    public function formBaoCaoBanTrungLao(Request $request): View
    {
        $month = (int) $request->get('month', date('m')); // Ép kiểu thành số nguyên
        $year = (int) $request->get('year', date('Y'));   // Ép kiểu thành số nguyên
        $buoiNhomType = $request->get('buoi_nhom_type', 1);

        $nextMonth = $month == 12 ? 1 : $month + 1;
        $nextYear = $month == 12 ? $year + 1 : $year;

        $buoiNhomHT = BuoiNhom::with('dienGia')
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', self::HOI_THANH_ID)
            ->orderBy('ngay_dien_ra')
            ->get();

        $buoiNhomBTL = BuoiNhom::with(['dienGia', 'giaoDichTaiChinh'])
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', self::BAN_TRUNG_LAO_ID)
            ->orderBy('ngay_dien_ra')
            ->get();

        $tinHuuTrungLao = TinHuu::select('tin_huu.id', 'tin_huu.ho_ten')
            ->join('tin_huu_ban_nganh', 'tin_huu.id', '=', 'tin_huu_ban_nganh.tin_huu_id')
            ->where('tin_huu_ban_nganh.ban_nganh_id', self::BAN_TRUNG_LAO_ID)
            ->orderBy('tin_huu.ho_ten')
            ->get();

        $diemManh = DanhGia::with('nguoiDanhGia')
            ->where('ban_nganh_id', self::BAN_TRUNG_LAO_ID)
            ->where('loai', 'diem_manh')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $diemYeu = DanhGia::with('nguoiDanhGia')
            ->where('ban_nganh_id', self::BAN_TRUNG_LAO_ID)
            ->where('loai', 'diem_yeu')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $keHoach = KeHoach::with('nguoiPhuTrach')
            ->where('ban_nganh_id', self::BAN_TRUNG_LAO_ID)
            ->where('thang', $nextMonth)
            ->where('nam', $nextYear)
            ->get();

        $kienNghi = KienNghi::with('nguoiDeXuat')
            ->where('ban_nganh_id', self::BAN_TRUNG_LAO_ID)
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        return view('_ban_trung_lao.nhap_lieu_bao_cao', compact(
            'month',
            'year',
            'nextMonth',
            'nextYear',
            'buoiNhomHT',
            'buoiNhomBTL',
            'tinHuuTrungLao',
            'diemManh',
            'diemYeu',
            'keHoach',
            'kienNghi',
            'buoiNhomType'
        ));
    }

    /**
     * Hiển thị báo cáo Ban Trung Lão
     */
    public function baoCaoBanTrungLao(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $banDieuHanh = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', self::BAN_TRUNG_LAO_ID)
            ->whereNotNull('chuc_vu')
            ->get();

        $buoiNhomHT = BuoiNhom::with('dienGia')
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', self::HOI_THANH_ID)
            ->orderBy('ngay_dien_ra')
            ->get();

        $buoiNhomBN = BuoiNhom::with('dienGia')
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', self::BAN_TRUNG_LAO_ID)
            ->orderBy('ngay_dien_ra')
            ->get();

        $giaoDich = GiaoDichTaiChinh::whereYear('ngay_giao_dich', $year)
            ->whereMonth('ngay_giao_dich', $month)
            ->where('ban_nganh_id', self::BAN_TRUNG_LAO_ID)
            ->orderBy('ngay_giao_dich')
            ->get();

        $tongThu = $giaoDich->where('loai', 'thu')->sum('so_tien');
        $tongChi = $giaoDich->where('loai', 'chi')->sum('so_tien');
        $tongTon = $tongThu - $tongChi;

        $taiChinh = [
            'tongThu' => $tongThu,
            'tongChi' => $tongChi,
            'tongTon' => $tongTon,
            'giaoDich' => $giaoDich,
        ];

        $thamVieng = ThamVieng::with(['tinHuu', 'nguoiTham'])
            ->whereYear('ngay_tham', $year)
            ->whereMonth('ngay_tham', $month)
            ->where('id_ban', self::BAN_TRUNG_LAO_ID)
            ->orderBy('ngay_tham')
            ->get();

        $nextMonth = $month == 12 ? 1 : $month + 1;
        $nextYear = $month == 12 ? $year + 1 : $year;

        $keHoach = KeHoach::with('nguoiPhuTrach')
            ->where('ban_nganh_id', self::BAN_TRUNG_LAO_ID)
            ->where('thang', $nextMonth)
            ->where('nam', $nextYear)
            ->get();

        $diemManh = DanhGia::where('ban_nganh_id', self::BAN_TRUNG_LAO_ID)
            ->where('loai', 'diem_manh')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $diemYeu = DanhGia::where('ban_nganh_id', self::BAN_TRUNG_LAO_ID)
            ->where('loai', 'diem_yeu')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $kienNghi = KienNghi::where('ban_nganh_id', self::BAN_TRUNG_LAO_ID)
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $totalMeetings = $buoiNhomBN->count();
        $avgAttendance = $totalMeetings > 0 ? round($buoiNhomBN->sum('so_luong_tin_huu') / $totalMeetings) : 0;
        $totalOffering = $tongThu;
        $totalVisits = $thamVieng->count();

        $summary = [
            'totalMeetings' => $totalMeetings,
            'avgAttendance' => $avgAttendance,
            'totalOffering' => $totalOffering,
            'totalVisits' => $totalVisits,
        ];

        return view('_ban_trung_lao.nhap_lieu_bao_cao', compact(
            'month',
            'year',
            'banDieuHanh',
            'buoiNhomHT',
            'buoiNhomBN',
            'taiChinh',
            'thamVieng',
            'keHoach',
            'summary',
            'diemManh',
            'diemYeu',
            'kienNghi'
        ));
    }

    /**
     * Cập nhật số lượng tham dự và dâng hiến cho một buổi nhóm
     */
    public function updateThamDuTrungLao(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:buoi_nhom,id',
            'so_luong_trung_lao' => 'required|integer|min:0',
            'dang_hien' => 'nullable|string' // Nới lỏng validation, sẽ xử lý sau
        ], [
            'id.required' => 'ID buổi nhóm là bắt buộc.',
            'id.exists' => 'Buổi nhóm không tồn tại.',
            'so_luong_trung_lao.required' => 'Số lượng Trung Lão là bắt buộc.',
            'so_luong_trung_lao.integer' => 'Số lượng Trung Lão phải là số nguyên.',
            'so_luong_trung_lao.min' => 'Số lượng Trung Lão không được nhỏ hơn 0.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first()
            ], 422);
        }

        try {
            $buoiNhom = BuoiNhom::findOrFail($request->id);
            $buoiNhom->so_luong_trung_lao = $request->so_luong_trung_lao;
            $buoiNhom->save();

            if ($request->has('dang_hien') && $request->dang_hien !== null) {
                // Chuẩn hóa giá trị dang_hien
                $dangHien = preg_replace('/[^0-9]/', '', $request->dang_hien);
                $dangHien = (int) $dangHien;

                if ($dangHien > 0) {
                    $giaoDich = GiaoDichTaiChinh::firstOrNew([
                        'buoi_nhom_id' => $buoiNhom->id,
                        'ban_nganh_id' => self::BAN_TRUNG_LAO_ID,
                    ]);

                    $giaoDich->loai = 'thu';
                    $giaoDich->so_tien = $dangHien;
                    $giaoDich->mo_ta = 'Dâng hiến buổi nhóm Ban Trung Lão ngày ' .
                        Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y');
                    $giaoDich->ngay_giao_dich = $buoiNhom->ngay_dien_ra;
                    $giaoDich->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật số lượng tham dự thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật số lượng tham dự: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lưu tất cả số lượng tham dự và dâng hiến
     */
    public function saveThamDuTrungLao(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'buoi_nhom' => 'required|array',
            'buoi_nhom.*.so_luong_trung_lao' => 'required|integer|min:0',
            'buoi_nhom.*.dang_hien' => 'nullable|string' // Nới lỏng validation, sẽ xử lý sau
        ], [
            'month.required' => 'Tháng là bắt buộc.',
            'month.integer' => 'Tháng phải là số nguyên.',
            'month.min' => 'Tháng phải từ 1 trở lên.',
            'month.max' => 'Tháng không được lớn hơn 12.',
            'buoi_nhom.*.so_luong_trung_lao.required' => 'Số lượng Trung Lão là bắt buộc.',
            'buoi_nhom.*.so_luong_trung_lao.integer' => 'Số lượng Trung Lão phải là số nguyên.',
            'buoi_nhom.*.so_luong_trung_lao.min' => 'Số lượng Trung Lão không được nhỏ hơn 0.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            foreach ($request->buoi_nhom as $id => $data) {
                $buoiNhom = BuoiNhom::findOrFail($id);
                $buoiNhom->so_luong_trung_lao = $data['so_luong_trung_lao'] ?? 0;
                $buoiNhom->save();

                if ($buoiNhom->ban_nganh_id == self::BAN_TRUNG_LAO_ID && isset($data['dang_hien']) && $data['dang_hien'] !== null) {
                    // Chuẩn hóa giá trị dang_hien
                    $dangHien = preg_replace('/[^0-9]/', '', $data['dang_hien']);
                    $dangHien = (int) $dangHien;

                    if ($dangHien > 0) {
                        $giaoDich = GiaoDichTaiChinh::firstOrNew([
                            'buoi_nhom_id' => $buoiNhom->id,
                            'ban_nganh_id' => self::BAN_TRUNG_LAO_ID,
                        ]);

                        $giaoDich->loai = 'thu';
                        $giaoDich->so_tien = $dangHien;
                        $giaoDich->mo_ta = 'Dâng hiến buổi nhóm Ban Trung Lão ngày ' .
                            Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y');
                        $giaoDich->ngay_giao_dich = $buoiNhom->ngay_dien_ra;
                        $giaoDich->save();
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Đã lưu số lượng tham dự thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi lưu số lượng tham dự: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }


    /**
     * Lưu đánh giá báo cáo
     */
    public function saveDanhGiaTrungLao(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'loai' => 'required|in:diem_manh,diem_yeu',
            'noi_dung' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first()
            ], 422);
        }

        DB::beginTransaction();

        try {
            DanhGia::create([
                'ban_nganh_id' => self::BAN_TRUNG_LAO_ID,
                'loai' => $request->loai,
                'noi_dung' => $request->noi_dung,
                'thang' => $request->month,
                'nam' => $request->year,
                'nguoi_danh_gia_id' => Auth::check() ? Auth::user()->tin_huu_id : null
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Đã lưu đánh giá thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi lưu đánh giá: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lưu kế hoạch báo cáo
     */
    public function saveKeHoachTrungLao(Request $request)
    {
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
            return redirect()->back()->withErrors($validator)->withInput();
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
                    KeHoach::create([
                        'ban_nganh_id' => self::BAN_TRUNG_LAO_ID,
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
            return redirect()->back()->with('success', 'Đã lưu kế hoạch thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi lưu kế hoạch: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Lưu kiến nghị báo cáo
     */
    public function saveKienNghiTrungLao(Request $request)
    {
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
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
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
                        'nguoi_de_xuat_id' => $data['nguoi_de_xuat_id'] ?? null,
                        'trang_thai' => $data['trang_thai'] ?? 'moi',
                        'phan_hoi' => $data['phan_hoi'] ?? null
                    ]);
                } else {
                    KienNghi::create([
                        'ban_nganh_id' => self::BAN_TRUNG_LAO_ID,
                        'tieu_de' => $data['tieu_de'],
                        'noi_dung' => $data['noi_dung'],
                        'nguoi_de_xuat_id' => $data['nguoi_de_xuat_id'] ?? null,
                        'thang' => $request->month,
                        'nam' => $request->year,
                        'trang_thai' => $data['trang_thai'] ?? 'moi',
                        'phan_hoi' => $data['phan_hoi'] ?? null
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Đã lưu kiến nghị thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi lưu kiến nghị: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    /**
     * Lưu toàn bộ báo cáo Ban Trung Lão
     */
    public function luuBaoCaoBanTrungLao(Request $request)
    {
        DB::beginTransaction();

        try {
            if ($request->has('buoi_nhom')) {
                $requestForThamDu = new Request($request->only(['month', 'year', 'ban_nganh_id', 'buoi_nhom']));
                $this->saveThamDuTrungLao($requestForThamDu);
            }

            if ($request->has('diem_manh') || $request->has('diem_yeu')) {
                $requestForDanhGia = new Request($request->only(['month', 'year', 'ban_nganh_id', 'diem_manh', 'diem_manh_id', 'diem_yeu', 'diem_yeu_id']));
                $this->saveDanhGiaTrungLao($requestForDanhGia);
            }

            if ($request->has('kehoach')) {
                $requestForKeHoach = new Request($request->only(['month', 'year', 'ban_nganh_id', 'kehoach']));
                $this->saveKeHoachTrungLao($requestForKeHoach);
            }

            if ($request->has('kiennghi')) {
                $requestForKienNghi = new Request($request->only(['month', 'year', 'ban_nganh_id', 'kiennghi']));
                $this->saveKienNghiTrungLao($requestForKienNghi);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Đã lưu báo cáo thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi lưu báo cáo tổng hợp: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lưu báo cáo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cập nhật số lượng tham dự
     */
    public function capNhatSoLuongThamDu(Request $request)
    {
        return $this->updateThamDuTrungLao($request);
    }

    /**
     * Xóa đánh giá (điểm mạnh hoặc điểm yếu)
     */
    public function xoaDanhGia($id)
    {
        try {
            $danhGia = DanhGia::where('id', $id)
                ->where('ban_nganh_id', self::BAN_TRUNG_LAO_ID)
                ->firstOrFail();
            $danhGia->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa đánh giá thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa đánh giá: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi xóa đánh giá!'
            ], 500);
        }
    }

    /**
     * Xóa kiến nghị
     */
    public function xoaKienNghi($id)
    {
        try {
            $kienNghi = KienNghi::where('id', $id)
                ->where('ban_nganh_id', self::BAN_TRUNG_LAO_ID)
                ->firstOrFail();
            $kienNghi->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa kiến nghị thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa kiến nghị: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi xóa kiến nghị!'
            ], 500);
        }
    }

    /**
     * Lấy dữ liệu tóm tắt cho báo cáo
     */
    private function getSummaryData($month, $year, $banId)
    {
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $totalMeetings = BuoiNhom::where(function ($query) use ($banId) {
            $query->where('ban_nganh_id', $banId)
                ->orWhereNull('ban_nganh_id');
        })
            ->whereMonth('ngay_dien_ra', $month)
            ->whereYear('ngay_dien_ra', $year)
            ->count();

        $avgAttendance = BuoiNhom::where(function ($query) use ($banId) {
            $query->where('ban_nganh_id', $banId)
                ->orWhereNull('ban_nganh_id');
        })
            ->whereMonth('ngay_dien_ra', $month)
            ->whereYear('ngay_dien_ra', $year)
            ->avg('so_luong_tin_huu') ?? 0;

        $totalVisits = ThamVieng::where('id_ban', $banId)
            ->whereMonth('ngay_tham', $month)
            ->whereYear('ngay_tham', $year)
            ->count();

        $totalOffering = $this->getFinancialData($month, $year, $banId)['tongTon'] ?? 0;

        return [
            'totalMeetings' => $totalMeetings,
            'avgAttendance' => round($avgAttendance),
            'totalVisits' => $totalVisits,
            'totalOffering' => $totalOffering
        ];
    }

    /**
     * Lấy dữ liệu tài chính
     */
    private function getFinancialData($month, $year, $banId)
    {
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $hasTransactions = GiaoDichTaiChinh::where('ban_nganh_id', $banId)
            ->whereMonth('ngay_giao_dich', $month)
            ->whereYear('ngay_giao_dich', $year)
            ->exists();

        if (!$hasTransactions) {
            return [
                'giaoDich' => collect([]),
                'tongThu' => 0,
                'tongChi' => 0,
                'tongTon' => 0
            ];
        }

        $giaoDich = GiaoDichTaiChinh::where('ban_nganh_id', $banId)
            ->whereMonth('ngay_giao_dich', $month)
            ->whereYear('ngay_giao_dich', $year)
            ->orderBy('ngay_giao_dich')
            ->get();

        $tongThu = $giaoDich->where('loai', 'thu')->sum('so_tien');
        $tongChi = $giaoDich->where('loai', 'chi')->sum('so_tien');
        $tongTon = $tongThu - $tongChi;

        return [
            'giaoDich' => $giaoDich,
            'tongThu' => $tongThu,
            'tongChi' => $tongChi,
            'tongTon' => $tongTon
        ];
    }
}
