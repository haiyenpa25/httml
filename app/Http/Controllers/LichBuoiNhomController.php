<?php

namespace App\Http\Controllers;

use App\Models\LichBuoiNhom;
use App\Models\BanNganh;
use Illuminate\Http\Request;

class LichBuoiNhomController extends Controller
{
    public function index()
    {
        $lichBuoiNhoms = LichBuoiNhom::all();
        return view('lich_buoi_nhom.index', compact('lichBuoiNhoms'));
    }

    public function create()
    {
        $banNganhs = BanNganh::all(); // Lấy danh sách ban ngành để hiển thị trong select box
        return view('lich_buoi_nhom.create', compact('banNganhs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ten' => 'required|max:255',
            'loai' => 'required|enum:hoi_thanh,ban_nganh,truyen_giang',
            'ban_nganh_id' => 'nullable|exists:ban_nganh,id',
            'thu' => 'required|enum:thu_2,thu_3,thu_4,thu_5,thu_6,thu_7,chu_nhat',
            'gio_bat_dau' => 'required|date_format:H:i',
            'gio_ket_thuc' => 'required|date_format:H:i',
            'tan_suat' => 'required|enum:hang_tuan,tuan_cuoi_thang',
            'dia_diem' => 'required|text',
            'mo_ta' => 'nullable|text',
        ]);

        LichBuoiNhom::create($validatedData);

        return redirect()->route('lich-buoi-nhom.index')->with('success', 'Lịch buổi nhóm đã được thêm thành công!');
    }

    public function show(LichBuoiNhom $lichBuoiNhom)
    {
        return view('lich_buoi_nhom.show', compact('lichBuoiNhom'));
    }

    public function edit(LichBuoiNhom $lichBuoiNhom)
    {
        $banNganhs = BanNganh::all();
        return view('lich_buoi_nhom.edit', compact('lichBuoiNhom', 'banNganhs'));
    }

    public function update(Request $request, LichBuoiNhom $lichBuoiNhom)
    {
        $validatedData = $request->validate([
            'ten' => 'required|max:255',
            'loai' => 'required|enum:hoi_thanh,ban_nganh,truyen_giang',
            'ban_nganh_id' => 'nullable|exists:ban_nganh,id',
            'thu' => 'required|enum:thu_2,thu_3,thu_4,thu_5,thu_6,thu_7,chu_nhat',
            'gio_bat_dau' => 'required|date_format:H:i',
            'gio_ket_thuc' => 'required|date_format:H:i',
            'tan_suat' => 'required|enum:hang_tuan,tuan_cuoi_thang',
            'dia_diem' => 'required|text',
            'mo_ta' => 'nullable|text',
        ]);

        $lichBuoiNhom->update($validatedData);

        return redirect()->route('lich-buoi-nhom.index')->with('success', 'Lịch buổi nhóm đã được cập nhật thành công!');
    }

    public function destroy(LichBuoiNhom $lichBuoiNhom)
    {
        $lichBuoiNhom->delete();
        return redirect()->route('lich-buoi-nhom.index')->with('success', 'Lịch buổi nhóm đã được xóa thành công!');
    }
}