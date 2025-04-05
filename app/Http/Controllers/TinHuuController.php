<?php

namespace App\Http\Controllers;
enum LoaiTinHuu: string
{
    case CHINH_THUC = 'tin_huu_chinh_thuc';
    case TAN = 'tan_tin_huu';
    case KHAC = 'tin_huu_ht_khac';
}

enum GioiTinh: string
{
    case NAM = 'nam';
    case NU = 'nu';
}

enum TinhTrangHonNhan: string
{
    case DOC_THAN = 'doc_than';
    case KET_HON = 'ket_hon';
}

use App\Models\TinHuu;
use App\Models\HoGiaDinh;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class TinHuuController extends Controller
{
    public function index()
    {
        $tinHuuS = TinHuu::all();
        return view('_tin_huu.index', compact('tinHuuS'));
    }

    public function create()
    {
        $hoGiaDinhs = HoGiaDinh::all();
        return view('_tin_huu.create',compact('hoGiaDinhs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ho_ten' => 'required|max:255',
            'ngay_sinh' => 'required|date',
            'dia_chi' => 'required|string',
            'so_dien_thoai' => 'required|max:20',
            'loai_tin_huu' => ['required', Rule::enum(LoaiTinHuu::class)], // Sửa lại như này
            'gioi_tinh' => ['required', Rule::enum(GioiTinh::class)], // Sửa lại như này
            'tinh_trang_hon_nhan' => ['required', Rule::enum(TinhTrangHonNhan::class)], // Sửa lại như này
            'ho_gia_dinh_id' => 'nullable|exists:ho_gia_dinh,id',
        ]);

        TinHuu::create($validatedData);

        return redirect()->route('_tin_huu.index')->with('success', 'Tín hữu đã được thêm thành công!');
    }

    public function show(TinHuu $tinHuu)
    {
        return view('_tin_huu.show', compact('tinHuu'));
    }

    public function edit(TinHuu $tinHuu)
    {
         $hoGiaDinhs = HoGiaDinh::all();
        return view('_tin_huu.edit', compact('tinHuu','hoGiaDinhs'));
    }

    public function update(Request $request, TinHuu $tinHuu)
    {
        $validatedData = $request->validate([
            'ho_ten' => 'required|max:255',
            'ngay_sinh' => 'required|date',
            'dia_chi' => 'required|string',
            'so_dien_thoai' => 'required|max:20',
            'loai_tin_huu' => ['required', Rule::enum(LoaiTinHuu::class)], // Sửa lại như này
            'gioi_tinh' => ['required', Rule::enum(GioiTinh::class)], // Sửa lại như này
            'tinh_trang_hon_nhan' => ['required', Rule::enum(TinhTrangHonNhan::class)], // Sửa lại như này
            'ho_gia_dinh_id' => 'nullable|exists:ho_gia_dinh,id',
        ]);

        $tinHuu->update($validatedData);

        return redirect()->route('_tin_huu.index')->with('success', 'Tín hữu đã được cập nhật thành công!');
    }

    public function destroy(TinHuu $tinHuu)
    {
        $tinHuu->delete();
        return redirect()->route('_tin_huu.index')->with('success', 'Tín hữu đã được xóa thành công!');
    }

    public function danhSachNhanSu()
    {
        $nhanSu = TinHuu::where('vai_tro', '!=', 'thanh_vien')->get(); // Ví dụ: Lấy tất cả người dùng không phải là thành viên
        return view('_tin_huu.nhan_su', compact('nhanSu'));
    }
}