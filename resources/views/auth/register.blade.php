@extends('layouts.auth')

@section('title', 'Daftar Akun — Pasir Putih Parparean')

@section('content')
<div class="login-wrapper register-wrapper">

    {{-- LEFT VISUAL PANEL --}}
    <div class="login-visual">
        <div class="login-visual-bg"></div>
        <div class="login-visual-content">
            <a href="{{ url('/') }}" class="login-logo">
                Pasir Putih <span>Toba</span>
            </a>
            <div class="login-visual-quote">
                <p>"Bergabunglah dengan ribuan wisatawan yang telah merasakan keajaiban Danau Toba."</p>
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
                <div class="vs-divider"></div>
                <div class="vs-item">
                    <span class="vs-num">100%</span>
                    <span class="vs-label">Gratis Daftar</span>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT FORM PANEL --}}
    <div class="login-form-panel">
        <div class="login-form-inner">

            <a href="{{ url('/') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali ke Website
            </a>

            <div class="login-form-header">
                <div class="login-badge register-badge">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1>Buat Akun</h1>
                <p>Daftar untuk bisa memberikan ulasan pengalamanmu</p>
            </div>

            @if(session('error'))
                <div class="login-alert login-alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" class="login-form" id="registerForm">
                @csrf

                {{-- Name --}}
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="name" id="name"
                            value="{{ old('name') }}"
                            placeholder="Nama lengkapmu"
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
                    <label for="email">Email</label>
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

                {{-- Password --}}
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password"
                            placeholder="Minimal 8 karakter"
                            autocomplete="new-password" required>
                        <button type="button" class="toggle-pw" id="togglePassword" tabindex="-1">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    {{-- Strength bar --}}
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

                {{-- Confirm Password --}}
                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="Ulangi password"
                            autocomplete="new-password" required>
                        <button type="button" class="toggle-pw" id="toggleConfirm" tabindex="-1">
                            <i class="fas fa-eye" id="eyeIconConfirm"></i>
                        </button>
                    </div>
                    <span class="field-error" id="matchError" style="display:none">
                        <i class="fas fa-circle-exclamation"></i> Password tidak cocok
                    </span>
                    @error('password_confirmation')
                        <span class="field-error">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn-login" id="registerBtn">
                    <span class="btn-text">Buat Akun Sekarang</span>
                    <i class="fas fa-arrow-right btn-icon"></i>
                </button>
            </form>

            <div class="login-footer">
                <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// Toggle password visibility
function setupToggle(btnId, inputId, iconId) {
    const btn = document.getElementById(btnId);
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    if (!btn) return;
    btn.addEventListener('click', () => {
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
    });
}
setupToggle('togglePassword', 'password', 'eyeIcon');
setupToggle('toggleConfirm', 'password_confirmation', 'eyeIconConfirm');

// Password strength
const pwInput = document.getElementById('password');
const strengthFill = document.getElementById('pwStrengthFill');
const strengthLabel = document.getElementById('pwStrengthLabel');
const strengthWrap = document.getElementById('pwStrengthWrap');

pwInput.addEventListener('input', () => {
    const val = pwInput.value;
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = [
        { pct: '0%',   color: 'transparent', label: '' },
        { pct: '25%',  color: '#ef4444',      label: 'Lemah' },
        { pct: '50%',  color: '#f97316',      label: 'Sedang' },
        { pct: '75%',  color: '#eab308',      label: 'Kuat' },
        { pct: '100%', color: '#22c55e',      label: 'Sangat Kuat' },
    ];

    const lvl = val.length === 0 ? levels[0] : levels[score] || levels[1];
    strengthWrap.style.opacity = val.length ? '1' : '0';
    strengthFill.style.width = lvl.pct;
    strengthFill.style.background = lvl.color;
    strengthLabel.textContent = lvl.label;
    strengthLabel.style.color = lvl.color;
});

// Password match check
const confirmInput = document.getElementById('password_confirmation');
const matchError = document.getElementById('matchError');

confirmInput.addEventListener('input', checkMatch);
pwInput.addEventListener('input', checkMatch);

function checkMatch() {
    if (confirmInput.value.length === 0) { matchError.style.display = 'none'; return; }
    matchError.style.display = pwInput.value !== confirmInput.value ? 'flex' : 'none';
}

// Prevent submit if no match
document.getElementById('registerForm').addEventListener('submit', function(e) {
    if (pwInput.value !== confirmInput.value) {
        e.preventDefault();
        matchError.style.display = 'flex';
        confirmInput.focus();
    }
});
</script>
@endpush
