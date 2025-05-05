<?php

namespace App\Http\Controllers\BanThanhTrang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\BuoiNhom;
use App\Models\TinHuuBanNganh;
use App\Models\GiaoDichTaiChinh;
use App\Models\ThamVieng;
use App\Models\KeHoach;
use App\Models\DanhGia;
use App\Models\KienNghi;
use Carbon\Carbon;

class BaoCaoBanThanhTrangController extends Controller
{
    // Hiển thị báo cáo đã hoàn thiện Ban Trung Lão
    public function baoCaoBanThanhTrang(Request $request): View
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        // ID của Ban Trung Lão
        $banThanhTrangId = 1;

        // 1. Lấy thông tin Ban điều hành
        $banDieuHanh = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banThanhTrangId)
            ->whereNotNull('chuc_vu')
            ->get();

        // 2. Lấy buổi nhóm Hội Thánh (Chúa Nhật) có thống kê số lượng Trung Lão
        $buoiNhomHT = BuoiNhom::with('dienGia')
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', 20) // Hội thánh
            ->orderBy('ngay_dien_ra')
            ->get();

        // 3. Lấy buổi nhóm Ban Trung Lão
        $buoiNhomBN = BuoiNhom::with('dienGia')
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', $banThanhTrangId)
            ->orderBy('ngay_dien_ra')
            ->get();

        // 4. Lấy thông tin tài chính
        $giaoDich = GiaoDichTaiChinh::whereYear('ngay_giao_dich', $year)
            ->whereMonth('ngay_giao_dich', $month)
            ->where('ban_nganh_id', $banThanhTrangId)
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

        // 5. Lấy thông tin thăm viếng
        $thamVieng = ThamVieng::with(['tinHuu', 'nguoiTham'])
            ->whereYear('ngay_tham', $year)
            ->whereMonth('ngay_tham', $month)
            ->where('id_ban', $banThanhTrangId)
            ->orderBy('ngay_tham')
            ->get();

        // 6. Lấy kế hoạch tháng tiếp theo
        $nextMonth = $month == 12 ? 1 : $month + 1;
        $nextYear = $month == 12 ? $year + 1 : $year;

        $keHoach = KeHoach::with('nguoiPhuTrach')
            ->where('ban_nganh_id', $banThanhTrangId)
            ->where('thang', $nextMonth)
            ->where('nam', $nextYear)
            ->get();

        // 7. Lấy đánh giá
        $diemManh = DanhGia::where('ban_nganh_id', $banThanhTrangId)
            ->where('loai', 'diem_manh')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $diemYeu = DanhGia::where('ban_nganh_id', $banThanhTrangId)
            ->where('loai', 'diem_yeu')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        // 8. Lấy kiến nghị
        $kienNghi = KienNghi::where('ban_nganh_id', $banThanhTrangId)
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        // 9. Tính toán số liệu tổng hợp
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

        return view('_ban_thanh_trang.bao_cao', compact(
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



    // Method hiển thị form nhập liệu báo cáo
    public function formBaoCaoBanThanhTrang(Request $request)
    {
        $currentMonth = $request->get('month', date('m'));
        $currentYear = $request->get('year', date('Y'));
        $currentBanNganhId = $request->get('ban_nganh_id', 1); // Mặc định là Ban Trung Lão

        // Tính toán tháng năm tiếp theo
        $nextMonth = $currentMonth == 12 ? 1 : $currentMonth + 1;
        $nextYear = $currentMonth == 12 ? $currentYear + 1 : $currentYear;

        // Lấy danh sách buổi nhóm Hội Thánh trong tháng
        $buoiNhomHT = BuoiNhom::with('dienGia')
            ->whereYear('ngay_dien_ra', $currentYear)
            ->whereMonth('ngay_dien_ra', $currentMonth)
            ->where('ban_nganh_id', 20) // ID của Hội thánh
            ->orderBy('ngay_dien_ra')
            ->get();

        // Lấy danh sách buổi nhóm Ban Trung Lão trong tháng
        $buoiNhomBN = BuoiNhom::with(['dienGia', 'giaoDichTaiChinh'])
            ->whereYear('ngay_dien_ra', $currentYear)
            ->whereMonth('ngay_dien_ra', $currentMonth)
            ->where('ban_nganh_id', 1) // ID của Ban Trung Lão
            ->orderBy('ngay_dien_ra')
            ->get();

        // Lấy danh sách tín hữu thuộc Ban Trung Lão
        $tinHuuTrungLao = TinHuu::select('tin_huu.id', 'tin_huu.ho_ten')
            ->join('tin_huu_ban_nganh', 'tin_huu.id', '=', 'tin_huu_ban_nganh.tin_huu_id')
            ->where('tin_huu_ban_nganh.ban_nganh_id', 1)
            ->orderBy('tin_huu.ho_ten')
            ->get();

        // Lấy đánh giá
        $diemManh = DanhGia::where('ban_nganh_id', 1)
            ->where('loai', 'diem_manh')
            ->where('thang', $currentMonth)
            ->where('nam', $currentYear)
            ->get();

        $diemYeu = DanhGia::where('ban_nganh_id', 1)
            ->where('loai', 'diem_yeu')
            ->where('thang', $currentMonth)
            ->where('nam', $currentYear)
            ->get();

        // Lấy kế hoạch tháng tiếp theo
        $keHoach = KeHoach::with('nguoiPhuTrach')
            ->where('ban_nganh_id', 1)
            ->where('thang', $nextMonth)
            ->where('nam', $nextYear)
            ->get();

        // Lấy kiến nghị
        $kienNghi = KienNghi::where('ban_nganh_id', 1)
            ->where('thang', $currentMonth)
            ->where('nam', $currentYear)
            ->get();

        return view('_bao_cao.form_ban_thanh_trang', compact(
            'currentMonth',
            'currentYear',
            'currentBanNganhId',
            'nextMonth',
            'nextYear',
            'buoiNhomHT',
            'buoiNhomBN',
            'tinHuuTrungLao',
            'diemManh',
            'diemYeu',
            'keHoach',
            'kienNghi'
        ));
    }

    // Cập nhật số lượng tham dự
    public function updateThamDuTrungLao(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:buoi_nhom,id',
            'so_luong_trung_lao' => 'required|integer|min:0'
        ]);

        try {
            $buoiNhom = BuoiNhom::findOrFail($request->id);
            $buoiNhom->so_luong_trung_lao = $request->so_luong_trung_lao;
            $buoiNhom->save();

            // Xử lý dâng hiến
            if ($request->has('dang_hien')) {
                // Loại bỏ các ký tự không phải số
                $dangHien = preg_replace('/[^0-9]/', '', $request->dang_hien);

                if ($dangHien > 0) {
                    // Tìm hoặc tạo mới giao dịch tài chính
                    $giaoDich = GiaoDichTaiChinh::firstOrNew([
                        'buoi_nhom_id' => $buoiNhom->id,
                        'ban_nganh_id' => 1, // ID của Ban Trung Lão
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
            Log::error('Lỗi cập nhật: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    // Lưu tất cả số lượng tham dự
    public function saveThamDuTrungLao(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'buoi_nhom' => 'required|array'
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->buoi_nhom as $id => $data) {
                $buoiNhom = BuoiNhom::findOrFail($id);
                $buoiNhom->so_luong_trung_lao = $data['so_luong_trung_lao'] ?? 0;
                $buoiNhom->save();

                // Xử lý dâng hiến
                if ($buoiNhom->ban_nganh_id == 1 && isset($data['dang_hien'])) {
                    $dangHien = str_replace('.', '', $data['dang_hien']); // Xóa dấu phân cách hàng nghìn

                    if ($dangHien > 0) {
                        // Tìm hoặc tạo mới giao dịch tài chính
                        $giaoDich = GiaoDichTaiChinh::firstOrNew([
                            'buoi_nhom_id' => $buoiNhom->id,
                            'ban_nganh_id' => 1, // ID của Ban Trung Lão
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
            Log::error('Lỗi lưu tham dự: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // Lưu đánh giá
    public function saveDanhGiaTrungLao(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'diem_manh' => 'required|array',
            'diem_manh_id' => 'required|array',
            'diem_yeu' => 'required|array',
            'diem_yeu_id' => 'required|array'
        ]);

        DB::beginTransaction();

        try {
            // Lưu điểm mạnh
            foreach ($request->diem_manh as $index => $noiDung) {
                $id = $request->diem_manh_id[$index];

                if (empty($noiDung))
                    continue; // Bỏ qua nếu nội dung trống

                if ($id > 0) {
                    // Cập nhật
                    $danhGia = DanhGia::findOrFail($id);
                    $danhGia->noi_dung = $noiDung;
                    $danhGia->save();
                } else {
                    // Tạo mới
                    DanhGia::create([
                        'ban_nganh_id' => $request->ban_nganh_id,
                        'loai' => 'diem_manh',
                        'noi_dung' => $noiDung,
                        'thang' => $request->month,
                        'nam' => $request->year,
                        'nguoi_danh_gia_id' => Auth::check() ? Auth::user()->tin_huu_id : null
                    ]);
                }
            }

            // Lưu điểm yếu
            foreach ($request->diem_yeu as $index => $noiDung) {
                $id = $request->diem_yeu_id[$index];

                if (empty($noiDung))
                    continue; // Bỏ qua nếu nội dung trống

                if ($id > 0) {
                    // Cập nhật
                    $danhGia = DanhGia::findOrFail($id);
                    $danhGia->noi_dung = $noiDung;
                    $danhGia->save();
                } else {
                    // Tạo mới
                    DanhGia::create([
                        'ban_nganh_id' => $request->ban_nganh_id,
                        'loai' => 'diem_yeu',
                        'noi_dung' => $noiDung,
                        'thang' => $request->month,
                        'nam' => $request->year,
                        'nguoi_danh_gia_id' => Auth::check() ? Auth::user()->tin_huu_id : null
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Đã lưu đánh giá thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // Lưu kế hoạch
    public function saveKeHoachTrungLao(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'kehoach' => 'required|array'
        ]);

        DB::beginTransaction();

        try {
            // Lưu kế hoạch
            foreach ($request->kehoach as $data) {
                $id = $data['id'] ?? 0;

                // Bỏ qua nếu hoạt động trống
                if (empty($data['hoat_dong']))
                    continue;

                if ($id > 0) {
                    // Cập nhật
                    $keHoach = KeHoach::findOrFail($id);
                    $keHoach->hoat_dong = $data['hoat_dong'];
                    $keHoach->thoi_gian = $data['thoi_gian'] ?? '';
                    $keHoach->nguoi_phu_trach_id = $data['nguoi_phu_trach_id'] ?? null;
                    $keHoach->ghi_chu = $data['ghi_chu'] ?? '';
                    $keHoach->save();
                } else {
                    // Tạo mới
                    KeHoach::create([
                        'ban_nganh_id' => $request->ban_nganh_id,
                        'hoat_dong' => $data['hoat_dong'],
                        'thoi_gian' => $data['thoi_gian'] ?? '',
                        'nguoi_phu_trach_id' => $data['nguoi_phu_trach_id'] ?? null,
                        'ghi_chu' => $data['ghi_chu'] ?? '',
                        'thang' => $request->month,
                        'nam' => $request->year,
                        'trang_thai' => 'chua_thuc_hien'
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Đã lưu kế hoạch thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // Lưu kiến nghị
    public function saveKienNghiTrungLao(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'kiennghi' => 'required|array'
        ]);

        DB::beginTransaction();

        try {
            // Lưu kiến nghị
            foreach ($request->kiennghi as $data) {
                $id = $data['id'] ?? 0;

                // Bỏ qua nếu tiêu đề hoặc nội dung trống
                if (empty($data['tieu_de']) || empty($data['noi_dung']))
                    continue;

                if ($id > 0) {
                    // Cập nhật
                    $kienNghi = KienNghi::findOrFail($id);
                    $kienNghi->tieu_de = $data['tieu_de'];
                    $kienNghi->noi_dung = $data['noi_dung'];
                    $kienNghi->nguoi_de_xuat_id = $data['nguoi_de_xuat_id'] ?? null;
                    $kienNghi->save();
                } else {
                    // Tạo mới
                    KienNghi::create([
                        'ban_nganh_id' => $request->ban_nganh_id,
                        'tieu_de' => $data['tieu_de'],
                        'noi_dung' => $data['noi_dung'],
                        'nguoi_de_xuat_id' => $data['nguoi_de_xuat_id'] ?? null,
                        'thang' => $request->month,
                        'nam' => $request->year,
                        'trang_thai' => 'moi'
                    ]);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Đã lưu kiến nghị thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}