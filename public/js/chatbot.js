// ===================================================
// chatbot.js — Pasir Putih Parparean
// ===================================================

const chatToggle   = document.getElementById('chatToggle');
const chatPopup    = document.getElementById('chatPopup');
const chatClose    = document.getElementById('chatClose');
const chatInput    = document.getElementById('chatInput');
const chatSend     = document.getElementById('chatSend');
const chatMessages = document.getElementById('chatMessages');
const chatTyping   = document.getElementById('chatTyping');
const chatBadge    = document.getElementById('chatBadge');
const quickReplies = document.getElementById('quickReplies');
const statusEl     = document.querySelector('.chat-header-status');

let isOpen = false;

// ── Open / Close ──
function toggleChat() {
    isOpen = !isOpen;
    chatToggle.classList.toggle('open', isOpen);
    chatPopup.classList.toggle('open', isOpen);
    if (isOpen) {
        chatBadge.classList.add('hidden');
        chatInput.focus();
        scrollBottom();
    }
}
chatToggle.addEventListener('click', toggleChat);
chatClose.addEventListener('click', toggleChat);

// Close on outside click
document.addEventListener('click', e => {
    if (isOpen && !document.getElementById('chatWidget').contains(e.target)) {
        toggleChat();
    }
});

// ── Input ──
chatInput.addEventListener('input', () => {
    chatSend.disabled = chatInput.value.trim() === '';
});
chatInput.addEventListener('keydown', e => {
    if (e.key === 'Enter' && !e.shiftKey && chatInput.value.trim()) {
        e.preventDefault();
        sendMessage(chatInput.value.trim());
    }
});
chatSend.addEventListener('click', () => {
    if (chatInput.value.trim()) sendMessage(chatInput.value.trim());
});

// ── Quick Replies ──
document.querySelectorAll('.chat-quick-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        sendMessage(btn.dataset.msg);
        quickReplies.style.display = 'none';
    });
});

// ── Status ──
function setStatus(state, label = '') {
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
    statusEl.innerHTML =
        `<span class="${dotClass[state]}"></span>${text[state]}`;
}

async function checkAiStatus() {
    try {
        const res  = await fetch('/chatbot/status');
        const data = await res.json();
        setStatus(data.online ? 'online' : 'offline', data.label ?? '');
    } catch {
        setStatus('offline', 'Koneksi bermasalah');
    }
}
checkAiStatus();
setInterval(checkAiStatus, 30_000);

window.addEventListener('offline', () => setStatus('offline', 'Tidak ada koneksi'));
window.addEventListener('online',  () => checkAiStatus());

// ── Messages ──
function escHtml(str) {
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/\n/g, '<br>');
}

function scrollBottom() {
    setTimeout(() => { chatMessages.scrollTop = chatMessages.scrollHeight; }, 40);
}

function addMessage(text, isUser = false) {
    const msg = document.createElement('div');
    msg.className = `chat-msg ${isUser ? 'chat-msg-user' : 'chat-msg-bot'}`;
    msg.innerHTML = isUser
        ? `<div class="chat-msg-bubble">${escHtml(text)}</div>`
        : `<div class="chat-msg-avatar"><i class="fas fa-umbrella-beach"></i></div>
           <div class="chat-msg-bubble">${text}</div>`;
    chatMessages.appendChild(msg);
    scrollBottom();
}

function showTyping() {
    chatTyping.classList.add('show');
    setStatus('typing');
    scrollBottom();
}
function hideTyping() {
    chatTyping.classList.remove('show');
    setStatus('online');
}

// ── Send ──
async function sendMessage(text) {
    if (!text.trim()) return;

    addMessage(text, true);
    chatInput.value   = '';
    chatSend.disabled = true;
    showTyping();

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
            const timeout    = setTimeout(() => controller.abort(), 15_000);

            const res = await fetch('/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept':       'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body:   JSON.stringify({ message: text }),
                signal: controller.signal,
            });

            clearTimeout(timeout);
            const data = await res.json();
            hideTyping();
            addMessage(data.reply || 'Maaf, tidak ada respons.');
            chatSend.disabled = false;
            return;

        } catch (err) {
            attempt++;
            if (attempt > MAX_RETRY) {
                hideTyping();
                addMessage(
                    err.name === 'AbortError'
                        ? '⏱️ Koneksi terlalu lama. Coba lagi nanti ya!'
                        : '❌ Gagal terhubung ke server. Pastikan internet kamu stabil.'
                );
                chatSend.disabled = false;
            } else {
                await new Promise(r => setTimeout(r, attempt * 1000));
            }
        }
    }
}
