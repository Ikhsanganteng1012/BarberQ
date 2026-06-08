<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin BarberShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        :root {
            --admin-sidebar: #141414;
            --admin-sidebar-hover: #1f1f1f;
            --admin-header: #1a1a1a;
            --admin-active: #0d6efd;
            --admin-content-bg: #f0f2f5;
        }
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background: var(--admin-content-bg); min-height: 100vh; margin: 0; }
        .admin-wrapper { display: flex; min-height: 100vh; }
        .admin-sidebar {
            width: 260px;
            background: var(--admin-sidebar);
            color: #e8e8e8;
            flex-shrink: 0;
            transition: transform .2s;
        }
        .admin-sidebar .brand {
            padding: 1.25rem 1.25rem;
            font-weight: 700;
            font-size: 1rem;
            border-bottom: 1px solid rgba(255,255,255,.08);
            color: #fff;
        }
        .admin-sidebar .nav-link {
            color: #c8c8c8;
            padding: .65rem 1.25rem;
            display: flex;
            align-items: center;
            gap: .65rem;
            text-decoration: none;
            font-size: .9rem;
            border-left: 3px solid transparent;
        }
        .admin-sidebar .nav-link:hover { background: var(--admin-sidebar-hover); color: #fff; }
        .admin-sidebar .nav-link.active {
            background: var(--admin-active);
            color: #fff;
            border-left-color: #fff;
        }
        .admin-sidebar .submenu { background: rgba(0,0,0,.2); }
        .admin-sidebar .submenu .nav-link { padding-left: 2.5rem; font-size: .85rem; }
        .admin-sidebar .submenu .nav-link.active { background: rgba(13,110,253,.35); }
        .admin-main { flex: 1; display: flex; flex-direction: column; min-width: 0; }
        .admin-header {
            background: var(--admin-header);
            color: #fff;
            padding: .85rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        .admin-header .title { font-weight: 600; font-size: 1rem; }
        .admin-content {
            flex: 1;
            padding: 1.5rem;
            background: #fff;
            margin: 1rem;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,.06);
        }
        .admin-footer {
            text-align: center;
            padding: 1rem;
            color: #6c757d;
            font-size: .85rem;
        }
        .btn-admin-add { background: #6f42c1; border-color: #6f42c1; color: #fff; }
        .btn-admin-add:hover { background: #5a32a3; border-color: #5a32a3; color: #fff; }
        @media (max-width: 991.98px) {
            .admin-sidebar { position: fixed; z-index: 1040; height: 100vh; overflow-y: auto; transform: translateX(-100%); }
            .admin-sidebar.show { transform: translateX(0); }
            .admin-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.4); z-index: 1039; }
            .admin-overlay.show { display: block; }
        }
    </style>
    @yield('styles')
</head>
<body>
<div class="admin-overlay d-lg-none" id="adminOverlay"></div>
<div class="admin-wrapper">
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="brand"><i class="fas fa-cut me-2"></i>BarberQ Admin</div>
        <nav class="py-2">
            <a class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-home fa-fw"></i> Beranda
            </a>
            <a class="nav-link @if(request()->routeIs('admin.users.index') && !request()->boolean('customers')) active @endif" href="{{ route('admin.users.index') }}">
                <i class="fas fa-user-shield fa-fw"></i> User
            </a>
            <a class="nav-link @if(request()->routeIs('admin.users.index') && request()->boolean('customers')) active @endif" href="{{ route('admin.users.index', ['customers' => 1]) }}">
                <i class="fas fa-users fa-fw"></i> Customer
            </a>
            <div class="text-uppercase small text-secondary px-3 pt-3 pb-1">Katalog</div>
            <div class="submenu">
                <a class="nav-link @if(request()->routeIs('admin.galleries.*')) active @endif" href="{{ route('admin.galleries.index') }}">
                    <i class="fas fa-images fa-fw"></i> Galeri
                </a>
                <a class="nav-link @if(request()->routeIs('admin.hair-styles.*')) active @endif" href="{{ route('admin.hair-styles.index') }}">
                    <i class="fas fa-user-tie fa-fw"></i> Model Rambut
                </a>
            </div>
            <a class="nav-link @if(request()->routeIs('admin.services.*')) active @endif" href="{{ route('admin.services.index') }}">
                <i class="fas fa-concierge-bell fa-fw"></i> Layanan
            </a>
            <a class="nav-link @if(request()->routeIs('admin.testimonials.*')) active @endif" href="{{ route('admin.testimonials.index') }}">
                <i class="fas fa-quote-left fa-fw"></i> Testimoni
            </a>
            <a class="nav-link @if(request()->routeIs('admin.bookings.*')) active @endif" href="{{ route('admin.bookings.index') }}">
                <i class="fas fa-calendar-check fa-fw"></i> Transaksi Booking
            </a>
            <a class="nav-link @if(request()->routeIs('admin.reports.*')) active @endif" href="{{ route('admin.reports.index') }}">
                <i class="fas fa-chart-bar fa-fw"></i> Laporan
            </a>
            <a class="nav-link @if(request()->routeIs('admin.consultations.*')) active @endif" href="{{ route('admin.consultations.index') }}">
                <i class="fas fa-comments fa-fw"></i> Konsultasi
            </a>
        </nav>
    </aside>
    <div class="admin-main">
        <header class="admin-header">
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-link text-white p-0 d-lg-none" id="sidebarToggle" aria-label="Menu">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
                <span class="title">BarberQ — Panel Admin</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="small text-white-50 d-none d-sm-inline">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm"><i class="fas fa-sign-out-alt"></i></button>
                </form>
            </div>
        </header>
        <div class="admin-content">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">{{ $message }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ $message }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @yield('content')
        </div>
        <footer class="admin-footer">Web Programming — Studi Kasus BarberQ.</footer>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
(function () {
    var sb = document.getElementById('adminSidebar');
    var ov = document.getElementById('adminOverlay');
    var tg = document.getElementById('sidebarToggle');
    if (tg && sb && ov) {
        tg.addEventListener('click', function () { sb.classList.toggle('show'); ov.classList.toggle('show'); });
        ov.addEventListener('click', function () { sb.classList.remove('show'); ov.classList.remove('show'); });
    }
})();
</script>
@yield('scripts')
</body>
</html>
