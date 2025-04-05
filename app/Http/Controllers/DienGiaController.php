<?php

namespace App\Http\Controllers;

use App\Models\DienGia;
use Illuminate\Http\Request;

class DienGiaController extends Controller
{
    public function index()
    {
        $dienGias = DienGia::all();
        return view('_dien_gia.index', compact('dienGias'));
    }

    public function create()
    {
        return view('_dien_gia.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ho_ten' => 'required|string|max:255',
            'chuc_danh' => 'required|in:Thầy,Cô,Mục sư,Mục sư nhiệm chức,Truyền Đạo,Chấp Sự',
            'hoi_thanh' => 'nullable|string|max:255',
            'dia_chi' => 'nullable|string|max:255',
            'so_dien_thoai' => 'nullable|string|max:20',
        ]);

        DienGia::create($validated);

        return redirect()->route('_dien_gia.index')->with('success', 'Thêm diễn giả thành công.');
    }

    public function show(DienGia $dienGia)
{
    return view('_dien_gia.show', compact('dienGia'));
}

public function edit(DienGia $dienGia)
{
    return view('_dien_gia.edit', compact('dienGia'));
}

public function update(Request $request, DienGia $dienGia)
{
    $validated = $request->validate([
        'ho_ten' => 'required|string|max:255',
        'chuc_danh' => 'required|in:Thầy,Cô,Mục sư,Mục sư nhiệm chức,Truyền Đạo,Chấp Sự',
        'hoi_thanh' => 'nullable|string|max:255',
        'dia_chi' => 'nullable|string|max:255',
        'so_dien_thoai' => 'nullable|string|max:20',
    ]);

    $dienGia->update($validated);

    return redirect()->route('_dien_gia.index')->with('success', 'Cập nhật thành công.');
}

public function destroy(DienGia $dienGia)
{
    $dienGia->delete();

    return redirect()->route('_dien_gia.index')->with('success', 'Xóa diễn giả thành công.');
}
}
