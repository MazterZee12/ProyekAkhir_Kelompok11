/* ============================================================
   public.js — Pasir Putih Parparean
   ============================================================ */

// ── Navbar scroll ──────────────────────────────────────────
const navbar = document.getElementById('navbar');

function updateNavbar() {
    if (window.location.pathname === '/' && window.scrollY <= 60) {
        navbar.classList.remove('scrolled');
    } else {
        navbar.classList.add('scrolled');
    }
}

window.addEventListener('scroll', updateNavbar, { passive: true });
window.addEventListener('pageshow', () => {
    menuOpen = false;
    if (navLinks) navLinks.style.cssText = '';
    updateNavbar();
});
updateNavbar();

// ── Scroll reveal ──────────────────────────────────────────
const reveals = document.querySelectorAll('.reveal, .feature-item, .bento-item');
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            setTimeout(() => entry.target.classList.add('visible'), i * 70);
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.08 });

reveals.forEach(el => revealObserver.observe(el));

// ── Hamburger ──────────────────────────────────────────────
const hamburger = document.getElementById('hamburger');
const navLinks  = document.querySelector('.nav-links');
let menuOpen    = false;

if (hamburger && navLinks) {
    hamburger.addEventListener('click', () => {
        menuOpen = !menuOpen;
        navLinks.style.cssText = menuOpen ? `
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 64px;
            left: 0;
            right: 0;
            background: rgba(6, 13, 24, 0.97);
            backdrop-filter: blur(20px);
            padding: 20px 24px;
            gap: 4px;
            z-index: 99;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        ` : '';
    });

    navLinks.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            menuOpen = false;
            navLinks.style.cssText = '';
        });
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 1080) {
            menuOpen = false;
            navLinks.style.cssText = '';
        }
    });
}

// ── User dropdown ──────────────────────────────────────────
const userMenuBtn      = document.getElementById('userMenuBtn');
const userMenuDropdown = document.getElementById('userMenuDropdown');

if (userMenuBtn && userMenuDropdown) {
    userMenuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        userMenuDropdown.classList.toggle('open');
    });

    document.addEventListener('click', () => {
        userMenuDropdown.classList.remove('open');
    });

    // ── Session timeout (30 min) ──────────────────────────
    const SESSION_TIMEOUT = 30 * 60 * 1000;
    const WARNING_BEFORE  = 2  * 60 * 1000;
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

    ['click', 'keydown', 'mousemove', 'scroll', 'touchstart'].forEach(event => {
        document.addEventListener(event, resetTimers, { passive: true });
    });

    resetTimers();
}

