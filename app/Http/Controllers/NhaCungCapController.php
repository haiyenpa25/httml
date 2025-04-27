<?php

namespace App\Http\Controllers;

use App\Models\NhaCungCap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NhaCungCapController extends Controller
{
    /**
     * Hiển thị danh sách nhà cung cấp
     */
    public function index()
    {
        return view('_thiet_bi.nha_cung_cap.index');
    }

    /**
     * Lấy danh sách nhà cung cấp dạng JSON
     */
    public function getNhaCungCaps()
    {
        try {
            $nhaCungCaps = NhaCungCap::withCount('thietBis')->get();
            return response()->json($nhaCungCaps);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy danh sách nhà cung cấp: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể lấy danh sách nhà cung cấp'], 500);
        }
    }

    /**
     * Lưu nhà cung cấp mới
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'ten_nha_cung_cap' => 'required|string|max:255',
                'dia_chi' => 'nullable|string',
                'so_dien_thoai' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'ghi_chu' => 'nullable|string'
            ]);

            $nhaCungCap = NhaCungCap::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Thêm nhà cung cấp thành công',
                'data' => $nhaCungCap
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi thêm nhà cung cấp: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể thêm nhà cung cấp: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy thông tin nhà cung cấp
     */
    public function show(NhaCungCap $nhaCungCap)
    {
        return response()->json($nhaCungCap);
    }

    /**
     * Lấy thông tin nhà cung cấp để chỉnh sửa
     */
    public function edit(NhaCungCap $nhaCungCap)
    {
        return response()->json($nhaCungCap);
    }

    /**
     * Cập nhật thông tin nhà cung cấp
     */
    public function update(Request $request, NhaCungCap $nhaCungCap)
    {
        try {
            $validated = $request->validate([
                'ten_nha_cung_cap' => 'required|string|max:255',
                'dia_chi' => 'nullable|string',
                'so_dien_thoai' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'ghi_chu' => 'nullable|string'
            ]);

            $nhaCungCap->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật nhà cung cấp thành công',
                'data' => $nhaCungCap
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật nhà cung cấp: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể cập nhật nhà cung cấp: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xóa nhà cung cấp
     */
    public function destroy(NhaCungCap $nhaCungCap)
    {
        try {
            // Kiểm tra xem có thiết bị nào đang sử dụng nhà cung cấp này không
            $countThietBi = $nhaCungCap->thietBis()->count();
            if ($countThietBi > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xóa nhà cung cấp vì có ' . $countThietBi . ' thiết bị đang sử dụng.'
                ], 400);
            }

            $nhaCungCap->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa nhà cung cấp thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa nhà cung cấp: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa nhà cung cấp: ' . $e->getMessage()
            ], 500);
        }
    }
}
