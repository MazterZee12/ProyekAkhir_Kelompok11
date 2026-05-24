// ===== CHATBOT WIDGET =====
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
let isOpen = false;

// Toggle open/close
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

// Enable/disable send button
chatInput.addEventListener('input', () => {
    chatSend.disabled = chatInput.value.trim() === '';
});

// Send on Enter
chatInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' && !e.shiftKey && chatInput.value.trim()) {
        e.preventDefault();
        sendMessage(chatInput.value.trim());
    }
});
chatSend.addEventListener('click', () => {
    if (chatInput.value.trim()) sendMessage(chatInput.value.trim());
});

// Quick reply buttons
document.querySelectorAll('.chat-quick-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        sendMessage(btn.dataset.msg);
        quickReplies.style.display = 'none';
    });
});

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

window.addEventListener('offline', () => {
    setStatus('offline', 'Tidak ada koneksi');
});
window.addEventListener('online', () => {
    checkAiStatus();
});

function addMessage(text, isUser = false) {
    const msg = document.createElement('div');
    msg.className = `chat-msg ${isUser ? 'chat-msg-user' : 'chat-msg-bot'}`;
    if (!isUser) {
        msg.innerHTML = `
            <div class="chat-msg-avatar"><i class="fas fa-umbrella-beach"></i></div>
            <div class="chat-msg-bubble">${text}</div>
        `;
    } else {
        msg.innerHTML = `<div class="chat-msg-bubble">${text}</div>`;
    }
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

async function sendMessage(text) {
    if (!text.trim()) return;
    addMessage(text, true);
    chatInput.value = '';
    chatSend.disabled = true;
    showTyping();

    // Cek koneksi browser dulu
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
            const timeout = setTimeout(() => controller.abort(), 15000);

            const response = await fetch('/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ message: text }),
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
                if (err.name === 'AbortError') {
                    addMessage('⏱️ Koneksi terlalu lama. Coba lagi nanti ya!');
                } else {
                    addMessage('❌ Gagal terhubung ke server. Pastikan internet kamu stabil.');
                }
                chatSend.disabled = false;
            } else {
                // Tunggu sebelum retry (1 detik, 2 detik)
                await new Promise(r => setTimeout(r, attempt * 1000));
            }
        }
    }
}
