@extends('layouts.app')
@section('title', 'Welcome')

@section('content')
<div class="hero-scp text-center mb-5">
    <h1 class="fw-bold">Students Complaint Portal</h1>
    <p class="lead mb-4">A web-based platform to submit, track, and resolve student complaints — quickly and transparently.</p>
    @auth
        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('complaints.create') }}" class="btn-scp" style="background:#fff; color:var(--scp-purple-dark);">
            {{ auth()->user()->isAdmin() ? 'Go to Dashboard' : 'Register Complaint' }}
        </a>
    @else
        <a href="{{ route('register') }}" class="btn-scp me-2" style="background:#fff; color:var(--scp-purple-dark);">Get Started</a>
        <a href="{{ route('complaints.track') }}" class="btn-scp-outline" style="background:transparent; color:#fff; border-color:rgba(255,255,255,.6);">Track a Complaint</a>
    @endauth
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card card-scp p-4 h-100">
            <i class="fa-solid fa-file-circle-plus fa-2x mb-2" style="color:var(--scp-purple)"></i>
            <h5>Easy Submission</h5>
            <p class="text-muted mb-0">Submit complaints with category, description, priority and optional attachment — anonymously if you prefer.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-scp p-4 h-100">
            <i class="fa-solid fa-magnifying-glass-chart fa-2x mb-2" style="color:var(--scp-purple)"></i>
            <h5>Real-Time Tracking</h5>
            <p class="text-muted mb-0">Every complaint gets a unique ID. Track its status — Pending, In Progress, Resolved, or Rejected.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-scp p-4 h-100">
            <i class="fa-solid fa-chart-simple fa-2x mb-2" style="color:var(--scp-purple)"></i>
            <h5>Accountable Admin</h5>
            <p class="text-muted mb-0">Administration reviews, assigns, and resolves complaints through a structured dashboard.</p>
        </div>
    </div>
</div>
@endsection
