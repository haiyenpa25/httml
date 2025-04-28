<?php

namespace App\Http\Controllers;

use App\Models\BanNganh;
use App\Models\TinHuu;
use App\Models\TinHuuBanNganh;
use App\Models\BuoiNhom;
use App\Models\DienGia;
use App\Models\ChiTietThamGia;
use App\Models\NhiemVu;
use App\Models\GiaoDichTaiChinh;
use App\Models\ThamVieng;
use App\Models\BuoiNhomNhiemVu;
use App\Models\KeHoach;
use App\Models\KienNghi;
use App\Models\DanhGia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BanTrungLaoController extends Controller
{
    // ID của Ban Trung Lão và Hội Thánh
    private const BAN_TRUNG_LAO_ID = 1;
    private const HOI_THANH_ID = 13;

    /**
     * Hiển thị trang chính của Ban Trung Lão
     */
    public function index()
    {
        $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
        if (!$banTrungLao) {
            return redirect()->route('_ban_nganh.index')->with('error', 'Không tìm thấy Ban Trung Lão');
        }

        $banDieuHanh = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banTrungLao->id)
            ->whereNotNull('chuc_vu')
            ->whereIn('chuc_vu', ['Cố Vấn', 'Cố Vấn Linh Vụ', 'Trưởng Ban', 'Thư Ký', 'Thủ Quỹ', 'Ủy Viên'])
            ->orderByRaw("CASE 
                WHEN chuc_vu = 'Cố Vấn' OR chuc_vu = 'Cố Vấn Linh Vụ' THEN 1 
                WHEN chuc_vu = 'Trưởng Ban' THEN 2 
                WHEN chuc_vu = 'Thư Ký' THEN 3 
                WHEN chuc_vu = 'Thủ Quỹ' THEN 4 
                WHEN chuc_vu = 'Ủy Viên' THEN 5 
                ELSE 6 END")
            ->get();

        $banVien = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banTrungLao->id)
            ->where(function ($query) {
                $query->whereNull('chuc_vu')
                    ->orWhere('chuc_vu', 'Thành viên')
                    ->orWhere('chuc_vu', '');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $existingMemberIds = TinHuuBanNganh::where('ban_nganh_id', $banTrungLao->id)
            ->pluck('tin_huu_id')
            ->toArray();

        $tinHuuList = TinHuu::whereNotIn('id', $existingMemberIds)
            ->orderBy('ho_ten', 'asc')
            ->get();

        return view('_ban_trung_lao.index', compact('banTrungLao', 'banDieuHanh', 'banVien', 'tinHuuList'));
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

        $exists = TinHuuBanNganh::where('tin_huu_id', $validatedData['tin_huu_id'])
            ->where('ban_nganh_id', $validatedData['ban_nganh_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Thành viên này đã thuộc ban Trung Lão!'
            ], 422);
        }

        TinHuuBanNganh::create([
            'tin_huu_id' => $validatedData['tin_huu_id'],
            'ban_nganh_id' => $validatedData['ban_nganh_id'],
            'chuc_vu' => $validatedData['chuc_vu'] ?? 'Thành viên'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm thành viên vào ban Trung Lão thành công!'
        ]);
    }

    /**
     * Xóa thành viên khỏi Ban Trung Lão
     */
    public function xoaThanhVien(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'tin_huu_id' => 'required|exists:tin_huu,id',
                'ban_nganh_id' => 'required|exists:ban_nganh,id',
            ]);

            $recordExists = TinHuuBanNganh::where('tin_huu_id', $validatedData['tin_huu_id'])
                ->where('ban_nganh_id', $validatedData['ban_nganh_id'])
                ->exists();

            if (!$recordExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy thành viên trong Ban Trung Lão để xóa.'
                ], 404);
            }

            TinHuuBanNganh::where('tin_huu_id', $validatedData['tin_huu_id'])
                ->where('ban_nganh_id', $validatedData['ban_nganh_id'])
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa thành viên khỏi ban Trung Lão thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa thành viên khỏi Ban Trung Lão: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi xóa thành viên: ' . $e->getMessage()
            ], 500);
        }
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

        if ($validatedData['chuc_vu'] == 'Trưởng Ban') {
            $existingTruongBan = TinHuuBanNganh::where('ban_nganh_id', $validatedData['ban_nganh_id'])
                ->where('chuc_vu', 'Trưởng Ban')
                ->where('tin_huu_id', '!=', $validatedData['tin_huu_id'])
                ->first();

            if ($existingTruongBan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ban Trung Lão đã có Trưởng Ban! Vui lòng thay đổi chức vụ của người hiện tại trước.'
                ], 422);
            }

            BanNganh::where('id', $validatedData['ban_nganh_id'])
                ->update(['truong_ban_id' => $validatedData['tin_huu_id']]);
        }

        TinHuuBanNganh::where('tin_huu_id', $validatedData['tin_huu_id'])
            ->where('ban_nganh_id', $validatedData['ban_nganh_id'])
            ->update(['chuc_vu' => $validatedData['chuc_vu'] ?? 'Thành viên']);

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật chức vụ thành công!'
        ]);
    }

    /**
     * Hiển thị trang điểm danh của Ban Trung Lão
     */
    public function diemDanh(Request $request)
    {
        $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
        if (!$banTrungLao) {
            return redirect()->route('_ban_nganh.index')->with('error', 'Không tìm thấy Ban Trung Lão');
        }

        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $selectedBuoiNhom = $request->input('buoi_nhom_id');

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create()->month($i)->translatedFormat('F');
            $months[$i] = $monthName;
        }

        $currentYear = (int) date('Y');
        $years = range($currentYear - 2, $currentYear + 1);

        $buoiNhomOptions = BuoiNhom::where('ban_nganh_id', $banTrungLao->id)
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->orderBy('ngay_dien_ra', 'desc')
            ->get();

        $currentBuoiNhom = $selectedBuoiNhom ? BuoiNhom::with(['dienGia', 'tinHuuHdct', 'tinHuuDoKt'])->find($selectedBuoiNhom) : null;

        $danhSachTinHuu = TinHuu::whereHas('banNganhs', function ($query) use ($banTrungLao) {
            $query->where('ban_nganh_id', $banTrungLao->id);
        })->orderBy('ho_ten')->get();

        $diemDanhData = [];
        $stats = ['co_mat' => 0, 'vang_mat' => 0, 'vang_co_phep' => 0, 'ti_le_tham_du' => 0];

        if ($selectedBuoiNhom) {
            $chiTietThamGia = ChiTietThamGia::where('buoi_nhom_id', $selectedBuoiNhom)
                ->get()
                ->keyBy('tin_huu_id');

            foreach ($chiTietThamGia as $id => $chiTiet) {
                $diemDanhData[$id] = [
                    'status' => $chiTiet->trang_thai,
                    'note' => $chiTiet->ghi_chu
                ];

                if ($chiTiet->trang_thai == 'co_mat') {
                    $stats['co_mat']++;
                } elseif ($chiTiet->trang_thai == 'vang_mat') {
                    $stats['vang_mat']++;
                } elseif ($chiTiet->trang_thai == 'vang_co_phep') {
                    $stats['vang_co_phep']++;
                }
            }

            $totalMembers = $danhSachTinHuu->count();
            $stats['ti_le_tham_du'] = $totalMembers > 0 ? round(($stats['co_mat'] / $totalMembers) * 100) : 0;
        }

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

            ChiTietThamGia::where('buoi_nhom_id', $buoiNhomId)->delete();

            foreach ($attendanceData as $tinHuuId => $data) {
                ChiTietThamGia::create([
                    'buoi_nhom_id' => $buoiNhomId,
                    'tin_huu_id' => $tinHuuId,
                    'trang_thai' => $data['status'],
                    'ghi_chu' => $data['note'] ?? null
                ]);
            }

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
        $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
        if (!$banTrungLao) {
            return redirect()->route('_ban_nganh.index')->with('error', 'Không tìm thấy Ban Trung Lão');
        }

        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $buoiNhoms = BuoiNhom::with(['dienGia', 'tinHuuHdct', 'tinHuuDoKt'])
            ->where('ban_nganh_id', $banTrungLao->id)
            ->whereMonth('ngay_dien_ra', $month)
            ->whereYear('ngay_dien_ra', $year)
            ->orderBy('ngay_dien_ra', 'asc')
            ->get();

        $dienGias = DienGia::orderBy('ho_ten')->get();
        $tinHuus = TinHuu::orderBy('ho_ten')->get();

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = date('F', mktime(0, 0, 0, $i, 1));
        }

        $years = [];
        $currentYear = (int) date('Y');
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
            'ngay_dien_ra' => 'Ngày diễn ra',
            'chu_de' => 'Chủ đề',
            'dien_gia_id' => 'Diễn giả',
            'id_tin_huu_hdct' => 'Người hướng dẫn',
            'id_tin_huu_do_kt' => 'Người đọc Kinh Thánh',
            'ghi_chu' => 'Ghi chú',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
            if (!$banTrungLao || $buoiNhom->ban_nganh_id !== $banTrungLao->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buổi nhóm không thuộc Ban Trung Lão.'
                ], 403);
            }

            $buoiNhom->update($validator->validated());

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
        try {
            $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
            if (!$banTrungLao || $buoiNhom->ban_nganh_id !== $banTrungLao->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buổi nhóm không thuộc Ban Trung Lão.'
                ], 403);
            }

            $buoiNhom->delete();

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

        // Tổng số lần thăm
        $thongKe['total_visits'] = ThamVieng::where('id_ban', $banNganhId)
            ->where('trang_thai', 'da_tham')
            ->count();

        // Thống kê theo tháng
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

    /**
     * Hiển thị trang phân công chi tiết nhiệm vụ
     */
    public function phanCongChiTiet(Request $request)
    {
        $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
        if (!$banTrungLao) {
            return redirect()->route('_ban_nganh.index')->with('error', 'Không tìm thấy Ban Trung Lão');
        }

        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $selectedBuoiNhom = $request->input('buoi_nhom_id');

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create()->month($i)->translatedFormat('F');
            $months[$i] = $monthName;
        }

        $currentYear = (int) date('Y');
        $years = range($currentYear - 2, $currentYear + 1);

        $buoiNhomOptions = BuoiNhom::where('ban_nganh_id', $banTrungLao->id)
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->orderBy('ngay_dien_ra', 'desc')
            ->get();

        $currentBuoiNhom = $selectedBuoiNhom ? BuoiNhom::with(['dienGia', 'tinHuuHdct', 'tinHuuDoKt'])->find($selectedBuoiNhom) : null;

        $danhSachNhiemVu = NhiemVu::all();

        $thanhVienBan = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banTrungLao->id)
            ->get();

        $nhiemVuPhanCong = [];
        $daPhanCong = [];

        if ($selectedBuoiNhom) {
            $nhiemVuPhanCong = BuoiNhomNhiemVu::with(['nhiemVu', 'tinHuu'])
                ->where('buoi_nhom_id', $selectedBuoiNhom)
                ->orderBy('vi_tri')
                ->get();

            foreach ($nhiemVuPhanCong as $phanCong) {
                if ($phanCong->tin_huu_id) {
                    $daPhanCong[$phanCong->tin_huu_id] = ($daPhanCong[$phanCong->tin_huu_id] ?? 0) + 1;
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
            $buoiNhom = BuoiNhom::find($request->buoi_nhom_id);
            $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();

            if (!$banTrungLao || $buoiNhom->ban_nganh_id != $banTrungLao->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buổi nhóm không thuộc Ban Trung Lão'
                ], 403);
            }

            $isMember = TinHuuBanNganh::where('tin_huu_id', $request->tin_huu_id)
                ->where('ban_nganh_id', $banTrungLao->id)
                ->exists();

            if (!$isMember) {
                return response()->json([
                    'success' => false,
                    'message' => 'Người được phân công không thuộc Ban Trung Lão'
                ], 403);
            }

            $nhiemVu = NhiemVu::find($request->nhiem_vu_id);
            if ($nhiemVu->id_ban_nganh != $banTrungLao->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nhiệm vụ không thuộc Ban Trung Lão'
                ], 403);
            }

            $maxPosition = BuoiNhomNhiemVu::where('buoi_nhom_id', $request->buoi_nhom_id)
                ->max('vi_tri') ?? 0;

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
                $exists = BuoiNhomNhiemVu::where('buoi_nhom_id', $request->buoi_nhom_id)
                    ->where('nhiem_vu_id', $request->nhiem_vu_id)
                    ->exists();

                if ($exists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Nhiệm vụ này đã được phân công cho buổi nhóm'
                    ], 422);
                }

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
            $phanCong = BuoiNhomNhiemVu::find($id);

            if (!$phanCong) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy phân công này'
                ], 404);
            }

            $buoiNhom = BuoiNhom::find($phanCong->buoi_nhom_id);
            $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();

            if (!$banTrungLao || $buoiNhom->ban_nganh_id != $banTrungLao->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có quyền xóa phân công này'
                ], 403);
            }

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

    /**
     * Lấy danh sách Ban Điều Hành (JSON cho DataTables)
     */
    public function dieuHanhList(Request $request)
    {
        try {
            $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
            if (!$banTrungLao) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy Ban Trung Lão'
                ], 404);
            }

            $query = TinHuuBanNganh::with('tinHuu')
                ->where('ban_nganh_id', $banTrungLao->id)
                ->whereNotNull('chuc_vu')
                ->whereIn('chuc_vu', ['Cố Vấn', 'Cố Vấn Linh Vụ', 'Trưởng Ban', 'Thư Ký', 'Thủ Quỹ', 'Ủy Viên']);

            if ($hoTen = $request->input('ho_ten')) {
                $query->whereHas('tinHuu', function ($q) use ($hoTen) {
                    $q->where('ho_ten', 'like', '%' . $hoTen . '%');
                });
            }

            if ($chucVu = $request->input('chuc_vu')) {
                $query->where('chuc_vu', $chucVu);
            }

            $data = $query->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'tin_huu_id' => $item->tin_huu_id,
                    'ho_ten' => $item->tinHuu->ho_ten ?? 'N/A',
                    'chuc_vu' => $item->chuc_vu ?? 'Thành viên'
                ];
            });

            if ($data->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Không có thành viên Ban Điều Hành',
                    'data' => []
                ]);
            }

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy danh sách Ban Điều Hành: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy danh sách Ban Viên (JSON cho DataTables)
     */
    public function banVienList(Request $request)
    {
        try {
            $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
            if (!$banTrungLao) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy Ban Trung Lão'
                ], 404);
            }

            $query = TinHuuBanNganh::with('tinHuu')
                ->where('ban_nganh_id', $banTrungLao->id)
                ->where(function ($q) {
                    $q->whereNull('chuc_vu')
                        ->orWhere('chuc_vu', 'Thành viên')
                        ->orWhere('chuc_vu', '');
                });

            if ($hoTen = $request->input('ho_ten')) {
                $query->whereHas('tinHuu', function ($q) use ($hoTen) {
                    $q->where('ho_ten', 'like', '%' . $hoTen . '%');
                });
            }

            if ($soDienThoai = $request->input('so_dien_thoai')) {
                $query->whereHas('tinHuu', function ($q) use ($soDienThoai) {
                    $q->where('so_dien_thoai', 'like', '%' . $soDienThoai . '%');
                });
            }

            if ($diaChi = $request->input('dia_chi')) {
                $query->whereHas('tinHuu', function ($q) use ($diaChi) {
                    $q->where('dia_chi', 'like', '%' . $diaChi . '%');
                });
            }

            $data = $query->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'tin_huu_id' => $item->tin_huu_id,
                    'ho_ten' => $item->tinHuu->ho_ten ?? 'N/A',
                    'so_dien_thoai' => $item->tinHuu->so_dien_thoai ?? 'N/A',
                    'dia_chi' => $item->tinHuu->dia_chi ?? 'N/A',
                    'chuc_vu' => $item->chuc_vu ?? 'Thành viên'
                ];
            });

            if ($data->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Không có Ban Viên',
                    'data' => []
                ]);
            }

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy danh sách Ban Viên: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hiển thị form nhập liệu báo cáo Ban Trung Lão
     */
    // Trong BanTrungLaoController.php
    // Trong BanTrungLaoController.php
    public function formBaoCaoBanTrungLao(Request $request): View
    {
        $month = $request->get('month', date('m')); // Lấy month từ request, mặc định là tháng hiện tại
        $year = $request->get('year', date('Y')); // Lấy year từ request, mặc định là năm hiện tại
        $buoiNhomType = $request->get('buoi_nhom_type', 1); // Lấy buoi_nhom_type, mặc định là 1 (Ban Trung Lão)

        $nextMonth = $month == 12 ? 1 : (int) $month + 1;
        $nextYear = $month == 12 ? (int) $year + 1 : $year;

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
     * Cập nhật số lượng tham dự và dâng hiến cho một buổi nhóm
     */
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

    /**
     * Lưu tất cả số lượng tham dự và dâng hiến
     */
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

    /**
     * Lưu đánh giá báo cáo
     */
    public function saveDanhGiaTrungLao(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'diem_manh' => 'required|array',
            'diem_manh_id' => 'required|array',
            'diem_yeu' => 'required|array',
            'diem_yeu_id' => 'required|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            foreach ($request->diem_manh as $index => $noiDung) {
                $id = $request->diem_manh_id[$index];

                if (empty($noiDung)) {
                    continue;
                }

                if ($id > 0) {
                    $danhGia = DanhGia::findOrFail($id);
                    $danhGia->noi_dung = $noiDung;
                    $danhGia->save();
                } else {
                    DanhGia::create([
                        'ban_nganh_id' => self::BAN_TRUNG_LAO_ID,
                        'loai' => 'diem_manh',
                        'noi_dung' => $noiDung,
                        'thang' => $request->month,
                        'nam' => $request->year,
                        'nguoi_danh_gia_id' => Auth::check() ? Auth::user()->tin_huu_id : null
                    ]);
                }
            }

            foreach ($request->diem_yeu as $index => $noiDung) {
                $id = $request->diem_yeu_id[$index];

                if (empty($noiDung)) {
                    continue;
                }

                if ($id > 0) {
                    $danhGia = DanhGia::findOrFail($id);
                    $danhGia->noi_dung = $noiDung;
                    $danhGia->save();
                } else {
                    DanhGia::create([
                        'ban_nganh_id' => self::BAN_TRUNG_LAO_ID,
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
            Log::error('Lỗi lưu đánh giá: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
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


    /**
     * Hiển thị báo cáo Ban Trung Lão
     */
    public function baoCaoBanTrungLao(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        // ID của Ban Trung Lão
        $banTrungLaoId = 1;

        // 1. Lấy thông tin Ban điều hành
        $banDieuHanh = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banTrungLaoId)
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

    public function capNhatSoLuongThamDu(Request $request)
    {
        return $this->updateThamDuTrungLao($request); // Gọi phương thức hiện có
    }

    /**
     * Xóa đánh giá (điểm mạnh hoặc điểm yếu)
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
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
            \Log::error('Lỗi xóa đánh giá: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi xóa đánh giá!'
            ], 500);
        }
    }

    /**
     * Xóa kiến nghị
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
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
            \Log::error('Lỗi xóa kiến nghị: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi xóa kiến nghị!'
            ], 500);
        }
    }
}