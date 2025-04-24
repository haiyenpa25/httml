<?php

namespace App\Http\Controllers;

use App\Models\TinHuu;
use App\Models\HoGiaDinh;
use App\Models\BanNganh;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\TinHuuRequest;
use App\Http\Controllers\Controller;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\TinHuuBanNganh;
use App\Enums\LoaiTinHuu; // Import enum
use App\Enums\GioiTinh; // Import enum
use App\Enums\TinhTrangHonNhan; // Import enum

class TinHuuController extends Controller
{
    public function index()
    {
        $tinHuuS = TinHuu::all();
        $hoGiaDinhs = HoGiaDinh::all();
        $banNganhs = BanNganh::all();
        // Debug: Kiểm tra dữ liệu $banNganhs

        return view('_tin_huu.index', compact('tinHuuS', 'hoGiaDinhs', 'banNganhs'));
    }

    public function create()
    {
        $hoGiaDinhs = HoGiaDinh::all();
        return view('_tin_huu.create', compact('hoGiaDinhs'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'ho_ten' => 'required|string|max:255',
                'ngay_sinh' => 'required|date',
                'so_dien_thoai' => 'required|string|max:20',
                'dia_chi' => 'required|string|max:255',
                'loai_tin_huu' => 'required|in:tin_huu_chinh_thuc,tan_tin_huu,tin_huu_ht_khac',
                'gioi_tinh' => 'required|in:nam,nu',
                'tinh_trang_hon_nhan' => 'required|in:doc_than,ket_hon',
                'ho_gia_dinh_id' => 'nullable|exists:ho_gia_dinh,id',
                'ngay_tin_chua' => 'nullable|date'
            ]);

            $tinHuu = TinHuu::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Thêm tín hữu thành công',
                'data' => $tinHuu
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi thêm tín hữu: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể thêm tín hữu: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, TinHuu $tinHuu)
    {
        try {
            $validated = $request->validate([
                'ho_ten' => 'required|string|max:255',
                'ngay_sinh' => 'required|date',
                'so_dien_thoai' => 'required|string|max:20',
                'dia_chi' => 'required|string|max:255',
                'loai_tin_huu' => 'required|in:tin_huu_chinh_thuc,tan_tin_huu,tin_huu_ht_khac',
                'gioi_tinh' => 'required|in:nam,nu',
                'tinh_trang_hon_nhan' => 'required|in:doc_than,ket_hon',
                'ho_gia_dinh_id' => 'nullable|exists:ho_gia_dinh,id',
                'ngay_tin_chua' => 'nullable|date'
            ]);

            $tinHuu->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật tín hữu thành công',
                'data' => $tinHuu
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật tín hữu: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể cập nhật tín hữu: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(TinHuu $tinHuu)
    {
        try {
            $tinHuu->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa tín hữu thành công'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi xóa tín hữu: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa tín hữu: ' . $e->getMessage()
            ], 500);
        }
    }

    public function danhSachNhanSu()
    {
        $nhanSu = TinHuu::where('vai_tro', '!=', 'thanh_vien')->get();
        return view('_tin_huu.nhan_su', compact('nhanSu'));
    }

    public function getByBanNganh($banNganhId)
    {
        $tinHuus = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banNganhId)
            ->get()
            ->map(function ($record) {
                return [
                    'id' => $record->tinHuu->id,
                    'ho_ten' => $record->tinHuu->ho_ten
                ];
            });

        return response()->json($tinHuus);
    }

    public function getTinHuus()
    {
        try {
            $tinHuus = TinHuu::with(['hoGiaDinh'])
                ->select([
                    'id',
                    'ho_ten',
                    'ngay_sinh',
                    'so_dien_thoai',
                    'dia_chi',
                    'loai_tin_huu',
                    'gioi_tinh',
                    'tinh_trang_hon_nhan',
                    'ho_gia_dinh_id',
                    'ngay_tin_chua'
                ])
                ->get()
                ->map(function ($tinHuu) {
                    // Lấy thông tin ban ngành từ bảng tin_huu_ban_nganh
                    $banNganhs = TinHuuBanNganh::where('tin_huu_id', $tinHuu->id)
                        ->with('banNganh')
                        ->get()
                        ->map(function ($record) {
                            // Đảm bảo banNganh tồn tại và có cột ten
                            if ($record->banNganh && isset($record->banNganh->ten)) {
                                return [
                                    'id' => $record->banNganh->id,
                                    'ten' => $record->banNganh->ten, // Sửa từ ten_ban_nganh thành ten
                                    'chuc_vu' => $record->chuc_vu
                                ];
                            }
                            return null; // Bỏ qua nếu banNganh không hợp lệ
                        })
                        ->filter() // Loại bỏ các phần tử null
                        ->values()
                        ->toArray();

                    // Đảm bảo ban_nganhs luôn là mảng
                    $tinHuu->ban_nganhs = $banNganhs ?: [];
                    return $tinHuu;
                });

            return response()->json($tinHuus);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy danh sách tín hữu: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể lấy danh sách tín hữu'], 500);
        }
    }

    public function edit(TinHuu $tinHuu)
    {
        return response()->json($tinHuu);
    }

    public function show(TinHuu $tinHuu)
    {
        return response()->json($tinHuu);
    }
}
