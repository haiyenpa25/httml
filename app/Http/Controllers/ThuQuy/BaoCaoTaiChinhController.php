<?php

namespace App\Http\Controllers\ThuQuy;

use App\Models\BaoCaoTaiChinh;
use App\Models\GiaoDichTaiChinh;
use App\Models\QuyTaiChinh;
use App\Models\BanNganh;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\PDF;
use Yajra\DataTables\Facades\DataTables;


class BaoCaoTaiChinhController extends ThuQuyController
{
    /**
     * Hiển thị danh sách báo cáo tài chính
     */
    public function index()
    {
        return view('_thu_quy.bao_cao.index');
    }

    /**
     * Lấy dữ liệu cho DataTables
     */
    public function getDanhSachBaoCao(Request $request)
    {
        $baoCao = BaoCaoTaiChinh::with(['quyTaiChinh', 'nguoiTao']);

        return DataTables::of($baoCao)
            ->editColumn('tu_ngay', function ($bc) {
                return $bc->tu_ngay->format('d/m/Y');
            })
            ->editColumn('den_ngay', function ($bc) {
                return $bc->den_ngay->format('d/m/Y');
            })
            ->editColumn('loai_bao_cao', function ($bc) {
                $loaiBaoCaoText = [
                    'thang' => 'Tháng',
                    'quy' => 'Quý',
                    'sau_thang' => 'Sáu tháng',
                    'nam' => 'Năm',
                    'tuy_chinh' => 'Tùy chỉnh'
                ];

                return $loaiBaoCaoText[$bc->loai_bao_cao] ?? '';
            })
            ->addColumn('quy_tai_chinh', function ($bc) {
                return $bc->quyTaiChinh ? $bc->quyTaiChinh->ten_quy : 'Tổng hợp';
            })
            ->addColumn('nguoi_tao', function ($bc) {
                return $bc->nguoiTao->tin_huu->ho_ten ?? '';
            })
            ->editColumn('tong_thu', function ($bc) {
                return $this->formatTien($bc->tong_thu);
            })
            ->editColumn('tong_chi', function ($bc) {
                return $this->formatTien($bc->tong_chi);
            })
            ->editColumn('cong_khai', function ($bc) {
                return $bc->cong_khai ? '<span class="badge bg-success">Có</span>' : '<span class="badge bg-secondary">Không</span>';
            })
            ->addColumn('action', function ($bc) {
                $btnXem = '<a href="' . route('_thu_quy.bao_cao.show', $bc->id) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>';
                $btnTaiXuong = '';

                if ($bc->duong_dan_file) {
                    $btnTaiXuong = '<a href="' . route('_thu_quy.bao_cao.download', $bc->id) . '" class="btn btn-sm btn-secondary"><i class="fas fa-download"></i></a>';
                }

                $btnXoa = '';
                if ($this->user->vai_tro == 'quan_tri') {
                    $btnXoa = '<button type="button" data-id="' . $bc->id . '" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>';
                }

                return '<div class="btn-group">' . $btnXem . ' ' . $btnTaiXuong . ' ' . $btnXoa . '</div>';
            })
            ->rawColumns(['cong_khai', 'action'])
            ->make(true);
    }

    /**
     * Trang tạo báo cáo mới
     */
    public function create()
    {
        // Kiểm tra quyền tạo báo cáo
        if (!$this->kiemTraQuyenTaoBaoCao()) {
            return redirect()->route('_thu_quy.bao_cao.index')
                ->with('error', 'Bạn không có quyền tạo báo cáo');
        }

        $dsQuy = QuyTaiChinh::where('trang_thai', 'hoat_dong')->get();
        $dsBanNganh = BanNganh::orderBy('ten')->get();

        return view('_thu_quy.bao_cao.create', compact('dsQuy', 'dsBanNganh'));
    }

