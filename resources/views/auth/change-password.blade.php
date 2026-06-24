@extends('layouts.auth')
@section('title', 'Ganti Password — Pasir Putih Parparean')
@section('content')
<div class="login-wrapper">

    <div class="login-visual">
        <div class="login-visual-bg"></div>
        <div class="login-visual-content">
            <a href="{{ url('/') }}" class="login-logo">
                Pasir Putih <span>Parparean</span>
            </a>
            <div class="login-visual-quote">
                <p>"Jaga keamanan akunmu dengan password yang kuat."</p>
                <div class="quote-line"></div>
            </div>
            <div class="login-visual-stats">
                <div class="vs-item">
                    <span class="vs-num">5K+</span>
                    <span class="vs-label">Pengunjung / Bulan</span>
                </div>
                <div class="vs-divider"></div>
                <div class="vs-item">
                    <span class="vs-num">4.8★</span>
                    <span class="vs-label">Rating Rata-rata</span>
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
                    <i class="fas fa-shield-halved"></i>
                </div>
                <h1>Ganti Password</h1>
                <p>
                    @if(auth()->user()->must_change_password)
                        Buat password baru untuk akunmu.
                    @else
                        Masukkan password lama dan buat password baru untuk akunmu.
                    @endif
                </p>
            </div>

            @if(session('info'))
                <div class="login-alert login-alert-info">
                    <i class="fas fa-circle-info"></i> {{ session('info') }}
                </div>
            @endif

            @if(session('success'))
                <div class="login-alert login-alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="login-alert login-alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.change.post') }}" class="login-form" id="changePasswordForm">
                @csrf

                {{-- Password Saat Ini — hanya tampil jika bukan dari lupa password --}}
                @if(!auth()->user()->must_change_password)
                <div class="form-group {{ $errors->has('current_password') ? 'has-error' : '' }}">
                    <label for="current_password">Password Saat Ini</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="current_password" id="current_password"
                            placeholder="••••••••"
                            autocomplete="off" required>
                        <button type="button" class="toggle-pw" id="toggleCurrent" tabindex="-1">
                            <i class="fas fa-eye" id="eyeIconCurrent"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <span class="field-error">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </span>
                    @enderror
                </div>
                @endif

                {{-- Password Baru --}}
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Password Baru</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password"
                            placeholder="Minimal 8 karakter"
                            autocomplete="new-password" required>
                        <button type="button" class="toggle-pw" id="togglePassword" tabindex="-1">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    <div class="pw-strength-wrap" id="pwStrengthWrap">
                        <div class="pw-strength-bar">
                            <div class="pw-strength-fill" id="pwStrengthFill"></div>
                        </div>
                        <span class="pw-strength-label" id="pwStrengthLabel"></span>
                    </div>
                    @error('password')
                        <span class="field-error">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Konfirmasi Password Baru --}}
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Ulangi password baru"
                            autocomplete="new-password" required>
                        <button type="button" class="toggle-pw" id="toggleConfirm" tabindex="-1">
                            <i class="fas fa-eye" id="eyeIconConfirm"></i>
                        </button>
                    </div>
                    <span class="field-error" id="matchError" style="display:none">
                        <i class="fas fa-circle-exclamation"></i> Password tidak cocok
                    </span>
                </div>

                <button type="submit" class="btn-login" id="changeBtn">
                    <span class="btn-text">Simpan Password Baru</span>
                    <i class="fas fa-arrow-right btn-icon"></i>
                </button>
            </form>

        </div>
    </div>
</div>
{{-- Tidak ada @push('scripts') — semua sudah di auth.js --}}
@endsection
