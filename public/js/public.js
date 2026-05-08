// ===== NAVBAR SCROLL =====
const navbar = document.getElementById('navbar');

function updateNavbar() {
    if (window.location.pathname === '/' && window.scrollY <= 60) {
        navbar.classList.remove('scrolled');
    } else {
        navbar.classList.add('scrolled');
    }
}

window.addEventListener('pageshow', () => {
    // Reset inline style yang mungkin tersisa dari hamburger
    navLinks.style.cssText = '';
    menuOpen = false;
    updateNavbar();
});
window.addEventListener('scroll', updateNavbar);
updateNavbar();

// ===== SCROLL REVEAL =====
const reveals = document.querySelectorAll('.reveal, .feature-item, .bento-item');
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            setTimeout(() => entry.target.classList.add('visible'), i * 80);
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.1 });
reveals.forEach(el => observer.observe(el));

// ===== HAMBURGER MOBILE =====
const hamburger = document.getElementById('hamburger');
const navLinks  = document.querySelector('.nav-links');
let menuOpen    = false;

hamburger.addEventListener('click', () => {
    menuOpen = !menuOpen;
    if (menuOpen) {
        navLinks.style.cssText = `
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 60px;
            left: 0;
            right: 0;
            background: rgba(13,31,45,0.85);
            backdrop-filter: blur(12px);
            padding: 24px;
            gap: 8px;
            z-index: 999;
            overflow-y: auto;
        `;
    } else {
        navLinks.style.cssText = '';
        menuOpen = false;
    }
});

// Tutup saat klik link
navLinks.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
        menuOpen = false;
        navLinks.style.cssText = '';
    });
});

// Reset saat resize ke desktop
window.addEventListener('resize', () => {
    if (window.innerWidth > 1080) {
        menuOpen = false;
        navLinks.style.cssText = '';
    }
});

// Tutup saat klik link (kecuali user menu btn)
navLinks.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
        menuOpen = false;
        navLinks.style.cssText = '';
        navLinks.querySelectorAll('li').forEach(li => li.style.cssText = '');
    });
});

// ===== USER DROPDOWN =====
const userMenuBtn = document.getElementById('userMenuBtn');
const userMenuDropdown = document.getElementById('userMenuDropdown');

if (userMenuBtn) {
    userMenuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        userMenuDropdown.classList.toggle('open');
    });

    document.addEventListener('click', () => {
        userMenuDropdown.classList.remove('open');
    });

    // ===== SESSION TIMEOUT =====
    const SESSION_TIMEOUT = 30 * 60 * 1000; // 30 menit
    const WARNING_BEFORE  = 2 * 60 * 1000;  // warning 2 menit sebelum

    let timeoutTimer, warningTimer;

    function resetTimers() {
        clearTimeout(timeoutTimer);
        clearTimeout(warningTimer);

        warningTimer = setTimeout(() => {
            const lanjut = confirm('Sesi kamu akan berakhir dalam 2 menit. Tetap di halaman ini?');
            if (lanjut) resetTimers();
        }, SESSION_TIMEOUT - WARNING_BEFORE);

        timeoutTimer = setTimeout(() => {
            alert('Sesi kamu telah berakhir. Kamu akan diarahkan ke halaman login.');
            window.location.href = '/logout-session';
        }, SESSION_TIMEOUT);
    }

    if (document.getElementById('userMenuBtn')) {
        ['click', 'keydown', 'mousemove', 'scroll', 'touchstart'].forEach(event => {
            document.addEventListener(event, resetTimers, { passive: true });
        });
        resetTimers();
    }
}

// HERO CAROUSEL
(function () {
    const slides  = document.querySelectorAll('.hero-slide');
    const texts   = document.querySelectorAll('.hero-text');
    const dots    = document.querySelectorAll('.hero-dot');
    if (!slides.length || slides.length === 1) return;

    let current = 0;
    let timer;

    function goTo(n) {
        slides[current].classList.remove('active');
        texts[current].classList.remove('active');
        dots[current]?.classList.remove('active');
        current = (n + slides.length) % slides.length;
        slides[current].classList.add('active');
        texts[current].classList.add('active');
        dots[current]?.classList.add('active');
    }

    function next() { goTo(current + 1); }
    function startTimer() { timer = setInterval(next, 5000); }
    function resetTimer() { clearInterval(timer); startTimer(); }

    document.getElementById('heroNext')?.addEventListener('click', () => { next(); resetTimer(); });
    document.getElementById('heroPrev')?.addEventListener('click', () => { goTo(current - 1); resetTimer(); });
    dots.forEach((dot, i) => dot.addEventListener('click', () => { goTo(i); resetTimer(); }));

    startTimer();
})();
