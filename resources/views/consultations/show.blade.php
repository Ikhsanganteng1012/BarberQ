@extends('layouts.app')

@section('title', 'Detail Konsultasi')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail Konsultasi #{{ $consultation->id }}</h2>
            <div class="text-muted">
                Status:
                <span class="fw-semibold">{{ strtoupper($consultation->status) }}</span>
            </div>
        </div>
        <a class="btn btn-outline-dark" href="{{ route('consultations.index') }}">Kembali</a>
    </div>

    <div class="row g-3">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="fw-semibold mb-2">Selfie</div>
                    <img class="img-fluid rounded" src="{{ asset('storage/'.$consultation->selfie_path) }}" alt="Selfie">
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <div class="fw-semibold mb-2">Pesan kamu</div>
                    <div class="text-muted" style="white-space: pre-wrap;">{{ $consultation->user_message ?? '-' }}</div>
                    <div class="text-muted small mt-3">Diajukan: {{ $consultation->created_at->format('d M Y H:i') }}</div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="fw-semibold mb-2">Balasan admin</div>
                    @if($consultation->admin_message)
                        <div class="text-muted" style="white-space: pre-wrap;">{{ $consultation->admin_message }}</div>
                        <div class="mt-3">
                            <div class="text-muted small">Admin: {{ $consultation->admin?->name ?? '-' }}</div>
                            @if($consultation->recommendedHairStyle)
                                <div class="text-muted small">
                                    Rekomendasi model:
                                    <span class="fw-semibold">{{ $consultation->recommendedHairStyle->name }}</span>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-muted">Belum ada balasan. Silakan tunggu.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($consultation->admin_message)
        <div class="consultation-booking-cta mt-4">
            <div class="consultation-booking-cta-inner">
                @if($consultation->recommendedHairStyle)
                    <div class="consultation-booking-cta-info">
                        <div class="consultation-booking-cta-label">Model Rekomendasi Admin</div>
                        <div class="consultation-booking-cta-model">{{ $consultation->recommendedHairStyle->name }}</div>
                        @if($consultation->recommendedHairStyle->description)
                            <p class="consultation-booking-cta-desc">{{ $consultation->recommendedHairStyle->description }}</p>
                        @endif
                    </div>
                @else
                    <div class="consultation-booking-cta-info">
                        <div class="consultation-booking-cta-label">Rekomendasi Admin Siap</div>
                        <p class="consultation-booking-cta-desc mb-0">Gunakan saran dari admin untuk langsung booking jadwal potong rambut.</p>
                    </div>
                @endif

                <a href="{{ route('booking.index', ['consultation' => $consultation->id]) }}" class="btn-booking-shortcut">
                    <i class="fas fa-calendar-check"></i>
                    <span>Gunakan Model Ini &amp; Booking Jadwal</span>
                </a>
            </div>
        </div>
    @endif
</div>

<style>
    .consultation-booking-cta {
        background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 12px 40px rgba(0,0,0,0.15);
    }

    .consultation-booking-cta-inner {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
    }

    .consultation-booking-cta-label {
        color: #d4af37;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 0.35rem;
    }

    .consultation-booking-cta-model {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.35rem;
    }

    .consultation-booking-cta-desc {
        color: rgba(255,255,255,0.65);
        font-size: 0.95rem;
        margin: 0;
        max-width: 520px;
        line-height: 1.6;
    }

    .btn-booking-shortcut {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #d4af37 0%, #f0c955 50%, #b8891b 100%);
        background-size: 200% 200%;
        color: #111;
        font-weight: 700;
        font-size: 1.05rem;
        border-radius: 14px;
        text-decoration: none;
        box-shadow: 0 10px 30px rgba(212,175,55,0.35);
        transition: all 0.35s ease;
        white-space: nowrap;
    }

    .btn-booking-shortcut:hover {
        color: #111;
        transform: translateY(-3px);
        box-shadow: 0 14px 36px rgba(212,175,55,0.5);
        background-position: 100% 0;
    }

    @media (max-width: 768px) {
        .btn-booking-shortcut {
            width: 100%;
            white-space: normal;
            text-align: center;
        }
    }
</style>
@endsection

