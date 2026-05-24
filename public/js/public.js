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

navLinks.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
        menuOpen = false;
        navLinks.style.cssText = '';
        navLinks.querySelectorAll('li').forEach(li => li.style.cssText = '');
    });
});

// ===== USER DROPDOWN =====
const userMenuBtn      = document.getElementById('userMenuBtn');
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
    const SESSION_TIMEOUT = 30 * 60 * 1000;
    const WARNING_BEFORE  = 2 * 60 * 1000;

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

// ===== HERO CAROUSEL =====
(function () {
    const slides = document.querySelectorAll('.hero-slide');
    const texts  = document.querySelectorAll('.hero-text');
    const dots   = document.querySelectorAll('.hero-dot');
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

// ===== CHATBOT WIDGET =====
(function () {
    const chatToggle   = document.getElementById('chatToggle');
    const chatPopup    = document.getElementById('chatPopup');
    const chatClose    = document.getElementById('chatClose');
    const chatInput    = document.getElementById('chatInput');
    const chatSend     = document.getElementById('chatSend');
    const chatMessages = document.getElementById('chatMessages');
    const chatTyping   = document.getElementById('chatTyping');
    const chatBadge    = document.getElementById('chatBadge');
    const quickReplies = document.getElementById('quickReplies');
    const statusText   = document.querySelector('.chat-header-status');

    if (!chatToggle) return; // Guard: kalau widget tidak ada di halaman ini, skip
    let isOpen = false;

    // ── Toggle open/close ─────────────────────────────────────────
    function toggleChat() {
        isOpen = !isOpen;
        chatToggle.classList.toggle('open', isOpen);
        chatPopup.classList.toggle('open', isOpen);
        if (isOpen) {
            chatBadge.classList.add('hidden');
            chatInput.focus();
        }
    }
    chatToggle.addEventListener('click', toggleChat);
    chatClose.addEventListener('click', toggleChat);

    // ── Enable/disable send button ────────────────────────────────
    chatInput.addEventListener('input', () => {
        chatSend.disabled = chatInput.value.trim() === '';
    });

    chatInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey && chatInput.value.trim()) {
            e.preventDefault();
            sendMessage(chatInput.value.trim());
        }
    });

    chatSend.addEventListener('click', () => {
        if (chatInput.value.trim()) sendMessage(chatInput.value.trim());
    });

    // ── Quick reply buttons ───────────────────────────────────────
    document.querySelectorAll('.chat-quick-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            sendMessage(btn.dataset.msg);
            quickReplies.style.display = 'none';
        });
    });

    // ── Status AI ─────────────────────────────────────────────────
    function setStatus(state, label = '') {
        const dots = {
            online  : '<span class="chat-status-dot"></span>',
            typing  : '<span class="chat-status-dot typing"></span>',
            offline : '<span class="chat-status-dot offline"></span>',
        };
        const labels = {
            online  : label || 'Online sekarang',
            typing  : 'Sedang mengetik...',
            offline : label || 'Sedang tidak tersedia',
        };
        statusText.innerHTML = `${dots[state]} ${labels[state]}`;
    }

    async function checkAiStatus() {
        try {
            const res  = await fetch('/chatbot/status');
            const data = await res.json();
            setStatus(data.online ? 'online' : 'offline', data.label);
        } catch {
            setStatus('offline', 'Koneksi bermasalah');
        }
    }
    checkAiStatus();
    setInterval(checkAiStatus, 30_000);

    // ── Deteksi koneksi realtime ──────────────────────────────────
    window.addEventListener('offline', () => setStatus('offline', 'Tidak ada koneksi'));
    window.addEventListener('online',  () => checkAiStatus());

    // ── Append pesan ──────────────────────────────────────────────
    function addMessage(text, isUser = false) {
        const msg = document.createElement('div');
        msg.className = `chat-msg ${isUser ? 'chat-msg-user' : 'chat-msg-bot'}`;
        msg.innerHTML = isUser
            ? `<div class="chat-msg-bubble">${text}</div>`
            : `<div class="chat-msg-avatar"><i class="fas fa-umbrella-beach"></i></div>
               <div class="chat-msg-bubble">${text}</div>`;
        chatMessages.appendChild(msg);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function showTyping() {
        chatTyping.classList.add('show');
        setStatus('typing');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function hideTyping() {
        chatTyping.classList.remove('show');
        setStatus('online');
    }

    // ── Kirim pesan ───────────────────────────────────────────────
    async function sendMessage(text) {
        if (!text.trim()) return;
        addMessage(text, true);
        chatInput.value  = '';
        chatSend.disabled = true;
        showTyping();

        // Cek CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!csrfToken) {
            hideTyping();
            addMessage('⚠️ Konfigurasi halaman bermasalah. Coba refresh dulu ya!');
            chatSend.disabled = false;
            return;
        }

        // Cek koneksi browser
        if (!navigator.onLine) {
            hideTyping();
            addMessage('⚠️ Tidak ada koneksi internet. Periksa jaringan kamu ya!');
            chatSend.disabled = false;
            return;
        }

        const MAX_RETRY = 2;
        let attempt = 0;

        while (attempt <= MAX_RETRY) {
            try {
                const controller = new AbortController();
                const timeout    = setTimeout(() => controller.abort(), 15000);

                const response = await fetch('/chatbot', {
                    method : 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body  : JSON.stringify({ message: text }),
                    signal: controller.signal,
                });

                clearTimeout(timeout);
                const data = await response.json();
                hideTyping();
                addMessage(data.reply || 'Maaf, tidak ada respons.');
                return;

            } catch (err) {
                attempt++;
                if (attempt > MAX_RETRY) {
                    hideTyping();
                    addMessage(err.name === 'AbortError'
                        ? '⏱️ Koneksi terlalu lama. Coba lagi nanti ya!'
                        : '❌ Gagal terhubung ke server. Pastikan internet kamu stabil.');
                    chatSend.disabled = false;
                } else {
                    await new Promise(r => setTimeout(r, attempt * 1000));
                }
            }
        }
    }
})();
