@extends('layouts.app')

@section('title', 'Booking Layanan')

@section('content')
<!-- Header -->
<section style="background: linear-gradient(135deg, #1a1a1a 0%, #333 100%); color: #fff; padding: 4rem 0; margin-bottom: 3rem;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin: 0;">Booking Layanan</h1>
        <p style="color: #ccc; margin-top: 0.5rem;">Pesan layanan favorit Anda sekarang</p>
    </div>
</section>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card" style="border: none; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                <div class="card-body p-4">
                    <h3 style="color: #1a1a1a; font-weight: 700; margin-bottom: 2rem;">
                        <i class="fas fa-calendar-alt me-2" style="color: #d4af37;"></i>Form Booking
                    </h3>

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4" role="alert">
                            <div class="fw-semibold mb-1">Periksa kembali data berikut:</div>
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($services->isEmpty())
                        <div class="alert alert-warning mb-0">
                            Belum ada layanan aktif. Silakan hubungi admin atau coba lagi nanti.
                        </div>
                    @else
                    <form action="{{ route('booking.store') }}" method="POST" id="bookingForm">
                        @csrf

                        <!-- Service Selection -->
                        <div class="mb-4">
                            <label for="service_id" class="form-label" style="font-weight: 600; color: #1a1a1a;">
                                <i class="fas fa-cut me-2" style="color: #d4af37;"></i>Pilih Layanan
                            </label>
                            <select class="form-select @error('service_id') is-invalid @enderror" id="service_id" name="service_id" required style="border-radius: 8px; padding: 0.75rem; border: 2px solid #e0e0e0;">
                                <option value="">-- Pilih Layanan --</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-duration="{{ $service->duration }}">
                                        {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }} ({{ $service->duration }} min)
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Service Details -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px;">
                                    <small style="color: #999; display: block; margin-bottom: 0.5rem;">LAYANAN DIPILIH</small>
                                    <h5 id="serviceName" style="color: #1a1a1a; font-weight: 700; margin: 0; font-size: 1rem;">—</h5>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px;">
                                    <small style="color: #999; display: block; margin-bottom: 0.5rem;">HARGA POTONG RAMBUT</small>
                                    <h4 id="servicePrice" style="color: #d4af37; font-weight: 700; margin: 0;">Rp 0</h4>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px;">
                                    <small style="color: #999; display: block; margin-bottom: 0.5rem;">DURASI</small>
                                    <h4 id="serviceDuration" style="color: #1a1a1a; font-weight: 700; margin: 0;">0 menit</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label" style="font-weight: 600; color: #1a1a1a;">
                                <i class="fas fa-user me-2" style="color: #d4af37;"></i>Nama Lengkap
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama Anda" required style="border-radius: 8px; padding: 0.75rem; border: 2px solid #e0e0e0;" value="{{ $prefill['name'] }}">
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label" style="font-weight: 600; color: #1a1a1a;">
                                <i class="fas fa-envelope me-2" style="color: #d4af37;"></i>Email
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email Anda" required style="border-radius: 8px; padding: 0.75rem; border: 2px solid #e0e0e0;" value="{{ $prefill['email'] }}">
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label" style="font-weight: 600; color: #1a1a1a;">
                                <i class="fas fa-phone me-2" style="color: #d4af37;"></i>Nomor Telepon
                            </label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Contoh: 08123456789" required style="border-radius: 8px; padding: 0.75rem; border: 2px solid #e0e0e0;" value="{{ $prefill['phone'] }}">
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date -->
                        <div class="mb-3">
                            <label for="booking_date" class="form-label" style="font-weight: 600; color: #1a1a1a;">
                                <i class="fas fa-calendar me-2" style="color: #d4af37;"></i>Tanggal Booking
                            </label>
                            <input type="date" class="form-control @error('booking_date') is-invalid @enderror" id="booking_date" name="booking_date" required style="border-radius: 8px; padding: 0.75rem; border: 2px solid #e0e0e0;" value="{{ old('booking_date') }}">
                            @error('booking_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Time -->
                        <div class="mb-3">
                            <label for="booking_time" class="form-label" style="font-weight: 600; color: #1a1a1a;">
                                <i class="fas fa-clock me-2" style="color: #d4af37;"></i>Waktu Booking
                            </label>
                            <input type="time" class="form-control @error('booking_time') is-invalid @enderror" id="booking_time" name="booking_time" required style="border-radius: 8px; padding: 0.75rem; border: 2px solid #e0e0e0;" value="{{ old('booking_time') }}">
                            <small style="color: #999; display: block; margin-top: 0.5rem;">Jam operasional: 09:00 - 21:00</small>
                            @error('booking_time')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="form-label" style="font-weight: 600; color: #1a1a1a;">
                                <i class="fas fa-sticky-note me-2" style="color: #d4af37;"></i>Catatan Tambahan (Opsional)
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Contoh: Potong pendek, harap tidak terlalu pendek, dll" style="border-radius: 8px; padding: 0.75rem; border: 2px solid #e0e0e0;">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Terms -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required style="border: 2px solid #e0e0e0;">
                                <label class="form-check-label" for="terms" style="color: #666; margin-top: 0.25rem;">
                                    Saya setuju dengan syarat dan ketentuan booking
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 btn-lg" style="border-radius: 8px;">
                            <i class="fas fa-check-circle me-2"></i>Konfirmasi Booking
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <!-- Info Section -->
            <div style="margin-top: 3rem;">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div style="text-align: center;">
                            <i class="fas fa-check-circle" style="font-size: 2.5rem; color: #d4af37; margin-bottom: 1rem; display: block;"></i>
                            <h5 style="font-weight: 700; color: #1a1a1a; margin-bottom: 0.5rem;">Instan</h5>
                            <p style="color: #666; font-size: 0.9rem;">Konfirmasi booking langsung setelah submit</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="text-align: center;">
                            <i class="fas fa-lock" style="font-size: 2.5rem; color: #d4af37; margin-bottom: 1rem; display: block;"></i>
                            <h5 style="font-weight: 700; color: #1a1a1a; margin-bottom: 0.5rem;">Aman</h5>
                            <p style="color: #666; font-size: 0.9rem;">Data Anda terlindungi dan tidak dipublikasikan</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="text-align: center;">
                            <i class="fas fa-headset" style="font-size: 2.5rem; color: #d4af37; margin-bottom: 1rem; display: block;"></i>
                            <h5 style="font-weight: 700; color: #1a1a1a; margin-bottom: 0.5rem;">Dukungan</h5>
                            <p style="color: #666; font-size: 0.9rem;">Tim kami siap membantu 24/7</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!$services->isEmpty())
<script>
    (function () {
        var sel = document.getElementById('service_id');
        var nameEl = document.getElementById('serviceName');
        var priceEl = document.getElementById('servicePrice');
        var durEl = document.getElementById('serviceDuration');
        var dateEl = document.getElementById('booking_date');
        if (!sel || !nameEl || !priceEl || !durEl || !dateEl) return;

        function refresh() {
            var opt = sel.options[sel.selectedIndex];
            var price = opt.getAttribute('data-price') || '0';
            var duration = opt.getAttribute('data-duration') || '0';
            var p = parseFloat(price) || 0;
            nameEl.textContent = opt.value ? opt.textContent.split(' - ')[0] : '—';
            priceEl.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(p);
            durEl.textContent = duration + ' menit';
        }
        sel.addEventListener('change', refresh);
        refresh();

        var today = new Date().toISOString().split('T')[0];
        dateEl.setAttribute('min', today);
    })();
</script>
@endif
@endsection