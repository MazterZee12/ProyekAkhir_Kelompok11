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
                <p>Masukkan password lama dan buat password baru untuk akunmu.</p>
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

                {{-- Password Saat Ini --}}
                <div class="form-group {{ $errors->has('current_password') ? 'has-error' : '' }}">
                    <label for="current_password">Password Saat Ini</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="current_password" id="current_password"
                            placeholder="••••••••"
                            autocomplete="current-password" required>
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

@push('scripts')
<script>
function setupToggle(btnId, inputId, iconId) {
    const btn   = document.getElementById(btnId);
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (!btn) return;
    btn.addEventListener('click', () => {
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
    });
}
setupToggle('toggleCurrent',  'current_password',     'eyeIconCurrent');
setupToggle('togglePassword', 'password',              'eyeIcon');
setupToggle('toggleConfirm',  'password_confirmation', 'eyeIconConfirm');

const pwInput       = document.getElementById('password');
const strengthFill  = document.getElementById('pwStrengthFill');
const strengthLabel = document.getElementById('pwStrengthLabel');
const strengthWrap  = document.getElementById('pwStrengthWrap');

pwInput.addEventListener('input', () => {
    const val = pwInput.value;
    let score = 0;
    if (val.length >= 8)          score++;
    if (/[A-Z]/.test(val))        score++;
    if (/[0-9]/.test(val))        score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = [
        { pct: '0%',   color: 'transparent', label: '' },
        { pct: '25%',  color: '#ef4444',     label: 'Lemah' },
        { pct: '50%',  color: '#f97316',     label: 'Sedang' },
        { pct: '75%',  color: '#eab308',     label: 'Kuat' },
        { pct: '100%', color: '#22c55e',     label: 'Sangat Kuat' },
    ];

    const lvl = val.length === 0 ? levels[0] : (levels[score] || levels[1]);
    strengthWrap.style.opacity    = val.length ? '1' : '0';
    strengthFill.style.width      = lvl.pct;
    strengthFill.style.background = lvl.color;
    strengthLabel.textContent     = lvl.label;
    strengthLabel.style.color     = lvl.color;
});

const confirmInput = document.getElementById('password_confirmation');
const matchError   = document.getElementById('matchError');

function checkMatch() {
    if (!confirmInput.value.length) { matchError.style.display = 'none'; return; }
    matchError.style.display = pwInput.value !== confirmInput.value ? 'flex' : 'none';
}
confirmInput.addEventListener('input', checkMatch);
pwInput.addEventListener('input', checkMatch);

document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    if (pwInput.value !== confirmInput.value) {
        e.preventDefault();
        matchError.style.display = 'flex';
        confirmInput.focus();
    }
});
</script>
@endpush
@endsection
