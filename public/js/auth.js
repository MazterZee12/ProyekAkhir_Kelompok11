// ===== TOGGLE PASSWORD =====
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

// ===== LOADING STATE ON SUBMIT =====
const loginBtn  = document.getElementById('loginBtn');
const loginForm = document.querySelector('.login-form');

if (loginForm && loginBtn) {
    loginForm.addEventListener('submit', () => {
        loginBtn.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2"
                style="animation: spin 0.8s linear infinite; flex-shrink:0">
                <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" opacity="0.3"/>
                <path d="M21 12a9 9 0 0 0-9-9"/>
            </svg>
            Memverifikasi...
        `;
        loginBtn.disabled = true;
    });
}
