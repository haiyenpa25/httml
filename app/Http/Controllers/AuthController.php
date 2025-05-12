<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'mat_khau' => 'required',
        ]);

        // Đổi tên 'mat_khau' thành 'password' để phù hợp với Auth::attempt
        $credentials['password'] = $credentials['mat_khau'];
        unset($credentials['mat_khau']);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Lấy default_url từ nguoi_dung hoặc nguoi_dung_phan_quyen
            $defaultUrl = $user->default_url ?? $user->quyen()->whereNotNull('default_url')->value('default_url') ?? '/dashboard';

            Log::info('User logged in: ' . $user->id . ', redirecting to: ' . $defaultUrl);

            return redirect()->to($defaultUrl)->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Đã đăng xuất thành công!');
    }

    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $nguoiDung = NguoiDung::where('email', $request->email)->with('tinHuu')->first();

        if (!$nguoiDung || !Hash::check($request->password, $nguoiDung->mat_khau)) {
            return response()->json([
                'success' => false,
                'message' => 'Thông tin đăng nhập không hợp lệ.'
            ], 401);
        }

        // Tạo token nếu đăng nhập thành công
        $token = md5(uniqid() . $nguoiDung->id . time());
        $nguoiDung->api_token = $token;
        $nguoiDung->save();

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $nguoiDung->id,
                'tin_huu_id' => $nguoiDung->tin_huu_id,
                'ho_ten' => $nguoiDung->tinHuu->ho_ten,
                'email' => $nguoiDung->email,
                'vai_tro' => $nguoiDung->vai_tro
            ],
            'token' => $token
        ]);
    }
}
?>