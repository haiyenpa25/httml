<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaoLopHocRequest;
use App\Http\Requests\UpdateLopHocRequest;
use App\Models\LopHoc;
use App\Models\TinHuu;
use App\Models\NguoiDungPhanQuyen;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LopHocController extends Controller
{
    protected function checkPermission($permission)
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }
        return NguoiDungPhanQuyen::where('nguoi_dung_id', $user->id)
            ->where('quyen', $permission)
            ->exists();
    }

    public function index(Request $request)
    {
        if (!$this->checkPermission('view-lop-hoc')) {
            abort(403, 'Bạn không có quyền xem danh sách lớp học.');
        }

        if ($request->ajax()) {
            $lopHocs = LopHoc::query();
            return DataTables::of($lopHocs)
                ->addColumn('action', fn($lopHoc) => view('lop-hoc.partials.actions', compact('lopHoc'))->render())
                ->make(true);
        }

        return view('lop-hoc.index');
    }

    public function create()
    {
        if (!$this->checkPermission('create-lop-hoc')) {
            abort(403, 'Bạn không có quyền tạo lớp học.');
        }

        return view('lop-hoc.create');
    }

    public function store(TaoLopHocRequest $request)
    {
        $lopHoc = LopHoc::create($request->validated());
        return redirect()->route('lop-hoc.index')->with('success', 'Lớp học đã được tạo.');
    }

    public function edit(LopHoc $lopHoc)
    {
        if (!$this->checkPermission('edit-lop-hoc')) {
            abort(403, 'Bạn không có quyền sửa lớp học.');
        }

        return view('lop-hoc.edit', compact('lopHoc'));
    }

    public function update(UpdateLopHocRequest $request, LopHoc $lopHoc)
    {
        $lopHoc->update($request->validated());
        return redirect()->route('lop-hoc.index')->with('success', 'Lớp học đã được cập nhật.');
    }

    public function destroy(LopHoc $lopHoc)
    {
        if (!$this->checkPermission('delete-lop-hoc')) {
            abort(403, 'Bạn không có quyền xóa lớp học.');
        }

        $lopHoc->delete();
        return redirect()->route('lop-hoc.index')->with('success', 'Lớp học đã được xóa.');
    }

    public function themHocVien(Request $request, LopHoc $lopHoc)
    {
        if (!$this->checkPermission('manage-hoc-vien')) {
            abort(403, 'Bạn không có quyền thêm học viên.');
        }

        $request->validate(['tin_huu_id' => 'required|exists:tin_huu,id']);
        $lopHoc->tinHuus()->attach($request->tin_huu_id, ['vai_tro' => 'hoc_vien']);
        return redirect()->route('lop-hoc.show', $lopHoc)->with('success', 'Học viên đã được thêm.');
    }

    public function xoaHocVien(LopHoc $lopHoc, TinHuu $tinHuu)
    {
        if (!$this->checkPermission('manage-hoc-vien')) {
            abort(403, 'Bạn không có quyền xóa học viên.');
        }

        $lopHoc->tinHuus()->detach($tinHuu->id);
        return redirect()->route('lop-hoc.show', $lopHoc)->with('success', 'Học viên đã được xóa.');
    }
}
