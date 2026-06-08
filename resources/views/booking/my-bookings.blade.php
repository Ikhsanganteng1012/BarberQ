@extends('layouts.app')

@section('title', 'Booking Saya')

@section('content')
<!-- Header -->
<section style="background: linear-gradient(135deg, #1a1a1a 0%, #333 100%); color: #fff; padding: 4rem 0; margin-bottom: 3rem;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin: 0;">Booking Saya</h1>
        <p style="color: #ccc; margin-top: 0.5rem;">Kelola semua booking Anda di sini</p>
    </div>
</section>

<div class="container mb-5">
    @forelse($bookings as $booking)
        <div class="card mb-3" style="border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 style="color: #1a1a1a; font-weight: 700; margin-bottom: 0.5rem;">{{ $booking->service->name }}</h5>
                        <p style="color: #666; margin-bottom: 0.5rem;">
                            <i class="fas fa-calendar me-2"></i>{{ $booking->booking_date->format('d M Y') }} - {{ date('H:i', strtotime($booking->booking_time)) }} WIB
                        </p>
                        <p style="color: #999; margin: 0;">
                            @if($booking->queue_code)
                                <i class="fas fa-barcode me-2"></i><span class="font-monospace fw-semibold">{{ $booking->queue_code }}</span>
                            @else
                                <i class="fas fa-clock me-2"></i><span class="text-muted">Barcode tersedia setelah pembayaran</span>
                            @endif
                        </p>
                        <a class="btn btn-sm btn-outline-dark mt-2" href="{{ \Illuminate\Support\Facades\URL::temporarySignedRoute('booking.confirmation', now()->addDays(7), ['booking' => $booking]) }}">
                            <i class="fas fa-{{ $booking->payment_status === 'paid' ? 'qrcode' : 'credit-card' }} me-1"></i>
                            {{ $booking->payment_status === 'paid' ? 'Lihat barcode' : 'Bayar & dapatkan barcode' }}
                        </a>
                    </div>
                    <div class="col-md-4 text-end">
                        <div style="margin-bottom: 1rem;">
                            @if($booking->status === 'pending')
                                <span class="badge" style="background-color: #ffc107; color: #000;">
                                    <i class="fas fa-clock me-1"></i>Menunggu Konfirmasi
                                </span>
                            @elseif($booking->status === 'confirmed')
                                <span class="badge" style="background-color: #198754; color: #fff;">
                                    <i class="fas fa-check-circle me-1"></i>Dikonfirmasi
                                </span>
                            @elseif($booking->status === 'completed')
                                <span class="badge" style="background-color: #6c757d; color: #fff;">
                                    <i class="fas fa-check-double me-1"></i>Selesai
                                </span>
                            @else
                                <span class="badge" style="background-color: #dc3545; color: #fff;">
                                    <i class="fas fa-times-circle me-1"></i>Dibatalkan
                                </span>
                            @endif
                        </div>
                        <p style="color: #d4af37; font-weight: 700; font-size: 1.2rem; margin: 0;">
                            Rp {{ number_format($booking->amount ?? $booking->service->price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="fas fa-inbox" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block;"></i>
            <p style="color: #999; font-size: 1.1rem; margin-bottom: 2rem;">Anda belum memiliki booking</p>
            <a href="{{ route('booking.index') }}" class="btn btn-primary">
                <i class="fas fa-calendar-alt me-2"></i>Buat Booking Baru
            </a>
        </div>
    @endforelse

    <!-- Pagination -->
    @if($bookings->hasPages())
        <div class="mt-5 d-flex justify-content-center">
            {{ $bookings->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection