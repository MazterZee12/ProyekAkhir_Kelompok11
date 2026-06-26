// ===== SIDEBAR TOGGLE =====
const sidebar   = document.getElementById('sidebar');
const toggleBtn = document.getElementById('toggleSidebar');

if (sidebar && toggleBtn) {
    toggleBtn.addEventListener('click', function () {
        if (window.innerWidth < 992) {
            sidebar.classList.toggle('show');
        } else {
            sidebar.classList.toggle('collapsed');
        }
    });
}

// ===== THEME SWITCHER =====
function setTheme(theme) {
    document.body.classList.remove(
        'theme-purple', 'theme-ocean',  'theme-forest',
        'theme-black',  'theme-rose',   'theme-amber',
        'theme-slate',  'theme-yellow', 'theme-cyan',
        'theme-lime',   'theme-pink'
    );
    document.body.classList.add('theme-' + theme);

    try {
        localStorage.setItem('admin-theme', theme);
    } catch {
        // Safari private mode — tema aktif tapi tidak tersimpan
    }
}

// ===== LOAD SAVED THEME =====
window.addEventListener('DOMContentLoaded', () => {
    try {
        const saved = localStorage.getItem('admin-theme');
        if (saved) setTheme(saved);
    } catch {
        // localStorage tidak tersedia — pakai tema default
    }
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

if (themeToggle && themePalette) {
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
}

// ===== INFORMATION REQUEST: search auto-submit (debounced) =====
(function () {
    const searchInput = document.getElementById('irSearchInput');
    if (!searchInput) return;

    let debounceTimer;
    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => this.form.submit(), 500);
    });
})();

// ===== INFORMATION REQUEST: status select =====
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.ir-status-select').forEach(select => {
        select.addEventListener('change', function () {
            const label = this.options[this.selectedIndex].text;
            if (confirm('Ubah status permintaan menjadi "' + label + '"?')) {
                this.form.submit();
            } else {
                this.value = this.dataset.current;
            }
        });
    });
});
