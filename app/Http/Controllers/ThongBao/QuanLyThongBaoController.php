<?php

namespace App\Http\Controllers\ThongBao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThongBao;
use Illuminate\Support\Facades\Auth;

class QuanLyThongBaoController extends Controller
{
    /**
     * Đánh dấu thông báo đã đọc.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        $thongBao = ThongBao::where('id', $id)
            ->where('nguoi_nhan_id', $user->id)
            ->firstOrFail();

        $thongBao->da_doc = true;
        $thongBao->save();

        return response()->json([
            'success' => true,
            'message' => 'Đánh dấu thông báo đã đọc thành công.'
        ]);
    }

    /**
     * Đánh dấu nhiều thông báo đã đọc.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markMultipleAsRead(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'numeric|exists:thong_bao,id'
        ]);

        $user = Auth::user();
        $ids = $request->input('ids');

        $count = ThongBao::whereIn('id', $ids)
            ->where('nguoi_nhan_id', $user->id)
            ->update(['da_doc' => true]);

        return response()->json([
            'success' => true,
            'message' => "Đã đánh dấu $count thông báo là đã đọc."
        ]);
    }

    /**
     * Lưu trữ thông báo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function archive($id)
    {
        $user = Auth::user();
        $thongBao = ThongBao::where('id', $id)
            ->where('nguoi_nhan_id', $user->id)
            ->firstOrFail();

        $thongBao->luu_tru = true;
        $thongBao->save();

        return response()->json([
            'success' => true,
            'message' => 'Đã lưu trữ thông báo thành công.'
        ]);
    }

    /**
     * Lưu trữ nhiều thông báo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function archiveMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'numeric|exists:thong_bao,id'
        ]);

        $user = Auth::user();
        $ids = $request->input('ids');

        $count = ThongBao::whereIn('id', $ids)
            ->where('nguoi_nhan_id', $user->id)
            ->update(['luu_tru' => true]);

        return response()->json([
            'success' => true,
            'message' => "Đã lưu trữ $count thông báo."
        ]);
    }

    /**
     * Bỏ lưu trữ thông báo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function unarchive($id)
    {
        $user = Auth::user();
        $thongBao = ThongBao::where('id', $id)
            ->where('nguoi_nhan_id', $user->id)
            ->firstOrFail();

        $thongBao->luu_tru = false;
        $thongBao->save();

        return response()->json([
            'success' => true,
            'message' => 'Đã bỏ lưu trữ thông báo thành công.'
        ]);
    }

    /**
     * Bỏ lưu trữ nhiều thông báo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unarchiveMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'numeric|exists:thong_bao,id'
        ]);

        $user = Auth::user();
        $ids = $request->input('ids');

        $count = ThongBao::whereIn('id', $ids)
            ->where('nguoi_nhan_id', $user->id)
            ->update(['luu_tru' => false]);

        return response()->json([
            'success' => true,
            'message' => "Đã bỏ lưu trữ $count thông báo."
        ]);
    }

    /**
     * Xóa thông báo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $thongBao = ThongBao::where('id', $id)
            ->where('nguoi_nhan_id', $user->id)
            ->firstOrFail();

        $thongBao->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa thông báo thành công.'
        ]);
    }

    /**
     * Xóa nhiều thông báo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyMultiple(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'numeric|exists:thong_bao,id'
        ]);

        $user = Auth::user();
        $ids = $request->input('ids');

        $count = ThongBao::whereIn('id', $ids)
            ->where('nguoi_nhan_id', $user->id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => "Đã xóa $count thông báo."
        ]);
    }

    /**
     * Hiển thị thông báo đã lưu trữ.
     *
     * @return \Illuminate\View\View
     */
    public function archived()
    {
        $user = Auth::user();

        $thongBaos = ThongBao::where('nguoi_nhan_id', $user->id)
            ->where('luu_tru', true)
            ->orderBy('ngay_gui', 'desc')
            ->with(['nguoiGui.tinHuu'])
            ->paginate(10);

        return view('_thong_bao.archived', compact('thongBaos'));
    }

    /**
     * Hiển thị thông báo đã gửi.
     *
     * @return \Illuminate\View\View
     */
    public function sent()
    {
        $user = Auth::user();

        $thongBaos = ThongBao::where('nguoi_gui_id', $user->id)
            ->orderBy('ngay_gui', 'desc')
            ->with(['nguoiNhan.tinHuu'])
            ->paginate(10);

        return view('_thong_bao.sent', compact('thongBaos'));
    }
}
