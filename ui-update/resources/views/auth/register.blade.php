@extends('layouts.app')
@section('title', 'Register')

@section('content')
<h1 class="scp-page-header text-center">Create Account</h1>

<div class="scp-hero-panel justify-content-center">
    <div class="scp-hero-illustration">
        <div class="icon-wrap">
            <i class="fa-solid fa-user-plus"></i>
        </div>
        <h5>Student Registration</h5>
        <p>Create your account to start submitting complaints.</p>
    </div>

    <div class="scp-hero-form" style="flex: 0 1 460px;">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label class="scp-field-label">Full Name <span class="req">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="scp-field-label">Roll Number <span class="req">*</span></label>
                    <input type="text" name="roll_number" class="form-control" placeholder="S23BINFT1M01016" value="{{ old('roll_number') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="scp-field-label">Department</label>
                    <input type="text" name="department" class="form-control" placeholder="Information Technology" value="{{ old('department') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="scp-field-label">Email <span class="req">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="scp-field-label">Password <span class="req">*</span></label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="scp-field-label">Confirm Password <span class="req">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            <button class="btn-scp w-100 mt-2" type="submit">Register</button>
        </form>
        <p class="text-center mt-4 mb-0 small">Already have an account? <a href="{{ route('login') }}" style="color:var(--scp-purple-dark); font-weight:700;">Login</a></p>
    </div>
</div>
@endsection
