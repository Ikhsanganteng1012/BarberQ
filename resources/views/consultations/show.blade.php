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
</div>
@endsection

