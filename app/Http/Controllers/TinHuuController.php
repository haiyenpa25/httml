<?php

namespace App\Http\Controllers;

use App\Models\TinHuu;
use App\Models\HoGiaDinh;
use Illuminate\Http\Request;

class TinHuuController extends Controller
{
    public function index()
    {
        $tinHuuS = TinHuu::all();
        return view('tin_huu.index', compact('tinHuuS'));
    }

    public function create()
    {
        $hoGiaDinhs = HoGiaDinh::all();
        return view('tin_huu.create',compact('hoGiaDinhs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ho_ten' => 'required|max:255',
            'ngay_sinh' => 'required|date',
            'dia_chi' => 'required|text',
            'so_dien_thoai' => 'required|max:20',
            'loai_tin_huu' => 'required|enum:tin_huu_chinh_thuc,tan_tin_huu,tin_huu_ht_khac',
            'gioi_tinh' => 'required|enum:nam,nu',
            'tinh_trang_hon_nhan' => 'required|enum:doc_than,ket_hon',
            'ho_gia_dinh_id' => 'nullable|exists:ho_gia_dinh,id',
        ]);

        TinHuu::create($validatedData);

        return redirect()->route('tin-huu.index')->with('success', 'Tín hữu đã được thêm thành công!');
    }

    public function show(TinHuu $tinHuu)
    {
        return view('tin_huu.show', compact('tinHuu'));
    }

    public function edit(TinHuu $tinHuu)
    {
         $hoGiaDinhs = HoGiaDinh::all();
        return view('tin_huu.edit', compact('tinHuu','hoGiaDinhs'));
    }

    public function update(Request $request, TinHuu $tinHuu)
    {
        $validatedData = $request->validate([
           'ho_ten' => 'required|max:255',
            'ngay_sinh' => 'required|date',
            'dia_chi' => 'required|text',
            'so_dien_thoai' => 'required|max:20',
            'loai_tin_huu' => 'required|enum:tin_huu_chinh_thuc,tan_tin_huu,tin_huu_ht_khac',
            'gioi_tinh' => 'required|enum:nam,nu',
            'tinh_trang_hon_nhan' => 'required|enum:doc_than,ket_hon',
            'ho_gia_dinh_id' => 'nullable|exists:ho_gia_dinh,id',
        ]);

        $tinHuu->update($validatedData);

        return redirect()->route('tin-huu.index')->with('success', 'Tín hữu đã được cập nhật thành công!');
    }

    public function destroy(TinHuu $tinHuu)
    {
        $tinHuu->delete();
        return redirect()->route('tin-huu.index')->with('success', 'Tín hữu đã được xóa thành công!');
    }

    public function danhSachNhanSu()
    {
        $nhanSu = TinHuu::where('vai_tro', '!=', 'thanh_vien')->get(); // Ví dụ: Lấy tất cả người dùng không phải là thành viên
        return view('tin_huu.nhan_su', compact('nhanSu'));
    }
}