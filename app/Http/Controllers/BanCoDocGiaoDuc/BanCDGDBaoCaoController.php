<?php

namespace App\Http\Controllers\BanCoDocGiaoDuc;

use App\Http\Controllers\Controller;
use App\Models\BanNganh;
use App\Models\BuoiNhom;
use App\Models\DanhGia;
use App\Models\GiaoDichTaiChinh;
use App\Models\KeHoach;
use App\Models\KienNghi;
use App\Models\TinHuu;
use App\Models\TinHuuBanNganh;
use App\Traits\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BanCDGDBaoCaoController extends Controller
{
    use ApiResponseTrait;

    /**
     * Hiển thị form nhập liệu báo cáo ban
     */
    public function formBaoCaoBan(Request $request, array $config): View
    {
        $banType = $config['view_prefix'];
        $banNganh = Cache::remember("ban_{$banType}", now()->addDay(), function () use ($config) {
            return BanNganh::where('id', $config['id'])->first();
        });

        if (!$banNganh) {
            Log::error("formBaoCaoBan: Không tìm thấy ban ngành", ['ban_nganh_id' => $config['id']]);
            throw new \Exception("Không tìm thấy ban ngành với ID {$config['id']}");
        }

        $month = (int) $request->get('month', date('m'));
        $year = (int) $request->get('year', date('Y'));

        // Kiểm tra và thông báo lỗi tháng/năm không hợp lệ
        if ($month < 1 || $month > 12) {
            Session::flash('error', 'Tháng không hợp lệ, đã đặt lại về tháng hiện tại.');
            $month = date('m');
        }
        if ($year < 2020 || $year > date('Y') + 1) {
            Session::flash('error', 'Năm không hợp lệ, đã đặt lại về năm hiện tại.');
            $year = date('Y');
        }

        $buoiNhomType = $request->get('buoi_nhom_type', 1);
        $selectedBanNganh = $request->get('ban_nganh', 'trung_lao');

        $nextMonth = $month == 12 ? 1 : $month + 1;
        $nextYear = $month == 12 ? $year + 1 : $year;

        $banNganhMap = [
            'trung_lao' => config('ban_nganh.trung_lao.id', 1),
            'thanh_trang' => config('ban_nganh.thanh_trang.id', 2),
            'thanh_nien' => config('ban_nganh.thanh_nien.id', 3),
        ];

        // Kiểm tra ánh xạ ban_nganh_id_goi
        if (!isset($banNganhMap[$selectedBanNganh])) {
            Log::error("formBaoCaoBan: Ban ngành không hợp lệ", ['selectedBanNganh' => $selectedBanNganh]);
            throw new \Exception("Ban ngành không hợp lệ: {$selectedBanNganh}");
        }

        $banNganhIdGoi = $banNganhMap[$selectedBanNganh];

        $buoiNhomHT = $buoiNhomType == 13 ? BuoiNhom::with('dienGia')
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', $config['hoi_thanh_id'])
            ->orderBy('ngay_dien_ra')
            ->get() : collect([]);

        // Chỉ lấy danh sách buổi nhóm, không tải quan hệ giaoDichTaiChinh ở đây
        $buoiNhomBN = $buoiNhomType == 1 ? BuoiNhom::with('dienGia')
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', $config['id'])
            ->orderBy('ngay_dien_ra')
            ->get() : collect([]);

        // Kiểm tra và lấy danh sách tín hữu
        $tinHuu = collect([]);
        try {
            $query = TinHuu::select('id', 'ho_ten')
                ->whereHas('banNganhs', function ($query) use ($config) {
                    $query->where('ban_nganh_id', $config['id']);
                })
                ->orderBy('ho_ten');

            $tinHuu = $query->get();

            if (!$tinHuu instanceof \Illuminate\Database\Eloquent\Collection) {
                Log::warning("formBaoCaoBan: Kết quả truy vấn tín hữu không phải collection", [
                    'ban_nganh_id' => $config['id'],
                    'result_type' => gettype($tinHuu)
                ]);
                $tinHuu = collect([]);
            }
        } catch (\Exception $e) {
            Log::error("formBaoCaoBan: Lỗi khi lấy danh sách tín hữu", [
                'ban_nganh_id' => $config['id'],
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $tinHuu = collect([]);
        }

        $keHoach = KeHoach::with('nguoiPhuTrach')
            ->where('ban_nganh_id', $config['id'])
            ->where('thang', $nextMonth)
            ->where('nam', $nextYear)
            ->get();

        $kienNghi = KienNghi::with('nguoiDeXuat')
            ->where('ban_nganh_id', $config['id'])
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $logName = isset($config['name']) ? $config['name'] : "Ban ID {$config['id']}";
        Log::info("formBaoCaoBan {$logName}: Tải dữ liệu", [
            'month' => $month,
            'year' => $year,
            'selectedBanNganh' => $selectedBanNganh,
            'ban_nganh_id_goi' => $banNganhIdGoi,
            'buoi_nhom_count' => $buoiNhomBN->count(),
            'tin_huu_count' => $tinHuu->count(),
            'tin_huu_type' => get_class($tinHuu),
            'ke_hoach_count' => $keHoach->count(),
            'kien_nghi_count' => $kienNghi->count()
        ]);

        return view('_ban_co_doc_giao_duc.nhap_lieu_bao_cao', compact(
            'config',
            'banNganh',
            'month',
            'year',
            'buoiNhomType',
            'selectedBanNganh',
            'buoiNhomHT',
            'buoiNhomBN',
            'tinHuu',
            'nextMonth',
            'nextYear',
            'keHoach',
            'kienNghi',
            'banNganhIdGoi' // Truyền thêm biến này để sử dụng trong view
        ));
    }

    /**
     * Hiển thị báo cáo hoàn thiện của ban
     */
    public function baoCaoBan(Request $request, array $config): View
    {
        $month = (int) $request->get('month', date('m'));
        $year = (int) $request->get('year', date('Y'));

        // Kiểm tra và thông báo lỗi tháng/năm không hợp lệ
        if ($month < 1 || $month > 12) {
            Session::flash('error', 'Tháng không hợp lệ, đã đặt lại về tháng hiện tại.');
            $month = date('m');
        }
        if ($year < 2020 || $year > date('Y') + 1) {
            Session::flash('error', 'Năm không hợp lệ, đã đặt lại về năm hiện tại.');
            $year = date('Y');
        }

        $logName = isset($config['name']) ? $config['name'] : "Ban ID {$config['id']}";
        Log::info("baoCaoBan {$logName}: Bắt đầu xử lý báo cáo", [
            'month' => $month,
            'year' => $year,
            'config' => [
                'id' => $config['id'],
                'hoi_thanh_id' => $config['hoi_thanh_id'],
                'view_prefix' => $config['view_prefix']
            ]
        ]);

        $nextMonth = $month == 12 ? 1 : $month + 1;
        $nextYear = $month == 12 ? $year + 1 : $year;

        $banDieuHanh = Cache::remember("ban_dieu_hanh_{$config['id']}_{$month}_{$year}", now()->addHour(), function () use ($config) {
            return TinHuuBanNganh::with([
                'tinHuu' => function ($query) {
                    $query->select('id', 'ho_ten');
                }
            ])
                ->select('id', 'tin_huu_id', 'ban_nganh_id', 'chuc_vu')
                ->where('ban_nganh_id', $config['id'])
                ->whereNotNull('chuc_vu')
                ->get();
        });

        Log::info("baoCaoBan {$logName}: Dữ liệu ban điều hành", [
            'count' => $banDieuHanh->count()
        ]);

        $buoiNhomHT = BuoiNhom::with([
            'dienGia' => function ($query) {
                $query->select('id', 'ho_ten');
            }
        ])
            ->select('id', 'ban_nganh_id', 'dien_gia_id', 'chu_de', 'ngay_dien_ra', 'so_luong_trung_lao', 'so_luong_thanh_trang', 'so_luong_thanh_nien', 'kinh_thanh', 'ghi_chu')
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', $config['hoi_thanh_id'])
            ->orderBy('ngay_dien_ra')
            ->get();

        Log::info("baoCaoBan {$logName}: Dữ liệu buổi nhóm Hội Thánh", [
            'count' => $buoiNhomHT->count()
        ]);

        $buoiNhomBN = BuoiNhom::with([
            'dienGia' => function ($query) {
                $query->select('id', 'ho_ten');
            },
            'giaoDichTaiChinh' => function ($query) {
                $query->select('id', 'buoi_nhom_id', 'so_tien', 'mo_ta', 'ban_nganh_id_goi');
            }
        ])
            ->select('id', 'ban_nganh_id', 'dien_gia_id', 'chu_de', 'ngay_dien_ra', 'so_luong_trung_lao', 'so_luong_thanh_trang', 'so_luong_thanh_nien', 'kinh_thanh', 'ghi_chu')
            ->whereYear('ngay_dien_ra', $year)
            ->whereMonth('ngay_dien_ra', $month)
            ->where('ban_nganh_id', $config['id'])
            ->orderBy('ngay_dien_ra')
            ->get();

        Log::info("baoCaoBan {$logName}: Dữ liệu buổi nhóm Ban Ngành", [
            'count' => $buoiNhomBN->count()
        ]);

        $giaoDich = GiaoDichTaiChinh::select('id', 'ban_nganh_id', 'loai', 'so_tien', 'mo_ta', 'ngay_giao_dich', 'ban_nganh_id_goi')
            ->whereYear('ngay_giao_dich', $year)
            ->whereMonth('ngay_giao_dich', $month)
            ->where('ban_nganh_id', $config['id'])
            ->orderBy('ngay_giao_dich')
            ->get();

        $tongThu = $giaoDich->where('loai', 'thu')->sum('so_tien');
        $tongChi = $giaoDich->where('loai', 'chi')->sum('so_tien');
        $tongTon = $tongThu - $tongChi;

        // Tính tổng thu theo từng lớp
        $tongThuTrungLao = $giaoDich->where('loai', 'thu')->where('ban_nganh_id_goi', config('ban_nganh.trung_lao.id', 1))->sum('so_tien');
        $tongThuThanhTrang = $giaoDich->where('loai', 'thu')->where('ban_nganh_id_goi', config('ban_nganh.thanh_trang.id', 2))->sum('so_tien');
        $tongThuThanhNien = $giaoDich->where('loai', 'thu')->where('ban_nganh_id_goi', config('ban_nganh.thanh_nien.id', 3))->sum('so_tien');

        $taiChinh = [
            'tongThu' => $tongThu,
            'tongChi' => $tongChi,
            'tongTon' => $tongTon,
            'tongThuTrungLao' => $tongThuTrungLao,
            'tongThuThanhTrang' => $tongThuThanhTrang,
            'tongThuThanhNien' => $tongThuThanhNien,
            'giaoDich' => $giaoDich,
        ];

        Log::info("baoCaoBan {$logName}: Dữ liệu tài chính", [
            'tongThu' => $tongThu,
            'tongChi' => $tongChi,
            'tongTon' => $tongTon,
            'tongThuTrungLao' => $tongThuTrungLao,
            'tongThuThanhTrang' => $tongThuThanhTrang,
            'tongThuThanhNien' => $tongThuThanhNien,
            'giaoDich_count' => $giaoDich->count()
        ]);

        $thamVieng = Cache::remember("tham_vieng_{$config['id']}_{$month}_{$year}", now()->addHour(), function () use ($config, $month, $year) {
            return \App\Models\ThamVieng::with([
                'tinHuu' => function ($query) {
                    $query->select('id', 'ho_ten');
                },
                'nguoiTham' => function ($query) {
                    $query->select('id', 'ho_ten');
                }
            ])
                ->select('id', 'id_ban', 'tin_huu_id', 'nguoi_tham_id', 'ngay_tham', 'noi_dung') // Xóa 'loai_tham'
                ->whereYear('ngay_tham', $year)
                ->whereMonth('ngay_tham', $month)
                ->where('id_ban', $config['id'])
                ->orderBy('ngay_tham')
                ->get();
        });

        Log::info("baoCaoBan {$logName}: Dữ liệu thăm viếng", [
            'count' => $thamVieng->count()
        ]);

        $keHoach = Cache::remember("ke_hoach_{$config['id']}_{$nextMonth}_{$nextYear}", now()->addHour(), function () use ($config, $nextMonth, $nextYear) {
            return KeHoach::with([
                'nguoiPhuTrach' => function ($query) {
                    $query->select('id', 'ho_ten');
                }
            ])
                ->select('id', 'ban_nganh_id', 'hoat_dong', 'thoi_gian', 'nguoi_phu_trach_id', 'ghi_chu', 'thang', 'nam')
                ->where('ban_nganh_id', $config['id'])
                ->where('thang', $nextMonth)
                ->where('nam', $nextYear)
                ->get();
        });

        Log::info("baoCaoBan {$logName}: Dữ liệu kế hoạch", [
            'count' => $keHoach->count(),
            'nextMonth' => $nextMonth,
            'nextYear' => $nextYear
        ]);

        $diemManh = DanhGia::with([
            'nguoiDanhGia' => function ($query) {
                $query->select('id', 'ho_ten');
            }
        ])
            ->select('id', 'ban_nganh_id', 'loai', 'noi_dung', 'nguoi_danh_gia_id', 'thang', 'nam')
            ->where('ban_nganh_id', $config['id'])
            ->where('loai', 'diem_manh')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        $diemYeu = DanhGia::with([
            'nguoiDanhGia' => function ($query) {
                $query->select('id', 'ho_ten');
            }
        ])
            ->select('id', 'ban_nganh_id', 'loai', 'noi_dung', 'nguoi_danh_gia_id', 'thang', 'nam')
            ->where('ban_nganh_id', $config['id'])
            ->where('loai', 'diem_yeu')
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        Log::info("baoCaoBan {$logName}: Dữ liệu đánh giá", [
            'diemManh_count' => $diemManh->count(),
            'diemYeu_count' => $diemYeu->count()
        ]);

        $kienNghi = KienNghi::with([
            'nguoiDeXuat' => function ($query) {
                $query->select('id', 'ho_ten');
            }
        ])
            ->select('id', 'ban_nganh_id', 'tieu_de', 'noi_dung', 'nguoi_de_xuat_id', 'trang_thai', 'thang', 'nam')
            ->where('ban_nganh_id', $config['id'])
            ->where('thang', $month)
            ->where('nam', $year)
            ->get();

        Log::info("baoCaoBan {$logName}: Dữ liệu kiến nghị", [
            'count' => $kienNghi->count()
        ]);

        $totalMeetings = $buoiNhomBN->count();
        $avgAttendance = $totalMeetings > 0 ? round(($buoiNhomBN->sum('so_luong_trung_lao') + $buoiNhomBN->sum('so_luong_thanh_trang') + $buoiNhomBN->sum('so_luong_thanh_nien')) / $totalMeetings) : 0;
        $totalOffering = $tongThu;
        $totalVisits = $thamVieng->count();

        $summary = [
            'totalMeetings' => $totalMeetings,
            'avgAttendance' => $avgAttendance,
            'totalOffering' => $totalOffering,
            'totalVisits' => $totalVisits,
        ];

        Log::info("baoCaoBan {$logName}: Thống kê", [
            'summary' => $summary
        ]);

        return view("{$config['view_prefix']}.bao_cao", compact(
            'config',
            'month',
            'year',
            'nextMonth',
            'nextYear',
            'banDieuHanh',
            'buoiNhomHT',
            'buoiNhomBN',
            'taiChinh',
            'thamVieng',
            'keHoach',
            'summary',
            'diemManh',
            'diemYeu',
            'kienNghi'
        ));
    }

    /**
     * Cập nhật số lượng tham dự và dâng hiến cho một buổi nhóm
     */
    public function updateThamDu(Request $request, array $config): JsonResponse
    {
        $logName = isset($config['name']) ? $config['name'] : "Ban ID {$config['id']}";
        Log::info("updateThamDu {$logName}: Nhận yêu cầu", $request->all());

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:buoi_nhom,id',
            'ban_nganh' => 'required|in:trung_lao,thanh_trang,thanh_nien',
            'so_luong' => 'required|integer|min:0',
            'dang_hien' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        $banNganhMap = [
            'trung_lao' => config('ban_nganh.trung_lao.id', 1),
            'thanh_trang' => config('ban_nganh.thanh_trang.id', 2),
            'thanh_nien' => config('ban_nganh.thanh_nien.id', 3),
        ];

        $selectedBanNganh = $request->input('ban_nganh');
        $banNganhIdGoi = $banNganhMap[$selectedBanNganh] ?? null;

        if (!$banNganhIdGoi) {
            return response()->json([
                'success' => false,
                'message' => 'Ban ngành không hợp lệ'
            ], 400);
        }

        $buoiNhom = BuoiNhom::find($request->input('id'));

        if (!$buoiNhom) {
            return response()->json([
                'success' => false,
                'message' => 'Buổi nhóm không tồn tại'
            ], 404);
        }

        // Cập nhật số lượng dựa trên ban_nganh
        if ($selectedBanNganh === 'trung_lao') {
            $buoiNhom->so_luong_trung_lao = $request->input('so_luong');
        } elseif ($selectedBanNganh === 'thanh_trang') {
            $buoiNhom->so_luong_thanh_trang = $request->input('so_luong');
        } elseif ($selectedBanNganh === 'thanh_nien') {
            $buoiNhom->so_luong_thanh_nien = $request->input('so_luong');
        }

        $buoiNhom->save();

        // Lưu hoặc cập nhật giao dịch tài chính
        if ($request->input('dang_hien') > 0) {
            $giaoDichData = [
                'ban_nganh_id' => $config['id'],
                'ban_nganh_id_goi' => $banNganhIdGoi,
                'buoi_nhom_id' => $buoiNhom->id,
                'loai' => 'thu',
                'hinh_thuc' => 'dang_hien',
                'so_tien' => (int) $request->input('dang_hien'),
                'mo_ta' => "Tiền dâng TCN ban {$selectedBanNganh} ngày " . Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y'),
                'ngay_giao_dich' => $buoiNhom->ngay_dien_ra,
                'trang_thai' => 'hoan_thanh',
            ];

            Log::info("updateThamDu {$logName}: Lưu giao dịch tài chính", $giaoDichData);

            GiaoDichTaiChinh::updateOrCreate(
                [
                    'buoi_nhom_id' => $buoiNhom->id,
                    'ban_nganh_id' => $config['id'],
                    'ban_nganh_id_goi' => $banNganhIdGoi,
                    'hinh_thuc' => 'dang_hien',
                ],
                $giaoDichData
            );
        }

        Log::info("updateThamDu {$logName}: Cập nhật thành công");

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật số lượng tham dự và dâng hiến thành công!'
        ]);
    }

    /**
     * Lưu tất cả số lượng tham dự và dâng hiến
     */
    public function saveThamDu(Request $request, array $config): JsonResponse
    {
        $logName = isset($config['name']) ? $config['name'] : "Ban ID {$config['id']}";
        Log::info("saveThamDu {$logName}: Nhận yêu cầu", $request->all());

        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'ban_nganh' => 'required|in:trung_lao,thanh_trang,thanh_nien',
            'buoi_nhom' => 'required|array',
            'buoi_nhom.*.id' => 'required|exists:buoi_nhom,id',
            'buoi_nhom.*.so_luong' => 'required|integer|min:0',
            'buoi_nhom.*.dang_hien' => 'nullable|string'
        ], [
            'month.required' => 'Tháng là bắt buộc.',
            'month.integer' => 'Tháng phải là số nguyên.',
            'month.min' => 'Tháng phải từ 1 trở lên.',
            'month.max' => 'Tháng không được lớn hơn 12.',
            'ban_nganh_id.required' => 'ID ban ngành là bắt buộc.',
            'ban_nganh.required' => 'Ban ngành là bắt buộc.',
            'ban_nganh.in' => 'Ban ngành không hợp lệ.',
            'buoi_nhom.*.id.required' => 'ID buổi nhóm là bắt buộc.',
            'buoi_nhom.*.id.exists' => 'Buổi nhóm không tồn tại.',
            'buoi_nhom.*.so_luong.required' => 'Số lượng tham dự là bắt buộc.',
            'buoi_nhom.*.so_luong.integer' => 'Số lượng tham dự phải là số nguyên.',
            'buoi_nhom.*.so_luong.min' => 'Số lượng tham dự không được nhỏ hơn 0.'
        ]);

        if ($validator->fails()) {
            Log::error("saveThamDu {$logName}: Validation thất bại", ['errors' => $validator->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->ban_nganh_id != $config['id']) {
            return response()->json([
                'success' => false,
                'message' => 'Ban ngành không hợp lệ!'
            ], 422);
        }

        DB::beginTransaction();

        try {
            $banNganh = $request->ban_nganh;
            $banNganhMap = [
                'trung_lao' => config('ban_nganh.trung_lao.id', 1),
                'thanh_trang' => config('ban_nganh.thanh_trang.id', 2),
                'thanh_nien' => config('ban_nganh.thanh_nien.id', 3),
            ];
            $banNameMap = [
                'trung_lao' => 'Trung Lão',
                'thanh_trang' => 'Thanh Tráng',
                'thanh_nien' => 'Thanh Niên',
            ];

            // Kiểm tra ánh xạ ban_nganh_id_goi
            if (!isset($banNganhMap[$banNganh])) {
                Log::error("saveThamDu {$logName}: Ban ngành không hợp lệ", ['ban_nganh' => $banNganh]);
                return response()->json([
                    'success' => false,
                    'message' => 'Ban ngành không hợp lệ: ' . $banNganh
                ], 422);
            }

            foreach ($request->buoi_nhom as $id => $data) {
                $buoiNhom = BuoiNhom::findOrFail($data['id']);
                if ($banNganh == 'trung_lao') {
                    $buoiNhom->so_luong_trung_lao = $data['so_luong'];
                } elseif ($banNganh == 'thanh_trang') {
                    $buoiNhom->so_luong_thanh_trang = $data['so_luong'];
                } elseif ($banNganh == 'thanh_nien') {
                    $buoiNhom->so_luong_thanh_nien = $data['so_luong'];
                }
                $buoiNhom->save();

                if ($buoiNhom->ban_nganh_id == $config['id'] && isset($data['dang_hien']) && $data['dang_hien'] !== null) {
                    $dangHien = preg_replace('/[^0-9]/', '', $data['dang_hien']);
                    $dangHien = (int) $dangHien;

                    if ($dangHien > 0) {
                        $existingRecord = GiaoDichTaiChinh::where([
                            'buoi_nhom_id' => $buoiNhom->id,
                            'ban_nganh_id' => $config['id'],
                            'ban_nganh_id_goi' => $banNganhMap[$banNganh],
                        ])->first();

                        if ($existingRecord) {
                            $existingRecord->update([
                                'so_tien' => $dangHien,
                                'mo_ta' => "Tiền dâng TCN ban {$banNameMap[$banNganh]} vào ngày " . Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y'),
                            ]);
                        } else {
                            GiaoDichTaiChinh::create([
                                'buoi_nhom_id' => $buoiNhom->id,
                                'ban_nganh_id' => $config['id'],
                                'ban_nganh_id_goi' => $banNganhMap[$banNganh],
                                'loai' => 'thu',
                                'hinh_thuc' => 'dang_hien',
                                'so_tien' => $dangHien,
                                'mo_ta' => "Tiền dâng TCN ban {$banNameMap[$banNganh]} vào ngày " . Carbon::parse($buoiNhom->ngay_dien_ra)->format('d/m/Y'),
                                'ngay_giao_dich' => $buoiNhom->ngay_dien_ra,
                                'trang_thai' => 'hoan_thanh',
                            ]);
                        }

                        Log::info("saveThamDu {$logName}: Lưu giao dịch tài chính", [
                            'ban_nganh_id' => $config['id'],
                            'ban_nganh_id_goi' => $banNganhMap[$banNganh],
                            'buoi_nhom_id' => $buoiNhom->id,
                            'so_tien' => $dangHien
                        ]);
                    }
                }
            }

            // Xóa cache liên quan
            Cache::forget("ban_{$config['view_prefix']}");
            Cache::forget("ban_dieu_hanh_{$config['id']}_{$request->month}_{$request->year}");

            DB::commit();
            Log::info("saveThamDu {$logName}: Lưu thành công");
            return response()->json([
                'success' => true,
                'message' => 'Đã lưu số lượng tham dự và dâng hiến thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("saveThamDu {$logName}: Lỗi lưu", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => "Lỗi: {$e->getMessage()}"
            ], 500);
        }
    }

    /**
     * Lưu đánh giá báo cáo (dành cho AJAX)
     */
    public function saveDanhGia(Request $request, array $config): JsonResponse
    {
        $logName = isset($config['name']) ? $config['name'] : "Ban ID {$config['id']}";
        Log::info("saveDanhGia {$logName}: Nhận yêu cầu", $request->all());

        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'loai' => 'required|in:diem_manh,diem_yeu',
            'noi_dung' => 'required|string'
        ]);

        if ($validator->fails()) {
            Log::error("saveDanhGia {$logName}: Validation thất bại", ['errors' => $validator->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first()
            ], 422);
        }

        if ($request->ban_nganh_id != $config['id']) {
            return response()->json([
                'success' => false,
                'message' => 'Ban ngành không hợp lệ!'
            ], 422);
        }

        if (!Auth::check()) {
            Log::error("saveDanhGia {$logName}: Người dùng chưa đăng nhập");
            return response()->json([
                'success' => false,
                'message' => 'Người dùng chưa đăng nhập.'
            ], 401);
        }

        $user = Auth::user();
        if (!$user->tin_huu_id) {
            Log::error("saveDanhGia {$logName}: Người dùng không có tin_huu_id", ['user_id' => $user->id]);
            return response()->json([
                'success' => false,
                'message' => 'Không thể xác định người đánh giá. Vui lòng kiểm tra thông tin người dùng (tin_huu_id không tồn tại).'
            ], 422);
        }

        DB::beginTransaction();

        try {
            $danhGia = DanhGia::create([
                'ban_nganh_id' => $config['id'],
                'loai' => $request->loai,
                'noi_dung' => $request->noi_dung,
                'thang' => $request->month,
                'nam' => $request->year,
                'nguoi_danh_gia_id' => $user->tin_huu_id
            ]);

            // Xóa cache liên quan
            Cache::forget("ban_{$config['view_prefix']}_danh_gia_{$request->month}_{$request->year}");

            DB::commit();
            Log::info("saveDanhGia {$logName}: Lưu thành công", ['danh_gia_id' => $danhGia->id, 'nguoi_danh_gia_id' => $user->tin_huu_id]);
            return response()->json([
                'success' => true,
                'message' => 'Đã lưu đánh giá thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("saveDanhGia {$logName}: Lỗi lưu đánh giá", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => "Lỗi: {$e->getMessage()}"
            ], 500);
        }
    }

    /**
     * Lưu đánh giá báo cáo (dành cho form web)
     */
    public function saveDanhGiaWeb(Request $request, array $config)
    {
        $logName = isset($config['name']) ? $config['name'] : "Ban ID {$config['id']}";
        Log::info("saveDanhGiaWeb {$logName}: Nhận yêu cầu", $request->all());

        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'diem_manh' => 'required|array',
            'diem_manh_id' => 'required|array',
            'diem_yeu' => 'required|array',
            'diem_yeu_id' => 'required|array'
        ]);

        if ($validator->fails()) {
            Log::error("saveDanhGiaWeb {$logName}: Validation thất bại", ['errors' => $validator->errors()]);
            return redirect()->back()->with('error', 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first());
        }

        if ($request->ban_nganh_id != $config['id']) {
            return redirect()->back()->with('error', 'Ban ngành không hợp lệ!');
        }

        if (!Auth::check()) {
            Log::error("saveDanhGiaWeb {$logName}: Người dùng chưa đăng nhập");
            return redirect()->back()->with('error', 'Người dùng chưa đăng nhập.');
        }

        $user = Auth::user();
        if (!$user->tin_huu_id) {
            Log::error("saveDanhGiaWeb {$logName}: Người dùng không có tin_huu_id", ['user_id' => $user->id]);
            return redirect()->back()->with('error', 'Không thể xác định người đánh giá. Vui lòng kiểm tra thông tin người dùng (tin_huu_id không tồn tại).');
        }

        DB::beginTransaction();

        try {
            // Lưu điểm mạnh
            foreach ($request->diem_manh as $index => $noiDung) {
                $id = $request->diem_manh_id[$index];

                if (empty($noiDung)) {
                    continue;
                }

                if ($id > 0) {
                    $danhGia = DanhGia::findOrFail($id);
                    $danhGia->noi_dung = $noiDung;
                    $danhGia->save();
                } else {
                    DanhGia::create([
                        'ban_nganh_id' => $config['id'],
                        'loai' => 'diem_manh',
                        'noi_dung' => $noiDung,
                        'thang' => $request->month,
                        'nam' => $request->year,
                        'nguoi_danh_gia_id' => $user->tin_huu_id
                    ]);
                }
            }

            // Lưu điểm yếu
            foreach ($request->diem_yeu as $index => $noiDung) {
                $id = $request->diem_yeu_id[$index];

                if (empty($noiDung)) {
                    continue;
                }

                if ($id > 0) {
                    $danhGia = DanhGia::findOrFail($id);
                    $danhGia->noi_dung = $noiDung;
                    $danhGia->save();
                } else {
                    DanhGia::create([
                        'ban_nganh_id' => $config['id'],
                        'loai' => 'diem_yeu',
                        'noi_dung' => $noiDung,
                        'thang' => $request->month,
                        'nam' => $request->year,
                        'nguoi_danh_gia_id' => $user->tin_huu_id
                    ]);
                }
            }

            // Xóa cache liên quan
            Cache::forget("ban_{$config['view_prefix']}_danh_gia_{$request->month}_{$request->year}");

            DB::commit();
            Log::info("saveDanhGiaWeb {$logName}: Lưu thành công", ['nguoi_danh_gia_id' => $user->tin_huu_id]);
            return redirect()->back()->with('success', 'Đã lưu đánh giá thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("saveDanhGiaWeb {$logName}: Lỗi lưu đánh giá", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', "Lỗi: {$e->getMessage()}");
        }
    }

    /**
     * Lưu kế hoạch báo cáo
     */
    public function saveKeHoach(Request $request, array $config): JsonResponse
    {
        $logName = isset($config['name']) ? $config['name'] : "Ban ID {$config['id']}";
        Log::info("saveKeHoach {$logName}: Nhận yêu cầu", $request->all());

        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'kehoach' => 'required|array',
            'kehoach.*.hoat_dong' => 'required|string',
            'kehoach.*.thoi_gian' => 'nullable|string',
            'kehoach.*.nguoi_phu_trach_id' => 'nullable|exists:tin_huu,id',
            'kehoach.*.ghi_chu' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            Log::error("saveKeHoach {$logName}: Validation thất bại", ['errors' => $validator->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->ban_nganh_id != $config['id']) {
            return response()->json([
                'success' => false,
                'message' => 'Ban ngành không hợp lệ!'
            ], 422);
        }

        DB::beginTransaction();

        try {
            foreach ($request->kehoach as $data) {
                $id = $data['id'] ?? 0;

                if (empty($data['hoat_dong'])) {
                    continue;
                }

                if ($id > 0) {
                    $keHoach = KeHoach::findOrFail($id);
                    $keHoach->update([
                        'hoat_dong' => $data['hoat_dong'],
                        'thoi_gian' => $data['thoi_gian'] ?? '',
                        'nguoi_phu_trach_id' => $data['nguoi_phu_trach_id'] ?? null,
                        'ghi_chu' => $data['ghi_chu'] ?? ''
                    ]);
                } else {
                    $keHoach = KeHoach::create([
                        'ban_nganh_id' => $config['id'],
                        'hoat_dong' => $data['hoat_dong'],
                        'thoi_gian' => $data['thoi_gian'] ?? '',
                        'nguoi_phu_trach_id' => $data['nguoi_phu_trach_id'] ?? null,
                        'ghi_chu' => $data['ghi_chu'] ?? '',
                        'thang' => $request->month,
                        'nam' => $request->year,
                        'trang_thai' => 'chua_thuc_hien'
                    ]);
                }
            }

            // Xóa cache liên quan
            Cache::forget("ke_hoach_{$config['id']}_{$request->month}_{$request->year}");

            DB::commit();
            Log::info("saveKeHoach {$logName}: Lưu thành công");
            return response()->json([
                'success' => true,
                'message' => 'Đã lưu kế hoạch thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("saveKeHoach {$logName}: Lỗi lưu kế hoạch", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => "Lỗi: {$e->getMessage()}"
            ], 500);
        }
    }

    /**
     * Lưu kiến nghị báo cáo
     */
    public function saveKienNghi(Request $request, array $config): JsonResponse
    {
        $logName = isset($config['name']) ? $config['name'] : "Ban ID {$config['id']}";
        Log::info("saveKienNghi {$logName}: Nhận yêu cầu", $request->all());

        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'kiennghi' => 'required|array',
            'kiennghi.*.tieu_de' => 'required|string',
            'kiennghi.*.noi_dung' => 'required|string',
            'kiennghi.*.nguoi_de_xuat_id' => 'nullable|exists:tin_huu,id',
            'kiennghi.*.phan_hoi' => 'nullable|string',
            'kiennghi.*.trang_thai' => 'nullable|in:moi,da_xem,da_xu_ly'
        ]);

        if ($validator->fails()) {
            Log::error("saveKienNghi {$logName}: Validation thất bại", ['errors' => $validator->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->ban_nganh_id != $config['id']) {
            return response()->json([
                'success' => false,
                'message' => 'Ban ngành không hợp lệ!'
            ], 422);
        }

        DB::beginTransaction();

        try {
            $user = Auth::user();
            if (!$user || !$user->tin_huu_id) {
                Log::error("saveKienNghi {$logName}: Người dùng không có tin_huu_id", ['user_id' => $user ? $user->id : null]);
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xác định người đề xuất. Vui lòng kiểm tra thông tin người dùng (tin_huu_id không tồn tại).'
                ], 422);
            }

            foreach ($request->kiennghi as $data) {
                $id = $data['id'] ?? 0;

                if (empty($data['tieu_de']) || empty($data['noi_dung'])) {
                    continue;
                }

                if ($id > 0) {
                    $kienNghi = KienNghi::findOrFail($id);
                    $kienNghi->update([
                        'tieu_de' => $data['tieu_de'],
                        'noi_dung' => $data['noi_dung'],
                        'nguoi_de_xuat_id' => $data['nguoi_de_xuat_id'] ?? $user->tin_huu_id,
                        'trang_thai' => $data['trang_thai'] ?? 'moi',
                        'phan_hoi' => $data['phan_hoi'] ?? null
                    ]);
                } else {
                    $kienNghi = KienNghi::create([
                        'ban_nganh_id' => $config['id'],
                        'tieu_de' => $data['tieu_de'],
                        'noi_dung' => $data['noi_dung'],
                        'nguoi_de_xuat_id' => $data['nguoi_de_xuat_id'] ?? $user->tin_huu_id,
                        'thang' => $request->month,
                        'nam' => $request->year,
                        'trang_thai' => $data['trang_thai'] ?? 'moi',
                        'phan_hoi' => $data['phan_hoi'] ?? null
                    ]);
                }
            }

            // Xóa cache liên quan
            Cache::forget("ban_{$config['view_prefix']}_kien_nghi_{$request->month}_{$request->year}");

            DB::commit();
            Log::info("saveKienNghi {$logName}: Lưu thành công", ['nguoi_de_xuat_id' => $user->tin_huu_id]);
            return response()->json([
                'success' => true,
                'message' => 'Đã lưu kiến nghị thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("saveKienNghi {$logName}: Lỗi lưu kiến nghị", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => "Lỗi: {$e->getMessage()}"
            ], 500);
        }
    }

    /**
     * Lưu toàn bộ báo cáo ban
     */
    public function luuBaoCao(Request $request, array $config): JsonResponse
    {
        $logName = isset($config['name']) ? $config['name'] : "Ban ID {$config['id']}";
        Log::info("luuBaoCao {$logName}: Nhận yêu cầu", $request->all());

        DB::beginTransaction();

        try {
            if ($request->has('buoi_nhom')) {
                $requestForThamDu = new Request($request->only(['month', 'year', 'ban_nganh_id', 'buoi_nhom', 'ban_nganh']));
                $this->saveThamDu($requestForThamDu, $config);
            }

            if ($request->has('loai') && $request->has('noi_dung')) {
                $requestForDanhGia = new Request($request->only(['month', 'year', 'ban_nganh_id', 'loai', 'noi_dung']));
                $this->saveDanhGia($requestForDanhGia, $config);
            } elseif ($request->has('diem_manh') || $request->has('diem_yeu')) {
                $requestForDanhGia = new Request($request->only(['month', 'year', 'ban_nganh_id', 'diem_manh', 'diem_manh_id', 'diem_yeu', 'diem_yeu_id']));
                $this->saveDanhGiaWeb($requestForDanhGia, $config);
            }

            if ($request->has('kehoach')) {
                $requestForKeHoach = new Request($request->only(['month', 'year', 'ban_nganh_id', 'kehoach']));
                $this->saveKeHoach($requestForKeHoach, $config);
            }

            if ($request->has('kiennghi')) {
                $requestForKienNghi = new Request($request->only(['month', 'year', 'ban_nganh_id', 'kiennghi']));
                $this->saveKienNghi($requestForKienNghi, $config);
            }

            DB::commit();
            Log::info("luuBaoCao {$logName}: Lưu thành công");
            return response()->json([
                'success' => true,
                'message' => 'Đã lưu báo cáo thành công!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("luuBaoCao {$logName}: Lỗi lưu báo cáo tổng hợp", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => "Lỗi: {$e->getMessage()}"
            ], 500);
        }
    }

    /**
     * Xóa đánh giá (điểm mạnh hoặc điểm yếu)
     */
    public function xoaDanhGia($id, array $config): JsonResponse
    {
        $logName = isset($config['name']) ? $config['name'] : "Ban ID {$config['id']}";
        Log::info("xoaDanhGia {$logName}: Nhận yêu cầu", ['id' => $id]);

        try {
            $danhGia = DanhGia::where('id', $id)
                ->where('ban_nganh_id', $config['id'])
                ->firstOrFail();
            $month = $danhGia->thang;
            $year = $danhGia->nam;
            $danhGia->delete();

            // Xóa cache liên quan
            Cache::forget("ban_{$config['view_prefix']}_danh_gia_{$month}_{$year}");

            Log::info("xoaDanhGia {$logName}: Xóa thành công", ['id' => $id]);
            return response()->json([
                'success' => true,
                'message' => 'Xóa đánh giá thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error("xoaDanhGia {$logName}: Lỗi xóa đánh giá", [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => "Lỗi: {$e->getMessage()}"
            ], 500);
        }
    }

    /**
     * Lấy danh sách đánh giá (điểm mạnh/yếu) cho DataTable
     */
    public function danhGiaList(Request $request, array $config): JsonResponse
    {
        $logName = isset($config['name']) ? $config['name'] : "Ban ID {$config['id']}";
        Log::info("danhGiaList {$logName}: Nhận yêu cầu", $request->all());

        $validator = Validator::make($request->all(), [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2021|max:2030',
            'ban_nganh_id' => 'required|exists:ban_nganh,id',
            'loai' => 'required|in:diem_manh,diem_yeu',
        ]);

        if ($validator->fails()) {
            Log::error("danhGiaList {$logName}: Validation thất bại", ['errors' => $validator->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu đầu vào không hợp lệ: ' . $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->ban_nganh_id != $config['id']) {
            return response()->json([
                'success' => false,
                'message' => 'Ban ngành không hợp lệ!'
            ], 422);
        }

        try {
            $danhGia = DanhGia::with([
                'nguoiDanhGia' => function ($query) {
                    $query->select('id', 'ho_ten');
                }
            ])
                ->select('id', 'noi_dung', 'nguoi_danh_gia_id')
                ->where('ban_nganh_id', $config['id'])
                ->where('loai', $request->loai)
                ->where('thang', $request->month)
                ->where('nam', $request->year)
                ->get();

            $data = $danhGia->map(function ($item, $index) {
                return [
                    'id' => $item->id,
                    'noi_dung' => e($item->noi_dung ?? 'N/A'),
                    'nguoi_danh_gia' => e($item->nguoiDanhGia ? $item->nguoiDanhGia->ho_ten : 'N/A'),
                ];
            })->toArray();

            Log::info("danhGiaList {$logName}: Trả về dữ liệu", ['count' => count($data)]);

            return response()->json([
                'success' => true,
                'data' => $data,
                'draw' => $request->input('draw'),
                'recordsTotal' => count($data),
                'recordsFiltered' => count($data),
            ]);
        } catch (\Exception $e) {
            Log::error("danhGiaList {$logName}: Lỗi lấy danh sách đánh giá", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => "Lỗi: {$e->getMessage()}"
            ], 500);
        }
    }

    /**
     * Xóa kiến nghị
     */
    public function xoaKienNghi($id, array $config): JsonResponse
    {
        $logName = isset($config['name']) ? $config['name'] : "Ban ID {$config['id']}";
        Log::info("xoaKienNghi {$logName}: Nhận yêu cầu", ['id' => $id]);

        try {
            $kienNghi = KienNghi::where('id', $id)
                ->where('ban_nganh_id', $config['id'])
                ->firstOrFail();

            $user = Auth::user();
            if (!$user || !$user->tin_huu_id) {
                Log::error("xoaKienNghi {$logName}: Người dùng không có tin_huu_id", ['user_id' => $user ? $user->id : null]);
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xác định người dùng. Vui lòng kiểm tra thông tin (tin_huu_id không tồn tại).'
                ], 422);
            }

            if ($kienNghi->nguoi_de_xuat_id !== $user->tin_huu_id) {
                Log::warning("xoaKienNghi {$logName}: Người dùng không có quyền xóa", [
                    'user_tin_huu_id' => $user->tin_huu_id,
                    'nguoi_de_xuat_id' => $kienNghi->nguoi_de_xuat_id
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền xóa kiến nghị này!'
                ], 403);
            }

            $month = $kienNghi->thang;
            $year = $kienNghi->nam;
            $kienNghi->delete();

            // Xóa cache liên quan
            Cache::forget("ban_{$config['view_prefix']}_kien_nghi_{$month}_{$year}");

            Log::info("xoaKienNghi {$logName}: Xóa thành công", ['id' => $id, 'nguoi_de_xuat_id' => $user->tin_huu_id]);
            return response()->json([
                'success' => true,
                'message' => 'Xóa kiến nghị thành công!'
            ]);
        } catch (\Exception $e) {
            Log::error("xoaKienNghi {$logName}: Lỗi xóa kiến nghị", [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => "Lỗi: {$e->getMessage()}"
            ], 500);
        }
    }
}
