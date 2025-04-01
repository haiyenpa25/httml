<?php

namespace App\Http\Controllers;

use App\Models\LichSuBaoTri;
use App\Models\ThietBi;
use Illuminate\Http\Request;

class LichSuBaoTriController extends Controller
{
    public function index()
    {
        $lichSuBaoTris = LichSuBaoTri::all();
        return view('lich_su_bao_tri.index', compact('lichSuBaoTris'));
    }

    public function create()
    {
         $thietBis = ThietBi::all();
        return view('lich_su_bao_tri.create', compact('thietBis'));
    }

    public function store(Request $request)
    {
         $validatedData = $request->validate([
           'thiet_bi_id' => 'required|exists:thiet_bi,id',
            'ngay_bao_tri' => 'required|date',
            'chi_phi' => 'nullable|numeric',
            'nguoi_thuc_hien' => 'required|max:255',
            'mo_ta' => 'nullable|text',
        ]);

        LichSuBaoTri::create($validatedData);

        return redirect()->route('lich-su-bao-tri.index')->with('success', 'Lịch sử bảo trì đã được thêm thành công!');
    }

    public function show(LichSuBaoTri $lichSuBaoTri)
    {
        return view('lich_su_bao_tri.show', compact('lichSuBaoTri'));
    }

    public function edit(LichSuBaoTri $lichSuBaoTri)
    {
        $thietBis = ThietBi::all();
        return view('lich_su_bao_tri.edit', compact('lichSuBaoTri', 'thietBis'));
    }

    public function update(Request $request, LichSuBaoTri $lichSuBaoTri)
    {
          $validatedData = $request->validate([
            'thiet_bi_id' => 'required|exists:thiet_bi,id',
            'ngay_bao_tri' => 'required|date',
            'chi_phi' => 'nullable|numeric',
            'nguoi_thuc_hien' => 'required|max:255',
            'mo_ta' => 'nullable|text',
        ]);

        $lichSuBaoTri->update($validatedData);

        return redirect()->route('lich-su-bao-tri.index')->with('success', 'Lịch sử bảo trì đã được cập nhật thành công!');
    }

    public function destroy(LichSuBaoTri $lichSuBaoTri)
    {
        $lichSuBaoTri->delete();
        return redirect()->route('lich-su-bao-tri.index')->with('success', 'Lịch sử bảo trì đã được xóa thành công!');
    }
}