<?php

namespace App\Http\Controllers\ThuQuy;

use App\Models\LichSuThaoTac;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LichSuThaoTacController extends ThuQuyController
{
    /**
     * Hiển thị danh sách lịch sử thao tác
     */
    public function index()
    {
        return view('_thu_quy.lich_su.index');
    }

    /**
     * Lấy dữ liệu lịch sử thao tác cho DataTables
     */
    public function getData(Request $request)
    {
        $lichSu = LichSuThaoTac::with('nguoiDung')
            ->orderBy('created_at', 'desc');

        return DataTables::of($lichSu)
            ->editColumn('created_at', fn($log) => $log->created_at->format('d/m/Y H:i:s'))
            ->addColumn('nguoi_dung', fn($log) => $log->nguoiDung ? $log->nguoiDung->tinHuu->ho_ten : 'Không xác định')
            ->addColumn('bang_tac_dong', fn($log) => $log->bang_tac_dong)
            ->addColumn('id_tac_dong', fn($log) => $log->id_tac_dong)
            ->editColumn('ip_address', fn($log) => $log->ip_address)
            ->make(true);
    }
}