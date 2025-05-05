<?php

namespace App\Http\Controllers;

use App\Models\GiaoDichTaiChinh;
use App\Models\BanNganh;
use Illuminate\Http\Request;

class GiaoDichTaiChinhController extends Controller
{
    public function index()
    {
        $giaoDichTaiChinhs = GiaoDichTaiChinh::all();
        return view('giao_dich_tai_chinh.index', compact('giaoDichTaiChinhs'));
    }

    public function create()
    {
        $banNganhs = BanNganh::all();
        return view('giao_dich_tai_chinh.create', compact('banNganhs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'loai' => 'required|enum:thu,chi',
            'so_tien' => 'required|numeric',
            'mo_ta' => 'required|text',
            'ngay_giao_dich' => 'required|date',
            'ban_nganh_id' => 'nullable|exists:ban_nganh,id',
        ]);

        GiaoDichTaiChinh::create($validatedData);

        return redirect()->route('giao-dich-tai-chinh.index')->with('success', 'Giao dịch tài chính đã được thêm thành công!');
    }

    public function show2(GiaoDichTaiChinh $giaoDichTaiChinh)
    {
        return view('giao_dich_tai_chinh.show', compact('giaoDichTaiChinh'));
    }

    public function edit(GiaoDichTaiChinh $giaoDichTaiChinh)
    {
        $banNganhs = BanNganh::all();
        return view('giao_dich_tai_chinh.edit', compact('giaoDichTaiChinh', 'banNganhs'));
    }

    public function update(Request $request, GiaoDichTaiChinh $giaoDichTaiChinh)
    {
        $validatedData = $request->validate([
            'loai' => 'required|enum:thu,chi',
            'so_tien' => 'required|numeric',
            'mo_ta' => 'required|text',
            'ngay_giao_dich' => 'required|date',
            'ban_nganh_id' => 'nullable|exists:ban_nganh,id',
        ]);

        $giaoDichTaiChinh->update($validatedData);

        return redirect()->route('giao-dich-tai-chinh.index')->with('success', 'Giao dịch tài chính đã được cập nhật thành công!');
    }

    public function destroy(GiaoDichTaiChinh $giaoDichTaiChinh)
    {
        $giaoDichTaiChinh->delete();
        return redirect()->route('giao-dich-tai-chinh.index')->with('success', 'Giao dịch tài chính đã được xóa thành công!');
    }
    public function baoCao()
    {
        /* Tạo báo cáo tài chính */
    }


    /**
     * Lấy dữ liệu cho DataTables
     */
    public function getDanhSachGiaoDich(Request $request)
    {
        $giaoDich = GiaoDichTaiChinh::with(['quyTaiChinh', 'buoiNhom', 'banNganh'])
            ->orderBy('ngay_giao_dich', 'desc');

        return DataTables::of($giaoDich)
            ->editColumn('so_tien', function ($gd) {
                $class = ($gd->loai == 'thu') ? 'text-success' : 'text-danger';
                $prefix = ($gd->loai == 'thu') ? '+' : '-';
                return '<span class="' . $class . '">' . $prefix . ' ' . $this->formatTien($gd->so_tien) . '</span>';
            })
            ->editColumn('ngay_giao_dich', function ($gd) {
                return $gd->ngay_giao_dich->format('d/m/Y');
            })
            ->editColumn('loai', function ($gd) {
                $class = ($gd->loai == 'thu') ? 'badge bg-success' : 'badge bg-danger';
                $text = ($gd->loai == 'thu') ? 'Thu' : 'Chi';
                return '<span class="' . $class . '">' . $text . '</span>';
            })
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
            ->addColumn('quy_tai_chinh', function ($gd) {
                return $gd->quyTaiChinh ? $gd->quyTaiChinh->ten_quy : '';
            })
            ->addColumn('action', function ($gd) {
                $btnXem = '<a href="' . route('thu_quy.giao_dich.show', $gd->id) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>';

                $btnSua = '';
                $btnXoa = '';

                // Chỉ có thể sửa/xóa nếu là người tạo hoặc admin và giao dịch chưa được duyệt
                if ($this->user->vai_tro == 'quan_tri' || ($gd->trang_thai == 'cho_duyet')) {
                    $btnSua = '<a href="' . route('thu_quy.giao_dich.edit', $gd->id) . '" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>';
                    $btnXoa = '<button type="button" data-id="' . $gd->id . '" class="btn btn-sm btn-danger btn-delete"><i class="fas fa-trash"></i></button>';
                }

                // Nút duyệt giao dịch
                $btnDuyet = '';
                if ($this->kiemTraQuyenDuyet() && $gd->trang_thai == 'cho_duyet') {
                    $btnDuyet = '<a href="' . route('thu_quy.giao_dich.duyet.show', $gd->id) . '" class="btn btn-sm btn-success"><i class="fas fa-check"></i> Duyệt</a>';
                }

                return '<div class="btn-group">' . $btnXem . ' ' . $btnSua . ' ' . $btnXoa . ' ' . $btnDuyet . '</div>';
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

        return view('thu_quy.giao_dich.show', compact('giaoDich'));
    }


}