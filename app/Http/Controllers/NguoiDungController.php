<?php

namespace App\Http\Controllers;

enum VaiTro: string
{
    case QUAN_TRI = 'quan_tri';
    case TRUONG_BAN = 'truong_ban';
    case THANH_VIEN = 'thanh_vien';
}

use App\Models\NguoiDung;
use App\Models\TinHuu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Thêm để mã hóa mật khẩu
use Illuminate\Validation\Rule;

class NguoiDungController extends Controller
{
    public function index()
    {
        $nguoiDungs = NguoiDung::all();
        return view('nguoi_dung.index', compact('nguoiDungs'));
    }

    public function create()
    {
        $tinHuuS = TinHuu::all();
        return view('nguoi_dung.create', compact('tinHuuS'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tin_huu_id' => 'required|exists:tin_huu,id|unique:nguoi_dung,tin_huu_id',
            'email' => 'required|email|unique:nguoi_dung,email',
            'mat_khau' => 'required|min:6',
            'vai_tro' => ['nullable', Rule::enum(VaiTro::class)], // Sửa dòng này
        ]);

        $validatedData['mat_khau'] = Hash::make($validatedData['mat_khau']); // Mã hóa mật khẩu

        NguoiDung::create($validatedData);

        return redirect()->route('nguoi_dung.index')->with('success', 'Người dùng đã được thêm thành công!');
    }

    public function show(NguoiDung $nguoiDung)
    {
        return view('nguoi_dung.show', compact('nguoiDung'));
    }

    public function edit(NguoiDung $nguoiDung)
    {
        $tinHuuS = TinHuu::all();
        return view('nguoi_dung.edit', compact('nguoiDung', 'tinHuuS'));
    }

    public function update(Request $request, NguoiDung $nguoiDung)
    {
        $validatedData = $request->validate([
            'tin_huu_id' => 'required|exists:tin_huu,id|unique:nguoi_dung,tin_huu_id,' . $nguoiDung->id,
            'email' => 'required|email|unique:nguoi_dung,email,' . $nguoiDung->id,
            'mat_khau' => 'nullable|min:6', // cho phép null vì có check field
            'vai_tro' => ['nullable', Rule::enum(VaiTro::class)],
        ]);

        if ($request->filled('mat_khau')) {
            $validatedData['mat_khau'] = Hash::make($validatedData['mat_khau']);
        }

        $nguoiDung->update($validatedData);

        return redirect()->route('nguoi_dung.index')->with('success', 'Người dùng đã được cập nhật thành công!');
    }

    public function destroy(NguoiDung $nguoiDung)
    {
        $nguoiDung->delete();
        return redirect()->route('nguoi_dung.index')->with('success', 'Người dùng đã được xóa thành công!');
    }
}