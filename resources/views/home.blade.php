@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<section class="hero" style="background: linear-gradient(135deg, #1a1a1a 0%, #333 100%); color: #fff; padding: 8rem 0; position: relative; overflow: hidden;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 style="font-size: 3.5rem; font-weight: 700; margin-bottom: 1rem; line-height: 1.2;">
                    Tampil Percaya Diri
                    <span style="color: #d4af37;">Bersama Kami</span>
                </h1>
                <p style="font-size: 1.1rem; margin-bottom: 2rem; line-height: 1.6; color: #ccc;">
                    Barbershop modern dengan pelayanan premium dan barber profesional yang siap membuat Anda tampil maksimal.
                </p>
                <div class="d-flex gap-3">
                    @auth
                    <a href="{{ route('booking.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-calendar-alt me-2"></i>Booking Sekarang
                    </a>
                    @else
                    <a href="{{ route('login.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Login untuk Booking
                    </a>
                    @endauth
                    <a href="{{ route('services.index') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-info-circle me-2"></i>Lihat Layanan
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div style="position: relative;">
                    <img src="gambarcukurhalamanberanda.png" alt="Hero Image" class="img-fluid rounded-3" style="box-shadow: 0 10px 40px rgba(212, 175, 55, 0.3);">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section style="padding: 5rem 0;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Layanan Kami</h2>
            <p style="color: #666; margin-top: 2rem; font-size: 1.1rem;">
                Kami menyediakan berbagai layanan barbershop premium dengan harga terjangkau
            </p>
        </div>
        <div class="row g-4">
            @forelse($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100" style="border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px); box-shadow: 0 15px 40px rgba(212, 175, 55, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 20px rgba(0,0,0,0.1)'">
                        <img src="{{ $service->image_url ?? 'https://via.placeholder.com/300x200?text=' . urlencode($service->name) }}" class="card-img-top" alt="{{ $service->name }}" style="height: 200px; object-fit: cover; border-radius: 15px 15px 0 0;">
                        <div class="card-body">
                            <h5 class="card-title" style="color: #1a1a1a; font-weight: 700;">{{ $service->name }}</h5>
                            <p class="card-text text-muted" style="font-size: 0.95rem;">{{ Str::limit($service->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span style="font-size: 1.5rem; font-weight: 700; color: #d4af37;">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                <small style="color: #999;"><i class="fas fa-clock me-1"></i>{{ $service->duration }} min</small>
                            </div>
                            <a href="{{ route('services.show', $service) }}" class="btn btn-primary w-100 mt-3">
                                <i class="fas fa-arrow-right me-2"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p style="color: #999; font-size: 1.1rem;">Tidak ada layanan yang tersedia</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('services.index') }}" class="btn btn-dark btn-lg">
                <i class="fas fa-list me-2"></i>Lihat Semua Layanan
            </a>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section style="padding: 5rem 0; background-color: #fff;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Galeri Karya Kami</h2>
            <p style="color: #666; margin-top: 2rem; font-size: 1.1rem;">
                Hasil karya profesional dari tim barber berpengalaman kami
            </p>
        </div>
        <div class="row g-4">
            @forelse($galleries as $gallery)
                <div class="col-md-6 col-lg-3">
                    <div style="position: relative; overflow: hidden; border-radius: 15px; height: 250px;">
                        <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: all 0.3s ease;" class="gallery-img">
                        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(26, 26, 26, 0.7); display: flex; align-items: center; justify-content: center; opacity: 0; transition: all 0.3s ease;" class="gallery-overlay">
                            <div class="text-center text-white">
                                <h6 style="font-weight: 700; margin-bottom: 0.5rem;">{{ $gallery->title }}</h6>
                                <p style="font-size: 0.9rem;">{{ Str::limit($gallery->description, 50) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p style="color: #999; font-size: 1.1rem;">Galeri belum tersedia</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('gallery.index') }}" class="btn btn-dark btn-lg">
                <i class="fas fa-images me-2"></i>Lihat Galeri Lengkap
            </a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section style="padding: 5rem 0;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Testimoni Pelanggan</h2>
            <p style="color: #666; margin-top: 2rem; font-size: 1.1rem;">
                Kepuasan pelanggan adalah prioritas utama kami
            </p>
        </div>
        <div class="row g-4">
            @forelse($testimonials as $testimonial)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100" style="border: none; border-left: 5px solid #d4af37; border-radius: 10px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $testimonial->image_url ?? 'https://ui-avatars.com/api/?name='.urlencode($testimonial->name).'&background=d4af37&color=1a1a1a' }}" alt="{{ $testimonial->name }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-right: 1rem;">
                                <div>
                                    <h6 class="mb-0" style="font-weight: 700;">{{ $testimonial->name }}</h6>
                                    <div style="color: #d4af37;">@for($i = 1; $i <= $testimonial->rating; $i++)<i class="fas fa-star"></i>@endfor</div>
                                </div>
                            </div>
                            <p class="card-text text-muted" style="font-size: 0.95rem; line-height: 1.6;">"{{ $testimonial->message }}"</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p style="color: #999; font-size: 1.1rem;">Belum ada testimoni</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('testimonials.index') }}" class="btn btn-dark btn-lg">
                <i class="fas fa-comments me-2"></i>Lihat Semua Testimoni
            </a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="background: linear-gradient(135deg, #1a1a1a 0%, #333 100%); color: #fff; padding: 5rem 0;">
    <div class="container text-center">
        <h2 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem;">Siap Tampil Percaya Diri?</h2>
        <p style="font-size: 1.1rem; margin-bottom: 2rem; color: #ccc;">
            Booking sekarang dan dapatkan pengalaman barbershop kelas dunia
        </p>
        @auth
        <a href="{{ route('booking.index') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-calendar-alt me-2"></i>Booking Sekarang
        </a>
        @else
        <a href="{{ route('login.index') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-sign-in-alt me-2"></i>Login untuk Booking
        </a>
        @endauth
    </div>
</section>

<style>
    .gallery-img:hover {
        transform: scale(1.1);
    }
    
    .gallery-img:hover ~ .gallery-overlay,
    .gallery-overlay:hover {
        opacity: 1 !important;
    }
</style>
@endsection