    /**
     * Lưu báo cáo mới
     */
    public function store(Request $request)
    {
        // Kiểm tra quyền tạo báo cáo
        if (!$this->kiemTraQuyenTaoBaoCao()) {
            return redirect()->route('_thu_quy.bao_cao.index')
                ->with('error', 'Bạn không có quyền tạo báo cáo');
        }

        $validated = $request->validate([
            'tieu_de' => 'required|string|max:255',
            'loai_bao_cao' => 'required|in:thang,quy,sau_thang,nam,tuy_chinh',
            'quy_tai_chinh_id' => 'nullable|exists:quy_tai_chinh,id',
            'ky_bao_cao' => 'required_unless:loai_bao_cao,tuy_chinh',
            'nam_bao_cao' => 'required|numeric|min:2020|max:2030',
            'tu_ngay' => 'required_if:loai_bao_cao,tuy_chinh|nullable|date',
            'den_ngay' => 'required_if:loai_bao_cao,tuy_chinh|nullable|date|after_or_equal:tu_ngay',
            'cong_khai' => 'boolean',
            'ban_nganh_id' => 'nullable|exists:ban_nganh,id',
        ]);

        // Xác định khoảng thời gian báo cáo
        $tuNgay = null;
        $denNgay = null;

        if ($validated['loai_bao_cao'] == 'tuy_chinh') {
            $tuNgay = Carbon::parse($validated['tu_ngay']);
            $denNgay = Carbon::parse($validated['den_ngay']);
        } else {
            list($tuNgay, $denNgay) = $this->xacDinhKhoangThoiGian(
                $validated['loai_bao_cao'],
                $validated['ky_bao_cao'],
                $validated['nam_bao_cao']
            );
        }

        // Tạo báo cáo
        $baoCao = new BaoCaoTaiChinh();
        $baoCao->tieu_de = $validated['tieu_de'];
        $baoCao->loai_bao_cao = $validated['loai_bao_cao'];
        $baoCao->quy_tai_chinh_id = $validated['quy_tai_chinh_id'];
        $baoCao->tu_ngay = $tuNgay;
        $baoCao->den_ngay = $denNgay;
        $baoCao->cong_khai = $validated['cong_khai'] ?? false;
        $baoCao->nguoi_tao_id = $this->user->id;

        // Tính toán dữ liệu báo cáo
        $query = GiaoDichTaiChinh::where('trang_thai', 'hoan_thanh')
            ->whereBetween('ngay_giao_dich', [$tuNgay, $denNgay]);

        // Lọc theo quỹ nếu có
        if ($validated['quy_tai_chinh_id']) {
            $query->where('quy_tai_chinh_id', $validated['quy_tai_chinh_id']);
        }

        // Lọc theo ban ngành nếu có
        if (isset($validated['ban_nganh_id'])) {
            $query->where('ban_nganh_id', $validated['ban_nganh_id']);
        }

        // Tính tổng thu chi
        $tongThu = $query->where('loai', 'thu')->sum('so_tien');
        $tongChi = $query->where('loai', 'chi')->sum('so_tien');

        // Tính số dư đầu kỳ
        $soDuDauKy = 0;
        if ($validated['quy_tai_chinh_id']) {
            // Tính số dư đầu kỳ cho một quỹ cụ thể
            $thuTruocKy = GiaoDichTaiChinh::where('quy_tai_chinh_id', $validated['quy_tai_chinh_id'])
                ->where('trang_thai', 'hoan_thanh')
                ->where('loai', 'thu')
                ->where('ngay_giao_dich', '<', $tuNgay)
                ->sum('so_tien');

            $chiTruocKy = GiaoDichTaiChinh::where('quy_tai_chinh_id', $validated['quy_tai_chinh_id'])
                ->where('trang_thai', 'hoan_thanh')
                ->where('loai', 'chi')
                ->where('ngay_giao_dich', '<', $tuNgay)
                ->sum('so_tien');

            $soDuDauKy = $thuTruocKy - $chiTruocKy;
        } else {
            // Tính số dư đầu kỳ tổng hợp
            $thuTruocKy = GiaoDichTaiChinh::where('trang_thai', 'hoan_thanh')
                ->where('loai', 'thu')
                ->where('ngay_giao_dich', '<', $tuNgay);

            $chiTruocKy = GiaoDichTaiChinh::where('trang_thai', 'hoan_thanh')
                ->where('loai', 'chi')
                ->where('ngay_giao_dich', '<', $tuNgay);

            // Lọc theo ban ngành nếu có
            if (isset($validated['ban_nganh_id'])) {
                $thuTruocKy->where('ban_nganh_id', $validated['ban_nganh_id']);
                $chiTruocKy->where('ban_nganh_id', $validated['ban_nganh_id']);
            }

            $soDuDauKy = $thuTruocKy->sum('so_tien') - $chiTruocKy->sum('so_tien');
        }

        $baoCao->tong_thu = $tongThu;
        $baoCao->tong_chi = $tongChi;
        $baoCao->so_du_dau_ky = $soDuDauKy;
        $baoCao->so_du_cuoi_ky = $soDuDauKy + $tongThu - $tongChi;

        // Lấy dữ liệu chi tiết cho báo cáo
        $noiDungBaoCao = $this->layDuLieuChiTiet($tuNgay, $denNgay, $validated);
        $baoCao->noi_dung_bao_cao = $noiDungBaoCao;

        $baoCao->save();

        // Tạo file PDF
        $filePath = $this->taoPdfBaoCao($baoCao);
        $baoCao->duong_dan_file = $filePath;
        $baoCao->save();

        // Ghi log thao tác
        $this->ghiLogThaoTac('Tạo báo cáo tài chính', 'bao_cao_tai_chinh', $baoCao->id, null, $baoCao->toArray());

        return redirect()->route('_thu_quy.bao_cao.show', $baoCao->id)
            ->with('success', 'Tạo báo cáo tài chính thành công');
    }

