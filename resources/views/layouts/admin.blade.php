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

    <style>
        body {
            min-height: 100vh;
            overflow-x: hidden;
            transition: background 0.3s, color 0.3s;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 250px;
            transition: width 0.3s ease, background 0.3s ease, left 0.3s ease;
            color: #fff;
        }
        .sidebar.collapsed {
            width: 60px;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.75);
            padding: 12px 20px;
            transition: background 0.2s, color 0.2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,.15);
            color: #fff;
        }
        .sidebar .nav-text {
            transition: opacity 0.2s ease;
        }
        .sidebar.collapsed .nav-text {
            opacity: 0;
            pointer-events: none;
        }

        /* ===== CONTENT ===== */
        .content {
            flex: 1;
            padding: 20px;
            background: #f4f6f9;
            transition: background 0.3s, color 0.3s;
        }

        /* ===== THEMES ===== */
        /* Purple */
        body.theme-purple .navbar { background: #5b2d8b !important; }
        body.theme-purple .sidebar { background: #0d0219 !important; }
        body.theme-purple .sidebar .nav-link:hover,
        body.theme-purple .sidebar .nav-link.active { background: rgba(255,255,255,.15) !important; color: #fff !important; }

        /* Orange */
        body.theme-orange .navbar { background: #ff9800 !important; color: #000 !important; }
        body.theme-orange .sidebar { background: #ffffff !important; color: #000 !important; }
        body.theme-orange .sidebar .nav-link { color: #212529 !important; }
        body.theme-orange .sidebar .nav-link:hover,
        body.theme-orange .sidebar .nav-link.active { background: rgba(0,0,0,.1) !important; color: #000 !important; }

        /* Red */
        body.theme-red .navbar { background: #b71c1c !important; }
        body.theme-red .sidebar { background: #0d0219 !important; }
        body.theme-red .sidebar .nav-link:hover,
        body.theme-red .sidebar .nav-link.active { background: rgba(255,255,255,.15) !important; color: #fff !important; }

        /* Black */
        body.theme-black { background: #ffffff !important; color: #000 !important; }
        body.theme-black .navbar { background: #212121 !important; color: #fff !important; }
        body.theme-black .sidebar { background: #ffffff !important; color: #000 !important; }
        body.theme-black .sidebar .nav-link { color: #212529 !important; }
        body.theme-black .sidebar .nav-link:hover,
        body.theme-black .sidebar .nav-link.active { background: rgba(0,0,0,.1) !important; color: #000 !important; }

        /* ===== BUTTON COLORS ===== */
        .btn-purple { background-color: #5b2d8b; color: #fff; }
        .btn-purple:hover { background-color: #5b2d8b; color: #fff; }
        .btn-orange { background-color: #ff9800; color: #fff; }
        .btn-orange:hover { background-color: #ff9800; color: #fff;   }
        .btn-red { background-color: #b71c1c; color: #fff; }
        .btn-red:hover { background-color: #b71c1c; color: #fff;   }

        /* ===== OFFCANVAS MOBILE ===== */
        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                height: 100%;
                z-index: 1030;
            }
            .sidebar.show {
                left: 0;
            }
        }

        .btn-group .btn {
            width: 28px;
            height: 28px;
            padding: 0;
            border-radius: 50%;
        }

        .btn-group .btn:hover {
            transform: scale(1.1);
        }
    </style>
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
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="fas fa-home me-2"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cogs me-2"></i>
                    <span class="nav-text">Settings</span>
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
