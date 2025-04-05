<?php

namespace App\Http\Controllers;

use App\Models\ChiTietThamGia;
use App\Models\BuoiNhom;
use App\Models\TinHuu;
use Illuminate\Http\Request;

class ChiTietThamGiaController extends Controller
{
    public function index()
    {
        $chiTietThamGias = ChiTietThamGia::all();
        return view('chi_tiet_tham_gia.index', compact('chiTietThamGias'));
    }

    public function create()
    {
         $buoiNhoms = BuoiNhom::all();
         $tinhuus = TinHuu::all();

        return view('chi_tiet_tham_gia.create',compact('buoiNhoms','tinhuus'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'buoi_nhom_id' => 'required|exists:buoi_nhom,id',
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'trang_thai' => 'nullable|enum:co_mat,vang_mat',
            'ghi_chu' => 'nullable|text',
        ]);

        ChiTietThamGia::create($validatedData);

        return redirect()->route('chi-tiet-tham-gia.index')->with('success', 'Chi tiết tham gia đã được thêm thành công!');
    }

    public function show(ChiTietThamGia $chiTietThamGia)
    {
        return view('chi_tiet_tham_gia.show', compact('chiTietThamGia'));
    }

    public function edit(ChiTietThamGia $chiTietThamGia)
    {
            $buoiNhoms = BuoiNhom::all();
         $tinhuus = TinHuu::all();

        return view('chi_tiet_tham_gia.edit', compact('chiTietThamGia','buoiNhoms','tinhuus'));
    }

    public function update(Request $request, ChiTietThamGia $chiTietThamGia)
    {
            $validatedData = $request->validate([
           'buoi_nhom_id' => 'required|exists:buoi_nhom,id',
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'trang_thai' => 'nullable|enum:co_mat,vang_mat',
            'ghi_chu' => 'nullable|text',
        ]);

        $chiTietThamGia->update($validatedData);

        return redirect()->route('chi-tiet-tham-gia.index')->with('success', 'Chi tiết tham gia đã được cập nhật thành công!');
    }

    public function destroy(ChiTietThamGia $chiTietThamGia)
    {
        $chiTietThamGia->delete();
        return redirect()->route('chi-tiet-tham-gia.index')->with('success', 'Chi tiết tham gia đã được xóa thành công!');
    }
}