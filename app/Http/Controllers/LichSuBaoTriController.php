<?php

namespace App\Http\Controllers;

use App\Models\LichSuBaoTri;
use App\Models\ThietBi;
use App\Models\GiaoDichTaiChinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LichSuBaoTriController extends Controller
{
    /**
     * Lấy lịch sử bảo trì của thiết bị
     */
    public function getByThietBi($thietBiId)
    {
        try {
            $lichSuBaoTris = LichSuBaoTri::where('thiet_bi_id', $thietBiId)
                ->orderBy('ngay_bao_tri', 'desc')
                ->get();

            return response()->json($lichSuBaoTris);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy lịch sử bảo trì: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể lấy lịch sử bảo trì'], 500);
        }
    }

    /**
     * Lưu lịch sử bảo trì mới
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'thiet_bi_id' => 'required|exists:thiet_bi,id',
                'ngay_bao_tri' => 'required|date',
                'chi_phi' => 'nullable|numeric|min:0',
                'nguoi_thuc_hien' => 'required|string|max:255',
                'mo_ta' => 'nullable|string'
            ]);

            $lichSuBaoTri = LichSuBaoTri::create($validated);

            // Tạo giao dịch tài chính nếu có chi phí
            if ($lichSuBaoTri->chi_phi > 0) {
                $thietBi = ThietBi::findOrFail($lichSuBaoTri->thiet_bi_id);

                GiaoDichTaiChinh::create([
                    'loai' => 'chi',
                    'so_tien' => $lichSuBaoTri->chi_phi,
                    'mo_ta' => 'Chi phí bảo trì thiết bị: ' . $thietBi->ten,
                    'ngay_giao_dich' => $lichSuBaoTri->ngay_bao_tri,
                    'ban_nganh_id' => $thietBi->id_ban
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Thêm lịch sử bảo trì thành công',
                'data' => $lichSuBaoTri
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi thêm lịch sử bảo trì: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể thêm lịch sử bảo trì: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy thông tin lịch sử bảo trì để chỉnh sửa
     */
    public function edit(LichSuBaoTri $lichSuBaoTri)
    {
        return response()->json($lichSuBaoTri);
    }

    /**
     * Cập nhật thông tin lịch sử bảo trì
     */
    public function update(Request $request, LichSuBaoTri $lichSuBaoTri)
    {
        try {
            $validated = $request->validate([
                'ngay_bao_tri' => 'required|date',
                'chi_phi' => 'nullable|numeric|min:0',
                'nguoi_thuc_hien' => 'required|string|max:255',
                'mo_ta' => 'nullable|string'
            ]);

            // Cập nhật thông tin
            $lichSuBaoTri->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật lịch sử bảo trì thành công',
                'data' => $lichSuBaoTri
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật lịch sử bảo trì: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể cập nhật lịch sử bảo trì: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa lịch sử bảo trì
     */
    public function destroy(LichSuBaoTri $lichSuBaoTri)
    {
        try {
            $lichSuBaoTri->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa lịch sử bảo trì thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa lịch sử bảo trì: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa lịch sử bảo trì: ' . $e->getMessage()
            ], 500);
        }
    }
}