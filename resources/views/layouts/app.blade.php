<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - BarberShop Modern</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        :root {
            --primary: #1a1a1a;
            --secondary: #d4af37;
            --light: #f8f9fa;
            --dark: #111;
        }
        
        body {
            background-color: #f8f9fa;
        }
        
        /* Navbar */
        .navbar {
            background-color: var(--primary);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--secondary) !important;
        }
        
        .navbar-brand i {
            margin-right: 0.5rem;
        }
        
        .nav-link {
            color: #fff !important;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .nav-link:hover {
            color: var(--secondary) !important;
        }

        .nav-link.active {
            color: var(--secondary) !important;
            font-weight: 700;
            border-bottom: 2px solid var(--secondary);
        }
        
        /* Buttons */
        .btn-primary {
            background-color: var(--secondary);
            border-color: var(--secondary);
            color: var(--dark);
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: #c99a2e;
            border-color: #c99a2e;
            color: var(--dark);
        }
        
        .btn-dark {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-dark:hover {
            background-color: #333;
            border-color: #333;
        }
        
        /* Section */
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 4px;
            background-color: var(--secondary);
        }
        
        /* Footer */
        footer {
            background-color: var(--primary);
            color: #e8e8e8;
            padding: 3rem 0 1rem;
            margin-top: 5rem;
        }

        footer p,
        footer li,
        footer .text-muted {
            color: #e0e0e0 !important;
        }
        
        footer h5 {
            color: var(--secondary);
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        footer a {
            color: #e8e8e8;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        footer a:hover {
            color: var(--secondary);
        }
        
        footer .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-color: var(--secondary);
            color: var(--dark);
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            margin-right: 0.5rem;
            font-weight: 600;
        }
        
        footer .social-links a:hover {
            background-color: #fff;
        }
        
        .copyright {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 2rem;
            margin-top: 2rem;
            text-align: center;
            color: #ccc;
        }
        
        /* Alert */
        .alert {
            border-radius: 8px;
            border: none;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-cut"></i>BarberQ
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                    </li>
                    @auth
                        @if(auth()->user()->is_admin)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">Dashboard</a>
                            </li>
                        @endif
                    @endauth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}" href="{{ route('gallery.index') }}">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('testimonials.*') ? 'active' : '' }}" href="{{ route('testimonials.index') }}">Testimoni</a>
                    </li>
                    @guest
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('about.*') ? 'active' : '' }}" href="{{ route('about.index') }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary text-dark" href="{{ route('login.index') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary text-dark" href="{{ route('register.index') }}">Register</a>
                        </li>
                    @else
                        @if(auth()->user()->is_admin)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.consultations.*') ? 'active' : '' }}" href="{{ route('admin.consultations.index') }}">Konsultasi</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('consultations.*') ? 'active' : '' }}" href="{{ route('consultations.index') }}">Konsultasi</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs(['booking.*', 'bookings.*']) ? 'active' : '' }}" href="{{ route('booking.index') }}">Booking</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-primary text-dark">Logout</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-error alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5><i class="fas fa-cut me-2"></i>BarberShop</h5>
                    <p class="text-muted">Barbershop modern dengan pelayanan terbaik dan profesional.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Menu</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('services.index') }}">Layanan</a></li>
                        <li><a href="{{ route('gallery.index') }}">Galeri</a></li>
                        @auth
                            <li><a href="{{ route('booking.index') }}">Booking</a></li>
                        @else
                            <li><a href="{{ route('about.index') }}">About</a></li>
                        @endauth
                        <li><a href="{{ route('login.index') }}">Login</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Layanan</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Potong Rambut</a></li>
                        <li><a href="#">Cukur Kumis</a></li>
                        <li><a href="#">Perawatan Wajah</a></li>
                        <li><a href="#">Coloring</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled text-muted">
                        <li><i class="fas fa-phone me-2"></i>+62 812-3456-7890</li>
                        <li><i class="fas fa-envelope me-2"></i>contact@barbershop.com</li>
                        <li><i class="fas fa-map-marker-alt me-2"></i>Jl. kembangan utara no 12, Jakarta</li>
                        <li><i class="fas fa-clock me-2"></i>Senin - Minggu 09:00 - 21:00</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2026 BarberQ. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>