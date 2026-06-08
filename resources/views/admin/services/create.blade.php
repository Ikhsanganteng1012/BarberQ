@extends('layouts.admin')

@section('title', 'Tambah Layanan')

@section('content')
<h4 class="fw-bold mb-4">Tambah Layanan</h4>
<form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="row g-3" style="max-width:640px">
    @csrf
    <div class="col-12">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label">Harga (Rp)</label>
        <input type="number" step="0.01" min="0" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label">Durasi (menit)</label>
        <input type="number" min="1" name="duration" class="form-control @error('duration') is-invalid @enderror" value="{{ old('duration', 30) }}" required>
        @error('duration')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label">Gambar (opsional)</label>
        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12 form-check">
        <input type="hidden" name="is_active" value="0">
        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="a" checked>
        <label class="form-check-label" for="a">Aktif</label>
    </div>
    <div class="col-12">
        <button class="btn btn-primary" type="submit">Simpan</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.services.index') }}">Batal</a>
    </div>
</form>
@endsection
