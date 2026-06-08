@extends('layouts.app')

@section('title', 'Galeri Kami')

@section('content')
<!-- Header -->
<section style="background: linear-gradient(135deg, #1a1a1a 0%, #333 100%); color: #fff; padding: 4rem 0; margin-bottom: 3rem;">
    <div class="container">
        <h1 style="font-size: 2.5rem; font-weight: 700; margin: 0;">Galeri Karya Kami</h1>
        <p style="color: #ccc; margin-top: 0.5rem;">Hasil karya profesional dari tim barber berpengalaman</p>
    </div>
</section>

<div class="container mb-5">
    <div class="row g-4">
        @forelse($galleries as $gallery)
            <div class="col-md-6 col-lg-3">
                <div style="position: relative; overflow: hidden; border-radius: 15px; height: 300px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#galleryModal"
                     onclick="setGalleryImage(@json($gallery->image_url), @json($gallery->title), @json($gallery->description ?? ''))">
                    <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: all 0.3s ease;" class="gallery-img">
                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(26, 26, 26, 0.7); display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0; transition: all 0.3s ease;" class="gallery-overlay">
                        <i class="fas fa-search" style="font-size: 2rem; color: #d4af37; margin-bottom: 1rem;"></i>
                        <h6 style="color: #fff; font-weight: 700; margin-bottom: 0.5rem;">{{ $gallery->title }}</h6>
                        <p style="color: #ccc; font-size: 0.85rem; text-align: center; margin: 0; padding: 0 1rem;">Klik untuk melihat detail</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-image" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block;"></i>
                <p style="color: #999; font-size: 1.1rem;">Galeri belum tersedia</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($galleries->hasPages())
        <div class="mt-5 d-flex justify-content-center">
            {{ $galleries->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<!-- Gallery Modal -->
<div class="modal fade" id="galleryModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 15px;">
            <button type="button" class="btn-close" data-bs-dismiss="modal" style="position: absolute; top: 1rem; right: 1rem; z-index: 10;"></button>
            <div class="modal-body p-0">
                <img id="modalImage" src="" alt="" style="width: 100%; border-radius: 15px 15px 0 0;">
            </div>
            <div class="modal-body pt-3">
                <h5 id="modalTitle" style="font-weight: 700; color: #1a1a1a; margin-bottom: 1rem;"></h5>
                <p id="modalDescription" style="color: #666; line-height: 1.6;"></p>
            </div>
        </div>
    </div>
</div>

<style>
    .gallery-img {
        transition: transform 0.3s ease;
    }
    
    .gallery-img:hover {
        transform: scale(1.1);
    }
    
    [data-bs-toggle="modal"]:hover .gallery-overlay {
        opacity: 1 !important;
    }
</style>

<script>
    function setGalleryImage(image, title, description) {
        document.getElementById('modalImage').src = image;
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalDescription').textContent = description;
    }
</script>
@endsection