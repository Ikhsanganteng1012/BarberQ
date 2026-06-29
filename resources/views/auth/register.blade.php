@extends('layouts.app')

@section('title', 'Register')

@section('styles')
<style>
    main { margin: 0; padding: 0; }
    footer { margin-top: 0 !important; }

    .login-wrapper {
        position: relative;
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        overflow: hidden;
        isolation: isolate;
    }

    .login-wrapper::before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(135deg, rgba(10,10,10,0.75) 0%, rgba(26,26,26,0.65) 50%, rgba(10,10,10,0.85) 100%),
            url('https://images.unsplash.com/photo-1599351431202-1e0f0137899a?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
        filter: blur(4px) saturate(1.1);
        transform: scale(1.08);
        z-index: -2;
    }

    .login-wrapper::after {
        content: "";
        position: absolute;
        inset: 0;
        background:
            radial-gradient(600px circle at 15% 20%, rgba(212,175,55,0.18), transparent 40%),
            radial-gradient(500px circle at 85% 80%, rgba(212,175,55,0.12), transparent 40%);
        z-index: -1;
        pointer-events: none;
    }

    .glass-card {
        width: 100%;
        max-width: 440px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 24px;
        padding: 2.75rem 2.25rem;
        backdrop-filter: blur(18px) saturate(160%);
        -webkit-backdrop-filter: blur(18px) saturate(160%);
        box-shadow:
            0 20px 60px rgba(0,0,0,0.45),
            inset 0 1px 0 rgba(255,255,255,0.15);
        color: #fff;
        animation: fadeUp .7s cubic-bezier(.2,.8,.2,1) both;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .brand-mark {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 64px; height: 64px;
        border-radius: 18px;
        background: linear-gradient(135deg, #d4af37, #b8891b);
        color: #111;
        font-size: 1.6rem;
        box-shadow: 0 10px 25px rgba(212,175,55,0.35);
        margin: 0 auto 1rem;
    }

    .login-title {
        font-size: 1.9rem;
        font-weight: 700;
        letter-spacing: .3px;
        text-align: center;
        margin-bottom: .35rem;
        color: #fff;
    }

    .login-subtitle {
        text-align: center;
        color: rgba(255,255,255,0.7);
        font-size: .95rem;
        margin-bottom: 2rem;
    }

    .login-subtitle .accent { color: #d4af37; font-weight: 600; }

    .field {
        position: relative;
        margin-bottom: 1.1rem;
    }

    .field .field-icon {
        position: absolute;
        top: 50%;
        left: 16px;
        transform: translateY(-50%);
        color: rgba(255,255,255,0.55);
        font-size: .95rem;
        pointer-events: none;
        transition: color .25s ease;
    }

    .field input {
        width: 100%;
        padding: 0.95rem 1rem 0.95rem 2.85rem;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 12px;
        color: #fff;
        font-size: .95rem;
        outline: none;
        transition: all .25s ease;
    }

    .field input::placeholder { color: rgba(255,255,255,0.45); }

    .field input:focus {
        border-color: #d4af37;
        background: rgba(255,255,255,0.1);
        box-shadow: 0 0 0 4px rgba(212,175,55,0.15);
    }

    .field input:focus + .field-icon,
    .field:focus-within .field-icon { color: #d4af37; }

    .btn-login {
        width: 100%;
        padding: 0.95rem 1rem;
        background: linear-gradient(135deg, #d4af37 0%, #f0c955 50%, #b8891b 100%);
        background-size: 200% 200%;
        color: #111;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: .4px;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 8px 22px rgba(212,175,55,0.3);
        transition: all .35s ease;
        margin-top: 0.5rem;
    }
    .btn-login:hover {
        background-position: 100% 0;
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(212,175,55,0.45);
    }

    .btn-google {
        width: 100%;
        padding: 0.9rem 1rem;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 12px;
        color: #fff;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .btn-google:hover {
        background: rgba(255,255,255,0.14);
        border-color: rgba(255,255,255,0.35);
        color: #fff;
        transform: translateY(-1px);
    }
    .btn-google img {
        width: 20px;
        height: 20px;
    }

    .divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 1.5rem 0 1.25rem;
        color: rgba(255,255,255,0.45);
        font-size: .8rem;
        letter-spacing: 1.5px;
    }
    .divider::before, .divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    }

    .footer-text {
        text-align: center;
        color: rgba(255,255,255,0.65);
        font-size: .9rem;
    }
    .footer-text a {
        color: #d4af37;
        text-decoration: none;
        font-weight: 600;
    }
    .footer-text a:hover { text-decoration: underline; }

    .err-box {
        background: rgba(220, 53, 69, 0.15);
        border: 1px solid rgba(220, 53, 69, 0.4);
        color: #ffb3b9;
        padding: .75rem 1rem;
        border-radius: 10px;
        margin-bottom: 1.25rem;
        font-size: .9rem;
    }

    @media (max-width: 480px) {
        .glass-card { padding: 2rem 1.4rem; border-radius: 20px; }
        .login-title { font-size: 1.6rem; }
    }
</style>
@endsection

@section('content')
<div class="login-wrapper">
    <div class="glass-card">
        <div class="text-center">
            <div class="brand-mark"><i class="fas fa-user-plus"></i></div>
        </div>

        <h2 class="login-title">Buat Akun</h2>
        <p class="login-subtitle">Daftar untuk akses <span class="accent">BarberShop</span></p>

        @if(session('error'))
            <div class="err-box">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="err-box">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <a href="{{ route('auth.google') }}" class="btn-google">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google">
            <span>Daftar dengan Google</span>
        </a>

        <div class="divider">ATAU</div>

        <form method="POST" action="{{ route('register.store') }}" autocomplete="on">
            @csrf

            <div class="field">
                <input type="text" name="name" id="name"
                       placeholder="Nama lengkap"
                       value="{{ old('name') }}" required>
                <i class="fas fa-user field-icon"></i>
            </div>

            <div class="field">
                <input type="email" name="email" id="email"
                       placeholder="Alamat email"
                       value="{{ old('email') }}" required>
                <i class="fas fa-envelope field-icon"></i>
            </div>

            <div class="field">
                <input type="password" name="password" id="password"
                       placeholder="Password (min. 8 karakter)" required>
                <i class="fas fa-lock field-icon"></i>
            </div>

            <div class="field">
                <input type="password" name="password_confirmation" id="password_confirmation"
                       placeholder="Konfirmasi password" required>
                <i class="fas fa-lock field-icon"></i>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-user-plus"></i>
                <span>Daftar Sekarang</span>
            </button>
        </form>

        <p class="footer-text" style="margin-top: 1.5rem;">
            Sudah punya akun? <a href="{{ route('login.index') }}">Masuk</a>
        </p>
    </div>
</div>
@endsection
