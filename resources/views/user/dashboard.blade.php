@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Dashboard</h2>
            <div class="text-muted">Halo, {{ auth()->user()->name }}.</div>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-dark" href="{{ route('bookings.my') }}">
                <i class="fas fa-calendar-check me-2"></i>Booking Saya
            </a>
            <a class="btn btn-primary" href="{{ route('booking.index') }}">
                <i class="fas fa-plus me-2"></i>Buat Booking
            </a>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="fw-semibold mb-1">Butuh saran model rambut?</div>
                    <div class="text-muted mb-3">Kirim selfie dan ceritakan preferensimu. Admin akan memberi rekomendasi.</div>
                    <a class="btn btn-primary" href="{{ route('consultations.create') }}">
                        Mulai Konsultasi
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="fw-semibold mb-1">Kelola akun</div>
                    <div class="text-muted mb-3">Ubah nama, email, dan password akun Anda.</div>
                    <a class="btn btn-outline-dark" href="{{ route('user.profile') }}">
                        <i class="fas fa-user-cog me-2"></i>Pengaturan Akun
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

