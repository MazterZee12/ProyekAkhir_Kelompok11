<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ── Login ────────────────────────────────────────────────

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
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->must_change_password) {
                return redirect()->route('password.change')
                    ->with('info', 'Kamu menggunakan password sementara. Silakan ganti sekarang.');
            }

            return $this->redirectAuthenticated($user);
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->with('error', 'Email atau password salah.');
    }

    // ── Register ─────────────────────────────────────────────

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
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'name.string'        => 'Nama lengkap tidak valid.',
            'name.max'           => 'Nama lengkap maksimal 255 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.string'       => 'Email tidak valid.',
            'email.email'        => 'Format email tidak valid.',
            'email.max'          => 'Email maksimal 255 karakter.',
            'email.unique'       => 'Email ini sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
        ]);

        try {
            $user = User::create([
                'name'                 => $validated['name'],
                'email'                => $validated['email'],
                'password'             => Hash::make($validated['password']),
                'role'                 => 'user',
                'must_change_password' => false,
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()
                ->intended(route('home'))
                ->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->name . '.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat akun. Silakan coba lagi.');
        }
    }

    // ── Logout ───────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    // ── Lupa Password ────────────────────────────────────────

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function resetPasswordSimple(Request $request)
    {
        $request->validate([
            'name'  => ['required', 'string'],
            'email' => ['required', 'email'],
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', 'user')
                    ->first();

        if (!$user || strtolower(trim($user->name)) !== strtolower(trim($request->name))) {
            return back()
                ->withInput()
                ->with('error', 'Nama lengkap atau email tidak sesuai dengan data akun.');
        }

        try {
            $newPassword = Str::random(8);

            $user->update([
                'password'             => Hash::make($newPassword),
                'must_change_password' => true,
            ]);

            return back()->with('new_password', $newPassword);

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal mereset password. Silakan coba lagi.');
        }
    }

    // ── Ganti Password ───────────────────────────────────────

    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required'         => 'Password baru wajib diisi.',
            'password.confirmed'        => 'Konfirmasi password tidak cocok.',
            'password.min'              => 'Password baru minimal 8 karakter.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini tidak sesuai.');
        }

        try {
            $user->update([
                'password'             => Hash::make($request->password),
                'must_change_password' => false,
            ]);

            return back()->with('success', 'Password berhasil diubah! Gunakan password baru ini untuk login berikutnya.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengubah password. Silakan coba lagi.');
        }
    }

    // ── Helper ───────────────────────────────────────────────

    protected function redirectAuthenticated($user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->intended(route('home'));
    }
}
