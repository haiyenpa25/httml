<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Đảm bảo view này tồn tại
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email', // Thêm 'email' validation
            'mat_khau' => 'required',
        ]);

        $user = NguoiDung::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['mat_khau'], $user->mat_khau)) {
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();
            return redirect()->intended('/trang-chu');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput(); // Thêm ->withInput() để giữ lại email đã nhập
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
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
