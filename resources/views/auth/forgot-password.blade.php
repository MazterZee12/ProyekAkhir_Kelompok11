@extends('layouts.auth')
@section('title', 'Lupa Password — Pasir Putih Parparean')
@section('content')
<div class="login-wrapper">

    <div class="login-visual">
        <div class="login-visual-bg"></div>
        <div class="login-visual-content">
            <a href="{{ url('/') }}" class="login-logo">
                Pasir Putih <span>Parparean</span>
            </a>
            <div class="login-visual-quote">
                <p>"Tenang, kami bantu kamu kembali masuk ke akunmu."</p>
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

            <a href="{{ route('login') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Login
            </a>

            <div class="login-form-header">
                <div class="login-badge">
                    <i class="fas fa-key"></i>
                </div>
                <h1>Lupa Password?</h1>
                <p>Masukkan nama lengkap dan email akunmu untuk verifikasi identitasmu.</p>
            </div>

            @if(session('error'))
                <div class="login-alert login-alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if(session('new_password'))
                <div class="new-password-box">
                    <div class="new-password-title">
                        <i class="fas fa-check-circle"></i> Verifikasi Berhasil!
                    </div>
                    <p class="new-password-hint">
                        Password sementara kamu adalah:
                    </p>
                    <div class="new-password-display">
                        <code id="newPwCode">{{ session('new_password') }}</code>
                        <button class="btn-copy" type="button" onclick="
                            navigator.clipboard.writeText(document.getElementById('newPwCode').textContent);
                            this.textContent = 'Tersalin!';
                            setTimeout(() => this.textContent = 'Salin', 2000);
                        ">Salin</button>
                    </div>
                    <p class="new-password-hint">
                        Salin password di atas lalu klik <strong>Masuk Sekarang</strong>.
                        Setelah login, kamu akan langsung diarahkan untuk mengganti password.
                    </p>
                    <a href="{{ route('login') }}" class="btn-login" style="margin-top:8px">
                        <span class="btn-text">Masuk Sekarang</span>
                        <i class="fas fa-arrow-right btn-icon"></i>
                    </a>
                </div>
            @else
                <form method="POST" action="{{ route('password.email') }}" class="login-form" id="forgotForm">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Nama Lengkap</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="name" id="name"
                                value="{{ old('name') }}"
                                placeholder="Nama lengkap sesuai akun"
                                autocomplete="name" autofocus required>
                        </div>
                        @error('name')
                            <span class="field-error">
                                <i class="fas fa-circle-exclamation"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">Alamat Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" id="email"
                                value="{{ old('email') }}"
                                placeholder="email@contoh.com"
                                autocomplete="email" required>
                        </div>
                        @error('email')
                            <span class="field-error">
                                <i class="fas fa-circle-exclamation"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-login" id="forgotBtn">
                        <span class="btn-text">Verifikasi & Reset Password</span>
                        <i class="fas fa-arrow-right btn-icon"></i>
                    </button>
                </form>

                <div class="login-footer">
                    <p>Ingat passwordnya? <a href="{{ route('login') }}">Masuk di sini</a></p>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