    /**
     * Xác định khoảng thời gian báo cáo
     */
    private function xacDinhKhoangThoiGian($loaiBaoCao, $kyBaoCao, $namBaoCao)
    {
        $tuNgay = null;
        $denNgay = null;

        switch ($loaiBaoCao) {
            case 'thang':
                $tuNgay = Carbon::createFromDate($namBaoCao, $kyBaoCao, 1)->startOfDay();
                $denNgay = $tuNgay->copy()->endOfMonth()->endOfDay();
                break;

            case 'quy':
                $thangBatDau = (($kyBaoCao - 1) * 3) + 1;
                $tuNgay = Carbon::createFromDate($namBaoCao, $thangBatDau, 1)->startOfDay();
                $denNgay = $tuNgay->copy()->addMonths(2)->endOfMonth()->endOfDay();
                break;

            case 'sau_thang':
                if ($kyBaoCao == 1) {
                    $tuNgay = Carbon::createFromDate($namBaoCao, 1, 1)->startOfDay();
                    $denNgay = Carbon::createFromDate($namBaoCao, 6, 30)->endOfDay();
                } else {
                    $tuNgay = Carbon::createFromDate($namBaoCao, 7, 1)->startOfDay();
                    $denNgay = Carbon::createFromDate($namBaoCao, 12, 31)->endOfDay();
                }
                break;

            case 'nam':
                $tuNgay = Carbon::createFromDate($namBaoCao, 1, 1)->startOfDay();
                $denNgay = Carbon::createFromDate($namBaoCao, 12, 31)->endOfDay();
                break;
        }

        return [$tuNgay, $denNgay];
    }

