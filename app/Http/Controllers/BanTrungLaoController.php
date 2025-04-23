<?php

namespace App\Http\Controllers;

use App\Models\BanNganh;
use App\Models\TinHuu;
use App\Models\TinHuuBanNganh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BuoiNhom;
use App\Models\DienGia;
use App\Models\ChiTietThamGia;
use App\Models\NhiemVu;
use App\Models\GiaoDichTaiChinh;
use App\Models\ThamVieng;
use App\Models\BuoiNhomNhiemVu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\KeHoach;
use App\Models\KienNghi;
use App\Models\DanhGia;
use Illuminate\Support\Facades\Auth;


class BanTrungLaoController extends Controller
{
    /**
     * Hiển thị trang chính của Ban Trung Lão
     */
    public function index()
    {
        // Lấy thông tin ban Trung Lão
        $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
        if (!$banTrungLao) {
            return redirect()->route('_ban_nganh.index')->with('error', 'Không tìm thấy Ban Trung Lão');
        }

        // Lấy danh sách ban điều hành (có chức vụ cụ thể)
        $banDieuHanh = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banTrungLao->id)
            ->whereNotNull('chuc_vu')
            ->whereIn('chuc_vu', [
                'Cố Vấn',
                'Cố Vấn Linh Vụ',
                'Trưởng Ban',
                'Thư Ký',
                'Thủ Quỹ',
                'Ủy Viên'
            ])
            ->orderByRaw("CASE 
                WHEN chuc_vu = 'Cố Vấn' OR chuc_vu = 'Cố Vấn Linh Vụ' THEN 1 
                WHEN chuc_vu = 'Trưởng Ban' THEN 2 
                WHEN chuc_vu = 'Thư Ký' THEN 3 
                WHEN chuc_vu = 'Thủ Quỹ' THEN 4 
                WHEN chuc_vu = 'Ủy Viên' THEN 5 
                ELSE 6 END")
            ->get();

        // Lấy danh sách tất cả thành viên trong ban Trung Lão (không thuộc ban điều hành)
        $banVien = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banTrungLao->id)
            ->where(function ($query) {
                $query->whereNull('chuc_vu')
                    ->orWhere('chuc_vu', 'Thành viên')
                    ->orWhere('chuc_vu', '');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Lấy danh sách tất cả tín hữu (cho chức năng thêm thành viên)
        // Loại bỏ những người đã là thành viên của ban
        $existingMemberIds = TinHuuBanNganh::where('ban_nganh_id', $banTrungLao->id)
            ->pluck('tin_huu_id')
            ->toArray();

        $tinHuuList = TinHuu::whereNotIn('id', $existingMemberIds)
            ->orderBy('ho_ten', 'asc')
            ->get();

        return view('_ban_trung_lao.index', compact('banTrungLao', 'banDieuHanh', 'banVien', 'tinHuuList'));
    }

    /**
     * Hiển thị báo cáo Ban Trung Lão
     */
    /**
     * Hiển thị báo cáo Ban Trung Lão
     */



    /**
     * Lấy dữ liệu tóm tắt cho báo cáo
     */
    private function getSummaryData($month, $year, $banId)
    {
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // Đếm tổng số buổi nhóm
        $totalMeetings = BuoiNhom::where(function ($query) use ($banId) {
            $query->where('ban_nganh_id', $banId)
                ->orWhereNull('ban_nganh_id');
        })
            ->whereMonth('ngay_dien_ra', $month)
            ->whereYear('ngay_dien_ra', $year)
            ->count();

        // Tính trung bình người tham dự
        $avgAttendance = BuoiNhom::where(function ($query) use ($banId) {
            $query->where('ban_nganh_id', $banId)
                ->orWhereNull('ban_nganh_id');
        })
            ->whereMonth('ngay_dien_ra', $month)
            ->whereYear('ngay_dien_ra', $year)
            ->avg('so_luong_tin_huu');

        if (is_null($avgAttendance)) {
            $avgAttendance = 0;
        }

        // Đếm số lần thăm viếng
        $totalVisits = ThamVieng::where('id_ban', $banId)
            ->whereMonth('ngay_tham', $month)
            ->whereYear('ngay_tham', $year)
            ->count();

        // Lấy tổng dâng hiến
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

        // Kiểm tra xem có giao dịch nào không
        $hasTransactions = GiaoDichTaiChinh::where('ban_nganh_id', $banId)
            ->whereMonth('ngay_giao_dich', $month)
            ->whereYear('ngay_giao_dich', $year)
            ->exists();

        // Nếu không có giao dịch, tạo mẫu dữ liệu
        if (!$hasTransactions) {
            // Tạo dữ liệu mẫu - bạn có thể điều chỉnh hoặc xóa phần này trong môi trường sản xuất
            $giaoDich = collect([]);
            $tongThu = 5400000; // Giá trị mẫu
            $tongChi = 1500000; // Giá trị mẫu
            $tongTon = $tongThu - $tongChi;

            return [
                'giaoDich' => $giaoDich,
                'tongThu' => $tongThu,
                'tongChi' => $tongChi,
                'tongTon' => $tongTon
            ];
        }

        // Lấy tất cả giao dịch tài chính trong tháng
        $giaoDich = GiaoDichTaiChinh::where('ban_nganh_id', $banId)
            ->whereMonth('ngay_giao_dich', $month)
            ->whereYear('ngay_giao_dich', $year)
            ->orderBy('ngay_giao_dich')
            ->get();

        // Tính tổng thu
        $tongThu = $giaoDich->where('loai', 'thu')->sum('so_tien');

        // Tính tổng chi
        $tongChi = $giaoDich->where('loai', 'chi')->sum('so_tien');

        // Tính tổng tồn
        $tongTon = $tongThu - $tongChi;

        return [
            'giaoDich' => $giaoDich,
            'tongThu' => $tongThu,
            'tongChi' => $tongChi,
            'tongTon' => $tongTon
        ];
    }

    /**
     * Thêm thành viên vào Ban Trung Lão
     */
    public function themThanhVien(Request $request)
    {
        $validatedData = $request->validate([
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'chuc_vu' => 'nullable|string|max:50',
        ]);

        // Kiểm tra xem thành viên đã có trong ban chưa
        $exists = TinHuuBanNganh::where('tin_huu_id', $validatedData['tin_huu_id'])
            ->where('ban_nganh_id', $validatedData['ban_nganh_id'])
            ->exists();

        if ($exists) {
            return redirect()->route('_ban_trung_lao.index')
                ->with('error', 'Thành viên này đã thuộc ban Trung Lão!');
        }

        // Thêm thành viên mới vào bảng tin_huu_ban_nganh
        TinHuuBanNganh::create([
            'tin_huu_id' => $validatedData['tin_huu_id'],
            'ban_nganh_id' => $validatedData['ban_nganh_id'],
            'chuc_vu' => $validatedData['chuc_vu'] ?? 'Thành viên'
        ]);

        return redirect()->route('_ban_trung_lao.index')
            ->with('success', 'Đã thêm thành viên vào ban Trung Lão thành công!');
    }

    /**
     * Xóa thành viên khỏi Ban Trung Lão
     */
    public function xoaThanhVien(Request $request)
    {
        $validatedData = $request->validate([
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
        ]);

        // Xóa thành viên khỏi bảng tin_huu_ban_nganh
        TinHuuBanNganh::where('tin_huu_id', $validatedData['tin_huu_id'])
            ->where('ban_nganh_id', $validatedData['ban_nganh_id'])
            ->delete();

        return redirect()->route('_ban_trung_lao.index')
            ->with('success', 'Đã xóa thành viên khỏi ban Trung Lão thành công!');
    }

    /**
     * Cập nhật chức vụ thành viên trong Ban Trung Lão
     */
    public function capNhatChucVu(Request $request)
    {
        $validatedData = $request->validate([
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'chuc_vu' => 'nullable|string|max:50',
        ]);

        // Nếu là thiết lập Trưởng Ban, kiểm tra xem đã có Trưởng Ban chưa
        if ($validatedData['chuc_vu'] == 'Trưởng Ban') {
            $existingTruongBan = TinHuuBanNganh::where('ban_nganh_id', $validatedData['ban_nganh_id'])
                ->where('chuc_vu', 'Trưởng Ban')
                ->where('tin_huu_id', '!=', $validatedData['tin_huu_id'])
                ->first();

            if ($existingTruongBan) {
                return redirect()->route('_ban_trung_lao.index')
                    ->with('error', 'Ban Trung Lão đã có Trưởng Ban! Vui lòng thay đổi chức vụ của người hiện tại trước.');
            }

            // Cập nhật trưởng ban cho bảng ban_nganh
            BanNganh::where('id', $validatedData['ban_nganh_id'])
                ->update(['truong_ban_id' => $validatedData['tin_huu_id']]);
        }

        // Cập nhật chức vụ trong bảng tin_huu_ban_nganh
        TinHuuBanNganh::where('tin_huu_id', $validatedData['tin_huu_id'])
            ->where('ban_nganh_id', $validatedData['ban_nganh_id'])
            ->update(['chuc_vu' => $validatedData['chuc_vu'] ?? 'Thành viên']);

        return redirect()->route('_ban_trung_lao.index')
            ->with('success', 'Đã cập nhật chức vụ thành công!');
    }

    /**
     * Hiển thị trang điểm danh của Ban Trung Lão
     */
    public function diemDanh(Request $request)
    {
        // Lấy thông tin ban Trung Lão
        $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
        if (!$banTrungLao) {
            return redirect()->route('_ban_nganh.index')->with('error', 'Không tìm thấy Ban Trung Lão');
        }

        // Lấy tháng và năm từ request, nếu không có thì lấy tháng và năm hiện tại
        $month = $request->input('month', date('m')); // Tháng hiện tại
        $year = $request->input('year', date('Y')); // Năm hiện tại
        $selectedBuoiNhom = $request->input('buoi_nhom_id');

        // Tạo danh sách các tháng
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create()->month($i)->translatedFormat('F');
            $months[$i] = $monthName;
        }

        // Tạo danh sách các năm (2 năm trước đến 1 năm sau)
        $currentYear = (int)date('Y');
        $years = range($currentYear - 2, $currentYear + 1);

        // Lấy danh sách các buổi nhóm trong tháng và năm đã chọn
        $buoiNhomOptions = BuoiNhom::where('ban_nganh_id', $banTrungLao->id)
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->orderBy('ngay_dien_ra', 'desc')
            ->get();

        // Thông tin buổi nhóm đang được chọn
        $currentBuoiNhom = null;
        if ($selectedBuoiNhom) {
            $currentBuoiNhom = BuoiNhom::with(['dienGia', 'tinHuuHdct', 'tinHuuDoKt'])
                ->find($selectedBuoiNhom);
        }

        // Danh sách tín hữu trong Ban Trung Lão
        $danhSachTinHuu = TinHuu::whereHas('banNganhs', function ($query) use ($banTrungLao) {
            $query->where('ban_nganh_id', $banTrungLao->id);
        })
            ->orderBy('ho_ten')
            ->get();

        // Lấy dữ liệu điểm danh của buổi nhóm đã chọn
        $diemDanhData = [];
        $stats = [
            'co_mat' => 0,
            'vang_mat' => 0,
            'vang_co_phep' => 0,
            'ti_le_tham_du' => 0
        ];

        if ($selectedBuoiNhom) {
            $chiTietThamGia = ChiTietThamGia::where('buoi_nhom_id', $selectedBuoiNhom)
                ->get()
                ->keyBy('tin_huu_id');

            foreach ($chiTietThamGia as $id => $chiTiet) {
                $diemDanhData[$id] = [
                    'status' => $chiTiet->trang_thai,
                    'note' => $chiTiet->ghi_chu
                ];

                // Cập nhật thống kê
                if ($chiTiet->trang_thai == 'co_mat') {
                    $stats['co_mat']++;
                } elseif ($chiTiet->trang_thai == 'vang_mat') {
                    $stats['vang_mat']++;
                } elseif ($chiTiet->trang_thai == 'vang_co_phep') {
                    $stats['vang_co_phep']++;
                }
            }

            // Tính tỷ lệ tham dự
            $totalMembers = $danhSachTinHuu->count();
            $stats['ti_le_tham_du'] = $totalMembers > 0
                ? round(($stats['co_mat'] / $totalMembers) * 100)
                : 0;
        }

        // Lấy danh sách diễn giả cho form thêm buổi nhóm
        $dienGias = DienGia::orderBy('ho_ten')->get();

        return view('_ban_trung_lao.diem_danh', compact(
            'banTrungLao',
            'months',
            'years',
            'month',
            'year',
            'buoiNhomOptions',
            'selectedBuoiNhom',
            'currentBuoiNhom',
            'danhSachTinHuu',
            'diemDanhData',
            'stats',
            'dienGias'
        ));
    }

