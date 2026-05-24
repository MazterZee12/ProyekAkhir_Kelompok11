<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body class="theme-purple">

<!-- NAVBAR -->
<nav class="navbar navbar-dark">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <button id="toggleSidebar" class="btn btn-outline-light btn-sm">
                <i class="fas fa-bars"></i>
            </button>
            <span class="navbar-brand mb-0">
                <i class="fas fa-umbrella-beach me-2"></i>Pasir Putih Toba
            </span>
        </div>
        <!-- THEME SWITCHER -->
    <div class="theme-switcher-wrapper">
        <button class="theme-toggle-btn" id="themeToggle" title="Change Theme">
            <i class="fas fa-palette"></i>
        </button>
        <div class="theme-palette" id="themePalette">
            <div class="theme-palette-inner">
                <small class="theme-palette-label">Pilih Tema</small>
                <div class="theme-grid">
                    <button class="theme-btn theme-purple-btn" onclick="setTheme('purple')" title="Purple">
                        <span>Purple</span>
                    </button>
                    <button class="theme-btn theme-ocean-btn" onclick="setTheme('ocean')" title="Ocean">
                        <span>Ocean</span>
                    </button>
                    <button class="theme-btn theme-forest-btn" onclick="setTheme('forest')" title="Forest">
                        <span>Forest</span>
                    </button>
                    <button class="theme-btn theme-black-btn" onclick="setTheme('black')" title="Dark">
                        <span>Dark</span>
                    </button>
                    <button class="theme-btn theme-rose-btn" onclick="setTheme('rose')" title="Rose">
                        <span>Rose</span>
                    </button>
                    <button class="theme-btn theme-amber-btn" onclick="setTheme('amber')" title="Amber">
                        <span>Amber</span>
                    </button>
                    <button class="theme-btn theme-slate-btn" onclick="setTheme('slate')" title="Slate">
                        <span>Slate</span>
                    </button>
                    <button class="theme-btn theme-yellow-btn" onclick="setTheme('yellow')" title="Yellow">
                        <span>Yellow</span>
                    </button>
                    <button class="theme-btn theme-cyan-btn" onclick="setTheme('cyan')" title="Cyan">
                        <span>Cyan</span>
                    </button>
                    <button class="theme-btn theme-lime-btn" onclick="setTheme('lime')" title="Lime">
                        <span>Lime</span>
                    </button>
                    <button class="theme-btn theme-pink-btn" onclick="setTheme('pink')" title="Pink">
                        <span>Pink</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
            <!-- USER -->
            <div class="dropdown">
                <button class="btn btn-outline-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle me-1"></i>{{ auth()->user()->name ?? 'Admin' }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="wrapper">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar">
        <div class="sidebar-section-label">Main</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-section-label">Konten</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.announcements.index') }}" class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i>
                    <span class="nav-text">Pengumuman</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.facilities.index') }}" class="nav-link {{ request()->routeIs('admin.facilities.*') ? 'active' : '' }}">
                    <i class="fas fa-building"></i>
                    <span class="nav-text">Fasilitas</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.prices.index') }}" class="nav-link {{ request()->routeIs('admin.prices.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span class="nav-text">Katalog Harga</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.galleries.index') }}" class="nav-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i>
                    <span class="nav-text">Galeri</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                    <i class="fas fa-image"></i>
                    <span class="nav-text">Banner</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-section-label">Informasi</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.profiles.index') }}" class="nav-link {{ request()->routeIs('admin.profiles.*') ? 'active' : '' }}">
                    <i class="fas fa-id-card"></i>
                    <span class="nav-text">Profil</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="fas fa-address-card"></i>
                    <span class="nav-text">Kontak & Lokasi</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.schedules.index') }}" class="nav-link {{ request()->routeIs('admin.schedules.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="nav-text">Jadwal & Kunjungan</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                    <i class="fas fa-question-circle"></i>
                    <span class="nav-text">FAQ</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-section-label">Pengguna</div>
        <ul class="nav flex-column">
            <li class="nav-item">
                @php
                    $reportedCount = \App\Models\Review::where('reports_count', '>=', 5)
                        ->where('is_hidden', false)
                        ->count();
                @endphp
                <a href="{{ route('admin.reviews.index') }}"
                    class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <i class="fas fa-star"></i>
                    <span class="nav-text d-flex align-items-center gap-2">
                        Ulasan
                        @if($reportedCount > 0)
                            <span class="badge bg-danger" style="font-size:0.6rem;padding:3px 6px;">
                                {{ $reportedCount }}
                            </span>
                        @endif
                    </span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- CONTENT -->
    <main class="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mx-3 mt-3" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
