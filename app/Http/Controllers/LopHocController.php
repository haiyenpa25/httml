<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaoLopHocRequest;
use App\Http\Requests\UpdateLopHocRequest;
use App\Models\LopHoc;
use App\Models\TinHuu;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LopHocController extends Controller
{
    /**
     * Hiển thị danh sách lớp học (hỗ trợ DataTables).
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = LopHoc::query();

            // Áp dụng bộ lọc
            if ($tenLop = $request->input('ten_lop')) {
                $query->where('ten_lop', 'like', '%' . $tenLop . '%');
            }

            if ($loaiLop = $request->input('loai_lop')) {
                $query->where('loai_lop', $loaiLop);
            }

            if ($tanSuat = $request->input('tan_suat')) {
                $query->where('tan_suat', $tanSuat);
            }

            if ($diaDiem = $request->input('dia_diem')) {
                $query->where('dia_diem', 'like', '%' . $diaDiem . '%');
            }

            dd($query);

            return DataTables::of($query)
                ->addColumn('action', function ($lopHoc) {
                    // Cập nhật đường dẫn partial view
                    return view('_lop_hoc.partials.actions', compact('lopHoc'))->render();
                })
                ->editColumn('thoi_gian_bat_dau', function ($lopHoc) {
                    return $lopHoc->thoi_gian_bat_dau ? $lopHoc->thoi_gian_bat_dau->format('Y-m-d H:i:s') : null;
                })
                ->editColumn('thoi_gian_ket_thuc', function ($lopHoc) {
                    return $lopHoc->thoi_gian_ket_thuc ? $lopHoc->thoi_gian_ket_thuc->format('Y-m-d H:i:s') : null;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Cập nhật đường dẫn view
        return view('_lop_hoc.index');
    }

    /**
     * Hiển thị form tạo lớp học mới.
     */
    public function create()
    {
        // Cập nhật đường dẫn view
        return view('_lop_hoc.create');
    }

    /**
     * Lưu lớp học mới.
     */
    public function store(TaoLopHocRequest $request)
    {
        $data = $request->validated();
        LopHoc::create($data);

        return redirect()->route('lop-hoc.index')->with('success', 'Lớp học đã được tạo thành công.');
    }

    /**
     * Hiển thị chi tiết lớp học.
     */
    public function show(LopHoc $lopHoc)
    {
        // Cập nhật đường dẫn view
        return view('_lop_hoc.show', compact('lopHoc'));
    }

    /**
     * Hiển thị form sửa lớp học.
     */
    public function edit(LopHoc $lopHoc)
    {
        // Cập nhật đường dẫn view
        return view('_lop_hoc.edit', compact('lopHoc'));
    }

    /**
     * Cập nhật thông tin lớp học.
     */
    public function update(UpdateLopHocRequest $request, LopHoc $lopHoc)
    {
        $data = $request->validated();
        $lopHoc->update($data);

        return redirect()->route('lop-hoc.index')->with('success', 'Lớp học đã được cập nhật thành công.');
    }

    /**
     * Xóa lớp học.
     */
    public function destroy(LopHoc $lopHoc)
    {
        $lopHoc->delete();

        return redirect()->route('lop-hoc.index')->with('success', 'Lớp học đã được xóa thành công.');
    }

    /**
     * Thêm học viên hoặc giáo viên vào lớp học (qua AJAX).
     */
    public function themHocVien(Request $request, LopHoc $lopHoc)
    {
        $request->validate([
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'vai_tro' => 'required|in:hoc_vien,giao_vien',
        ]);

        $exists = $lopHoc->tinHuus()
            ->wherePivot('tin_huu_id', $request->tin_huu_id)
            ->wherePivot('vai_tro', $request->vai_tro)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Tín hữu đã được thêm vào lớp học với vai trò này.',
            ], 422);
        }

        $lopHoc->tinHuus()->attach($request->tin_huu_id, ['vai_tro' => $request->vai_tro]);

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm tín hữu vào lớp học thành công.',
        ]);
    }

    /**
     * Xóa học viên hoặc giáo viên khỏi lớp học.
     */
    public function xoaHocVien(LopHoc $lopHoc, TinHuu $tinHuu)
    {
        $lopHoc->tinHuus()->detach($tinHuu->id);

        return redirect()->route('lop-hoc.show', $lopHoc)->with('success', 'Học viên đã được xóa khỏi lớp học.');
    }
}
