<?php

namespace App\Http\Controllers;

use App\Models\BanNganh;
use App\Models\TinHuu;
use Illuminate\Http\Request;

class BanNganhController2 extends Controller
{
    /**
     * Danh sách tất cả Ban Ngành
     */
    public function index()
    {
        $banNganhs = BanNganh::all();
        return view('_ban_nganh.index', compact('banNganhs'));
    }

    /**
     * Form tạo mới Ban Ngành
     */
    public function create()
    {
        $tinHuus = TinHuu::all();
        return view('_ban_nganh.create', compact('tinHuus'));
    }

    /**
     * Lưu thông tin Ban Ngành mới
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ten' => 'required|max:255',
            'loai' => 'required|in:sinh_hoat,muc_vu',
            'mo_ta' => 'nullable|string',
            'truong_ban_id' => 'nullable|exists:tin_huu,id',
        ]);

        BanNganh::create($validatedData);

        return redirect()->route('_ban_nganh.index')->with('success', 'Ban ngành đã được thêm thành công!');
    }

    /**
     * Xem chi tiết Ban Ngành
     */
    public function show(BanNganh $danh_sach)
    {
        $banNganh = $danh_sach; // Đặt lại biến cho khớp với view
        return view('_ban_nganh.show', compact('banNganh'));
    }

    /**
     * Form chỉnh sửa Ban Ngành
     */
    public function edit(BanNganh $danh_sach)
    {
        $banNganh = $danh_sach;
        $tinHuus = TinHuu::all();

        return view('_ban_nganh.edit', compact('banNganh', 'tinHuus'));
    }

    /**
     * Cập nhật Ban Ngành
     */
    public function update(Request $request, BanNganh $danh_sach)
    {
        $validatedData = $request->validate([
            'ten' => 'required|max:255',
            'loai' => 'required|in:sinh_hoat,muc_vu',
            'mo_ta' => 'nullable|string',
            'truong_ban_id' => 'nullable|exists:tin_huu,id',
        ]);

        $danh_sach->update($validatedData);

        return redirect()->route('_ban_nganh.index')->with('success', 'Ban ngành đã được cập nhật thành công!');
    }

    /**
     * Xóa Ban Ngành
     */
    public function destroy(BanNganh $danh_sach)
    {
        $danh_sach->delete();

        return redirect()->route('_ban_nganh.index')->with('success', 'Ban ngành đã được xóa thành công!');
    }
}
