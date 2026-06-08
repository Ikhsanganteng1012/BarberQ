@extends('layouts.app')

@section('title', 'Layanan Kami')

@section('content')
<!-- Header -->
<section style="background: linear-gradient(135deg, #1a1a1a 0%, #333 100%); color: #fff; padding: 4rem 0; margin-bottom: 3rem;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin: 0;">Layanan Barbershop Kami</h1>
        <p style="color: #ccc; margin-top: 0.5rem;">Pilih layanan terbaik sesuai kebutuhan Anda</p>
    </div>
</section>

<div class="container mb-5">
    <div class="row g-4">
        @forelse($services as $service)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100" style="border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 40px rgba(212, 175, 55, 0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 20px rgba(0,0,0,0.1)'">
                    <div style="position: relative; height: 200px; overflow: hidden; border-radius: 15px 15px 0 0;">
                        <img src="{{ $service->image_url ?? 'https://via.placeholder.com/300x200?text=' . urlencode($service->name) }}" class="img-fluid" alt="{{ $service->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; top: 10px; right: 10px; background: #d4af37; color: #1a1a1a; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600; font-size: 0.9rem;">
                            Rp {{ number_format($service->price, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" style="color: #1a1a1a; font-weight: 700; font-size: 1.3rem;">{{ $service->name }}</h5>
                        <p class="card-text text-muted" style="font-size: 0.95rem; line-height: 1.6;">{{ $service->description }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                            <small style="color: #999;"><i class="fas fa-clock me-2"></i>{{ $service->duration }} menit</small>
                            <small style="color: #999;"><i class="fas fa-check-circle me-1" style="color: #d4af37;"></i>Tersedia</small>
                        </div>
                        <a href="{{ route('services.show', $service) }}" class="btn btn-primary w-100">
                            <i class="fas fa-arrow-right me-2"></i>Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-inbox" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block;"></i>
                <p style="color: #999; font-size: 1.1rem;">Tidak ada layanan yang tersedia</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($services->hasPages())
        <div class="mt-5 d-flex justify-content-center">
            {{ $services->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection