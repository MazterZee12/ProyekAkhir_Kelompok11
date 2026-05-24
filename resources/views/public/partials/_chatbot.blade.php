{{-- CHATBOT WIDGET --}}
<div class="chat-widget" id="chatWidget">

    {{-- Toggle Button --}}
    <button class="chat-toggle" id="chatToggle" aria-label="Buka Chat">
        <i class="fas fa-comments chat-icon-open"></i>
        <i class="fas fa-times chat-icon-close"></i>
        <span class="chat-badge" id="chatBadge">1</span>
    </button>

    {{-- Chat Popup --}}
    <div class="chat-popup" id="chatPopup">

        {{-- Header --}}
        <div class="chat-header">
            <div class="chat-header-avatar">
                <i class="fas fa-umbrella-beach"></i>
            </div>
            <div class="chat-header-info">
                <div class="chat-header-name">Asisten Pantai</div>
                <div class="chat-header-status">
                    <span class="chat-status-dot"></span>
                    Online sekarang
                </div>
            </div>
            <button class="chat-header-close" id="chatClose">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Messages --}}
        <div class="chat-messages" id="chatMessages">
            <div class="chat-msg chat-msg-bot">
                <div class="chat-msg-avatar"><i class="fas fa-umbrella-beach"></i></div>
                <div class="chat-msg-bubble">
                    Halo! 👋 Selamat datang di Pasir Putih Parparean.<br>
                    Ada yang bisa saya bantu? Tanyakan tentang harga tiket, fasilitas, jadwal, atau info lainnya!
                    <br><br>
                    Hello! Welcome to Pasir Putih Parparean. How can I help you today?
                </div>
            </div>

            {{-- Quick replies --}}
            <div class="chat-quick-replies" id="quickReplies">
                <button class="chat-quick-btn" data-msg="Berapa harga tiket masuk?">🎫 Harga Tiket</button>
                <button class="chat-quick-btn" data-msg="Apa saja fasilitas yang tersedia?">🏖️ Fasilitas</button>
                <button class="chat-quick-btn" data-msg="Jam buka dan tutup pantai?">🕐 Jam Buka</button>
                <button class="chat-quick-btn" data-msg="Bagaimana cara menuju ke sana?">📍 Lokasi</button>
            </div>
        </div>

        {{-- Typing indicator --}}
        <div class="chat-typing" id="chatTyping">
            <div class="chat-msg-avatar"><i class="fas fa-umbrella-beach"></i></div>
            <div class="chat-typing-dots">
                <span></span><span></span><span></span>
            </div>
        </div>

        {{-- Input --}}
        <div class="chat-input-area">
            <div class="chat-input-wrap">
                <input type="text" id="chatInput"
                    placeholder="Ketik pesan... / Type a message..."
                    maxlength="500" autocomplete="off">
                <button class="chat-send" id="chatSend" disabled>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <div class="chat-footer-note">
                Powered by AI · Pasir Putih Parparean
            </div>
        </div>

    </div>
</div>
