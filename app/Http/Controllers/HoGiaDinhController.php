<?php

namespace App\Http\Controllers;

use App\Models\HoGiaDinh;
use Illuminate\Http\Request;

class HoGiaDinhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hoGiaDinhs = HoGiaDinh::all();
        return view('_ho_gia_dinh.index', compact('hoGiaDinhs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('_ho_gia_dinh.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'so_ho' => 'required|max:50|unique:ho_gia_dinh',
            'dia_chi' => 'required|string', // Corrected to 'string'
        ]);

        HoGiaDinh::create($validatedData);

        return redirect()->route('_ho_gia_dinh.index')->with('success', 'Hộ gia đình đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(HoGiaDinh $hoGiaDinh)
    {
        return view('_ho_gia_dinh.show', compact('hoGiaDinh'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HoGiaDinh $hoGiaDinh)
    {
        return view('_ho_gia_dinh.edit', compact('hoGiaDinh'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HoGiaDinh $hoGiaDinh)
    {
        $validatedData = $request->validate([
            'so_ho' => 'required|max:50|unique:ho_gia_dinh,so_ho,' . $hoGiaDinh->id,
            'dia_chi' => 'required|string', // Corrected to 'string'
        ]);
        

        $hoGiaDinh->update($validatedData);

        return redirect()->route('_ho_gia_dinh.index')->with('success', 'Hộ gia đình đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HoGiaDinh $hoGiaDinh)
    {
        $hoGiaDinh->delete();
        return redirect()->route('_ho_gia_dinh.index')->with('success', 'Hộ gia đình đã được xóa thành công!');
    }
}