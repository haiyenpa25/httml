<?php

namespace App\Http\Controllers;

use App\Models\BuoiNhom;
use App\Models\DienGia;
use App\Models\TinHuu;
use App\Models\BanNganh;
use App\Models\BuoiNhomLich;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BuoiNhomController extends Controller
{
    /**
     * Display a listing of the resource (View).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        Log::info('Accessing BuoiNhom index view.');
        return view('_buoi_nhom.index');
    }

    /**
     * Show the form for creating a new resource (View).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        Log::info('Accessing BuoiNhom create view.');
        $banNganhs = BanNganh::orderBy('ten')->get();
        $dienGias = DienGia::orderBy('ho_ten')->get();
        $lichBuoiNhoms = BuoiNhomLich::orderBy('ten')->get();
        return view('_buoi_nhom.create', compact('banNganhs', 'dienGias', 'lichBuoiNhoms'));
    }

    /**
     * Store a newly created resource in storage (Handles POST request from Ajax).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Log::info('Attempting to store new BuoiNhom.', $request->all());

        $validator = Validator::make($request->all(), [
            'lich_buoi_nhom_id' => 'required|exists:buoi_nhom_lich,id',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'ngay_dien_ra' => 'required|date',
            'gio_bat_dau' => 'nullable|date_format:H:i',
            'gio_ket_thuc' => 'nullable|date_format:H:i|after:gio_bat_dau',
            'dia_diem' => 'nullable|string|max:255',
            'chu_de' => 'nullable|string|max:255',
            'dien_gia_id' => 'nullable|exists:dien_gia,id',
            'id_tin_huu_hdct' => 'nullable|exists:tin_huu,id',
            'id_tin_huu_do_kt' => 'nullable|exists:tin_huu,id',
            'ghi_chu' => 'nullable|string',
        ], [
            'required' => ':attribute không được để trống.',
            'exists' => ':attribute không hợp lệ.',
            'date' => ':attribute phải là ngày hợp lệ.',
            'date_format' => ':attribute không đúng định dạng Giờ:Phút.',
            'after' => ':attribute phải sau Giờ bắt đầu.',
            'string' => ':attribute phải là chuỗi.',
            'max' => ':attribute không được vượt quá :max ký tự.',
        ], [
            'lich_buoi_nhom_id' => 'Lịch buổi nhóm',
            'ban_nganh_id' => 'Ban ngành',
            'ngay_dien_ra' => 'Ngày diễn ra',
            'gio_bat_dau' => 'Giờ bắt đầu',
            'gio_ket_thuc' => 'Giờ kết thúc',
            'dia_diem' => 'Địa điểm',
            'chu_de' => 'Chủ đề',
            'dien_gia_id' => 'Diễn giả',
            'id_tin_huu_hdct' => 'Người hướng dẫn CT',
            'id_tin_huu_do_kt' => 'Người đọc Kinh Thánh',
            'ghi_chu' => 'Ghi chú',
        ]);

        if ($validator->fails()) {
            Log::warning('BuoiNhom store validation failed.', $validator->errors()->toArray());
            return response()->json(['success' => false, 'message' => 'Dữ liệu không hợp lệ.', 'errors' => $validator->errors()], 422);
        }

        try {
            BuoiNhom::create($validator->validated());
            Log::info('BuoiNhom created successfully.');
            return response()->json(['success' => true, 'message' => 'Buổi nhóm đã được tạo thành công.']);
        } catch (\Exception $e) {
            Log::error('Error storing BuoiNhom: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi lưu buổi nhóm. Vui lòng thử lại.'], 500);
        }
    }

    /**
     * Display the specified resource (View - Optional).
     *
     * @param  \App\Models\BuoiNhom  $buoiNhom
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(BuoiNhom $buoiNhom)
    {
        Log::info('Showing BuoiNhom details for ID: ' . $buoiNhom->id);
        return redirect()->route('buoi_nhom.edit', $buoiNhom);
    }

    /**
     * Show the form for editing the specified resource (View).
     *
     * @param  \App\Models\BuoiNhom  $buoiNhom
     * @return \Illuminate\View\View
     */
    public function edit(BuoiNhom $buoiNhom)
    {
        Log::info('Accessing BuoiNhom edit view for ID: ' . $buoiNhom->id);
        $banNganhs = BanNganh::orderBy('ten')->get();
        $dienGias = DienGia::orderBy('ho_ten')->get();
        $lichBuoiNhoms = BuoiNhomLich::orderBy('ten')->get();

        $tinHuuHdct = collect();
        $tinHuuDoKt = collect();
        if ($buoiNhom->ban_nganh_id) {
            $tinHuuTrongBanNganh = $this->getTinHuuTrongBanNganh($buoiNhom->ban_nganh_id);
            if ($buoiNhom->id_tin_huu_hdct && !$tinHuuTrongBanNganh->contains('id', $buoiNhom->id_tin_huu_hdct)) {
                $nguoiHdct = TinHuu::find($buoiNhom->id_tin_huu_hdct);
                if ($nguoiHdct)
                    $tinHuuTrongBanNganh->push($nguoiHdct);
            }
            if ($buoiNhom->id_tin_huu_do_kt && !$tinHuuTrongBanNganh->contains('id', $buoiNhom->id_tin_huu_do_kt)) {
                $nguoiDoKt = TinHuu::find($buoiNhom->id_tin_huu_do_kt);
                if ($nguoiDoKt)
                    $tinHuuTrongBanNganh->push($nguoiDoKt);
            }
            $tinHuuHdct = $tinHuuTrongBanNganh;
            $tinHuuDoKt = $tinHuuTrongBanNganh;
        }

        return view('_buoi_nhom.edit', compact('buoiNhom', 'banNganhs', 'dienGias', 'lichBuoiNhoms', 'tinHuuHdct', 'tinHuuDoKt'));
    }

    /**
     * Update the specified resource in storage (Handles PUT request from Ajax).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BuoiNhom  $buoiNhom
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, BuoiNhom $buoiNhom)
    {
        Log::info('Attempting to update BuoiNhom ID: ' . $buoiNhom->id, $request->all());

        $validator = Validator::make($request->all(), [
            'lich_buoi_nhom_id' => 'required|exists:buoi_nhom_lich,id',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'ngay_dien_ra' => 'required|date',
            'gio_bat_dau' => 'nullable|date_format:H:i',
            'gio_ket_thuc' => 'nullable|date_format:H:i|after:gio_bat_dau',
            'dia_diem' => 'nullable|string|max:255',
            'chu_de' => 'nullable|string|max:255',
            'dien_gia_id' => 'nullable|exists:dien_gia,id',
            'id_tin_huu_hdct' => 'nullable|exists:tin_huu,id',
            'id_tin_huu_do_kt' => 'nullable|exists:tin_huu,id',
            'ghi_chu' => 'nullable|string',
        ], [
            'required' => ':attribute không được để trống.',
            'exists' => ':attribute không hợp lệ.',
            'date' => ':attribute phải là ngày hợp lệ.',
            'date_format' => ':attribute không đúng định dạng Giờ:Phút.',
            'after' => ':attribute phải sau Giờ bắt đầu.',
            'string' => ':attribute phải là chuỗi.',
            'max' => ':attribute không được vượt quá :max ký tự.',
        ], [
            'lich_buoi_nhom_id' => 'Lịch buổi nhóm',
            'ban_nganh_id' => 'Ban ngành',
            'ngay_dien_ra' => 'Ngày diễn ra',
            'gio_bat_dau' => 'Giờ bắt đầu',
            'gio_ket_thuc' => 'Giờ kết thúc',
            'dia_diem' => 'Địa điểm',
            'chu_de' => 'Chủ đề',
            'dien_gia_id' => 'Diễn giả',
            'id_tin_huu_hdct' => 'Người hướng dẫn CT',
            'id_tin_huu_do_kt' => 'Người đọc Kinh Thánh',
            'ghi_chu' => 'Ghi chú',
        ]);

        if ($validator->fails()) {
            Log::warning('BuoiNhom update validation failed for ID: ' . $buoiNhom->id, $validator->errors()->toArray());
            return response()->json(['success' => false, 'message' => 'Dữ liệu không hợp lệ.', 'errors' => $validator->errors()], 422);
        }

        try {
            $buoiNhom->update($validator->validated());
            Log::info('BuoiNhom updated successfully for ID: ' . $buoiNhom->id);
            return response()->json(['success' => true, 'message' => 'Buổi nhóm đã được cập nhật thành công.']);
        } catch (\Exception $e) {
            Log::error('Error updating BuoiNhom ' . $buoiNhom->id . ': ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi cập nhật buổi nhóm.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage (Handles DELETE request from Ajax).
     *
     * @param  \App\Models\BuoiNhom  $buoiNhom
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BuoiNhom $buoiNhom)
    {
        Log::info('Attempting to delete BuoiNhom ID: ' . $buoiNhom->id);
        try {
            $buoiNhom->delete();
            Log::info('BuoiNhom deleted successfully ID: ' . $buoiNhom->id);
            return response()->json(['success' => true, 'message' => 'Buổi nhóm đã được xóa thành công.']);
        } catch (\Exception $e) {
            Log::error('Error deleting BuoiNhom ' . $buoiNhom->id . ': ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Lỗi khi xóa buổi nhóm. Có thể do dữ liệu liên quan.'], 500);
        }
    }

    /**
     * Get list of BuoiNhom as JSON for the table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBuoiNhoms(Request $request)
    {
        Log::info('API: Fetching all BuoiNhoms for table.', $request->all());
        try {
            $query = BuoiNhom::with(['dienGia:id,ho_ten,chuc_danh', 'banNganh:id,ten'])
                ->select(
                    'id',
                    'ngay_dien_ra',
                    'chu_de',
                    'dien_gia_id',
                    'ban_nganh_id',
                    'so_luong_trung_lao',
                    'so_luong_thanh_trang',
                    'so_luong_thanh_nien',
                    'so_luong_thieu_nhi_au',
                    'so_luong_tin_huu_khac',
                    'so_luong_tin_huu',
                    'so_luong_than_huu',
                    'so_nguoi_tin_chua'
                );

            // Lọc theo tháng và năm nếu có
            if ($request->has('month') && $request->has('year')) {
                $month = (int) $request->input('month');
                $year = (int) $request->input('year');

                if ($month >= 1 && $month <= 12 && $year >= 1900 && $year <= 9999) {
                    $query->whereMonth('ngay_dien_ra', $month)
                        ->whereYear('ngay_dien_ra', $year);
                } else {
                    Log::warning('Invalid month or year parameter.', ['month' => $month, 'year' => $year]);
                    return response()->json(['error' => 'Tháng hoặc năm không hợp lệ.'], 400);
                }
            }

            $buoiNhoms = $query->orderBy('ngay_dien_ra', 'desc')->get();
            Log::info('API: BuoiNhoms data fetched.', ['count' => $buoiNhoms->count()]);
            return response()->json($buoiNhoms);
        } catch (\Exception $e) {
            Log::error('API: Error fetching BuoiNhoms: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi khi tải danh sách buổi nhóm.'], 500);
        }
    }

    /**
     * Get a single BuoiNhom as JSON for editing.
     *
     * @param \App\Models\BuoiNhom $buoiNhom
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBuoiNhomJson(BuoiNhom $buoiNhom)
    {
        Log::info('API: Fetching BuoiNhom JSON for edit ID: ' . $buoiNhom->id);
        try {
            return response()->json($buoiNhom);
        } catch (\Exception $e) {
            Log::error('API: Error fetching BuoiNhom JSON ID ' . $buoiNhom->id . ': ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi khi tải dữ liệu buổi nhóm.'], 500);
        }
    }

    /**
     * Get TinHuu by BanNganh ID as JSON for select options.
     *
     * @param  int  $banNganhId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTinHuuByBanNganh($banNganhId)
    {
        Log::info('API: getTinHuuByBanNganh called with banNganhId: ' . $banNganhId);

        if (!ctype_digit((string) $banNganhId) || $banNganhId <= 0) {
            Log::warning('API: Invalid banNganhId received: ' . $banNganhId);
            return response()->json(['error' => 'ID Ban Ngành không hợp lệ.'], 400);
        }

        try {
            $tinHuu = $this->getTinHuuTrongBanNganh($banNganhId);
            Log::info('API: getTinHuuByBanNganh result count: ' . $tinHuu->count(), ['ban_nganh_id' => $banNganhId]);
            return response()->json($tinHuu);
        } catch (\Exception $e) {
            Log::error('API: getTinHuuByBanNganh error for ID ' . $banNganhId . ': ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi máy chủ khi tải dữ liệu tín hữu.'], 500);
        }
    }

    /**
     * Helper function to get TinHuu within a specific BanNganh.
     *
     * @param int $banNganhId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getTinHuuTrongBanNganh(int $banNganhId)
    {
        return TinHuu::select('tin_huu.id', 'tin_huu.ho_ten')
            ->join('tin_huu_ban_nganh', 'tin_huu.id', '=', 'tin_huu_ban_nganh.tin_huu_id')
            ->where('tin_huu_ban_nganh.ban_nganh_id', $banNganhId)
            ->orderBy('tin_huu.ho_ten')
            ->distinct()
            ->get();
    }

    /**
     * Update counts for a specific BuoiNhom (Handles PUT request from Ajax).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BuoiNhom  $buoiNhom
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCounts(Request $request, BuoiNhom $buoiNhom)
    {
        Log::info("Attempting to update counts for BuoiNhom ID: {$buoiNhom->id}", $request->all());

        $validator = Validator::make($request->all(), [
            'so_luong_trung_lao' => 'nullable|integer|min:0',
            'so_luong_thanh_trang' => 'nullable|integer|min:0',
            'so_luong_thanh_nien' => 'nullable|integer|min:0',
            'so_luong_thieu_nhi_au' => 'nullable|integer|min:0',
            'so_luong_tin_huu_khac' => 'nullable|integer|min:0',
            'so_luong_tin_huu' => 'nullable|integer|min:0',
            'so_luong_than_huu' => 'nullable|integer|min:0',
            'so_nguoi_tin_chua' => 'nullable|integer|min:0',
        ], [
            'integer' => ':attribute phải là số nguyên.',
            'min' => ':attribute không được nhỏ hơn :min.',
        ], [
            'so_luong_trung_lao' => 'Số lượng Trung Lão',
            'so_luong_thanh_trang' => 'Số lượng Thanh Tráng',
            'so_luong_thanh_nien' => 'Số lượng Thanh Niên',
            'so_luong_thieu_nhi_au' => 'Số lượng Thiếu Nhi/Ấu',
            'so_luong_tin_huu_khac' => 'Số lượng Tín hữu Khác',
            'so_luong_tin_huu' => 'Tổng số Tín hữu',
            'so_luong_than_huu' => 'Số lượng Thân Hữu',
            'so_nguoi_tin_chua' => 'Số người Tin Chúa',
        ]);

        if ($validator->fails()) {
            Log::warning('Validation failed for updateCounts.', $validator->errors()->toArray());
            return response()->json(['success' => false, 'message' => 'Dữ liệu không hợp lệ.', 'errors' => $validator->errors()], 422);
        }

        try {
            $buoiNhom->update($validator->validated());
            Log::info("Counts updated successfully for BuoiNhom ID: {$buoiNhom->id}");
            return response()->json(['success' => true, 'message' => 'Cập nhật số lượng thành công.']);
        } catch (\Exception $e) {
            Log::error("Error updating counts for BuoiNhom ID {$buoiNhom->id}: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi cập nhật số lượng.'], 500);
        }
    }
    public function filter(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'month' => 'nullable|integer|between:1,12',
            'year' => 'nullable|integer|between:2020,2030'
        ]);

        // Default to current month and year if not provided
        $month = $validatedData['month'] ?? date('m');
        $year = $validatedData['year'] ?? date('Y');

        // Query buổi nhóm with filtering
        $buoiNhoms = BuoiNhom::with(['dienGia', 'nguoiHuongDan', 'nguoiDocKinhThanh'])
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->get();

        // Return view with filtered data
        return view('_buoi_nhom.phan_cong', [
            'buoiNhoms' => $buoiNhoms,
            'selectedMonth' => $month,
            'selectedYear' => $year
        ]);
    }
}
