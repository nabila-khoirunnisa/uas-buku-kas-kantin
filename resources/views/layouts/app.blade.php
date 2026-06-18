<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Buku Kas Kantin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f0f4f0;
            font-family: 'Figtree', sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            width: 240px;
            background: linear-gradient(180deg, #091d81 0%, #1d155f 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            padding-top: 0;
        }
        .sidebar-brand {
            background-color: #1b2f89;
            padding: 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-brand h5 {
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            margin: 0;
        }
        .sidebar-brand small {
            color: rgba(255,255,255,0.6);
            font-size: 0.75rem;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.75);
            padding: 10px 20px;
            border-radius: 8px;
            margin: 2px 10px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255,255,255,0.15);
            color: #fff;
        }
        .sidebar .nav-link i {
            font-size: 1.1rem;
            width: 20px;
        }
        .main-content {
            margin-left: 240px;
            min-height: 100vh;
        }
        .topbar {
            background-color: #fff;
            border-bottom: 1px solid #e0e0e0;
            padding: 12px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 99;
        }
        .topbar .page-title {
            font-weight: 600;
            color: #2851da;
            font-size: 1.1rem;
            margin: 0;
        }
        .topbar .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .topbar .user-avatar {
            width: 36px;
            height: 36px;
            background-color: #0b188d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.85rem;
        }
        .content-area {
            padding: 24px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
        }
        .btn-primary {
            background-color: #062268;
            border-color: #1a1b5c;
        }
        .btn-primary:hover {
            background-color: #1c1c80;
            border-color: #153f9a;
        }
        .table thead th {
            background-color: #120990;
            color: white;
            border: none;
            font-weight: 500;
            font-size: 0.875rem;
        }
        .table tbody tr:hover {
            background-color: #f0f7f3;
        }
        .badge-admin {
            background-color: #130996;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
        }
        .badge-kasir {
            background-color: #6c757d;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
        }
        .nav-section {
            padding: 12px 20px 4px;
            font-size: 0.7rem;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <div class="d-flex">

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-brand">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-book-half text-white" style="font-size:1.5rem;"></i>
                    <div>
                        <h5>Buku Kas</h5>
                        <small>Kantin</small>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <div class="nav-section">Menu Utama</div>

                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                <div class="nav-section">Menu</div>

@if(auth()->user()->role === 'admin')
    <div class="nav-section">Admin</div>

    <a href="{{ route('produk.index') }}"
       class="nav-link {{ request()->routeIs('produk.*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i> Produk
    </a>
@endif


<a href="{{ route('transaksi.index') }}"
   class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
    <i class="bi bi-receipt"></i> Transaksi
</a>

                <div class="nav-section">Akun</div>

                <a href="{{ route('profile.edit') }}"
                   class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i> Profil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link w-100 border-0 text-start"
                            style="background:none; cursor:pointer;">
                        <i class="bi bi-box-arrow-left"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">

            <!-- Topbar -->
            <div class="topbar">
                <p class="page-title">
                    <i class="bi bi-grid-1x2 me-1"></i>
                    @yield('page-title', 'Dashboard')
                </p>
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:0.875rem; font-weight:600;">{{ Auth::user()->name }}</div>
                        <div style="font-size:0.75rem; color:#888;">
                            {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Kasir' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="content-area">
                @yield('content')
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>