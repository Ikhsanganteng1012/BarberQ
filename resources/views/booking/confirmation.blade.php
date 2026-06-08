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
                    <p class="text-muted">Pembayaran lunas. Tunjukkan <strong>barcode antrian</strong> di kasir saat kedatangan.</p>
                @else
                    <p class="text-muted">Selesaikan pembayaran terlebih dahulu. Barcode antrian akan muncul setelah bukti pembayaran diunggah.</p>
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
                            @else
                                <span class="badge text-bg-secondary">Belum / Menunggu</span>
                            @endif
                        </div>
                    </div>
                    @if($booking->notes)
                        <div class="mt-3 p-3 bg-light rounded small"><strong>Catatan:</strong> {{ $booking->notes }}</div>
                    @endif
                </div>
            </div>

            @if($booking->payment_status !== \App\Models\Booking::PAYMENT_PAID)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold border-bottom pb-2 mb-3"><i class="fas fa-money-bill-wave me-2 text-success"></i>Pembayaran (QRIS / Transfer Bank)</h5>
                    <p class="text-muted small">Pilih metode pembayaran, lakukan transfer, lalu unggah bukti. Status pembayaran akan otomatis lunas setelah bukti diunggah.</p>

                    <form method="POST" action="{{ $paymentAction }}" class="mb-4">
                        @csrf
                        <div class="row g-2">
                            <div class="col-md-6">
                                <button type="submit" name="payment_method" value="qris" class="btn btn-outline-primary w-100 py-3 {{ $booking->payment_method === 'qris' ? 'active' : '' }}">
                                    <i class="fas fa-qrcode d-block fa-lg mb-1"></i> Bayar via QRIS
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" name="payment_method" value="bank_transfer" class="btn btn-outline-primary w-100 py-3 {{ $booking->payment_method === 'bank_transfer' ? 'active' : '' }}">
                                    <i class="fas fa-university d-block fa-lg mb-1"></i> Transfer Bank
                                </button>
                            </div>
                        </div>
                    </form>

                    @php
                        $paymentRef = $booking->queue_code ?? ('BOOKING-'.$booking->id);
                        $qrisPayload = 'BARBERSHOP|'.$paymentRef.'|'.number_format((float) ($booking->amount ?? 0), 0, '', '');
                    @endphp

                    @if($booking->payment_method === \App\Models\Booking::METHOD_QRIS)
                        <div class="border rounded p-3 bg-light">
                            <div class="fw-semibold mb-2">Pembayaran QRIS</div>
                            <p class="small text-muted mb-2">Scan menggunakan e-wallet Anda. Setelah bayar, unggah screenshot bukti pembayaran di bawah.</p>
                            @php
                                $qrisPath = public_path($barber['qris_image']);
                            @endphp
                            <div class="text-center">
                                @if(file_exists($qrisPath))
                                    <img src="{{ asset($barber['qris_image']) }}" alt="QRIS" class="img-fluid mb-2" style="max-width:220px;">
                                @else
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($qrisPayload) }}" alt="QR pembayaran" class="img-fluid mb-2">
                                @endif
                                <div class="small text-muted">{{ $qrisPayload }}</div>
                            </div>
                        </div>
                    @elseif($booking->payment_method === \App\Models\Booking::METHOD_BANK_TRANSFER)
                        <div class="border rounded p-3 bg-light">
                            <div class="fw-semibold mb-2">Transfer ke rekening</div>
                            <ul class="list-unstyled small mb-0">
                                <li><strong>Bank:</strong> {{ $barber['bank_name'] }}</li>
                                <li><strong>Atas nama:</strong> {{ $barber['bank_account_name'] }}</li>
                                <li><strong>No. rekening:</strong> <span class="font-monospace">{{ $barber['bank_account_number'] }}</span></li>
                                <li class="mt-2"><strong>Nominal:</strong> Rp {{ number_format($booking->amount ?? 0, 0, ',', '.') }}</li>
                                <li class="mt-1 text-muted">Sertakan berita transfer: <span class="font-monospace">{{ $paymentRef }}</span></li>
                            </ul>
                        </div>
                    @endif

                    <div class="border-top pt-4 mt-4">
                        <h6 class="fw-bold mb-2"><i class="fas fa-paperclip me-2"></i>Unggah bukti pembayaran</h6>
                        <p class="small text-muted mb-3">Setelah unggah bukti, status pembayaran otomatis lunas dan barcode antrian akan tersedia.</p>
                        @if($booking->payment_proof_path)
                            <div class="mb-3">
                                <span class="badge text-bg-success mb-2">Bukti sudah diunggah</span>
                                <div><img src="{{ asset('storage/'.$booking->payment_proof_path) }}" alt="Bukti" class="img-fluid rounded border" style="max-height:200px;"></div>
                            </div>
                        @endif
                        <form method="POST" action="{{ $proofAction }}" enctype="multipart/form-data" class="row g-2 align-items-end">
                            @csrf
                            <div class="col-md-8">
                                <label class="form-label small mb-0">File gambar (JPG/PNG, maks. 6 MB)</label>
                                <input type="file" name="payment_proof" class="form-control form-control-sm" accept="image/*" required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-success w-100">Unggah bukti</button>
                            </div>
                        </form>
                    </div>
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
@endsection
