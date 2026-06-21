<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pasir Putih Parparean')</title>
    <meta name="description" content="@yield('description', 'Destinasi wisata pantai terbaik di kawasan Danau Toba, Sumatera Utara.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Figtree:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/public.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">
    @stack('styles')
</head>
<body>

<nav id="navbar">
    <a href="{{ url('/') }}" class="nav-logo">Pasir Putih <span>Parparean</span></a>
    <ul class="nav-links">
        <li><a href="{{ url('/about') }}">Tentang</a></li>
        <li class="nav-dropdown-wrap">
            <button class="nav-dropdown-trigger">Jelajahi <i class="fas fa-chevron-down"></i></button>
            <div class="nav-dropdown-menu">
                <a href="{{ url('/gallery') }}"><i class="fas fa-images"></i> Galeri</a>
                <a href="{{ url('/facilities') }}"><i class="fas fa-umbrella-beach"></i> Fasilitas</a>
                <a href="{{ url('/pricing') }}"><i class="fas fa-ticket-alt"></i> Harga Tiket</a>
                <a href="{{ route('information-requests.index') }}"><i class="fas fa-circle-info"></i> Permintaan Informasi</a>
            </div>
        </li>
        <li class="nav-dropdown-wrap">
            <button class="nav-dropdown-trigger">Info <i class="fas fa-chevron-down"></i></button>
            <div class="nav-dropdown-menu">
                <a href="{{ url('/announcements') }}"><i class="fas fa-bullhorn"></i> Pengumuman</a>
                <a href="{{ url('/faq') }}"><i class="fas fa-question-circle"></i> FAQ</a>
                <a href="{{ url('/reviews') }}"><i class="fas fa-star"></i> Ulasan</a>
            </div>
        </li>
        <li><a href="{{ url('/contact') }}" class="nav-cta">Kontak</a></li>
        <li style="border-left:1px solid rgba(255,255,255,.15);height:20px;margin:0 4px;"></li>
        @auth
            @if(auth()->user()->role === 'admin')
                <li><a href="{{ route('admin.dashboard') }}" class="nav-admin"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            @else
                <li><a href="{{ url('/reviews/create') }}" class="nav-cta">Tulis Ulasan</a></li>
                <li style="position:relative;" class="nav-user-dropdown">
                    <button type="button" class="nav-admin nav-user-btn" id="userMenuBtn">
                        <i class="fas fa-user"></i> {{ Str::limit(auth()->user()->name, 15) }} ▾
                    </button>
                    <div class="nav-dropdown" id="userMenuDropdown">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                </li>
            @endif
        @else
            <li><a href="{{ route('login') }}" class="nav-admin"><i class="fas fa-lock"></i> Login</a></li>
        @endauth
    </ul>
    <button class="hamburger" id="hamburger" aria-label="Menu">
        <span></span><span></span><span></span>
    </button>
</nav>

@yield('content')

<footer id="contact">
    <div class="footer-inner">
        <div class="footer-brand">
            <h3>Pasir Putih <span>Parparean</span></h3>
            <p>Destinasi wisata pantai terbaik di kawasan Danau Toba, Sumatera Utara. Alam indah, budaya kaya, kenangan abadi.</p>
            <div class="footer-socials">
                @php $contact = \App\Models\Contact::where('is_active', true)->first(); @endphp
                @if($contact)
                    @if($contact->instagram)<a href="{{ $contact->instagram }}" target="_blank" class="social-btn"><i class="fab fa-instagram"></i></a>@endif
                    @if($contact->facebook)<a href="{{ $contact->facebook }}" target="_blank" class="social-btn"><i class="fab fa-facebook-f"></i></a>@endif
                    @if($contact->youtube)<a href="{{ $contact->youtube }}" target="_blank" class="social-btn"><i class="fab fa-youtube"></i></a>@endif
                    @if($contact->twitter)<a href="{{ $contact->twitter }}" target="_blank" class="social-btn"><i class="fab fa-x-twitter"></i></a>@endif
                @endif
            </div>
        </div>
        <div class="footer-links">
            <div class="footer-col">
                <h4>Jelajahi</h4>
                <ul>
                    <li><a href="{{ url('/about') }}">Tentang Kami</a></li>
                    <li><a href="{{ url('/gallery') }}">Galeri</a></li>
                    <li><a href="{{ url('/facilities') }}">Fasilitas</a></li>
                    <li><a href="{{ url('/pricing') }}">Harga Tiket</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Informasi</h4>
                <ul>
                    <li><a href="{{ url('/announcements') }}">Pengumuman</a></li>
                    <li><a href="{{ url('/faq') }}">FAQ</a></li>
                    <li><a href="{{ route('information-requests.index') }}">Permintaan Informasi</a></li>
                    <li><a href="{{ url('/reviews') }}">Ulasan</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© {{ date('Y') }} Pasir Putih Parparean. All rights reserved.</p>
        <a href="{{ url('/contact') }}">Hubungi Kami</a>
    </div>
</footer>

{{-- ✅ FIX 1: HTML chatbot harus di-render SEBELUM script dijalankan --}}
@include('public.partials._chatbot')

<script src="{{ asset('js/public.js') }}"></script>
{{-- ✅ FIX 2: Hapus 'defer' agar chatbot.js jalan setelah DOM siap --}}
<script src="{{ asset('js/chatbot.js') }}"></script>
@stack('scripts')
</body>
</html>
