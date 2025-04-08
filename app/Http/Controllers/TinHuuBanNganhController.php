<?php

namespace App\Http\Controllers;

use App\Models\BanNganh;
use App\Models\TinHuu;
use App\Models\TinHuuBanNganh;
use Illuminate\Http\Request;

class TinHuuBanNganhController extends Controller
{
    public function index()
    {
        $bannganhs = BanNganh::all();
        $tinhuus = TinHuu::all();
        // Danh sách chức vụ cố định (có thể lưu vào bảng riêng nếu cần)
        $chucVus = ['Trưởng ban', 'Phó ban', 'Thành viên'];
        return view('_tin_huu_ban_nganh.index', compact('bannganhs', 'tinhuus', 'chucVus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'chuc_vu' => 'nullable|string|max:50', // Validate trường chức vụ
        ]);

        TinHuuBanNganh::firstOrCreate(
            [
                'ban_nganh_id' => $request->ban_nganh_id,
                'tin_huu_id' => $request->tin_huu_id,
            ],
            [
                'chuc_vu' => $request->chuc_vu, // Lưu chức vụ nếu có
            ]
        );

        return response()->json(['success' => true]);
    }

    public function getMembers(Request $request)
    {
        $members = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $request->ban_nganh_id)
            ->get();

        $html = view('_tin_huu_ban_nganh.members', compact('members'))->render();
        return response()->json(['html' => $html]);
    }

    public function destroy(Request $request)
    {
        $record = TinHuuBanNganh::where('ban_nganh_id', $request->ban_nganh_id)
            ->where('tin_huu_id', $request->tin_huu_id)
            ->first();

        if ($record) {
            $record->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }
}