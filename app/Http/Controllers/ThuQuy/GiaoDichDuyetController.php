<?php

namespace App\Http\Controllers\ThuQuy;

use App\Models\GiaoDichTaiChinh;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GiaoDichDuyetController extends ThuQuyController
{
    /**
     * Hiển thị trang duyệt giao dịch
     */
    public function show($id)
    {
        if (!$this->kiemTraQuyenDuyet()) {
            return redirect()->route('_thu_quy.giao_dich.index')
                ->with('error', 'Bạn không có quyền duyệt giao dịch');
        }

        $giaoDich = GiaoDichTaiChinh::with(['quyTaiChinh', 'buoiNhom', 'banNganh', 'chiDinhKy'])
            ->findOrFail($id);

        if ($giaoDich->trang_thai !== 'cho_duyet') {
            return redirect()->route('_thu_quy.giao_dich.show', $id)
                ->with('error', 'Giao dịch này không cần duyệt');
        }

        return view('_thu_quy.giao_dich.duyet', compact('giaoDich'));
    }

    /**
     * Xử lý duyệt giao dịch
     */
    public function update(Request $request, $id)
    {
        if (!$this->kiemTraQuyenDuyet()) {
            return redirect()->route('_thu_quy.giao_dich.index')
                ->with('error', 'Bạn không có quyền duyệt giao dịch');
        }

        $giaoDich = GiaoDichTaiChinh::with('quyTaiChinh')->findOrFail($id);

        if ($giaoDich->trang_thai !== 'cho_duyet') {
            return redirect()->route('_thu_quy.giao_dich.show', $id)
                ->with('error', 'Giao dịch này không cần duyệt');
        }

        $validated = $request->validate([
            'hanh_dong' => 'required|in:duyet,tu_choi',
            'ly_do_tu_choi' => 'required_if:hanh_dong,tu_choi|string'
        ]);

        $duLieuCu = $giaoDich->toArray();

        if ($validated['hanh_dong'] === 'duyet') {
            $giaoDich->trang_thai = 'hoan_thanh';
            $giaoDich->nguoi_duyet_id = $this->user->tin_huu_id;
            $giaoDich->ngay_duyet = now();

            $this->capNhatSoDuQuy($giaoDich->quy_tai_chinh_id, $giaoDich->so_tien, $giaoDich->loai);

            $this->guiThongBao(
                'Giao dịch đã được duyệt',
                "Giao dịch {$giaoDich->ma_giao_dich} đã được duyệt và hoàn thành",
                'da_duyet',
                $this->user->id,
                GiaoDichTaiChinh::class,
                $giaoDich->id
            );

            $message = 'Duyệt giao dịch thành công';
        } else {
            $giaoDich->trang_thai = 'tu_choi';
            $giaoDich->nguoi_duyet_id = $this->user->tin_huu_id;
            $giaoDich->ngay_duyet = now();
            $giaoDich->ly_do_tu_choi = $validated['ly_do_tu_choi'];

            $this->guiThongBao(
                'Giao dịch bị từ chối',
                "Giao dịch {$giaoDich->ma_giao_dich} đã bị từ chối với lý do: {$giaoDich->ly_do_tu_choi}",
                'tu_choi',
                $this->user->id,
                GiaoDichTaiChinh::class,
                $giaoDich->id
            );

            $message = 'Từ chối giao dịch thành công';
        }

        $giaoDich->save();
        $this->ghiLogThaoTac(
            $validated['hanh_dong'] === 'duyet' ? 'Duyệt giao dịch' : 'Từ chối giao dịch',
            'giao_dich_tai_chinh',
            $giaoDich->id,
            $duLieuCu,
            $giaoDich->toArray()
        );

        return redirect()->route('_thu_quy.giao_dich.show', $id)->with('success', $message);
    }

    /**
     * Hiển thị danh sách giao dịch chờ duyệt
     */
    public function danhSachChoDuyet()
    {
        if (!$this->kiemTraQuyenDuyet()) {
            return redirect()->route('_thu_quy.dashboard')
                ->with('error', 'Bạn không có quyền duyệt giao dịch');
        }

        return view('_thu_quy.giao_dich.danh_sach_cho_duyet');
    }

    /**
     * Lấy dữ liệu giao dịch chờ duyệt cho DataTables
     */
    public function getDanhSachChoDuyet()
    {
        $giaoDich = GiaoDichTaiChinh::with(['quyTaiChinh', 'buoiNhom', 'banNganh'])
            ->where('trang_thai', 'cho_duyet')
            ->orderBy('ngay_giao_dich', 'desc');

        return DataTables::of($giaoDich)
            ->editColumn('so_tien', fn($gd) => $this->formatTien($gd->so_tien))
            ->editColumn('ngay_giao_dich', fn($gd) => $gd->ngay_giao_dich->format('d/m/Y'))
            ->addColumn('quy_tai_chinh', fn($gd) => $gd->quyTaiChinh ? $gd->quyTaiChinh->ten_quy : '')
            ->addColumn('action', fn($gd) => '<div class="btn-group">' .
                '<a href="' . route('_thu_quy.giao_dich.show', $gd->id) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a> ' .
                '<a href="' . route('_thu_quy.giao_dich.duyet.show', $gd->id) . '" class="btn btn-sm btn-success"><i class="fas fa-check"></i> Duyệt</a>' .
                '</div>')
            ->rawColumns(['action'])
            ->make(true);
    }
}