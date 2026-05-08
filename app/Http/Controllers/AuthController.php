<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectAuthenticated(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectAuthenticated(Auth::user());
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->with('error', 'Email atau password salah.');
    }

    // public function showAdminLoginForm()
    // {
    //     if (Auth::check() && Auth::user()->role === 'admin') {
    //         return redirect()->route('admin.dashboard');
    //     }
    //     return view('auth.adminLogin');
    // }

    // public function adminLogin(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email'    => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);

    //     if (Auth::attempt($credentials, $request->boolean('remember'))) {
    //         $request->session()->regenerate();

    //         if (Auth::user()->role !== 'admin') {
    //             Auth::logout();
    //             return back()
    //                 ->withInput($request->only('email'))
    //                 ->with('error', 'Akun ini tidak memiliki akses admin.');
    //         }

    //         return redirect()->route('admin.dashboard');
    //     }

    //     return back()
    //         ->withInput($request->only('email', 'remember'))
    //         ->with('error', 'Email atau password salah.');
    // }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return $this->redirectAuthenticated(Auth::user());
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'user',
        ]);

        Auth::login($user);

        return redirect()
            ->route('home')
            ->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->name . '.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    protected function redirectAuthenticated($user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    }
}
