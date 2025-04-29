<?php

namespace App\Http\Controllers;

use App\Models\GiaoDichTaiChinh;
use App\Models\BanNganh;
use Illuminate\Http\Request;

class GiaoDichTaiChinhController extends Controller
{
    public function index()
    {
        $giaoDichTaiChinhs = GiaoDichTaiChinh::all();
        return view('giao_dich_tai_chinh.index', compact('giaoDichTaiChinhs'));
    }

    public function create()
    {
         $banNganhs = BanNganh::all();
        return view('giao_dich_tai_chinh.create', compact('banNganhs'));
    }

    public function store(Request $request)
    {
         $validatedData = $request->validate([
            'loai' => 'required|enum:thu,chi',
            'so_tien' => 'required|numeric',
            'mo_ta' => 'required|text',
            'ngay_giao_dich' => 'required|date',
            'ban_nganh_id' => 'nullable|exists:ban_nganh,id',
        ]);

        GiaoDichTaiChinh::create($validatedData);

        return redirect()->route('giao-dich-tai-chinh.index')->with('success', 'Giao dịch tài chính đã được thêm thành công!');
    }

    public function show(GiaoDichTaiChinh $giaoDichTaiChinh)
    {
        return view('giao_dich_tai_chinh.show', compact('giaoDichTaiChinh'));
    }

    public function edit(GiaoDichTaiChinh $giaoDichTaiChinh)
    {
           $banNganhs = BanNganh::all();
        return view('giao_dich_tai_chinh.edit', compact('giaoDichTaiChinh','banNganhs'));
    }

    public function update(Request $request, GiaoDichTaiChinh $giaoDichTaiChinh)
    {
           $validatedData = $request->validate([
            'loai' => 'required|enum:thu,chi',
            'so_tien' => 'required|numeric',
            'mo_ta' => 'required|text',
            'ngay_giao_dich' => 'required|date',
            'ban_nganh_id' => 'nullable|exists:ban_nganh,id',
        ]);

        $giaoDichTaiChinh->update($validatedData);

        return redirect()->route('giao-dich-tai-chinh.index')->with('success', 'Giao dịch tài chính đã được cập nhật thành công!');
    }

    public function destroy(GiaoDichTaiChinh $giaoDichTaiChinh)
    {
        $giaoDichTaiChinh->delete();
        return redirect()->route('giao-dich-tai-chinh.index')->with('success', 'Giao dịch tài chính đã được xóa thành công!');
    }
    public function baoCao() {
        /* Tạo báo cáo tài chính */
    }
}