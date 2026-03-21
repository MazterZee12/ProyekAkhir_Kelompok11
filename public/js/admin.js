// ===== SIDEBAR TOGGLE =====
const sidebar   = document.getElementById('sidebar');
const toggleBtn = document.getElementById('toggleSidebar');

toggleBtn.addEventListener('click', function () {
    if (window.innerWidth < 992) {
        sidebar.classList.toggle('show');
    } else {
        sidebar.classList.toggle('collapsed');
    }
});

// ===== THEME SWITCHER =====
function setTheme(theme) {
    document.body.classList.remove(
        'theme-purple','theme-ocean','theme-forest',
        'theme-black','theme-rose','theme-amber','theme-slate',
        'theme-yellow','theme-cyan','theme-lime','theme-pink'
    );
    document.body.classList.add('theme-' + theme);
    localStorage.setItem('admin-theme', theme);
}

// ===== LOAD SAVED THEME =====
window.addEventListener('DOMContentLoaded', () => {
    const saved = localStorage.getItem('admin-theme');
    if (saved) setTheme(saved);
});

// ===== AUTO HIDE ALERT =====
window.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            alert.classList.remove('show');
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 300);
        });
    }, 3000);
});

// ===== CONFIRM DELETE =====
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', function (e) {
            if (!confirm(this.dataset.confirm)) {
                e.preventDefault();
            }
        });
    });
});

// ===== THEME PALETTE TOGGLE =====
const themeToggle  = document.getElementById('themeToggle');
const themePalette = document.getElementById('themePalette');

themeToggle.addEventListener('click', function (e) {
    e.stopPropagation();
    themePalette.classList.toggle('show');
});

document.addEventListener('click', function () {
    themePalette.classList.remove('show');
});

themePalette.addEventListener('click', function (e) {
    e.stopPropagation();
});
