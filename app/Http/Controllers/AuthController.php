<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NguoiDung; // Import Model NguoiDung
use Illuminate\Support\Facades\Hash; // Import Hash

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'mat_khau' => 'required',
        ]);

        $user = NguoiDung::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['mat_khau'], $user->mat_khau)) {
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();
            return redirect()->intended('/dashboard'); // Thay đổi đường dẫn nếu cần
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}