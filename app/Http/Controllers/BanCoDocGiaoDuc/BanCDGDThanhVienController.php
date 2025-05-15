<?php

namespace App\Http\Controllers\BanCoDocGiaoDuc;

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
use Yajra\DataTables\Facades\DataTables;

class BanCDGDThanhVienController extends Controller
{
    use ApiResponseTrait;

    /**
     * Hiển thị trang chính của ban
     */
    public function index(string $banType, array $config): View
    {
        $banNganh = Cache::remember("ban_{$banType}", now()->addDay(), function () use ($config) {
            return BanNganh::where('id', $config['id'])->first();
        });

        if (!$banNganh) {
            throw new \Exception("Không tìm thấy {$config['name']}");
        }

        $banDieuHanh = Cache::remember("ban_{$banType}_dieu_hanh", now()->addHour(), function () use ($banNganh) {
            return TinHuuBanNganh::with('tinHuu')
                ->where('ban_nganh_id', $banNganh->id)
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

        $banVien = Cache::remember("ban_{$banType}_ban_vien", now()->addHour(), function () use ($banNganh) {
            return TinHuuBanNganh::with('tinHuu')
                ->where('ban_nganh_id', $banNganh->id)
                ->where(function ($query) {
                    $query->whereNull('chuc_vu')
                        ->orWhere('chuc_vu', 'Thành viên')
                        ->orWhere('chuc_vu', '');
                })
                ->orderBy('created_at', 'desc')
                ->get();
        });

        $existingMemberIds = TinHuuBanNganh::where('ban_nganh_id', $banNganh->id)
            ->pluck('tin_huu_id')
            ->toArray();

        $tinHuuList = TinHuu::whereNotIn('id', $existingMemberIds)
            ->orderBy('ho_ten', 'asc')
            ->get();

        return view('_ban_co_doc_giao_duc.index', compact('banNganh', 'banDieuHanh', 'banVien', 'tinHuuList', 'config'));
    }

    /**
     * Lấy danh sách Ban Viên (JSON cho DataTables)
     */
    public function banVienList(Request $request, array $config): JsonResponse
    {
        try {
            Log::info('Gọi banVienList với config:', $config);
            Log::info('Request data:', $request->all());

            $query = TinHuuBanNganh::with([
                'tinHuu' => function ($query) {
                    $query->select(
                        'id',
                        'ho_ten',
                        'ngay_sinh',
                        'dia_chi',
                        'so_dien_thoai',
                        'loai_tin_huu',
                        'ngay_sinh_hoat_voi_hoi_thanh',
                        'ngay_tin_chua',
                        'hoan_thanh_bap_tem',
                        'gioi_tinh',
                        'tinh_trang_hon_nhan'
                    );
                },
                'banNganh' => function ($query) {
                    $query->select('id', 'ten');
                }
            ])
                ->where('ban_nganh_id', $config['id'])
                ->where(function ($q) {
                    $q->whereNull('chuc_vu')
                        ->orWhere('chuc_vu', 'Thành viên')
                        ->orWhere('chuc_vu', '');
                });

            // Áp dụng bộ lọc
            if ($hoTen = $request->input('ho_ten')) {
                $query->whereHas('tinHuu', function ($q) use ($hoTen) {
                    $q->where('ho_ten', 'like', '%' . $hoTen . '%');
                });
            }
            if ($loaiTinHuu = $request->input('loai_tin_huu')) {
                $query->whereHas('tinHuu', function ($q) use ($loaiTinHuu) {
                    $q->where('loai_tin_huu', $loaiTinHuu);
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
            if ($ngaySinh = $request->input('ngay_sinh')) {
                $query->whereHas('tinHuu', function ($q) use ($ngaySinh) {
                    $q->where('ngay_sinh', $ngaySinh);
                });
            }
            if ($gioiTinh = $request->input('gioi_tinh')) {
                $query->whereHas('tinHuu', function ($q) use ($gioiTinh) {
                    $q->where('gioi_tinh', $gioiTinh);
                });
            }
            if ($tinhTrangHonNhan = $request->input('tinh_trang_hon_nhan')) {
                $query->whereHas('tinHuu', function ($q) use ($tinhTrangHonNhan) {
                    $q->where('tinh_trang_hon_nhan', $tinhTrangHonNhan);
                });
            }
            if ($hoanThanhBapTem = $request->input('hoan_thanh_bap_tem')) {
                $query->whereHas('tinHuu', function ($q) use ($hoanThanhBapTem) {
                    $q->where('hoan_thanh_bap_tem', $hoanThanhBapTem);
                });
            }
            if ($tuoi = $request->input('tuoi')) {
                $query->whereHas('tinHuu', function ($q) use ($tuoi) {
                    if ($tuoi === 'under_15') {
                        $q->whereRaw('YEAR(CURDATE()) - YEAR(ngay_sinh) < 15');
                    } elseif ($tuoi === '15') {
                        $q->whereRaw('YEAR(CURDATE()) - YEAR(ngay_sinh) = 15');
                    } elseif ($tuoi === '18') {
                        $q->whereRaw('YEAR(CURDATE()) - YEAR(ngay_sinh) = 18');
                    } elseif ($tuoi === '21') {
                        $q->whereRaw('YEAR(CURDATE()) - YEAR(ngay_sinh) = 21');
                    } elseif ($tuoi === 'above_21') {
                        $q->whereRaw('YEAR(CURDATE()) - YEAR(ngay_sinh) > 21');
                    }
                });
            }
            if ($thoiGianSinhHoat = $request->input('thoi_gian_sinh_hoat')) {
                $query->whereHas('tinHuu', function ($q) use ($thoiGianSinhHoat) {
                    if ($thoiGianSinhHoat === '6_months') {
                        $q->whereRaw('TIMESTAMPDIFF(MONTH, ngay_sinh_hoat_voi_hoi_thanh, CURDATE()) = 6');
                    } elseif ($thoiGianSinhHoat === '1_year') {
                        $q->whereRaw('TIMESTAMPDIFF(MONTH, ngay_sinh_hoat_voi_hoi_thanh, CURDATE()) = 12');
                    } elseif ($thoiGianSinhHoat === '2_years_plus') {
                        $q->whereRaw('TIMESTAMPDIFF(MONTH, ngay_sinh_hoat_voi_hoi_thanh, CURDATE()) >= 24');
                    }
                });
            }

            $dataTable = DataTables::of($query)
                ->addColumn('id', function ($row) {
                    return $row->tin_huu_id;
                })
                ->addColumn('ho_ten', function ($row) {
                    return $row->tinHuu->ho_ten ?? 'N/A';
                })
                ->addColumn('ngay_sinh', function ($row) {
                    return $row->tinHuu->ngay_sinh;
                })
                ->addColumn('dia_chi', function ($row) {
                    return $row->tinHuu->dia_chi ?? 'N/A';
                })
                ->addColumn('so_dien_thoai', function ($row) {
                    return $row->tinHuu->so_dien_thoai ?? 'N/A';
                })
                ->addColumn('ban_nganh', function ($row) {
                    return $row->banNganh->ten ?? 'N/A';
                })
                ->addColumn('loai_tin_huu', function ($row) {
                    return $row->tinHuu->loai_tin_huu ?? 'N/A';
                })
                ->addColumn('ngay_sinh_hoat_voi_hoi_thanh', function ($row) {
                    return $row->tinHuu->ngay_sinh_hoat_voi_hoi_thanh;
                })
                ->addColumn('ngay_tin_chua', function ($row) {
                    return $row->tinHuu->ngay_tin_chua;
                })
                ->addColumn('hoan_thanh_bap_tem', function ($row) {
                    return $row->tinHuu->hoan_thanh_bap_tem;
                })
                ->addColumn('gioi_tinh', function ($row) {
                    return $row->tinHuu->gioi_tinh ?? 'N/A';
                })
                ->addColumn('tinh_trang_hon_nhan', function ($row) {
                    return $row->tinHuu->tinh_trang_hon_nhan ?? 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $tinHuuId = $row->tin_huu_id;
                    $banNganhId = $row->ban_nganh_id;
                    $hoTen = $row->tinHuu ? ($row->tinHuu->ho_ten ?? 'N/A') : 'N/A';
                    $chucVu = $row->chuc_vu ?? 'Thành viên';
                    return '<div class="btn-group">' .
                        '<button class="btn btn-sm btn-info btn-view" data-tin-huu-id="' . $tinHuuId . '" title="Xem chi tiết"><i class="fas fa-eye"></i></button>' .
                        '<button class="btn btn-sm btn-warning btn-edit" data-tin-huu-id="' . $tinHuuId . '" data-ban-nganh-id="' . $banNganhId . '" data-ten-tin-huu="' . htmlspecialchars($hoTen) . '" data-chuc-vu="' . htmlspecialchars($chucVu) . '" data-toggle="modal" data-target="#modal-edit-chuc-vu" title="Chỉnh sửa chức vụ"><i class="fas fa-edit"></i></button>' .
                        '<button class="btn btn-sm btn-danger btn-delete" data-tin-huu-id="' . $tinHuuId . '" data-ban-nganh-id="' . $banNganhId . '" data-ten-tin-huu="' . htmlspecialchars($hoTen) . '" data-toggle="modal" data-target="#modal-xoa-thanh-vien" title="Xóa"><i class="fas fa-trash"></i></button>' .
                        '</div>';
                });

            $response = $dataTable->make(true);
            Log::info('Dữ liệu trả về từ DataTables (banVienList):', json_decode(json_encode($response->getData()), true));

            return $response;
        } catch (\Exception $e) {
            Log::error("Lỗi lấy danh sách Ban Viên: {$e->getMessage()}", ['exception' => $e]);
            return $this->errorResponse("Lỗi hệ thống: {$e->getMessage()}", 500);
        }
    }

    /**
     * Thêm thành viên vào ban
     */
    public function themThanhVien(Request $request, array $config): JsonResponse
    {
        $validatedData = $request->validate([
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'chuc_vu' => 'nullable|string|max:50',
        ]);

        if ($validatedData['ban_nganh_id'] != $config['id']) {
            return $this->errorResponse("Ban ngành không hợp lệ!", 422);
        }

        $exists = TinHuuBanNganh::where('tin_huu_id', $validatedData['tin_huu_id'])
            ->where('ban_nganh_id', $validatedData['ban_nganh_id'])
            ->exists();

        if ($exists) {
            return $this->errorResponse("Thành viên này đã thuộc {$config['name']}!", 422);
        }

        try {
            DB::beginTransaction();
            TinHuuBanNganh::create([
                'tin_huu_id' => $validatedData['tin_huu_id'],
                'ban_nganh_id' => $validatedData['ban_nganh_id'],
                'chuc_vu' => $validatedData['chuc_vu'] ?? 'Thành viên'
            ]);
            $this->clearBanNganhCache($config['view_prefix']);
            DB::commit();
            return $this->successResponse("Đã thêm thành viên vào {$config['name']} thành công!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi thêm thành viên: {$e->getMessage()}");
            return $this->errorResponse("Có lỗi xảy ra: {$e->getMessage()}", 500);
        }
    }

    /**
     * Xóa thành viên khỏi ban
     */
    public function xoaThanhVien(Request $request, array $config): JsonResponse
    {
        $validatedData = $request->validate([
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
        ]);

        if ($validatedData['ban_nganh_id'] != $config['id']) {
            return $this->errorResponse("Ban ngành không hợp lệ!", 422);
        }

        $recordExists = TinHuuBanNganh::where('tin_huu_id', $validatedData['tin_huu_id'])
            ->where('ban_nganh_id', $validatedData['ban_nganh_id'])
            ->exists();

        if (!$recordExists) {
            return $this->notFoundResponse("Không tìm thấy thành viên trong {$config['name']} để xóa.");
        }

        try {
            DB::beginTransaction();
            TinHuuBanNganh::where('tin_huu_id', $validatedData['tin_huu_id'])
                ->where('ban_nganh_id', $validatedData['ban_nganh_id'])
                ->delete();
            $this->clearBanNganhCache($config['view_prefix']);
            DB::commit();
            return $this->successResponse("Đã xóa thành viên khỏi {$config['name']} thành công!");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi khi xóa thành viên khỏi {$config['name']}: {$e->getMessage()}");
            return $this->errorResponse("Đã xảy ra lỗi khi xóa thành viên: {$e->getMessage()}", 500);
        }
    }

    /**
     * Cập nhật chức vụ thành viên trong ban
     */
    public function capNhatChucVu(Request $request, array $config): JsonResponse
    {
        $validatedData = $request->validate([
            'tin_huu_id' => 'required|exists:tin_huu,id',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'chuc_vu' => 'nullable|string|max:50',
        ]);

        if ($validatedData['ban_nganh_id'] != $config['id']) {
            return $this->errorResponse("Ban ngành không hợp lệ!", 422);
        }

        try {
            DB::beginTransaction();

            if ($validatedData['chuc_vu'] === 'Trưởng Ban') {
                $existingTruongBan = TinHuuBanNganh::where('ban_nganh_id', $validatedData['ban_nganh_id'])
                    ->where('chuc_vu', 'Trưởng Ban')
                    ->where('tin_huu_id', '!=', $validatedData['tin_huu_id'])
                    ->first();

                if ($existingTruongBan) {
                    return $this->errorResponse("{$config['name']} đã có Trưởng Ban! Vui lòng thay đổi chức vụ của người hiện tại trước.", 422);
                }

                BanNganh::where('id', $validatedData['ban_nganh_id'])
                    ->update(['truong_ban_id' => $validatedData['tin_huu_id']]);
            }

            TinHuuBanNganh::where('tin_huu_id', $validatedData['tin_huu_id'])
                ->where('ban_nganh_id', $validatedData['ban_nganh_id'])
                ->update(['chuc_vu' => $validatedData['chuc_vu'] ?? 'Thành viên']);

            $this->clearBanNganhCache($config['view_prefix']);
            DB::commit();
            return $this->successResponse('Đã cập nhật chức vụ thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi cập nhật chức vụ: {$e->getMessage()}");
            return $this->errorResponse("Có lỗi xảy ra: {$e->getMessage()}", 500);
        }
    }

    /**
     * Lấy chi tiết thông tin thành viên
     */
    public function chiTietThanhVien(Request $request, array $config): JsonResponse
    {
        try {
            $tinHuuId = $request->query('tin_huu_id');

            if (!$tinHuuId) {
                return $this->errorResponse('Thiếu tham số tin_huu_id', 400);
            }

            $tinHuu = TinHuu::with(['banNganhTinHuu.ban_nganh'])
                ->findOrFail($tinHuuId);

            $data = [
                'ma_tin_huu' => $tinHuu->ma_tin_huu,
                'ho_ten' => $tinHuu->ho_ten,
                'ngay_sinh' => $tinHuu->ngay_sinh,
                'tuoi' => now()->year - ($tinHuu->ngay_sinh ? date('Y', strtotime($tinHuu->ngay_sinh)) : now()->year),
                'so_dien_thoai' => $tinHuu->so_dien_thoai,
                'email' => $tinHuu->email,
                'dia_chi' => $tinHuu->dia_chi,
                'gioi_tinh' => $tinHuu->gioi_tinh,
                'tinh_trang_hon_nhan' => $tinHuu->tinh_trang_hon_nhan,
                'loai_tin_huu' => $tinHuu->loai_tin_huu,
                'ngay_tin_chua' => $tinHuu->ngay_tin_chua,
                'ngay_bap_tem' => $tinHuu->ngay_bap_tem,
                'hoan_thanh_bap_tem' => $tinHuu->hoan_thanh_bap_tem,
                'ngay_sinh_hoat_voi_hoi_thanh' => $tinHuu->ngay_sinh_hoat_voi_hoi_thanh,
                'ban_nganh' => $tinHuu->banNganhTinHuu->first()->ban_nganh->ten ?? 'N/A',
                'chuc_vu' => $tinHuu->banNganhTinHuu->first()->chuc_vu ?? 'Thành viên',
                'nghe_nghiep' => $tinHuu->nghe_nghiep,
                'noi_lam_viec' => $tinHuu->noi_lam_viec,
                'trinh_do_hoc_van' => $tinHuu->trinh_do_hoc_van,
                'chuc_vu_xa_hoi' => $tinHuu->chuc_vu_xa_hoi,
                'nguoi_than' => $tinHuu->nguoi_than,
                'quan_he' => $tinHuu->quan_he,
                'so_dien_thoai_nguoi_than' => $tinHuu->so_dien_thoai_nguoi_than,
            ];

            return $this->successResponse('Lấy chi tiết thành viên thành công', $data);
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy chi tiết thành viên: ' . $e->getMessage());
            return $this->errorResponse('Có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Hiển thị trang điểm danh của ban
     */
    public function diemDanh(Request $request, array $config): View
    {
        $banNganh = BanNganh::where('id', $config['id'])->first();
        if (!$banNganh) {
            return view('errors.custom', ['message' => "Không tìm thấy {$config['name']}"]);
        }

        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $selectedBuoiNhom = $request->input('buoi_nhom_id');
        $selectedBanNganh = $request->input('ban_nganh');

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = Carbon::create()->month($i)->translatedFormat('F');
            $months[$i] = $monthName;
        }

        $currentYear = (int) date('Y');
        $years = range($currentYear - 2, $currentYear + 1);

        $buoiNhomOptions = BuoiNhom::where('ban_nganh_id', $banNganh->id)
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->orderBy('ngay_dien_ra', 'desc')
            ->get();

        $danhSachTinHuu = [];
        $diemDanhData = [];
        $stats = ['co_mat' => 0, 'vang' => 0, 'ti_le_tham_du' => 0];

        if ($selectedBuoiNhom && $selectedBanNganh) {
            // Ánh xạ ban_nganh sang ban_nganh_id từ config
            $banNganhMap = [
                'trung_lao' => config('ban_nganh.trung_lao.id'),
                'thanh_trang' => config('ban_nganh.thanh_trang.id'),
                'thanh_nien' => config('ban_nganh.thanh_nien.id'),
            ];

            $banNganhId = $banNganhMap[$selectedBanNganh] ?? null;
            if ($banNganhId) {
                $danhSachTinHuu = TinHuu::whereHas('banNganhs', function ($query) use ($banNganhId) {
                    $query->where('ban_nganh_id', $banNganhId);
                })->orderBy('ho_ten')->get();

                $chiTietThamGia = ChiTietThamGia::where('buoi_nhom_id', $selectedBuoiNhom)
                    ->whereIn('tin_huu_id', $danhSachTinHuu->pluck('id'))
                    ->get()
                    ->keyBy('tin_huu_id');

                foreach ($chiTietThamGia as $id => $chiTiet) {
                    $diemDanhData[$id] = ['status' => $chiTiet->trang_thai];
                    if ($chiTiet->trang_thai == 'co_mat') {
                        $stats['co_mat']++;
                    }
                }

                $totalMembers = $danhSachTinHuu->count();
                $stats['vang'] = $totalMembers - $stats['co_mat'];
                $stats['ti_le_tham_du'] = $totalMembers > 0 ? round(($stats['co_mat'] / $totalMembers) * 100) : 0;
            }
        }

        $dienGias = DienGia::orderBy('ho_ten')->get();

        return view('_ban_co_doc_giao_duc.diem_danh', compact(
            'banNganh',
            'months',
            'years',
            'month',
            'year',
            'buoiNhomOptions',
            'selectedBuoiNhom',
            'selectedBanNganh',
            'danhSachTinHuu',
            'diemDanhData',
            'stats',
            'dienGias',
            'config'
        ));
    }

    /**
     * Xử lý lưu điểm danh
     */
    public function luuDiemDanh(Request $request, array $config): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'buoi_nhom_id' => 'required|exists:buoi_nhom,id',
            'ban_nganh' => 'required|in:trung_lao,thanh_trang,thanh_nien',
            'attendance' => 'array',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors()->toArray());
        }

        try {
            DB::beginTransaction();
            $buoiNhomId = $request->buoi_nhom_id;
            $banNganh = $request->ban_nganh;
            $attendanceData = $request->attendance ?? [];

            // Ánh xạ ban_nganh sang ban_nganh_id từ config
            $banNganhMap = [
                'trung_lao' => config('ban_nganh.trung_lao.id'),
                'thanh_trang' => config('ban_nganh.thanh_trang.id'),
                'thanh_nien' => config('ban_nganh.thanh_nien.id'),
            ];
            $banNganhId = $banNganhMap[$banNganh] ?? null;

            if (!$banNganhId) {
                return $this->errorResponse("Ban ngành không hợp lệ!", 422);
            }

            // Xóa điểm danh cũ cho ban này
            $tinHuuIds = TinHuuBanNganh::where('ban_nganh_id', $banNganhId)->pluck('tin_huu_id');
            ChiTietThamGia::where('buoi_nhom_id', $buoiNhomId)
                ->whereIn('tin_huu_id', $tinHuuIds)
                ->delete();

            // Lưu điểm danh mới
            $coMatCount = 0;
            foreach ($attendanceData as $tinHuuId => $status) {
                ChiTietThamGia::create([
                    'buoi_nhom_id' => $buoiNhomId,
                    'tin_huu_id' => $tinHuuId,
                    'trang_thai' => 'co_mat',
                ]);
                $coMatCount++;
            }

            // Cập nhật số lượng vào BuoiNhom
            $buoiNhom = BuoiNhom::find($buoiNhomId);
            if ($banNganh == 'trung_lao') {
                $buoiNhom->so_luong_trung_lao = $coMatCount;
            } elseif ($banNganh == 'thanh_trang') {
                $buoiNhom->so_luong_thanh_trang = $coMatCount;
            } elseif ($banNganh == 'thanh_nien') {
                $buoiNhom->so_luong_thanh_nien = $coMatCount;
            }
            $buoiNhom->save();

            DB::commit();
            return $this->successResponse('Đã lưu điểm danh thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi lưu điểm danh: {$e->getMessage()}");
            return $this->errorResponse("Đã xảy ra lỗi khi lưu điểm danh: {$e->getMessage()}", 500);
        }
    }

    /**
     * Thêm buổi nhóm mới
     */
    public function themBuoiNhom(Request $request, array $config): JsonResponse
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

        if ($request->ban_nganh_id != $config['id']) {
            return $this->errorResponse("Ban ngành không hợp lệ!", 422);
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
            Log::error("Lỗi thêm buổi nhóm: {$e->getMessage()}");
            return $this->errorResponse("Đã xảy ra lỗi khi tạo buổi nhóm: {$e->getMessage()}", 500);
        }
    }

    /**
     * Hiển thị trang phân công của ban
     */
    public function phanCong(Request $request, array $config): View
    {
        $banNganh = BanNganh::where('id', $config['id'])->first();
        if (!$banNganh) {
            throw new \Exception("Không tìm thấy {$config['name']}");
        }

        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        $buoiNhoms = BuoiNhom::with(['dienGia', 'tinHuuHdct', 'tinHuuDoKt'])
            ->where('ban_nganh_id', $banNganh->id)
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
            'banNganh',
            'buoiNhoms',
            'dienGias',
            'tinHuus',
            'month',
            'year',
            'months',
            'years',
            'config'
        ));
    }

    /**
     * Cập nhật thông tin buổi nhóm
     */
    public function updateBuoiNhom(Request $request, BuoiNhom $buoiNhom, array $config): JsonResponse
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

        if ($buoiNhom->ban_nganh_id != $config['id']) {
            return $this->forbiddenResponse("Buổi nhóm không thuộc {$config['name']}.");
        }

        try {
            $buoiNhom->update($validator->validated());
            return $this->successResponse('Buổi nhóm đã được cập nhật thành công.', $buoiNhom->fresh()->load(['dienGia', 'tinHuuHdct', 'tinHuuDoKt']));
        } catch (\Exception $e) {
            Log::error("Lỗi cập nhật BuoiNhom {$buoiNhom->id}: {$e->getMessage()}");
            return $this->errorResponse("Đã xảy ra lỗi khi cập nhật buổi nhóm: {$e->getMessage()}", 500);
        }
    }

    /**
     * Xóa buổi nhóm
     */
    public function deleteBuoiNhom(BuoiNhom $buoiNhom, array $config): JsonResponse
    {
        if ($buoiNhom->ban_nganh_id != $config['id']) {
            return $this->forbiddenResponse("Buổi nhóm không thuộc {$config['name']}.");
        }

        try {
            $buoiNhom->delete();
            return $this->successResponse('Buổi nhóm đã được xóa thành công!');
        } catch (\Exception $e) {
            Log::error("Lỗi xóa BuoiNhom {$buoiNhom->id}: {$e->getMessage()}");
            return $this->errorResponse('Lỗi khi xóa buổi nhóm: Có thể do dữ liệu liên quan.', 500);
        }
    }

    /**
     * Hiển thị trang phân công chi tiết nhiệm vụ
     */
    public function phanCongChiTiet(Request $request, array $config): View
    {
        $banNganh = BanNganh::where('id', $config['id'])->first();
        if (!$banNganh) {
            throw new \Exception("Không tìm thấy {$config['name']}");
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

        $buoiNhomOptions = BuoiNhom::where('ban_nganh_id', $banNganh->id)
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->orderBy('ngay_dien_ra', 'desc')
            ->get();

        $currentBuoiNhom = $selectedBuoiNhom ? BuoiNhom::with(['dienGia', 'tinHuuHdct', 'tinHuuDoKt'])->find($selectedBuoiNhom) : null;

        $danhSachNhiemVu = NhiemVu::all();

        $thanhVienBan = TinHuuBanNganh::with('tinHuu')
            ->where('ban_nganh_id', $banNganh->id)
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
            'banNganh',
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
            'daPhanCong',
            'config'
        ));
    }

    /**
     * Lưu phân công nhiệm vụ
     */
    public function phanCongNhiemVu(Request $request, array $config): JsonResponse
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
            if ($buoiNhom->ban_nganh_id != $config['id']) {
                return $this->forbiddenResponse("Buổi nhóm không thuộc {$config['name']}.");
            }

            $isMember = TinHuuBanNganh::where('tin_huu_id', $request->tin_huu_id)
                ->where('ban_nganh_id', $config['id'])
                ->exists();

            if (!$isMember) {
                return $this->forbiddenResponse("Người được phân công không thuộc {$config['name']}.");
            }

            $nhiemVu = NhiemVu::find($request->nhiem_vu_id);
            if ($nhiemVu->id_ban_nganh != $config['id']) {
                return $this->forbiddenResponse("Nhiệm vụ không thuộc {$config['name']}.");
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
            Log::error("Lỗi phân công nhiệm vụ: {$e->getMessage()}");
            return $this->errorResponse("Đã xảy ra lỗi khi phân công nhiệm vụ: {$e->getMessage()}", 500);
        }
    }

