<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        // redirect ke dashboard jika sudah login
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        try {
            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }

            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput();

        } catch (\Exception $e) {
            Log::error('AuthController::login failed', [
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);
            return back()
                ->withErrors(['email' => 'Terjadi kesalahan. Silakan coba lagi.'])
                ->withInput();
        }
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
