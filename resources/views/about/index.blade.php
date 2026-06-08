@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<section style="background: linear-gradient(135deg, #1a1a1a 0%, #333 100%); color: #fff; padding: 4rem 0; margin-bottom: 3rem;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin: 0;">Tentang Kami</h1>
        <p style="color: #ccc; margin-top: 0.5rem;">Kenali BarberShop Modern — tempat tampil percaya diri</p>
    </div>
</section>

<div class="container mb-5">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h3 style="font-weight: 700; color: #1a1a1a; margin-bottom: 1rem;">
                        <i class="fas fa-cut me-2" style="color: #d4af37;"></i>BarberShop Modern
                    </h3>
                    <p style="color: #666; line-height: 1.8;">
                        BarberShop Modern adalah barbershop premium yang menghadirkan pengalaman grooming terbaik.
                        Tim barber profesional kami siap membantu Anda tampil maksimal dengan layanan potong rambut,
                        perawatan wajah, dan styling modern.
                    </p>
                    <p style="color: #666; line-height: 1.8; margin-bottom: 0;">
                        Kami percaya setiap pelanggan layak mendapat pelayanan berkualitas, nyaman, dan ramah.
                        Login untuk mulai booking layanan favorit Anda.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h3 style="font-weight: 700; color: #1a1a1a; margin-bottom: 1rem;">
                        <i class="fas fa-star me-2" style="color: #d4af37;"></i>Keunggulan Kami
                    </h3>
                    <ul class="list-unstyled mb-0" style="color: #666; line-height: 2;">
                        <li><i class="fas fa-check-circle me-2" style="color: #d4af37;"></i>Barber berpengalaman &amp; profesional</li>
                        <li><i class="fas fa-check-circle me-2" style="color: #d4af37;"></i>Produk perawatan berkualitas</li>
                        <li><i class="fas fa-check-circle me-2" style="color: #d4af37;"></i>Booking online mudah &amp; cepat</li>
                        <li><i class="fas fa-check-circle me-2" style="color: #d4af37;"></i>Pembayaran QRIS &amp; transfer bank</li>
                        <li><i class="fas fa-check-circle me-2" style="color: #d4af37;"></i>Jam operasional Senin–Minggu 09:00–21:00</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        @guest
            <a href="{{ route('login.index') }}" class="btn btn-primary btn-lg me-2">
                <i class="fas fa-sign-in-alt me-2"></i>Login untuk Booking
            </a>
            <a href="{{ route('register.index') }}" class="btn btn-dark btn-lg">
                <i class="fas fa-user-plus me-2"></i>Daftar Akun
            </a>
        @else
            <a href="{{ route('booking.index') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-calendar-alt me-2"></i>Booking Sekarang
            </a>
        @endguest
    </div>
</div>
@endsection
