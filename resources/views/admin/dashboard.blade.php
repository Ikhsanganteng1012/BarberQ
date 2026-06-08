@extends('layouts.admin')

@section('title', 'Beranda')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Dashboard</h4>
        <div class="text-muted">Halo, {{ auth()->user()->name }}.</div>
    </div>
</div>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="fw-semibold mb-1"><i class="fas fa-users text-primary me-2"></i>User &amp; Customer</div>
                <p class="text-muted small mb-3">Kelola akun, role, dan status aktif.</p>
                <a class="btn btn-sm btn-primary" href="{{ route('admin.users.index') }}">Data User</a>
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.users.index', ['customers' => 1]) }}">Customer</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="fw-semibold mb-1"><i class="fas fa-images text-primary me-2"></i>Katalog</div>
                <p class="text-muted small mb-3">Galeri potongan &amp; model rambut.</p>
                <a class="btn btn-sm btn-primary" href="{{ route('admin.galleries.index') }}">Galeri</a>
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.hair-styles.index') }}">Model Rambut</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="fw-semibold mb-1"><i class="fas fa-concierge-bell text-primary me-2"></i>Layanan &amp; Ulasan</div>
                <p class="text-muted small mb-3">Harga, durasi, dan moderasi testimoni.</p>
                <a class="btn btn-sm btn-primary" href="{{ route('admin.services.index') }}">Layanan</a>
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.testimonials.index') }}">Testimoni</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="fw-semibold mb-1"><i class="fas fa-calendar-check text-primary me-2"></i>Transaksi</div>
                <p class="text-muted small mb-3">Booking, QRIS/transfer, barcode antrian.</p>
                <a class="btn btn-sm btn-primary" href="{{ route('admin.bookings.index') }}">Transaksi Booking</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="fw-semibold mb-1"><i class="fas fa-chart-bar text-primary me-2"></i>Laporan</div>
                <p class="text-muted small mb-3">Ringkasan booking dan pendapatan tercatat.</p>
                <a class="btn btn-sm btn-primary" href="{{ route('admin.reports.index') }}">Buka Laporan</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="fw-semibold mb-1"><i class="fas fa-comments text-primary me-2"></i>Konsultasi</div>
                <p class="text-muted small mb-3">Balasan rekomendasi model rambut.</p>
                <a class="btn btn-sm btn-primary" href="{{ route('admin.consultations.index') }}">Konsultasi</a>
            </div>
        </div>
    </div>
</div>
@endsection
