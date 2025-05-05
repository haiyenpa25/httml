<?php

namespace App\Http\Controllers\BanThanhTrang;

use App\Http\Controllers\Controller;
use App\Models\BanNganh;
use App\Models\BuoiNhom;
use App\Models\BuoiNhomNhiemVu;
use App\Models\ChiTietThamGia;
use App\Models\DienGia;
use App\Models\NhiemVu;
use App\Models\TinHuu;
use App\Models\TinHuuBanNganh;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BanCoDocGiaoDucThanhVienController extends Controller
{
    use ApiResponseTrait;

    // Hằng số để tránh magic numbers
    private const BAN_NGANH_ID = 2;

    /**
     * Hiển thị trang chính của Ban Cơ Đốc Giáo Dục.
     *
     * @return View
     */
    public function index(): View
    {
        $banCoDocGiaoDuc = Cache::remember('ban_co_doc_giao_duc', now()->addDay(), function () {
            return BanNganh::where('ten', 'Ban Cơ Đốc Giáo Dục')->first();
        });

        if (!$banCoDocGiaoDuc) {
            throw new \Exception('Không tìm thấy Thanh Tráng');
        }

        $banDieuHanh = Cache::remember('ban_co_doc_giao_duc_dieu_hanh', now()->addHour(), function () use ($banCoDocGiaoDuc) {
            return TinHuuBanNganh::with('tinHuu')
                ->where('ban_nganh_id', $banCoDocGiaoDuc->id)
                ->whereNotNull('chuc_vu')
                ->whereIn('chuc_vu', ['Cố Vấn', 'Cố Vấn Linh Vụ', 'Trưởng Ban', 'Thư Ký', 'Thủ Quỹ', 'Ủy Viên'])
                ->orderByRaw("CASE 
                WHEN chuc_vu = 'Cố Vấn' OR chuc_vu = 'Cố Vấn Linh Vụ' THEN 1 
                WHEN chuc_vu = 'Trưởng Ban' THEN 2 
                WHEN chuc_vu = 'Thư Ký' THEN 3 
                WHEN chuc_vu = 'Thủ Quỹ' THEN 4 
                WHEN chuc_vu = 'Ủy Viên' THEN 5 
                ELSE 6 END")
                ->get();
        });

        $banVien = Cache::remember('ban_co_doc_giao_duc_ban_vien', now()->addHour(), function () use ($banCoDocGiaoDuc) {
            return TinHuuBanNganh::with('tinHuu')
                ->where('ban_nganh_id', $banCoDocGiaoDuc->id)
                ->where(function ($query) {
                    $query->whereNull('chuc_vu')
                        ->orWhere('chuc_vu', 'Thành viên')
                        ->orWhere('chuc_vu', '');
                })
                ->orderBy('created_at', 'desc')
                ->get();
        });



        $existingMemberIds = TinHuuBanNganh::where('ban_nganh_id', $banCoDocGiaoDuc->id)
            ->pluck('tin_huu_id')
            ->toArray();

        $tinHuuList = TinHuu::whereNotIn('id', $existingMemberIds)
            ->orderBy('ho_ten', 'asc')
            ->get();

        return view('_ban_co_doc_giao_duc.thanh_vien', compact('banCoDocGiaoDuc', 'banDieuHanh', 'banVien', 'tinHuuList'));
    }

    /**
     * Thêm thành viên vào Ban Cơ Đốc Giáo Dục.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function themThanhVien(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'chuc_vu' => 'nullable|string|max:50',
        ]);

        $exists = TinHuuBanNganh::where('tin_huu_id', $validatedData['tin_huu_id'])
            ->where('ban_nganh_id', $validatedData['ban_nganh_id'])
            ->exists();

        if ($exists) {
            return $this->errorResponse('Thành viên này đã thuộc Ban Cơ Đốc Giáo Dục!', 422);
        }

        try {
            DB::beginTransaction();
            TinHuuBanNganh::create([
                'tin_huu_id' => $validatedData['tin_huu_id'],
                'ban_nganh_id' => $validatedData['ban_nganh_id'],
                'chuc_vu' => $validatedData['chuc_vu'] ?? 'Thành viên'
            ]);
            $this->clearBanThanhTrangCache();
            DB::commit();
            return $this->successResponse('Đã thêm thành viên vào Ban Cơ Đốc Giáo Dục thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi thêm thành viên: ' . $e->getMessage());
            return $this->errorResponse('Có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Xóa thành viên khỏi Ban Cơ Đốc Giáo Dục.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function xoaThanhVien(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
        ]);

        $recordExists = TinHuuBanNganh::where('tin_huu_id', $validatedData['tin_huu_id'])
            ->where('ban_nganh_id', $validatedData['ban_nganh_id'])
            ->exists();

        if (!$recordExists) {
            return $this->notFoundResponse('Không tìm thấy thành viên trong Ban Cơ Đốc Giáo Dục để xóa.');
        }

        try {
            DB::beginTransaction();
            TinHuuBanNganh::where('tin_huu_id', $validatedData['tin_huu_id'])
                ->where('ban_nganh_id', $validatedData['ban_nganh_id'])
                ->delete();
            $this->clearBanThanhTrangCache();
            DB::commit();
            return $this->successResponse('Đã xóa thành viên khỏi Ban Cơ Đốc Giáo Dục thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi xóa thành viên khỏi Ban Cơ Đốc Giáo Dục: ' . $e->getMessage());
            return $this->errorResponse('Đã xảy ra lỗi khi xóa thành viên: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Cập nhật chức vụ thành viên trong Ban Cơ Đốc Giáo Dục.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function capNhatChucVu(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'chuc_vu' => 'nullable|string|max:50',
        ]);

        try {
            DB::beginTransaction();

            if ($validatedData['chuc_vu'] === 'Trưởng Ban') {
                $existingTruongBan = TinHuuBanNganh::where('ban_nganh_id', $validatedData['ban_nganh_id'])
                    ->where('chuc_vu', 'Trưởng Ban')
                    ->where('tin_huu_id', '!=', $validatedData['tin_huu_id'])
                    ->first();

                if ($existingTruongBan) {
                    return $this->errorResponse('Ban Cơ Đốc Giáo Dục đã có Trưởng Ban! Vui lòng thay đổi chức vụ của người hiện tại trước.', 422);
                }

                BanNganh::where('id', $validatedData['ban_nganh_id'])
                    ->update(['truong_ban_id' => $validatedData['tin_huu_id']]);
            }

            TinHuuBanNganh::where('tin_huu_id', $validatedData['tin_huu_id'])
                ->where('ban_nganh_id', $validatedData['ban_nganh_id'])
                ->update(['chuc_vu' => $validatedData['chuc_vu'] ?? 'Thành viên']);

            $this->clearBanThanhTrangCache();
            DB::commit();
            return $this->successResponse('Đã cập nhật chức vụ thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi cập nhật chức vụ: ' . $e->getMessage());
            return $this->errorResponse('Có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Xóa cache liên quan đến Ban Cơ Đốc Giáo Dục.
     *
     * @return void
     */
    private function clearBanThanhTrangCache(): void
    {
        Cache::forget('ban_co_doc_giao_duc');
        Cache::forget('ban_co_doc_giao_duc_dieu_hanh');
        Cache::forget('ban_co_doc_giao_duc_ban_vien');
        Cache::forget('ban_co_doc_giao_duc_thanh_vien');
    }

    /**
     * Hiển thị trang điểm danh của Ban Cơ Đốc Giáo Dục.
     *
     * @param Request $request
     * @return View
     */
    public function diemDanh(Request $request): View
    {
        $banCoDocGiaoDuc = BanNganh::where('ten', 'Ban Cơ Đốc Giáo Dục')->first();
        if (!$banCoDocGiaoDuc) {
            return view('errors.custom', ['message' => 'Không tìm thấy Ban Cơ Đốc Giáo Dục']);
        }

        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $selectedBuoiNhom = $request->input('buoi_nhom_id');

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create()->month($i)->translatedFormat('F');
            $months[$i] = $monthName;
        }

        $currentYear = (int) date('Y');
        $years = range($currentYear - 2, $currentYear + 1);

        $buoiNhomOptions = BuoiNhom::where('ban_nganh_id', $banCoDocGiaoDuc->id)
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->orderBy('ngay_dien_ra', 'desc')
            ->get();

        $currentBuoiNhom = $selectedBuoiNhom ? BuoiNhom::with(['dienGia', 'tinHuuHdct', 'tinHuuDoKt'])->find($selectedBuoiNhom) : null;

        $danhSachTinHuu = TinHuu::whereHas('banNganhs', function ($query) use ($banCoDocGiaoDuc) {
            $query->where('ban_nganh_id', $banCoDocGiaoDuc->id);
        })->orderBy('ho_ten')->get();

        $diemDanhData = [];
        $stats = ['co_mat' => 0, 'vang_mat' => 0, 'vang_co_phep' => 0, 'ti_le_tham_du' => 0];

        if ($selectedBuoiNhom) {
            $chiTietThamGia = ChiTietThamGia::where('buoi_nhom_id', $selectedBuoiNhom)
                ->get()
                ->keyBy('tin_huu_id');

            foreach ($chiTietThamGia as $id => $chiTiet) {
                $diemDanhData[$id] = [
                    'status' => $chiTiet->trang_thai,
                    'note' => $chiTiet->ghi_chu
                ];

                if ($chiTiet->trang_thai == 'co_mat') {
                    $stats['co_mat']++;
                } elseif ($chiTiet->trang_thai == 'vang_mat') {
                    $stats['vang_mat']++;
                } elseif ($chiTiet->trang_thai == 'vang_co_phep') {
                    $stats['vang_co_phep']++;
                }
            }

            $totalMembers = $danhSachTinHuu->count();
            $stats['ti_le_tham_du'] = $totalMembers > 0 ? round(($stats['co_mat'] / $totalMembers) * 100) : 0;
        }

        $dienGias = DienGia::orderBy('ho_ten')->get();

        return view('_ban_co_doc_giao_duc.diem_danh', compact(
            'banCoDocGiaoDuc',
            'months',
            'years',
            'month',
            'year',
            'buoiNhomOptions',
            'selectedBuoiNhom',
            'currentBuoiNhom',
            'danhSachTinHuu',
            'diemDanhData',
            'stats',
            'dienGias'
        ));
    }

    /**
     * Xử lý lưu điểm danh.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function luuDiemDanh(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'buoi_nhom_id' => 'required|exists:buoi_nhom,id',
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|in:co_mat,vang_mat,vang_co_phep',
            'attendance.*.note' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray());
        }

        try {
            DB::beginTransaction();
            $buoiNhomId = $request->buoi_nhom_id;
            $attendanceData = $request->attendance;

            ChiTietThamGia::where('buoi_nhom_id', $buoiNhomId)->delete();

            foreach ($attendanceData as $tinHuuId => $data) {
                ChiTietThamGia::create([
                    'buoi_nhom_id' => $buoiNhomId,
                    'tin_huu_id' => $tinHuuId,
                    'trang_thai' => $data['status'],
                    'ghi_chu' => $data['note'] ?? null
                ]);
            }

            $buoiNhom = BuoiNhom::find($buoiNhomId);
            $buoiNhom->so_luong_tin_huu = collect($attendanceData)->filter(function ($item) {
                return $item['status'] === 'co_mat' || $item['status'] === 'vang_co_phep';
            })->count();
            $buoiNhom->save();

            DB::commit();
            return $this->successResponse('Đã lưu điểm danh thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi lưu điểm danh: ' . $e->getMessage());
            return $this->errorResponse('Đã xảy ra lỗi khi lưu điểm danh: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Thêm buổi nhóm mới.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function themBuoiNhom(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'ngay_dien_ra' => 'required|date',
            'chu_de' => 'required|string|max:255',
            'dien_gia_id' => 'nullable|exists:dien_gia,id',
            'dia_diem' => 'required|string',
            'gio_bat_dau' => 'required',
            'gio_ket_thuc' => 'required',
            'ghi_chu' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray());
        }

        try {
            $buoiNhom = BuoiNhom::create([
                'ban_nganh_id' => $request->ban_nganh_id,
                'ngay_dien_ra' => $request->ngay_dien_ra,
                'chu_de' => $request->chu_de,
                'dien_gia_id' => $request->dien_gia_id,
                'dia_diem' => $request->dia_diem,
                'gio_bat_dau' => $request->gio_bat_dau,
                'gio_ket_thuc' => $request->gio_ket_thuc,
                'ghi_chu' => $request->ghi_chu
            ]);

            return $this->successResponse('Đã tạo buổi nhóm mới thành công!', $buoiNhom);
        } catch (\Exception $e) {
            Log::error('Lỗi thêm buổi nhóm: ' . $e->getMessage());
            return $this->errorResponse('Đã xảy ra lỗi khi tạo buổi nhóm: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Hiển thị trang phân công của Ban Cơ Đốc Giáo Dục.
     *
     * @param Request $request
     * @return View
     * @throws \Exception
     */
    public function phanCong(Request $request): View
    {
        $banCoDocGiaoDuc = BanNganh::where('ten', 'Ban Cơ Đốc Giáo Dục')->first();
        if (!$banCoDocGiaoDuc) {
            throw new \Exception('Không tìm thấy Ban Cơ Đốc Giáo Dục');
        }

        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $buoiNhoms = BuoiNhom::with(['dienGia', 'tinHuuHdct', 'tinHuuDoKt'])
            ->where('ban_nganh_id', $banCoDocGiaoDuc->id)
            ->whereMonth('ngay_dien_ra', $month)
            ->whereYear('ngay_dien_ra', $year)
            ->orderBy('ngay_dien_ra', 'asc')
            ->get();

        $dienGias = DienGia::orderBy('ho_ten')->get();
        $tinHuus = TinHuu::orderBy('ho_ten')->get();

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = date('F', mktime(0, 0, 0, $i, 1));
        }

        $years = [];
        $currentYear = (int) date('Y');
        for ($i = $currentYear - 2; $i <= $currentYear + 2; $i++) {
            $years[$i] = $i;
        }

        return view('_ban_co_doc_giao_duc.phan_cong', compact(
            'banCoDocGiaoDuc',
            'buoiNhoms',
            'dienGias',
            'tinHuus',
            'month',
            'year',
            'months',
            'years'
        ));
    }

    /**
     * Cập nhật thông tin buổi nhóm.
     *
     * @param Request $request
     * @param BuoiNhom $buoiNhom
     * @return JsonResponse
     */
    public function updateBuoiNhom(Request $request, BuoiNhom $buoiNhom): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ngay_dien_ra' => 'required|date',
            'chu_de' => 'nullable|string|max:255',
            'dien_gia_id' => 'nullable|exists:dien_gia,id',
            'id_tin_huu_hdct' => 'nullable|exists:tin_huu,id',
            'id_tin_huu_do_kt' => 'nullable|exists:tin_huu,id',
            'ghi_chu' => 'nullable|string',
        ], [
            'required' => ':attribute không được để trống.',
            'exists' => ':attribute không hợp lệ.',
            'date' => ':attribute phải là ngày hợp lệ.',
            'string' => ':attribute phải là chuỗi.',
            'max' => ':attribute không được vượt quá :max ký tự.',
            'ngay_dien_ra' => 'Ngày diễn ra',
            'chu_de' => 'Chủ đề',
            'dien_gia_id' => 'Diễn giả',
            'id_tin_huu_hdct' => 'Người hướng dẫn',
            'id_tin_huu_do_kt' => 'Người đọc Kinh Thánh',
            'ghi_chu' => 'Ghi chú',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray());
        }

        try {
            $banCoDocGiaoDuc = BanNganh::where('ten', 'Ban Cơ Đốc Giáo Dục')->first();
            if (!$banCoDocGiaoDuc || $buoiNhom->ban_nganh_id !== $banCoDocGiaoDuc->id) {
                return $this->forbiddenResponse('Buổi nhóm không thuộc Ban Cơ Đốc Giáo Dục.');
            }

            $buoiNhom->update($validator->validated());

            return $this->successResponse('Buổi nhóm đã được cập nhật thành công.', $buoiNhom->fresh()->load(['dienGia', 'tinHuuHdct', 'tinHuuDoKt']));
        } catch (\Exception $e) {
            Log::error('Lỗi cập nhật BuoiNhom ' . $buoiNhom->id . ': ' . $e->getMessage());
            return $this->errorResponse('Đã xảy ra lỗi khi cập nhật buổi nhóm: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Xóa buổi nhóm.
     *
     * @param BuoiNhom $buoiNhom
     * @return JsonResponse
     */
    public function deleteBuoiNhom(BuoiNhom $buoiNhom): JsonResponse
    {
        try {
            $banCoDocGiaoDuc = BanNganh::where('ten', 'Ban Cơ Đốc Giáo Dục')->first();
            if (!$banCoDocGiaoDuc || $buoiNhom->ban_nganh_id !== $banCoDocGiaoDuc->id) {
                return $this->forbiddenResponse('Buổi nhóm không thuộc Ban Cơ Đốc Giáo Dục.');
            }

            $buoiNhom->delete();

            return $this->successResponse('Buổi nhóm đã được xóa thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi xóa BuoiNhom ' . $buoiNhom->id . ': ' . $e->getMessage());
            return $this->errorResponse('Lỗi khi xóa buổi nhóm: Có thể do dữ liệu liên quan.', 500);
        }
    }

    /**
     * Hiển thị trang phân công chi tiết nhiệm vụ.
     *
     * @param Request $request
     * @return View
     * @throws \Exception
     */
    public function phanCongChiTiet(Request $request): View
    {
        $banCoDocGiaoDuc = BanNganh::where('ten', 'Ban Cơ Đốc Giáo Dục')->first();
        if (!$banCoDocGiaoDuc) {
            throw new \Exception('Không tìm thấy Ban Cơ Đốc Giáo Dục');
        }

        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $selectedBuoiNhom = $request->input('buoi_nhom_id');

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create()->month($i)->translatedFormat('F');
            $months[$i] = $monthName;
        }

        $currentYear = (int) date('Y');
        $years = range($currentYear - 2, $currentYear + 1);

        $buoiNhomOptions = BuoiNhom::where('ban_nganh_id', $banCoDocGiaoDuc->id)
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->orderBy('ngay_dien_ra', 'desc')
            ->get();

        $currentBuoiNhom = $selectedBuoiNhom ? BuoiNhom::with(['dienGia', 'tinHuuHdct', 'tinHuuDoKt'])->find($selectedBuoiNhom) : null;

        $danhSachNhiemVu = NhiemVu::all();

        $thanhVienBan = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banCoDocGiaoDuc->id)
            ->get();

        $nhiemVuPhanCong = [];
        $daPhanCong = [];

        if ($selectedBuoiNhom) {
            $nhiemVuPhanCong = BuoiNhomNhiemVu::with(['nhiemVu', 'tinHuu'])
                ->where('buoi_nhom_id', $selectedBuoiNhom)
                ->orderBy('vi_tri')
                ->get();

            foreach ($nhiemVuPhanCong as $phanCong) {
                if ($phanCong->tin_huu_id) {
                    $daPhanCong[$phanCong->tin_huu_id] = ($daPhanCong[$phanCong->tin_huu_id] ?? 0) + 1;
                }
            }
        }

        return view('_ban_co_doc_giao_duc.phan_cong_chi_tiet', compact(
            'banCoDocGiaoDuc',
            'months',
            'years',
            'month',
            'year',
            'buoiNhomOptions',
            'selectedBuoiNhom',
            'currentBuoiNhom',
            'danhSachNhiemVu',
            'thanhVienBan',
            'nhiemVuPhanCong',
            'daPhanCong'
        ));
    }

    /**
     * Lưu phân công nhiệm vụ.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function phanCongNhiemVu(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'buoi_nhom_id' => 'required|exists:buoi_nhom,id',
            'nhiem_vu_id' => 'required|exists:nhiem_vu,id',
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'ghi_chu' => 'nullable|string',
            'id' => 'nullable|exists:buoi_nhom_nhiem_vu,id'
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray());
        }

        try {
            $buoiNhom = BuoiNhom::find($request->buoi_nhom_id);
            $banCoDocGiaoDuc = BanNganh::where('ten', 'Ban Cơ Đốc Giáo Dục')->first();

            if (!$banCoDocGiaoDuc || $buoiNhom->ban_nganh_id != $banCoDocGiaoDuc->id) {
                return $this->forbiddenResponse('Buổi nhóm không thuộc Ban Cơ Đốc Giáo Dục.');
            }

            $isMember = TinHuuBanNganh::where('tin_huu_id', $request->tin_huu_id)
                ->where('ban_nganh_id', $banCoDocGiaoDuc->id)
                ->exists();

            if (!$isMember) {
                return $this->forbiddenResponse('Người được phân công không thuộc Ban Cơ Đốc Giáo Dục.');
            }

            $nhiemVu = NhiemVu::find($request->nhiem_vu_id);
            if ($nhiemVu->id_ban_nganh != $banCoDocGiaoDuc->id) {
                return $this->forbiddenResponse('Nhiệm vụ không thuộc Ban Cơ Đốc Giáo Dục.');
            }

            $maxPosition = BuoiNhomNhiemVu::where('buoi_nhom_id', $request->buoi_nhom_id)
                ->max('vi_tri') ?? 0;

            if ($request->filled('id')) {
                $phanCong = BuoiNhomNhiemVu::find($request->id);
                $phanCong->update([
                    'nhiem_vu_id' => $request->nhiem_vu_id,
                    'tin_huu_id' => $request->tin_huu_id,
                    'ghi_chu' => $request->ghi_chu
                ]);

                return $this->successResponse('Cập nhật phân công nhiệm vụ thành công!');
            }

            $exists = BuoiNhomNhiemVu::where('buoi_nhom_id', $request->buoi_nhom_id)
                ->where('nhiem_vu_id', $request->nhiem_vu_id)
                ->exists();

            if ($exists) {
                return $this->errorResponse('Nhiệm vụ này đã được phân công cho buổi nhóm.', 422);
            }

            BuoiNhomNhiemVu::create([
                'buoi_nhom_id' => $request->buoi_nhom_id,
                'nhiem_vu_id' => $request->nhiem_vu_id,
                'tin_huu_id' => $request->tin_huu_id,
                'vi_tri' => $maxPosition + 1,
                'ghi_chu' => $request->ghi_chu
            ]);

            return $this->successResponse('Phân công nhiệm vụ thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi phân công nhiệm vụ: ' . $e->getMessage());
            return $this->errorResponse('Đã xảy ra lỗi khi phân công nhiệm vụ: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Xóa phân công nhiệm vụ.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function xoaPhanCong($id): JsonResponse
    {
        try {
            $phanCong = BuoiNhomNhiemVu::find($id);

            if (!$phanCong) {
                return $this->notFoundResponse('Không tìm thấy phân công này.');
            }

            $buoiNhom = BuoiNhom::find($phanCong->buoi_nhom_id);
            $banCoDocGiaoDuc = BanNganh::where('ten', 'Ban Cơ Đốc Giáo Dục')->first();

            if (!$banCoDocGiaoDuc || $buoiNhom->ban_nganh_id != $banCoDocGiaoDuc->id) {
                return $this->forbiddenResponse('Không có quyền xóa phân công này.');
            }

            $phanCong->delete();

            return $this->successResponse('Xóa phân công thành công!');
        } catch (\Exception $e) {
            Log::error('Lỗi xóa phân công nhiệm vụ: ' . $e->getMessage());
            return $this->errorResponse('Đã xảy ra lỗi khi xóa phân công: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Lấy danh sách Ban Điều Hành (JSON cho DataTables).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function dieuHanhList(Request $request): JsonResponse
    {
        try {
            $banCoDocGiaoDuc = BanNganh::where('ten', 'Ban Cơ Đốc Giáo Dục')->first();
            if (!$banCoDocGiaoDuc) {
                return $this->notFoundResponse('Không tìm thấy Ban Cơ Đốc Giáo Dục.');
            }

            $query = TinHuuBanNganh::with('tinHuu')
                ->where('ban_nganh_id', $banCoDocGiaoDuc->id)
                ->whereNotNull('chuc_vu')
                ->whereIn('chuc_vu', ['Cố Vấn', 'Cố Vấn Linh Vụ', 'Trưởng Ban', 'Thư Ký', 'Thủ Quỹ', 'Ủy Viên']);

            if ($hoTen = $request->input('ho_ten')) {
                $query->whereHas('tinHuu', function ($q) use ($hoTen) {
                    $q->where('ho_ten', 'like', '%' . $hoTen . '%');
                });
            }

            if ($chucVu = $request->input('chuc_vu')) {
                $query->where('chuc_vu', $chucVu);
            }

            $data = $query->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'tin_huu_id' => $item->tin_huu_id,
                    'ho_ten' => $item->tinHuu->ho_ten ?? 'N/A',
                    'chuc_vu' => $item->chuc_vu ?? 'Thành viên'
                ];
            });

            if ($data->isEmpty()) {
                return $this->successResponse('Không có thành viên Ban Điều Hành.', []);
            }

            return $this->successResponse('Lấy danh sách Ban Điều Hành thành công.', $data);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy danh sách Ban Điều Hành: ' . $e->getMessage());
            return $this->errorResponse('Lỗi hệ thống: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Lấy danh sách Ban Viên (JSON cho DataTables).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function banVienList(Request $request): JsonResponse
    {
        try {
            $banCoDocGiaoDuc = BanNganh::where('ten', 'Ban Cơ Đốc Giáo Dục')->first();
            if (!$banCoDocGiaoDuc) {
                return $this->notFoundResponse('Không tìm thấy Ban Cơ Đốc Giáo Dục.');
            }

            $query = TinHuuBanNganh::with('tinHuu')
                ->where('ban_nganh_id', $banCoDocGiaoDuc->id)
                ->where(function ($q) {
                    $q->whereNull('chuc_vu')
                        ->orWhere('chuc_vu', 'Thành viên')
                        ->orWhere('chuc_vu', '');
                });

            if ($hoTen = $request->input('ho_ten')) {
                $query->whereHas('tinHuu', function ($q) use ($hoTen) {
                    $q->where('ho_ten', 'like', '%' . $hoTen . '%');
                });
            }

            if ($soDienThoai = $request->input('so_dien_thoai')) {
                $query->whereHas('tinHuu', function ($q) use ($soDienThoai) {
                    $q->where('so_dien_thoai', 'like', '%' . $soDienThoai . '%');
                });
            }

            if ($diaChi = $request->input('dia_chi')) {
                $query->whereHas('tinHuu', function ($q) use ($diaChi) {
                    $q->where('dia_chi', 'like', '%' . $diaChi . '%');
                });
            }

            $data = $query->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'tin_huu_id' => $item->tin_huu_id,
                    'ho_ten' => $item->tinHuu->ho_ten ?? 'N/A',
                    'so_dien_thoai' => $item->tinHuu->so_dien_thoai ?? 'N/A',
                    'dia_chi' => $item->tinHuu->dia_chi ?? 'N/A',
                    'chuc_vu' => $item->chuc_vu ?? 'Thành viên'
                ];
            });

            if ($data->isEmpty()) {
                return $this->successResponse('Không có Ban Viên.', []);
            }

            return $this->successResponse('Lấy danh sách Ban Viên thành công.', $data);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy danh sách Ban Viên: ' . $e->getMessage());
            return $this->errorResponse('Lỗi hệ thống: ' . $e->getMessage(), 500);
        }
    }
}
