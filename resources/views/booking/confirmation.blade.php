@extends('layouts.app')

@section('title', 'Konfirmasi Booking')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width:72px;height:72px;">
                    <i class="fas fa-check text-success fa-2x"></i>
                </div>
                <h1 class="fw-bold">Booking Berhasil</h1>
                @if($booking->payment_status === \App\Models\Booking::PAYMENT_PAID)
                    <p class="text-muted">Pembayaran lunas via Midtrans. Tunjukkan <strong>barcode antrian</strong> di kasir saat kedatangan.</p>
                @else
                    <p class="text-muted">Selesaikan pembayaran via Midtrans. Barcode antrian akan muncul setelah pembayaran berhasil.</p>
                @endif
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="fas fa-receipt me-2 text-warning"></i>Detail Booking</h5>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="text-muted small">LAYANAN</div>
                            <div class="fw-semibold">{{ $booking->service->name }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">HARGA POTONG RAMBUT</div>
                            <div class="fw-bold text-warning">Rp {{ number_format($booking->amount ?? $booking->service->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">TANGGAL</div>
                            <div class="fw-semibold">{{ $booking->booking_date->format('d M Y') }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">WAKTU</div>
                            <div class="fw-semibold">{{ date('H:i', strtotime($booking->booking_time)) }} WIB</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">NAMA</div>
                            <div class="fw-semibold">{{ $booking->customer_name }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">EMAIL</div>
                            <div class="fw-semibold">{{ $booking->customer_email }}</div>
                        </div>
                        @if($booking->guest_phone)
                            <div class="col-sm-6">
                                <div class="text-muted small">TELEPON</div>
                                <div class="fw-semibold">{{ $booking->guest_phone }}</div>
                            </div>
                        @endif
                        <div class="col-sm-6">
                            <div class="text-muted small">STATUS BOOKING</div>
                            <span class="badge text-bg-warning text-dark">{{ ucfirst($booking->status) }}</span>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">STATUS PEMBAYARAN</div>
                            @if($booking->payment_status === \App\Models\Booking::PAYMENT_PAID)
                                <span class="badge text-bg-success">Lunas</span>
                            @elseif($booking->transaction_status === 'pending')
                                <span class="badge text-bg-info text-dark">Menunggu Midtrans</span>
                            @else
                                <span class="badge text-bg-secondary">Belum Bayar</span>
                            @endif
                        </div>
                        @if($booking->transaction_id)
                            <div class="col-12">
                                <div class="text-muted small">ID TRANSAKSI MIDTRANS</div>
                                <div class="font-monospace small">{{ $booking->transaction_id }}</div>
                            </div>
                        @endif
                    </div>
                    @if($booking->notes)
                        <div class="mt-3 p-3 bg-light rounded small"><strong>Catatan:</strong> {{ $booking->notes }}</div>
                    @endif
                </div>
            </div>

            @if($booking->payment_status !== \App\Models\Booking::PAYMENT_PAID)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4 text-center">
                    <h5 class="fw-bold border-bottom pb-2 mb-3">
                        <i class="fas fa-credit-card me-2 text-success"></i>Pembayaran via Midtrans
                    </h5>
                    <p class="text-muted small mb-4">
                        Bayar dengan QRIS, transfer bank, e-wallet, dan metode lain melalui Midtrans Snap.
                        Setelah pembayaran berhasil, barcode antrian otomatis tersedia.
                    </p>

                    <div class="border rounded p-4 bg-light mb-4">
                        <div class="text-muted small mb-1">TOTAL BAYAR</div>
                        <div class="fs-3 fw-bold text-warning mb-0">
                            Rp {{ number_format($booking->amount ?? 0, 0, ',', '.') }}
                        </div>
                    </div>

                    <form method="POST" action="{{ $midtransPayAction }}" id="midtransPayForm">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg px-5" id="btnPayMidtrans">
                            <i class="fas fa-lock me-2"></i>Bayar Sekarang
                        </button>
                    </form>

                    <p class="text-muted small mt-3 mb-0">
                        <i class="fas fa-shield-alt me-1"></i> Pembayaran aman diproses oleh Midtrans
                    </p>
                </div>
            </div>
            @endif

            @if($booking->payment_status === \App\Models\Booking::PAYMENT_PAID && $booking->queue_code)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="fas fa-barcode me-2 text-primary"></i>Antrian &amp; Barcode</h5>
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <div class="text-muted small">KODE ANTRIAN</div>
                            <div class="fs-4 fw-bold text-primary font-monospace">{{ $booking->queue_code }}</div>
                            <div class="text-muted small mt-2">Tunjukkan barcode ini di kasir saat kedatangan.</div>
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <a class="btn btn-outline-dark btn-sm" href="{{ $printUrl }}" target="_blank" rel="noopener">
                                    <i class="fas fa-print me-1"></i> Halaman cetak barcode
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5 text-center mt-3 mt-md-0">
                            <svg id="queueBarcode" class="w-100" style="max-height:90px;"></svg>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="d-grid gap-2">
                <a href="{{ route('home') }}" class="btn btn-dark btn-lg"><i class="fas fa-home me-2"></i>Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if($booking->payment_status === \App\Models\Booking::PAYMENT_PAID && $booking->queue_code)
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    try {
        JsBarcode('#queueBarcode', @json($booking->queue_code), {
            format: 'CODE128',
            displayValue: true,
            fontSize: 14,
            height: 50,
            margin: 0
        });
    } catch (e) {
        console.warn(e);
    }
});
</script>
@endif

@if($booking->payment_status !== \App\Models\Booking::PAYMENT_PAID && session('snap_token'))
<script src="{{ $snapScriptUrl }}" data-client-key="{{ $midtransClientKey }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var token = @json(session('snap_token'));
    if (token && window.snap) {
        snap.pay(token, {
            onSuccess: function () {},
            onPending: function () {},
            onError: function () {},
            onClose: function () {}
        });
    }
});
</script>
@endif
@endsection
