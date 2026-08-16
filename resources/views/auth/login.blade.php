@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="auth-split-wrap">
    <div class="auth-split-card">
        <div class="auth-split-form">
            <h2>Login</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <label>Email</label>
                <div class="auth-input-wrap">
                    <input type="email" name="email" placeholder="admin@iub.edu.pk" value="{{ old('email') }}" required autofocus>
                    <i class="fa-solid fa-envelope"></i>
                </div>

                <label>Password</label>
                <div class="auth-input-wrap">
                    <input type="password" name="password" placeholder="••••••••" required>
                    <i class="fa-solid fa-lock"></i>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>

                <button class="btn-auth" type="submit">Login</button>
            </form>

            <p class="text-center mt-4 mb-2 auth-footer-link">No account? <a href="{{ route('register') }}">Register as student</a></p>
            <p class="text-center mb-0 auth-note">Admins use the same login form — you'll be redirected to the admin dashboard automatically.</p>
        </div>

        <div class="auth-split-welcome">
            <h3>Welcome Back!</h3>
            <p>Enter your credentials to access your account and track your complaints.</p>
        </div>
    </div>
</div>
@endsection
