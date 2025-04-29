<?php

namespace App\Http\Controllers;

use App\Models\SuKien;
use Illuminate\Http\Request;

class SuKienController extends Controller
{
    public function index()
    {
        $suKiens = SuKien::all();
        return view('su_kien.index', compact('suKiens'));
    }

    public function create()
    {
        return view('su_kien.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ten' => 'required|max:255',
            'ngay_gio' => 'required|date',
            'dia_diem' => 'required|text',
            'mo_ta' => 'nullable|text',
        ]);

        SuKien::create($validatedData);

        return redirect()->route('su-kien.index')->with('success', 'Sự kiện đã được thêm thành công!');
    }

    public function show(SuKien $suKien)
    {
        return view('su_kien.show', compact('suKien'));
    }

    public function edit(SuKien $suKien)
    {
        return view('su_kien.edit', compact('suKien'));
    }

    public function update(Request $request, SuKien $suKien)
    {
         $validatedData = $request->validate([
             'ten' => 'required|max:255',
            'ngay_gio' => 'required|date',
            'dia_diem' => 'required|text',
            'mo_ta' => 'nullable|text',
        ]);

        $suKien->update($validatedData);

        return redirect()->route('su-kien.index')->with('success', 'Sự kiện đã được cập nhật thành công!');
    }

    public function destroy(SuKien $suKien)
    {
        $suKien->delete();
        return redirect()->route('su-kien.index')->with('success', 'Sự kiện đã được xóa thành công!');
    }
}