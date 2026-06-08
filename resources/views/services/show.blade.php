@extends('layouts.app')

@section('title', $service->name)

@section('content')
<!-- Breadcrumb -->
<section style="background-color: #f8f9fa; padding: 1.5rem 0;">
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>'; font-size: 0.95rem;" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Layanan</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $service->name }}</li>
            </ol>
        </nav>
    </div>
</section>

<div class="container my-5">
    <div class="row gap-4">
        <!-- Image -->
        <div class="col-lg-6">
            <img src="{{ $service->image_url ?? 'https://via.placeholder.com/500x500?text=' . urlencode($service->name) }}" alt="{{ $service->name }}" class="img-fluid rounded-3" style="box-shadow: 0 10px 40px rgba(212, 175, 55, 0.2);">
        </div>

        <!-- Details -->
        <div class="col-lg-6">
            <h1 style="font-size: 2.5rem; font-weight: 700; color: #1a1a1a; margin-bottom: 1rem;">{{ $service->name }}</h1>
            
            <div style="border-top: 2px solid #e0e0e0; border-bottom: 2px solid #e0e0e0; padding: 1.5rem 0; margin-bottom: 2rem;">
                <div class="row">
                    <div class="col-6 mb-3">
                        <small style="color: #999; display: block; margin-bottom: 0.5rem;"><i class="fas fa-tag me-1"></i>HARGA</small>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #d4af37; margin: 0;">Rp {{ number_format($service->price, 0, ',', '.') }}</h3>
                    </div>
                    <div class="col-6 mb-3">
                        <small style="color: #999; display: block; margin-bottom: 0.5rem;"><i class="fas fa-hourglass-end me-1"></i>DURASI</small>
                        <h3 style="font-size: 2rem; font-weight: 700; color: #1a1a1a; margin: 0;">{{ $service->duration }} min</h3>
                    </div>
                </div>
            </div>

            <h4 style="color: #1a1a1a; font-weight: 700; margin-bottom: 1rem;">Deskripsi Layanan</h4>
            <p style="color: #666; line-height: 1.8; font-size: 1rem; margin-bottom: 2rem;">
                {{ $service->description }}
            </p>

            <h4 style="color: #1a1a1a; font-weight: 700; margin-bottom: 1rem; margin-top: 2rem;">Fitur Layanan</h4>
            <ul style="list-style: none; padding: 0; margin-bottom: 2rem;">
                <li style="padding: 0.5rem 0;"><i class="fas fa-check" style="color: #d4af37; width: 25px; text-align: center;"></i> Dilayani oleh barber profesional</li>
                <li style="padding: 0.5rem 0;"><i class="fas fa-check" style="color: #d4af37; width: 25px; text-align: center;"></i> Menggunakan produk berkualitas</li>
                <li style="padding: 0.5rem 0;"><i class="fas fa-check" style="color: #d4af37; width: 25px; text-align: center;"></i> Suasana nyaman dan aman</li>
                <li style="padding: 0.5rem 0;"><i class="fas fa-check" style="color: #d4af37; width: 25px; text-align: center;"></i> Kepuasan pelanggan terjamin</li>
            </ul>

            <div class="d-grid gap-2 mt-4">
                <a href="{{ route('booking.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-calendar-alt me-2"></i>Booking Sekarang
                </a>
                <a href="{{ route('services.index') }}" class="btn btn-outline-dark btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Layanan
                </a>
            </div>
        </div>
    </div>

    <!-- Related Services -->
    @if($relatedServices->count())
        <section style="margin-top: 5rem;">
            <h3 style="font-size: 1.8rem; font-weight: 700; color: #1a1a1a; margin-bottom: 2rem;">
                <i class="fas fa-list me-2"></i>Layanan Terkait
            </h3>
            <div class="row g-4">
                @foreach($relatedServices as $related)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100" style="border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                            <img src="{{ $related->image_url ?? 'https://via.placeholder.com/300x200?text=' . urlencode($related->name) }}" class="card-img-top" alt="{{ $related->name }}" style="height: 150px; object-fit: cover; border-radius: 15px 15px 0 0;">
                            <div class="card-body">
                                <h5 class="card-title" style="font-weight: 700;">{{ $related->name }}</h5>
                                <p class="card-text text-muted" style="font-size: 0.9rem;">{{ Str::limit($related->description, 60) }}</p>
                                <p style="font-size: 1.3rem; font-weight: 700; color: #d4af37; margin-bottom: 1rem;">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                                <a href="{{ route('services.show', $related) }}" class="btn btn-primary w-100">
                                    <i class="fas fa-arrow-right me-2"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection