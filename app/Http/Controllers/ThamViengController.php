<?php

namespace App\Http\Controllers;

use App\Models\ThamVieng;
use App\Models\TinHuu;
use App\Models\ThanHuu;
use App\Models\BanNganh;

use Illuminate\Http\Request;

class ThamViengController extends Controller
{
    public function index()
    {
        $thamViengs = ThamVieng::all();
        return view('tham_vieng.index', compact('thamViengs'));
    }

    public function create()
    {
         $tinHuuS = TinHuu::all();
        $thanHuuS = ThanHuu::all();
         $banNganhs = BanNganh::all();
        return view('tham_vieng.create', compact('tinHuuS', 'thanHuuS','banNganhs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tin_huu_id' => 'nullable|exists:tin_huu,id',
            'than_huu_id' => 'nullable|exists:than_huu,id',
            'nguoi_tham_id' => 'required|exists:tin_huu,id',
            'id_ban' => 'nullable|exists:ban_nganh,id',
            'ngay_tham' => 'required|date',
            'noi_dung' => 'required|text',
            'ket_qua' => 'nullable|text',
            'trang_thai' => 'nullable|enum:da_tham,ke_hoach',
        ]);

        // Validate that either tin_huu_id or than_huu_id is present
        if (!($request->has('tin_huu_id') || $request->has('than_huu_id'))) {
            return back()->withErrors(['tin_huu_id' => 'Ít nhất một trong hai Tín Hữu hoặc Thân Hữu phải được chọn.']);
        }

        ThamVieng::create($validatedData);

        return redirect()->route('tham-vieng.index')->with('success', 'Thăm viếng đã được thêm thành công!');
    }

    public function show(ThamVieng $thamVieng)
    {
        return view('tham_vieng.show', compact('thamVieng'));
    }

    public function edit(ThamVieng $thamVieng)
    {
         $tinHuuS = TinHuu::all();
        $thanHuuS = ThanHuu::all();
         $banNganhs = BanNganh::all();
        return view('tham_vieng.edit', compact('thamVieng', 'tinHuuS', 'thanHuuS','banNganhs'));
    }

    public function update(Request $request, ThamVieng $thamVieng)
    {
          $validatedData = $request->validate([
           'tin_huu_id' => 'nullable|exists:tin_huu,id',
            'than_huu_id' => 'nullable|exists:than_huu,id',
            'nguoi_tham_id' => 'required|exists:tin_huu,id',
            'id_ban' => 'nullable|exists:ban_nganh,id',
            'ngay_tham' => 'required|date',
            'noi_dung' => 'required|text',
            'ket_qua' => 'nullable|text',
            'trang_thai' => 'nullable|enum:da_tham,ke_hoach',
        ]);
           if (!($request->has('tin_huu_id') || $request->has('than_huu_id'))) {
            return back()->withErrors(['tin_huu_id' => 'Ít nhất một trong hai Tín Hữu hoặc Thân Hữu phải được chọn.']);
        }

        $thamVieng->update($validatedData);

        return redirect()->route('tham-vieng.index')->with('success', 'Thăm viếng đã được cập nhật thành công!');
    }

    public function destroy(ThamVieng $thamVieng)
    {
        $thamVieng->delete();
        return redirect()->route('tham-vieng.index')->with('success', 'Thăm viếng đã được xóa thành công!');
    }
}