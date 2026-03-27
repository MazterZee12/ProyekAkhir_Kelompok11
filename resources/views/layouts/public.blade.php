<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pantai Pasir Putih Toba')</title>
    <meta name="description" content="@yield('description', 'Destinasi wisata pantai terbaik di kawasan Danau Toba, Sumatera Utara.')">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/public.css') }}">
    @stack('styles')
</head>
<body>

<!-- NAVBAR -->
<nav id="navbar">
    <a href="{{ url('/') }}" class="nav-logo">
        Pasir Putih <span>Toba</span>
    </a>

    <ul class="nav-links">
        <li><a href="{{ url('/#about') }}">Tentang</a></li>
        <li><a href="{{ url('/#gallery') }}">Galeri</a></li>
        <li><a href="{{ url('/#facilities') }}">Fasilitas</a></li>
        <li><a href="{{ url('/#pricing') }}">Harga</a></li>
        <li><a href="{{ url('/#announcements') }}">Pengumuman</a></li>
        <li><a href="{{ url('/#contact') }}" class="nav-cta">Kontak</a></li>

        {{-- Separator --}}
        <li style="border-left: 1px solid rgba(255,255,255,0.15); height: 20px; margin: 0 4px;"></li>

        {{-- Login pengunjung / nama jika sudah login --}}
        @auth
            @if(auth()->user()->role === 'admin')
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="nav-admin">
                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                    </a>
                </li>
            @else
                <li>
                    <a href="#" class="nav-admin">
                        <i class="fas fa-user me-1"></i>{{ auth()->user()->name }}
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="nav-admin" style="cursor:pointer; background:none; border:none; font-family:inherit;">
                            Logout
                        </button>
                    </form>
                </li>
            @endif
        @else
            <li>
                <a href="{{ route('login') }}" class="nav-admin">
                    <i class="fas fa-lock me-1"></i>Login
                </a>
            </li>
        @endauth
    </ul>

    <button class="hamburger" id="hamburger">
        <span></span><span></span><span></span>
    </button>
</nav>

<!-- CONTENT -->
@yield('content')

<!-- FOOTER -->
<footer id="contact">
    <div class="footer-grid">
        <div class="footer-brand">
            <h3>Pasir Putih <span>Toba</span></h3>
            <p>Destinasi wisata pantai terbaik di kawasan Danau Toba, Sumatera Utara. Alam indah, budaya kaya, kenangan abadi.</p>
            <div class="footer-socials">
                @php $contact = \App\Models\Contact::where('is_active', true)->first(); @endphp
                @if($contact)
                    @if($contact->instagram)
                        <a href="{{ $contact->instagram }}" target="_blank" class="social-btn"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if($contact->facebook)
                        <a href="{{ $contact->facebook }}" target="_blank" class="social-btn"><i class="fab fa-facebook"></i></a>
                    @endif
                    @if($contact->youtube)
                        <a href="{{ $contact->youtube }}" target="_blank" class="social-btn"><i class="fab fa-youtube"></i></a>
                    @endif
                    @if($contact->twitter)
                        <a href="{{ $contact->twitter }}" target="_blank" class="social-btn"><i class="fab fa-twitter"></i></a>
                    @endif
                @endif
            </div>
        </div>
        <div class="footer-col">
            <h4>Navigasi</h4>
            <ul>
                <li><a href="{{ url('/#about') }}">Tentang Kami</a></li>
                <li><a href="{{ url('/#gallery') }}">Galeri</a></li>
                <li><a href="{{ url('/#facilities') }}">Fasilitas</a></li>
                <li><a href="{{ url('/#pricing') }}">Harga Tiket</a></li>
                <li><a href="{{ url('/#announcements') }}">Pengumuman</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Informasi</h4>
            <ul>
                <li><a href="{{ url('/faq') }}">FAQ</a></li>
                <li><a href="{{ url('/schedule') }}">Jadwal Operasional</a></li>
                <li><a href="{{ url('/reviews') }}">Ulasan</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Kontak</h4>
            <ul>
                @if($contact)
                    @if($contact->address)
                        <li><a href="#"><i class="fas fa-map-marker-alt"></i> {{ $contact->address }}</a></li>
                    @endif
                    @if($contact->phone)
                        <li><a href="tel:{{ $contact->phone }}"><i class="fas fa-phone"></i> {{ $contact->phone }}</a></li>
                    @endif
                    @if($contact->email)
                        <li><a href="mailto:{{ $contact->email }}"><i class="fas fa-envelope"></i> {{ $contact->email }}</a></li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© {{ date('Y') }} Pantai Pasir Putih Toba. All rights reserved.</p>
        <p>Dibuat dengan ❤ untuk wisata Danau Toba</p>
    </div>
</footer>

<script src="{{ asset('js/public.js') }}"></script>
@stack('scripts')
</body>
</html>
