@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-1">Buat Akun</h3>
                    <p class="text-muted mb-4">Daftar untuk melihat booking & konsultasi.</p>

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

                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" name="password" type="password" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100" type="submit">
                            Daftar
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <span class="text-muted">Sudah punya akun?</span>
                        <a href="{{ route('login.index') }}" class="fw-semibold text-decoration-none">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

