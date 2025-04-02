<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'mat_khau' => 'required', // Use 'mat_khau' to match database column name
        ]);

        //dd($request->all()); // Kiểm tra dữ liệu đầu vào

        $authAttemptResult = Auth::attempt(['email' => $credentials['email'], 'mat_khau' => $credentials['mat_khau']]);

        dd($authAttemptResult); // Kiểm tra kết quả của Auth::attempt()

        if ($authAttemptResult) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard'); // Chuyển hướng đến trang dashboard sau khi đăng nhập thành công
        }

        Log::error('Login attempt failed for email: ' . $credentials['email']); // Ghi log lỗi đăng nhập

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Chuyển hướng đến trang đăng nhập sau khi đăng xuất
    }
}