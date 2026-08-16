<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Complaint Portal') | IUB</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-scp sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('images/iub-logo.png') }}" alt="IUB Logo" height="40">
            Student Complaint Portal
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.complaints.index') }}">Manage Complaints</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('complaints.create') }}">Register Complaint</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('complaints.index') }}">My Complaints</a></li>
                    @endif
                    <li class="nav-item"><a class="nav-link" href="{{ route('complaints.track') }}">Track Progress</a></li>
                    <li class="nav-item ms-lg-2">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn-scp-outline" type="submit" style="padding:.5rem 1.4rem;">
                                {{ Str::limit(auth()->user()->name, 14) }} — Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('complaints.create') }}">Register Complaint</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('complaints.track') }}">Track Progress</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item ms-lg-2"><a class="btn-scp" href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<main class="py-4">
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check"></i> {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Please fix the following:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

<footer class="footer-scp text-center py-3 mt-5">
    <small>&copy; {{ date('Y') }} The Islamia University of Bahawalpur — Department of Information Technology · Student Complaint Portal (FYP)</small>
</footer>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
@yield('scripts')
</body>
</html>
