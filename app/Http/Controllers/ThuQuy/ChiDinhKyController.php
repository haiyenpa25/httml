<?php

namespace App\Http\Controllers\ThuQuy;

use App\Models\ChiDinhKy;
use App\Models\GiaoDichTaiChinh;
use App\Models\QuyTaiChinh;
use App\Models\BanNganh;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ChiDinhKyController extends ThuQuyController
{
    /**
     * Hiển thị danh sách chi định kỳ
     */
    public function index()
    {
        return view('_thu_quy.chi_dinh_ky.index');
    }

    /**
     * Lấy dữ liệu chi định kỳ cho DataTables
     */
    public function getDanhSachChiDinhKy()
    {
        $chiDinhKy = ChiDinhKy::with(['quyTaiChinh', 'banNganh']);

        return DataTables::of($chiDinhKy)
            ->editColumn('so_tien', fn($chi) => $this->formatTien($chi->so_tien))
            ->editColumn('trang_thai', fn($chi) => '<span class="badge ' . ($chi->trang_thai == 'hoat_dong' ? 'bg-success' : 'bg-warning') . '">' . ($chi->trang_thai == 'hoat_dong' ? 'Hoạt động' : 'Tạm dừng') . '</span>')
            ->addColumn('quy_tai_chinh', fn($chi) => $chi->quyTaiChinh ? $chi->quyTaiChinh->ten_quy : '')
            ->addColumn('ban_nganh', fn($chi) => $chi->banNganh ? $chi->banNganh->ten : '')
            ->addColumn('action', function ($chi) {
                $actions = '<a href="' . route('_thu_quy.chi_dinh_ky.show', $chi->id) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>';
                $actions .= ' <a href="' . route('_thu_quy.chi_dinh_ky.edit', $chi->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>';
                $actions .= ' <a href="' . route('_thu_quy.chi_dinh_ky.tao_giao_dich', $chi->id) . '" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Tạo Giao Dịch</a>';
                $actions .= ' <button type="button" data-id="' . $chi->id . '" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>';
                return '<div class="btn-group">' . $actions . '</div>';
            })
            ->rawColumns(['trang_thai', 'action'])
            ->make(true);
    }

    /**
     * Hiển thị form tạo chi định kỳ mới
     */
    public function create()
    {
        $dsQuy = QuyTaiChinh::where('trang_thai', 'hoat_dong')->get();
        $dsBanNganh = BanNganh::orderBy('ten')->get();

        return view('_thu_quy.chi_dinh_ky.create', compact('dsQuy', 'dsBanNganh'));
    }

    /**
     * Lưu chi định kỳ mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_chi' => 'required|string|max:255',
            'quy_tai_chinh_id' => 'required|exists:quy_tai_chinh,id',
            'so_tien' => 'required|numeric|min:1000',
            'mo_ta' => 'required|string',
            'tan_suat' => 'required|in:hang_thang,hang_quy,nua_nam,hang_nam',
            'ngay_thanh_toan' => 'required|numeric|between:1,31',
            'thang_thanh_toan' => 'required_if:tan_suat,hang_nam|nullable|numeric|between:1,12',
            'ban_nganh_id' => 'nullable|exists:ban_nganh,id',
            'nguoi_nhan' => 'required|string',
            'trang_thai' => 'required|in:hoat_dong,tam_dung',
        ]);

        $chiDinhKy = ChiDinhKy::create($validated);

        $this->ghiLogThaoTac('Tạo chi định kỳ mới', 'chi_dinh_ky', $chiDinhKy->id, null, $chiDinhKy->toArray());

        return redirect()->route('_thu_quy.chi_dinh_ky.index')->with('success', 'Tạo chi định kỳ thành công');
    }

    /**
     * Hiển thị chi tiết chi định kỳ
     */
    public function show($id)
    {
        $chiDinhKy = ChiDinhKy::with(['quyTaiChinh', 'banNganh'])->findOrFail($id);
        $giaoDich = GiaoDichTaiChinh::where('chi_dinh_ky_id', $id)
            ->orderBy('ngay_giao_dich', 'desc')
            ->take(10)
            ->get();

        return view('_thu_quy.chi_dinh_ky.show', compact('chiDinhKy', 'giaoDich'));
    }

    /**
     * Hiển thị form chỉnh sửa chi định kỳ
     */
    public function edit($id)
    {
        $chiDinhKy = ChiDinhKy::findOrFail($id);
        $dsQuy = QuyTaiChinh::where('trang_thai', 'hoat_dong')->get();
        $dsBanNganh = BanNganh::orderBy('ten')->get();

        return view('_thu_quy.chi_dinh_ky.edit', compact('chiDinhKy', 'dsQuy', 'dsBanNganh'));
    }

    /**
     * Cập nhật chi định kỳ
     */
    public function update(Request $request, $id)
    {
        $chiDinhKy = ChiDinhKy::findOrFail($id);

        $validated = $request->validate([
            'ten_chi' => 'required|string|max:255',
            'quy_tai_chinh_id' => 'required|exists:quy_tai_chinh,id',
            'so_tien' => 'required|numeric|min:1000',
            'mo_ta' => 'required|string',
            'tan_suat' => 'required|in:hang_thang,hang_quy,nua_nam,hang_nam',
            'ngay_thanh_toan' => 'required|numeric|between:1,31',
            'thang_thanh_toan' => 'required_if:tan_suat,hang_nam|nullable|numeric|between:1,12',
            'ban_nganh_id' => 'nullable|exists:ban_nganh,id',
            'nguoi_nhan' => 'required|string',
            'trang_thai' => 'required|in:hoat_dong,tam_dung',
        ]);

        $duLieuCu = $chiDinhKy->toArray();
        $chiDinhKy->update($validated);

        $this->ghiLogThaoTac('Cập nhật chi định kỳ', 'chi_dinh_ky', $chiDinhKy->id, $duLieuCu, $chiDinhKy->toArray());

        return redirect()->route('_thu_quy.chi_dinh_ky.index')->with('success', 'Cập nhật chi định kỳ thành công');
    }

    /**
     * Xóa chi định kỳ
     */
    public function destroy($id)
    {
        $chiDinhKy = ChiDinhKy::findOrFail($id);
        $duLieuCu = $chiDinhKy->toArray();

        $giaoDichCount = GiaoDichTaiChinh::where('chi_dinh_ky_id', $id)->count();
        if ($giaoDichCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Không thể xóa chi định kỳ này vì đã có {$giaoDichCount} giao dịch liên quan"
            ]);
        }

        $chiDinhKy->delete();
        $this->ghiLogThaoTac('Xóa chi định kỳ', 'chi_dinh_ky', $id, $duLieuCu, null);

        return response()->json(['success' => true]);
    }

    /**
     * Tạo giao dịch từ chi định kỳ
     */
    public function taoGiaoDich($id)
    {
        $chiDinhKy = ChiDinhKy::findOrFail($id);

        $giaoDich = new GiaoDichTaiChinh();
        $giaoDich->quy_tai_chinh_id = $chiDinhKy->quy_tai_chinh_id;
        $giaoDich->loai = 'chi';
        $giaoDich->hinh_thuc = 'khac';
        $giaoDich->so_tien = $chiDinhKy->so_tien;
        $giaoDich->mo_ta = $chiDinhKy->mo_ta;
        $giaoDich->ngay_giao_dich = Carbon::now();
        $giaoDich->phuong_thuc = 'chuyen_khoan';
        $giaoDich->nguoi_nhan = $chiDinhKy->nguoi_nhan;
        $giaoDich->ban_nganh_id = $chiDinhKy->ban_nganh_id;
        $giaoDich->chi_dinh_ky_id = $chiDinhKy->id;
        $giaoDich->trang_thai = $chiDinhKy->so_tien > 1000000 ? 'cho_duyet' : 'hoan_thanh';

        if ($giaoDich->trang_thai === 'hoan_thanh') {
            $this->capNhatSoDuQuy($giaoDich->quy_tai_chinh_id, $giaoDich->so_tien, $giaoDich->loai);
        }

        $giaoDich->save();
        $giaoDich->ma_giao_dich = $this->taoMaGiaoDich($giaoDich->loai, $giaoDich->id);
        $giaoDich->save();

        $this->ghiLogThaoTac('Tạo giao dịch từ chi định kỳ', 'giao_dich_tai_chinh', $giaoDich->id, null, $giaoDich->toArray());

        if ($giaoDich->trang_thai === 'cho_duyet') {
            $dsDuyet = $this->layDanhSachNguoiDuyet();
            foreach ($dsDuyet as $nguoiDuyet) {
                $this->guiThongBao(
                    'Yêu cầu duyệt giao dịch mới từ chi định kỳ',
                    "Có giao dịch chi {$this->formatTien($giaoDich->so_tien)} từ chi định kỳ {$chiDinhKy->ten_chi} cần được duyệt",
                    'yeu_cau_duyet',
                    $nguoiDuyet->id,
                    GiaoDichTaiChinh::class,
                    $giaoDich->id
                );
            }
        }

        return redirect()->route('_thu_quy.chi_dinh_ky.show', $chiDinhKy->id)
            ->with('success', $giaoDich->trang_thai === 'cho_duyet' ? 'Tạo giao dịch thành công và đang chờ duyệt' : 'Tạo giao dịch thành công');
    }

    /**
     * Kiểm tra và tạo giao dịch tự động từ chi định kỳ
     */
    public function kiemTraVaTaoGiaoDichTuDong()
    {
        $today = Carbon::now();
        $chiDinhKy = ChiDinhKy::where('trang_thai', 'hoat_dong')
            ->where(function ($query) use ($today) {
                $query->orWhere(function ($q) use ($today) {
                    $q->where('tan_suat', 'hang_thang')
                        ->where('ngay_thanh_toan', $today->day);
                })->orWhere(function ($q) use ($today) {
                    $q->where('tan_suat', 'hang_quy')
                        ->where('ngay_thanh_toan', $today->day)
                        ->whereRaw('MOD(?, 3) = 0', [$today->month]);
                })->orWhere(function ($q) use ($today) {
                    $q->where('tan_suat', 'nua_nam')
                        ->where('ngay_thanh_toan', $today->day)
                        ->whereIn('thang_thanh_toan', [6, 12]);
                })->orWhere(function ($q) use ($today) {
                    $q->where('tan_suat', 'hang_nam')
                        ->where('ngay_thanh_toan', $today->day)
                        ->where('thang_thanh_toan', $today->month);
                });
            })->get();

        $soLuongGiaoDich = 0;
        foreach ($chiDinhKy as $chi) {
            $giaoDich = new GiaoDichTaiChinh();
            $giaoDich->quy_tai_chinh_id = $chi->quy_tai_chinh_id;
            $giaoDich->loai = 'chi';
            $giaoDich->hinh_thuc = 'khac';
            $giaoDich->so_tien = $chi->so_tien;
            $giaoDich->mo_ta = $chi->mo_ta;
            $giaoDich->ngay_giao_dich = Carbon::now();
            $giaoDich->phuong_thuc = 'chuyen_khoan';
            $giaoDich->nguoi_nhan = $chi->nguoi_nhan;
            $giaoDich->ban_nganh_id = $chi->ban_nganh_id;
            $giaoDich->chi_dinh_ky_id = $chi->id;
            $giaoDich->trang_thai = $chi->so_tien > 1000000 ? 'cho_duyet' : 'hoan_thanh';

            if ($giaoDich->trang_thai === 'hoan_thanh') {
                $this->capNhatSoDuQuy($giaoDich->quy_tai_chinh_id, $giaoDich->so_tien, $giaoDich->loai);
            }

            $giaoDich->save();
            $giaoDich->ma_giao_dich = $this->taoMaGiaoDich($giaoDich->loai, $giaoDich->id);
            $giaoDich->save();

            $this->ghiLogThaoTac('Tạo giao dịch tự động từ chi định kỳ', 'giao_dich_tai_chinh', $giaoDich->id, null, $giaoDich->toArray());

            if ($giaoDich->trang_thai === 'cho_duyet') {
                $dsDuyet = $this->layDanhSachNguoiDuyet();
                foreach ($dsDuyet as $nguoiDuyet) {
                    $this->guiThongBao(
                        'Yêu cầu duyệt giao dịch tự động từ chi định kỳ',
                        "Có giao dịch chi {$this->formatTien($giaoDich->so_tien)} từ chi định kỳ {$chi->ten_chi} cần được duyệt",
                        'yeu_cau_duyet',
                        $nguoiDuyet->id,
                        GiaoDichTaiChinh::class,
                        $giaoDich->id
                    );
                }
            }

            $soLuongGiaoDich++;
        }

        return response()->json([
            'success' => true,
            'message' => "Đã tạo {$soLuongGiaoDich} giao dịch tự động từ chi định kỳ"
        ]);
    }
}