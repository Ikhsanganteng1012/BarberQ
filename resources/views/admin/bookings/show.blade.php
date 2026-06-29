@extends('layouts.admin')

@section('title', 'Detail Booking')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Detail Transaksi</h4>
        <div class="text-muted font-monospace">{{ $booking->queue_code ?? 'Menunggu pembayaran' }}</div>
    </div>
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.bookings.index') }}">Kembali</a>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card border shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Barcode antrian</h6>
                @if($booking->queue_code && $booking->payment_status === \App\Models\Booking::PAYMENT_PAID)
                <div class="text-center bg-light rounded p-3">
                    <svg id="adminQueueBarcode" style="max-width:100%;"></svg>
                </div>
                <p class="small text-muted mt-2 mb-0">Barcode tersedia setelah pembayaran lunas.</p>
                @else
                <p class="small text-muted mb-0">Barcode belum tersedia — menunggu pembayaran dari pelanggan.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card border shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Ringkasan</h6>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-2"><strong>Pelanggan:</strong> {{ $booking->customer_name }} ({{ $booking->customer_email }})</li>
                    @if($booking->guest_phone)
                        <li class="mb-2"><strong>Telepon:</strong> {{ $booking->guest_phone }}</li>
                    @endif
                    <li class="mb-2"><strong>Layanan:</strong> {{ $booking->service?->name }}</li>
                    <li class="mb-2"><strong>Jadwal:</strong> {{ $booking->booking_date?->format('d M Y') }} {{ substr($booking->booking_time, 0, 5) }}</li>
                    <li class="mb-2"><strong>Total:</strong> Rp {{ number_format($booking->amount ?? 0, 0, ',', '.') }}</li>
                    <li class="mb-2"><strong>Metode:</strong>
                        @if($booking->payment_method === \App\Models\Booking::METHOD_MIDTRANS)
                            Midtrans @if($booking->payment_type) ({{ $booking->payment_type }}) @endif
                        @elseif($booking->payment_method === \App\Models\Booking::METHOD_QRIS) QRIS
                        @elseif($booking->payment_method === \App\Models\Booking::METHOD_BANK_TRANSFER) Transfer bank
                        @else —
                        @endif
                    </li>
                    @if($booking->midtrans_order_id)
                        <li class="mb-2"><strong>Order ID:</strong> <span class="font-monospace">{{ $booking->midtrans_order_id }}</span></li>
                    @endif
                    @if($booking->transaction_id)
                        <li class="mb-2"><strong>Transaction ID:</strong> <span class="font-monospace">{{ $booking->transaction_id }}</span></li>
                    @endif
                    @if($booking->transaction_status)
                        <li class="mb-2"><strong>Status Midtrans:</strong> {{ $booking->transaction_status }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card border shadow-sm mt-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Status booking</h6>
        <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="row g-2 align-items-end">
            @csrf
            <div class="col-md-4">
                <select name="status" class="form-select">
                    @foreach(['pending' => 'Menunggu', 'confirmed' => 'Dikonfirmasi', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $label)
                        <option value="{{ $val }}" @selected($booking->status === $val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Simpan status</button>
            </div>
        </form>
    </div>
</div>

<div class="card border shadow-sm mt-4">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Pembayaran Midtrans</h6>
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="text-muted small">Status pembayaran</div>
                @if($booking->payment_status === \App\Models\Booking::PAYMENT_PAID)
                    <span class="badge text-bg-success">Lunas</span>
                @else
                    <span class="badge text-bg-secondary">Belum lunas</span>
                @endif
            </div>
            @if($booking->payment_note)
                <div class="col-md-8">
                    <div class="text-muted small">Catatan</div>
                    <div class="small">{{ $booking->payment_note }}</div>
                </div>
            @endif
        </div>
        <p class="small text-muted mb-0">Pembayaran diproses otomatis via Midtrans (webhook notification).</p>
    </div>
</div>
@endsection

@section('scripts')
@if($booking->queue_code && $booking->payment_status === \App\Models\Booking::PAYMENT_PAID)
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    JsBarcode('#adminQueueBarcode', @json($booking->queue_code), {
        format: 'CODE128',
        displayValue: true,
        fontSize: 14,
        height: 56,
        margin: 8
    });
});
</script>
@endif
@endsection
