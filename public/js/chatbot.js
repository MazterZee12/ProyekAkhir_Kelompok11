// ===== CHATBOT WIDGET =====
const chatToggle  = document.getElementById('chatToggle');
const chatPopup   = document.getElementById('chatPopup');
const chatClose   = document.getElementById('chatClose');
const chatInput   = document.getElementById('chatInput');
const chatSend    = document.getElementById('chatSend');
const chatMessages = document.getElementById('chatMessages');
const chatTyping  = document.getElementById('chatTyping');
const chatBadge   = document.getElementById('chatBadge');
const quickReplies = document.getElementById('quickReplies');

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
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function hideTyping() {
    chatTyping.classList.remove('show');
}

async function sendMessage(text) {
    if (!text.trim()) return;

    addMessage(text, true);
    chatInput.value = '';
    chatSend.disabled = true;
    showTyping();

    try {
        const response = await fetch('/chatbot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ message: text })
        });

        const data = await response.json();
        hideTyping();
        addMessage(data.reply || 'Maaf, tidak ada respons.');
    } catch (err) {
        hideTyping();
        addMessage('Maaf, terjadi kesalahan koneksi. Coba lagi ya! 🙏');
    }
}
