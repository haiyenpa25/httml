<?php

namespace App\Http\Controllers;

use App\Models\TaiLieu;
use App\Models\TinHuu;
use Illuminate\Http\Request;

class TaiLieuController extends Controller
{
    public function index()
    {
        $taiLieus = TaiLieu::all();
        return view('tai_lieu.index', compact('taiLieus'));
    }

    public function create()
    {
              $tinhuus = TinHuu::all();

        return view('tai_lieu.create',compact('tinhuus'));
    }

    public function store(Request $request)
    {
         $validatedData = $request->validate([
           'tieu_de' => 'required|max:255',
            'duong_dan_tai_lieu' => 'required|max:255',
            'danh_muc' => 'required|max:100',
            'nguoi_tai_len_id' => 'required|exists:tin_huu,id',
        ]);

        TaiLieu::create($validatedData);

        return redirect()->route('tai-lieu.index')->with('success', 'Tài liệu đã được thêm thành công!');
    }

    public function show(TaiLieu $taiLieu)
    {
        return view('tai_lieu.show', compact('taiLieu'));
    }

    public function edit(TaiLieu $taiLieu)
    {
           $tinhuus = TinHuu::all();

        return view('tai_lieu.edit', compact('taiLieu','tinhuus'));
    }

    public function update(Request $request, TaiLieu $taiLieu)
    {
           $validatedData = $request->validate([
             'tieu_de' => 'required|max:255',
            'duong_dan_tai_lieu' => 'required|max:255',
            'danh_muc' => 'required|max:100',
            'nguoi_tai_len_id' => 'required|exists:tin_huu,id',
        ]);

        $taiLieu->update($validatedData);

        return redirect()->route('tai-lieu.index')->with('success', 'Tài liệu đã được cập nhật thành công!');
    }

    public function destroy(TaiLieu $taiLieu)
    {
        $taiLieu->delete();
        return redirect()->route('tai-lieu.index')->with('success', 'Tài liệu đã được xóa thành công!');
    }
}