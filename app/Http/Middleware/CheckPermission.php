<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BanNganh;
use Illuminate\Support\Facades\Log;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::user();
        if (!$user) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Unauthorized.'], 401);
            }
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để truy cập.');
        }

        $banNganhId = $request->route('ban_nganh_id') ?? $request->input('id_ban_nganh');

        // Ánh xạ chuỗi ban_nganh_id thành ID số
        if ($banNganhId) {
            $banNganh = BanNganh::where('id', $banNganhId)->first();
            if (!$banNganh) {
                Log::error('Ban ngành không tồn tại: ' . $banNganhId);
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['error' => 'Ban ngành không tồn tại.'], 404);
                }
                return response()->view('errors.404', ['message' => 'Ban ngành không tồn tại.'], 404);
            }
            $banNganhId = $banNganh->id;
        } else {
            $banNganhId = null;
        }

        // Kiểm tra quyền admin-access
        if ($user->hasPermission('admin-access')) {
            return $next($request);
        }

        // Kiểm tra quyền trong ban ngành (nếu có) hoặc quyền toàn hệ thống
        if (!$user->hasPermission($permission, $banNganhId)) {
            Log::warning('User ' . $user->id . ' lacks permission ' . $permission . ' for ban_nganh_id: ' . ($banNganhId ?? 'null'));
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Không có quyền truy cập.'], 403);
            }
            return response()->view('errors.403', ['message' => 'Bạn không có quyền truy cập trang này.'], 403);
        }

        return $next($request);
    }
}
