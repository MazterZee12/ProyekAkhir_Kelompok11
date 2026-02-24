<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body class="theme-purple">

<!-- NAVBAR -->
<nav class="navbar navbar-dark">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <div>
            <button id="toggleSidebar" class="btn btn-outline-light me-2">
                <i class="fas fa-bars"></i>
            </button>
            <span class="navbar-brand">Admin Panel</span>
        </div>

        <!-- THEME SWITCHER -->
        <div class="btn-group">
            <button class="btn btn-sm btn-purple" onclick="setTheme('purple')"></button>
            <button class="btn btn-sm btn-orange" onclick="setTheme('orange')"></button>
            <button class="btn btn-sm btn-red" onclick="setTheme('red')"></button>
            <button class="btn btn-sm btn-dark" onclick="setTheme('black')"></button>
        </div>

    </div>
</nav>

<div class="wrapper">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar">
        <ul class="nav flex-column mt-3">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- Settings (Pengaturan) -->
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog me-2"></i>
                    <span class="nav-text">Settings</span>
                </a>
            </li>

            <!-- Galeri (Gallery) -->
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-images me-2"></i>
                    <span class="nav-text">Galeri</span>
                </a>
            </li>

            <!-- Fasilitas (Facilities) -->
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-building me-2"></i>
                    <span class="nav-text">Fasilitas</span>
                </a>
            </li>

            <!-- Harga Menu (Menu Prices) -->
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-utensils me-2"></i>
                    <span class="nav-text">Harga Menu</span>
                </a>
            </li>

            <!-- Pengumuman (Announcements) -->
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-bullhorn me-2"></i>
                    <span class="nav-text">Pengumuman</span>
                </a>
            </li>

            <!-- Profil (Profile) -->
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-id-card me-2"></i>
                    <span class="nav-text">Profil</span>
                </a>
            </li>

            <!-- Ulasan (Reviews) -->
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-star me-2"></i>
                    <span class="nav-text">Ulasan</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- CONTENT -->
    <main class="content">
        @yield('content')
    </main>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');

    // Sidebar toggle
    toggleBtn.addEventListener('click', function() {
        if(window.innerWidth < 992){
            sidebar.classList.toggle('show'); // offcanvas mobile
        } else {
            sidebar.classList.toggle('collapsed'); // desktop collapse
        }
    });

    // Theme switcher
    function setTheme(theme) {
        document.body.classList.remove('theme-purple','theme-orange','theme-red','theme-black');
        document.body.classList.add('theme-' + theme);
        localStorage.setItem('admin-theme', theme);
    }

    // Load saved theme
    window.addEventListener('DOMContentLoaded', () => {
        const savedTheme = localStorage.getItem('admin-theme');
        if(savedTheme) setTheme(savedTheme);
    });
</script>

</body>
</html>
