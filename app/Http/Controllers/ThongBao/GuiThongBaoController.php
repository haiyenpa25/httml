<?php

namespace App\Http\Controllers\ThongBao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThongBao;
use App\Models\NguoiDung;
use App\Models\BanNganh;
use App\Models\TinHuu;
use App\Models\TinHuuBanNganh;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GuiThongBaoController extends Controller
{
    /**
     * Hiển thị form gửi thông báo.
     *
     * @param \Illuminate\Database\Eloquent\Collection $cacBanNganh
     * @return \Illuminate\View\View
     */
    public function showCreateForm($cacBanNganh)
    {
        $user = Auth::user();
        $canSendToAll = $user->vai_tro === 'quan_tri';
        $banNganhManage = [];

        // Nếu là trưởng ban, lấy danh sách ban ngành quản lý
        if ($user->vai_tro === 'truong_ban') {
            $banNganhManage = BanNganh::where('truong_ban_id', $user->tin_huu_id)->get();
        }

        return view('_thong_bao.create', compact('cacBanNganh', 'canSendToAll', 'banNganhManage'));
    }

    /**
     * Lưu thông báo mới.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tieu_de' => 'required|string|max:255',
            'noi_dung' => 'required|string',
            'nguoi_nhan' => 'required|array',
        ]);

        $user = Auth::user();
        $nguoiNhans = $request->input('nguoi_nhan');
        $now = now();
        $thongBaos = [];

        try {
            DB::beginTransaction();

            // Tạo thông báo cho từng người nhận
            foreach ($nguoiNhans as $nguoiNhanId) {
                // Kiểm tra quyền gửi thông báo
                if (!$this->canSendTo($user, $nguoiNhanId)) {
                    continue;
                }

                $thongBao = ThongBao::create([
                    'tieu_de' => $request->tieu_de,
                    'noi_dung' => $request->noi_dung,
                    'loai' => 'trong_ung_dung',
                    'nguoi_nhan_id' => $nguoiNhanId,
                    'nguoi_gui_id' => $user->id,
                    'trang_thai' => 'da_gui',
                    'ngay_gui' => $now,
                    'da_doc' => false,
                    'luu_tru' => false
                ]);

                $thongBaos[] = $thongBao;
            }

            DB::commit();

            return redirect()->route('thong-bao.index')
                ->with('success', 'Đã gửi thông báo thành công đến ' . count($thongBaos) . ' người nhận.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Không thể gửi thông báo: ' . $e->getMessage());
        }
    }

    /**
     * Kiểm tra quyền gửi thông báo.
     *
     * @param  \App\Models\NguoiDung  $user
     * @param  int  $nguoiNhanId
     * @return bool
     */
    private function canSendTo($user, $nguoiNhanId)
    {
        // Quản trị viên có thể gửi cho bất kỳ ai
        if ($user->vai_tro === 'quan_tri') {
            return true;
        }

        // Trưởng ban có thể gửi cho thành viên trong ban ngành của mình
        if ($user->vai_tro === 'truong_ban') {
            $banNganhIds = BanNganh::where('truong_ban_id', $user->tin_huu_id)->pluck('id')->toArray();

            if (empty($banNganhIds)) {
                return false;
            }

            $nguoiNhan = NguoiDung::find($nguoiNhanId);
            if (!$nguoiNhan) {
                return false;
            }

            // Kiểm tra xem người nhận có thuộc ban ngành nào mà người gửi làm trưởng ban không
            $thanhVien = TinHuuBanNganh::where('tin_huu_id', $nguoiNhan->tin_huu_id)
                ->whereIn('ban_nganh_id', $banNganhIds)
                ->exists();

            return $thanhVien;
        }

        // Thành viên thường chỉ có thể gửi thông báo cá nhân cho trưởng ban hoặc quản trị viên
        $nguoiNhan = NguoiDung::find($nguoiNhanId);
        if (!$nguoiNhan) {
            return false;
        }

        return $nguoiNhan->vai_tro === 'quan_tri' || $nguoiNhan->vai_tro === 'truong_ban';
    }

    /**
     * Lấy danh sách người dùng theo ban ngành.
     *
     * @param  int  $banNganhId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersByBanNganh($banNganhId)
    {
        $users = NguoiDung::whereHas('tinHuu.banNganhs', function ($query) use ($banNganhId) {
            $query->where('ban_nganh.id', $banNganhId);
        })->with('tinHuu')->get();

        $formattedUsers = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'ho_ten' => $user->tinHuu->ho_ten,
            ];
        });

        return response()->json(['users' => $formattedUsers]);
    }

    /**
     * Lấy trưởng ban của ban ngành.
     *
     * @param  int  $banNganhId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTruongBan($banNganhId)
    {
        $banNganh = BanNganh::find($banNganhId);

        if (!$banNganh || !$banNganh->truong_ban_id) {
            return response()->json(['user' => null]);
        }

        $truongBan = NguoiDung::where('tin_huu_id', $banNganh->truong_ban_id)->with('tinHuu')->first();

        if (!$truongBan) {
            return response()->json(['user' => null]);
        }

        return response()->json([
            'user' => [
                'id' => $truongBan->id,
                'ho_ten' => $truongBan->tinHuu->ho_ten,
            ]
        ]);
    }

    /**
     * Lấy danh sách tất cả người dùng.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllUsers()
    {
        $users = NguoiDung::with('tinHuu')->get();

        $formattedUsers = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'ho_ten' => $user->tinHuu->ho_ten,
            ];
        });

        return response()->json(['users' => $formattedUsers]);
    }

    /**
     * API lấy danh sách người dùng theo vai trò
     *
     * @param string $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersByRole($role)
    {
        $validRoles = ['quan_tri', 'truong_ban', 'thanh_vien'];

        if (!in_array($role, $validRoles)) {
            return response()->json(['error' => 'Vai trò không hợp lệ'], 400);
        }

        $users = NguoiDung::where('vai_tro', $role)
            ->with('tinHuu')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'ho_ten' => $user->tinHuu->ho_ten,
                ];
            });

        return response()->json(['users' => $users]);
    }

    /**
     * Gửi thông báo nhanh cho một người
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendQuickMessage(Request $request)
    {
        $request->validate([
            'nguoi_nhan_id' => 'required|exists:nguoi_dung,id',
            'tieu_de' => 'required|string|max:255',
            'noi_dung' => 'required|string',
        ]);

        $user = Auth::user();

        // Kiểm tra quyền gửi thông báo
        if (!$this->canSendTo($user, $request->nguoi_nhan_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền gửi thông báo đến người này'
            ], 403);
        }

        try {
            $thongBao = ThongBao::create([
                'tieu_de' => $request->tieu_de,
                'noi_dung' => $request->noi_dung,
                'loai' => 'trong_ung_dung',
                'nguoi_nhan_id' => $request->nguoi_nhan_id,
                'nguoi_gui_id' => $user->id,
                'trang_thai' => 'da_gui',
                'ngay_gui' => now(),
                'da_doc' => false,
                'luu_tru' => false
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Đã gửi thông báo thành công',
                'data' => $thongBao
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể gửi thông báo: ' . $e->getMessage()
            ], 500);
        }
    }
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
