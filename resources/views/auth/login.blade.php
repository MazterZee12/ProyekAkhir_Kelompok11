@extends('layouts.auth')

@section('title', 'Masuk — Pantai Pasir Putih Toba')

@section('content')
<div class="login-wrapper">

    <div class="login-visual">
        <div class="login-visual-bg"></div>
        <div class="login-visual-content">
            <a href="{{ url('/') }}" class="login-logo">
                Pasir Putih <span>Toba</span>
            </a>
            <div class="login-visual-quote">
                <p>"Keindahan alam Danau Toba adalah warisan yang harus kita jaga bersama."</p>
                <div class="quote-line"></div>
            </div>
            <div class="login-visual-stats">
                <div class="vs-item">
                    <span class="vs-num">5K+</span>
                    <span class="vs-label">Pengunjung / Bulan</span>
                </div>
                <div class="vs-divider"></div>
                <div class="vs-item">
                    <span class="vs-num">4.8</span>
                    <span class="vs-label">Rating Rata-rata</span>
                </div>
                <div class="vs-divider"></div>
                <div class="vs-item">
                    <span class="vs-num">15+</span>
                    <span class="vs-label">Fasilitas</span>
                </div>
            </div>
        </div>
    </div>

    <div class="login-form-panel">
        <div class="login-form-inner">

            <a href="{{ url('/') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Website
            </a>

            <div class="login-form-header">
                <div class="login-badge">
                    <i class="fas fa-user"></i>
                </div>
                <h1>Selamat Datang</h1>
                <p>Masuk untuk berbagi pengalamanmu di Pantai Pasir Putih Toba</p>
            </div>

            @if(session('info'))
                <div class="login-alert login-alert-info">
                    <i class="fas fa-clock"></i> {{ session('info') }}
                </div>
            @endif

            @if(session('error'))
                <div class="login-alert login-alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="login-alert login-alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="login-form">
                @csrf

                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" id="email"
                            value="{{ old('email') }}"
                            placeholder="email@contoh.com"
                            autocomplete="email" autofocus required>
                    </div>
                    @error('email')
                        <span class="field-error">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password"
                            placeholder="••••••••"
                            autocomplete="current-password" required>
                        <button type="button" class="toggle-pw" id="togglePassword" tabindex="-1">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="field-error">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-remember">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        Ingat saya selama 30 hari
                    </label>
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <span class="btn-text">Masuk</span>
                    <i class="fas fa-arrow-right btn-icon"></i>
                </button>
            </form>

            <div class="login-divider">
                <span>atau</span>
            </div>

            <a href="{{ route('register') }}" class="btn-register-alt">
                <i class="fas fa-user-plus"></i>
                Buat Akun Baru
            </a>
        </div>
    </div>

</div>
@endsection



@push('scripts')
<script>
const toggleBtn     = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');
const eyeIcon       = document.getElementById('eyeIcon');
if (toggleBtn && passwordInput) {
    toggleBtn.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        eyeIcon.className  = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
    });
}
</script>
@endpush
