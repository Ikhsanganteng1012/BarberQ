@extends('layouts.admin')

@section('title', 'Tambah Galeri')

@section('content')
<h4 class="fw-bold mb-4">Tambah Galeri</h4>
<form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="row g-3" style="max-width:640px">
    @csrf
    <div class="col-12">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">Gambar</label>
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 form-check">
        <input type="hidden" name="is_active" value="0">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="a" checked>
        <label class="form-check-label" for="a">Tampilkan di situs</label>
    </div>
    <div class="col-12">
        <button class="btn btn-primary" type="submit">Simpan</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.galleries.index') }}">Batal</a>
    </div>
</form>
@endsection