    /**
     * Xóa phân công nhiệm vụ
     */
    public function xoaPhanCong($id, array $config): JsonResponse
    {
        try {
            $phanCong = BuoiNhomNhiemVu::find($id);

            if (!$phanCong) {
                return $this->notFoundResponse('Không tìm thấy phân công này.');
            }

            $buoiNhom = BuoiNhom::find($phanCong->buoi_nhom_id);
            if ($buoiNhom->ban_nganh_id != $config['id']) {
                return $this->forbiddenResponse("Không có quyền xóa phân công này.");
            }

            $phanCong->delete();

            return $this->successResponse('Xóa phân công thành công!');
        } catch (\Exception $e) {
            Log::error("Lỗi xóa phân công nhiệm vụ: {$e->getMessage()}");
            return $this->errorResponse("Đã xảy ra lỗi khi xóa phân công: {$e->getMessage()}", 500);
        }
    }

    /**
     * Lấy danh sách Ban Điều Hành (JSON cho DataTables)
     */
    public function dieuHanhList(Request $request, array $config): JsonResponse
    {
        try {
            Log::info('Gọi dieuHanhList với config:', $config);
            Log::info('Request data:', $request->all());

            $query = TinHuuBanNganh::with('tinHuu')
                ->where('ban_nganh_id', $config['id'])
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

            return DataTables::of($query)
                ->addColumn('id', function ($row) {
                    return $row->id;
                })
                ->addColumn('tin_huu_id', function ($row) {
                    return $row->tin_huu_id;
                })
                ->addColumn('ho_ten', function ($row) {
                    return $row->tinHuu->ho_ten ?? 'N/A';
                })
                ->addColumn('chuc_vu', function ($row) {
                    return $row->chuc_vu ?? 'Thành viên';
                })
                ->addColumn('action', function ($row) {
                    $tinHuuId = $row->tin_huu_id;
                    $banNganhId = $row->ban_nganh_id;
                    $hoTen = $row->tinHuu ? ($row->tinHuu->ho_ten ?? 'N/A') : 'N/A';
                    $chucVu = $row->chuc_vu ?? 'Thành viên';
                    return '<div class="btn-group">' .
                        '<button class="btn btn-sm btn-info btn-view" data-tin-huu-id="' . $tinHuuId . '" title="Xem chi tiết"><i class="fas fa-eye"></i></button>' .
                        '<button class="btn btn-sm btn-warning btn-edit" data-tin-huu-id="' . $tinHuuId . '" data-ban-nganh-id="' . $banNganhId . '" data-ten-tin-huu="' . htmlspecialchars($hoTen) . '" data-chuc-vu="' . htmlspecialchars($chucVu) . '" data-toggle="modal" data-target="#modal-edit-chuc-vu" title="Chỉnh sửa chức vụ"><i class="fas fa-edit"></i></button>' .
                        '<button class="btn btn-sm btn-danger btn-delete" data-tin-huu-id="' . $tinHuuId . '" data-ban-nganh-id="' . $banNganhId . '" data-ten-tin-huu="' . htmlspecialchars($hoTen) . '" data-toggle="modal" data-target="#modal-xoa-thanh-vien" title="Xóa"><i class="fas fa-trash"></i></button>' .
                        '</div>';
                })
                ->make(true);
        } catch (\Exception $e) {
            Log::error("Lỗi lấy danh sách Ban Điều Hành: {$e->getMessage()}", ['exception' => $e]);
            return $this->errorResponse("Lỗi hệ thống: {$e->getMessage()}", 500);
        }
    }

    /**
     * Xóa cache liên quan đến ban
     */
    private function clearBanNganhCache(string $viewPrefix): void
    {
        $banType = str_replace('_ban_', '', $viewPrefix);
        Cache::forget("ban_{$banType}");
        Cache::forget("ban_{$banType}_dieu_hanh");
        Cache::forget("ban_{$banType}_ban_vien");
        Cache::forget("ban_{$banType}_thanh_vien");
    }
}