<?php

namespace App\Http\Controllers;

use App\Models\DienGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DienGiaExport;

class DienGiaController extends Controller
{
    /**
     * Hiển thị trang danh sách diễn giả
     */
    public function index()
    {
        $dienGias = DienGia::orderBy('ho_ten')->paginate(10);
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
     * API: Lấy danh sách diễn giả cho DataTables (server-side)
     */
    public function getDienGias(Request $request)
    {
        try {
            $query = DienGia::query();

            // Xử lý lọc
            if ($request->has('ho_ten') && $request->ho_ten) {
                $query->where('ho_ten', 'like', '%' . $request->ho_ten . '%');
            }
            if ($request->has('chuc_danh') && $request->chuc_danh) {
                $query->where('chuc_danh', $request->chuc_danh);
            }
            if ($request->has('hoi_thanh') && $request->hoi_thanh) {
                $query->where('hoi_thanh', 'like', '%' . $request->hoi_thanh . '%');
            }

            return DataTables::of($query)
                ->addIndexColumn() // Thêm cột chỉ số cho STT
                ->addColumn('action', function ($dienGia) {
                    return '<div class="btn-group">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-view" data-id="' . $dienGia->id . '" title="Xem chi tiết"><i class="fas fa-eye"></i></a>
                        <button type="button" class="btn btn-sm btn-info btn-edit" data-id="' . $dienGia->id . '" title="Sửa"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $dienGia->id . '" data-name="' . $dienGia->ho_ten . '" title="Xóa"><i class="fas fa-trash"></i></button>
                    </div>';
                })
                ->editColumn('hoi_thanh', function ($dienGia) {
                    return $dienGia->hoi_thanh ?: '(Không có)';
                })
                ->editColumn('so_dien_thoai', function ($dienGia) {
                    return $dienGia->so_dien_thoai ? '<a href="tel:' . $dienGia->so_dien_thoai . '" class="text-primary"><i class="fas fa-phone-alt mr-1"></i>' . $dienGia->so_dien_thoai . '</a>' : '(Không có)';
                })
                ->rawColumns(['ho_ten', 'chuc_danh', 'so_dien_thoai', 'action'])
                ->make(true);
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
                'message' => 'Không thể thêm diễn giả'
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
                'message' => 'Không thể cập nhật diễn giả'
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
                'message' => 'Không thể xóa diễn giả'
            ], 500);
        }
    }

    /**
     * Xuất danh sách diễn giả ra Excel
     */
    public function exportExcel()
    {
        try {
            return Excel::download(new DienGiaExport, 'danh_sach_dien_gia_' . date('Ymd_His') . '.xlsx');
        } catch (\Exception $e) {
            Log::error('Lỗi xuất Excel: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Không thể xuất Excel');
        }
    }
}
