<?php

namespace App\Http\Controllers\BanMucVu;

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
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BanMucVuBaoCaoController extends Controller
{
    private const HOI_THANH_ID = 20;

    /**
     * Hiển thị form nhập liệu báo cáo Ban Mục Vụ
     */
    public function formBaoCaoBanMucVu(Request $request): View
    {
        $ban_nganh_id = $request->query('ban_nganh_id', 1);
        $banNganh = BanNganh::findOrFail($ban_nganh_id);
        $banNganhs = BanNganh::orderBy('ten')->get();

        $month = (int) $request->get('month', date('m'));
        $year = (int) $request->get('year', date('Y'));
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
            ->where('ban_nganh_id', $banNganh->id)
            ->orderBy('ngay_dien_ra')
            ->get();

        $tinHuuBanNganh = TinHuu::select('tin_huu.id', 'tin_huu.ho_ten')
            ->join('tin_huu_ban_nganh', 'tin_huu.id', '=', 'tin_huu_ban_nganh.tin_huu_id')
            ->where('tin_huu_ban_nganh.ban_nganh_id', $banNganh->id)
            ->orderBy('tin_huu.ho_ten')
            ->get();

        $diemManh = DanhGia::with('nguoiDanhGia')
            ->where('ban_nganh_id', $banNganh->id)
            ->where('loai', 'diem_manh')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $diemYeu = DanhGia::with('nguoiDanhGia')
            ->where('ban_nganh_id', $banNganh->id)
            ->where('loai', 'diem_yeu')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $keHoach = KeHoach::with('nguoiPhuTrach')
            ->where('ban_nganh_id', $banNganh->id)
            ->where('thang', $nextMonth)
            ->where('nam', $nextYear)
            ->get();

        $kienNghi = KienNghi::with('nguoiDeXuat')
            ->where('ban_nganh_id', $banNganh->id)
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        return view('_ban_muc_vu.nhap_lieu_bao_cao', compact(
            'banNganh',
            'banNganhs',
            'month',
            'year',
            'nextMonth',
            'nextYear',
            'buoiNhomHT',
            'buoiNhomBTL',
            'tinHuuBanNganh',
            'diemManh',
            'diemYeu',
            'keHoach',
            'kienNghi',
            'buoiNhomType'
        ));
    }

    /**
     * Hiển thị báo cáo Ban Mục Vụ
     */
    public function baoCaoBanMucVu(Request $request): View
    {
        $ban_nganh_id = $request->query('ban_nganh_id', 1);
        $banNganh = BanNganh::findOrFail($ban_nganh_id);
        $banNganhs = BanNganh::orderBy('ten')->get();

        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $banDieuHanh = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banNganh->id)
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
            ->where('ban_nganh_id', $banNganh->id)
            ->orderBy('ngay_dien_ra')
            ->get();

        $giaoDich = GiaoDichTaiChinh::whereYear('ngay_giao_dich', $year)
            ->whereMonth('ngay_giao_dich', $month)
            ->where('ban_nganh_id', $banNganh->id)
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
            ->where('id_ban', $banNganh->id)
            ->orderBy('ngay_tham')
            ->get();

        $nextMonth = $month == 12 ? 1 : $month + 1;
        $nextYear = $month == 12 ? $year + 1 : $year;

        $keHoach = KeHoach::with('nguoiPhuTrach')
            ->where('ban_nganh_id', $banNganh->id)
            ->where('thang', $nextMonth)
            ->where('nam', $nextYear)
            ->get();

        $diemManh = DanhGia::where('ban_nganh_id', $banNganh->id)
            ->where('loai', 'diem_manh')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $diemYeu = DanhGia::where('ban_nganh_id', $banNganh->id)
            ->where('loai', 'diem_yeu')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $kienNghi = KienNghi::where('ban_nganh_id', $banNganh->id)
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

        return view('_ban_muc_vu.nhap_lieu_bao_cao', compact(
            'banNganh',
            'banNganhs',
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
    public function updateThamDuBanMucVu(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:buoi_nhom,id',
            'so_luong_trung_lao' => 'required|integer|min:0',
            'dang_hien' => 'nullable|string'
        ], [
            'id.required' => 'ID buổi nhóm là bắt buộc.',
            'id.exists' => 'Buổi nhóm không tồn tại.',
            'so_luong_trung_lao.required' => 'Số lượng là bắt buộc.',
            'so_luong_trung_lao.integer' => 'Số lượng phải là số nguyên.',
            'so_luong_trung_lao.min' => 'Số lượng không được nhỏ hơn 0.',
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
                $dangHien = preg_replace('/[^0-9]/', '', $request->dang_hien);
                $dangHien = (int) $dangHien;

                if ($dangHien > 0) {
                    $giaoDich = GiaoDichTaiChinh::firstOrNew([
                        'buoi_nhom_id' => $buoiNhom->id,
                        'ban_nganh_id' => $buoiNhom->ban_nganh_id,
                    ]);

                    $giaoDich->loai = 'thu';
                    $giaoDich->so_tien = $dangHien;
                    $giaoDich->mo_ta = 'Dâng hiến buổi nhóm ban ngành ngày ' .
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
    public function saveThamDuBanMucVu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'buoi_nhom' => 'required|array',
            'buoi_nhom.*.so_luong_trung_lao' => 'required|integer|min:0',
            'buoi_nhom.*.dang_hien' => 'nullable|string'
        ], [
            'month.required' => 'Tháng là bắt buộc.',
            'month.integer' => 'Tháng phải là số nguyên.',
            'month.min' => 'Tháng phải từ 1 trở lên.',
            'month.max' => 'Tháng không được lớn hơn 12.',
            'buoi_nhom.*.so_luong_trung_lao.required' => 'Số lượng là bắt buộc.',
            'buoi_nhom.*.so_luong_trung_lao.integer' => 'Số lượng phải là số nguyên.',
            'buoi_nhom.*.so_luong_trung_lao.min' => 'Số lượng không được nhỏ hơn 0.'
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

                if ($buoiNhom->ban_nganh_id == $request->ban_nganh_id && isset($data['dang_hien']) && $data['dang_hien'] !== null) {
                    $dangHien = preg_replace('/[^0-9]/', '', $data['dang_hien']);
                    $dangHien = (int) $dangHien;

                    if ($dangHien > 0) {
                        $giaoDich = GiaoDichTaiChinh::firstOrNew([
                            'buoi_nhom_id' => $buoiNhom->id,
                            'ban_nganh_id' => $request->ban_nganh_id,
                        ]);

                        $giaoDich->loai = 'thu';
                        $giaoDich->so_tien = $dangHien;
                        $giaoDich->mo_ta = 'Dâng hiến buổi nhóm ban ngành ngày ' .
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
    public function saveDanhGiaBanMucVu(Request $request): JsonResponse
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
                'ban_nganh_id' => $request->ban_nganh_id,
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
    public function saveKeHoachBanMucVu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'kehoach' => 'required|array',
            'kehoach.*.hoat_dong' => 'required|string',
            'kehoach.*.thoi_gian' => 'nullable|string',
            'kehoach.*.nguoi_phu_trach_id' => 'nullable|exists:tin_huu,id',
            'kehoach.*.ghi_chu' => 'nullable|string',
            'kehoach.*.id' => 'nullable|exists:ke_hoach,id',
        ], [
            'month.required' => 'Tháng là bắt buộc.',
            'month.integer' => 'Tháng phải là số nguyên.',
            'month.min' => 'Tháng phải từ 1 trở lên.',
            'month.max' => 'Tháng không được lớn hơn 12.',
            'kehoach.*.hoat_dong.required' => 'Hoạt động là bắt buộc.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            KeHoach::where('ban_nganh_id', $request->ban_nganh_id)
                ->where('thang', $request->month)
                ->where('nam', $request->year)
                ->delete();

            foreach ($request->kehoach as $item) {
                if (!empty($item['hoat_dong'])) {
                    KeHoach::create([
                        'ban_nganh_id' => $request->ban_nganh_id,
                        'hoat_dong' => $item['hoat_dong'],
                        'thoi_gian' => $item['thoi_gian'] ?? null,
                        'nguoi_phu_trach_id' => $item['nguoi_phu_trach_id'] ?? null,
                        'ghi_chu' => $item['ghi_chu'] ?? null,
                        'thang' => $request->month,
                        'nam' => $request->year,
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
    public function saveKienNghiBanMucVu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'kiennghi' => 'required|array',
            'kiennghi.*.tieu_de' => 'required|string',
            'kiennghi.*.noi_dung' => 'required|string',
            'kiennghi.*.nguoi_de_xuat_id' => 'nullable|exists:tin_huu,id',
            'kiennghi.*.id' => 'nullable|exists:kien_nghi,id',
        ], [
            'month.required' => 'Tháng là bắt buộc.',
            'month.integer' => 'Tháng phải là số nguyên.',
            'month.min' => 'Tháng phải từ 1 trở lên.',
            'month.max' => 'Tháng không được lớn hơn 12.',
            'kiennghi.*.tieu_de.required' => 'Tiêu đề kiến nghị là bắt buộc.',
            'kiennghi.*.noi_dung.required' => 'Nội dung kiến nghị là bắt buộc.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            foreach ($request->kiennghi as $item) {
                if (!empty($item['tieu_de']) && !empty($item['noi_dung'])) {
                    if (isset($item['id']) && $item['id'] != 0) {
                        $kienNghi = KienNghi::find($item['id']);
                        if ($kienNghi) {
                            $kienNghi->update([
                                'tieu_de' => $item['tieu_de'],
                                'noi_dung' => $item['noi_dung'],
                                'nguoi_de_xuat_id' => $item['nguoi_de_xuat_id'] ?? null,
                            ]);
                        }
                    } else {
                        KienNghi::create([
                            'ban_nganh_id' => $request->ban_nganh_id,
                            'tieu_de' => $item['tieu_de'],
                            'noi_dung' => $item['noi_dung'],
                            'nguoi_de_xuat_id' => $item['nguoi_de_xuat_id'] ?? null,
                            'thang' => $request->month,
                            'nam' => $request->year,
                        ]);
                    }
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
     * Xóa đánh giá
     */
    public function xoaDanhGia($id): JsonResponse
    {
        $danhGia = DanhGia::find($id);

        if (!$danhGia) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy đánh giá.'
            ], 404);
        }

        try {
            $danhGia->delete();
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa đánh giá thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa đánh giá: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa kiến nghị
     */
    public function xoaKienNghi($id): JsonResponse
    {
        $kienNghi = KienNghi::find($id);

        if (!$kienNghi) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy kiến nghị.'
            ], 404);
        }

        try {
            $kienNghi->delete();
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa kiến nghị thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa kiến nghị: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
}