@extends('layouts.admin')

@section('title', 'Edit Model Rambut')

@section('content')
<div style="max-width:720px">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h4 class="fw-bold mb-1">Edit Model Rambut</h4>
                    <div class="text-muted">Perbarui informasi model rambut.</div>
                </div>
                <a class="btn btn-outline-secondary btn-sm" href="{{ route('admin.hair-styles.index') }}">Kembali</a>
            </div>

            @if ($errors->any())
                <div class="alert alert-error" role="alert">
                    <div class="fw-semibold mb-1">Periksa input:</div>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.hair-styles.update', $hairStyle) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="name">Nama</label>
                            <input id="name" name="name" class="form-control" value="{{ old('name', $hairStyle->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="description">Deskripsi (opsional)</label>
                            <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $hairStyle->description) }}</textarea>
                        </div>

                        @if($hairStyle->image_path)
                            <div class="mb-3">
                                <div class="fw-semibold mb-2">Gambar saat ini</div>
                                <img src="{{ asset('storage/'.$hairStyle->image_path) }}" alt="" class="img-fluid rounded" style="max-height:220px;object-fit:cover;">
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="image">Ganti gambar (opsional)</label>
                            <input id="image" name="image" class="form-control" type="file" accept="image/*">
                            <div class="form-text">Maks 5MB.</div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" {{ old('is_active', $hairStyle->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>

                        <button class="btn btn-primary w-100" type="submit">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
</div>
@endsection

