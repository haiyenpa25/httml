<?php

namespace App\Http\Controllers\ThuQuy;

use App\Models\QuyTaiChinh;
use App\Models\TinHuu;
use App\Models\GiaoDichTaiChinh;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuyTaiChinhController extends ThuQuyController
{
    public function index()
    {
        return view('_thu_quy.quy_tai_chinh.index');
    }

    public function getDanhSachQuy()
    {
        $quyTaiChinh = QuyTaiChinh::with('nguoiQuanLy');

        return DataTables::of($quyTaiChinh)
            ->editColumn('so_du_hien_tai', fn($quy) => $this->formatTien($quy->so_du_hien_tai))
            ->editColumn('trang_thai', fn($quy) => '<span class="badge ' . ($quy->trang_thai == 'hoat_dong' ? 'bg-success' : 'bg-warning') . '">' . ($quy->trang_thai == 'hoat_dong' ? 'Hoạt động' : 'Tạm dừng') . '</span>')
            ->addColumn('nguoi_quan_ly', fn($quy) => $quy->nguoiQuanLy ? $quy->nguoiQuanLy->ho_ten : 'Chưa có')
            ->addColumn('action', function ($quy) {
                $actions = '<a href="' . route('_thu_quy.quy.show', $quy->id) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>';
                $actions .= ' <a href="' . route('_thu_quy.quy.edit', $quy->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>';
                if ($this->user->vai_tro === 'quan_tri') {
                    $actions .= ' <button type="button" data-id="' . $quy->id . '" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>';
                }
                return '<div class="btn-group">' . $actions . '</div>';
            })
            ->rawColumns(['trang_thai', 'action'])
            ->make(true);
    }

    public function create()
    {
        $nguoiQuanLy = TinHuu::orderBy('ho_ten')->get();
        return view('_thu_quy.quy_tai_chinh.create', compact('nguoiQuanLy'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_quy' => 'required|max:255',
            'mo_ta' => 'nullable|string',
            'so_du_hien_tai' => 'required|numeric|min:0',
            'nguoi_quan_ly_id' => 'nullable|exists:tin_huu,id',
            'trang_thai' => 'required|in:hoat_dong,tam_dung'
        ]);

        $quy = QuyTaiChinh::create($validated);

        $this->ghiLogThaoTac('Tạo quỹ mới', 'quy_tai_chinh', $quy->id, null, $quy->toArray());

        if ($quy->nguoi_quan_ly_id) {
            $nguoiDung = TinHuu::find($quy->nguoi_quan_ly_id)->nguoiDung;
            if ($nguoiDung) {
                $this->guiThongBao(
                    'Phân công quản lý quỹ',
                    "Bạn được phân công làm người quản lý quỹ {$quy->ten_quy}",
                    'khac',
                    $nguoiDung->id,
                    QuyTaiChinh::class,
                    $quy->id
                );
            }
        }

        return redirect()->route('_thu_quy.quy.index')->with('success', 'Tạo quỹ thành công');
    }

    public function show($id)
    {
        $quy = QuyTaiChinh::with('nguoiQuanLy')->findOrFail($id);

        $thongKeThu = GiaoDichTaiChinh::where('quy_tai_chinh_id', $id)
            ->where('loai', 'thu')
            ->sum('so_tien');

        $thongKeChi = GiaoDichTaiChinh::where('quy_tai_chinh_id', $id)
            ->where('loai', 'chi')
            ->sum('so_tien');

        $giaoDichMoiNhat = GiaoDichTaiChinh::where('quy_tai_chinh_id', $id)
            ->orderBy('ngay_giao_dich', 'desc')
            ->take(5)
            ->get();

        $thongKeTheoThang = GiaoDichTaiChinh::where('quy_tai_chinh_id', $id)
            ->whereYear('ngay_giao_dich', now()->year)
            ->select(
                DB::raw('MONTH(ngay_giao_dich) as thang'),
                DB::raw('SUM(CASE WHEN loai = "thu" THEN so_tien ELSE 0 END) as tong_thu'),
                DB::raw('SUM(CASE WHEN loai = "chi" THEN so_tien ELSE 0 END) as tong_chi')
            )
            ->groupBy('thang')
            ->orderBy('thang')
            ->get();

        $dataChartLabels = [];
        $dataChartThu = [];
        $dataChartChi = [];

        for ($i = 1; $i <= 12; $i++) {
            $dataChartLabels[] = 'Tháng ' . $i;
            $thongKeThang = $thongKeTheoThang->firstWhere('thang', $i);
            $dataChartThu[] = $thongKeThang ? $thongKeThang->tong_thu : 0;
            $dataChartChi[] = $thongKeThang ? $thongKeThang->tong_chi : 0;
        }

        return view('_thu_quy.quy_tai_chinh.show', compact(
            'quy',
            'thongKeThu',
            'thongKeChi',
            'giaoDichMoiNhat',
            'dataChartLabels',
            'dataChartThu',
            'dataChartChi'
        ));
    }

    public function edit($id)
    {
        $quy = QuyTaiChinh::findOrFail($id);
        $nguoiQuanLy = TinHuu::orderBy('ho_ten')->get();

        return view('_thu_quy.quy_tai_chinh.edit', compact('quy', 'nguoiQuanLy'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'ten_quy' => 'required|max:255',
            'mo_ta' => 'nullable|string',
            'nguoi_quan_ly_id' => 'nullable|exists:tin_huu,id',
            'trang_thai' => 'required|in:hoat_dong,tam_dung'
        ]);

        $quy = QuyTaiChinh::findOrFail($id);
        $duLieuCu = $quy->toArray();
        $quanLyCu = $quy->nguoi_quan_ly_id;

        $quy->update($validated);

        $this->ghiLogThaoTac('Cập nhật quỹ', 'quy_tai_chinh', $quy->id, $duLieuCu, $quy->toArray());

        if ($quanLyCu != $quy->nguoi_quan_ly_id && $quy->nguoi_quan_ly_id) {
            $nguoiDung = TinHuu::find($quy->nguoi_quan_ly_id)->nguoiDung;
            if ($nguoiDung) {
                $this->guiThongBao(
                    'Phân công quản lý quỹ',
                    "Bạn được phân công làm người quản lý quỹ {$quy->ten_quy}",
                    'khac',
                    $nguoiDung->id,
                    QuyTaiChinh::class,
                    $quy->id
                );
            }
        }

        return redirect()->route('_thu_quy.quy.index')->with('success', 'Cập nhật quỹ thành công');
    }

    public function destroy($id)
    {
        if ($this->user->vai_tro !== 'quan_tri') {
            return response()->json(['success' => false, 'message' => 'Bạn không có quyền xóa quỹ']);
        }

        $quy = QuyTaiChinh::findOrFail($id);
        $soGiaoDich = $quy->giaoDich()->count();

        if ($soGiaoDich > 0) {
            return response()->json([
                'success' => false,
                'message' => "Không thể xóa quỹ này vì đã có {$soGiaoDich} giao dịch liên quan"
            ]);
        }

        $duLieuCu = $quy->toArray();
        $quy->delete();

        $this->ghiLogThaoTac('Xóa quỹ', 'quy_tai_chinh', $id, $duLieuCu, null);

        return response()->json(['success' => true]);
    }

    public function giaoDichQuy($id)
    {
        $quy = QuyTaiChinh::findOrFail($id);
        return view('_thu_quy.quy_tai_chinh.giao_dich', compact('quy'));
    }

    public function getGiaoDichQuy($id)
    {
        $giaoDich = GiaoDichTaiChinh::with(['buoiNhom', 'banNganh'])
            ->where('quy_tai_chinh_id', $id)
            ->orderBy('ngay_giao_dich', 'desc');

        return DataTables::of($giaoDich)
            ->editColumn('so_tien', fn($gd) => '<span class="' . ($gd->loai == 'thu' ? 'text-success' : 'text-danger') . '">' . ($gd->loai == 'thu' ? '+' : '-') . ' ' . $this->formatTien($gd->so_tien) . '</span>')
            ->editColumn('ngay_giao_dich', fn($gd) => $gd->ngay_giao_dich->format('d/m/Y'))
            ->editColumn('loai', fn($gd) => '<span class="badge ' . ($gd->loai == 'thu' ? 'bg-success' : 'bg-danger') . '">' . ($gd->loai == 'thu' ? 'Thu' : 'Chi') . '</span>')
            ->editColumn('hinh_thuc', function ($gd) {
                $hinhThucText = [
                    'dang_hien' => 'Dâng hiến',
                    'tai_tro' => 'Tài trợ',
                    'luong' => 'Lương',
                    'hoa_don' => 'Hóa đơn',
                    'sua_chua' => 'Sửa chữa',
                    'khac' => 'Khác'
                ];
                return $gd->hinh_thuc ? $hinhThucText[$gd->hinh_thuc] : '';
            })
            ->addColumn('buoi_nhom', fn($gd) => $gd->buoiNhom ? $gd->buoiNhom->chu_de : '')
            ->addColumn('ban_nganh', fn($gd) => $gd->banNganh ? $gd->banNganh->ten : '')
            ->addColumn('action', fn($gd) => '<a href="' . route('_thu_quy.giao_dich.show', $gd->id) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>')
            ->rawColumns(['so_tien', 'loai', 'action'])
            ->make(true);
    }
}