<?php

namespace App\Http\Controllers\TinHuu;

use App\Http\Controllers\Controller;
use App\Models\TinHuu;
use App\Models\HoGiaDinh;
use App\Models\BanNganh;
use App\Models\TinHuuBanNganh;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class TinHuuThanhVienController extends Controller
{
    use ApiResponseTrait;

    public function index(): View
    {
        $hoGiaDinhs = HoGiaDinh::all();
        $banNganhs = BanNganh::all();
        return view('_tin_huu.index', compact('hoGiaDinhs', 'banNganhs'));
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ho_ten' => 'required|string|max:255',
            'ngay_sinh' => 'required|date',
            'dia_chi' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:20',
            'loai_tin_huu' => 'required|in:tin_huu_chinh_thuc,tan_tin_huu,tin_huu_du_le,tin_huu_ht_khac',
            'gioi_tinh' => 'required|in:nam,nu',
            'tinh_trang_hon_nhan' => 'required|in:doc_than,ket_hon',
            'ho_gia_dinh_id' => 'nullable|exists:ho_gia_dinh,id',
            'ngay_tin_chua' => 'nullable|date',
            'ngay_sinh_hoat_voi_hoi_thanh' => 'nullable|date',
            'ngay_nhan_bap_tem' => 'nullable|date',
            'hoan_thanh_bap_tem' => 'nullable|boolean',
            'noi_xuat_than' => 'nullable|string|max:255',
            'ban_nganh_id' => 'nullable|exists:ban_nganh,id',
            'chuc_vu' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray());
        }

        try {
            DB::beginTransaction();

            $tinHuu = TinHuu::create([
                'ho_ten' => $request->ho_ten,
                'ngay_sinh' => $request->ngay_sinh,
                'dia_chi' => $request->dia_chi,
                'so_dien_thoai' => $request->so_dien_thoai,
                'loai_tin_huu' => $request->loai_tin_huu,
                'gioi_tinh' => $request->gioi_tinh,
                'tinh_trang_hon_nhan' => $request->tinh_trang_hon_nhan,
                'ho_gia_dinh_id' => $request->ho_gia_dinh_id,
                'ngay_tin_chua' => $request->ngay_tin_chua,
                'ngay_sinh_hoat_voi_hoi_thanh' => $request->ngay_sinh_hoat_voi_hoi_thanh ?? now(),
                'ngay_nhan_bap_tem' => $request->ngay_nhan_bap_tem,
                'hoan_thanh_bap_tem' => $request->hoan_thanh_bap_tem ?? false,
                'noi_xuat_than' => $request->noi_xuat_than,
            ]);

            if ($request->ban_nganh_id) {
                TinHuuBanNganh::create([
                    'tin_huu_id' => $tinHuu->id,
                    'ban_nganh_id' => $request->ban_nganh_id,
                    'chuc_vu' => $request->chuc_vu ?? 'Thành viên',
                ]);
            }

            DB::commit();
            return $this->successResponse('Thêm tín hữu thành công', $tinHuu);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi thêm tín hữu: ' . $e->getMessage());
            return $this->errorResponse('Không thể thêm tín hữu: ' . $e->getMessage(), 500);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $tinHuu = TinHuu::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'ho_ten' => 'required|string|max:255',
            'ngay_sinh' => 'required|date',
            'dia_chi' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:20',
            'loai_tin_huu' => 'required|in:tin_huu_chinh_thuc,tan_tin_huu,tin_huu_du_le,tin_huu_ht_khac',
            'gioi_tinh' => 'required|in:nam,nu',
            'tinh_trang_hon_nhan' => 'required|in:doc_than,ket_hon',
            'ho_gia_dinh_id' => 'nullable|exists:ho_gia_dinh,id',
            'ngay_tin_chua' => 'nullable|date',
            'ngay_sinh_hoat_voi_hoi_thanh' => 'nullable|date',
            'ngay_nhan_bap_tem' => 'nullable|date',
            'hoan_thanh_bap_tem' => 'nullable|boolean',
            'noi_xuat_than' => 'nullable|string|max:255',
            'ban_nganh_id' => 'nullable|exists:ban_nganh,id',
            'chuc_vu' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray());
        }

        try {
            DB::beginTransaction();

            $tinHuu->update([
                'ho_ten' => $request->ho_ten,
                'ngay_sinh' => $request->ngay_sinh,
                'dia_chi' => $request->dia_chi,
                'so_dien_thoai' => $request->so_dien_thoai,
                'loai_tin_huu' => $request->loai_tin_huu,
                'gioi_tinh' => $request->gioi_tinh,
                'tinh_trang_hon_nhan' => $request->tinh_trang_hon_nhan,
                'ho_gia_dinh_id' => $request->ho_gia_dinh_id,
                'ngay_tin_chua' => $request->ngay_tin_chua,
                'ngay_sinh_hoat_voi_hoi_thanh' => $request->ngay_sinh_hoat_voi_hoi_thanh ?? $tinHuu->ngay_sinh_hoat_voi_hoi_thanh,
                'ngay_nhan_bap_tem' => $request->ngay_nhan_bap_tem,
                'hoan_thanh_bap_tem' => $request->hoan_thanh_bap_tem ?? $tinHuu->hoan_thanh_bap_tem,
                'noi_xuat_than' => $request->noi_xuat_than,
            ]);

            if ($request->ban_nganh_id) {
                $existing = TinHuuBanNganh::where('tin_huu_id', $tinHuu->id)
                    ->where('ban_nganh_id', $request->ban_nganh_id)
                    ->first();

                if ($existing) {
                    $existing->update(['chuc_vu' => $request->chuc_vu ?? 'Thành viên']);
                } else {
                    TinHuuBanNganh::create([
                        'tin_huu_id' => $tinHuu->id,
                        'ban_nganh_id' => $request->ban_nganh_id,
                        'chuc_vu' => $request->chuc_vu ?? 'Thành viên',
                    ]);
                }
            }

            DB::commit();
            return $this->successResponse('Cập nhật tín hữu thành công', $tinHuu);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi cập nhật tín hữu: ' . $e->getMessage());
            return $this->errorResponse('Không thể cập nhật tín hữu: ' . $e->getMessage(), 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $tinHuu = TinHuu::findOrFail($id);
            $tinHuu->delete();
            return $this->successResponse('Xóa tín hữu thành công');
        } catch (\Exception $e) {
            Log::error('Lỗi xóa tín hữu: ' . $e->getMessage());
            return $this->errorResponse('Không thể xóa tín hữu: ' . $e->getMessage(), 500);
        }
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $query = TinHuu::with(['hoGiaDinh', 'banNganhTinHuu.banNganh']);

            // Áp dụng bộ lọc
            if ($hoTen = $request->input('ho_ten')) {
                $query->where('ho_ten', 'like', '%' . $hoTen . '%');
            }
            if ($loaiTinHuu = $request->input('loai_tin_huu')) {
                $query->where('loai_tin_huu', $loaiTinHuu);
            }
            if ($soDienThoai = $request->input('so_dien_thoai')) {
                $query->where('so_dien_thoai', 'like', '%' . $soDienThoai . '%');
            }
            if ($ngaySinh = $request->input('ngay_sinh')) {
                $query->where('ngay_sinh', $ngaySinh);
            }
            if ($gioiTinh = $request->input('gioi_tinh')) {
                $query->where('gioi_tinh', $gioiTinh);
            }
            if ($tinhTrangHonNhan = $request->input('tinh_trang_hon_nhan')) {
                $query->where('tinh_trang_hon_nhan', $tinhTrangHonNhan);
            }
            if ($hoanThanhBapTem = $request->input('hoan_thanh_bap_tem')) {
                $query->where('hoan_thanh_bap_tem', $hoanThanhBapTem);
            }
            if ($tuoi = $request->input('tuoi')) {
                $query->whereRaw("YEAR(CURDATE()) - YEAR(ngay_sinh) " . ($tuoi === 'under_18' ? '< 18' : ($tuoi === '18_to_30' ? 'BETWEEN 18 AND 30' : '> 30')));
            }
            if ($thoiGianSinhHoat = $request->input('thoi_gian_sinh_hoat')) {
                $query->whereRaw("TIMESTAMPDIFF(YEAR, ngay_sinh_hoat_voi_hoi_thanh, CURDATE()) " . ($thoiGianSinhHoat === 'under_1_year' ? '< 1' : ($thoiGianSinhHoat === '1_to_5_years' ? 'BETWEEN 1 AND 5' : '> 5')));
            }
            if ($banNganhId = $request->input('ban_nganh_id')) {
                $query->whereHas('banNganhTinHuu', function ($q) use ($banNganhId) {
                    $q->where('ban_nganh_id', $banNganhId);
                });
            }

            return DataTables::of($query)
                ->addColumn('ban_nganhs', function ($row) {
                    return $row->banNganhTinHuu->map(function ($item) {
                        return [
                            'id' => $item->banNganh->id,
                            'ten' => $item->banNganh->ten,
                            'chuc_vu' => $item->chuc_vu
                        ];
                    })->toArray();
                })
                ->addColumn('action', function ($row) {
                    return '<div class="btn-group">' .
                        '<button class="btn btn-sm btn-info btn-view" data-id="' . $row->id . '" title="Xem chi tiết"><i class="fas fa-eye"></i></button>' .
                        '<button class="btn btn-sm btn-warning btn-edit" data-id="' . $row->id . '" data-toggle="modal" data-target="#modal-sua-tin-huu" title="Chỉnh sửa"><i class="fas fa-edit"></i></button>' .
                        '<button class="btn btn-sm btn-danger btn-delete" data-id="' . $row->id . '" data-name="' . htmlspecialchars($row->ho_ten) . '" data-toggle="modal" data-target="#modal-xoa-tin-huu" title="Xóa"><i class="fas fa-trash"></i></button>' .
                        '</div>';
                })
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy danh sách tín hữu: ' . $e->getMessage());
            return $this->errorResponse('Không thể lấy danh sách tín hữu: ' . $e->getMessage(), 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $tinHuu = TinHuu::with(['hoGiaDinh', 'banNganhTinHuu.banNganh'])->findOrFail($id);
            return $this->successResponse('Lấy chi tiết tín hữu thành công', $tinHuu);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy chi tiết tín hữu: ' . $e->getMessage());
            return $this->errorResponse('Không thể lấy chi tiết tín hữu: ' . $e->getMessage(), 500);
        }
    }

    public function edit(int $id): JsonResponse
    {
        try {
            $tinHuu = TinHuu::with(['banNganhTinHuu'])->findOrFail($id);
            $data = $tinHuu->toArray();
            // Đảm bảo ngày sinh được định dạng đúng Y-m-d
            $data['ngay_sinh'] = $tinHuu->ngay_sinh ? $tinHuu->ngay_sinh->format('Y-m-d') : null;
            $data['ngay_tin_chua'] = $tinHuu->ngay_tin_chua ? $tinHuu->ngay_tin_chua->format('Y-m-d') : null;
            $data['ngay_sinh_hoat_voi_hoi_thanh'] = $tinHuu->ngay_sinh_hoat_voi_hoi_thanh ? $tinHuu->ngay_sinh_hoat_voi_hoi_thanh->format('Y-m-d') : null;
            $data['ngay_nhan_bap_tem'] = $tinHuu->ngay_nhan_bap_tem ? $tinHuu->ngay_nhan_bap_tem->format('Y-m-d') : null;
            $data['ban_nganh_id'] = $tinHuu->banNganhTinHuu->first()->ban_nganh_id ?? null;
            $data['chuc_vu'] = $tinHuu->banNganhTinHuu->first()->chuc_vu ?? null;
            return $this->successResponse('Lấy thông tin chỉnh sửa thành công', $data);
        } catch (\Exception $e) {
            Log::error('Lỗi lấy thông tin chỉnh sửa: ' . $e->getMessage());
            return $this->errorResponse('Không thể lấy thông tin chỉnh sửa: ' . $e->getMessage(), 500);
        }
    }
}