    /**
     * Lấy dữ liệu chi tiết cho báo cáo
     */
    private function layDuLieuChiTiet($tuNgay, $denNgay, $params)
    {
        $result = [];

        // 1. Thông tin chung
        $result['thong_tin_chung'] = [
            'tu_ngay' => $tuNgay->format('d/m/Y'),
            'den_ngay' => $denNgay->format('d/m/Y'),
            'ngay_tao' => Carbon::now()->format('d/m/Y H:i:s'),
            'nguoi_tao' => $this->user->tin_huu->ho_ten ?? 'Không xác định',
        ];

        // 2. Thống kê thu chi
        $query = GiaoDichTaiChinh::where('trang_thai', 'hoan_thanh')
            ->whereBetween('ngay_giao_dich', [$tuNgay, $denNgay]);

        // Lọc theo quỹ nếu có
        if (isset($params['quy_tai_chinh_id'])) {
            $query->where('quy_tai_chinh_id', $params['quy_tai_chinh_id']);
        }

        // Lọc theo ban ngành nếu có
        if (isset($params['ban_nganh_id'])) {
            $query->where('ban_nganh_id', $params['ban_nganh_id']);
        }

        // Thống kê theo hình thức
        $thongKeTheoHinhThuc = $query->select('loai', 'hinh_thuc', DB::raw('SUM(so_tien) as tong_tien'))
            ->groupBy('loai', 'hinh_thuc')
            ->get()
            ->groupBy('loai');

        $result['thong_ke_hinh_thuc'] = [
            'thu' => $thongKeTheoHinhThuc->get('thu') ?? [],
            'chi' => $thongKeTheoHinhThuc->get('chi') ?? []
        ];

        // Thống kê theo ngày
        $thongKeTheoNgay = $query->select(
            DB::raw('DATE(ngay_giao_dich) as ngay'),
            'loai',
            DB::raw('SUM(so_tien) as tong_tien')
        )
            ->groupBy('ngay', 'loai')
            ->orderBy('ngay')
            ->get()
            ->groupBy('ngay');

        $result['thong_ke_ngay'] = $thongKeTheoNgay->toArray();

        // Thống kê theo tháng (cho báo cáo dài hạn)
        if ($tuNgay->diffInMonths($denNgay) > 0) {
            $thongKeTheoThang = $query->select(
                DB::raw('YEAR(ngay_giao_dich) as nam'),
                DB::raw('MONTH(ngay_giao_dich) as thang'),
                'loai',
                DB::raw('SUM(so_tien) as tong_tien')
            )
                ->groupBy('nam', 'thang', 'loai')
                ->orderBy('nam')
                ->orderBy('thang')
                ->get();

            $result['thong_ke_thang'] = $thongKeTheoThang->toArray();
        }

        // Thống kê theo ban ngành
        $thongKeTheoBanNganh = $query->select(
            'ban_nganh_id',
            'loai',
            DB::raw('SUM(so_tien) as tong_tien')
        )
            ->groupBy('ban_nganh_id', 'loai')
            ->with('banNganh')
            ->get()
            ->groupBy('ban_nganh_id');

        $result['thong_ke_ban_nganh'] = $thongKeTheoBanNganh->toArray();

        // Danh sách giao dịch
        $giaoDich = $query->with(['quyTaiChinh', 'banNganh', 'buoiNhom', 'chiDinhKy'])
            ->orderBy('ngay_giao_dich', 'desc')
            ->get();

        $result['danh_sach_giao_dich'] = $giaoDich->toArray();

        return $result;
    }

    /**
     * Tạo file PDF cho báo cáo
     */
    private function taoPdfBaoCao(BaoCaoTaiChinh $baoCao)
    {
        $pdf = PDF::loadView('_thu_quy.bao_cao.pdf_template', [
            'baoCao' => $baoCao,
            'formatTien' => function ($so) {
                return $this->formatTien($so);
            }
        ]);

        $fileName = 'bao_cao_tai_chinh_' . $baoCao->id . '_' . date('YmdHis') . '.pdf';
        $filePath = 'bao_cao/' . $fileName;

        Storage::disk('public')->put($filePath, $pdf->output());

        return $filePath;
    }

    /**
     * Hiển thị chi tiết báo cáo
     */
    public function show($id)
    {
        $baoCao = BaoCaoTaiChinh::with(['quyTaiChinh', 'nguoiTao'])
            ->findOrFail($id);

        // Kiểm tra quyền xem báo cáo không công khai
        if (!$baoCao->cong_khai && $this->user->vai_tro == 'thanh_vien') {
            return redirect()->route('_thu_quy.bao_cao.index')
                ->with('error', 'Bạn không có quyền xem báo cáo này');
        }

        // Lấy dữ liệu cho biểu đồ
        $chartData = $this->layDuLieuBieuDo($baoCao);

        return view('_thu_quy.bao_cao.show', compact('baoCao', 'chartData'));
    }

