<?php

namespace App\Http\Controllers\ThuQuy;

use App\Models\GiaoDichTaiChinh;
use Yajra\DataTables\Facades\DataTables;

class GiaoDichTaiChinhController extends ThuQuyController
{
    /**
     * Hiển thị danh sách giao dịch tài chính
     */
    public function index()
    {
        return view('_thu_quy.giao_dich.index');
    }

    /**
     * Lấy dữ liệu cho DataTables
     */
    public function getDanhSachGiaoDich()
    {
        $giaoDich = GiaoDichTaiChinh::with(['quyTaiChinh', 'buoiNhom', 'banNganh'])
            ->orderBy('ngay_giao_dich', 'desc');

        return DataTables::of($giaoDich)
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
            ->addColumn('action', function ($gd) {
                $actions = '<a href="' . route('_thu_quy.giao_dich.show', $gd->id) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>';
                if ($this->user->vai_tro === 'quan_tri' || $gd->trang_thai === 'cho_duyet') {
                    $actions .= ' <a href="' . route('_thu_quy.giao_dich.edit', $gd->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>';
                    $actions .= ' <button type="button" data-id="' . $gd->id . '" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>';
                }
                if ($this->kiemTraQuyenDuyet() && $gd->trang_thai === 'cho_duyet') {
                    $actions .= ' <a href="' . route('_thu_quy.giao_dich.duyet.show', $gd->id) . '" class="btn btn-sm btn-success"><i class="fas fa-check"></i> Duyệt</a>';
                }
                return '<div class="btn-group">' . $actions . '</div>';
            })
            ->rawColumns(['so_tien', 'loai', 'trang_thai', 'action'])
            ->make(true);
    }

    /**
     * Hiển thị chi tiết giao dịch
     */
    public function show($id)
    {
        $giaoDich = GiaoDichTaiChinh::with(['quyTaiChinh', 'buoiNhom', 'banNganh', 'chiDinhKy', 'nguoiDuyet'])
            ->findOrFail($id);

        return view('_thu_quy.giao_dich.show', compact('giaoDich'));
    }
}