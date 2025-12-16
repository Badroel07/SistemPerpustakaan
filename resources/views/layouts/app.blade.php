<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Perpustakaan')</title>

    <!-- Bulma CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #3273dc;
            --primary-dark: #2756a8;
            --accent-color: #00d1b2;
            --bg-dark: #1a1a2e;
            --bg-card: #16213e;
            --text-light: #f5f5f5;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--bg-dark) 0%, #0f3460 100%);
            min-height: 100vh;
        }

        .sidebar {
            background: var(--bg-card);
            min-height: 100vh;
            position: fixed;
            width: 260px;
            padding: 1.5rem 0;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.3);
            z-index: 100;
        }

        .sidebar-brand {
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }

        .sidebar-brand h1 {
            color: var(--text-light);
            font-size: 1.3rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand i {
            color: var(--accent-color);
            font-size: 1.5rem;
        }

        .sidebar-menu {
            padding: 0 1rem;
        }

        .sidebar-menu .menu-label {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0.5rem 1rem;
            margin-top: 1rem;
        }

        .sidebar-menu .menu-list a {
            color: rgba(255, 255, 255, 0.7);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            margin-bottom: 0.25rem;
        }

        .sidebar-menu .menu-list a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-light);
        }

        .sidebar-menu .menu-list a.is-active {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            font-weight: 500;
        }

        .sidebar-menu .menu-list a i {
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 260px;
            padding: 2rem;
            min-height: 100vh;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .top-bar h2 {
            color: var(--text-light);
            font-size: 1.5rem;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--text-light);
        }

        .user-info .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-header-title {
            color: var(--text-light);
            font-weight: 600;
        }

        .card-content {
            color: rgba(255, 255, 255, 0.8);
        }

        .table {
            background: transparent;
            color: rgba(255, 255, 255, 0.9);
        }

        .table thead {
            background: transparent;
        }

        .table thead th {
            color: rgba(255, 255, 255, 0.6) !important;
            background: rgba(255, 255, 255, 0.05) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .table tbody tr {
            background: transparent !important;
        }

        .table.is-striped tbody tr:not(.is-selected):nth-child(even) {
            background: rgba(255, 255, 255, 0.03) !important;
        }

        .table.is-striped tbody tr:not(.is-selected):nth-child(odd) {
            background: transparent !important;
        }

        .table td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
            vertical-align: middle;
            color: rgba(255, 255, 255, 0.9) !important;
            background: transparent !important;
        }

        .table th {
            color: rgba(255, 255, 255, 0.6) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        .table.is-hoverable tbody tr:not(.is-selected):hover {
            background: rgba(255, 255, 255, 0.08) !important;
        }

        .button.is-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .button.is-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(50, 115, 220, 0.4);
        }

        .input,
        .textarea,
        .select select {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-light);
            border-radius: 8px;
        }

        /* Fix dropdown option text color */
        .select select option {
            background: #1a1a2e;
            color: #f5f5f5;
        }

        .select select option:hover,
        .select select option:checked {
            background: #3273dc;
            color: white;
        }

        .input:focus,
        .textarea:focus,
        .select select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 2px rgba(0, 209, 178, 0.2);
        }

        .input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .label {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        .tag.is-success {
            background: #48c78e;
        }

        .tag.is-danger {
            background: #f14668;
        }

        .tag.is-warning {
            background: #ffe08a;
            color: #1a1a2e;
        }

        .tag.is-info {
            background: #3e8ed0;
        }

        .notification {
            border-radius: 12px;
        }

        .stat-card {
            padding: 1.5rem;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .stat-card .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-light);
        }

        .stat-card .stat-label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }

        .pagination-link,
        .pagination-previous,
        .pagination-next {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-light);
        }

        .pagination-link.is-current {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .modal-card {
            border-radius: 16px;
            overflow: hidden;
        }

        .modal-card-head,
        .modal-card-foot {
            background: var(--bg-card);
            border: none;
        }

        .modal-card-title {
            color: var(--text-light);
        }

        .modal-card-body {
            background: var(--bg-dark);
        }

        @media screen and (max-width: 1023px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.is-active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <h1><i class="fas fa-book-open"></i> Perpustakaan</h1>
        </div>

        <nav class="sidebar-menu">
            <aside class="menu">
                <ul class="menu-list">
                    <li>
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'is-active' : '' }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                </ul>

                <p class="menu-label">Transaksi</p>
                <ul class="menu-list">
                    <li>
                        <a href="{{ route('peminjaman.index') }}" class="{{ request()->routeIs('peminjaman.*') ? 'is-active' : '' }}">
                            <i class="fas fa-hand-holding"></i> Peminjaman
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pengembalian.index') }}" class="{{ request()->routeIs('pengembalian.*') ? 'is-active' : '' }}">
                            <i class="fas fa-undo"></i> Pengembalian
                        </a>
                    </li>
                </ul>

                <p class="menu-label">Data Master</p>
                <ul class="menu-list">
                    <li>
                        <a href="{{ route('anggota.index') }}" class="{{ request()->routeIs('anggota.*') ? 'is-active' : '' }}">
                            <i class="fas fa-users"></i> Anggota
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.*') ? 'is-active' : '' }}">
                            <i class="fas fa-book"></i> Buku
                        </a>
                    </li>
                </ul>

                <p class="menu-label">Laporan</p>
                <ul class="menu-list">
                    <li>
                        <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'is-active' : '' }}">
                            <i class="fas fa-chart-bar"></i> Laporan
                        </a>
                    </li>
                </ul>
            </aside>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="top-bar">
            <h2>@yield('page-title', 'Dashboard')</h2>
            <div class="user-info">
                <span>{{ Auth::guard('petugas')->user()->nama ?? 'Petugas' }}</span>
                <div class="avatar">
                    {{ strtoupper(substr(Auth::guard('petugas')->user()->nama ?? 'P', 0, 1)) }}
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="button is-small is-danger is-outlined">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="notification is-success is-light">
            <button class="delete"></button>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="notification is-danger is-light">
            <button class="delete"></button>
            {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="notification is-danger is-light">
            <button class="delete"></button>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>

    <script>
        // Close notification
        document.addEventListener('DOMContentLoaded', () => {
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                const $notification = $delete.parentNode;
                $delete.addEventListener('click', () => {
                    $notification.parentNode.removeChild($notification);
                });
            });

            // Auto-hide notifications after 5 seconds
            setTimeout(() => {
                document.querySelectorAll('.notification').forEach(notification => {
                    notification.style.transition = 'opacity 0.5s';
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 500);
                });
            }, 5000);
        });
    </script>
    @yield('scripts')
</body>

</html>