    /**
     * Lấy dữ liệu cho biểu đồ
     */
    private function layDuLieuBieuDo(BaoCaoTaiChinh $baoCao)
    {
        $result = [];
        $noiDungBaoCao = $baoCao->noi_dung_bao_cao;

        // Biểu đồ phân bổ thu chi theo hình thức
        $thuTheoHinhThuc = [];
        $chiTheoHinhThuc = [];

        if (isset($noiDungBaoCao['thong_ke_hinh_thuc']['thu'])) {
            foreach ($noiDungBaoCao['thong_ke_hinh_thuc']['thu'] as $item) {
                $hinhThuc = $this->tenHinhThuc($item['hinh_thuc']);
                $thuTheoHinhThuc[] = [
                    'name' => $hinhThuc,
                    'y' => (float) $item['tong_tien']
                ];
            }
        }

        if (isset($noiDungBaoCao['thong_ke_hinh_thuc']['chi'])) {
            foreach ($noiDungBaoCao['thong_ke_hinh_thuc']['chi'] as $item) {
                $hinhThuc = $this->tenHinhThuc($item['hinh_thuc']);
                $chiTheoHinhThuc[] = [
                    'name' => $hinhThuc,
                    'y' => (float) $item['tong_tien']
                ];
            }
        }

        $result['pie_thu'] = $thuTheoHinhThuc;
        $result['pie_chi'] = $chiTheoHinhThuc;

        // Biểu đồ thu chi theo thời gian
        $labels = [];
        $dataThu = [];
        $dataChi = [];

        if ($baoCao->tu_ngay->diffInMonths($baoCao->den_ngay) > 0 && isset($noiDungBaoCao['thong_ke_thang'])) {
            // Dữ liệu theo tháng
            $thongKeThang = collect($noiDungBaoCao['thong_ke_thang'])->groupBy(function ($item) {
                return $item['nam'] . '-' . str_pad($item['thang'], 2, '0', STR_PAD_LEFT);
            });

            foreach ($thongKeThang as $key => $group) {
                list($nam, $thang) = explode('-', $key);
                $labels[] = 'T' . (int) $thang . '/' . $nam;

                $thu = $group->firstWhere('loai', 'thu');
                $chi = $group->firstWhere('loai', 'chi');

                $dataThu[] = $thu ? (float) $thu['tong_tien'] : 0;
                $dataChi[] = $chi ? (float) $chi['tong_tien'] : 0;
            }
        } else if (isset($noiDungBaoCao['thong_ke_ngay'])) {
            // Dữ liệu theo ngày
            $thongKeNgay = $noiDungBaoCao['thong_ke_ngay'];
            ksort($thongKeNgay);

            foreach ($thongKeNgay as $ngay => $group) {
                $labels[] = Carbon::parse($ngay)->format('d/m/Y');

                $thu = collect($group)->firstWhere('loai', 'thu');
                $chi = collect($group)->firstWhere('loai', 'chi');

                $dataThu[] = $thu ? (float) $thu['tong_tien'] : 0;
                $dataChi[] = $chi ? (float) $chi['tong_tien'] : 0;
            }
        }

        $result['line_chart'] = [
            'labels' => $labels,
            'thu' => $dataThu,
            'chi' => $dataChi
        ];

        return $result;
    }

    /**
     * Trả về tên hình thức giao dịch đầy đủ
     */
    private function tenHinhThuc($key)
    {
        $hinhThucText = [
            'dang_hien' => 'Dâng hiến',
            'tai_tro' => 'Tài trợ',
            'luong' => 'Lương',
            'hoa_don' => 'Hóa đơn',
            'sua_chua' => 'Sửa chữa',
            'khac' => 'Khác'
        ];

        return $hinhThucText[$key] ?? 'Không xác định';
    }

    /**
     * Tải xuống báo cáo
     */
    public function download($id)
    {
        $baoCao = BaoCaoTaiChinh::findOrFail($id);

        // Kiểm tra quyền xem báo cáo không công khai
        if (!$baoCao->cong_khai && $this->user->vai_tro == 'thanh_vien') {
            return redirect()->route('_thu_quy.bao_cao.index')
                ->with('error', 'Bạn không có quyền tải báo cáo này');
        }

        if (!$baoCao->duong_dan_file) {
            return redirect()->route('_thu_quy.bao_cao.show', $id)
                ->with('error', 'Báo cáo chưa có file để tải xuống');
        }

        return Storage::disk('public')->download($baoCao->duong_dan_file, 'bao_cao_tai_chinh_' . $baoCao->id . '.pdf');
    }

    /**
     * Xóa báo cáo
     */
    public function destroy($id)
    {
        // Chỉ admin mới có quyền xóa báo cáo
        if ($this->user->vai_tro != 'quan_tri') {
            return response()->json(['success' => false, 'message' => 'Bạn không có quyền xóa báo cáo']);
        }

        $baoCao = BaoCaoTaiChinh::findOrFail($id);
        $duLieuCu = $baoCao->toArray();

        // Xóa file báo cáo nếu có
        if ($baoCao->duong_dan_file) {
            Storage::disk('public')->delete($baoCao->duong_dan_file);
        }

        $baoCao->delete();

        // Ghi log thao tác
        $this->ghiLogThaoTac('Xóa báo cáo tài chính', 'bao_cao_tai_chinh', $id, $duLieuCu, null);

        return response()->json(['success' => true]);
    }
}