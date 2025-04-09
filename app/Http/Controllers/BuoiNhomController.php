<?php

namespace App\Http\Controllers;

use App\Models\BuoiNhom;
use App\Models\DienGia; // Thêm use DienGia
use App\Models\TinHuu; // Giữ lại nếu bạn vẫn dùng cho người hướng dẫn, thăm viếng
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BanNganh; // Thêm use BanNganh
use App\Models\BuoiNhomTo; // Thêm use BuoiNhomTo
use App\Models\BuoiNhomLich; // Thêm use BuoiNhomLich
use App\Models\TinHuuBanNganh; // Thêm use TinHuuBanNganh

class BuoiNhomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buoiNhoms = BuoiNhom::latest()->paginate(10);
        return view('_buoi_nhom.index', compact('buoiNhoms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banNganhs = BanNganh::all();
        $dienGias = DienGia::all();
        $lichBuoiNhoms = BuoiNhomLich::all(); // Lấy danh sách lịch
        return view('_buoi_nhom.create', compact('banNganhs', 'dienGias', 'lichBuoiNhoms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'lich_buoi_nhom_id' => 'required|exists:buoi_nhom_lich,id',
            'ban_nganh_id' => 'required|exists:ban_nganhs,id',
            'ngay_dien_ra' => 'required|date',
            'gio_bat_dau' => 'required|date_format:H:i',
            'gio_ket_thuc' => 'required|date_format:H:i|after:gio_bat_dau',
            'dia_diem' => 'nullable|string',
            'chu_de' => 'nullable|string',
            'dien_gia_id' => 'nullable|exists:dien_gias,id',
            'id_tin_huu_hdct' => 'nullable|exists:tin_huus,id',
            'id_tin_huu_do_kt' => 'nullable|exists:tin_huus,id',
            'ghi_chu' => 'nullable|string',
        ]);

        BuoiNhom::create($request->all());

        return redirect()->route('buoi_nhom.index')->with('success', 'Buổi nhóm đã được tạo thành công.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BuoiNhom  $buoiNhom
     * @return \Illuminate\Http\Response
     */
    public function show(BuoiNhom $buoiNhom)
    {
        return view('_buoi_nhom.show', compact('buoiNhom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BuoiNhom  $buoiNhom
     * @return \Illuminate\Http\Response
     */
    public function edit(BuoiNhom $buoiNhom)
    {
        $dienGias = DienGia::all(); // Lấy tất cả diễn giả
        $nguoiHuongDans = TinHuu::where('vai_tro', 'Hướng dẫn')->get(); // Giữ lại nếu cần
        $nguoiThamViengs = TinHuu::where('vai_tro', 'Thăm viếng')->get(); // Giữ lại nếu cần

        return view('_buoi_nhom.edit', compact('buoiNhom', 'dienGias', 'nguoiHuongDans', 'nguoiThamViengs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BuoiNhom  $buoiNhom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BuoiNhom $buoiNhom)
    {
        $request->validate([
            'lich_buoi_nhom_id' => 'required|exists:buoi_nhom_lich,id',
            'ban_nganh_id' => 'required|exists:ban_nganhs,id',
            'ngay_dien_ra' => 'required|date',
            'gio_bat_dau' => 'required|date_format:H:i',
            'gio_ket_thuc' => 'required|date_format:H:i|after:gio_bat_dau',
            'dia_diem' => 'nullable|string',
            'chu_de' => 'nullable|string',
            'dien_gia_id' => 'nullable|exists:dien_gias,id',
            'id_tin_huu_hdct' => 'nullable|exists:tin_huus,id',
            'id_tin_huu_do_kt' => 'nullable|exists:tin_huus,id',
            'ghi_chu' => 'nullable|string',
        ]);

        $buoiNhom->update($request->all());

        return redirect()->route('buoi_nhom.index')->with('success', 'Buổi nhóm đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BuoiNhom  $buoiNhom
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuoiNhom $buoiNhom)
    {
        $buoiNhom->delete();

        return redirect()->route('buoi_nhom.index')->with('success', 'Báo cáo đã được xóa thành công.');
    }
    public function getTinHuuByBanNganh($banNganhId)
    {
        $tinHuu = TinHuu::select('tin_huu.id', 'tin_huu.ho_ten')
            ->join('tin_huu_ban_nganh', 'tin_huu.id', '=', 'tin_huu_ban_nganh.tin_huu_id')
            ->where('tin_huu_ban_nganh.ban_nganh_id', $banNganhId)
            ->get();

        return response()->json($tinHuu);
    }

    public function getBuoiNhoms()
    {
        $buoiNhoms = BuoiNhom::with('dienGia')->get();
        return response()->json($buoiNhoms);
    }

    public function getBuoiNhom($id)
    {
        $buoiNhom = BuoiNhom::find($id);
        return response()->json($buoiNhom);
    }

    public function deleteBuoiNhom($id)
    {
        $buoiNhom = BuoiNhom::find($id);
        if ($buoiNhom) {
            $buoiNhom->delete();
            return response()->json(['success' => true, 'message' => 'Buổi nhóm đã được xóa.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy buổi nhóm.']);
        }
    }
}
