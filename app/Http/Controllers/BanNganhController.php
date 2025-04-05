<?php

namespace App\Http\Controllers;

use App\Models\BanNganh;
use App\Models\TinHuu;
use Illuminate\Http\Request;

class BanNganhController extends Controller
{
    public function index()
    {
        $banNganhs = BanNganh::all();
        return view('_ban_nganh.index', compact('banNganhs'));
    }

    public function create()
    {
        $tinHuus = TinHuu::all();
        return view('_ban_nganh.create', compact('tinHuus'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ten' => 'required|max:255',
            'loai' => 'required|in:sinh_hoat,muc_vu',
            'mo_ta' => 'nullable|string',
            'truong_ban_id' => 'nullable|exists:tin_huu,id',
        ]);

        BanNganh::create($validatedData);

        return redirect()->route('_ban_nganh.index')->with('success', 'Ban ngành đã được thêm thành công!');
    }

    public function show(BanNganh $banNganh)
    {
        return view('_ban_nganh.show', compact('banNganh'));
    }

    public function edit(BanNganh $banNganh)
    {
        $tinHuus = TinHuu::all();
        return view('_ban_nganh.edit', compact('banNganh', 'tinHuus'));
    }

    public function update(Request $request, BanNganh $banNganh)
    {
        $validatedData = $request->validate([
            'ten' => 'required|max:255',
            'loai' => 'required|in:sinh_hoat,muc_vu',
            'mo_ta' => 'nullable|string',
            'truong_ban_id' => 'nullable|exists:tin_huu,id',
        ]);

        $banNganh->update($validatedData);

        return redirect()->route('_ban_nganh.index')->with('success', 'Ban ngành đã được cập nhật thành công!');
    }

    public function destroy(BanNganh $banNganh)
    {
        $banNganh->delete();
        return redirect()->route('_ban_nganh.index')->with('success', 'Ban ngành đã được xóa thành công!');
    }
}
