<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaoLopHocRequest;
use App\Http\Requests\UpdateLopHocRequest;
use App\Models\LopHoc;
use App\Models\TinHuu;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class LopHocController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = LopHoc::query();

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

            return DataTables::of($query)
                ->addColumn('action', fn($lopHoc) => '') // Client-side xử lý
                ->make(true);
        }

        return view('_lop_hoc.index');
    }

    public function create()
    {
        return view('_lop_hoc.create');
    }

    public function store(TaoLopHocRequest $request)
    {
        $data = $request->validated();
        LopHoc::create($data);

        return redirect()->route('lop-hoc.index')->with('success', 'Lớp học đã được tạo thành công.');
    }

    public function show(LopHoc $lopHoc)
    {
        return view('_lop_hoc.show', compact('lopHoc'));
    }

    public function edit(LopHoc $lopHoc)
    {
        return view('_lop_hoc.edit', compact('lopHoc'));
    }

    public function update(UpdateLopHocRequest $request, LopHoc $lopHoc)
    {
        $data = $request->validated();
        $lopHoc->update($data);

        return redirect()->route('lop-hoc.index')->with('success', 'Lớp học đã được cập nhật thành công.');
    }

    public function destroy(LopHoc $lopHoc)
    {
        $lopHoc->delete();

        return redirect()->route('lop-hoc.index')->with('success', 'Lớp học đã được xóa thành công.');
    }

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

    public function xoaHocVien(LopHoc $lopHoc, TinHuu $tinHuu)
    {
        try {
            $lopHoc->tinHuus()->detach($tinHuu->id);
            return response()->json(['success' => true, 'message' => 'Học viên đã được xóa khỏi lớp học.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi khi xóa học viên'], 500);
        }
    }

    public function getThanhVien(Request $request, LopHoc $lopHoc)
    {
        if ($request->ajax()) {
            $query = $lopHoc->tinHuus()->select('tin_huus.id as tin_huu_id', 'tin_huus.ho_ten', 'lop_hoc_tin_huu.vai_tro');
            return DataTables::of($query)
                ->addIndexColumn()
                ->make(true);
        }
        return response()->json(['success' => false, 'message' => 'Yêu cầu không hợp lệ'], 400);
    }
}