    /**
     * Xử lý lưu điểm danh
     */
    public function luuDiemDanh(Request $request)
    {
        Log::info('Lưu điểm danh request:', $request->all());

        $validator = Validator::make($request->all(), [
            'buoi_nhom_id' => 'required|exists:buoi_nhom,id',
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|in:co_mat,vang_mat,vang_co_phep',
            'attendance.*.note' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $buoiNhomId = $request->buoi_nhom_id;
            $attendanceData = $request->attendance;

            // Xóa dữ liệu điểm danh cũ của buổi nhóm này
            ChiTietThamGia::where('buoi_nhom_id', $buoiNhomId)->delete();

            // Thêm dữ liệu điểm danh mới
            foreach ($attendanceData as $tinHuuId => $data) {
                ChiTietThamGia::create([
                    'buoi_nhom_id' => $buoiNhomId,
                    'tin_huu_id' => $tinHuuId,
                    'trang_thai' => $data['status'],
                    'ghi_chu' => $data['note'] ?? null
                ]);
            }

            // Cập nhật thống kê trong bảng buổi nhóm
            $buoiNhom = BuoiNhom::find($buoiNhomId);
            $buoiNhom->so_luong_tin_huu = collect($attendanceData)->filter(function ($item) {
                return $item['status'] === 'co_mat' || $item['status'] === 'vang_co_phep';
            })->count();

            $buoiNhom->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đã lưu điểm danh thành công'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi lưu điểm danh: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi lưu điểm danh: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Thêm buổi nhóm mới
     */
    public function themBuoiNhom(Request $request)
    {
        Log::info('Thêm buổi nhóm request:', $request->all());

        $validator = Validator::make($request->all(), [
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'ngay_dien_ra' => 'required|date',
            'chu_de' => 'required|string|max:255',
            'dien_gia_id' => 'nullable|exists:dien_gia,id',
            'dia_diem' => 'required|string',
            'gio_bat_dau' => 'required',
            'gio_ket_thuc' => 'required',
            'ghi_chu' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Tạo buổi nhóm mới
            $buoiNhom = BuoiNhom::create([
                'ban_nganh_id' => $request->ban_nganh_id,
                'ngay_dien_ra' => $request->ngay_dien_ra,
                'chu_de' => $request->chu_de,
                'dien_gia_id' => $request->dien_gia_id,
                'dia_diem' => $request->dia_diem,
                'gio_bat_dau' => $request->gio_bat_dau,
                'gio_ket_thuc' => $request->gio_ket_thuc,
                'ghi_chu' => $request->ghi_chu
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đã tạo buổi nhóm mới thành công',
                'data' => $buoiNhom
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi thêm buổi nhóm: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi tạo buổi nhóm: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hiển thị trang phân công của Ban Trung Lão
     */
    public function phanCong(Request $request)
    {
        // Lấy thông tin ban Trung Lão
        $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
        if (!$banTrungLao) {
            return redirect()->route('_ban_nganh.index')->with('error', 'Không tìm thấy Ban Trung Lão');
        }

        // Lấy tháng và năm từ request, nếu không có thì lấy tháng và năm hiện tại
        $month = $request->input('month', date('m')); // Tháng hiện tại
        $year = $request->input('year', date('Y')); // Năm hiện tại

        // Lấy danh sách buổi nhóm của Ban Trung Lão theo tháng và năm
        $buoiNhoms = BuoiNhom::with(['dienGia', 'tinHuuHdct', 'tinHuuDoKt'])
            ->where('ban_nganh_id', $banTrungLao->id)
            ->whereMonth('ngay_dien_ra', $month)
            ->whereYear('ngay_dien_ra', $year)
            ->orderBy('ngay_dien_ra', 'asc')
            ->get();

        // Lấy danh sách diễn giả
        $dienGias = DienGia::orderBy('ho_ten')->get();

        // Lấy danh sách tín hữu
        $tinHuus = TinHuu::orderBy('ho_ten')->get();

        // Chuẩn bị dữ liệu cho select box tháng
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = date('F', mktime(0, 0, 0, $i, 1));
        }

        // Chuẩn bị dữ liệu cho select box năm
        $years = [];
        $currentYear = (int)date('Y');
        for ($i = $currentYear - 2; $i <= $currentYear + 2; $i++) {
            $years[$i] = $i;
        }

        return view('_ban_trung_lao.phan_cong', compact(
            'banTrungLao',
            'buoiNhoms',
            'dienGias',
            'tinHuus',
            'month',
            'year',
            'months',
            'years'
        ));
    }

    /**
     * Cập nhật thông tin buổi nhóm
     */
    public function updateBuoiNhom(Request $request, BuoiNhom $buoiNhom)
    {
        Log::info('Attempting to update BuoiNhom ID for Ban Trung Lao: ' . $buoiNhom->id, $request->all());

        $validator = Validator::make($request->all(), [
            'ngay_dien_ra' => 'required|date',
            'chu_de' => 'nullable|string|max:255',
            'dien_gia_id' => 'nullable|exists:dien_gia,id',
            'id_tin_huu_hdct' => 'nullable|exists:tin_huu,id',
            'id_tin_huu_do_kt' => 'nullable|exists:tin_huu,id',
            'ghi_chu' => 'nullable|string',
        ], [
            'required' => ':attribute không được để trống.',
            'exists' => ':attribute không hợp lệ.',
            'date' => ':attribute phải là ngày hợp lệ.',
            'string' => ':attribute phải là chuỗi.',
            'max' => ':attribute không được vượt quá :max ký tự.',
        ], [
            'ngay_dien_ra' => 'Ngày diễn ra',
            'chu_de' => 'Chủ đề',
            'dien_gia_id' => 'Diễn giả',
            'id_tin_huu_hdct' => 'Người hướng dẫn',
            'id_tin_huu_do_kt' => 'Người đọc Kinh Thánh',
            'ghi_chu' => 'Ghi chú',
        ]);

        if ($validator->fails()) {
            Log::warning('BuoiNhom update validation failed for ID: ' . $buoiNhom->id, $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Kiểm tra xem buổi nhóm có thuộc Ban Trung Lão không
            $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();

            if (!$banTrungLao || $buoiNhom->ban_nganh_id !== $banTrungLao->id) {
                Log::warning('Attempted to update BuoiNhom not belonging to Ban Trung Lão');
                return response()->json([
                    'success' => false,
                    'message' => 'Buổi nhóm không thuộc Ban Trung Lão.'
                ], 403);
            }

            // Cập nhật thông tin buổi nhóm
            $buoiNhom->update($validator->validated());

            Log::info('BuoiNhom updated successfully for ID: ' . $buoiNhom->id);
            return response()->json([
                'success' => true,
                'message' => 'Buổi nhóm đã được cập nhật thành công.',
                'data' => $buoiNhom->fresh()->load(['dienGia', 'tinHuuHdct', 'tinHuuDoKt'])
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating BuoiNhom ' . $buoiNhom->id . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi cập nhật buổi nhóm.'
            ], 500);
        }
    }

    /**
     * Xóa buổi nhóm
     */
    public function deleteBuoiNhom(BuoiNhom $buoiNhom)
    {
        Log::info('Attempting to delete BuoiNhom ID: ' . $buoiNhom->id);

        try {
            // Kiểm tra xem buổi nhóm có thuộc Ban Trung Lão không
            $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();

            if (!$banTrungLao || $buoiNhom->ban_nganh_id !== $banTrungLao->id) {
                Log::warning('Attempted to delete BuoiNhom not belonging to Ban Trung Lão');
                return response()->json([
                    'success' => false,
                    'message' => 'Buổi nhóm không thuộc Ban Trung Lão.'
                ], 403);
            }

            $buoiNhom->delete();

            Log::info('BuoiNhom deleted successfully ID: ' . $buoiNhom->id);
            return response()->json([
                'success' => true,
                'message' => 'Buổi nhóm đã được xóa thành công.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting BuoiNhom ' . $buoiNhom->id . ': ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa buổi nhóm. Có thể do dữ liệu liên quan.'
            ], 500);
        }
    }

    /**
     * Hiển thị trang thăm viếng
     */
    public function thamVieng()
    {
        // Lấy thông tin ban Trung Lão
        $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
        if (!$banTrungLao) {
            return redirect()->route('_ban_nganh.index')->with('error', 'Không tìm thấy Ban Trung Lão');
        }

        // Lấy danh sách thành viên trong Ban Trung Lão
        $thanhVienBanTrungLao = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banTrungLao->id)
            ->get();

        // Lấy danh sách tất cả tín hữu
        $danhSachTinHuu = TinHuu::orderBy('ho_ten')->get();

        // Đề xuất thăm viếng - những tín hữu chưa thăm lâu nhất
        $now = Carbon::now();
        $deXuatThamVieng = TinHuu::select('*')
            ->selectRaw('DATEDIFF(?, ngay_tham_vieng_gan_nhat) as so_ngay_chua_tham', [$now])
            ->whereNotNull('ngay_tham_vieng_gan_nhat')
            ->orderBy('ngay_tham_vieng_gan_nhat', 'asc')
            ->limit(10)
            ->get()
            ->merge(
                TinHuu::whereNull('ngay_tham_vieng_gan_nhat')
                    ->orderBy('created_at', 'asc')
                    ->limit(5)
                    ->get()
            );

        // Lấy danh sách tín hữu có tọa độ cho bản đồ
        $tinHuuWithLocations = TinHuu::whereNotNull('vi_do')
            ->whereNotNull('kinh_do')
            ->get();

        // Lịch sử thăm viếng - 30 ngày gần đây
        $lichSuThamVieng = ThamVieng::with(['tinHuu', 'nguoiTham'])
            ->where('id_ban', $banTrungLao->id)
            ->where('trang_thai', 'da_tham')
            ->whereDate('ngay_tham', '>=', Carbon::now()->subDays(30))
            ->orderBy('ngay_tham', 'desc')
            ->limit(20)
            ->get();

        // Thống kê thăm viếng
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

        // Tổng số lần thăm
        $thongKe['total_visits'] = ThamVieng::where('id_ban', $banNganhId)
            ->where('trang_thai', 'da_tham')
            ->count();

        // Số lần thăm tháng này
        $thongKe['this_month'] = ThamVieng::where('id_ban', $banNganhId)
            ->where('trang_thai', 'da_tham')
            ->whereMonth('ngay_tham', Carbon::now()->month)
            ->whereYear('ngay_tham', Carbon::now()->year)
            ->count();

        // Thống kê 6 tháng gần đây
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

            // Tạo bản ghi thăm viếng mới
            $thamVieng = ThamVieng::create([
                'tin_huu_id' => $request->tin_huu_id,
                'nguoi_tham_id' => $request->nguoi_tham_id,
                'id_ban' => $request->id_ban,
                'ngay_tham' => $request->ngay_tham,
                'noi_dung' => $request->noi_dung,
                'ket_qua' => $request->ket_qua,
                'trang_thai' => $request->trang_thai,
            ]);

            // Nếu trạng thái là "đã thăm", cập nhật ngày thăm viếng gần nhất cho tín hữu
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
                $query->whereNull('ngay_tham_vieng_gan_nhat')
                    ->orWhere('ngay_tham_vieng_gan_nhat', '<=', $cutoffDate);
            })
            ->orderBy('ngay_tham_vieng_gan_nhat', 'asc')
            ->orderBy('created_at', 'asc')
            ->limit(20)
            ->get();

        // Format dates
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

        // Format data
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
        $thamVieng = ThamVieng::with(['tinHuu', 'nguoiTham', 'banNganh'])
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
    }


    /**
     * Hiển thị form nhập liệu báo cáo Ban Trung Lão
     */
    public function banTrungLaoForm(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));
        $buoiNhomType = $request->get('buoi_nhom_id', 1); // Mặc định là Ban Trung Lão

        // ID của Ban Trung Lão và Hội Thánh
        $banTrungLaoId = 1; // Ban Trung Lão
        $hoiThanhId = 13;   // Hội Thánh

        // Lấy danh sách tín hữu trong Ban Trung Lão
        $thanhVienBan = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banTrungLaoId)
            ->get();

        // Lấy buổi nhóm của Hội Thánh trong tháng hiện tại
        $buoiNhomHT = BuoiNhom::with('dienGia')
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', $hoiThanhId)
            ->orderBy('ngay_dien_ra')
            ->get();

        // Lấy buổi nhóm Ban Trung Lão trong tháng hiện tại
        $buoiNhomBTL = BuoiNhom::with('dienGia')
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', $banTrungLaoId)
            ->orderBy('ngay_dien_ra')
            ->get();

        // Lấy đánh giá hiện tại
        $diemManh = DanhGia::where('ban_nganh_id', $banTrungLaoId)
            ->where('loai', 'diem_manh')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $diemYeu = DanhGia::where('ban_nganh_id', $banTrungLaoId)
            ->where('loai', 'diem_yeu')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        // Lấy kế hoạch cho tháng tiếp theo
        $nextMonth = $month == 12 ? 1 : $month + 1;
        $nextYear = $month == 12 ? $year + 1 : $year;

        $keHoach = KeHoach::with('nguoiPhuTrach')
            ->where('ban_nganh_id', $banTrungLaoId)
            ->where('thang', $nextMonth)
            ->where('nam', $nextYear)
            ->get();

        // Lấy kiến nghị
        $kienNghi = KienNghi::with('nguoiDeXuat')
            ->where('ban_nganh_id', $banTrungLaoId)
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        return view('_ban_trung_lao.form_ban_trung_lao', compact(
            'month',
            'year',
            'buoiNhomType',
            'thanhVienBan',
            'buoiNhomHT',
            'buoiNhomBTL',
            'diemManh',
            'diemYeu',
            'keHoach',
            'kienNghi'
        ));
    }

    /**
     * Lưu cập nhật số lượng tham dự buổi nhóm
     */
    public function capNhatSoLuongThamDu(Request $request)
    {
        try {
            $buoiNhomId = $request->buoi_nhom_id;
            $soLuongTrungLao = $request->so_luong_trung_lao;

            // Tìm buổi nhóm
            $buoiNhom = BuoiNhom::findOrFail($buoiNhomId);

            // Cập nhật số lượng trung lão
            $buoiNhom->so_luong_trung_lao = $soLuongTrungLao;

            // Nếu có dâng hiến và là buổi nhóm Ban Trung Lão (id = 1)
            if ($request->has('dang_hien') && $buoiNhom->ban_nganh_id == 1) {
                // Định dạng lại số tiền (loại bỏ dấu phẩy)
                $dangHien = str_replace([',', '.'], '', $request->dang_hien);

                // Tạo hoặc cập nhật giao dịch tài chính
                $giaoDich = GiaoDichTaiChinh::updateOrCreate(
                    [
                        'buoi_nhom_id' => $buoiNhomId,
                        'loai' => 'thu',
                        'ban_nganh_id' => 1
                    ],
                    [
                        'so_tien' => $dangHien,
                        'mo_ta' => 'Dâng hiến buổi nhóm ngày ' . Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y'),
                        'ngay_giao_dich' => $buoiNhom->ngay_dien_ra
                    ]
                );
            }

            $buoiNhom->save();

            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật số lượng tham dự thành công.'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật số lượng tham dự: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lưu đánh giá báo cáo
     */
    public function luuDanhGia(Request $request)
    {
        try {
            $banTrungLaoId = 1; // ID của Ban Trung Lão
            $month = $request->month;
            $year = $request->year;

            // Xóa đánh giá cũ của tháng này
            DanhGia::where('ban_nganh_id', $banTrungLaoId)
                ->where('thang', $month)
                ->where('nam', $year)
                ->delete();

            // Lưu điểm mạnh mới
            if ($request->has('diem_manh')) {
                foreach ($request->diem_manh as $diemManh) {
                    if (!empty($diemManh)) {
                        DanhGia::create([
                            'ban_nganh_id' => $banTrungLaoId,
                            'loai' => 'diem_manh',
                            'noi_dung' => $diemManh,
                            'thang' => $month,
                            'nam' => $year,
                            'nguoi_danh_gia_id' => Auth::user()->tin_huu_id ?? null
                        ]);
                    }
                }
            }

            // Lưu điểm yếu mới
            if ($request->has('diem_yeu')) {
                foreach ($request->diem_yeu as $diemYeu) {
                    if (!empty($diemYeu)) {
                        DanhGia::create([
                            'ban_nganh_id' => $banTrungLaoId,
                            'loai' => 'diem_yeu',
                            'noi_dung' => $diemYeu,
                            'thang' => $month,
                            'nam' => $year,
                            'nguoi_danh_gia_id' => Auth::user()->tin_huu_id ?? null
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Đã lưu đánh giá thành công.'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi lưu đánh giá: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lưu đánh giá: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lưu kế hoạch báo cáo
     */
    public function luuKeHoach(Request $request)
    {
        try {
            $banTrungLaoId = 1; // ID của Ban Trung Lão

            // Tháng kế hoạch là tháng sau
            $currentMonth = $request->month;
            $currentYear = $request->year;

            $nextMonth = $currentMonth == 12 ? 1 : $currentMonth + 1;
            $nextYear = $currentMonth == 12 ? $currentYear + 1 : $currentYear;

            // Xóa kế hoạch cũ của tháng sau
            KeHoach::where('ban_nganh_id', $banTrungLaoId)
                ->where('thang', $nextMonth)
                ->where('nam', $nextYear)
                ->delete();

            // Lưu kế hoạch mới
            if ($request->has('hoat_dong')) {
                $count = count($request->hoat_dong);

                for ($i = 0; $i < $count; $i++) {
                    if (!empty($request->hoat_dong[$i])) {
                        KeHoach::create([
                            'ban_nganh_id' => $banTrungLaoId,
                            'hoat_dong' => $request->hoat_dong[$i],
                            'thoi_gian' => $request->thoi_gian[$i] ?? null,
                            'nguoi_phu_trach_id' => $request->nguoi_phu_trach_id[$i] ?? null,
                            'ghi_chu' => $request->ghi_chu[$i] ?? null,
                            'thang' => $nextMonth,
                            'nam' => $nextYear,
                            'trang_thai' => $request->trang_thai[$i] ?? 'chua_thuc_hien'
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Đã lưu kế hoạch thành công.'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi lưu kế hoạch: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lưu kế hoạch: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lưu kiến nghị báo cáo
     */
    public function luuKienNghi(Request $request)
    {
        try {
            $banTrungLaoId = 1; // ID của Ban Trung Lão
            $month = $request->month;
            $year = $request->year;

            // Không xóa kiến nghị cũ vì kiến nghị cần được theo dõi liên tục

            // Lưu kiến nghị mới hoặc cập nhật kiến nghị cũ
            if ($request->has('tieu_de')) {
                $count = count($request->tieu_de);

                for ($i = 0; $i < $count; $i++) {
                    if (!empty($request->tieu_de[$i]) && !empty($request->noi_dung[$i])) {
                        // Nếu có id thì cập nhật, không thì tạo mới
                        if (!empty($request->kien_nghi_id[$i])) {
                            $kienNghi = KienNghi::find($request->kien_nghi_id[$i]);
                            if ($kienNghi) {
                                $kienNghi->update([
                                    'tieu_de' => $request->tieu_de[$i],
                                    'noi_dung' => $request->noi_dung[$i],
                                    'nguoi_de_xuat_id' => $request->nguoi_de_xuat_id[$i] ?? null,
                                    'trang_thai' => $request->trang_thai_kien_nghi[$i] ?? 'moi',
                                    'phan_hoi' => $request->phan_hoi[$i] ?? null
                                ]);
                            }
                        } else {
                            KienNghi::create([
                                'ban_nganh_id' => $banTrungLaoId,
                                'tieu_de' => $request->tieu_de[$i],
                                'noi_dung' => $request->noi_dung[$i],
                                'nguoi_de_xuat_id' => $request->nguoi_de_xuat_id[$i] ?? null,
                                'thang' => $month,
                                'nam' => $year,
                                'trang_thai' => $request->trang_thai_kien_nghi[$i] ?? 'moi',
                                'phan_hoi' => $request->phan_hoi[$i] ?? null
                            ]);
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Đã lưu kiến nghị thành công.'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi lưu kiến nghị: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi lưu kiến nghị: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lưu tất cả thông tin báo cáo
     */
    public function luuBaoCaoBanTrungLao(Request $request)
    {
        try {
            DB::beginTransaction();

            // Lưu các phần dữ liệu
            $this->capNhatSoLuongThamDu($request);
            $this->luuDanhGia($request);
            $this->luuKeHoach($request);
            $this->luuKienNghi($request);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đã lưu báo cáo thành công.'
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
     * Hiển thị báo cáo Ban Trung Lão
     */
    public function baoCaoBanTrungLao(Request $request): \Illuminate\View\View
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        // ID của Ban Trung Lão
        $banTrungLaoId = 1; // Giả sử ID=1 là Ban Trung Lão

        // 1. Lấy thông tin Ban điều hành
        $banDieuHanh = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banTrungLaoId)
            ->whereNotNull('chuc_vu')
            ->get();

        // 2. Lấy buổi nhóm Hội Thánh (Chúa Nhật) có thống kê số lượng Trung Lão
        $buoiNhomHT = BuoiNhom::with('dienGia')
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', 13) // Giả sử ID=13 là Hội thánh
            ->orderBy('ngay_dien_ra')
            ->get();

        // 3. Lấy buổi nhóm Ban Trung Lão
        $buoiNhomBN = BuoiNhom::with('dienGia')
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', $banTrungLaoId)
            ->orderBy('ngay_dien_ra')
            ->get();

        // 4. Lấy thông tin tài chính
        $giaoDich = GiaoDichTaiChinh::whereYear('ngay_giao_dich', $year)
            ->whereMonth('ngay_giao_dich', $month)
            ->where('ban_nganh_id', $banTrungLaoId)
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
            ->where('id_ban', $banTrungLaoId)
            ->orderBy('ngay_tham')
            ->get();

        // 6. Lấy kế hoạch tháng tiếp theo
        $nextMonth = $month == 12 ? 1 : $month + 1;
        $nextYear = $month == 12 ? $year + 1 : $year;

        $keHoach = KeHoach::with('nguoiPhuTrach')
            ->where('ban_nganh_id', $banTrungLaoId)
            ->where('thang', $nextMonth)
            ->where('nam', $nextYear)
            ->get();

        // 7. Lấy đánh giá
        $diemManh = DanhGia::where('ban_nganh_id', $banTrungLaoId)
            ->where('loai', 'diem_manh')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $diemYeu = DanhGia::where('ban_nganh_id', $banTrungLaoId)
            ->where('loai', 'diem_yeu')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        // 8. Lấy kiến nghị
        $kienNghi = KienNghi::where('ban_nganh_id', $banTrungLaoId)
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

        return view('_bao_cao.ban_trung_lao', compact(
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
     * Hiển thị trang phân công chi tiết nhiệm vụ
     */
    public function phanCongChiTiet(Request $request)
    {
        // Lấy thông tin ban Trung Lão
        $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
        if (!$banTrungLao) {
            return redirect()->route('_ban_nganh.index')->with('error', 'Không tìm thấy Ban Trung Lão');
        }

        // Lấy tháng và năm từ request, nếu không có thì lấy tháng và năm hiện tại
        $month = $request->input('month', date('m')); // Tháng hiện tại
        $year = $request->input('year', date('Y')); // Năm hiện tại
        $selectedBuoiNhom = $request->input('buoi_nhom_id');

        // Tạo danh sách các tháng
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create()->month($i)->translatedFormat('F');
            $months[$i] = $monthName;
        }

        // Tạo danh sách các năm (2 năm trước đến 1 năm sau)
        $currentYear = (int)date('Y');
        $years = range($currentYear - 2, $currentYear + 1);

        // Lấy danh sách các buổi nhóm trong tháng và năm đã chọn
        $buoiNhomOptions = BuoiNhom::where('ban_nganh_id', $banTrungLao->id)
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->orderBy('ngay_dien_ra', 'desc')
            ->get();

        // Thông tin buổi nhóm đang được chọn
        $currentBuoiNhom = null;
        if ($selectedBuoiNhom) {
            $currentBuoiNhom = BuoiNhom::with(['dienGia', 'tinHuuHdct', 'tinHuuDoKt'])
                ->find($selectedBuoiNhom);
        }

        // Lấy danh sách các nhiệm vụ thuộc ban Trung Lão
        $danhSachNhiemVu = NhiemVu::All();

        // Lấy danh sách thành viên ban Trung Lão
        $thanhVienBan = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banTrungLao->id)
            ->get();

        // Lấy phân công nhiệm vụ của buổi nhóm đã chọn
        $nhiemVuPhanCong = [];
        $daPhanCong = [];

        if ($selectedBuoiNhom) {
            $nhiemVuPhanCong = BuoiNhomNhiemVu::with(['nhiemVu', 'tinHuu'])
                ->where('buoi_nhom_id', $selectedBuoiNhom)
                ->orderBy('vi_tri')
                ->get();

            // Đếm số nhiệm vụ đã phân công cho mỗi tín hữu
            foreach ($nhiemVuPhanCong as $phanCong) {
                if ($phanCong->tin_huu_id) {
                    if (!isset($daPhanCong[$phanCong->tin_huu_id])) {
                        $daPhanCong[$phanCong->tin_huu_id] = 1;
                    } else {
                        $daPhanCong[$phanCong->tin_huu_id]++;
                    }
                }
            }
        }

        return view('_ban_trung_lao.phan_cong_chi_tiet', compact(
            'banTrungLao',
            'months',
            'years',
            'month',
            'year',
            'buoiNhomOptions',
            'selectedBuoiNhom',
            'currentBuoiNhom',
            'danhSachNhiemVu',
            'thanhVienBan',
            'nhiemVuPhanCong',
            'daPhanCong'
        ));
    }

    /**
     * Lưu phân công nhiệm vụ
     */
    public function phanCongNhiemVu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'buoi_nhom_id' => 'required|exists:buoi_nhom,id',
            'nhiem_vu_id' => 'required|exists:nhiem_vu,id',
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'ghi_chu' => 'nullable|string',
            'id' => 'nullable|exists:buoi_nhom_nhiem_vu,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Kiểm tra xem buổi nhóm có thuộc Ban Trung Lão không
            $buoiNhom = BuoiNhom::find($request->buoi_nhom_id);
            $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();

            if (!$banTrungLao || $buoiNhom->ban_nganh_id != $banTrungLao->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buổi nhóm không thuộc Ban Trung Lão'
                ], 403);
            }

            // Kiểm tra xem người được phân công có thuộc Ban Trung Lão không
            $isMember = TinHuuBanNganh::where('tin_huu_id', $request->tin_huu_id)
                ->where('ban_nganh_id', $banTrungLao->id)
                ->exists();

            if (!$isMember) {
                return response()->json([
                    'success' => false,
                    'message' => 'Người được phân công không thuộc Ban Trung Lão'
                ], 403);
            }

            // Kiểm tra xem nhiệm vụ có thuộc Ban Trung Lão không
            $nhiemVu = NhiemVu::find($request->nhiem_vu_id);
            if ($nhiemVu->id_ban_nganh != $banTrungLao->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nhiệm vụ không thuộc Ban Trung Lão'
                ], 403);
            }

            // Lấy vị trí tiếp theo
            $maxPosition = BuoiNhomNhiemVu::where('buoi_nhom_id', $request->buoi_nhom_id)
                ->max('vi_tri') ?? 0;

            // Nếu có ID, cập nhật bản ghi hiện tại
            if ($request->filled('id')) {
                $phanCong = BuoiNhomNhiemVu::find($request->id);
                $phanCong->update([
                    'nhiem_vu_id' => $request->nhiem_vu_id,
                    'tin_huu_id' => $request->tin_huu_id,
                    'ghi_chu' => $request->ghi_chu
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật phân công nhiệm vụ thành công'
                ]);
            } else {
                // Kiểm tra xem nhiệm vụ đã được phân công cho buổi nhóm này chưa
                $exists = BuoiNhomNhiemVu::where('buoi_nhom_id', $request->buoi_nhom_id)
                    ->where('nhiem_vu_id', $request->nhiem_vu_id)
                    ->exists();

                if ($exists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Nhiệm vụ này đã được phân công cho buổi nhóm'
                    ], 422);
                }

                // Tạo phân công mới
                BuoiNhomNhiemVu::create([
                    'buoi_nhom_id' => $request->buoi_nhom_id,
                    'nhiem_vu_id' => $request->nhiem_vu_id,
                    'tin_huu_id' => $request->tin_huu_id,
                    'vi_tri' => $maxPosition + 1,
                    'ghi_chu' => $request->ghi_chu
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Phân công nhiệm vụ thành công'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Lỗi phân công nhiệm vụ: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi phân công nhiệm vụ: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa phân công nhiệm vụ
     */
    public function xoaPhanCong($id)
    {
        try {
            // Tìm phân công cần xóa
            $phanCong = BuoiNhomNhiemVu::find($id);

            if (!$phanCong) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy phân công này'
                ], 404);
            }

            // Kiểm tra buổi nhóm có thuộc Ban Trung Lão không
            $buoiNhom = BuoiNhom::find($phanCong->buoi_nhom_id);
            $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();

            if (!$banTrungLao || $buoiNhom->ban_nganh_id != $banTrungLao->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền xóa phân công này'
                ], 403);
            }

            // Xóa phân công
            $phanCong->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa phân công thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa phân công nhiệm vụ: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi xóa phân công: ' . $e->getMessage()
            ], 500);
        }
    }
}
