@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="login-wrapper">
    <div class="login-card">

        {{-- Left panel: IUB branding --}}
        <div class="login-left">
            <img src="{{ asset('images/iub-logo.png') }}"
                 onerror="this.onerror=null;this.src='';this.style.display='none';"
                 alt="IUB Logo" class="login-iub-logo">
            <h4>Welcome Back!</h4>
            <div class="login-divider"></div>
            <p>Enter your credentials to access your account and manage or track your complaints.</p>
            <span class="login-badge"><i class="fa-solid fa-shield-halved me-1"></i>Secure Portal</span>
        </div>

        {{-- Right panel: form --}}
        <div class="login-right">
            <h2>Login</h2>
            <p class="subtitle">Student Complaint Portal &mdash; IUB</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="scp-field-label">Email <span class="req">*</span></label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="yourroll@iub.edu.pk"
                           value="{{ old('email') }}" required autofocus>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="scp-field-label">Password <span class="req">*</span></label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••" required>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small text-muted" for="remember">Remember me</label>
                </div>

                <button class="btn-login" type="submit">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>Login
                </button>
            </form>

            <p class="text-center mt-4 mb-0 small">
                No account?
                <a href="{{ route('register') }}" style="color:var(--iub-navy);font-weight:700;">Register as Student</a>
            </p>

            <div class="admin-note">
                <i class="fa-solid fa-circle-info me-1"></i>
                Admins use the same login form — you'll be redirected to the admin dashboard automatically.
            </div>
        </div>
    </div>
</div>
@endsection
