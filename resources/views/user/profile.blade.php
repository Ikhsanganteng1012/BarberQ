@extends('layouts.app')

@section('title', 'Kelola Akun')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4">
                <a href="{{ route('user.dashboard') }}" class="text-muted text-decoration-none small">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
                <h2 class="fw-bold mt-2 mb-1">Kelola Akun</h2>
                <p class="text-muted mb-0">Ubah nama, email, dan password Anda.</p>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <h5 class="fw-bold mb-3"><i class="fas fa-user me-2 text-warning"></i>Informasi Akun</h5>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama / Username</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-4">

                        <h5 class="fw-bold mb-3"><i class="fas fa-lock me-2 text-warning"></i>Ubah Password</h5>
                        <p class="text-muted small">Kosongkan jika tidak ingin mengubah password.</p>

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">Password Saat Ini</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password" name="current_password" autocomplete="current-password">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password Baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" autocomplete="new-password">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                   name="password_confirmation" autocomplete="new-password">
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
