@extends('layouts.app')
@section('title', 'Login')

@section('content')
<h1 class="scp-page-header text-center">Login</h1>

<div class="scp-hero-panel justify-content-center">
    <div class="scp-hero-illustration">
        <div class="icon-wrap">
            <i class="fa-solid fa-right-to-bracket"></i>
        </div>
        <h5>Welcome Back</h5>
        <p>Log in to submit or track your complaints.</p>
    </div>

    <div class="scp-hero-form" style="flex: 0 1 380px;">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="scp-field-label">Email <span class="req">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label class="scp-field-label">Password <span class="req">*</span></label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label small text-muted" for="remember">Remember me</label>
            </div>
            <button class="btn-scp w-100" type="submit">Login</button>
        </form>
        <p class="text-center mt-4 mb-0 small">No account? <a href="{{ route('register') }}" style="color:var(--scp-purple-dark); font-weight:700;">Register as student</a></p>
    </div>
</div>
@endsection
