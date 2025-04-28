<?php

namespace App\Http\Controllers\ThongBao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThongBao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NhanThongBaoController extends Controller
{
    /**
     * Hiển thị hộp thư đến của người dùng.
     *
     * @return \Illuminate\View\View
     */
    public function inbox()
    {
        $user = Auth::user();

        $thongBaos = ThongBao::where('nguoi_nhan_id', $user->id)
            ->where('luu_tru', false)
            ->orderBy('ngay_gui', 'desc')
            ->with(['nguoiGui.tinHuu'])
            ->paginate(10);

        return view('_thong_bao.inbox', compact('thongBaos'));
    }

    /**
     * Hiển thị chi tiết thông báo.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = Auth::user();
        $thongBao = ThongBao::where('id', $id)
            ->where('nguoi_nhan_id', $user->id)
            ->with(['nguoiGui.tinHuu'])
            ->firstOrFail();

        // Đánh dấu là đã đọc nếu chưa đọc
        if (!$thongBao->da_doc) {
            $thongBao->da_doc = true;
            $thongBao->save();
        }

        return view('_thong_bao.show', compact('thongBao'));
    }

    /**
     * Đếm số thông báo chưa đọc của người dùng.
     *
     * @return int
     */
    public function demThongBaoChuaDoc()
    {
        $user = Auth::user();
        return ThongBao::where('nguoi_nhan_id', $user->id)
            ->where('da_doc', false)
            ->count();
    }

    /**
     * Trả về số lượng thông báo chưa đọc (dùng cho AJAX).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function countUnread()
    {
        $count = $this->demThongBaoChuaDoc();
        return response()->json(['count' => $count]);
    }

    /**
     * Lấy danh sách các thông báo mới nhất (dùng cho AJAX).
     *
     * @param  int  $limit
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLatestNotifications($limit = 5)
    {
        $user = Auth::user();

        $thongBaos = ThongBao::where('nguoi_nhan_id', $user->id)
            ->orderBy('ngay_gui', 'desc')
            ->with(['nguoiGui.tinHuu'])
            ->limit($limit)
            ->get()
            ->map(function ($thongBao) {
                return [
                    'id' => $thongBao->id,
                    'tieu_de' => $thongBao->tieu_de,
                    'nguoi_gui' => $thongBao->nguoiGui->tinHuu->ho_ten,
                    'ngay_gui' => $thongBao->ngay_gui->format('d/m/Y H:i'),
                    'da_doc' => (bool) $thongBao->da_doc,
                ];
            });

        return response()->json(['notifications' => $thongBaos]);
    }
}
