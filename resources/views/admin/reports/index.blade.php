@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<h4 class="fw-bold mb-4">Laporan ringkas</h4>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Total booking</div>
                <div class="fs-3 fw-bold">{{ $bookingTotal }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Booking lunas</div>
                <div class="fs-3 fw-bold text-success">{{ $bookingPaid }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Pendapatan tercatat (lunas)</div>
                <div class="fs-3 fw-bold text-primary">Rp {{ number_format($revenue, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Jumlah customer (non-admin)</div>
                <div class="fs-3 fw-bold">{{ $usersCount }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Layanan aktif</div>
                <div class="fs-3 fw-bold">{{ $servicesCount }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="text-muted small">Testimoni menunggu moderasi</div>
                <div class="fs-3 fw-bold text-warning">{{ $testimonialsPending }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
