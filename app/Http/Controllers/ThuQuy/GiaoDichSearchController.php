<?php

namespace App\Http\Controllers\ThuQuy;

use App\Models\BanNganh;
use App\Models\GiaoDichTaiChinh;
use App\Models\QuyTaiChinh;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GiaoDichExport;

class GiaoDichSearchController extends ThuQuyController
{
    /**
     * Hiển thị trang tìm kiếm giao dịch nâng cao
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $dsQuy = QuyTaiChinh::where('trang_thai', 'hoat_dong')->get();
        $dsBanNganh = BanNganh::orderBy('ten')->get();

        return view('_thu_quy.giao_dich.search', compact('dsQuy', 'dsBanNganh'));
    }

    /**
     * Xử lý tìm kiếm giao dịch nâng cao
     * Hỗ trợ cả hiển thị kết quả trên giao diện và trả về dữ liệu cho DataTables qua AJAX
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Yajra\DataTables\DataTableAbstract
     */
    public function search(Request $request)
    {
        $query = GiaoDichTaiChinh::with(['quyTaiChinh', 'buoiNhom', 'banNganh']);

        // Áp dụng các bộ lọc tìm kiếm
        if ($request->filled('quy_tai_chinh_id')) {
            $query->where('quy_tai_chinh_id', $request->quy_tai_chinh_id);
        }

        if ($request->filled('loai')) {
            $query->where('loai', $request->loai);
        }

        if ($request->filled('hinh_thuc')) {
            $query->where('hinh_thuc', $request->hinh_thuc);
        }

        if ($request->filled('tu_ngay')) {
            $query->whereDate('ngay_giao_dich', '>=', $request->tu_ngay);
        }

        if ($request->filled('den_ngay')) {
            $query->whereDate('ngay_giao_dich', '<=', $request->den_ngay);
        }

        if ($request->filled('ban_nganh_id')) {
            $query->where('ban_nganh_id', $request->ban_nganh_id);
        }

        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        if ($request->filled('so_tien_min')) {
            $query->where('so_tien', '>=', $request->so_tien_min);
        }

        if ($request->filled('so_tien_max')) {
            $query->where('so_tien', '<=', $request->so_tien_max);
        }

        if ($request->filled('mo_ta')) {
            $query->where('mo_ta', 'like', '%' . $request->mo_ta . '%');
        }

        // Lưu tham số tìm kiếm vào session để sử dụng cho xuất PDF/Excel
        $request->session()->put('_thu_quy.tim_kiem_giao_dich', $request->all());

        // Xử lý yêu cầu AJAX cho DataTables
        if ($request->ajax()) {
            return DataTables::of($query)
                ->editColumn('so_tien', fn($gd) => '<span class="' . ($gd->loai == 'thu' ? 'text-success' : 'text-danger') . '">' . ($gd->loai == 'thu' ? '+' : '-') . ' ' . $this->formatTien($gd->so_tien) . '</span>')
                ->editColumn('ngay_giao_dich', fn($gd) => $gd->ngay_giao_dich->format('d/m/Y'))
                ->editColumn('loai', fn($gd) => '<span class="badge ' . ($gd->loai == 'thu' ? 'bg-success' : 'bg-danger') . '">' . ($gd->loai == 'thu' ? 'Thu' : 'Chi') . '</span>')
                ->editColumn('trang_thai', function ($gd) {
                    $statusClasses = [
                        'cho_duyet' => 'bg-warning',
                        'da_duyet' => 'bg-success',
                        'tu_choi' => 'bg-danger',
                        'hoan_thanh' => 'bg-info'
                    ];
                    $statusTexts = [
                        'cho_duyet' => 'Chờ duyệt',
                        'da_duyet' => 'Đã duyệt',
                        'tu_choi' => 'Từ chối',
                        'hoan_thanh' => 'Hoàn thành'
                    ];
                    $class = $statusClasses[$gd->trang_thai] ?? 'bg-secondary';
                    $text = $statusTexts[$gd->trang_thai] ?? 'Không xác định';
                    return '<span class="badge ' . $class . '">' . $text . '</span>';
                })
                ->addColumn('quy_tai_chinh', fn($gd) => $gd->quyTaiChinh ? $gd->quyTaiChinh->ten_quy : '')
                ->addColumn('action', fn($gd) => '<a href="' . route('_thu_quy.giao_dich.show', $gd->id) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>')
                ->rawColumns(['so_tien', 'loai', 'trang_thai', 'action'])
                ->make(true);
        }

        // Hiển thị trang kết quả tìm kiếm
        return view('_thu_quy.giao_dich.search_results');
    }

    /**
     * Xuất kết quả tìm kiếm sang PDF
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function xuatPDF(Request $request)
    {
        // Lấy tham số tìm kiếm từ session
        $params = $request->session()->get('_thu_quy.tim_kiem_giao_dich', []);

        // Xây dựng query từ tham số
        $query = GiaoDichTaiChinh::with(['quyTaiChinh', 'buoiNhom', 'banNganh']);

        if (isset($params['quy_tai_chinh_id'])) {
            $query->where('quy_tai_chinh_id', $params['quy_tai_chinh_id']);
        }

        if (isset($params['loai'])) {
            $query->where('loai', $params['loai']);
        }

        if (isset($params['hinh_thuc'])) {
            $query->where('hinh_thuc', $params['hinh_thuc']);
        }

        if (isset($params['tu_ngay'])) {
            $query->whereDate('ngay_giao_dich', '>=', $params['tu_ngay']);
        }

        if (isset($params['den_ngay'])) {
            $query->whereDate('ngay_giao_dich', '<=', $params['den_ngay']);
        }

        if (isset($params['ban_nganh_id'])) {
            $query->where('ban_nganh_id', $params['ban_nganh_id']);
        }

        if (isset($params['trang_thai'])) {
            $query->where('trang_thai', $params['trang_thai']);
        }

        if (isset($params['so_tien_min'])) {
            $query->where('so_tien', '>=', $params['so_tien_min']);
        }

        if (isset($params['so_tien_max'])) {
            $query->where('so_tien', '<=', $params['so_tien_max']);
        }

        if (isset($params['mo_ta'])) {
            $query->where('mo_ta', 'like', '%' . $params['mo_ta'] . '%');
        }

        // Lấy dữ liệu giao dịch
        $giaoDich = $query->orderBy('ngay_giao_dich', 'desc')->get();

        // Tính tổng thu, chi và số dư
        $tongThu = $giaoDich->where('loai', 'thu')->sum('so_tien');
        $tongChi = $giaoDich->where('loai', 'chi')->sum('so_tien');
        $soDu = $tongThu - $tongChi;

        // Tạo tiêu đề báo cáo
        $tieuDeBaoCao = 'Báo cáo giao dịch tài chính';
        if (isset($params['tu_ngay']) && isset($params['den_ngay'])) {
            $tieuDeBaoCao .= ' từ ' . date('d/m/Y', strtotime($params['tu_ngay'])) .
                ' đến ' . date('d/m/Y', strtotime($params['den_ngay']));
        }

        // Tạo PDF
        $pdf = PDF::loadView('_thu_quy.giao_dich.pdf_export', [
            'giaoDich' => $giaoDich,
            'tieuDe' => $tieuDeBaoCao,
            'tongThu' => $tongThu,
            'tongChi' => $tongChi,
            'soDu' => $soDu,
            'params' => $params
        ]);

        return $pdf->download('bao-cao-giao-dich-' . date('dmY') . '.pdf');
    }

    /**
     * Xuất kết quả tìm kiếm sang Excel
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function xuatExcel(Request $request)
    {
        // Lấy tham số tìm kiếm từ session
        $params = $request->session()->get('_thu_quy.tim_kiem_giao_dich', []);

        // Xây dựng query từ tham số
        $query = GiaoDichTaiChinh::with(['quyTaiChinh', 'buoiNhom', 'banNganh']);

        if (isset($params['quy_tai_chinh_id'])) {
            $query->where('quy_tai_chinh_id', $params['quy_tai_chinh_id']);
        }

        if (isset($params['loai'])) {
            $query->where('loai', $params['loai']);
        }

        if (isset($params['hinh_thuc'])) {
            $query->where('hinh_thuc', $params['hinh_thuc']);
        }

        if (isset($params['tu_ngay'])) {
            $query->whereDate('ngay_giao_dich', '>=', $params['tu_ngay']);
        }

        if (isset($params['den_ngay'])) {
            $query->whereDate('ngay_giao_dich', '<=', $params['den_ngay']);
        }

        if (isset($params['ban_nganh_id'])) {
            $query->where('ban_nganh_id', $params['ban_nganh_id']);
        }

        if (isset($params['trang_thai'])) {
            $query->where('trang_thai', $params['trang_thai']);
        }

        if (isset($params['so_tien_min'])) {
            $query->where('so_tien', '>=', $params['so_tien_min']);
        }

        if (isset($params['so_tien_max'])) {
            $query->where('so_tien', '<=', $params['so_tien_max']);
        }

        if (isset($params['mo_ta'])) {
            $query->where('mo_ta', 'like', '%' . $params['mo_ta'] . '%');
        }

        // Lấy dữ liệu giao dịch
        $giaoDich = $query->orderBy('ngay_giao_dich', 'desc')->get();

        // Xuất Excel sử dụng GiaoDichExport
        return Excel::download(
            new GiaoDichExport($giaoDich, $params),
            'bao-cao-giao-dich-' . date('dmY') . '.xlsx'
        );
    }
}