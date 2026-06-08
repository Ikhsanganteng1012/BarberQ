@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('content')
<h4 class="fw-bold mb-4">Edit Galeri</h4>
<form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="row g-3" style="max-width:640px">
    @csrf
    @method('PUT')
    <div class="col-12">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $gallery->title) }}" required>
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description', $gallery->description) }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Ganti gambar (opsional)</label>
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="mt-2"><img src="{{ asset('storage/'.$gallery->image) }}" alt="" width="120" class="rounded"></div>
    </div>
    <div class="col-12 form-check">
        <input type="hidden" name="is_active" value="0">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="a" {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}>
        <label class="form-check-label" for="a">Tampilkan di situs</label>
    </div>
    <div class="col-12">
        <button class="btn btn-primary" type="submit">Perbarui</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.galleries.index') }}">Batal</a>
    </div>
</form>
@endsection
