<?php

namespace App\Http\Controllers;

use App\Models\ThanHuu;
use App\Models\TinHuu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ThanHuuExport;

class ThanHuuController extends Controller
{
    /**
     * Hiển thị trang danh sách thân hữu
     */
    public function index()
    {
        // Lấy danh sách tín hữu để sử dụng trong form lọc và modal
        $tinHuus = TinHuu::orderBy('ho_ten')->get();

        // Lấy danh sách thân hữu (phân trang nếu cần, nhưng ở đây DataTables sẽ xử lý server-side)
        $thanHuus = ThanHuu::orderBy('ho_ten')->paginate(10);

        return view('_than_huu.index', compact('thanHuus', 'tinHuus'));

        $thanHuus = ThanHuu::orderBy('ho_ten')->paginate(10);
        return view('_than_huu.index', compact('thanHuus'));
    }

    /**
     * Hiển thị form tạo mới thân hữu
     */
    public function create()
    {
        $tinHuus = TinHuu::orderBy('ho_ten')->get();
        return view('_than_huu.create', compact('tinHuus'));
    }

    /**
     * Hiển thị form chỉnh sửa thân hữu
     */
    public function edit(ThanHuu $thanHuu)
    {
        $tinHuus = TinHuu::orderBy('ho_ten')->get();
        return view('_than_huu.edit', compact('thanHuu', 'tinHuus'));
    }

    /**
     * Hiển thị chi tiết thân hữu
     */
    public function show(ThanHuu $thanHuu)
    {
        return view('_than_huu.show', compact('thanHuu'));
    }

    /**
     * API: Lấy danh sách thân hữu cho DataTables (server-side)
     */
    public function getThanHuus(Request $request)
    {
        try {
            $query = ThanHuu::query()->with('tinHuuGioiThieu');

            // Xử lý lọc
            if ($request->has('ho_ten') && $request->ho_ten) {
                $query->where('ho_ten', 'like', '%' . $request->ho_ten . '%');
            }
            if ($request->has('trang_thai') && $request->trang_thai) {
                $query->where('trang_thai', $request->trang_thai);
            }
            if ($request->has('tin_huu_gioi_thieu_id') && $request->tin_huu_gioi_thieu_id) {
                $query->where('tin_huu_gioi_thieu_id', $request->tin_huu_gioi_thieu_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($thanHuu) {
                    return '<div class="btn-group">
                        <a href="javascript:void(0)" class="btn btn-sm btn-primary btn-view" data-id="' . $thanHuu->id . '" title="Xem chi tiết"><i class="fas fa-eye"></i></a>
                        <button type="button" class="btn btn-sm btn-info btn-edit" data-id="' . $thanHuu->id . '" title="Sửa"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="' . $thanHuu->id . '" data-name="' . $thanHuu->ho_ten . '" title="Xóa"><i class="fas fa-trash"></i></button>
                    </div>';
                })
                ->editColumn('tin_huu_gioi_thieu', function ($thanHuu) {
                    return $thanHuu->tinHuuGioiThieu ? $thanHuu->tinHuuGioiThieu->ho_ten : '(Không có)';
                })
                ->editColumn('trang_thai', function ($thanHuu) {
                    $badges = [
                        'chua_tin' => 'badge-danger',
                        'da_tham_gia' => 'badge-warning',
                        'da_tin_chua' => 'badge-success'
                    ];
                    $labels = [
                        'chua_tin' => 'Chưa tin',
                        'da_tham_gia' => 'Đã tham gia',
                        'da_tin_chua' => 'Đã tin Chúa'
                    ];
                    return '<span class="badge ' . ($badges[$thanHuu->trang_thai] ?? 'badge-secondary') . '">' . ($labels[$thanHuu->trang_thai] ?? $thanHuu->trang_thai) . '</span>';
                })
                ->editColumn('so_dien_thoai', function ($thanHuu) {
                    return $thanHuu->so_dien_thoai ? '<a href="tel:' . $thanHuu->so_dien_thoai . '" class="text-primary"><i class="fas fa-phone-alt mr-1"></i>' . $thanHuu->so_dien_thoai . '</a>' : '(Không có)';
                })
                ->rawColumns(['ho_ten', 'trang_thai', 'so_dien_thoai', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy danh sách thân hữu: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể lấy danh sách thân hữu'], 500);
        }
    }

    /**
     * API: Lấy thông tin chi tiết 1 thân hữu
     */
    public function getThanHuuJson(ThanHuu $thanHuu)
    {
        try {
            $thanHuu->load('tinHuuGioiThieu');
            return response()->json($thanHuu);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy thông tin thân hữu: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể lấy thông tin thân hữu'], 500);
        }
    }

    /**
     * API: Thêm thân hữu mới
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'ho_ten' => 'required|string|max:255',
                'nam_sinh' => 'required|integer|min:1900|max:' . date('Y'),
                'so_dien_thoai' => 'nullable|string|max:20',
                'dia_chi' => 'nullable|string|max:255',
                'tin_huu_gioi_thieu_id' => 'required|exists:tin_huu,id',
                'trang_thai' => 'required|in:chua_tin,da_tham_gia,da_tin_chua',
                'ghi_chu' => 'nullable|string',
            ]);

            $thanHuu = ThanHuu::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Thêm thân hữu thành công',
                'data' => $thanHuu
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi thêm thân hữu: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể thêm thân hữu'
            ], 500);
        }
    }

    /**
     * API: Cập nhật thân hữu
     */
    public function update(Request $request, ThanHuu $thanHuu)
    {
        try {
            $validated = $request->validate([
                'ho_ten' => 'required|string|max:255',
                'nam_sinh' => 'required|integer|min:1900|max:' . date('Y'),
                'so_dien_thoai' => 'nullable|string|max:20',
                'dia_chi' => 'nullable|string|max:255',
                'tin_huu_gioi_thieu_id' => 'required|exists:tin_huu,id',
                'trang_thai' => 'required|in:chua_tin,da_tham_gia,da_tin_chua',
                'ghi_chu' => 'nullable|string',
            ]);

            $thanHuu->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thân hữu thành công',
                'data' => $thanHuu
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật thân hữu: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể cập nhật thân hữu'
            ], 500);
        }
    }

    /**
     * API: Xóa thân hữu
     */
    public function destroy(ThanHuu $thanHuu)
    {
        try {
            $thanHuu->delete();
            return response()->json([
                'success' => true,
                'message' => 'Xóa thân hữu thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa thân hữu: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa thân hữu'
            ], 500);
        }
    }

    /**
     * Xuất danh sách thân hữu ra Excel
     */
    public function exportExcel()
    {
        try {
            return Excel::download(new ThanHuuExport, 'danh_sach_than_huu_' . date('Ymd_His') . '.xlsx');
        } catch (\Exception $e) {
            Log::error('Lỗi xuất Excel: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Không thể xuất Excel');
        }
    }
}
