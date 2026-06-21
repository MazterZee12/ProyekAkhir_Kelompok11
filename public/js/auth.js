/* ============================================================
   auth.js — Pasir Putih Parparean
   ============================================================ */

// ── Login: toggle password + loading state ──────────────────
(function () {
    const toggleBtn     = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon       = document.getElementById('eyeIcon');

    if (toggleBtn && passwordInput && eyeIcon) {
        toggleBtn.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.className  = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    }

    const loginBtn  = document.getElementById('loginBtn');
    const loginForm = document.getElementById('loginForm');

    if (loginForm && loginBtn) {
        loginForm.addEventListener('submit', () => {
            loginBtn.innerHTML = `
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2"
                    style="animation:spin 0.8s linear infinite;flex-shrink:0">
                    <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" opacity="0.3"/>
                    <path d="M21 12a9 9 0 0 0-9-9"/>
                </svg>
                Memverifikasi...
            `;
            loginBtn.disabled = true;
        });
    }
})();

// ── Register: toggle password + strength + match ────────────
(function () {
    // Hanya jalan jika ada form register
    if (!document.getElementById('registerForm')) return;

    function setupToggle(btnId, inputId, iconId) {
        const btn   = document.getElementById(btnId);
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (!btn || !input || !icon) return;

        btn.addEventListener('click', () => {
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            icon.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    }

    setupToggle('togglePassword', 'password', 'eyeIcon');
    setupToggle('toggleConfirm', 'password_confirmation', 'eyeIconConfirm');

    const pwInput       = document.getElementById('password');
    const strengthFill  = document.getElementById('pwStrengthFill');
    const strengthLabel = document.getElementById('pwStrengthLabel');
    const strengthWrap  = document.getElementById('pwStrengthWrap');

    if (pwInput && strengthFill && strengthLabel && strengthWrap) {
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
    }

    const confirmInput = document.getElementById('password_confirmation');
    const matchError   = document.getElementById('matchError');
    const registerForm = document.getElementById('registerForm');

    if (pwInput && confirmInput && matchError) {
        function checkMatch() {
            if (!confirmInput.value.length) {
                matchError.style.display = 'none';
                return;
            }
            matchError.style.display = pwInput.value !== confirmInput.value ? 'flex' : 'none';
        }

        confirmInput.addEventListener('input', checkMatch);
        pwInput.addEventListener('input', checkMatch);

        if (registerForm) {
            registerForm.addEventListener('submit', function (e) {
                if (pwInput.value !== confirmInput.value) {
                    e.preventDefault();
                    matchError.style.display = 'flex';
                    confirmInput.focus();
                }
            });
        }
    }
})();

// ── Forgot Password: loading state ──────────────────────────
(function () {
    const forgotBtn  = document.getElementById('forgotBtn');
    const forgotForm = document.getElementById('forgotForm');

    if (forgotForm && forgotBtn) {
        forgotForm.addEventListener('submit', () => {
            forgotBtn.innerHTML = `
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2"
                    style="animation:spin 0.8s linear infinite;flex-shrink:0">
                    <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" opacity="0.3"/>
                    <path d="M21 12a9 9 0 0 0-9-9"/>
                </svg>
                Memproses...
            `;
            forgotBtn.disabled = true;
        });
    }
})();

// ── Change Password: toggle + strength + match ──────────────
(function () {
    // Hanya jalan jika ada form change password
    if (!document.getElementById('changePasswordForm')) return;

    function setupToggle(btnId, inputId, iconId) {
        const btn   = document.getElementById(btnId);
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (!btn || !input || !icon) return;

        btn.addEventListener('click', () => {
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            icon.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    }

    // Semua 3 toggle di change password
    setupToggle('toggleCurrent',  'current_password',     'eyeIconCurrent');
    setupToggle('togglePassword', 'password',              'eyeIcon');
    setupToggle('toggleConfirm',  'password_confirmation', 'eyeIconConfirm');

    // Password strength
    const pwInput       = document.getElementById('password');
    const strengthFill  = document.getElementById('pwStrengthFill');
    const strengthLabel = document.getElementById('pwStrengthLabel');
    const strengthWrap  = document.getElementById('pwStrengthWrap');

    if (pwInput && strengthFill && strengthLabel && strengthWrap) {
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
    }

    // Password match check
    const confirmInput = document.getElementById('password_confirmation');
    const matchError   = document.getElementById('matchError');
    const changeForm   = document.getElementById('changePasswordForm');

    if (pwInput && confirmInput && matchError) {
        function checkMatch() {
            if (!confirmInput.value.length) {
                matchError.style.display = 'none';
                return;
            }
            matchError.style.display = pwInput.value !== confirmInput.value ? 'flex' : 'none';
        }

        confirmInput.addEventListener('input', checkMatch);
        pwInput.addEventListener('input', checkMatch);
    }

    if (changeForm) {
        changeForm.addEventListener('submit', function (e) {
            const pw      = document.getElementById('password');
            const confirm = document.getElementById('password_confirmation');
            const err     = document.getElementById('matchError');

            if (pw && confirm && pw.value !== confirm.value) {
                e.preventDefault();
                if (err) err.style.display = 'flex';
                confirm.focus();
            }
        });
    }
})();
