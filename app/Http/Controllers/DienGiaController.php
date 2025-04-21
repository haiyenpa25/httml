<?php

namespace App\Http\Controllers;

use App\Models\DienGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DienGiaController extends Controller
{
    /**
     * Hiển thị trang danh sách diễn giả
     */
    public function index()
    {
        $dienGias = DienGia::orderBy('ho_ten')->get();
        return view('_dien_gia.index', compact('dienGias'));
    }

    /**
     * Hiển thị form tạo mới diễn giả
     */
    public function create()
    {
        return view('_dien_gia.create');
    }

    /**
     * Hiển thị form chỉnh sửa diễn giả
     */
    public function edit(DienGia $dienGia)
    {
        return view('_dien_gia.edit', compact('dienGia'));
    }

    /**
     * Hiển thị chi tiết diễn giả
     */
    public function show(DienGia $dienGia)
    {
        return view('_dien_gia.show', compact('dienGia'));
    }

    /**
     * API: Lấy danh sách diễn giả
     */
    public function getDienGias()
    {
        try {
            $dienGias = DienGia::orderBy('ho_ten')->get();
            return response()->json($dienGias);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy danh sách diễn giả: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể lấy danh sách diễn giả'], 500);
        }
    }

    /**
     * API: Lấy thông tin chi tiết 1 diễn giả
     */
    public function getDienGiaJson(DienGia $dienGia)
    {
        try {
            return response()->json($dienGia);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy thông tin diễn giả: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể lấy thông tin diễn giả'], 500);
        }
    }

    /**
     * API: Thêm diễn giả mới
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'ho_ten' => 'required|string|max:255',
                'chuc_danh' => 'required|in:Thầy,Cô,Mục sư,Mục sư nhiệm chức,Truyền Đạo,Chấp Sự',
                'hoi_thanh' => 'nullable|string|max:255',
                'dia_chi' => 'nullable|string|max:255',
                'so_dien_thoai' => 'nullable|string|max:20',
            ]);

            $dienGia = DienGia::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Thêm diễn giả thành công',
                'data' => $dienGia
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi thêm diễn giả: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể thêm diễn giả: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Cập nhật diễn giả
     */
    public function update(Request $request, DienGia $dienGia)
    {
        try {
            $validated = $request->validate([
                'ho_ten' => 'required|string|max:255',
                'chuc_danh' => 'required|in:Thầy,Cô,Mục sư,Mục sư nhiệm chức,Truyền Đạo,Chấp Sự',
                'hoi_thanh' => 'nullable|string|max:255',
                'dia_chi' => 'nullable|string|max:255',
                'so_dien_thoai' => 'nullable|string|max:20',
            ]);

            $dienGia->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật diễn giả thành công',
                'data' => $dienGia
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật diễn giả: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể cập nhật diễn giả: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Xóa diễn giả
     */
    public function destroy(DienGia $dienGia)
    {
        try {
            $dienGia->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa diễn giả thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa diễn giả: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa diễn giả: ' . $e->getMessage()
            ], 500);
        }
    }
}
