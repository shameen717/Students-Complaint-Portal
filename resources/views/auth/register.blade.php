@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="auth-split-wrap">
    <div class="auth-split-card" style="min-height: 620px;">
        <div class="auth-split-form" style="flex-basis:62%; max-width:62%;">
            <h2>Create Account</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <label>Full Name</label>
                <div class="auth-input-wrap">
                    <input type="text" name="name" placeholder="Your full name" value="{{ old('name') }}" required autofocus>
                    <i class="fa-solid fa-user"></i>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label>Roll Number</label>
                        <div class="auth-input-wrap">
                            <input type="text" name="roll_number" placeholder="S23BINFT1M01016" value="{{ old('roll_number') }}" required>
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Department</label>
                        <div class="auth-input-wrap">
                            <input type="text" name="department" placeholder="Information Technology" value="{{ old('department') }}">
                            <i class="fa-solid fa-building-columns"></i>
                        </div>
                    </div>
                </div>

                <label>Email</label>
                <div class="auth-input-wrap">
                    <input type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required>
                    <i class="fa-solid fa-envelope"></i>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label>Password</label>
                        <div class="auth-input-wrap">
                            <input type="password" name="password" placeholder="••••••••" required>
                            <i class="fa-solid fa-lock"></i>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Confirm Password</label>
                        <div class="auth-input-wrap">
                            <input type="password" name="password_confirmation" placeholder="••••••••" required>
                            <i class="fa-solid fa-lock"></i>
                        </div>
                    </div>
                </div>

                <button class="btn-auth mt-2" type="submit">Register</button>
            </form>

            <p class="text-center mt-4 mb-0 auth-footer-link">Already have an account? <a href="{{ route('login') }}">Login</a></p>
        </div>

        <div class="auth-split-welcome" style="width:44%;">
            <h3>Join the Portal</h3>
            <p>Create your student account to submit and track complaints — anonymously if you prefer.</p>
        </div>
    </div>
</div>
@endsection
