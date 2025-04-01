<?php

namespace App\Http\Controllers;

use App\Models\HoGiaDinh;
use Illuminate\Http\Request;

class HoGiaDinhController extends Controller
{
    public function index()
    {
        $hoGiaDinhs = HoGiaDinh::all();
        return view('ho_gia_dinh.index', compact('hoGiaDinhs'));
    }

    public function create()
    {
        return view('ho_gia_dinh.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'so_ho' => 'required|max:50|unique:ho_gia_dinh,so_ho',
            'dia_chi' => 'required|text',
        ]);

        HoGiaDinh::create($validatedData);

        return redirect()->route('ho-gia-dinh.index')->with('success', 'Hộ gia đình đã được thêm thành công!');
    }

    public function show(HoGiaDinh $hoGiaDinh)
    {
        return view('ho_gia_dinh.show', compact('hoGiaDinh'));
    }

    public function edit(HoGiaDinh $hoGiaDinh)
    {
        return view('ho_gia_dinh.edit', compact('hoGiaDinh'));
    }

    public function update(Request $request, HoGiaDinh $hoGiaDinh)
    {
        $validatedData = $request->validate([
            'so_ho' => 'required|max:50|unique:ho_gia_dinh,so_ho,' . $hoGiaDinh->id,
            'dia_chi' => 'required|text',
        ]);

        $hoGiaDinh->update($validatedData);

        return redirect()->route('ho-gia-dinh.index')->with('success', 'Hộ gia đình đã được cập nhật thành công!');
    }

    public function destroy(HoGiaDinh $hoGiaDinh)
    {
        $hoGiaDinh->delete();
        return redirect()->route('ho-gia-dinh.index')->with('success', 'Hộ gia đình đã được xóa thành công!');
    }
}