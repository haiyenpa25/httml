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

        return view('chi_tiet_tham_gia.create', compact('buoiNhoms', 'tinhuus'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'buoi_nhom_id' => 'required|exists:buoi_nhom,id',
            'chi_tiet' => 'required|array',
            'chi_tiet.*.tin_huu_id' => 'required|exists:tin_huu,id',
            'chi_tiet.*.trang_thai' => 'in:co_mat,vang_mat,vang_khong_phep',
            'chi_tiet.*.ghi_chu' => 'nullable|string'
        ]);

        // Xóa điểm danh cũ nếu có
        ChiTietThamGia::where('buoi_nhom_id', $validatedData['buoi_nhom_id'])->delete();

        // Tạo điểm danh mới
        $chiTietThamGia = [];
        foreach ($validatedData['chi_tiet'] as $chiTiet) {
            $chiTietThamGia[] = ChiTietThamGia::create([
                'buoi_nhom_id' => $validatedData['buoi_nhom_id'],
                'tin_huu_id' => $chiTiet['tin_huu_id'],
                'trang_thai' => $chiTiet['trang_thai'] ?? 'co_mat',
                'ghi_chu' => $chiTiet['ghi_chu'] ?? null
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Điểm danh thành công',
            'data' => $chiTietThamGia
        ]);
    }

    public function getDanhSachTinHuu(Request $request, $buoiNhomId)
    {
        // Lấy danh sách tín hữu của ban ngành trong buổi nhóm
        $buoiNhom = BuoiNhom::findOrFail($buoiNhomId);

        $tinHuus = TinHuu::join('tin_huu_ban_nganh', 'tin_huu.id', '=', 'tin_huu_ban_nganh.tin_huu_id')
            ->where('tin_huu_ban_nganh.ban_nganh_id', $buoiNhom->ban_nganh_id)
            ->select('tin_huu.id', 'tin_huu.ho_ten', 'tin_huu.gioi_tinh')
            ->get();

        // Kiểm tra điểm danh đã tồn tại chưa
        $chiTietThamGia = ChiTietThamGia::where('buoi_nhom_id', $buoiNhomId)->get()->keyBy('tin_huu_id');

        $tinHuus = $tinHuus->map(function ($tinHuu) use ($chiTietThamGia) {
            $chiTiet = $chiTietThamGia->get($tinHuu->id);
            return [
                'id' => $tinHuu->id,
                'ho_ten' => $tinHuu->ho_ten,
                'gioi_tinh' => $tinHuu->gioi_tinh,
                'trang_thai' => $chiTiet ? $chiTiet->trang_thai : 'co_mat',
                'ghi_chu' => $chiTiet ? $chiTiet->ghi_chu : ''
            ];
        });

        return response()->json($tinHuus);
    }

    public function show(ChiTietThamGia $chiTietThamGia)
    {
        return view('chi_tiet_tham_gia.show', compact('chiTietThamGia'));
    }

    public function edit(ChiTietThamGia $chiTietThamGia)
    {
        $buoiNhoms = BuoiNhom::all();
        $tinhuus = TinHuu::all();

        return view('chi_tiet_tham_gia.edit', compact('chiTietThamGia', 'buoiNhoms', 'tinhuus'));
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
