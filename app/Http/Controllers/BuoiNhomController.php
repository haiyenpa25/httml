<?php

namespace App\Http\Controllers;

use App\Models\BuoiNhom;
use App\Models\LichBuoiNhom;
use Illuminate\Http\Request;

class BuoiNhomController extends Controller
{
    public function index()
    {
        $buoiNhoms = BuoiNhom::all();
        return view('buoi_nhom.index', compact('buoiNhoms'));
    }

    public function create()
    {
        $lichBuoiNhoms = LichBuoiNhom::all();
        return view('buoi_nhom.create', compact('lichBuoiNhoms'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'lich_buoi_nhom_id' => 'required|exists:lich_buoi_nhom,id',
            'ngay_dien_ra' => 'required|date',
            'gio_bat_dau' => 'required|date_format:H:i',
            'gio_ket_thuc' => 'required|date_format:H:i',
            'dia_diem' => 'required|text',
            'so_luong_tham_gia' => 'nullable|integer',
            'ghi_chu' => 'nullable|text',
            'trang_thai' => 'nullable|enum:da_dien_ra,sap_dien_ra,huy',
        ]);

        BuoiNhom::create($validatedData);

        return redirect()->route('buoi-nhom.index')->with('success', 'Buổi nhóm đã được thêm thành công!');
    }

    public function show(BuoiNhom $buoiNhom)
    {
        return view('buoi_nhom.show', compact('buoiNhom'));
    }

    public function edit(BuoiNhom $buoiNhom)
    {
         $lichBuoiNhoms = LichBuoiNhom::all();
        return view('buoi_nhom.edit', compact('buoiNhom','lichBuoiNhoms'));
    }

    public function update(Request $request, BuoiNhom $buoiNhom)
    {
         $validatedData = $request->validate([
            'lich_buoi_nhom_id' => 'required|exists:lich_buoi_nhom,id',
            'ngay_dien_ra' => 'required|date',
            'gio_bat_dau' => 'required|date_format:H:i',
            'gio_ket_thuc' => 'required|date_format:H:i',
            'dia_diem' => 'required|text',
            'so_luong_tham_gia' => 'nullable|integer',
            'ghi_chu' => 'nullable|text',
            'trang_thai' => 'nullable|enum:da_dien_ra,sap_dien_ra,huy',
        ]);

        $buoiNhom->update($validatedData);

        return redirect()->route('buoi-nhom.index')->with('success', 'Buổi nhóm đã được cập nhật thành công!');
    }

    public function destroy(BuoiNhom $buoiNhom)
    {
        $buoiNhom->delete();
        return redirect()->route('buoi-nhom.index')->with('success', 'Buổi nhóm đã được xóa thành công!');
    }
}