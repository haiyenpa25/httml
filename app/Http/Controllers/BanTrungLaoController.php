<?php

namespace App\Http\Controllers;

use App\Models\BanNganh;
use App\Models\TinHuu;
use App\Models\TinHuuBanNganh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BuoiNhom;
use App\Models\DienGia;
use Illuminate\Support\Facades\Validator;


class BanTrungLaoController extends Controller
{
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

    public function diemDanh()
    {
        // Hiển thị trang điểm danh
        $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
        if (!$banTrungLao) {
            return redirect()->route('_ban_nganh.index')->with('error', 'Không tìm thấy Ban Trung Lão');
        }

        $thanhVien = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banTrungLao->id)
            ->get();

        return view('_ban_trung_lao.diem_danh', compact('banTrungLao', 'thanhVien'));
    }

    public function thamVieng()
    {
        // Hiển thị trang thăm viếng
        $banTrungLao = BanNganh::where('ten', 'Ban Trung Lão')->first();
        if (!$banTrungLao) {
            return redirect()->route('_ban_nganh.index')->with('error', 'Không tìm thấy Ban Trung Lão');
        }

        $thanhVien = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banTrungLao->id)
            ->get();

        return view('_ban_trung_lao.tham_vieng', compact('banTrungLao', 'thanhVien'));
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
        $month = $request->input('month', date('n')); // Tháng hiện tại
        $year = $request->input('year', date('Y')); // Năm hiện tại

        // Lấy danh sách buổi nhóm của Ban Trung Lão theo tháng và năm
        $buoiNhoms = BuoiNhom::with(['dienGia', 'banNganh', 'tinHuuHdct', 'tinHuuDoKt'])
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


    public function updateBuoiNhom(Request $request, BuoiNhom $buoiNhom)
    {
        try {
            $validator = Validator::make($request->all(), [
                'chu_de' => 'nullable|string|max:255',
                'dien_gia_id' => 'nullable|exists:dien_gia,id',
                'id_tin_huu_hdct' => 'nullable|exists:tin_huu,id',
                'id_tin_huu_do_kt' => 'nullable|exists:tin_huu,id',
                'ghi_chu' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ.',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Cập nhật thông tin buổi nhóm
            $buoiNhom->update($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật buổi nhóm thành công.',
                'data' => $buoiNhom->fresh()->load(['dienGia', 'tinHuuHdct', 'tinHuuDoKt'])
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật buổi nhóm: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi khi cập nhật buổi nhóm: ' . $e->getMessage()
            ], 500);
        }
    }
}
