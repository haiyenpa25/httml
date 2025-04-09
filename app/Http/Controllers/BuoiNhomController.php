<?php

namespace App\Http\Controllers;

use App\Models\BuoiNhom;
use App\Models\BuoiNhomLich;
use App\Models\BuoiNhomTo;
use Illuminate\Http\Request;

class BuoiNhomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buoiNhoms = BuoiNhom::with(['lichBuoiNhom', 'to', 'tinHuuHdct', 'tinHuuDoKt', 'dienGia'])->latest()->paginate(10);
        return view('_buoi_nhom.index', compact('buoiNhoms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lichBuoiNhoms = BuoiNhomLich::all();
        $buoiNhomsTo = BuoiNhomTo::all();
        // Giả định bạn có cách lấy danh sách tín hữu
        $tinHuu = []; // Thay bằng cách lấy dữ liệu thực tế
        return view('_buoi_nhom.create', compact('lichBuoiNhoms', 'buoiNhomsTo', 'tinHuu'));
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
            'ngay_dien_ra' => 'required|date',
            'gio_bat_dau' => 'required|date_format:H:i:s',
            'gio_ket_thuc' => 'required|date_format:H:i:s|after:gio_bat_dau',
            'dia_diem' => 'required|string',
            // Các validation khác tùy theo yêu cầu
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
        $lichBuoiNhoms = BuoiNhomLich::all();
        $buoiNhomsTo = BuoiNhomTo::all();
        // Giả định bạn có cách lấy danh sách tín hữu
        $tinHuu = []; // Thay bằng cách lấy dữ liệu thực tế
        return view('_buoi_nhom.edit', compact('buoiNhom', 'lichBuoiNhoms', 'buoiNhomsTo', 'tinHuu'));
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
            'ngay_dien_ra' => 'required|date',
            'gio_bat_dau' => 'required|date_format:H:i:s',
            'gio_ket_thuc' => 'required|date_format:H:i:s|after:gio_bat_dau',
            'dia_diem' => 'required|string',
            // Các validation khác tùy theo yêu cầu
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
        return redirect()->route('buoi_nhom.index')->with('success', 'Buổi nhóm đã được xóa thành công.');
    }
}
