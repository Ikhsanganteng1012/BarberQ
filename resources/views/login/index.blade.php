@extends('layouts.app')

@section('title', 'Login')

@section('styles')
<style>
    /* Hilangkan margin-top default footer agar tampilan login bersih */
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

    /* Background image + blur */
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

    /* Glow accent blobs */
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

    .toggle-pass {
        position: absolute;
        top: 50%;
        right: 14px;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: rgba(255,255,255,0.55);
        cursor: pointer;
        padding: 6px;
        transition: color .2s ease;
    }
    .toggle-pass:hover { color: #d4af37; }

    .row-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: .25rem 0 1.5rem;
        font-size: .88rem;
    }

    .remember {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: rgba(255,255,255,0.75);
        cursor: pointer;
        user-select: none;
    }
    .remember input {
        appearance: none;
        width: 16px; height: 16px;
        border: 1.5px solid rgba(255,255,255,0.4);
        border-radius: 4px;
        background: transparent;
        display: grid;
        place-content: center;
        cursor: pointer;
        transition: all .2s ease;
    }
    .remember input:checked {
        background: #d4af37;
        border-color: #d4af37;
    }
    .remember input:checked::after {
        content: "✓";
        color: #111;
        font-size: 11px;
        font-weight: 800;
    }

    .forgot-link {
        color: #d4af37;
        text-decoration: none;
        font-weight: 500;
        transition: opacity .2s ease;
    }
    .forgot-link:hover { opacity: .8; color: #d4af37; text-decoration: underline; }

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
    }
    .btn-login:hover {
        background-position: 100% 0;
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(212,175,55,0.45);
    }
    .btn-login:active { transform: translateY(0); }

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
        display: flex;
        align-items: center;
        gap: 10px;
        animation: shake .4s ease;
    }
    @keyframes shake {
        0%,100% { transform: translateX(0); }
        25% { transform: translateX(-6px); }
        75% { transform: translateX(6px); }
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
            <div class="brand-mark"><i class="fas fa-cut"></i></div>
        </div>

        <h2 class="login-title">Selamat Datang</h2>
        <p class="login-subtitle">Masuk ke akun <span class="accent">BarberShop</span> Anda</p>

        @if(session('error'))
            <div class="err-box">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}" autocomplete="on">
            @csrf

            <div class="field">
                <input type="email" name="email" id="email"
                       placeholder="Masukkan email Anda"
                       value="{{ old('email') }}" required>
                <i class="fas fa-envelope field-icon"></i>
            </div>

            <div class="field">
                <input type="password" name="password" id="password"
                       placeholder="Masukkan password" required>
                <i class="fas fa-lock field-icon"></i>
                <button type="button" class="toggle-pass" onclick="togglePass()" aria-label="Tampilkan password">
                    <i class="fas fa-eye" id="togglePassIcon"></i>
                </button>
            </div>

            <div class="row-meta">
                <label class="remember">
                    <input type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </label>
                <a href="#" class="forgot-link">Lupa password?</a>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                <span>Masuk Sekarang</span>
            </button>
        </form>

        <div class="divider">ATAU</div>

        <p class="footer-text">
            Belum punya akun? <a href="{{ route('register.index') }}">Daftar</a>
        </p>
    </div>
</div>

<script>
    function togglePass() {
        const input = document.getElementById('password');
        const icon = document.getElementById('togglePassIcon');
        const isPass = input.type === 'password';
        input.type = isPass ? 'text' : 'password';
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }
</script>
@endsection
