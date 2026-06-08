@extends('layouts.app')

@section('title', 'Ajukan Konsultasi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h2 class="fw-bold mb-1">Ajukan Konsultasi</h2>
                    <div class="text-muted">Upload foto selfie (wajah jelas) agar admin bisa rekomendasikan model.</div>
                </div>
                <a class="btn btn-outline-dark" href="{{ route('consultations.index') }}">Kembali</a>
            </div>

            @if ($errors->any())
                <div class="alert alert-error" role="alert">
                    <div class="fw-semibold mb-1">Periksa input kamu:</div>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('consultations.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="selfie" class="form-label fw-semibold">Foto selfie</label>
                            <input class="form-control" type="file" id="selfie" name="selfie" accept="image/*" required>
                            <div class="form-text">Maks 5MB. Format JPG/PNG disarankan.</div>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label fw-semibold">Catatan (opsional)</label>
                            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Contoh: Mau rapi untuk kerja, wajah agak bulat, rambut mudah lepek, dll.">{{ old('message') }}</textarea>
                        </div>

                        <button class="btn btn-primary w-100" type="submit">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Konsultasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

