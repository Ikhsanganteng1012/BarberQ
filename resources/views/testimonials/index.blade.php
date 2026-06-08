@extends('layouts.app')

@section('title', 'Testimoni Pelanggan')

@section('content')
<section style="background: linear-gradient(135deg, #1a1a1a 0%, #333 100%); color: #fff; padding: 4rem 0; margin-bottom: 3rem;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin: 0;">Testimoni Pelanggan Kami</h1>
        <p style="color: #ccc; margin-top: 0.5rem;">Dengarkan pengalaman pelanggan setia kami</p>
    </div>
</section>

<div class="container mb-5">
    <div class="row g-4">
        @forelse($testimonials as $testimonial)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100" style="border: none; border-left: 5px solid #d4af37; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
                    <div class="card-body">
                        <div style="margin-bottom: 1rem;">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $testimonial->rating)
                                    <i class="fas fa-star" style="color: #d4af37;"></i>
                                @else
                                    <i class="far fa-star" style="color: #ddd;"></i>
                                @endif
                            @endfor
                        </div>

                        <p class="card-text text-muted" style="font-size: 1rem; line-height: 1.6; margin-bottom: 1.5rem; font-style: italic;">
                            "{{ $testimonial->message }}"
                        </p>

                        <div style="display: flex; align-items: center; padding-top: 1rem; border-top: 1px solid #e0e0e0;">
                            <img src="{{ $testimonial->image_url ?? 'https://ui-avatars.com/api/?name='.urlencode($testimonial->name).'&background=d4af37&color=1a1a1a' }}"
                                 alt="{{ $testimonial->name }}"
                                 style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; margin-right: 1rem;">
                            <div>
                                <h6 class="mb-0" style="font-weight: 700; color: #1a1a1a;">{{ $testimonial->name }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-comment-dots" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block;"></i>
                <p style="color: #999; font-size: 1.1rem;">Belum ada testimoni yang disetujui</p>
            </div>
        @endforelse
    </div>

    @if($testimonials->hasPages())
        <div class="mt-5 d-flex justify-content-center">
            {{ $testimonials->links('pagination::bootstrap-5') }}
        </div>
    @endif

    @auth
    <section style="margin-top: 5rem; padding: 3rem; background: #f8f9fa; border-radius: 15px;">
        <h3 style="font-size: 1.8rem; font-weight: 700; color: #1a1a1a; margin-bottom: 0.5rem; text-align: center;">
            <i class="fas fa-pen-fancy me-2" style="color: #d4af37;"></i>Bagikan Pengalaman Anda
        </h3>
        <p class="text-muted text-center mb-4 small">Testimoni akan ditinjau admin sebelum ditampilkan di halaman ini.</p>

        <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data" style="max-width: 600px; margin: 0 auto;">
            @csrf

            <div class="mb-4 text-center">
                <label class="form-label fw-semibold d-block mb-2">Rating Bintang</label>
                <div class="star-rating d-inline-flex gap-1" style="font-size: 2rem;">
                    @for($s = 1; $s <= 5; $s++)
                        <label class="mb-0" style="cursor: pointer;">
                            <input type="radio" name="rating" value="{{ $s }}" class="d-none star-input" {{ (int) old('rating', 5) === $s ? 'checked' : '' }} {{ $s === 5 ? 'required' : '' }}>
                            <i class="fas fa-star star-icon" data-value="{{ $s }}" style="color: {{ (int) old('rating', 5) >= $s ? '#d4af37' : '#ddd' }};"></i>
                        </label>
                    @endfor
                </div>
                @error('rating')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="message" class="form-label fw-semibold">Pengalaman Anda</label>
                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="4"
                          placeholder="Ceritakan pengalaman layanan barbershop kami..." required>{{ old('message') }}</textarea>
                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label fw-semibold">Foto Profil (opsional)</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="p-3 bg-white rounded border mb-3 small text-muted">
                <i class="fas fa-user me-1"></i> {{ auth()->user()->name }} · {{ auth()->user()->email }}
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-paper-plane me-2"></i>Kirim Testimoni
            </button>
        </form>
    </section>
    @else
    <section style="margin-top: 5rem; padding: 2rem; background: #f8f9fa; border-radius: 15px; text-align: center;">
        <p class="text-muted mb-3">Login untuk menulis testimoni dan memberi rating bintang.</p>
        <a href="{{ route('login.index') }}" class="btn btn-primary">
            <i class="fas fa-sign-in-alt me-2"></i>Login
        </a>
    </section>
    @endauth
</div>

@auth
<script>
document.querySelectorAll('.star-input').forEach(function (input) {
    input.addEventListener('change', function () {
        var val = parseInt(this.value, 10);
        document.querySelectorAll('.star-icon').forEach(function (icon) {
            icon.style.color = parseInt(icon.dataset.value, 10) <= val ? '#d4af37' : '#ddd';
        });
    });
});
</script>
@endauth
@endsection