// ── Hero carousel ──────────────────────────────────────────
(function () {
    const slides = document.querySelectorAll('.hero-slide');
    const texts  = document.querySelectorAll('.hero-text');
    const dots   = document.querySelectorAll('.hero-dot');
    if (!slides.length || slides.length === 1) return;

    let current = 0;
    let timer;

    function goTo(n) {
        slides[current].classList.remove('active');
        texts[current]?.classList.remove('active');
        dots[current]?.classList.remove('active');
        current = (n + slides.length) % slides.length;
        slides[current].classList.add('active');
        texts[current]?.classList.add('active');
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

// ── FAQ accordion ──────────────────────────────────────────
function toggleFaq(el) {
    const isOpen = el.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach(item => item.classList.remove('open'));
    if (!isOpen) el.classList.add('open');
}

// ── Gallery lightbox ───────────────────────────────────────
function openLightbox(src, title) {
    const lb  = document.getElementById('lightbox');
    const img = document.getElementById('lightbox-img');
    const cap = document.getElementById('lightbox-caption');
    if (!lb || !img) return;

    img.src                      = src;
    img.style.display            = 'block';
    cap.textContent              = title || '';
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    const lb = document.getElementById('lightbox');
    if (!lb) return;
    lb.classList.remove('open');
    document.body.style.overflow = '';
}

// Tombol close lightbox
document.getElementById('lightboxClose')?.addEventListener('click', closeLightbox);

// Klik backdrop lightbox
document.getElementById('lightbox')?.addEventListener('click', function (e) {
    if (e.target === this) closeLightbox();
});

// ── Alert auto-dismiss ─────────────────────────────────────
document.querySelectorAll('.js-alert').forEach(el => {
    setTimeout(() => {
        el.style.transition = 'opacity 0.5s';
        el.style.opacity    = '0';
        setTimeout(() => el.remove(), 500);
    }, 4000);
});

// ── Information Request: character counter ─────────────────
function irInitCharCounter(textareaId, counterId, minLength = 10) {
    const textarea = document.getElementById(textareaId);
    const counter  = document.getElementById(counterId);
    if (!textarea || !counter) return;

    function update() {
        const len = textarea.value.trim().length;
        counter.textContent = len + ' karakter' + (len < minLength ? ' (minimal ' + minLength + ')' : '');
        counter.style.color = len < minLength ? '#EF4444' : '#94a3b8';
    }

    textarea.addEventListener('input', update);
    update();
}

// ── Information Request: confirm delete ────────────────────
function irConfirmDelete(message) {
    return confirm(message || 'Yakin ingin menghapus permintaan ini?');
}

// ── Chatbot status check ───────────────────────────────────
const statusEl = document.querySelector('.chat-header-status');

function setStatus(state, label = '') {
    if (!statusEl) return;
    const dotClass = {
        online  : 'chat-status-dot',
        typing  : 'chat-status-dot typing',
        offline : 'chat-status-dot offline',
    };
    const text = {
        online  : label || 'Online sekarang',
        typing  : 'Sedang mengetik...',
        offline : label || 'Sedang tidak tersedia',
    };
    statusEl.innerHTML = `<span class="${dotClass[state]}"></span>${text[state]}`;
}

async function checkAiStatus() {
    try {
        const res = await fetch('/chatbot/status');

        if (!res.ok) {
            setStatus('offline', 'Server bermasalah');
            return;
        }

        const data = await res.json();
        setStatus(data.online ? 'online' : 'offline', data.label ?? '');

    } catch {
        setStatus('offline', 'Koneksi bermasalah');
    }
}

if (statusEl) {
    checkAiStatus();
    setInterval(checkAiStatus, 30_000);
    window.addEventListener('offline', () => setStatus('offline', 'Tidak ada koneksi'));
    window.addEventListener('online',  () => checkAiStatus());
}

// ── Keyboard: Escape tutup semua overlay ───────────────────
document.addEventListener('keydown', e => {
    if (e.key !== 'Escape') return;

    // Lightbox
    const lb = document.getElementById('lightbox');
    if (lb?.classList.contains('open')) {
        closeLightbox();
        return;
    }

    // Detail modal
    const modal = document.getElementById('detailModal');
    if (modal?.classList.contains('open')) {
        modal.classList.remove('open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }
});

// ── Universal detail modal ─────────────────────────────────
(function () {
    const modal = document.getElementById('detailModal');
    if (!modal) return;

    const modalImage       = document.getElementById('detailModalImage');
    const modalBadge       = document.getElementById('detailModalBadge');
    const modalTitle       = document.getElementById('detailModalTitle');
    const modalMeta        = document.getElementById('detailModalMeta');
    const modalDescription = document.getElementById('detailModalDescription');
    const closeTargets     = modal.querySelectorAll('[data-close-modal]');

    function openModal(data) {
        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        modalBadge.textContent       = data.badge || '';
        modalTitle.textContent       = data.title || '';
        modalMeta.textContent        = data.meta  || '';
        modalDescription.textContent = data.description || '';

        if (data.image) {
            modalImage.src           = data.image;
            modalImage.style.display = 'block';
            modalImage.alt           = data.title || '';
        } else {
            modalImage.removeAttribute('src');
            modalImage.style.display = 'none';
        }
    }

    function closeModal() {
        modal.classList.remove('open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.addEventListener('click', (e) => {
        const card = e.target.closest('.js-detail-card');
        if (!card) return;
        e.preventDefault();

        // Galeri → lightbox
        if (card.dataset.detailType === 'gallery' && card.dataset.image) {
            openLightbox(card.dataset.image, card.dataset.title);
            return;
        }

        // Lainnya → detail modal
        openModal({
            badge      : card.dataset.badge,
            title      : card.dataset.title,
            meta       : card.dataset.meta,
            description: card.dataset.description,
            image      : card.dataset.image,
        });
    });

    closeTargets.forEach(btn => btn.addEventListener('click', closeModal));
})();
