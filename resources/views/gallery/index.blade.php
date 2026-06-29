@extends('layouts.app')

@section('title', 'Galeri Kami')

@section('styles')
<style>
    .gallery-hero {
        position: relative;
        background: linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 50%, #2a2a2a 100%);
        color: #fff;
        padding: 5rem 0 4rem;
        margin-bottom: 3rem;
        overflow: hidden;
    }

    .gallery-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 600px 400px at 20% 30%, rgba(212,175,55,0.12), transparent),
            radial-gradient(ellipse 500px 350px at 80% 70%, rgba(212,175,55,0.08), transparent);
        pointer-events: none;
    }

    .gallery-hero-content {
        position: relative;
        z-index: 1;
    }

    .gallery-hero h1 {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 800;
        margin-bottom: 0.75rem;
        letter-spacing: -0.5px;
    }

    .gallery-hero p {
        color: rgba(255,255,255,0.7);
        font-size: 1.1rem;
        max-width: 540px;
        margin: 0;
    }

    .gallery-stats {
        display: flex;
        gap: 2rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .gallery-stat {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .gallery-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(212,175,55,0.15);
        border: 1px solid rgba(212,175,55,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #d4af37;
        font-size: 1.1rem;
    }

    .gallery-stat-value {
        font-size: 1.4rem;
        font-weight: 700;
        line-height: 1;
        color: #fff;
    }

    .gallery-stat-label {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.55);
        margin-top: 2px;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .gallery-card {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        cursor: pointer;
        background: #1a1a1a;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: transform 0.35s cubic-bezier(.2,.8,.2,1), box-shadow 0.35s ease;
        aspect-ratio: 4/5;
    }

    .gallery-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.18);
    }

    .gallery-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(.2,.8,.2,1);
        display: block;
    }

    .gallery-card:hover img {
        transform: scale(1.08);
    }

    .gallery-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to top,
            rgba(10,10,10,0.92) 0%,
            rgba(10,10,10,0.4) 40%,
            transparent 70%
        );
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 1.25rem;
        opacity: 0;
        transition: opacity 0.35s ease;
    }

    .gallery-card:hover .gallery-card-overlay {
        opacity: 1;
    }

    .gallery-card-title {
        color: #fff;
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 0.35rem;
        transform: translateY(8px);
        transition: transform 0.35s ease;
    }

    .gallery-card-desc {
        color: rgba(255,255,255,0.75);
        font-size: 0.85rem;
        line-height: 1.5;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transform: translateY(8px);
        transition: transform 0.35s ease 0.05s;
    }

    .gallery-card:hover .gallery-card-title,
    .gallery-card:hover .gallery-card-desc {
        transform: translateY(0);
    }

    .gallery-card-zoom {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(212,175,55,0.9);
        color: #111;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.3s ease;
    }

    .gallery-card:hover .gallery-card-zoom {
        opacity: 1;
        transform: scale(1);
    }

    .gallery-empty {
        text-align: center;
        padding: 5rem 2rem;
        background: #f8f9fa;
        border-radius: 20px;
        border: 2px dashed #e0e0e0;
    }

    .gallery-empty i {
        font-size: 3.5rem;
        color: #d4af37;
        opacity: 0.5;
        margin-bottom: 1.25rem;
        display: block;
    }

    .gallery-pagination {
        margin-top: 3rem;
    }

    .gallery-pagination .pagination {
        gap: 6px;
    }

    .gallery-pagination .page-link {
        border-radius: 10px !important;
        border: none;
        padding: 0.6rem 1rem;
        color: #1a1a1a;
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .gallery-pagination .page-item.active .page-link {
        background: #1a1a1a;
        color: #d4af37;
    }

    /* Lightbox Modal */
    .gallery-lightbox .modal-content {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        background: #111;
    }

    .gallery-lightbox .modal-body-image {
        position: relative;
        background: #0a0a0a;
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gallery-lightbox .modal-body-image img {
        max-width: 100%;
        max-height: 65vh;
        object-fit: contain;
        display: block;
    }

    .gallery-lightbox .modal-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.2);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.25s ease;
        backdrop-filter: blur(8px);
        z-index: 5;
    }

    .gallery-lightbox .modal-nav:hover {
        background: rgba(212,175,55,0.85);
        color: #111;
        border-color: #d4af37;
    }

    .gallery-lightbox .modal-nav.prev { left: 1rem; }
    .gallery-lightbox .modal-nav.next { right: 1rem; }

    .gallery-lightbox .modal-close-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: 10;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.15);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .gallery-lightbox .modal-close-btn:hover {
        background: rgba(220,53,69,0.8);
    }

    .gallery-lightbox .modal-info {
        padding: 1.5rem 2rem 2rem;
        color: #fff;
    }

    .gallery-lightbox .modal-info h5 {
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        color: #fff;
    }

    .gallery-lightbox .modal-info p {
        color: rgba(255,255,255,0.65);
        line-height: 1.7;
        margin: 0;
        font-size: 0.95rem;
    }

    .gallery-lightbox .modal-counter {
        color: rgba(255,255,255,0.45);
        font-size: 0.85rem;
        margin-top: 1rem;
    }

    .gallery-lightbox .modal-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(212,175,55,0.15);
        border: 1px solid rgba(212,175,55,0.3);
        color: #d4af37;
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        margin-bottom: 0.75rem;
    }

    @media (max-width: 576px) {
        .gallery-grid {
            grid-template-columns: 1fr;
        }

        .gallery-stats {
            gap: 1.25rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Header -->
<section class="gallery-hero">
    <div class="container gallery-hero-content">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <h1>Galeri Karya Kami</h1>
                <p>Hasil karya profesional dari tim barber berpengalaman — setiap potongan adalah seni.</p>
                <div class="gallery-stats">
                    <div class="gallery-stat">
                        <div class="gallery-stat-icon"><i class="fas fa-images"></i></div>
                        <div>
                            <div class="gallery-stat-value">{{ $galleries->total() }}</div>
                            <div class="gallery-stat-label">Total Karya</div>
                        </div>
                    </div>
                    <div class="gallery-stat">
                        <div class="gallery-stat-icon"><i class="fas fa-cut"></i></div>
                        <div>
                            <div class="gallery-stat-value">Pro</div>
                            <div class="gallery-stat-label">Barber Team</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container mb-5">
    @if($galleries->count() > 0)
        <div class="gallery-grid" id="galleryGrid">
            @foreach($galleries as $gallery)
                <div class="gallery-card"
                     data-index="{{ $loop->index }}"
                     onclick="openGallery({{ $loop->index }})">
                    <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" loading="lazy">
                    <div class="gallery-card-zoom"><i class="fas fa-expand"></i></div>
                    <div class="gallery-card-overlay">
                        <div class="gallery-card-title">{{ $gallery->title }}</div>
                        @if($gallery->description)
                            <p class="gallery-card-desc">{{ $gallery->description }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="gallery-empty">
            <i class="fas fa-image"></i>
            <h4 style="color: #555; font-weight: 600;">Galeri Belum Tersedia</h4>
            <p style="color: #999; margin-top: 0.5rem;">Karya terbaru dari tim kami akan segera ditampilkan di sini.</p>
        </div>
    @endif

    @if($galleries->hasPages())
        <div class="gallery-pagination d-flex justify-content-center">
            {{ $galleries->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<!-- Lightbox Modal -->
<div class="modal fade gallery-lightbox" id="galleryModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="modal-body-image">
                    <button type="button" class="modal-close-btn" data-bs-dismiss="modal" aria-label="Tutup">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="button" class="modal-nav prev" onclick="navigateGallery(-1)" aria-label="Sebelumnya">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <img id="modalImage" src="" alt="">
                    <button type="button" class="modal-nav next" onclick="navigateGallery(1)" aria-label="Selanjutnya">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="modal-info">
                    <div class="modal-badge"><i class="fas fa-cut"></i> BarberShop</div>
                    <h5 id="modalTitle"></h5>
                    <p id="modalDescription"></p>
                    <div class="modal-counter" id="modalCounter"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const galleryItems = @json($galleryItems);

    let currentIndex = 0;
    let galleryModal = null;

    document.addEventListener('DOMContentLoaded', function () {
        galleryModal = new bootstrap.Modal(document.getElementById('galleryModal'));

        document.getElementById('galleryModal').addEventListener('keydown', function (e) {
            if (e.key === 'ArrowLeft') navigateGallery(-1);
            if (e.key === 'ArrowRight') navigateGallery(1);
            if (e.key === 'Escape') galleryModal.hide();
        });
    });

    function openGallery(index) {
        currentIndex = index;
        updateModal();
        galleryModal.show();
    }

    function navigateGallery(direction) {
        currentIndex = (currentIndex + direction + galleryItems.length) % galleryItems.length;
        updateModal();
    }

    function updateModal() {
        const item = galleryItems[currentIndex];
        document.getElementById('modalImage').src = item.image;
        document.getElementById('modalImage').alt = item.title;
        document.getElementById('modalTitle').textContent = item.title;
        document.getElementById('modalDescription').textContent =
            item.description || 'Hasil karya profesional dari tim barber kami dengan teknik modern dan pelayanan terbaik.';
        document.getElementById('modalCounter').textContent =
            (currentIndex + 1) + ' / ' + galleryItems.length;
    }
</script>
@endsection
