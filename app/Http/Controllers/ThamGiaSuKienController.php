<?php

namespace App\Http\Controllers;

use App\Models\ThamGiaSuKien;
use App\Models\SuKien;
use App\Models\TinHuu;
use Illuminate\Http\Request;

class ThamGiaSuKienController extends Controller
{
    public function index()
    {
        $thamGiaSuKiens = ThamGiaSuKien::all();
        return view('tham_gia_su_kien.index', compact('thamGiaSuKiens'));
    }

    public function create()
    {
           $suKiens = SuKien::all();
         $tinhuus = TinHuu::all();

        return view('tham_gia_su_kien.create', compact('suKiens','tinhuus'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
           'su_kien_id' => 'required|exists:su_kien,id',
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'trang_thai' => 'nullable|enum:dang_ky,co_mat,vang_mat',
        ]);

        ThamGiaSuKien::create($validatedData);

        return redirect()->route('tham-gia-su-kien.index')->with('success', 'Tham gia sự kiện đã được thêm thành công!');
    }

    public function show(ThamGiaSuKien $thamGiaSuKien)
    {
        return view('tham_gia_su_kien.show', compact('thamGiaSuKien'));
    }

    public function edit(ThamGiaSuKien $thamGiaSuKien)
    {
            $suKiens = SuKien::all();
         $tinhuus = TinHuu::all();

        return view('tham_gia_su_kien.edit', compact('thamGiaSuKien','suKiens','tinhuus'));
    }

    public function update(Request $request, ThamGiaSuKien $thamGiaSuKien)
    {
         $validatedData = $request->validate([
            'su_kien_id' => 'required|exists:su_kien,id',
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'trang_thai' => 'nullable|enum:dang_ky,co_mat,vang_mat',
        ]);

        $thamGiaSuKien->update($validatedData);

        return redirect()->route('tham-gia-su-kien.index')->with('success', 'Tham gia sự kiện đã được cập nhật thành công!');
    }

    public function destroy(ThamGiaSuKien $thamGiaSuKien)
    {
        $thamGiaSuKien->delete();
        return redirect()->route('tham-gia-su-kien.index')->with('success', 'Tham gia sự kiện đã được xóa thành công!');
    }
}